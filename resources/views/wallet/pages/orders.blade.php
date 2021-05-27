
@extends('wallet.layouts.app')

@section('content')
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

                        <h2>Список подтвержденных заявок</h2>
                        <div class="orders-list">
                            @if (count($orders) != 0)
                                @foreach ($orders as $order)
                                    @php
                                        if ($order->currency == 'USDT') $dec = 0; else $dec = 5;
                                    @endphp
                                    <div class="order col-12 {{$order->status}}">
                                        <div class="row">
                                            <div class="col-12 col-md-9 order-wrapper">
                                                <div class="row">
                                                    <div class="col-6 col-lg-3">
                                                        <p>@php echo '<a href="tg://user?id=' . $order->user()->first()->uid .'">' . $order->user()->first()->username . '</a>'; @endphp</p>
                                                    </div>

                                                    <div class="col-6 col-lg-3">
                                                        <p><strong>{{number_format($order->amount, 0, ',', ' ')}} DHB</strong></p>
                                                    </div>

                                                    <div class="col-6 col-lg-3">
                                                        <p>за {{number_format($order->amount / $order->rate, $dec, ',', ' ') }} {{$order->currency}}</p>
                                                    </div>

                                                    <div class="col-6 col-lg-3">
                                                        <p>{{ $order->created_at->format('d.m.Y H:i') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <div class="orders-actions justify-content-md-end justify-content-around d-flex align-items-center h-100">
                                                    @if ($order->status != 'created')
                                                    <a data-id="{{$order->id}}" class="btn btn-success order-confirm">Подтвердить</a>
                                                    @endif
                                                    <a data-id="{{$order->id}}"  class="btn btn-danger order-decline">Отклонить</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p>Вы еще не создали ни единой заявки на получение DHB.</p>
                                <a onclick="$('#deposit-tab').click()" style="margin-top:40px;" class="button button-orange">Получить DHB</a>
                            @endif
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
            $('.order-confirm').bind('click', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                let _token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "/api/orders/" + id + "/confirm",
                    type:"POST",
                    data:{
                        _token: _token,
                    },
                    success:function(response){
                        alert('Заявка подтверждена')
                        window.location.href = '/wallet/orders/';
                    },
                });
            })

            $('.order-decline').bind('click', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                let _token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "/api/orders/" + id + "/decline",
                    type:"POST",
                    data:{
                        _token: _token,
                    },
                    success:function(response){
                        alert('Заявка отменена')
                        window.location.href = '/wallet/orders/';
                    },
                });
            })

        })
    </script>
@endsection
