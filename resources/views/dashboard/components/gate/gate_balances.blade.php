<div class="swiper">
    <!-- Additional required wrapper -->
    <div class="swiper-wrapper">
        @foreach ($currency::payableCurrencies()->get() as $currency)
            <div class="swiper-slide">
                <div class="total-amount">
                    <p class="total-amount-title">{{number_format($user->getBalance($currency->title.'_gate'), $currency->decimal_places, '.', ' ')}} <span>{{$currency->title}}</span></p>
                    <p class="total-currency">≈ $ <span>{{ number_format($user->getBalance($currency->title.'_gate') * $rates::getRates($currency->title), 2, '.', ' ') }}</span></p>
                </div>
            </div>
        @endforeach
    </div>
</div>


<div class="balance-items">

    <div class="balances-gate">
        <div class="progress w-100">
            <div class="progress-bar bg-success" role="progressbar" style="width: {{($user->getBalanceInner() - $user->getBalanceFrozen()) * 100 / $user->getBalanceInner()}}%; max-width:100%;" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <div class="col-12">
            <div class="row justify-content-between">
                <div class="col-6">
                    <div class="row">
                        <div class="balance-item balance-available"><span class="balance-color bg-success"></span><span class="balance-amount">$ <span>{{ number_format($user->getBalanceInner() - $user->getBalanceFrozen(), 2, '.', ' ') }}</span></span></div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row justify-content-end">
                        <div class="balance-item balance-frozen"><span class="balance-color bg-dark"></span><span class="balance-amount">$ <span>{{number_format($user->getBalanceFrozen(), 2, '.', ' ') }}</span></span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="gate-controls col-12">
            <div class="row align-items-center">
                <div class="col-6">
                    <div class="row">
                        <a class="gate-action active" data-action="deposit">Принять</a>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <a class="gate-action" data-action="withdraw">Отправить</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
