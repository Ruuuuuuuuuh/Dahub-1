<?php

namespace App\Http\Controllers;

use App\Helpers\Rate;
use App\Models\Currency;
use App\Models\Order;
use App\Models\Payment;
use App\Models\System;
use App\Models\UserConfig;
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
        $user = Auth::user();
        if (!$user->getWallet('RUB')) {
            $user->createWallet(
                [
                    'name' => 'RUB',
                    'slug' => 'RUB',
                ]
            );
        }
        if (!$user->getWallet('USD')) {
            $user->createWallet(
                [
                    'name' => 'USD',
                    'slug' => 'USD',
                ]
            );
        }

        $orders = Order::where('user_uid', Auth::user()->uid)->userOrders()->orderBy('id', 'DESC')->take(5)->get();
        $rates = new Rate();
        $currency = new Currency();
        $mode = $this->getMode();
        return view('dashboard.index', compact('orders', 'rates', 'currency', 'mode'));
    }

    public function getOrder($id) {
        $order = Order::findOrFail($id);
        $mode = $this->getMode();
        return view('dashboard.order', compact('order', 'mode'));
    }

    public function getMode() {
        return UserConfig::firstOrCreate(
            ['user_uid' => Auth::user()->uid, 'meta' => 'mode'],
            ['value' => 'lite']
        )->value;
    }
}
