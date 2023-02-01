<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Order;
use App\Models\System;
use Illuminate\Http\Request;
use App\Models\User;

class SiteController extends Controller
{

    /**
     * Landing page
     *
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
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

        $system = System::find(1);
        $system->getWallet('TokenSale')->refreshBalance();
        $balance = $system->getWallet('TokenSale')->balanceFloat;
        $currencies = Currency::payableCurrencies()->get();

        return view('site.landing')->with([
            'currencies'    => $currencies,
            'balance'       => $balance,
            'system'        => $system
        ])->with('transactions', $ordersList);
    }
}
