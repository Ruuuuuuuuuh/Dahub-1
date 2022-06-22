<?php

namespace App\Http\Controllers;

use App\Helpers\Rate;
use App\Models\Currency;
use App\Models\Order;
use App\Models\Payment;
use App\Models\System;
use App\Models\Tag;
use Bavix\Wallet\Models\Wallet;
use Bavix\Wallet\Services\WalletService;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Telegram\Bot\Api;
use Telegram\Bot\Laravel\Facades\Telegram;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $user = Auth::user();
        $system = System::find(1);
        $system->getWallet('TokenSale')->refreshBalance();
        $user->getWallet('DHB')->refreshBalance();
        $currencies = Currency::payableCurrencies();

        /**
         * Сколько токенов продано
         * @var float $balances
         */
        $balances = array();
        $balances['sold'] = $system->getSoldTokens();
        $balances['frozen'] = $system->getFrozenTokens();

        /**
         * Доступный баланс токен сейла
         * @var float $available
         */
        $available = $system->getWallet('TokenSale')->balanceFloat - $system->getFrozenTokens();

        /**
         * Баланс пользователя
         * @var float $userBalance
         */
        $userBalance = $user->getWallet('DHB')->balanceFloat;


        /**
         * Максимальное допустимое количество токенов для покупки
         * @var float $max
         */
        $max = 0;

        if ($system->amount_per_user != 0) {
            if ($system->amount_per_user > $userBalance) $max = $system->amount_per_user - $userBalance;
            else $max = 0;
        }
        else $max = $available;

        if ($max > 0) {
            if ($system->amount_per_order != 0) $max = min($system->amount_per_order, $max, $available);
            else $max = min($max, $available);
        }

        $startTokenSale = Carbon::parse($system->start_token_sale_date);
        $timeNow = Carbon::now();
        $stage = match (true) {
            $balances['sold'] <= 1000000 => 1,
            $balances['sold'] <= 1200000 => 2,
            $balances['sold'] <= 1400000 => 3,
            $balances['sold'] <= 1600000 => 4,
            $balances['sold'] <= 1800000 => 5,
            $balances['sold'] <= 2000000 => 6,
            default => 1,
        };
        return view('dashboard.index', compact('balances', 'system', 'max', 'startTokenSale', 'timeNow', 'currencies', 'stage'));
    }

    public function profile()
    {
        $system = System::find(1);
        $system->getWallet('TokenSale')->refreshBalance();
        $balances = $system->getSoldTokens() + $system->getFrozenTokens();
        return view('dashboard.pages.profile', compact('balances', 'system'));
    }

    public function orders()
    {
        $orders = Order::orderBy('id', 'DESC')->paginate(30);
        return view('dashboard.pages.admin.orders', compact('orders'));
    }

    // Этапы токен сейла
    public function stages()
    {
        $system = System::findOrFail(1);
        $system->getWallet('DHBFundWallet')->refreshBalance();
        return view('dashboard.pages.admin.stages', compact('system'));
    }

    // Пополнить HFT
    public function hft()
    {
        $system = System::findOrFail(1);
        if (!$system->getWallet('HFT')) {
            $system->createWallet(
                [
                    'name' => 'HFT',
                    'slug' => 'HFT',
                ]
            );
        }
        $system->getWallet('HFT')->refreshBalance();
        return view('dashboard.pages.admin.hft', compact('system'));
    }

    // Бухгалтерия

    /**
     * @return Application|Factory|View
     */
    public function reports(): View|Factory|Application
    {
        $system = System::findOrFail(1);
        $orders = Order::orderBy('id', 'DESC')->get();
        $wallet = new Wallet;
        $users = User::all();
        $tags = Tag::all();
        $route = Route::currentRouteName();
        $view = match ($route) {
            'dashboard.reports' => 'reports',
            'dashboard.reports.deposit' => 'deposit',
            'dashboard.reports.withdraw' => 'withdraw',
        };
        return view('dashboard.pages.admin.reports.'.$view, compact('system', 'orders', 'wallet', 'users', 'tags'));
    }

    public function explorer(Request $request)
    {
        $orders = Order::where('status', 'completed')->where('destination', 'TokenSale')->orderBy('id', 'DESC')->paginate(4);
        $ordersList = array();
        $i = 0;
        foreach ($orders as $order) {
            $ordersList[$i]['currency'] = $order->currency;
            $ordersList[$i]['amount'] = $order->amount;
            $ordersList[$i]['amount_dhb'] = $order->dhb_amount;
            $transaction = $order->orderSystemTransaction();
            $ordersList[$i]['date'] = $transaction->created_at->diffForHumans() . ', ' . $transaction->created_at->Format('H:s');
            $ordersList[$i]['uuid'] = $transaction->uuid;
            $i++;
        }
        if ($request->ajax()) {
            return json_encode($ordersList, JSON_FORCE_OBJECT | JSON_NUMERIC_CHECK);
        }
        return view('dashboard.pages.explorer')->with('transactions', $ordersList);
    }

    public function currencies() {
        $currencies = Currency::all();
        return view('dashboard.pages.admin.currencies')->with('currencies', $currencies);
    }

    public function currency($slug) {
        $currency = Currency::where('title', $slug)->first();
        $system = System::firstOrFail();
        if (!$system->hasWallet($slug)) {
            $system->createWallet(
                [
                    'name' => $currency->subtitle,
                    'slug' => $slug,
                    'decimal_places' => $currency->decimal_places
                ]
            );
        }
        return view('dashboard.pages.admin.currency')->with('currency', $currency);
    }

    public function updateCurrency($slug, Request $request) {
        $currency = Currency::where('title', $slug)->first();
        $currency->title = $request->input('title');
        $currency->subtitle = $request->input('subtitle');
        $currency->icon = $request->input('icon');
        $currency->decimal_places = $request->input('decimal_places');
        $currency->visible = $request->input('visible');
        $currency->save();
        return true;
    }

    public function payments() {
        $payments = Payment::all();
        return view('dashboard.pages.admin.payments')->with('payments', $payments);
    }

    public function getUsers() {
        $users = User::all();
        return view('dashboard.pages.admin.users')->with('users', $users);
    }

    public function transfer() {
        return view('dashboard.pages.transfer');
    }

    public function order($id) {
        $order = Order::where('id', $id)->firstOrFail();
        if (Auth::user()->uid == $order->user_uid) return view('dashboard.pages.order')->with('order', $order);
        else abort(404);
    }

    public function gates() {
        $gates = User::getGates()->get();
        return view('dashboard.pages.admin.gates')->with('gates', $gates);
    }

    public function tags() {
        $tags = Tag::all();
        return view('dashboard.pages.admin.tags')->with('tags', $tags);
    }

    public function telegram() {
        return view('dashboard.pages.admin.telegram');
    }

    /**
     * Страница настроек
     * @return Application|Factory|View
     */
    public function settings(): View|Factory|Application
    {
        $system = System::firstOrFail();
        return view('dashboard.pages.admin.settings')->with('system', $system);;
    }
}
