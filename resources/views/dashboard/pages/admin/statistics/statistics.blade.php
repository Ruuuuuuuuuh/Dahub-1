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
                            <p class="inline-block mb-0">Статистика</p>
                            <div class="d-flex justify-content-end">
                                <a class="btn btn-primary" href="/dashboard/">Вернуться назад</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h2>Статистика пользователей</h2>
                        <div class="d-flex mt-3 mb-3">
                            <a href="/dashboard/statistics?filter=balance" class="btn btn-primary text-large">Балансы в DHB</a>
                            <a href="/dashboard/statistics?filter=referrals" class="btn btn-primary text-large ml-3">Рефералы</a>
                            <a href="/dashboard/statistics?filter=orders" class="btn btn-primary text-large ml-3">Количество выполненных заявок</a>
                        </div>

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <td>Uid</td>
                                <td>Username</td>
                                <td>Name</td>
                                @if ($filter == 'balance')
                                <td>Balance</td>
                                @elseif ($filter == 'referrals')
                                <td>Referrals Count</td>
                                @elseif ($filter == 'orders')
                                <td>Gate orders</td>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{$user->uid}}</td>
                                    <td>{{$user->username}}</td>
                                    <td>{{$user->name}}</td>
                                    @if ($filter == 'balance')
                                        <td>{{number_format($user->wallets_balance / 100, 0, ',' , ' ')}}</td>
                                    @elseif ($filter == 'referrals')
                                        <td>{{$user->referrals_count}}</td>
                                    @elseif ($filter == 'orders')
                                        <td>{{$user->gate_orders_count}}</td>
                                    @endif
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

    </script>
@endsection
