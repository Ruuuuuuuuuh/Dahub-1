
@extends('wallet.layouts.app')

@section('content')
    <style>

    </style>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card main-screen">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="inline-block mb-0">Заявка #{{$order->id}}</p>
                            @if ($order->status != 'completed')
                            <div class="d-flex justify-content-end">
                                <a class="btn btn-primary" href="/wallet/" >Вернуться назад</a>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($order->status != 'completed')
                        <h2>Получение {{$order->dhb_amount}} DHB <span class="deposit-status">@if ($order->status == 'created') Шаг 2 из 3. В ожидании подтверждения шлюза @elseif ($order->status == 'accepted') Шаг 3 из 3. Ожидание отправки средств @endif</span></h2>
                        @else
                        <h2>Заявка выполнена</h2>
                        @endif
                        @if ($order->status == 'created')
                        <p class="mt-4">Ожидайте, как только мы подберем для вас платежный шлюз, вы получите уведомление в Telegram и дальнейшие инструкции с реквизитами оплаты. </p>
                        <a onclick="decline('{{$order->id}}');" style="margin-top:40px;" class="button button-danger">Отменить заявку</a>
                        @elseif ($order->status == 'accepted')
                            <div class="created-block form-inline">
                                <p>Отправьте <strong><span class="step2-amount">{{$order->amount}} </span> <span class="step2-currency"> {{$order->currency}}</span> </strong> на следующий адрес:</p>
                                <div class="w-100">
                                    <div class="col-12">

                                        <div class="row align-items-center">
                                            <div class="col-12 col-md-7">
                                                <div class="row">
                                                    <a class="wallet-link copy-link" data-toggle="popover" data-placement="bottom" data-content="Ссылка скопирована в буфер обмена." data-original-title="" title="">
                                                        <span>0xdbcf4c1b477ff67bcf0cc9fefc0044692c513a14</span>
                                                        <svg width="33" height="36" viewBox="0 0 33 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <g opacity="0.9">
                                                                <path d="M30.5379 5.84501H29.9899C27.6071 5.84501 25.6755 3.91338 25.6755 1.53059C25.6755 0.685295 24.9902 0 24.1449 0H1.53059C0.685295 0 0 0.685295 0 1.53059V28.6242C0 29.4695 0.685295 30.1548 1.53059 30.1548H2.07854C4.46127 30.1548 6.39285 32.0864 6.39285 34.4691C6.39285 35.3144 7.07815 35.9997 7.92344 35.9997H30.5379C31.3832 35.9997 32.0685 35.3144 32.0685 34.4691V7.37559C32.0685 6.5303 31.3832 5.84501 30.5379 5.84501ZM4.72707 27.0936C3.80702 27.0936 3.06117 26.3478 3.06117 25.4277V8.06117C3.06117 5.29975 5.29975 3.06117 8.06117 3.06117H21.2223C21.991 3.06117 22.6142 3.68436 22.6142 4.45309C22.6142 5.22182 21.991 5.84501 21.2223 5.84501H7.92354C7.07825 5.84501 6.39296 6.5303 6.39296 7.37559V25.4277C6.39296 26.3478 5.64711 27.0936 4.72707 27.0936ZM29.0073 27.9386C29.0073 30.7001 26.7687 32.9386 24.0073 32.9386H14.4541C11.6927 32.9386 9.45413 30.7001 9.45413 27.9386V13.9062C9.45413 11.1448 11.6927 8.90618 14.4541 8.90618H24.0073C26.7687 8.90618 29.0073 11.1448 29.0073 13.9062V27.9386Z" fill="url(#paint1_linear)"></path>
                                                            </g>
                                                            <defs>
                                                                <linearGradient id="paint1_linear" x1="16.0342" y1="-16.1999" x2="33.7999" y2="-11.6723" gradientUnits="userSpaceOnUse">
                                                                    <stop stop-color="#FF9134"></stop>
                                                                    <stop offset="1" stop-color="#E72269"></stop>
                                                                </linearGradient>
                                                            </defs>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <div class="row justify-content-center">
                                                    <div class="qr-code"><canvas width="256" height="256"></canvas></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <a onclick="decline();" style="margin-top:40px;" class="button button-danger">Отменить заявку</a>
                            </div>
                        @elseif ($order->status == 'completed')
                            <div class="mt-4 mb-3">
                                <p>
                                    <strong>Отправлено:</strong> {{number_format($order->amount, Auth::user()->getWallet($order->currency)->decimal_places, '.', ' ').' '.$order->currency}} в сети {{$order->payment}} <br />
                                    <strong>Получено:</strong> {{number_format($order->dhb_amount, 2, '.', ' ').' DHB'}} <br />
                                    <strong>На адрес: </strong>{{$order->payment_details}}<br />
                                    <strong>Хеш транзакции:</strong> {{ $order->orderSystemTransaction()->uuid}}<br />
                                </p>

                                <a href="/wallet" style="margin-top:40px;" class="button button-orange">Вернуться на главную</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function decline(id) {
            let _token = $('meta[name="csrf-token"]').attr('content');
            if (confirm("Отменить заявку?") == true) {
                $.ajax({
                    url: "/api/orders/declineOrder",
                    type:"POST",
                    data:{
                        _token: _token,
                        id: id
                    },
                    error: function () {
                        alert('При попытке отменить заявку произошла ошибка')
                        window.location.href = '/wallet/orders/' + id
                    },
                    success:function(response){
                        alert('Заявка успешно отменена')
                        window.location.href = '/wallet/'
                    },
                });
            }
        }

        $(document).ready(function(){
            let a = $('.copy-link span').text()
            $('.qr-code').qrcode(a)
        })


    </script>
@endsection