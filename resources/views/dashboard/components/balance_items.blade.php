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
            <div class="balance-item-amount-title">{{number_format(Auth::User()->getBalance('ETH'), 5, '.', ' ')}}</div>
            <div class="balance-item-amount-description">${{number_format(Auth::User()->getBalance('ETH') / Rate::getRates('ETH'), 2, '.', ' ')}}</div>
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
            <div class="balance-item-amount-title">{{number_format(Auth::User()->getBalance('DHB'), 2, '.', ' ')}}</div>
            <div class="balance-item-amount-description">${{number_format(Auth::User()->getBalance('DHB') / Rate::getRates('USDT'), 2, '.', ' ') }}</div>
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
            <div class="balance-item-amount-title">{{number_format(Auth::User()->getBalance('RUB'), 2, '.', ' ')}}</div>
            <div class="balance-item-amount-description">${{number_format(Auth::User()->getBalance('RUB') / 72.73, 2, '.', ' ')}}</div>
        </div>
    </div>
    <div class="balance-item d-flex justify-content-between w-100">
        <div class="balance-item-currency d-flex">
            <div class="balance-item-currency-icon">
                <div class="icon-wrapper">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_525:314)">
                            <rect width="21" height="21" fill="white"/>
                            <path d="M14 11.5965C14 12.3365 13.7156 12.9737 13.1469 13.5081C12.5781 14.0425 11.8393 14.3726 10.9304 14.4983V15.7679C10.9304 15.8356 10.9047 15.8912 10.8533 15.9347C10.8018 15.9782 10.7361 16 10.6561 16H9.49854C9.42423 16 9.35993 15.977 9.30562 15.9311C9.25132 15.8851 9.22417 15.8307 9.22417 15.7679V14.4983C8.8469 14.4548 8.4825 14.3798 8.13096 14.2734C7.77942 14.167 7.48932 14.0594 7.26068 13.9506C7.03203 13.8418 6.82053 13.7257 6.62618 13.6024C6.43184 13.4791 6.29894 13.3884 6.22748 13.3304C6.15603 13.2723 6.10602 13.2288 6.07744 13.1998C5.98026 13.0982 5.97455 12.9991 6.06029 12.9023L6.94343 11.923C6.98344 11.8746 7.04918 11.8456 7.14064 11.8359C7.22638 11.8263 7.29497 11.848 7.34642 11.9012L7.36357 11.9157C8.00949 12.3945 8.704 12.6968 9.4471 12.8225C9.65859 12.8612 9.87009 12.8806 10.0816 12.8806C10.5446 12.8806 10.9519 12.7766 11.3034 12.5686C11.655 12.3607 11.8307 12.0657 11.8307 11.6836C11.8307 11.5482 11.7879 11.42 11.7021 11.2991C11.6164 11.1782 11.5206 11.0766 11.4149 10.9944C11.3091 10.9122 11.1419 10.8215 10.9133 10.7224C10.6846 10.6232 10.496 10.5459 10.3474 10.4902C10.1988 10.4346 9.97012 10.356 9.66145 10.2545C9.43852 10.1771 9.26275 10.1166 9.13414 10.0731C9.00553 10.0296 8.82976 9.9655 8.60683 9.88086C8.3839 9.79622 8.20527 9.72126 8.07094 9.65597C7.93661 9.59068 7.77513 9.50484 7.5865 9.39844C7.39786 9.29204 7.24496 9.18927 7.12778 9.09012C7.01059 8.99098 6.88627 8.87249 6.7548 8.73465C6.62333 8.59682 6.52187 8.45657 6.45041 8.3139C6.37896 8.17122 6.31894 8.01042 6.27036 7.83147C6.22177 7.65253 6.19747 7.46391 6.19747 7.26563C6.19747 6.59821 6.47757 6.01302 7.03775 5.51004C7.59793 5.00707 8.32674 4.68304 9.22417 4.53795V3.23214C9.22417 3.16927 9.25132 3.11486 9.30562 3.06892C9.35993 3.02297 9.42423 3 9.49854 3H10.6561C10.7361 3 10.8018 3.02176 10.8533 3.06529C10.9047 3.10882 10.9304 3.16443 10.9304 3.23214V4.50893C11.2563 4.53795 11.5721 4.59356 11.8779 4.67578C12.1837 4.758 12.4323 4.83901 12.6238 4.91881C12.8153 4.99861 12.9968 5.08929 13.1683 5.19085C13.3398 5.29241 13.4513 5.36254 13.5027 5.40123C13.5541 5.43992 13.597 5.47377 13.6313 5.50279C13.7285 5.58984 13.7428 5.68173 13.6742 5.77846L12.9797 6.83761C12.9339 6.91016 12.8682 6.94885 12.7825 6.95368C12.7024 6.96819 12.6253 6.95126 12.551 6.9029C12.5338 6.88839 12.4924 6.85938 12.4266 6.81585C12.3609 6.77232 12.2494 6.70824 12.0922 6.62361C11.935 6.53897 11.7678 6.46159 11.5906 6.39146C11.4134 6.32134 11.2005 6.25846 10.9519 6.20285C10.7032 6.14723 10.4589 6.11942 10.2188 6.11942C9.67574 6.11942 9.23274 6.2234 8.88977 6.43136C8.54681 6.63932 8.37532 6.90774 8.37532 7.23661C8.37532 7.36235 8.39962 7.47842 8.4482 7.58482C8.49679 7.69122 8.5811 7.79157 8.70114 7.88588C8.82118 7.98019 8.93407 8.05999 9.03982 8.12528C9.14557 8.19057 9.30562 8.26553 9.51998 8.35017C9.73433 8.4348 9.90725 8.50009 10.0387 8.54604C10.1702 8.59198 10.3703 8.65848 10.6389 8.74554C10.9419 8.84226 11.1734 8.91843 11.3334 8.97405C11.4935 9.02967 11.7107 9.1143 11.9851 9.22796C12.2594 9.34161 12.4752 9.44438 12.6324 9.53627C12.7896 9.62816 12.9668 9.74907 13.164 9.899C13.3612 10.0489 13.5127 10.2025 13.6184 10.3597C13.7242 10.5168 13.8142 10.7018 13.8885 10.9146C13.9628 11.1274 14 11.3547 14 11.5965Z" fill="#22324E"/>
                        </g>
                        <defs>
                            <clipPath id="clip0_525:314">
                                <rect width="20" height="20" rx="10" fill="white"/>
                            </clipPath>
                        </defs>
                    </svg>

                </div>
            </div>
            <div class="balance-item-currency-text">
                <div class="balance-item-currency-title">USD</div>
                <div class="balance-item-currency-description">Dollars (USA)</div>
            </div>
        </div>
        <div class="balance-item-amount">
            <div class="balance-item-amount-title">${{number_format(Auth::User()->getWallet('USD')->balanceFloat, 2, '.', ' ')}}</div>
            <div class="balance-item-amount-description">${{number_format(Auth::User()->getWallet('USD')->balanceFloat, 2, '.', ' ')}}</div>
        </div>
    </div>
</div>
