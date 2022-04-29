<div class="swiper">
    <!-- Additional required wrapper -->
    <div class="swiper-wrapper">
        @foreach ($visibleWallets as $visibleWallet)
            <div class="swiper-slide">
                <div class="total-amount">
                    <p class="total-amount-title">{{$user->getBalance($visibleWallet)}} <span>{{$visibleWallet}}</span></p>
                    <p class="total-currency">≈ $ <span>{{ number_format($user->getBalance($visibleWallet) * $rates::getRates($visibleWallet), 2, ',', ' ') }}</span></p>
                </div>
            </div>
        @endforeach

    </div>
    <div class="swiper-pagination"></div>
</div>


<div class="balance-items">
    @foreach ($visibleWallets as $visibleWallet)
    <div class="balance-item d-flex justify-content-between w-100">
        <div class="balance-item-currency d-flex align-items-center">
            <div class="balance-item-currency-icon">
                <div class="icon-wrapper">
                    {!! $currency::where('title', $visibleWallet)->first()->icon !!}
                </div>
            </div>
            <div class="balance-item-currency-text">
                <div class="balance-item-currency-title">{{$visibleWallet}}</div>
                <div class="balance-item-currency-description">{{$currency::where('title', $visibleWallet)->first()->subtitle}}</div>
            </div>
        </div>
        <div class="balance-item-amount">
            <div class="balance-item-amount-title">{{number_format($user->getBalance($visibleWallet), $user->getWallet($visibleWallet)->decimal_places, '.', ' ')}}</div>
            <div class="balance-item-amount-description">${{number_format($user->getBalance($visibleWallet) * Rate::getRates($visibleWallet), 2, '.', ' ')}}</div>
        </div>
    </div>
    @endforeach
</div>
