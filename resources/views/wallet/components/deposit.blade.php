<div class="deposit-section">
    <div class="new-order">
        <h2>Получить DHB <span class="deposit-status">Шаг 1 из 3</span></h2>
        @if ($max > 2000)
        <div class="deposit-block form-inline">
            <p class="w-100">Введите количество DHB (доступно для покупки {{number_format($max, 0, ',', ' ')}} DHB)</p>
            <div class="form-group input-group">
                <input type="number" class="form-number form-control" name="deposit-amount" value="2000" step="1000"  data-min="2000" data-max="{{$max}}"  />
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
                    <option style="color:#fff;" value="USDT" selected="selected">USDT</option>
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
        @else
            <p style="margin-top: 25px;margin-bottom: -15px;font-weight: 500;color: #e93878;">Вы уже владеете максимальным количеством DHB</p>
        @endif
    </div>


    <div class="assignee-section">
        <h2>Заявка @if (count(Auth::user()->orders()->notCompleted()->get()) != 0)#{{Auth::user()->orders()->notCompleted()->first()->id}} @endif</h2>
        <p>Ожидайте подтверждения оплаты в течение <strong>24 часов.</strong></p>
    </div>
</div>

