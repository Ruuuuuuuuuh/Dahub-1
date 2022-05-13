@foreach ($wallets as $wallet)

    {{$wallet->name}} <br />
    {{$wallet->balance / (10 ** $wallet->decimal_places)}} <br />
    <hr />
@endforeach
