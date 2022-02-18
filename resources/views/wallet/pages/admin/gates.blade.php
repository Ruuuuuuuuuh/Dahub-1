
@extends('wallet.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card main-screen">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="inline-block mb-0">Администрирование шлюзов</p>
                            <div class="d-flex justify-content-end">
                                <a class="btn btn-primary" href="/wallet/" >Вернуться назад</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @foreach ($gates as $gate)
                            <div class="row mb-4">
                                <div class="col-12 col-md-9 order-wrapper">
                                    <div class="row align-items-center">
                                        <div class="col-6 col-lg-3">
                                            <p><a href="tg://user?id={{$gate->uid}}">{{$gate->uid}}</a></p>
                                        </div>

                                        <div class="col-6 col-lg-3">
                                            <p><a href="tg://resolve?domain={{$gate->username}}">{{'@'.$gate->username}}</a></p>
                                        </div>

                                        <div class="col-6 col-lg-3">
                                            <p>{{$gate->getWallet('iUSDT')->balanceFloat}} iUSDT</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
