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
use Telegram\Bot\Api;
use Telegram\Bot\Laravel\Facades\Telegram;

class DashboardController extends Controller {

    /**
     *
     * Экземпляр класса авторизованного пользователь
     * @var Auth::user()
     */
    protected $user;

    /**
     *
     * Экземпляр класса курса валют
     * @var Rate
     */
    protected $rates;

    /**
     *
     * Экземпляр класса валют
     * @var Currency
     */
    protected $currency;


    /**
     * Режим кошелька (Pro | Lite)
     * @var string
     */
    protected $mode;

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
            $this->rates = new Rate();
            $this->currency = new Currency();
            $this->mode = $this->getMode();
            return $next($request);

        });
    }

    /**
     * Show the application dashboard.
     *
     */
    public function index()
    {
        $visibleWallets = $this->getVisibleWallets();
        if ($this->mode == 'pro' && !$this->user->isGate()) {
            $this->user->switchMode('lite');
        }
        if ($this->mode == 'pro' && $this->user->isGate()) {
            $orders['deposit'] = Order::where('status', 'created')->whereIn('destination', ['TokenSale', 'deposit'])->orderBy('id', 'DESC')->get();
            $orders['withdraw'] = Order::where('status', 'created')->where('destination', 'withdraw')->orderBy('id', 'DESC')->get();
            $orders['owned'] = Order::where('gate', $this->user->uid)->where('status', '!=', 'completed')->orderBy('id', 'DESC')->get();
        }
        else {
            $orders = Order::where('user_uid', $this->user->uid)->orderBy('id', 'DESC')->take(10)->get();
        }
        foreach ($this->currency::all() as $item) {
            $this->user->getBalance($item->title);
        }
        return view('dashboard.index', compact('orders', 'visibleWallets'))->with(
            array(
                'user'      => $this->user,
                'mode'      => $this->mode,
                'currency'  => $this->currency,
                'rates'     => $this->rates
            )
        );

    }


    public function settings()
    {
        $currency = new Currency();
        $visibleWallets = $this->getVisibleWallets();

        return view('dashboard.pages.settings', compact('currency', 'visibleWallets'))->with(
            array(
                'user'      => $this->user,
                'mode'      => $this->mode,
                'currency'  => $this->currency,
                'rates'     => $this->rates
            )
        );

    }


    public function systemConfigPage()
    {

    }

    public function getOrder($id) {
        $order = Order::findOrFail($id);
        $ordersTimer = System::findOrFail(1)->orders_timer;
        if ($order->user_uid == $this->user->uid || $order->gate == $this->user->uid) {
            $dt = Carbon::now();
            $seconds_left = $dt->diffInSeconds($order->created_at);
            if ($this->mode == 'lite') {
                return view('dashboard.pages.order', compact('order','seconds_left', 'ordersTimer'))->with(
                    array(
                        'user'      => $this->user,
                        'mode'      => $this->mode,
                        'currency'  => $this->currency,
                        'rates'     => $this->rates
                    )
                );
            }
            else {
                return view('dashboard.pages.gate.order', compact('order', 'seconds_left', 'ordersTimer'))->with(
                    array(
                        'user'      => $this->user,
                        'mode'      => $this->mode,
                        'currency'  => $this->currency,
                        'rates'     => $this->rates
                    )
                );
            }
        }
        else {
            return redirect('wallet');
        }
    }

    public function acceptOrderPage($id) {
        $order = Order::findOrFail($id);
        $ordersTimer = System::findOrFail(1)->orders_timer;
        if ($this->user->isGate()) {
            if ($order->status == 'created') {
                $this->user->getBalance($order->currency);
                $this->user->switchMode('pro');
                $dt = Carbon::now();
                $seconds_left = $dt->diffInSeconds($order->created_at);
                $order = Order::findOrFail($id);
                return view('dashboard.pages.gate.order', compact('order', 'seconds_left', 'ordersTimer'))->with(
                    array(
                        'user'      => $this->user,
                        'mode'      => $this->mode,
                        'currency'  => $this->currency,
                        'rates'     => $this->rates
                    )
                );
            }
            else abort(404);
        }
        else abort(404);
    }

    public function getVisibleWallets() {
        return json_decode(UserConfig::firstOrCreate(
            ['user_uid' => $this->user->uid, 'meta' => 'visible_wallets'],
            ['value' => json_encode(['DHB', 'BTC', 'ETH'])]
        )->value, true);
    }

    /**
     * Show the test application dashboard.
     *
     */
    public function testPage()
    {
        $currency = new Currency();
        $visibleWallets = $this->getVisibleWallets();
        if ($this->mode == 'pro' && !$this->user->isGate()) {
            $this->user->switchMode('lite');
        }
        if ($this->mode == 'pro' && $this->user->isGate()) {
            $orders['deposit'] = Order::where('status', 'created')->whereIn('destination', ['TokenSale', 'deposit'])->orderBy('id', 'DESC')->get();
            $orders['withdraw'] = Order::where('status', 'created')->where('destination', 'withdraw')->orderBy('id', 'DESC')->get();
            $orders['owned'] = Order::where('status', 'accepted')->where('gate', $this->user->uid)->orderBy('id', 'DESC')->get();
        }
        else {
            $orders = Order::where('user_uid', $this->user->uid)->orderBy('id', 'DESC')->take(10)->get();
        }
        foreach ($currency::all() as $item) {
            $this->user->getBalance($item->title);
        }
        return view('dashboard.test', compact('orders', 'currency', 'visibleWallets'))->with(
            array(
                'user'      => $this->user,
                'mode'      => $this->mode,
                'currency'  => $this->currency,
                'rates'     => $this->rates
            )
        );

    }

    /**
     * Возвращает режим кошелька (Pro | Lite)
     * @return mixed
     */
    public function getMode() {
        return UserConfig::firstOrCreate(
            ['user_uid' => $this->user->uid, 'meta' => 'mode'],
            ['value' => 'lite']
        )->value;
    }
}
