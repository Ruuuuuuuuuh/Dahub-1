<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\System;
use Bavix\Wallet\Models\Wallet;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

    // Бухгалтерия
    public function reports()
    {
        $system = System::findOrFail(1);
        $system->getWallet('DHBFundWallet')->refreshBalance();
        $system->getWallet('TokenSale')->refreshBalance();
        $system->getWallet('USDT')->refreshBalance();
        $system->getWallet('BTC')->refreshBalance();
        $system->getWallet('ETH')->refreshBalance();
        $orders = Order::orderBy('id', 'DESC')->get();
        $wallet = new Wallet;
        $users = User::all();
        return view('wallet.pages.reports', compact('system', 'orders', 'wallet', 'users'));
    }
}
