<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="icon" href="favicon.ico">
    <title></title>
    <link rel="stylesheet" href="/css/dashboard.css">
    <script>
        window.user = {!! Auth::User()->toJson(JSON_PRETTY_PRINT) !!}
    </script>
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
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 3C19.5157 3 23.7244 11.2 23.9248 11.6C24.0251 11.8 24.0251 12.2 23.9248 12.4C23.7244 12.8 19.5157 21 12 21C4.92586 21 0.78149 13.7351 0.151837 12.6314C0.112538 12.5625 0.0869305 12.5176 0.0751566 12.5C-0.0250522 12.2 -0.0250522 11.9 0.0751566 11.6C0.275574 11.2 4.48434 3 12 3ZM2.07933 12C3.08142 13.6 6.58873 19 12 19C17.4113 19 20.9186 13.6 21.9207 12C20.9186 10.4 17.4113 5 12 5C6.58873 5 2.98121 10.4 2.07933 12ZM12 8C9.79541 8 7.99165 9.8 7.99165 12C7.99165 14.2 9.79541 16 12 16C14.2046 16 16.0084 14.2 16.0084 12C16.0084 9.8 14.2046 8 12 8ZM9.99582 12C9.99582 13.1 10.8977 14 12 14C13.1023 14 14.0042 13.1 14.0042 12C14.0042 10.9 13.1023 10 12 10C10.8977 10 9.99582 10.9 9.99582 12Z" fill="black"/>
                        <mask id="mask1" mask-type="alpha" maskUnits="userSpaceOnUse" x="0" y="3" width="24" height="18">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 3C19.5157 3 23.7244 11.2 23.9248 11.6C24.0251 11.8 24.0251 12.2 23.9248 12.4C23.7244 12.8 19.5157 21 12 21C4.92586 21 0.78149 13.7351 0.151837 12.6314C0.112538 12.5625 0.0869305 12.5176 0.0751566 12.5C-0.0250522 12.2 -0.0250522 11.9 0.0751566 11.6C0.275574 11.2 4.48434 3 12 3ZM2.07933 12C3.08142 13.6 6.58873 19 12 19C17.4113 19 20.9186 13.6 21.9207 12C20.9186 10.4 17.4113 5 12 5C6.58873 5 2.98121 10.4 2.07933 12ZM12 8C9.79541 8 7.99165 9.8 7.99165 12C7.99165 14.2 9.79541 16 12 16C14.2046 16 16.0084 14.2 16.0084 12C16.0084 9.8 14.2046 8 12 8ZM9.99582 12C9.99582 13.1 10.8977 14 12 14C13.1023 14 14.0042 13.1 14.0042 12C14.0042 10.9 13.1023 10 12 10C10.8977 10 9.99582 10.9 9.99582 12Z" fill="white"/>
                        </mask>
                        <g mask="url(#mask1)">
                            <rect width="24" height="24" fill="#B5BBC9"/>
                        </g>
                    </svg>
                </a>
            </div>
            <section class="balance">
                <div class="total-amount">
                    <h1>0,4943 <span>BTC</span></h1>
                    <p class="total-currency">≈ $16,456</p>
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
                                <div class="balance-item-currency-title">ETH</div>
                                <div class="balance-item-currency-description">Ethereum</div>
                            </div>
                        </div>
                        <div class="balance-item-amount">
                            <div class="balance-item-amount-title">1.93</div>
                            <div class="balance-item-amount-description">$4000.00</div>
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
                            <div class="balance-item-amount-title">20 000.00</div>
                            <div class="balance-item-amount-description">$1000.00</div>
                        </div>
                    </div>
                </div>
            </section>
        </header>
    </div>

    <noscript>
        <strong>We're sorry but doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
    </noscript>
    <div id="app"></div>
    <script src="{{ mix('js/app.js') }}"></script>
    <script>
        window.onload = function() {
            if (screen.width < 375) {
                let mvp = document.getElementById('vp');
                mvp.setAttribute('content','user-scalable=no,width=375');
            }
        }
    </script>
</body>

</html>
