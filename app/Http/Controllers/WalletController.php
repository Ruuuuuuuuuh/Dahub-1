<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\System;
use Illuminate\Http\Request;
use App\Models\User;

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
        $balances = $system->getSoldTokens() + $system->getFrozenTokens();
        return view('wallet.index', compact('balances', 'system'));
    }

    public function orders()
    {
        $orders = Order::where('status', 'assignee')->orderBy('id', 'DESC')->get();
        return view('wallet.pages.orders', compact('orders'));
    }

    // Этапы токен сейла
    public function stages()
    {
        $system = System::findOrFail(1);
        $system->getWallet('DHB')->refreshBalance();
        return view('wallet.pages.stages', compact('system'));
    }
}
