<h2>Партнерская программа</h2>
<p style="margin-top:35px;">Партнерская программа в проекте имеет три уровня:</p>
<p><strong>1-й уровень</strong> – 9 процентов вознаграждения</p>
<p><strong>2-й уровень</strong> – 6 процентов вознаграждения</p>
<p><strong>3-й уровень</strong> – 3 процента вознаграждения</p>
<p style="margin-top:35px;">Ваш баланс</p>
@if (Auth::User()->getWallet('USDT')->balanceFloat > 0) <p class="balance-amount">{{ number_format((Auth::User()->getWallet('USDT')->balanceFloat), 2, ',' , ' ')}} USDT</p>@endif
@if (Auth::User()->getWallet('BTC')->balanceFloat > 0) <p class="balance-amount">{{ number_format((Auth::User()->getWallet('BTC')->balanceFloat), 7, ',' , ' ')}} BTC</p>@endif
@if (Auth::User()->getWallet('ETH')->balanceFloat > 0) <p class="balance-amount">{{ number_format((Auth::User()->getWallet('ETH')->balanceFloat), 5, ',' , ' ')}} ETH</p>@endif
<hr />
<h3>Реферальная ссылка</h3>
<a class="ref-link copy-link" data-toggle="popover" data-placement="right" data-content="Ссылка скопирована в буфер обмена.">
    <span>{{ Auth::user()->getReferralLink() }}</span>
    <svg width="33" height="36" viewBox="0 0 33 36" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g opacity="0.9">
            <path d="M30.5379 5.84501H29.9899C27.6071 5.84501 25.6755 3.91338 25.6755 1.53059C25.6755 0.685295 24.9902 0 24.1449 0H1.53059C0.685295 0 0 0.685295 0 1.53059V28.6242C0 29.4695 0.685295 30.1548 1.53059 30.1548H2.07854C4.46127 30.1548 6.39285 32.0864 6.39285 34.4691C6.39285 35.3144 7.07815 35.9997 7.92344 35.9997H30.5379C31.3832 35.9997 32.0685 35.3144 32.0685 34.4691V7.37559C32.0685 6.5303 31.3832 5.84501 30.5379 5.84501ZM4.72707 27.0936C3.80702 27.0936 3.06117 26.3478 3.06117 25.4277V8.06117C3.06117 5.29975 5.29975 3.06117 8.06117 3.06117H21.2223C21.991 3.06117 22.6142 3.68436 22.6142 4.45309C22.6142 5.22182 21.991 5.84501 21.2223 5.84501H7.92354C7.07825 5.84501 6.39296 6.5303 6.39296 7.37559V25.4277C6.39296 26.3478 5.64711 27.0936 4.72707 27.0936ZM29.0073 27.9386C29.0073 30.7001 26.7687 32.9386 24.0073 32.9386H14.4541C11.6927 32.9386 9.45413 30.7001 9.45413 27.9386V13.9062C9.45413 11.1448 11.6927 8.90618 14.4541 8.90618H24.0073C26.7687 8.90618 29.0073 11.1448 29.0073 13.9062V27.9386Z" fill="url(#paint0_linear)"/>
        </g>
        <defs>
            <linearGradient id="paint0_linear" x1="16.0342" y1="-16.1999" x2="33.7999" y2="-11.6723" gradientUnits="userSpaceOnUse">
                <stop stop-color="#FF9134"/>
                <stop offset="1" stop-color="#E72269"/>
            </linearGradient>
        </defs>
    </svg>
</a>
