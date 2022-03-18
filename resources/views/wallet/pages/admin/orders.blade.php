
@extends('wallet.layouts.app')

@section('content')
    <style>
        .orders-list .completed {
            background: #9dfc9b;
            border-radius: 30px;
        }
        .orders-list .completed .order-wrapper {
            background:transparent;
        }
        .orders-actions {
            padding-right:25px;
        }
    </style>
    <div class="container-fluid admin-orders">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card main-screen">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="inline-block mb-0">Заявки</p>
                            <div class="d-flex justify-content-end">
                                <a class="btn btn-primary" href="/wallet/" >Вернуться назад</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <h2 class="mb-4">Список заявок</h2>

                        <div class="order-list">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <td>ID</td>
                                        <td>Дата создания</td>
                                        <td>Username</td>
                                        <td>Тип</td>
                                        <td>Сумма</td>
                                        <td>Статус</td>
                                        <td>Шлюз</td>
                                        <td>Действия</td>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($orders as $order)
                                <tr>
                                    <td>#{{$order->id}}</td>
                                    <td>{{$order->created_at->diffForHumans()}}</td>
                                    <td>@php $owner = $order->user()->first(); echo '<a href="tg://user?id=' . $owner->uid .'">' . $owner->name . '</a><br /><a href="tg://resolve?domain=' . $owner->username .'">@' . $owner->username . '</a>'; @endphp</td>
                                    <td>
                                        @switch($order->destination)
                                            @case('TokenSale')
                                            ТокенСейл (ввод)
                                            @break

                                            @case('deposit')
                                            Ввод
                                            @break

                                            @case('withdraw')
                                            Вывод
                                            @break

                                            @default
                                            {{$order->destination}}
                                        @endswitch
                                    </td>
                                    <td>{{$order->amount}} {{$order->currency}} @if ($order->destination == 'TokenSale') ({{$order->dhb_amount}} DHB) @endif</td>
                                    <td>
                                        @switch($order->status)
                                            @case('created')
                                            Новая
                                            @break

                                            @case('accepted')
                                            Принята шлюзом
                                            @break

                                            @case('pending')
                                            Ожидание перевода средств
                                            @break

                                            @case('completed')
                                            Выполнена
                                            @break

                                            @default
                                            В обработке
                                        @endswitch
                                    </td>
                                    <td>
                                        @if ($order->gate)
                                        @php $gate = \App\Models\User::where('uid', $order->gate)->first(); echo '<a href="tg://user?id=' . $gate->uid .'">' . $gate->name . '</a><br /><a href="tg://resolve?domain=' . $gate->username .'">@' . $gate->username . '</a>'; @endphp
                                        @endif
                                    </td>
                                    <td>
                                        @if ($order->status == 'created')
                                            <a data-id="{{$order->id}}" class="btn btn-danger order-decline">Отменить заявку</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){

            $('.order-decline').bind('click', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                let _token = $('meta[name="csrf-token"]').attr('content');
                if (confirm("Отменить заявку?") == true) {
                    $.ajax({
                        url: "/api/orders/" + id + "/decline",
                        type: "POST",
                        data: {
                            _token: _token,
                        },
                        success: function (response) {
                            alert('Заявка отменена')
                            window.location.href = '/wallet/orders/';
                        },
                    });
                }
            })

        })
    </script>
@endsection
