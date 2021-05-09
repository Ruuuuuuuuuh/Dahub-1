<h2>Заявки на пополнение</h2>
<div class="orders-list">
@if (count(Auth::user()->orders()->get()) != 0)
@foreach (Auth::user()->orders()->get() as $order):
    <div class="order col-12 {{$order->status}}">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="row">
                    <div class="col-md-12 col-lg-3">
                        <div class="row">
                            Получение
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-3">
                        <div class="row">
                            {{$order->amount}} DHB
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-3">
                        <div class="row">
                            за {{$order->amount / $order->rate}} {{$order->currency}}
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-3">
                        <div class="row">
                            {{ $order->created_at->format('d.m.Y H:i') }}
                        </div>
                    </div>
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
