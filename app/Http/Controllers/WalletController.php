<?php

namespace App\Http\Controllers;

use App\Helpers\Rate;
use App\Models\Currency;
use App\Models\Order;
use App\Models\Payment;
use App\Models\System;
use Bavix\Wallet\Models\Wallet;
use Bavix\Wallet\Services\WalletService;
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $system = System::find(1);
        $system->getWallet('TokenSale')->refreshBalance();
        $balances = $system->getSoldTokens() + $system->getFrozenTokens();
        return view('wallet.index', compact('balances', 'system'));
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
        $orders = Order::orderBy('id', 'DESC')->get();
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
        $orders = Order::where('status', 'completed')->orderBy('id', 'DESC')->paginate(4);
        $ordersList = array();
        $i = 0;
        foreach ($orders as $order) {
            $ordersList[$i]['currency'] = $order->currency;
            $ordersList[$i]['amount'] = $order->amount;
            $ordersList[$i]['amount'] = $order->amount;
            $transactions = $order->transactions();
            foreach ($transactions as $transaction) {
                if ($transaction->payable_type == 'App\Models\System') {
                    $ordersList[$i]['amountSource'] = $transaction->amount / 10 ** $transaction->wallet->decimal_places;
                    $ordersList[$i]['date'] = $transaction->created_at->diffForHumans() . ', ' . $transaction->created_at->Format('H:s');
                }
                else {
                    $ordersList[$i]['uuid'] = $transaction->uuid;
                }
            }
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

    public function payments() {
        $payments = Payment::all();
        return view('wallet.pages.payments')->with('payments', $payments);
    }
}
