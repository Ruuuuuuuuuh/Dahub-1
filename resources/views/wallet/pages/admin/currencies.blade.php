
@extends('wallet.layouts.app')

@section('content')
    <style>
        .currencies .nav-item {
            padding:15px 25px;
            font-size:18px;
            background:#f9f9f9;
            border-radius: 15px;
            margin:0 0 15px;
        }
        .currencies .nav-item a {
            padding:0;
            color:#1a202c;
        }
    </style>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card main-screen">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="inline-block mb-0">Добавление токенов / валют</p>
                            <div class="d-flex justify-content-end">
                                <a class="btn btn-primary" href="/dashboard/" >Вернуться назад</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h2>Список валют</h2>
                        <ul class="nav flex-column currencies">
                            @foreach ($currencies as $currency)
                                <li class="nav-item d-flex justify-content-between align-items-center" data-crypto="{{$currency->crypto}}">
                                    <a href="{{Route('wallet.currencies')}}/{{$currency->title}}">{{$currency->title}}</a>
                                </li>
                            @endforeach
                        </ul>
                        <a class="btn btn-success action">Добавить новую валюту / токен</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('.action').bind('click', function(e) {

                e.preventDefault();
                let title = prompt("Введите название валюты / токена");
                let crypto = prompt("Это криптовалюта? 1 – да, 0 – нет");
                let decimal_places = prompt("Число знаков после нуля");
                if (title != null) {
                    $.post( "/api/add_currency", {
                        "_token": "{{ csrf_token() }}",
                        "title": title,
                        "crypto": crypto,
                        "decimal_places": decimal_places,
                    })
                    .done(function( data ) {
                        alert('Валюта успешно добавлена')
                        window.location.href = '{{Request::url()}}';
                    });
                }
            })


        })
    </script>
@endsection
