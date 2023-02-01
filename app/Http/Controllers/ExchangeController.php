<?php

namespace App\Http\Controllers;

use App\Helpers\Rate;
use App\Models\Currency;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ExchangeController extends WalletController
{
    /**
     * Main Exchange P2P page
     *
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {
        $visibleWallets = $this->getVisibleWallets();

        if ($this->mode == 'pro') {
            $this->user->switchMode('lite');
        }

        return view('wallet.exchange.index')->with(
            array(
                'user'           => $this->user,
                'mode'           => $this->mode,
                'rates'          => $this->rates,
                'currency'       => $this->currency,
                'visibleWallets' => $visibleWallets
            )
        );
    }
}
