
@extends('wallet.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card main-screen">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="inline-block mb-0">Пользователи</p>
                            <div class="d-flex justify-content-end">
                                <a class="btn btn-primary" href="/wallet/" >Вернуться назад</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col" class="pl-5">Аватар</th>
                                    <th scope="col">Телеграм ID</th>
                                    <th scope="col">Имя</th>
                                    <th scope="col">TG @username</th>
                                    <th scope="col">Баланс DHB</th>
                                    <th scope="col">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($users as $user)

                                        <tr id="{{$user->uid}}">
                                            <td class="pl-4"><a class="user_avatar ml-3" style="background-image:url({{$user->avatar}})"></a></td>
                                            <td>{{$user->uid}}</td>
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->username}}</td>
                                            <td class="user-balance">{{number_format($user->getWallet('DHB')->balanceFloat, 0, ',', ' ')}} </td>
                                            <td>
                                                <a data-uid="{{$user->uid}}" class="btn btn-success user-deposit">+</a>
                                                <a data-uid="{{$user->uid}}"  class="btn btn-danger user-withdraw">-</a>
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
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('.user-deposit').bind('click', function(e) {
                let uid = $(this).data('uid');
                e.preventDefault();
                let amount = prompt("Введите количество токенов", "");
                if (amount != null) {
                    $.post( "/api/deposit", {
                        "_token": "{{ csrf_token() }}",
                        "uid": uid,
                        "amount": amount
                    })
                    .done(function( data ) {
                        $('#' + uid + ' .user-balance').html(data);
                    });
                }
            })

            $('.user-withdraw').bind('click', function(e) {
                let uid = $(this).data('uid');
                e.preventDefault();
                let amount = prompt("Введите количество токенов", "");
                if (amount != null) {
                    $.post( "/api/withdraw", {
                        "_token": "{{ csrf_token() }}",
                        "uid": uid,
                        "amount": amount
                    })
                    .done(function( data ) {
                        $('#' + uid + ' .user-balance').html(data);
                    });
                }
            })
        })
    </script>
@endsection
