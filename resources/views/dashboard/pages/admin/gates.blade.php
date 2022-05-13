@extends('dashboard.layouts.app')

@section('content')
    <div class="container-fluid">
        <table class="table table-striped">
            <thead>
            <tr>
                <td>Username</td>
                <td>Имя</td>
                @foreach (\App\Models\Currency::payableCurrencies()->get() as $currency)
                    <td>{{$currency->title}}</td>
                @endforeach
                <td>Всего, $</td>
                <td>Заморожено, $</td>
            </tr>
            </thead>
            <tbody>
            @foreach (\App\Models\User::getGates()->get() as $gate)
                <tr>
                    <td>{{$gate->username}}</td>
                    <td>{{$gate->name}}</td>
                    @foreach (\App\Models\Currency::payableCurrencies()->get() as $currency)
                        <td>
                            @if ($gate->hasWallet($currency->title.'_gate'))
                                {{$gate->getWallet($currency->title.'_gate')->balanceFloat}}
                            @else
                                0
                            @endif
                        </td>
                    @endforeach
                    <td>{{$gate->getBalanceInner()}}</td>
                    <td>{{$gate->getBalanceFrozen()}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection

@section('script')
    <script>

    </script>
@endsection
