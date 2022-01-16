<?php

namespace App\Http\Controllers;

use App\Helpers\Rate;
use App\Models\Currency;
use App\Models\Order;
use App\Models\Payment;
use App\Models\System;
use Bavix\Wallet\Models\Wallet;
use Bavix\Wallet\Services\WalletService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Laravel\Facades\Telegram;

class WalletController extends Controller
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

        /**
         * Сколько токенов продано
         * @var float $balances
         */
        $balances = $system->getSoldTokens() + $system->getFrozenTokens();

        /**
         * Доступный баланс токен сейла
         * @var float $available
         */
        $available = $system->getWallet('TokenSale')->balanceFloat;


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

        return view('wallet.index', compact('balances', 'system', 'max'));
    }

    public function profile()
    {
        $system = System::find(1);
        $system->getWallet('TokenSale')->refreshBalance();
        $balances = $system->getSoldTokens() + $system->getFrozenTokens();
        return view('wallet.profile', compact('balances', 'system'));
    }

    public function orders()
    {
        $orders = Order::where('destination','TokenSale')->orderBy('id', 'DESC')->get();
        return view('wallet.pages.orders', compact('orders'));
    }

    // Этапы токен сейла
    public function stages()
    {
        $system = System::findOrFail(1);
        $system->getWallet('DHBFundWallet')->refreshBalance();
        return view('wallet.pages.stages', compact('system'));
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
        return view('wallet.pages.hft', compact('system'));
    }

    // Бухгалтерия
    public function reports()
    {
        $system = System::findOrFail(1);
        $system->getWallet('DHBFundWallet')->refreshBalance();
        $system->getWallet('TokenSale')->refreshBalance();
        $system->getWallet('USDT')->refreshBalance();
        $system->getWallet('BTC')->refreshBalance();
        $system->getWallet('ETH')->refreshBalance();
        if (!$system->getWallet('HFT')) {
            $system->createWallet(
                [
                    'name' => 'HFT',
                    'slug' => 'HFT',
                ]
            );
        }
        $system->getWallet('HFT')->refreshBalance();
        $orders = Order::orderBy('id', 'DESC')->get();
        $wallet = new Wallet;
        $users = User::all();
        return view('wallet.pages.reports', compact('system', 'orders', 'wallet', 'users'));
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
        return view('wallet.pages.explorer')->with('transactions', $ordersList);
    }

    public function currencies() {
        $currencies = Currency::all();
        return view('wallet.pages.currencies')->with('currencies', $currencies);
    }

    public function currency($slug) {
        $currency = Currency::where('title', $slug)->first();
        return view('wallet.pages.currency')->with('currency', $currency);
    }

    public function updateCurrency($slug, Request $request) {
        $currency = Currency::where('title', $slug)->first();
        $currency->title = $request->input('title');
        $currency->subtitle = $request->input('subtitle');
        $currency->icon = $request->input('icon');
        $currency->decimal_places = $request->input('decimal_places');
        $currency->save();
        return true;
    }

    public function payments() {
        $payments = Payment::all();
        return view('wallet.pages.payments')->with('payments', $payments);
    }

    public function getUsers() {
        $users = User::all();
        return view('wallet.pages.users')->with('users', $users);
    }

    public function transfer() {
        return view('wallet.pages.transfer');
    }

    public function order($id) {
        $order = Order::where('id', $id)->firstOrFail();
        if (Auth::user()->uid == $order->user_uid) return view('wallet.pages.order')->with('order', $order);
        else abort(404);
    }
}
