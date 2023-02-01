@extends('wallet.layouts.exchange')
@section('content')
<div class="container-fluid">
    <div class="exchange-currencies">
        <div class="col-12">
            <div class="row">
                @foreach($currency->all() as $currency)
                    <a data-href="{{$currency->title}}" class="currency">{{$currency->title}}</a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
