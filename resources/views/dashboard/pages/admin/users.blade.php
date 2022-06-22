@extends('dashboard.layouts.app')

@section('content')
    <style>
        .form-group {
            position: relative;
        }
        .form-group .clear {
            position: absolute;
            top:7px;
            right:15px;
        }
    </style>
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
                        <div class="pb-3 d-flex justify-content-between">
                            {{ $users->links('pagination::bootstrap-4') }}
                            <form action="{{Route('dashboard.users')}}" method="GET" class="form d-flex col-md-3 col-12">
                                @csrf
                                @if (!request()->query('search'))
                                <input type="text" class="search-form form-control w-100" placeholder="Поиск пользователя по имени, tg id, username" name="search">
                                @else
                                    <div class="form-group w-100">
                                        <input type="text" class="search-form form-control" placeholder="Поиск пользователя по имени, tg id, username" name="search" value="{{request()->query('search')}}">
                                        <a href="{{Route('dashboard.users')}}" class="clear">
                                            <svg fill="#000000" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 30 30" width="18px" height="18px">    <path d="M 7 4 C 6.744125 4 6.4879687 4.0974687 6.2929688 4.2929688 L 4.2929688 6.2929688 C 3.9019687 6.6839688 3.9019687 7.3170313 4.2929688 7.7070312 L 11.585938 15 L 4.2929688 22.292969 C 3.9019687 22.683969 3.9019687 23.317031 4.2929688 23.707031 L 6.2929688 25.707031 C 6.6839688 26.098031 7.3170313 26.098031 7.7070312 25.707031 L 15 18.414062 L 22.292969 25.707031 C 22.682969 26.098031 23.317031 26.098031 23.707031 25.707031 L 25.707031 23.707031 C 26.098031 23.316031 26.098031 22.682969 25.707031 22.292969 L 18.414062 15 L 25.707031 7.7070312 C 26.098031 7.3170312 26.098031 6.6829688 25.707031 6.2929688 L 23.707031 4.2929688 C 23.316031 3.9019687 22.682969 3.9019687 22.292969 4.2929688 L 15 11.585938 L 7.7070312 4.2929688 C 7.5115312 4.0974687 7.255875 4 7 4 z"/></svg>
                                        </a>
                                    </div>

                                @endif
                            </form>

                        </div>
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

                        <div class="pb-3">
                            {{ $users->links('pagination::bootstrap-4') }}
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
