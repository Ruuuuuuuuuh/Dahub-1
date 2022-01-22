<div class="deposit-section">
    <div class="new-order">
        <h2>Получить DHB</h2>
        <h3 class="status-text">Шаг 1 из 3</h3>
        <div class="status-bar">
            <span class="active"></span>
            <span></span>
            <span></span>
        </div>
        @if ($max > 2000)
        <div class="deposit-block">
            <p class="w-100">Введите количество DHB. <br />Доступно для покупки {{number_format($max, 0, ',', ' ')}} DHB.</p>
            <div class="form-group deposit-amount-wrapper">
                <input type="number" name="deposit-amount" value="2000" step="1000"  data-min="2000" data-max="{{$max}}"  />
            </div>
            <div class="form-group deposit-recieve-group">
                <span style="margin-right:20px;">≈</span>
                <input class="deposit-receive" name="deposit-receive" value="{!! 2000 * Rate::getRates('DHB') !!}"/>
                <div class="deposit-currency-wrapper">
                    <select name="deposit-currency">
                        <option value="USDT" selected="selected">USDT</option>
                        <option value="BTC">BTC</option>
                        <option value="ETH">ETH</option>
                    </select>
                    <div class="select-angle">
                        <svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.72487 7.09686C6.32541 7.56931 5.59709 7.56931 5.19763 7.09686L1.01127 2.14566C0.461693 1.49567 0.923708 0.5 1.7749 0.5L10.1476 0.499999C10.9988 0.499999 11.4608 1.49567 10.9112 2.14566L6.72487 7.09686Z" fill="#CECECE"/>
                        </svg>
                    </div>
                </div>

            </div>

            <p class="w-100 mt-2">Выберите платежную систему</p>
            <div class="payment-select">
                <select class="ml-0" name="deposit-payment">
                    @foreach (\App\Models\Currency::where('title', 'USDT')->first()->payments()->get() as $payment)
                        <option value="{{$payment->title}}">{{$payment->title}}</option>
                    @endforeach
                </select>
                <div class="select-angle">
                    <svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.72487 7.09686C6.32541 7.56931 5.59709 7.56931 5.19763 7.09686L1.01127 2.14566C0.461693 1.49567 0.923708 0.5 1.7749 0.5L10.1476 0.499999C10.9988 0.499999 11.4608 1.49567 10.9112 2.14566L6.72487 7.09686Z" fill="#CECECE"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="subtotal">
            <p>Ваш баланс после покупки:</p>
            <p class="subtotal-amount"><span>{{ number_format(Auth::User()->getBalance('DHB') + 2000, 2, ',',' ')  }}</span> DHB</p>
        </div>

        <a onclick="deposit();" style="margin-top:40px;" class="button button-blue">Получить DHB</a>
        @else
            <p style="margin-top: 25px;margin-bottom: -15px;font-weight: 500;color: #e93878;">Вы уже владеете максимальным количеством DHB</p>
        @endif
    </div>


    <div class="assignee-section">
        <h2>Заявка @if (count(Auth::user()->orders()->notCompleted()->get()) != 0)#{{Auth::user()->orders()->notCompleted()->first()->id}} @endif</h2>
        <p>Ожидайте подтверждения оплаты в течение <strong>24 часов.</strong></p>
    </div>
</div>

