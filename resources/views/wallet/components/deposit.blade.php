<div class="deposit-section">
    <div class="new-order">
        <h2>Получить DHB <span class="deposit-status">Шаг 1 из 3</span></h2>
        <div class="deposit-block form-inline">

            <p class="w-100">Введите количество токенов DHB</p>
            <div class="form-group input-group">
                <input type="number" class="form-number form-control" name="deposit-amount" value="2000" step="1000"  min="2000"  />
                <div class="input-group-append">
                    <div class="input-group-text">DHB</div>
                </div>
            </div>
            <div class="form-group deposit-recieve-group">
                <p>
                    <span style="margin-right:20px;">=</span>
                    <input class="deposit-receive" name="deposit-receive" value="{!! 2000 * Rate::getRates('DHB') !!}"/>
                </p>
            </div>

            <div class="form-group currency-select">
                <select class="form-number form-control" name="deposit-currency">
                    <option value="USDT">USDT</option>
                    <option value="BTC">BTC</option>
                    <option value="ETH">ETH</option>
                </select>
            </div>

            <p class="w-100 mt-5">Выберите платежную систему</p>
            <div class="form-group payment-select">
                <select class="form-control ml-0" name="deposit-payment">
                    @foreach (\App\Models\Currency::where('title', 'USDT')->first()->payments()->get() as $payment)
                        <option value="{{$payment->title}}">{{$payment->title}}</option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="subtotal">
            <p><strong>Ваш баланс после покупки:</strong></p>
            <p class="subtotal-amount"><span>{{ number_format(Auth::User()->getBalance('DHB') + 2000, 2, ',',' ')  }}</span> DHB</p>
        </div>

        <a onclick="deposit();" style="margin-top:40px;" class="button button-orange">Получить DHB</a>
    </div>


    <div class="assignee-section">
        <h2>Заявка @if (count(Auth::user()->orders()->notCompleted()->get()) != 0)#{{Auth::user()->orders()->notCompleted()->first()->id}} @endif</h2>
        <p>Ожидайте подтверждения оплаты в течение <strong>24 часов.</strong></p>
    </div>
</div>

