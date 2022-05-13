@extends('dashboard.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card main-screen">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="inline-block mb-0">Пользователи</p>
                            <div class="d-flex justify-content-end">
                                <a class="btn btn-primary" href="/dashboard/">Вернуться назад</a>
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
                                <th scope="col">Телеграм ID</th>
                                <th scope="col">Имя</th>
                                <th scope="col">TG @username</th>
                                <th scope="col">Баланс DHB</th>
                                <th scope="col">Действия</th
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $user)

                                <tr id="{{$user->uid}}">
                                    <td>{{$user->uid}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->username}}</td>
                                    <td class="user-balance">{{number_format($user->getWallet('DHB')->balanceFloat, 0, ',', ' ')}} </td>
                                    <td class="gate-actions">
                                        @if ($user->isGate())
                                            <a data-uid="{{$user->uid}}" class="btn btn-danger user-remove-gate">Убрать
                                                из шлюзов</a>
                                        @else
                                            <a data-uid="{{$user->uid}}" class="btn btn-success user-set-gate">Назначить
                                                шлюзом</a>
                                        @endif
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
        $(document).ready(function () {
            $('.user-set-gate').bind('click', function (e) {
                e.preventDefault();
                let uid = $(this).data('uid');
                $.post("/api/set_gate", {
                    "_token": "{{ csrf_token() }}",
                    "user_uid": uid,
                })
                    .done(function () {
                        alert('Вы успешно назначили пользователю права шлюза')
                        $('#' + uid + ' .gate-actions').html('<a data-uid="' + uid + '" class="btn btn-danger user-remove-gate">Убрать из шлюзов</a>');
                    });
            })

            $('.user-remove-gate').bind('click', function (e) {
                e.preventDefault();
                let uid = $(this).data('uid');
                $.post("/api/remove_gate", {
                    "_token": "{{ csrf_token() }}",
                    "user_uid": uid,
                })
                    .done(function () {
                        alert('Вы успешно убрали у пользователя права шлюза')
                        $('#' + uid + ' .gate-actions').html('<a data-uid="' + uid + '" class="btn btn-success user-set-gate">Сделать шлюзом</a>');
                    });
            })
        })
    </script>
@endsection
