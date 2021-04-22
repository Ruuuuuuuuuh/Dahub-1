<?php

namespace App\Http\Controllers;

use App\Helpers\Rate;
use App\Models\System;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function deposit(Request $request)
    {
        $uid = $request->input('uid');
        $amount = $request->input('amount');
        $user = User::where('uid', $uid)->first();
        $user->getWallet('DHB')->deposit($amount);
        return $user->getWallet('DHB')->balance;
    }

    public function createOrder(Request $request)
    {
        $user = User::where('uid', $request->input('user_uid'))->first();
        $system = System::find(1);

        $headers = array (
            'Content-Type' => 'application/json; charset=UTF-8',
            'charset' => 'utf-8'
        );

        if ($request->input('amount') <= $system->getFreeTokens() && $request->input('amount') < 333333)
            if (!empty($user->orders()->notCompleted()->get())) {
                $order = Order::create([
                    'user_uid'       => $request->input('user_uid'),
                    'destination'    => $request->input('destination'),
                    'currency'       => $request->input('currency'),
                    'amount'         => $request->input('amount'),
                    'rate'           => Rate::getRates($request->input('currency')),
                    'status'         => 'created',
                ]);
                $order->save();
                return $order->id;
            }
            else {
                return response(['error'=> true, 'error-msg' => 'У вас уже есть активная заявка'],404, $headers, JSON_UNESCAPED_UNICODE);
            }
        else {
            return response(['error'=> true, 'error-msg' => 'Не достаточно токенов для получения'],404, $headers, JSON_UNESCAPED_UNICODE);
        }

    }

    public function assigneeOrder($id)
    {
        $order = Order::find($id);
        $order->status = 'assignee';
        $order->save();
        return $order->id;
    }


    public function confirmOrder($id)
    {
        $order = Order::find($id);
        $order->status = 'completed';


        $systemWallet = System::findOrFail(1);
        if ($systemWallet->getWallet('DHB')->balance >= $order->amount) {

            //deposit to user wallet
            $user = User::where('uid', $order->user_uid)->first();
            $user->getWallet('DHB')->deposit($order->amount);

            //withdraw from system wallet
            $systemWallet->getWallet('DHB')->withdraw($order->amount);

            //deposit to system wallet
            $systemWallet->getWallet($order->currency)->deposit($order->amount / $order->rate);
            $order->save();
            return $order->id;
        }
        else {

            $headers = array (
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            );

            return response(['error'=>true, 'error-msg' => 'Баланс системы меньше запрашиваемой суммы'], 404, $headers, JSON_UNESCAPED_UNICODE);
        }
    }


    public function declineOrder($id)
    {
        $order = Order::find($id);
        $order->forceDelete();
        return $order->id;
    }


    public function startTokenSale(Request $request)
    {
        $system = System::findOrFail(1);
        $system->getWallet('DHB')->deposit('2000000');
        $system->rate = 0.05;
        $system->stage = 1;
        $system->save();
        return true;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function withdraw(Request $request)
    {
        $uid = $request->input('uid');
        $amount = $request->input('amount');

        return $user->getWallet('DHB')->balance;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
