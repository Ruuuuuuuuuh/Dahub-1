
@extends('wallet.layouts.app')

@section('content')
    <div class="container-fluid admin-orders">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="inline-block mb-0">Бухгалтерия</p>
                            <div class="d-flex justify-content-end">
                                <a class="btn btn-primary" href="/wallet/" >Вернуться назад</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <h2 class="mb-5">Отчеты</h2>
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-deposit-tab" data-toggle="pill" href="#pills-deposit" role="tab" aria-controls="pills-deposit" aria-selected="true">Получение</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-withdraw-tab" data-toggle="pill" href="#pills-withdraw" role="tab" aria-controls="pills-withdraw" aria-selected="false">Отправка</a>
                            </li>
                            <li class="nav-item button-withdraw" data-toggle="modal" data-target="#modal-withdraw">
                                <a class="nav-link btn btn-danger">Вывести</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-deposit" role="tabpanel" aria-labelledby="pills-deposit-tab">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <td>Дата</td>
                                        <td>Номер транзакции</td>
                                        <td>Сумма</td>
                                        <td>Токен</td>
                                        <td>Назначение</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($system->getTransactions('deposit')->get() as $order)
                                        @if ($wallet::where('id', $order->wallet_id)->first()->slug != 'DHB')
                                        <tr>
                                            <td>
                                                {{ $order->created_at->Format('d.m.Y H:s') }}
                                            </td>
                                            <td>
                                                {{$order->uuid}}
                                            </td>
                                            <td>

                                                {{ ($order->amount / 10 ** $wallet::where('id', $order->wallet_id)->first()->decimal_places)  }}
                                            </td>
                                            <td>
                                                {{ $wallet::where('id', $order->wallet_id)->first()->slug}}
                                            </td>
                                            <td>
                                                {{ $order->meta['destination'] ?? '--' }}
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="pills-withdraw" role="tabpanel" aria-labelledby="pills-withdraw-tab">

                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <td>Дата</td>
                                        <td>Номер транзакции</td>
                                        <td>Сумма</td>
                                        <td>Токен</td>
                                        <td>Назначение</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($system->getTransactions('withdraw')->get() as $order)
                                        @if ($wallet::where('id', $order->wallet_id)->first()->slug != 'DHB')
                                        <tr>
                                            <td>
                                                {{ $order->created_at->Format('d.m.Y H:s') }}
                                            </td>
                                            <td>
                                                {{$order->uuid}}
                                            </td>
                                            <td>

                                                {{ abs(($order->amount / 10 ** $wallet::where('id', $order->wallet_id)->first()->decimal_places)) }}
                                            </td>
                                            <td>
                                                {{ $wallet::where('id', $order->wallet_id)->first()->slug}}
                                            </td>
                                            <td>
                                                {{ $order->meta['destination'] ?? '--' }}
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
<hr />
                        <h2 class="mb-3">Балансы системного кошелька</h2>
                        <h4>{{$system->getWallet('DHB')->balanceFloat}} DHB</h4>
                        <h4>{{$system->getWallet('USDT')->balanceFloat}} USDT</h4>
                        <h4>{{$system->getWallet('BTC')->balanceFloat}} BTC</h4>
                        <h4>{{$system->getWallet('ETH')->balanceFloat}} ETH</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal-withdraw" tabindex="-1" role="dialog" aria-labelledby="modal-withdraw" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Вывод средств с системного кошелька</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="/api/withdraw" id="withdraw-payment">
                        <div class="form-group">
                            <label for="currency">Валюта</label>
                            <select class="form-control" name="currency">
                                <option value="USDT">{{$system->getWallet('USDT')->balanceFloat}} USDT</option>
                                <option value="BTC">{{$system->getWallet('BTC')->balanceFloat}} BTC</option>
                                <option value="ETH">{{$system->getWallet('ETH')->balanceFloat}} ETH</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="amount">Сумма</label>
                            <input type="text" class="form-control" name="amount" placeholder="Введите сумму">
                        </div>
                        <div class="form-group">
                            <label for="destination">Назначение</label>
                            <input type="text" class="form-control" name="destination" placeholder="Введите назначение платежа (коротко)">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="button" onclick="withdrawPayment();" class="btn btn-primary">Вывести</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function withdrawPayment() {
            let currency = $('#withdraw-payment select[name="currency"]').val();
            let amount = $('#withdraw-payment input[name="amount"]').val();
            let destination = $('#withdraw-payment input[name="destination"]').val();
            let _token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "/api/withdraw-payment",
                type:"POST",
                data:{
                    _token: _token,
                    currency: currency,
                    amount: amount,
                    destination: destination,
                },
                success:function(response){
                    alert('Вывод средств успешно совершен')
                    window.location.href = '/wallet/reports/';
                },
            });
        }
    </script>
@endsection
