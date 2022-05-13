@extends('dashboard.layouts.app')

@section('content')
    <style>
        .currencies .nav-item {
            padding: 15px 25px;
            font-size: 18px;
            background: #f9f9f9;
            border-radius: 15px;
            margin: 0 0 15px;
        }

        .currencies .nav-item a {
            padding: 0;
            color: #1a202c;
        }
    </style>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card main-screen">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="inline-block mb-0">Список платежных систем</p>
                            <div class="d-flex justify-content-end">
                                <a class="btn btn-primary" href="/dashboard/">Вернуться назад</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h2>Список валют</h2>
                        <ul class="nav flex-column currencies">
                            @foreach ($payments as $payment)
                                <li class="nav-item d-flex justify-content-between align-items-center"
                                    data-crypto="{{$payment->crypto}}">
                                    {{$payment->title}}
                                    @if ($payment->crypto)
                                        <span class="badge badge-success" style="font-weight:500">Crypto</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                        <a class="btn btn-success action">Добавить новую платежную систему или сеть</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('.action').bind('click', function (e) {

                e.preventDefault();
                let title = prompt("Введите название платежной системы или сети");
                let crypto = prompt("Это сеть (крипто)? 1 – да, 0 – нет");
                if (title != null) {
                    $.post("/api/add_payment", {
                        "_token": "{{ csrf_token() }}",
                        "title": title,
                        "crypto": crypto,
                    })
                        .done(function (data) {
                            alert('Платежная сеть / система добавлена')
                            window.location.href = '{{Request::url()}}';
                        });
                }
            })


        })
    </script>
@endsection
