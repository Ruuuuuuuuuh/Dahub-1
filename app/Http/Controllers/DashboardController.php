<?php

namespace App\Http\Controllers;

use App\Helpers\Rate;
use App\Models\Currency;
use App\Models\Gate;
use App\Models\Order;
use App\Models\Payment;
use App\Models\System;
use App\Models\UserConfig;
use Bavix\Wallet\Models\Wallet;
use Bavix\Wallet\Services\WalletService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Laravel\Facades\Telegram;

class DashboardController extends Controller {

    /**
     *
     * Экземпляр класса авторизованного пользователь
     * @var Auth::user()
     */
    protected $user;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {

            $this->user = Auth::user();

            return $next($request);
        });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = $this->user;
        $rates = new Rate();
        $currency = new Currency();
        $mode = $this->getMode();
        $visibleWallets = $this->getVisibleWallets();
        if ($mode == 'pro' && !$this->user->isGate()) {
            $this->user->switchMode('lite');
        }
        if ($mode == 'pro' && $this->user->isGate()) {
            $orders['deposit'] = Order::where('status', 'created')->whereIn('destination', ['TokenSale', 'deposit'])->orderBy('id', 'DESC')->get();
            $orders['withdraw'] = Order::where('status', 'created')->where('destination', 'withdraw')->orderBy('id', 'DESC')->get();
            $orders['owned'] = Order::where('status', 'accepted')->where('gate', $user->uid)->orderBy('id', 'DESC')->get();
        }
        else {
            $orders = Order::where('user_uid', $this->user->uid)->userOrders()->orderBy('id', 'DESC')->take(10)->get();
        }
        foreach ($currency::all() as $item) {
            $this->user->getBalance($item->title);
        }
        return view('dashboard.index', compact('orders', 'user', 'rates', 'currency', 'mode', 'visibleWallets'));

    }

    public function settings()
    {
        $user = $this->user;
        $currency = new Currency();
        $mode = $this->getMode();
        $visibleWallets = $this->getVisibleWallets();

        return view('dashboard.pages.settings', compact('user', 'currency', 'mode', 'visibleWallets'));

    }


    public function systemConfigPage()
    {
        $user = $this->user;
        $currency = new Currency();
        $wallets = $user->wallets()->get();

        return view('dashboard.pages.systemconfigpage', compact('user', 'currency', 'wallets'));

    }

    public function getOrder($id) {
        $user = $this->user;
        $order = Order::findOrFail($id);
        if ($order->user_uid == $user->uid || $order->gate == $user->uid) {
            $mode = $this->getMode();
            $dt = Carbon::now();
            $seconds_left = $dt->diffInSeconds($order->created_at);
            if ($mode == 'lite') {
                return view('dashboard.pages.order', compact('order', 'mode', 'seconds_left'));
            }
            else {
                return view('dashboard.pages.gate.order', compact('order', 'mode', 'seconds_left'));
            }
        }
        else {
            return redirect('dashboard');
        }
    }

    public function acceptOrderPage($id) {
        if ($this->user->isGate()) {
            $order = Order::findOrFail($id);
            $this->user->getBalance($order->currency);
            $this->user->switchMode('pro');
            $mode = $this->getMode();
            $dt = Carbon::now();
            $seconds_left = $dt->diffInSeconds($order->created_at);
            $order = Order::findOrFail($id);
            return view('dashboard.pages.gate.order', compact('order', 'mode', 'seconds_left'));
        }
        else abort(404);
    }


    public function getMode() {
        return UserConfig::firstOrCreate(
            ['user_uid' => $this->user->uid, 'meta' => 'mode'],
            ['value' => 'lite']
        )->value;
    }

    public function getVisibleWallets() {
        return json_decode(UserConfig::firstOrCreate(
            ['user_uid' => $this->user->uid, 'meta' => 'visible_wallets'],
            ['value' => json_encode(['DHB', 'BTC', 'ETH'])]
        )->value, true);
    }
}
