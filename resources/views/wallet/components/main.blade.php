


        <p><strong>1-й этап </strong></p>
        <p>Цена 1 DHB = <strong>${{Rate::getRates('DHB')}}</strong></p>
        <div class="progress-labels w-100 d-flex justify-content-end align-items-center" style="padding-left:calc(50% - 10px - {{($balances['frozen'] / 2000000) * 100 }}%)">
            <span class="mobile-visible">$0.05</span>
            <span>$0.06</span>
            <span>$0.07</span>
            <span>$0.08</span>
            <span>$0.09</span>
            <span>$0.10</span>
            <span class="frozen-label" style="min-width: calc({{($balances['frozen'] / 2000000) * 100 }}% + 15px)"><svg width="18" height="22" viewBox="0 0 20 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_624_573)"><path d="M17.3863 10.8879C17.2546 10.7263 17.0773 10.6099 16.8828 10.5577C16.7925 10.5335 16.6949 10.5227 16.5979 10.5235C16.2262 10.5349 15.8331 10.5291 15.4246 10.5115C15.7456 9.36894 16.1107 8.06214 16.166 7.7861C16.644 5.41879 15.2208 2.92099 12.9252 2.09538C12.7822 2.04558 12.6348 1.99841 12.4933 1.95668C11.2188 1.59987 9.97632 1.70708 8.81045 2.27879C7.64553 2.84692 6.7038 3.8882 6.28852 5.06289C6.20166 5.3037 5.83233 6.68206 5.52196 7.85425C5.16186 7.66973 4.82547 7.48008 4.51627 7.28624C4.43361 7.23348 4.34616 7.19856 4.25237 7.17343C4.05437 7.12038 3.84357 7.12896 3.65125 7.20755C3.36564 7.31473 3.15301 7.55246 3.07455 7.84527L0.247158 18.3973C0.110332 18.9079 0.417145 19.4302 0.931256 19.568L13.5582 22.9514C14.0723 23.0891 14.6002 22.7866 14.736 22.2795L17.5634 11.7276C17.6419 11.4347 17.5766 11.1226 17.3863 10.8879ZM7.52416 8.74667C7.94052 7.26226 8.55946 5.25804 9.03681 4.79655C9.79672 4.05866 10.7995 3.77621 11.7848 4.01727C11.8195 4.02658 11.8543 4.03588 11.889 4.04519C12.8796 4.32211 13.6156 5.0628 13.9102 6.07558C14.1066 6.75971 13.6632 8.7344 13.2479 10.2842C12.3189 10.1386 11.3433 9.93074 10.3533 9.66547C9.36074 9.3957 8.40497 9.08602 7.52416 8.74667Z" fill="black"/></g><defs><clipPath id="clip0_624_573"><rect width="15" height="20" fill="white" transform="translate(5.17676) rotate(15)"/></clipPath></defs></svg></span>
        </div>
        <div class="progress w-100">
            <div class="progress-bar bg-success" role="progressbar" style="width: calc({{($balances['sold'] / 2000000) * 100 }}% + 10px)" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
            <div class="progress-bar bg-blue" role="progressbar" style="width: calc(10% + 10px); margin-left:calc(50% - 10px - {{($balances['frozen'] / 2000000) * 100 }}%)" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
            <div class="progress-bar bg-green" role="progressbar" style="width: calc(10% + 10px)" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
            <div class="progress-bar bg-yellow" role="progressbar" style="width: calc(10% + 10px)" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
            <div class="progress-bar bg-orange" role="progressbar" style="width: calc(10% + 10px)" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
            <div class="progress-bar bg-red" role="progressbar" style="width: calc(10% + 10px)" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <p style="margin-top:10px; font-size:18px;">Продано: {{number_format($balances['sold'], 0, ',', ' ')}} из 2 000 000 DHB
        <br/>Заморожено: {{number_format($balances['frozen'], 0, ',', ' ')}} DHB
        </p>
        <p class="our_balance"><strong>Ваш баланс</strong></p>
        <p>{{ number_format(Auth::User()->getWallet('DHB')->balanceFloat, 2, ',',' ') }} DHB = {{ number_format((Auth::User()->getWallet('DHB')->balanceFloat * Rate::getRates('DHB')), 2, ',' , ' ')}} USD</p>
        <a onclick="$('#deposit-tab').click()" style="margin-top:40px;" class="button button-orange">Получить DHB</a>








