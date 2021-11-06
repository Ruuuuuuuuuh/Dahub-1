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

        $rates = new Rate();
        $currency = new Currency();
        $mode = $this->getMode();
        if ($mode == 'lite') {
            $orders = Order::where('user_uid', Auth::user()->uid)->userOrders()->orderBy('id', 'DESC')->take(10)->get();
        }
        else {
            $orders['deposit'] = Order::where('status', 'created')->where('destination', 'deposit')->orderBy('id', 'DESC')->take(10)->get();
            $orders['withdraw'] = Order::where('status', 'created')->where('destination', 'withdraw')->orderBy('id', 'DESC')->take(10)->get();
            $orders['owned'] = Order::where('status', 'accepted')->where('gate', $user->uid)->orderBy('id', 'DESC')->take(10)->get();
        }
        return view('dashboard.index', compact('orders', 'rates', 'currency', 'mode'));

    }

    public function getOrder($id) {
        $user = Auth::user();
        $order = Order::findOrFail($id);
        if ($order->user_uid == $user->uid || $order->gate == $user->uid) {
            $mode = $this->getMode();
            if ($mode == 'lite') {
                return view('dashboard.pages.order', compact('order', 'mode'));
            }
            else {
                return view('dashboard.pages.gate.order', compact('order', 'mode'));
            }
        }
        else {
            return redirect('dashboard');
        }
    }

    public function getMode() {
        return UserConfig::firstOrCreate(
            ['user_uid' => Auth::user()->uid, 'meta' => 'mode'],
            ['value' => 'lite']
        )->value;
    }
}
