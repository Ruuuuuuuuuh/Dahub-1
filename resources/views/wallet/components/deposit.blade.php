<div class="deposit-section @if (count(Auth::user()->orders()->notCompleted()->get()) != 0) {{Auth::user()->orders()->notCompleted()->first()->status}} {{Auth::user()->orders()->notCompleted()->first()->currency}} @endif" @if (count(Auth::user()->orders()->notCompleted()->get()) != 0) data-id="{{Auth::user()->orders()->notCompleted()->first()->id}}" @endif>
    <div class="new-order">
        <h2>Получить DHB <span class="deposit-status">Шаг 1 из 3</span></h2>
        <div class="deposit-block form-inline">
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
        </div>

        <div class="subtotal">
            <p><strong>Ваш баланс после покупки:</strong></p>
            <p class="subtotal-amount"><span>{{ number_format(Auth::User()->getBalance('DHB') + 2000, 2, ',',' ')  }}</span> DHB</p>
        </div>

        <a onclick="deposit();" style="margin-top:40px;" class="button button-orange">Получить DHB</a>
    </div>

    <div class="created-order">
        <h2>Получить DHB <span class="deposit-status">Шаг 2 из 3</span></h2>

        <div class="created-block form-inline">
            <p>Отправьте <strong><span class="step2-amount">@if (count(Auth::user()->orders()->notCompleted()->get()) != 0){{number_format(Rate::getRates('DHB') * Auth::user()->orders()->notCompleted()->first()->amount / Auth::user()->orders()->notCompleted()->first()->rate, 5, ',', ' ') }} @endif </span> <span class="step2-currency">@if (count(Auth::user()->orders()->notCompleted()->get()) != 0) {{Auth::user()->orders()->notCompleted()->first()->currency}}@endif</span> </strong> на один из этих адресов:</p>
            <div class="wallet-link-section USDT w-100">
                <div class="col-12">
                    <div class="row flex-wrap flex-column">
                        <ul class="nav nav-tabs" id="usdt-wallet-links" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="usdt-erc20-tab" data-toggle="tab" href="#usdt-erc20" role="tab" aria-controls="usdt-erc20" aria-selected="true">ERC20</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="usdt-bsc-tab" data-toggle="tab" href="#usdt-bsc" role="tab" aria-controls="usdt-bsc" aria-selected="false">BEP20 (BSC)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="usdt-trc20-tab" data-toggle="tab" href="#usdt-trc20" role="tab" aria-controls="usdt-trc20" aria-selected="false">TRC20</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="usdt-wallet-content">
                            <div class="tab-pane fade show active" id="usdt-erc20" role="tabpanel" aria-labelledby="usdt-erc20-tab">
                                <div class="col-12">
                                    <div class="row align-items-center">
                                        <div class="col-12 col-md-7">
                                            <div class="row">
                                                <a class="wallet-link copy-link" data-toggle="popover" data-placement="bottom" data-content="Ссылка скопирована в буфер обмена.">
                                                    <span>0xdbcf4c1b477ff67bcf0cc9fefc0044692c513a14</span>
                                                    <svg width="33" height="36" viewBox="0 0 33 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g opacity="0.9">
                                                            <path d="M30.5379 5.84501H29.9899C27.6071 5.84501 25.6755 3.91338 25.6755 1.53059C25.6755 0.685295 24.9902 0 24.1449 0H1.53059C0.685295 0 0 0.685295 0 1.53059V28.6242C0 29.4695 0.685295 30.1548 1.53059 30.1548H2.07854C4.46127 30.1548 6.39285 32.0864 6.39285 34.4691C6.39285 35.3144 7.07815 35.9997 7.92344 35.9997H30.5379C31.3832 35.9997 32.0685 35.3144 32.0685 34.4691V7.37559C32.0685 6.5303 31.3832 5.84501 30.5379 5.84501ZM4.72707 27.0936C3.80702 27.0936 3.06117 26.3478 3.06117 25.4277V8.06117C3.06117 5.29975 5.29975 3.06117 8.06117 3.06117H21.2223C21.991 3.06117 22.6142 3.68436 22.6142 4.45309C22.6142 5.22182 21.991 5.84501 21.2223 5.84501H7.92354C7.07825 5.84501 6.39296 6.5303 6.39296 7.37559V25.4277C6.39296 26.3478 5.64711 27.0936 4.72707 27.0936ZM29.0073 27.9386C29.0073 30.7001 26.7687 32.9386 24.0073 32.9386H14.4541C11.6927 32.9386 9.45413 30.7001 9.45413 27.9386V13.9062C9.45413 11.1448 11.6927 8.90618 14.4541 8.90618H24.0073C26.7687 8.90618 29.0073 11.1448 29.0073 13.9062V27.9386Z" fill="url(#paint1_linear)"/>
                                                        </g>
                                                        <defs>
                                                            <linearGradient id="paint1_linear" x1="16.0342" y1="-16.1999" x2="33.7999" y2="-11.6723" gradientUnits="userSpaceOnUse">
                                                                <stop stop-color="#FF9134"/>
                                                                <stop offset="1" stop-color="#E72269"/>
                                                            </linearGradient>
                                                        </defs>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <div class="row justify-content-center">
                                                <div class="qr-code"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="usdt-bsc" role="tabpanel" aria-labelledby="usdt-bsc-tab">
                                <div class="col-12">
                                    <div class="row align-items-center">
                                        <div class="col-12 col-md-7">
                                            <div class="row">
                                                <a class="wallet-link copy-link" data-toggle="popover" data-placement="bottom" data-content="Ссылка скопирована в буфер обмена.">
                                                    <span>0xdbcf4c1b477ff67bcf0cc9fefc0044692c513a14</span>
                                                    <svg width="33" height="36" viewBox="0 0 33 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g opacity="0.9">
                                                            <path d="M30.5379 5.84501H29.9899C27.6071 5.84501 25.6755 3.91338 25.6755 1.53059C25.6755 0.685295 24.9902 0 24.1449 0H1.53059C0.685295 0 0 0.685295 0 1.53059V28.6242C0 29.4695 0.685295 30.1548 1.53059 30.1548H2.07854C4.46127 30.1548 6.39285 32.0864 6.39285 34.4691C6.39285 35.3144 7.07815 35.9997 7.92344 35.9997H30.5379C31.3832 35.9997 32.0685 35.3144 32.0685 34.4691V7.37559C32.0685 6.5303 31.3832 5.84501 30.5379 5.84501ZM4.72707 27.0936C3.80702 27.0936 3.06117 26.3478 3.06117 25.4277V8.06117C3.06117 5.29975 5.29975 3.06117 8.06117 3.06117H21.2223C21.991 3.06117 22.6142 3.68436 22.6142 4.45309C22.6142 5.22182 21.991 5.84501 21.2223 5.84501H7.92354C7.07825 5.84501 6.39296 6.5303 6.39296 7.37559V25.4277C6.39296 26.3478 5.64711 27.0936 4.72707 27.0936ZM29.0073 27.9386C29.0073 30.7001 26.7687 32.9386 24.0073 32.9386H14.4541C11.6927 32.9386 9.45413 30.7001 9.45413 27.9386V13.9062C9.45413 11.1448 11.6927 8.90618 14.4541 8.90618H24.0073C26.7687 8.90618 29.0073 11.1448 29.0073 13.9062V27.9386Z" fill="url(#paint2_linear)"/>
                                                        </g>
                                                        <defs>
                                                            <linearGradient id="paint2_linear" x1="16.0342" y1="-16.1999" x2="33.7999" y2="-11.6723" gradientUnits="userSpaceOnUse">
                                                                <stop stop-color="#FF9134"/>
                                                                <stop offset="1" stop-color="#E72269"/>
                                                            </linearGradient>
                                                        </defs>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <div class="row justify-content-center">
                                                <div class="qr-code"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="usdt-trc20" role="tabpanel" aria-labelledby="usdt-trc20-tab">
                                <div class="col-12">
                                    <div class="row align-items-center">
                                        <div class="col-12 col-md-7">
                                            <div class="row">
                                                <a class="wallet-link copy-link" data-toggle="popover" data-placement="bottom" data-content="Ссылка скопирована в буфер обмена.">
                                                    <span>TD3WszPT87kXEpMUZLRV5L8kYEa9Wdk4w2</span>
                                                    <svg width="33" height="36" viewBox="0 0 33 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g opacity="0.9">
                                                            <path d="M30.5379 5.84501H29.9899C27.6071 5.84501 25.6755 3.91338 25.6755 1.53059C25.6755 0.685295 24.9902 0 24.1449 0H1.53059C0.685295 0 0 0.685295 0 1.53059V28.6242C0 29.4695 0.685295 30.1548 1.53059 30.1548H2.07854C4.46127 30.1548 6.39285 32.0864 6.39285 34.4691C6.39285 35.3144 7.07815 35.9997 7.92344 35.9997H30.5379C31.3832 35.9997 32.0685 35.3144 32.0685 34.4691V7.37559C32.0685 6.5303 31.3832 5.84501 30.5379 5.84501ZM4.72707 27.0936C3.80702 27.0936 3.06117 26.3478 3.06117 25.4277V8.06117C3.06117 5.29975 5.29975 3.06117 8.06117 3.06117H21.2223C21.991 3.06117 22.6142 3.68436 22.6142 4.45309C22.6142 5.22182 21.991 5.84501 21.2223 5.84501H7.92354C7.07825 5.84501 6.39296 6.5303 6.39296 7.37559V25.4277C6.39296 26.3478 5.64711 27.0936 4.72707 27.0936ZM29.0073 27.9386C29.0073 30.7001 26.7687 32.9386 24.0073 32.9386H14.4541C11.6927 32.9386 9.45413 30.7001 9.45413 27.9386V13.9062C9.45413 11.1448 11.6927 8.90618 14.4541 8.90618H24.0073C26.7687 8.90618 29.0073 11.1448 29.0073 13.9062V27.9386Z" fill="url(#paint3_linear)"/>
                                                        </g>
                                                        <defs>
                                                            <linearGradient id="paint3_linear" x1="16.0342" y1="-16.1999" x2="33.7999" y2="-11.6723" gradientUnits="userSpaceOnUse">
                                                                <stop stop-color="#FF9134"/>
                                                                <stop offset="1" stop-color="#E72269"/>
                                                            </linearGradient>
                                                        </defs>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <div class="row justify-content-center">
                                                <div class="qr-code"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="wallet-link-section BTC w-100">
                <div class="col-12">
                    <div class="row flex-wrap flex-column">
                        <ul class="nav nav-tabs" id="btc-wallet-links" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="btc-bsc-tab" data-toggle="tab" href="#btc-bsc" role="tab" aria-controls="btc-bsc" aria-selected="false">BEP20 (BSC)</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="usdt-wallet-content">

                            <div class="tab-pane fade show active" id="btc-bsc" role="tabpanel" aria-labelledby="btc-bsc-tab">
                                <div class="col-12">
                                    <div class="row align-items-center">
                                        <div class="col-12 col-md-7">
                                            <div class="row">
                                                <a class="wallet-link copy-link" data-toggle="popover" data-placement="bottom" data-content="Ссылка скопирована в буфер обмена.">
                                                    <span>0xdbcf4c1b477ff67bcf0cc9fefc0044692c513a14</span>
                                                    <svg width="33" height="36" viewBox="0 0 33 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g opacity="0.9">
                                                            <path d="M30.5379 5.84501H29.9899C27.6071 5.84501 25.6755 3.91338 25.6755 1.53059C25.6755 0.685295 24.9902 0 24.1449 0H1.53059C0.685295 0 0 0.685295 0 1.53059V28.6242C0 29.4695 0.685295 30.1548 1.53059 30.1548H2.07854C4.46127 30.1548 6.39285 32.0864 6.39285 34.4691C6.39285 35.3144 7.07815 35.9997 7.92344 35.9997H30.5379C31.3832 35.9997 32.0685 35.3144 32.0685 34.4691V7.37559C32.0685 6.5303 31.3832 5.84501 30.5379 5.84501ZM4.72707 27.0936C3.80702 27.0936 3.06117 26.3478 3.06117 25.4277V8.06117C3.06117 5.29975 5.29975 3.06117 8.06117 3.06117H21.2223C21.991 3.06117 22.6142 3.68436 22.6142 4.45309C22.6142 5.22182 21.991 5.84501 21.2223 5.84501H7.92354C7.07825 5.84501 6.39296 6.5303 6.39296 7.37559V25.4277C6.39296 26.3478 5.64711 27.0936 4.72707 27.0936ZM29.0073 27.9386C29.0073 30.7001 26.7687 32.9386 24.0073 32.9386H14.4541C11.6927 32.9386 9.45413 30.7001 9.45413 27.9386V13.9062C9.45413 11.1448 11.6927 8.90618 14.4541 8.90618H24.0073C26.7687 8.90618 29.0073 11.1448 29.0073 13.9062V27.9386Z" fill="url(#paint11_linear)"/>
                                                        </g>
                                                        <defs>
                                                            <linearGradient id="paint11_linear" x1="16.0342" y1="-16.1999" x2="33.7999" y2="-11.6723" gradientUnits="userSpaceOnUse">
                                                                <stop stop-color="#FF9134"/>
                                                                <stop offset="1" stop-color="#E72269"/>
                                                            </linearGradient>
                                                        </defs>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <div class="row justify-content-center">
                                                <div class="qr-code"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="wallet-link-section ETH w-100">
                <div class="col-12">
                    <div class="row flex-wrap flex-column">
                        <ul class="nav nav-tabs" id="usdt-wallet-links" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="eth-erc20-tab" data-toggle="tab" href="#eth-erc20" role="tab" aria-controls="eth-erc20" aria-selected="true">ERC20</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="eth-bsc-tab" data-toggle="tab" href="#eth-bsc" role="tab" aria-controls="eth-bsc" aria-selected="false">BEP20 (BSC)</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="eth-wallet-content">
                            <div class="tab-pane fade show active" id="eth-erc20" role="tabpanel" aria-labelledby="eth-erc20-tab">
                                <div class="col-12">
                                    <div class="row align-items-center">
                                        <div class="col-12 col-md-7">
                                            <div class="row">
                                                <a class="wallet-link copy-link" data-toggle="popover" data-placement="bottom" data-content="Ссылка скопирована в буфер обмена.">
                                                    <span>0xdbcf4c1b477ff67bcf0cc9fefc0044692c513a14</span>
                                                    <svg width="33" height="36" viewBox="0 0 33 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g opacity="0.9">
                                                            <path d="M30.5379 5.84501H29.9899C27.6071 5.84501 25.6755 3.91338 25.6755 1.53059C25.6755 0.685295 24.9902 0 24.1449 0H1.53059C0.685295 0 0 0.685295 0 1.53059V28.6242C0 29.4695 0.685295 30.1548 1.53059 30.1548H2.07854C4.46127 30.1548 6.39285 32.0864 6.39285 34.4691C6.39285 35.3144 7.07815 35.9997 7.92344 35.9997H30.5379C31.3832 35.9997 32.0685 35.3144 32.0685 34.4691V7.37559C32.0685 6.5303 31.3832 5.84501 30.5379 5.84501ZM4.72707 27.0936C3.80702 27.0936 3.06117 26.3478 3.06117 25.4277V8.06117C3.06117 5.29975 5.29975 3.06117 8.06117 3.06117H21.2223C21.991 3.06117 22.6142 3.68436 22.6142 4.45309C22.6142 5.22182 21.991 5.84501 21.2223 5.84501H7.92354C7.07825 5.84501 6.39296 6.5303 6.39296 7.37559V25.4277C6.39296 26.3478 5.64711 27.0936 4.72707 27.0936ZM29.0073 27.9386C29.0073 30.7001 26.7687 32.9386 24.0073 32.9386H14.4541C11.6927 32.9386 9.45413 30.7001 9.45413 27.9386V13.9062C9.45413 11.1448 11.6927 8.90618 14.4541 8.90618H24.0073C26.7687 8.90618 29.0073 11.1448 29.0073 13.9062V27.9386Z" fill="url(#paint5_linear)"/>
                                                        </g>
                                                        <defs>
                                                            <linearGradient id="paint5_linear" x1="16.0342" y1="-16.1999" x2="33.7999" y2="-11.6723" gradientUnits="userSpaceOnUse">
                                                                <stop stop-color="#FF9134"/>
                                                                <stop offset="1" stop-color="#E72269"/>
                                                            </linearGradient>
                                                        </defs>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <div class="row justify-content-center">
                                                <div class="qr-code"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="usdt-bsc" role="tabpanel" aria-labelledby="usdt-bsc-tab">
                                <div class="col-12">
                                    <div class="row align-items-center">
                                        <div class="col-12 col-md-7">
                                            <div class="row">
                                                <a class="wallet-link copy-link" data-toggle="popover" data-placement="bottom" data-content="Ссылка скопирована в буфер обмена.">
                                                    <span>0xdbcf4c1b477ff67bcf0cc9fefc0044692c513a14</span>
                                                    <svg width="33" height="36" viewBox="0 0 33 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g opacity="0.9">
                                                            <path d="M30.5379 5.84501H29.9899C27.6071 5.84501 25.6755 3.91338 25.6755 1.53059C25.6755 0.685295 24.9902 0 24.1449 0H1.53059C0.685295 0 0 0.685295 0 1.53059V28.6242C0 29.4695 0.685295 30.1548 1.53059 30.1548H2.07854C4.46127 30.1548 6.39285 32.0864 6.39285 34.4691C6.39285 35.3144 7.07815 35.9997 7.92344 35.9997H30.5379C31.3832 35.9997 32.0685 35.3144 32.0685 34.4691V7.37559C32.0685 6.5303 31.3832 5.84501 30.5379 5.84501ZM4.72707 27.0936C3.80702 27.0936 3.06117 26.3478 3.06117 25.4277V8.06117C3.06117 5.29975 5.29975 3.06117 8.06117 3.06117H21.2223C21.991 3.06117 22.6142 3.68436 22.6142 4.45309C22.6142 5.22182 21.991 5.84501 21.2223 5.84501H7.92354C7.07825 5.84501 6.39296 6.5303 6.39296 7.37559V25.4277C6.39296 26.3478 5.64711 27.0936 4.72707 27.0936ZM29.0073 27.9386C29.0073 30.7001 26.7687 32.9386 24.0073 32.9386H14.4541C11.6927 32.9386 9.45413 30.7001 9.45413 27.9386V13.9062C9.45413 11.1448 11.6927 8.90618 14.4541 8.90618H24.0073C26.7687 8.90618 29.0073 11.1448 29.0073 13.9062V27.9386Z" fill="url(#paint6_linear)"/>
                                                        </g>
                                                        <defs>
                                                            <linearGradient id="paint6_linear" x1="16.0342" y1="-16.1999" x2="33.7999" y2="-11.6723" gradientUnits="userSpaceOnUse">
                                                                <stop stop-color="#FF9134"/>
                                                                <stop offset="1" stop-color="#E72269"/>
                                                            </linearGradient>
                                                        </defs>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <div class="row justify-content-center">
                                                <div class="qr-code"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="usdt-trc20" role="tabpanel" aria-labelledby="usdt-trc20-tab">
                                <div class="col-12">
                                    <div class="row align-items-center">
                                        <div class="col-12 col-md-7">
                                            <div class="row">
                                                <a class="wallet-link copy-link" data-toggle="popover" data-placement="bottom" data-content="Ссылка скопирована в буфер обмена.">
                                                    <span>TD3WszPT87kXEpMUZLRV5L8kYEa9Wdk4w2</span>
                                                    <svg width="33" height="36" viewBox="0 0 33 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g opacity="0.9">
                                                            <path d="M30.5379 5.84501H29.9899C27.6071 5.84501 25.6755 3.91338 25.6755 1.53059C25.6755 0.685295 24.9902 0 24.1449 0H1.53059C0.685295 0 0 0.685295 0 1.53059V28.6242C0 29.4695 0.685295 30.1548 1.53059 30.1548H2.07854C4.46127 30.1548 6.39285 32.0864 6.39285 34.4691C6.39285 35.3144 7.07815 35.9997 7.92344 35.9997H30.5379C31.3832 35.9997 32.0685 35.3144 32.0685 34.4691V7.37559C32.0685 6.5303 31.3832 5.84501 30.5379 5.84501ZM4.72707 27.0936C3.80702 27.0936 3.06117 26.3478 3.06117 25.4277V8.06117C3.06117 5.29975 5.29975 3.06117 8.06117 3.06117H21.2223C21.991 3.06117 22.6142 3.68436 22.6142 4.45309C22.6142 5.22182 21.991 5.84501 21.2223 5.84501H7.92354C7.07825 5.84501 6.39296 6.5303 6.39296 7.37559V25.4277C6.39296 26.3478 5.64711 27.0936 4.72707 27.0936ZM29.0073 27.9386C29.0073 30.7001 26.7687 32.9386 24.0073 32.9386H14.4541C11.6927 32.9386 9.45413 30.7001 9.45413 27.9386V13.9062C9.45413 11.1448 11.6927 8.90618 14.4541 8.90618H24.0073C26.7687 8.90618 29.0073 11.1448 29.0073 13.9062V27.9386Z" fill="url(#paint7_linear)"/>
                                                        </g>
                                                        <defs>
                                                            <linearGradient id="paint7_linear" x1="16.0342" y1="-16.1999" x2="33.7999" y2="-11.6723" gradientUnits="userSpaceOnUse">
                                                                <stop stop-color="#FF9134"/>
                                                                <stop offset="1" stop-color="#E72269"/>
                                                            </linearGradient>
                                                        </defs>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <div class="row justify-content-center">
                                                <div class="qr-code"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <a onclick="assignee();" style="margin-top:40px;" class="button button-blue">Переведено! Далее...</a>
            <a onclick="decline();" style="margin-top:40px;" class="button button-danger">Отменить заявку</a>
        </div>


    </div>

    <div class="assignee-section">
        <h2>Заявка @if (count(Auth::user()->orders()->notCompleted()->get()) != 0)#{{Auth::user()->orders()->notCompleted()->first()->id}} @endif</h2>
        <p>Ожидайте подтверждения оплаты в течение <strong>24 часов.</strong></p>
    </div>
</div>

