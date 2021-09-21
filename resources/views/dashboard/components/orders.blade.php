<div class="orders">

    @foreach ($orders as $order)
    <a href="{{Route('getOrder', $order->id)}}" class="order-item d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-start flex-column justify-content-center">
            <div class="currency">{{$order->currency}}</div>
            <div class="destination {{$order->destination}}">@if ($order->destination == 'deposit')Ввод@elseif ($order->destination == 'withdraw')Вывод@endif</div>
        </div>
        <div class="d-flex align-items-end flex-column justify-content-center">
            @if ($order->rate)
            <div class="amount">{{number_format($order->amount / $order->rate, Auth::user()->getWallet($order->currency)->decimal_places, '.', ' ')}}</div>
            <div class="datetime">{{$order->created_at->format('d.m.Y H:i')}}</div>
            @else
            <div class="amount">{{number_format($order->amount, Auth::user()->getWallet($order->currency)->decimal_places, '.', ' ')}}</div>
            <div class="datetime">{{$order->created_at->format('d.m.Y H:i')}}</div>
            @endif
        </div>
    </a>
    @endforeach
</div>
