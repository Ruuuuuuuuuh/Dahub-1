<div class="balance-items">

    <div class="balance-item d-flex justify-content-between w-100">
        <div class="balance-item-currency d-flex align-items-center">
            <div class="balance-item-currency-icon">
                <div class="icon-wrapper">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g opacity="0.9">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5 12.2199L12.3646 16.5731L12.3647 16.5732L12.3647 16.5732H12.3647L19.7294 12.2199L12.3647 8.54488e-05V0L12.3647 4.27244e-05L12.3647 0L12.3646 0.000166947L5 12.2199ZM12.3647 23.9946L12.3646 23.9944L5 13.6165L12.3647 17.9675L19.7338 13.6166L12.3647 23.9946L12.3647 23.9946Z" fill="white"/>
                        </g>
                    </svg>
                </div>
            </div>
            <div class="balance-item-currency-text">
                <div class="balance-item-currency-title">ETH</div>
                <div class="balance-item-currency-description">Ethereum</div>
            </div>
        </div>
        <div class="balance-item-amount">
            <div class="balance-item-amount-title">{{number_format(Auth::User()->getWallet('ETH')->balanceFloat, 5, '.', ' ')}}</div>
            <div class="balance-item-amount-description">${{number_format(Auth::User()->getWallet('ETH')->balanceFloat / Rate::getRates('ETH'), 2, '.', ' ')}}</div>
        </div>
    </div>
    <div class="balance-item d-flex justify-content-between w-100">
        <div class="balance-item-currency d-flex">
            <div class="balance-item-currency-icon">
                <div class="icon-wrapper">
                    <svg width="24" height="19" viewBox="0 0 24 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.9" d="M7.96344 8.19798C-3.97489 7.0748 0.215383 2.71116 3.32515 1.6138C15.8301 -2.77565 28.5063 2.05275 22.4318 12.8973C21.9179 13.8139 21.1404 13.3749 20.4157 12.6778C18.4128 10.7671 14.7628 8.84349 7.96344 8.19798Z" fill="white"/>
                        <path opacity="0.9" d="M17.8326 9.38414C17.9248 9.42287 18.0302 9.4616 18.1225 9.50033C19.2162 9.9651 19.9014 10.7397 20.2308 11.7467C20.5207 12.6375 19.9409 14.432 18.755 15.3874C17.5032 16.4073 15.8956 17.156 14.8282 17.5304C11.3363 18.744 8.00257 18.318 7.33054 15.8909C6.52675 12.999 13.1548 8.29969 17.2528 9.2034C17.4504 9.25504 17.6481 9.31959 17.8326 9.38414Z" fill="white"/>
                        <path opacity="0.9" d="M7.80542 6.37925C10.4803 6.96021 7.80542 12.3954 5.76299 11.8273C2.70593 10.9624 4.86695 5.73375 7.80542 6.37925Z" fill="white"/>
                    </svg>
                </div>
            </div>
            <div class="balance-item-currency-text">
                <div class="balance-item-currency-title">DHB</div>
                <div class="balance-item-currency-description">Da·Hub</div>
            </div>
        </div>
        <div class="balance-item-amount">
            <div class="balance-item-amount-title">{{number_format(Auth::User()->getWallet('DHB')->balanceFloat, 2, '.', ' ')}}</div>
            <div class="balance-item-amount-description">${{number_format(Auth::User()->getWallet('DHB')->balanceFloat / Rate::getRates('USDT'), 2, '.', ' ') }}</div>
        </div>
    </div>
    <div class="balance-item d-flex justify-content-between w-100">
        <div class="balance-item-currency d-flex">
            <div class="balance-item-currency-icon">
                <div class="icon-wrapper">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.14 6.99402H9.44604V9.71402H11.14C11.89 9.71402 12.5 9.10402 12.5 8.35402C12.5 7.60402 11.89 6.99402 11.14 6.99402Z" fill="white" fill-opacity="0.9"/>
                        <path d="M10 0C4.478 0 0 4.478 0 10C0 15.522 4.478 20 10 20C15.522 20 20 15.522 20 10C20 4.478 15.522 0 10 0ZM11.14 11.676H9.446V12.39H11.476C11.648 12.39 11.788 12.53 11.788 12.702V14.04C11.788 14.212 11.648 14.352 11.476 14.352H9.444V15.378C9.444 15.55 9.304 15.69 9.132 15.69H7.794C7.622 15.69 7.482 15.55 7.482 15.378V14.352H6.79C6.618 14.352 6.478 14.212 6.478 14.04V12.702C6.478 12.53 6.618 12.39 6.79 12.39H7.482V11.676H6.79C6.618 11.676 6.478 11.536 6.478 11.364V10.026C6.478 9.854 6.618 9.714 6.79 9.714H7.482V5.344C7.482 5.172 7.622 5.032 7.794 5.032H11.14C12.972 5.032 14.462 6.522 14.462 8.354C14.462 10.188 12.978 11.676 11.14 11.676Z" fill="white" fill-opacity="0.9"/>
                    </svg>
                </div>
            </div>
            <div class="balance-item-currency-text">
                <div class="balance-item-currency-title">RUB</div>
                <div class="balance-item-currency-description">Рубли</div>
            </div>
        </div>
        <div class="balance-item-amount">
            <div class="balance-item-amount-title">{{number_format(Auth::User()->getWallet('RUB')->balanceFloat, 2, '.', ' ')}}</div>
            <div class="balance-item-amount-description">${{number_format(Auth::User()->getWallet('ETH')->balanceFloat * 72.73, 2, '.', ' ')}}</div>
        </div>
    </div>
    <div class="balance-item d-flex justify-content-between w-100">
        {{--<div class="balance-item-currency d-flex">
            <div class="balance-item-currency-icon">
                <div class="icon-wrapper">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#hft-icon)">
                            <path d="M19.8093 8.12152L12.1374 13.1426L9.99989 19.4442L7.87341 13.1617L0.190448 8.12152C0.190448 8.12152 -0.936313 12.4697 2.28103 16.3248C5.18631 19.8147 9.11064 20.0027 9.99989 20C10.8891 20.0027 14.8162 19.8147 17.7188 16.3248C20.9361 12.4697 19.8093 8.12152 19.8093 8.12152Z" fill="white" fill-opacity="0.9"/>
                            <path d="M9.98617 0L5.66968 8.78082L9.98617 11.6142L14.3303 8.76175L9.98617 0Z" fill="white" fill-opacity="0.9"/>
                        </g>
                        <defs>
                            <clipPath id="hft-icon">
                                <rect width="20" height="20" fill="white"/>
                            </clipPath>
                        </defs>
                    </svg>
                </div>
            </div>
            <div class="balance-item-currency-text">
                <div class="balance-item-currency-title">HFT</div>
                <div class="balance-item-currency-description">Harvest</div>
            </div>
        </div>
        <div class="balance-item-amount">
            <div class="balance-item-amount-title">{{number_format(Auth::User()->getWallet('HFT')->balanceFloat, 2, '.', ' ')}}</div>
            <div class="balance-item-amount-description">$0.00</div>
        </div>--}}
    </div>
</div>
