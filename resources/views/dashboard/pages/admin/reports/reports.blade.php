@extends('dashboard.pages.admin.reports.layout')
@section('reportsContent')
    <h3 class="mb-3">Балансы системного кошелька</h3>
    <h4>{{ $system->getBalance('TokenSale') }} DHB (Токен Сейл)</h4>
    <h4>{{ $system->getBalance('DHBFundWallet') }} DHB (Резервы Фонда)</h4>
    @foreach (\App\Models\Currency::all() as $currency)
        @if (!in_array($currency->title, array('DHB', 'USD')) && $system->getBalance($currency->title) > 0)
            <h4>{{ $system->getBalance($currency->title) }} {{ $currency->title }}</h4>
        @endif
    @endforeach
@endsection
