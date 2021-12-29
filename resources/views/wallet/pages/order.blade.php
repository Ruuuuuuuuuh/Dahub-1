
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
                            <div class="d-flex justify-content-end">
                                <a class="btn btn-primary" href="/wallet/" >Вернуться назад</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h2>Получение DHB <span class="deposit-status">@if ($order->status == 'created') Шаг 2 из 3. В ожидании подтверждения шлюза @elseif ($order->status == 'assignee') Шаг 3 из 3. Ожидание отпраки средств  @elseif ($order->status == 'created')Выполнена@endif</span></h2>
                        @if ($order->status == 'created')
                        <a onclick="decline('{{$order->id}}');" style="margin-top:40px;" class="button button-danger">Отменить заявку</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>

    </script>
@endsection
