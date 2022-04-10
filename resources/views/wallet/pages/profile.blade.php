@extends('wallet.layouts.app')

@section('content')
    <div class="container-fluid admin-orders">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card main-screen">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="inline-block mb-0">Профиль</p>
                            <div class="d-flex justify-content-end">
                                <a class="btn btn-primary" href="/dashboard/" >Вернуться назад</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h3 class="mb-5">ID Пользователя: {{Auth::User()->uid}}</h3>
                        <p class="wallet-number">Номер кошелька: <strong>0x{{ md5(Auth::User()->getWallet('DHB')->id) }}</strong></p>
                        <p>Баланс: <strong>{{Auth::User()->getWallet('DHB')->balanceFloat}} DHB</strong></p>
                        <hr />
                        <p class="wallet-number">Номер кошелька: <strong>0x{{ md5(Auth::User()->getWallet('ETH')->id) }}</strong></p>
                        <p>Баланс: <strong>{{Auth::User()->getWallet('ETH')->balanceFloat}} ETH</strong></p>
                        <hr />
                        <p class="wallet-number">Номер кошелька: <strong>0x{{ md5(Auth::User()->getWallet('BTC')->id) }}</strong></p>
                        <p>Баланс: <strong>{{Auth::User()->getWallet('BTC')->balanceFloat}} BTC</strong></p>
                        <hr />
                        <p class="wallet-number">Номер кошелька: <strong>0x{{ md5(Auth::User()->getWallet('USDT')->id) }}</strong></p>
                        <p>Баланс: <strong>{{Auth::User()->getWallet('USDT')->balanceFloat}} USDT</strong></p>
                        @if (Auth::User()->getWallet('HFT'))
                            <hr />
                            <p class="wallet-number">Номер кошелька: <strong>0x{{ md5(Auth::User()->getWallet('HFT')->id) }}</strong></p>
                            <p>Баланс: <strong>{{Auth::User()->getWallet('HFT')->balanceFloat}} HFT</strong></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection
