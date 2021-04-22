
@extends('wallet.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card main-screen">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="inline-block mb-0">Этапы токен сейла</p>
                            <div class="d-flex justify-content-end">
                                <a class="btn btn-primary" href="/wallet/" >Вернуться назад</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>Текущий баланс DHB</p>
                        <h2>{{ $system->getWallet('DHB')->balance }} DHB</h2>
                        <p>Замороженные токены (в заявках)</p>
                        <h2>{{$system->getFrozenTokens()}} DHB</h2>
                        @if ($system->stage != 1)
                        <a class="button button-orange start-token-sale">Запустить токен сейл</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){

            $('.start-token-sale').bind('click', function(e) {
                e.preventDefault();
                let _token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "/api/start_token_sale",
                    type:"POST",
                    data:{
                        _token: _token,
                    },
                    success:function(response){
                        alert('Токен сейл успешно запущен по цене токена в 0.05$ На системный кошелек начислено 2 млн токенов DHB')
                        window.location.href = '/wallet/stages/';
                    },
                });
            })

        })
    </script>
@endsection
