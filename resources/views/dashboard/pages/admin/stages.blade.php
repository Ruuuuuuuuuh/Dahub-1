@extends('dashboard.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card main-screen">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="inline-block mb-0">Настройка токен сейла</p>
                            <div class="d-flex justify-content-end">
                                <a class="btn btn-primary" href="/dashboard/">Вернуться назад</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>Текущий баланс DHB</p>
                        <h2>{{ $system->getWallet('DHBFundWallet')->balanceFloat }} DHB</h2>
                        <p>Замороженные токены (в заявках)</p>
                        <a class="btn btn-success set-dhb-rate">Установить курс токенов</a>
                        {{--                        <a class="start-token-sale">старт токен сейл</a>--}}
                        <a class="btn btn-primary set-dhb-per-user">Лимит DHB в одни руки</a>
                        <a class="btn btn-warning set-dhb-per-order">Лимит DHB в одной заявке</a>
                        <div class="form-group w-50 mt-4">
                            <p>Установите таймер заморозки токенсейла:</p>
                            <input type="datetime-local" name="token-sale-date" class="form-control mb-3"
                                   @if ($system->start_token_sale_date) value="{{\Carbon\Carbon::parse($system->start_token_sale_date)->format('Y-m-d\TH:i')}}" @endif>
                            <a class="btn btn-success set-token-sale-date">Установить таймер</a>
                            <a class="btn btn-secondary reset-token-sale-date">Сбросить таймер</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('.set-dhb-rate').bind('click', function (e) {
                let dhbRate = '{{Rate::getRates('DHB')}}'
                e.preventDefault();
                let amount = prompt("Введите курс DHB, текущий курс равен " + dhbRate, "");
                if (amount != null) {
                    $.post("/api/set_dhb_rate", {
                        "_token": "{{ csrf_token() }}",
                        "rate": amount,
                    })
                        .done(function (data) {
                            alert('Курс DHB успешно установлен')
                        });
                }
            })

            $('.set-dhb-per-user').bind('click', function (e) {
                e.preventDefault();
                let amount = prompt("Введите, сколько токенов ограничить в одни руки");
                if (amount != null) {
                    $.post("/api/set_dhb_per_user", {
                        "_token": "{{ csrf_token() }}",
                        "amount": amount,
                    })
                        .done(function (data) {
                            alert('Количество DHB в одни руки установлено на значении ' + amount)
                        });
                }
            })

            $('.set-dhb-per-order').bind('click', function (e) {
                e.preventDefault();
                let amount = prompt("Введите, сколько токенов ограничить в одной заявке");
                if (amount != null) {
                    $.post("/api/set_dhb_per_order", {
                        "_token": "{{ csrf_token() }}",
                        "amount": amount,
                    })
                        .done(function (data) {
                            alert('Количество DHB в одной заявке установлено на значении ' + amount)
                        });
                }
            })

            $('.set-token-sale-date').bind('click', function (e) {
                e.preventDefault();
                let _token = $('meta[name="csrf-token"]').attr('content');
                let datetime = $('input[name="token-sale-date"]').val()
                $.ajax({
                    url: "/api/set-token-sale-date",
                    type: "POST",
                    data: {
                        _token: _token,
                        datetime: datetime
                    },
                    success: function (response) {
                        alert('Таймер старта токенсейла успешно установлен')
                        window.location.href = '{{Route('dashboard.stages')}}';
                    },
                });
            })

            $('.reset-token-sale-date').bind('click', function (e) {
                e.preventDefault();
                let _token = $('meta[name="csrf-token"]').attr('content');
                let datetime = ''
                $.ajax({
                    url: "/api/set-token-sale-date",
                    type: "POST",
                    data: {
                        _token: _token,
                        datetime: datetime
                    },
                    success: function (response) {
                        alert('Таймер токенсейла успешно сброшен')
                        window.location.href = '{{Route('dashboard.stages')}}';
                    },
                });
            })


        })
    </script>
@endsection
