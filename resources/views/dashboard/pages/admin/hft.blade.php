@extends('dashboard.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card main-screen">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="inline-block mb-0">Пополнение системного кошелька HFT</p>
                            <div class="d-flex justify-content-end">
                                <a class="btn btn-primary" href="/dashboard/">Вернуться назад</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>Текущий баланс: {{$system->getWallet('HFT')->balanceFloat}} HFT</p>
                        <a class="btn btn-success deposit-hft">Пополнить системный кошелек HFT</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('.deposit-hft').bind('click', function (e) {

                e.preventDefault();
                let amount = prompt("Введите количество HFT для пополнения");
                if (amount != null) {
                    $.post("/api/set_hft", {
                        "_token": "{{ csrf_token() }}",
                        "amount": amount,
                    })
                        .done(function (data) {
                            alert('HFT успешно пополнены')
                            window.location.href = '/wallet/hft/';
                        });
                }
            })


        })
    </script>
@endsection
