<h2>Мои заявки</h2>
    <div class="orders-list">
    @if (count(Auth::user()->orders()->get()) != 0)
        @foreach (Auth::user()->orders()->where('destination', 'TokenSale')->orderBy('id', 'DESC')->get() as $order)
        <div class="order col-12 {{$order->status}}">
            @php
            if ($order->currency == 'USDT') $dec = 0; else $dec = 5;
            @endphp
            <div class="row">
                <div class="col-lg-9 col-12 order-wrapper">
                    <div class="row">
                        <div class="col-4 col-lg-3">
                            <p>Получение</p>
                        </div>

                        <div class="col-4 col-lg-3">
                            <p><strong>{{number_format($order->amount, 0, ',', ' ')}} DHB</strong></p>
                        </div>

                        <div class="col-4 col-lg-3">
                            <p>за {{number_format($order->amount / $order->rate, $dec, ',', ' ') }} {{$order->currency}}</p>
                        </div>

                        <div class="col-4 col-lg-3">
                            <p>{{ $order->created_at->format('d.m.Y H:i') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-12">
                    <div class="order-status d-flex align-items-center h-100">
                        <p>@if ($order->status != 'completed') Ожидается @else Выполнено @endif</p>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @else
        <p>Вы еще не создали ни единой заявки на получение DHB.</p>
        <a onclick="$('#deposit-tab').click()" style="margin-top:40px;" class="button button-orange">Получить DHB</a>
    @endif
</div>
