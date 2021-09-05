<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" id="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="icon" href="favicon.ico">
    <title></title>
    <link rel="stylesheet" href="{{ mix('css/dashboard.css') }}">

    <script>
        window.user = {!! Auth::User()->toJson(JSON_PRETTY_PRINT) !!}
    </script>
    <script
        src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
</head>

<body>
<div class="app">
    <header class="header">
        <div class="header-top-icons d-flex justify-content-between">
            <a href="#" class="navbar-open">
                <svg width="23" height="24" viewBox="0 0 23 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M2 7H20C20.6 7 21 6.6 21 6C21 5.4 20.6 5 20 5H2C1.4 5 1 5.4 1 6C1 6.6 1.4 7 2 7ZM21 12C21 12.6 20.6 13 20 13H2C1.4 13 1 12.6 1 12C1 11.4 1.4 11 2 11H20C20.6 11 21 11.4 21 12ZM2 17H20C20.6 17 21 17.4 21 18C21 18.6 20.6 19 20 19H2C1.4 19 1 18.6 1 18C1 17.4 1.4 17 2 17Z" fill="black"/>
                    <mask id="mask0" mask-type="alpha" maskUnits="userSpaceOnUse" x="1" y="5" width="20" height="14">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2 7H20C20.6 7 21 6.6 21 6C21 5.4 20.6 5 20 5H2C1.4 5 1 5.4 1 6C1 6.6 1.4 7 2 7ZM21 12C21 12.6 20.6 13 20 13H2C1.4 13 1 12.6 1 12C1 11.4 1.4 11 2 11H20C20.6 11 21 11.4 21 12ZM2 17H20C20.6 17 21 17.4 21 18C21 18.6 20.6 19 20 19H2C1.4 19 1 18.6 1 18C1 17.4 1.4 17 2 17Z" fill="white"/>
                    </mask>
                    <g mask="url(#mask0)">
                        <rect x="-1" width="24" height="24" fill="#B5BBC9"/>
                    </g>
                </svg>
            </a>
            <a href="#" class="icon-watch">
                <span>PRO</span>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8 4H16C20.4 4 24 7.6 24 12C24 16.4 20.4 20 16 20H8C3.6 20 0 16.4 0 12C0 7.6 3.6 4 8 4ZM16 18C19.3 18 22 15.3 22 12C22 8.7 19.3 6 16 6H8C4.7 6 2 8.7 2 12C2 15.3 4.7 18 8 18H16ZM8 8C5.8 8 4 9.8 4 12C4 14.2 5.8 16 8 16C10.2 16 12 14.2 12 12C12 9.8 10.2 8 8 8ZM6 12C6 13.1 6.9 14 8 14C9.1 14 10 13.1 10 12C10 10.9 9.1 10 8 10C6.9 10 6 10.9 6 12Z" fill="black"/>
                    <mask id="switcher" mask-type="alpha" maskUnits="userSpaceOnUse" x="0" y="4" width="24" height="16">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8 4H16C20.4 4 24 7.6 24 12C24 16.4 20.4 20 16 20H8C3.6 20 0 16.4 0 12C0 7.6 3.6 4 8 4ZM16 18C19.3 18 22 15.3 22 12C22 8.7 19.3 6 16 6H8C4.7 6 2 8.7 2 12C2 15.3 4.7 18 8 18H16ZM8 8C5.8 8 4 9.8 4 12C4 14.2 5.8 16 8 16C10.2 16 12 14.2 12 12C12 9.8 10.2 8 8 8ZM6 12C6 13.1 6.9 14 8 14C9.1 14 10 13.1 10 12C10 10.9 9.1 10 8 10C6.9 10 6 10.9 6 12Z" fill="white"/>
                    </mask>
                    <g mask="url(#switcher)">
                        <rect width="24" height="24" fill="#B5BBC9"/>
                    </g>
                </svg>

            </a>
        </div>
        <section class="balance">
            <div class="total-amount">
                <h1>0.00000 <span>BTC</span></h1>
                <p class="total-currency">≈ $0.00</p>
            </div>
            <div class="balance-items">
                <div class="balance-item d-flex justify-content-between w-100">
                    <div class="balance-item-currency d-flex align-items-center">
                        <div class="balance-item-currency-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g opacity="0.9">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5 12.2199L12.3646 16.5731L12.3647 16.5732L12.3647 16.5732H12.3647L19.7294 12.2199L12.3647 8.54488e-05V0L12.3647 4.27244e-05L12.3647 0L12.3646 0.000166947L5 12.2199ZM12.3647 23.9946L12.3646 23.9944L5 13.6165L12.3647 17.9675L19.7338 13.6166L12.3647 23.9946L12.3647 23.9946Z" fill="white"/>
                                </g>
                            </svg>
                        </div>
                        <div class="balance-item-currency-text">
                            <div class="balance-item-currency-title">BTC</div>
                            <div class="balance-item-currency-description">Bitcoin</div>
                        </div>
                    </div>
                    <div class="balance-item-amount">
                        <div class="balance-item-amount-title">{{number_format(Auth::User()->getWallet('BTC')->balanceFloat, 5, '.', ' ')}}</div>
                        <div class="balance-item-amount-description">${{number_format(Auth::User()->getWallet('BTC')->balanceFloat / Rate::getRates('BTC'), 2, '.', ' ')}}</div>
                    </div>
                </div>
                <div class="balance-item d-flex justify-content-between w-100">
                    <div class="balance-item-currency d-flex align-items-center">
                        <div class="balance-item-currency-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g opacity="0.9">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5 12.2199L12.3646 16.5731L12.3647 16.5732L12.3647 16.5732H12.3647L19.7294 12.2199L12.3647 8.54488e-05V0L12.3647 4.27244e-05L12.3647 0L12.3646 0.000166947L5 12.2199ZM12.3647 23.9946L12.3646 23.9944L5 13.6165L12.3647 17.9675L19.7338 13.6166L12.3647 23.9946L12.3647 23.9946Z" fill="white"/>
                                </g>
                            </svg>
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
                            <svg width="24" height="19" viewBox="0 0 24 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.9" d="M7.96344 8.19798C-3.97489 7.0748 0.215383 2.71116 3.32515 1.6138C15.8301 -2.77565 28.5063 2.05275 22.4318 12.8973C21.9179 13.8139 21.1404 13.3749 20.4157 12.6778C18.4128 10.7671 14.7628 8.84349 7.96344 8.19798Z" fill="white"/>
                                <path opacity="0.9" d="M17.8326 9.38414C17.9248 9.42287 18.0302 9.4616 18.1225 9.50033C19.2162 9.9651 19.9014 10.7397 20.2308 11.7467C20.5207 12.6375 19.9409 14.432 18.755 15.3874C17.5032 16.4073 15.8956 17.156 14.8282 17.5304C11.3363 18.744 8.00257 18.318 7.33054 15.8909C6.52675 12.999 13.1548 8.29969 17.2528 9.2034C17.4504 9.25504 17.6481 9.31959 17.8326 9.38414Z" fill="white"/>
                                <path opacity="0.9" d="M7.80542 6.37925C10.4803 6.96021 7.80542 12.3954 5.76299 11.8273C2.70593 10.9624 4.86695 5.73375 7.80542 6.37925Z" fill="white"/>
                            </svg>
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
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.14 6.99402H9.44604V9.71402H11.14C11.89 9.71402 12.5 9.10402 12.5 8.35402C12.5 7.60402 11.89 6.99402 11.14 6.99402Z" fill="white" fill-opacity="0.9"/>
                                <path d="M10 0C4.478 0 0 4.478 0 10C0 15.522 4.478 20 10 20C15.522 20 20 15.522 20 10C20 4.478 15.522 0 10 0ZM11.14 11.676H9.446V12.39H11.476C11.648 12.39 11.788 12.53 11.788 12.702V14.04C11.788 14.212 11.648 14.352 11.476 14.352H9.444V15.378C9.444 15.55 9.304 15.69 9.132 15.69H7.794C7.622 15.69 7.482 15.55 7.482 15.378V14.352H6.79C6.618 14.352 6.478 14.212 6.478 14.04V12.702C6.478 12.53 6.618 12.39 6.79 12.39H7.482V11.676H6.79C6.618 11.676 6.478 11.536 6.478 11.364V10.026C6.478 9.854 6.618 9.714 6.79 9.714H7.482V5.344C7.482 5.172 7.622 5.032 7.794 5.032H11.14C12.972 5.032 14.462 6.522 14.462 8.354C14.462 10.188 12.978 11.676 11.14 11.676Z" fill="white" fill-opacity="0.9"/>
                            </svg>


                        </div>
                        <div class="balance-item-currency-text">
                            <div class="balance-item-currency-title">RUB</div>
                            <div class="balance-item-currency-description">Рубли</div>
                        </div>
                    </div>
                    <div class="balance-item-amount">
                        <div class="balance-item-amount-title">0.00</div>
                        <div class="balance-item-amount-description">$0.00</div>
                    </div>
                </div>
            </div>
        </section>
    </header>
    <main id="main-screen">
        <div class="screen-rollover">
            <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="18" cy="18" r="18" fill="#347AF0"/>
                <path d="M18.375 6.38571C18.125 6.12857 17.75 6 17.5 6C17.25 6 16.875 6.12857 16.625 6.38571L10.375 12.8143C9.875 13.3286 9.875 14.1 10.375 14.6143C10.875 15.1286 11.625 15.1286 12.125 14.6143L17.5 9.08571L22.875 14.6143C23.375 15.1286 24.125 15.1286 24.625 14.6143C25.125 14.1 25.125 13.3286 24.625 12.8143L18.375 6.38571Z" fill="white"/>
                <path d="M16.625 28.6143C16.875 28.8714 17.25 29 17.5 29C17.75 29 18.125 28.8714 18.375 28.6143L24.625 22.1857C25.125 21.6714 25.125 20.9 24.625 20.3857C24.125 19.8714 23.375 19.8714 22.875 20.3857L17.5 25.9143L12.125 20.3857C11.625 19.8714 10.875 19.8714 10.375 20.3857C9.875 20.9 9.875 21.6714 10.375 22.1857L16.625 28.6143Z" fill="white"/>
            </svg>
        </div>
        <div class="filter d-flex justify-content-between">
            <div class="filter-items">
                <a class="filter-item active" data-filter="all">Все</a>
                <a class="filter-item" data-filter="deposit">Ввод</a>
                <a class="filter-item" data-filter="withdraw">Вывод</a>
                <a class="filter-item" data-filter="exchange">Конвертация</a>
            </div>
            <div class="filter-action">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M22.009 2C22.409 2 22.709 2.2 22.909 2.6C23.109 2.9 23.009 3.3 22.809 3.6L15.009 12.8V21C15.009 21.4 14.809 21.7 14.509 21.9C14.409 22 14.209 22 14.009 22C13.809 22 13.709 22 13.609 21.9L9.60902 19.9C9.20902 19.7 9.00902 19.4 9.00902 19V12.8L1.20902 3.6C1.00902 3.3 0.909017 2.9 1.10902 2.6C1.30902 2.2 1.60902 2 2.00902 2H22.009ZM13.009 12.5C13.009 12.2 13.109 12 13.209 11.8L19.909 4H4.20902L10.809 11.9C10.909 12 11.009 12.3 11.009 12.5V18.4L13.009 19.4V12.5Z" fill="black"/>
                    <mask id="mask-filter" mask-type="alpha" maskUnits="userSpaceOnUse" x="1" y="2" width="23" height="20">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M22.009 2C22.409 2 22.709 2.2 22.909 2.6C23.109 2.9 23.009 3.3 22.809 3.6L15.009 12.8V21C15.009 21.4 14.809 21.7 14.509 21.9C14.409 22 14.209 22 14.009 22C13.809 22 13.709 22 13.609 21.9L9.60902 19.9C9.20902 19.7 9.00902 19.4 9.00902 19V12.8L1.20902 3.6C1.00902 3.3 0.909017 2.9 1.10902 2.6C1.30902 2.2 1.60902 2 2.00902 2H22.009ZM13.009 12.5C13.009 12.2 13.109 12 13.209 11.8L19.909 4H4.20902L10.809 11.9C10.909 12 11.009 12.3 11.009 12.5V18.4L13.009 19.4V12.5Z" fill="white"/>
                    </mask>
                    <g mask="url(#mask-filter)">
                        <rect width="24" height="24" fill="#78839C"/>
                    </g>
                </svg>
            </div>
        </div>
        <div class="orders">
            <div class="order-item d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-start flex-column justify-content-center">
                    <div class="currency">USDT</div>
                    <div class="destination deposit">Ввод</div>
                </div>
                <div class="d-flex align-items-end flex-column justify-content-center">
                    <div class="amount">104.00</div>
                    <div class="datetime">24.03.2021 14:20</div>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <div class="footer-nav w-100 d-flex justify-content-between">
            <a href="{{ Route('main') }}">
                <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#wallet)">
                        <path d="M21.7336 6.07273C21.6096 4.47281 20.2691 3.20865 18.638 3.20865H4.10599C2.39334 3.20865 1 4.60199 1 6.31464V20.6853C1 22.398 2.39334 23.7913 4.10599 23.7913H20.8941C22.6067 23.7913 24 22.398 24 20.6853V9.06246C24 7.64078 23.0395 6.44001 21.7336 6.07273ZM4.10599 4.65962H18.638C19.4276 4.65962 20.0894 5.21557 20.2535 5.95652H4.10599C3.49789 5.95652 2.93052 6.13286 2.45097 6.43611V6.31464C2.45097 5.40207 3.19342 4.65962 4.10599 4.65962ZM20.894 22.3404H4.10599C3.19342 22.3404 2.45097 21.5979 2.45097 20.6853V9.06246C2.45097 8.14989 3.19342 7.40745 4.10599 7.40745H20.8941C21.8066 7.40745 22.5491 8.14989 22.5491 9.06246V11.5943H17.9229C16.0897 11.5943 14.5983 13.0858 14.5983 14.919C14.5983 16.7522 16.0898 18.2437 17.9229 18.2437H22.549V20.6853C22.549 21.5979 21.8066 22.3404 20.894 22.3404ZM22.549 16.7927H17.9229C16.8898 16.7927 16.0493 15.9522 16.0493 14.919C16.0493 13.8858 16.8898 13.0453 17.9229 13.0453H22.549V16.7927Z" fill="#B5BBC9" stroke="#B5BBC9" stroke-width="0.3"/>
                        <path d="M18.1923 15.7294C18.6095 15.7294 18.9477 15.3912 18.9477 14.974C18.9477 14.5569 18.6095 14.2187 18.1923 14.2187C17.7752 14.2187 17.437 14.5569 17.437 14.974C17.437 15.3912 17.7752 15.7294 18.1923 15.7294Z" fill="#B5BBC9" stroke="#B5BBC9" stroke-width="0.3"/>
                    </g>
                    <defs>
                        <clipPath id="wallet">
                            <rect width="23" height="23" fill="white" transform="translate(1 2)"/>
                        </clipPath>
                    </defs>
                </svg>

                <span>Кошелек</span>
            </a>
            <a href="#">
                <svg width="25" height="25" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <mask id="orders1" mask-type="alpha" maskUnits="userSpaceOnUse" x="3" y="1" width="18" height="22">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M20 1H6.5C4.6 1 3 2.6 3 4.5V19.5C3 21.4 4.6 23 6.5 23H20C20.6 23 21 22.6 21 22V2C21 1.4 20.6 1 20 1ZM6.5 3H19V16H6.5C6 16 5.5 16.1 5 16.4V4.5C5 3.7 5.7 3 6.5 3ZM5 19.5C5 20.3 5.7 21 6.5 21H19V18H6.5C5.7 18 5 18.7 5 19.5Z" fill="white"/>
                    </mask>
                    <g mask="url(#orders1)">
                        <rect width="25" height="25" fill="#B5BBC9"/>
                    </g>
                </svg>

                <span>Заявки</span>
            </a>
        </div>
        <a class="create-order d-flex justify-content-center align-items-center flex-column" onclick="createOrder();">
            <svg width="72" height="72" viewBox="0 0 72 66" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g filter="url(#filter0_d)">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M36 63C53.6731 63 68 48.6731 68 31C68 13.3269 53.6731 -1 36 -1C18.3269 -1 4 13.3269 4 31C4 48.6731 18.3269 63 36 63Z" fill="#EDF1F9"/>
                </g>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M36 60C52.0163 60 65 47.0163 65 31C65 14.9837 52.0163 2 36 2C19.9837 2 7 14.9837 7 31C7 47.0163 19.9837 60 36 60Z" fill="#3783F5"/>
                <path d="M46 31C46 31.75 45.5 32.25 44.75 32.25H37.25V39.75C37.25 40.5 36.75 41 36 41C35.25 41 34.75 40.5 34.75 39.75V32.25H27.25C26.5 32.25 26 31.75 26 31C26 30.25 26.5 29.75 27.25 29.75H34.75V22.25C34.75 21.5 35.25 21 36 21C36.75 21 37.25 21.5 37.25 22.25V29.75H44.75C45.5 29.75 46 30.25 46 31Z" fill="black"/>
                <mask id="create-order" mask-type="alpha" maskUnits="userSpaceOnUse" x="26" y="21" width="20" height="20">
                    <path d="M46 31C46 31.75 45.5 32.25 44.75 32.25H37.25V39.75C37.25 40.5 36.75 41 36 41C35.25 41 34.75 40.5 34.75 39.75V32.25H27.25C26.5 32.25 26 31.75 26 31C26 30.25 26.5 29.75 27.25 29.75H34.75V22.25C34.75 21.5 35.25 21 36 21C36.75 21 37.25 21.5 37.25 22.25V29.75H44.75C45.5 29.75 46 30.25 46 31Z" fill="white"/>
                </mask>
                <g mask="url(#create-order)">
                    <rect x="21" y="16" width="30" height="30" fill="white"/>
                </g>
                <defs>
                    <filter id="filter0_d" x="0" y="-6" width="72" height="72" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                        <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                        <feOffset dy="-1"/>
                        <feGaussianBlur stdDeviation="2"/>
                        <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.502704 0"/>
                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow"/>
                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow" result="shape"/>
                    </filter>
                </defs>
            </svg>

            <span>Создать заявку</span>
        </a>
    </footer>
    @include('dashboard.components.createorder')
</div>
<script>
    window.onload = function() {
        if (screen.width < 375) {
            let mvp = document.getElementById('viewport');
            mvp.setAttribute('content','user-scalable=no,width=375');
        }
    }
    function createOrder() {
    }
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>

</html>
