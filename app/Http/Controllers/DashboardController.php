<?php

namespace App\Http\Controllers;

use App\Helpers\Rate;
use App\Models\Order;
use App\Models\System;
use Bavix\Wallet\Models\Wallet;
use Bavix\Wallet\Services\WalletService;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Laravel\Facades\Telegram;

class DashboardController extends Controller {
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
        $orders = Order::where('user_uid', Auth::user()->uid)->userOrders()->get();
        $rates = new Rate();
        return view('dashboard.index', compact('orders', 'rates'));
    }
}
