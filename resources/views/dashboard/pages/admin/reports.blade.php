@extends('dashboard.layouts.app')
@section('css')
    <link rel="stylesheet" href="/css/bootstrap-tagsinput.css">
    <style>
        .label {
            display: inline;
            padding: .2em .6em .3em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25em;
        }
        select option {
            line-height: 24px!important;
            min-height: 24px;
            max-height: 24px;
            padding: 8px 0;
        }
        select {
            padding-top:4px;
        }
        .label-info {
            background-color: #5bc0de;
        }

        .bootstrap-tagsinput {
            width: 100%;
            height: 37px;
            padding-top: 5px;
            display: table;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid admin-orders">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="inline-block mb-0">Бухгалтерия</p>
                            <div class="d-flex justify-content-end">
                                <a class="btn btn-primary" href="/dashboard/">Вернуться назад</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <h2 class="mb-5">Отчеты</h2>
                        <ul class="nav mb-3">
                            <li class="nav-item">
                                <a class="nav-link active" href="{{Route('dashboard.reports.deposit')}}">Получение</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="{{Route('dashboard.reports.withdraw')}}">Отправление</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{Route('dashboard.reports.balances')}}">Балансы системы</a>
                            </li>
                            <li class="nav-item button-send" data-toggle="modal" data-target="#modal-send">
                                <a class="nav-link btn btn-success">Перевести</a>
                            </li>
                        </ul>
                        <div class="content">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <td>Номер заявки</td>
                                        <td>Дата</td>
                                        <td>Номер транзакции</td>
                                        <td>Сумма</td>
                                        <td>Кошелек</td>
                                        <td>Назначение</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($system->getTransactions('deposit')->whereNotIn('wallet_id', [1, 2])->limit(30)->orderBy('id', 'DESC')->get() as $order)
                                        <tr>
                                            <td>
                                                {{ $order->meta['order_id'] ?? '--'  }}
                                            </td>
                                            <td>
                                                {{ $order->created_at->Format('d.m.Y H:s') }}
                                            </td>
                                            <td>
                                                {{$order->uuid}}
                                            </td>
                                            <td>

                                                {{ floatval($order->getAmountFloatAttribute())  }}
                                            </td>
                                            <td>
                                                {{ $order->wallet()->first()->slug }}
                                            </td>
                                            <td>
                                                @if (isset($order->meta['destination']))
                                                    @if (is_array($order->meta['destination']))
                                                        @foreach ($order->meta['destination'] as $destination)
                                                            <span class="badge badge-success">{{$destination}}</span>
                                                        @endforeach
                                                    @else
                                                        <span class="badge badge-success">{{$order->meta['destination']}}</span>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            <div class="tab-pane fade" id="pills-withdraw" role="tabpanel"
                                 aria-labelledby="pills-withdraw-tab">

                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <td>Номер заявки</td>
                                        <td>Дата</td>
                                        <td>Номер транзакции</td>
                                        <td>Сумма</td>
                                        <td>Кошелек</td>
                                        <td>Назначение</td>
                                        <td>Комментарий</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($system->getTransactions('withdraw')->whereNotIn('wallet_id', [1, 2])->limit(30)->orderBy('id', 'DESC')->get() as $order)
                                        <tr>
                                            <td>
                                                {{ $order->meta['order_id'] ?? '--'  }}
                                            </td>
                                            <td>
                                                {{ $order->created_at->Format('d.m.Y H:s') }}
                                            </td>
                                            <td>
                                                {{$order->uuid}}
                                            </td>
                                            <td>
                                                {{ floatval($order->getAmountFloatAttribute()) }}
                                            </td>
                                            <td>
                                                {{ $order->wallet()->first()->slug }}
                                            </td>
                                            <td>
                                                @if (isset($order->meta['destination']))
                                                    @if (is_array($order->meta['destination']))
                                                        @foreach ($order->meta['destination'] as $destination)
                                                            <span class="badge badge-success">{{$destination}}</span>
                                                        @endforeach
                                                    @else
                                                        <span class="badge badge-success">{{$order->meta['destination']}}</span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                {{ $order->meta['comment'] ?? '' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="pills-balances" role="tabpanel"
                                 aria-labelledby="pills-balances-tab">
                                <hr>
                                <h3 class="mb-3">Балансы системного кошелька</h3>
                                <h4>{{ $system->getBalance('TokenSale') }} DHB (Токен Сейл)</h4>
                                <h4>{{ $system->getBalance('DHBFundWallet') }} DHB (Резервы Фонда)</h4>
                                @foreach (\App\Models\Currency::all() as $currency)
                                    @if (!in_array($currency->title, array('DHB', 'USD')) && $system->getBalance($currency->title) > 0)
                                    <h4>{{ $system->getBalance($currency->title) }} {{ $currency->title }}</h4>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <hr/>

                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="modal-send" tabindex="-1" role="dialog" aria-labelledby="modal-send" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Перевод средств пользователю</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="/api/send" id="send-payment">
                        <div class="form-group">
                            <label for="currency">Валюта</label>
                            <select class="form-control" name="currency">
                                <option value="DHBFundWallet">{{$system->getBalance('DHBFundWallet')}} DHB (Резерв Фонда)</option>
                                @foreach (\App\Models\Currency::all() as $currency)
                                    @if (!in_array($currency->title, array('DHB', 'USD')) && $system->getBalance($currency->title) > 0)
                                        <option value="{{ $currency->title }}">{{ $system->getBalance($currency->title) }} {{ $currency->title }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="username">Пользователь</label>
                            <select class="form-control selectable" name="username" placeholder="Пользователь">
                                @foreach ($users as $user)
                                    <option value="{{$user->uid}}">{{$user->uid}} {{$user->username}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="amount">Сумма</label>
                            <input type="text" class="form-control" name="amount" placeholder="Введите сумму">
                        </div>
                        <div class="form-group">
                            <label for="destination">Назначение</label>
                            <select class="form-control selectable" name="destination" placeholder="Назначение платежа"
                                    multiple>
                                @foreach ($tags as $tag)
                                    <option value="{{$tag->name}}">{{$tag->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="message">Комментарий</label>
                            <textarea class="form-control" name="message"
                                      placeholder="Комментарий к транзакции"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="button" onclick="sendPayment();" class="btn btn-primary">Вывести</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="/js/typehead.js"></script>
    <script src="/js/bootstrap-tagsinput.js"></script>
    <script>
        let _token = $('meta[name="csrf-token"]').attr('content');

        let elt = $('input[name="destination"]');
        elt.tagsinput({
            typeahead: {
                afterSelect: function (val) {
                    this.$element.val("");
                },
                source: function (query) {
                    return $.post('/api/tags', {_token: $('meta[name="csrf-token"]').attr('content')});
                }
            },
        });
        elt.on('itemAdded', function (event) {
            console.log(event.item)
            $('.bootstrap-tagsinput input').val('')
        })
    </script>
    <script>
/*        function withdrawPayment() {
            let currency = $('#withdraw-payment select[name="currency"]').val();
            let amount = $('#withdraw-payment input[name="amount"]').val();
            let destination = $('#withdraw-payment select[name="destination"]').val();
            let message = $('#withdraw-payment textarea').val();
            let _token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "/api/withdraw-payment",
                type: "POST",
                data: {
                    _token: _token,
                    currency: currency,
                    amount: amount,
                    destination: destination,
                    message: message
                },
                success: function (response) {
                    alert('Вывод средств успешно совершен')
                    window.location.href = '{{Route('dashboard.reports')}}';
                },
            });
        }*/

        function sendPayment() {
            let currency = $('#send-payment select[name="currency"]').val();
            let amount = $('#send-payment input[name="amount"]').val();
            let destination = $('#send-payment select[name="destination"]').val();
            let message = $('#send-payment textarea').val();
            let username = $('#send-payment select[name="username"]').val();
            let _token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "/api/send",
                type: "POST",
                data: {
                    _token: _token,
                    currency: currency,
                    amount: amount,
                    destination: destination,
                    username: username,
                    message: message,
                },
                success: function (response) {
                    alert(response)
                    window.location.href = '{{Route('dashboard.reports')}}';
                },
            });
        }
    </script>
    <script src="/js/typehead.js"></script>
    <script src="/js/sifter.js"></script>
    <script src="/js/microplugin.min.js"></script>
    <link type="text/css" rel="stylesheet" href="/css/selectize.css">
    <script src="/js/selectize.js"></script>
    <script>
        $(function () {
            $(".selectable").selectize({
                create: true,
                sortField: "text",
                render: {
                    option_create: function (data, escape) {
                        return '<div class="create">Добавить <strong>' + escape(data.input) + '</strong>&hellip;</div>';
                    }
                },
            });
        })
    </script>
@endsection
