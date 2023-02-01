<!DOCTYPE html>
<html lang="en">
<head>
    <title>Da·HUB – Friendly crypto P2P platform</title>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="title" content="DaHUB Payment Processor | P2P" />
    <link rel="apple-touch-icon" sizes="180x180" href="/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#9f00a7">
    <meta name="theme-color" content="#ffffff">
    <meta data-hid="og:url" property="og:url" content="https://dahub.app/" />
    <meta data-hid="og:title" property="og:title" content="DaHUB Payment Processor | P2P" />
    <link href="/fonts/Gotham/style.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ mix('css/site.css') }}">
    <script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous"></script>

    <!-- ✅ load Bootstrap JS ✅ -->
    <script
        src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</head>
<body>

<div id="loader" class="align-items-center justify-content-center">
    <img src="/img/preloader.gif" >
</div>
<div>
    <div id="app">
        <div class="header">
            <div class="container-fluid">
                <div class="row header-wrapper">
                    <a class="logo">
                        <svg width="264" height="79" viewBox="0 0 264 79" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.9" d="M45.5367 37.4553C18.4383 34.8529 27.9367 24.7223 35.0139 22.2129C63.416 12.0823 92.2838 23.2353 78.4086 48.4223C77.1981 50.56 75.4288 49.5376 73.8457 47.9576C69.2827 43.4965 60.9949 38.9423 45.5367 37.4553Z" fill="url(#paint0_linear_550_33)"/>
                            <g opacity="0.9">
                                <path d="M66.582 39.8718C66.7683 39.9647 67.0476 39.9647 67.2339 40.0576C67.0476 39.9647 66.8614 39.8718 66.582 39.8718Z" fill="url(#paint1_linear_550_33)"/>
                                <path d="M67.9789 40.2435C68.1652 40.3365 68.4445 40.4294 68.6308 40.5224C71.1451 41.6376 72.635 43.4035 73.38 45.7271C74.0318 47.7718 72.7281 51.9541 70.0276 54.1847C67.1408 56.5082 63.5091 58.2741 61.0879 59.1106C53.1726 61.8988 45.5366 60.8765 44.0467 55.3C42.1842 48.6082 57.2699 37.7341 66.5821 39.7788C67.1408 39.9647 67.5133 40.0576 67.9789 40.2435Z" fill="url(#paint2_linear_550_33)"/>
                            </g>
                            <path opacity="0.9" d="M45.164 33.2729C51.2169 34.667 45.164 47.2141 40.5079 45.9129C33.5238 43.8682 38.4593 31.7859 45.164 33.2729Z" fill="url(#paint3_linear_550_33)"/>
                            <path d="M104.296 38.7432C104.296 34.8397 104.296 30.8432 104.296 26.9397C104.296 26.0103 104.576 25.7314 105.507 25.7314C108.58 25.7314 111.746 25.6385 114.819 25.7314C119.568 25.9173 123.759 27.4044 126.459 31.6797C129.718 36.9773 129.067 47.1079 121.244 50.4538C119.475 51.1973 117.613 51.662 115.657 51.662C112.305 51.662 108.952 51.662 105.507 51.662C104.576 51.662 104.203 51.3832 104.203 50.4538C104.296 46.6432 104.296 42.7397 104.296 38.7432ZM109.232 38.6503C109.232 41.2526 109.232 43.855 109.232 46.5503C109.232 47.2938 109.511 47.4797 110.163 47.4797C111.932 47.4797 113.702 47.4797 115.471 47.4797C119.196 47.2938 121.989 45.1561 122.921 41.8103C123.293 40.3232 123.293 38.8361 123.2 37.3491C122.827 33.7244 120.593 31.3079 117.054 30.4714C114.819 30.0067 112.491 30.1926 110.256 30.0997C109.511 30.0997 109.232 30.3785 109.325 31.122C109.232 33.6314 109.232 36.1408 109.232 38.6503Z" fill="#132D54"/>
                            <path d="M219.767 33.6314C222.468 31.4938 225.541 31.0291 228.707 31.7726C231.035 32.2373 232.99 33.5385 234.387 35.3973C237.367 39.3938 237.181 45.342 233.922 48.9667C230.942 52.4056 224.423 54.0785 219.302 49.9891L219.208 50.082C218.836 51.662 218.836 51.662 217.16 51.662C214.646 51.662 214.646 51.662 214.646 49.1526C214.646 41.4385 214.646 33.8173 214.646 26.1032C214.646 24.7091 214.646 24.7091 216.135 24.6161C216.88 24.6161 217.625 24.6161 218.37 24.6161C219.302 24.5232 219.581 24.895 219.581 25.8244C219.488 28.055 219.581 30.2856 219.581 32.4232C219.581 32.9809 219.488 33.2597 219.767 33.6314ZM231.594 41.9961C231.594 38.3714 229.079 35.862 225.541 35.862C222.002 35.862 219.302 38.5573 219.302 42.0891C219.302 45.5279 222.002 48.3161 225.448 48.3161C228.986 48.2232 231.594 45.5279 231.594 41.9961Z" fill="#132D54"/>
                            <path d="M165.012 38.3714C165.012 34.282 165.012 30.2855 165.012 26.1961C165.012 24.9879 165.105 24.895 166.222 24.895C167.06 24.895 167.898 24.895 168.736 24.895C169.668 24.802 169.854 25.1738 169.854 26.1032C169.761 28.3338 169.854 30.5644 169.854 32.795C169.854 33.0738 169.761 33.3526 170.04 33.4455C170.226 33.5385 170.413 33.2597 170.599 33.1667C173.579 31.215 176.745 31.0291 180.004 32.2373C183.357 33.4455 184.567 36.2338 184.846 39.5797C185.126 43.2973 184.94 47.1079 185.033 50.8255C185.033 51.662 184.753 52.0338 183.822 51.9408C182.891 51.8479 181.96 51.8479 181.028 51.9408C180.19 51.9408 179.911 51.662 180.004 50.9185C180.004 47.7585 180.004 44.5985 180.004 41.5314C180.004 40.602 180.004 39.7655 179.725 38.8361C179.166 37.1632 178.049 36.1408 176.279 35.955C172.275 35.5832 169.947 37.7208 169.854 41.7173C169.854 44.7844 169.854 47.7585 169.854 50.8255C169.854 51.662 169.575 51.9408 168.736 51.9408C167.805 51.8479 166.967 51.8479 166.036 51.9408C165.198 52.0338 164.918 51.662 164.918 50.8255C165.012 46.5502 165.012 42.4608 165.012 38.3714Z" fill="#132D54"/>
                            <path d="M146.108 49.8961C144.152 51.3832 142.011 52.1267 139.776 52.3126C137.634 52.4985 135.492 52.3126 133.723 50.9185C131.674 49.3385 131.208 47.1079 131.581 44.5985C131.953 42.4608 133.63 41.4385 135.492 40.7879C138.379 39.8585 141.452 39.9514 144.432 40.1373C145.549 40.2303 145.549 40.2303 145.642 39.115C145.642 37.3491 144.99 36.4197 143.221 35.862C141.638 35.3973 140.148 35.3973 138.565 36.0479C137.913 36.3267 137.261 36.6985 137.075 37.2561C136.703 38.0926 136.144 38.1855 135.399 38.1855C134.468 38.1855 133.63 38.1855 132.698 38.1855C132.046 38.1855 131.86 37.9067 131.953 37.2561C132.14 35.7691 132.791 34.5608 133.909 33.6314C135.306 32.4232 136.982 31.8655 138.844 31.5867C141.452 31.3079 144.059 31.4008 146.573 32.4232C149.181 33.5385 150.578 35.4903 150.578 38.4644C150.578 42.4608 150.578 46.5503 150.578 50.5467C150.578 51.4761 150.298 51.8479 149.367 51.755C149.181 51.755 148.995 51.755 148.808 51.755C146.76 51.8479 146.76 51.8479 146.108 49.8961ZM142.569 43.5761C141.172 43.5761 139.776 43.5761 138.379 43.9479C137.075 44.3197 136.423 44.9703 136.516 45.9926C136.516 47.1079 137.261 47.9444 138.472 48.2232C140.614 48.7808 142.569 48.2232 144.432 47.1079C145.456 46.4573 145.828 45.5279 145.642 44.3197C145.549 43.762 145.456 43.5761 144.897 43.5761C144.152 43.5761 143.407 43.5761 142.569 43.5761Z" fill="#132D54"/>
                            <path d="M189.782 38.4644C189.782 36.6985 189.782 34.8397 189.782 33.0738C189.782 32.4232 189.968 32.0514 190.713 32.1444C191.738 32.1444 192.669 32.1444 193.693 32.1444C194.438 32.1444 194.718 32.4232 194.718 33.1667C194.718 36.2338 194.718 39.2079 194.718 42.275C194.718 43.1114 194.718 43.855 194.904 44.6914C195.556 47.3867 197.418 48.502 200.119 48.2232C203.192 47.9444 204.495 46.2714 204.588 42.9256C204.588 39.7656 204.588 36.6056 204.588 33.4456C204.588 32.5161 204.868 32.1444 205.799 32.1444C206.73 32.2373 207.661 32.1444 208.593 32.1444C209.151 32.1444 209.524 32.3303 209.431 32.9809C209.338 36.8844 209.71 40.7879 209.245 44.6914C208.779 49.1526 205.613 52.1267 201.05 52.4056C199.746 52.4985 198.442 52.4985 197.139 52.3126C192.389 51.4761 189.782 48.4091 189.689 43.5761C189.782 41.8103 189.782 40.1373 189.782 38.4644Z" fill="#132D54"/>
                            <path d="M158.028 45.6208C159.57 45.6208 160.821 44.3725 160.821 42.8326C160.821 41.2927 159.57 40.0444 158.028 40.0444C156.485 40.0444 155.234 41.2927 155.234 42.8326C155.234 44.3725 156.485 45.6208 158.028 45.6208Z" fill="#132D54"/>
                            <defs>
                                <linearGradient id="paint0_linear_550_33" x1="27.3345" y1="34.8433" x2="82.0084" y2="36.1202" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#F88D3D"/>
                                    <stop offset="1" stop-color="#F5569F"/>
                                </linearGradient>
                                <linearGradient id="paint1_linear_550_33" x1="66.8234" y1="40.0298" x2="67.143" y2="39.7827" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#44B659"/>
                                    <stop offset="1" stop-color="#00B6F3"/>
                                </linearGradient>
                                <linearGradient id="paint2_linear_550_33" x1="46.8632" y1="59.77" x2="70.7049" y2="41.3387" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#44B659"/>
                                    <stop offset="1" stop-color="#00B6F3"/>
                                </linearGradient>
                                <linearGradient id="paint3_linear_550_33" x1="37.2766" y1="38.481" x2="47.6493" y2="38.977" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#40AAE2"/>
                                    <stop offset="1" stop-color="#465BA0"/>
                                </linearGradient>
                            </defs>
                        </svg>

                    </a>
                    <div class="menu-icon">
                        <svg width="19" height="22" viewBox="0 0 19 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="18.0714" height="3.14286" rx="1.57143" fill="#132D54"/>
                            <rect y="9.42856" width="18.0714" height="3.14286" rx="1.57143" fill="#132D54"/>
                            <rect y="18.8571" width="18.0714" height="3.14286" rx="1.57143" fill="#132D54"/>
                        </svg>
                    </div>
                    <div class="menu">
                        <nav class="nav justify-content-lg-end justify-content-center">
                            <li class="nav-item">
                                <a class="nav-link" href="https://docs.dahub.app/" target="_blank">Gitbook</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="https://t.me/DA_HUB" target="_blank">Telegram</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="https://t.me/DaHubSupportBot?start=dashboard" target="_blank">Поддержка</a>
                            </li>
                        </nav>
                        @guest
                        <a class="button" href="https://t.me/{{env('TELEGRAM_BOT_NAME')}}?start=login{{ app('request')->input('ref') }}">Регистрация / Вход</a>
                        @endguest
                        @auth
                        <a class="button logined" href="/dashboard/profile">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.25 5.25C5.25 3.15 6.9 1.5 9 1.5C11.1 1.5 12.75 3.15 12.75 5.25C12.75 7.35 11.1 9 9 9C6.9 9 5.25 7.35 5.25 5.25ZM15.75 14.25V15.75C15.75 16.2 15.45 16.5 15 16.5C14.55 16.5 14.25 16.2 14.25 15.75V14.25C14.25 12.975 13.275 12 12 12H6C4.725 12 3.75 12.975 3.75 14.25V15.75C3.75 16.2 3.45 16.5 3 16.5C2.55 16.5 2.25 16.2 2.25 15.75V14.25C2.25 12.15 3.9 10.5 6 10.5H12C14.1 10.5 15.75 12.15 15.75 14.25ZM9 7.5C7.725 7.5 6.75 6.525 6.75 5.25C6.75 3.975 7.725 3 9 3C10.275 3 11.25 3.975 11.25 5.25C11.25 6.525 10.275 7.5 9 7.5Z" fill="black"/>
                                <mask id="mask0_544_198" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="2" y="1" width="14" height="16">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.25 5.25C5.25 3.15 6.9 1.5 9 1.5C11.1 1.5 12.75 3.15 12.75 5.25C12.75 7.35 11.1 9 9 9C6.9 9 5.25 7.35 5.25 5.25ZM15.75 14.25V15.75C15.75 16.2 15.45 16.5 15 16.5C14.55 16.5 14.25 16.2 14.25 15.75V14.25C14.25 12.975 13.275 12 12 12H6C4.725 12 3.75 12.975 3.75 14.25V15.75C3.75 16.2 3.45 16.5 3 16.5C2.55 16.5 2.25 16.2 2.25 15.75V14.25C2.25 12.15 3.9 10.5 6 10.5H12C14.1 10.5 15.75 12.15 15.75 14.25ZM9 7.5C7.725 7.5 6.75 6.525 6.75 5.25C6.75 3.975 7.725 3 9 3C10.275 3 11.25 3.975 11.25 5.25C11.25 6.525 10.275 7.5 9 7.5Z" fill="white"/>
                                </mask>
                                <g mask="url(#mask0_544_198)">
                                    <rect width="18" height="18" fill="#848FAD"/>
                                </g>
                            </svg>&nbsp;
                            {{ auth()->user()->name }}</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        <section id="main-screen">
            <div class="container-fluid h-100">
                <div class="row justify-content-between align-items-center h-100 parallax-wrapper">
                    <div class="col-12 col-md-6 main-text">
                        <div class="block">
                            <h1>Friendly Crypto <br />Peer-To-Peer</h1>
                            <h3 class="mt-4 hashtags">#xранибезопасно #обменивайбыстро #зарабатывайлегко</h3>
                            <p class="description">Digital Assets Hub - это децентрализованная платформа-кошелёк, предназначенная для полного контроля над своими цифровыми активами (создание, листинг, обмен и сжигание), развитием которой управляют участники Dahub DAO посредством умного голосования.</p>
                            <div class="button-wrapper">
                                @auth
                                <a class="button" href="/dashboard">Войти в кошелек</a>
                                @endauth
                                @guest
                                <a class="button" href="https://t.me/{{env('TELEGRAM_BOT_NAME')}}?start=login{{ app('request')->input('ref') }}">Войти в кошелек</a>
                                @endguest
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="row justify-content-center justify-content-xl-end main-screen-image"
                             data-paroller-factor="0.2"
                             data-paroller-factor-xs="0.1"
                             data-paroller-factor-sm="0.1"
                             data-paroller-type="foreground"
                             data-paroller-direction="vertical">
                            <img src="/img/phones.jpg" alt="Dahub decentralized wallet-platform" style="margin-top:-50px">
                        </div>
                    </div>
<!--                    <div class="col-12 col-md-6">
                        <div class="phone-wrapper">
                            <video playsinline autoplay loop muted poster="">
                                <source src="/videos/dashboard.mp4" type="video/mp4">
                            </video>
                        </div>
                    </div>-->
                </div>
            </div>
        </section>
        <section id="second-screen" data-paroller-factor="0.4"
                 data-paroller-factor-xs="0.2"
                 data-paroller-factor-sm="0.3"
                 data-paroller-type="background"
                 data-paroller-direction="vertical" style="background: url('/img/2nd-screen.jpg') no-repeat center;">
            <div class="container-fluid h-100">
                <div class="row align-items-center">
                    <div class="mobile-scroll-icon animate-flicker">
                        <svg width="43" height="41" viewBox="0 0 43 41" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.7154 23.142C15.7154 23.1426 15.7164 23.1428 15.7166 23.1422C15.8334 22.8885 15.7824 22.6629 15.7824 22.4466C15.7856 17.0066 15.7803 11.5676 15.7856 6.12754C15.7887 3.46885 17.2039 1.31338 19.536 0.379277C22.8238 -0.938535 26.6978 1.32911 27.151 4.84223C27.3478 6.36971 27.218 7.90664 27.2379 9.43832C27.261 11.164 27.261 12.8906 27.2316 14.6163C27.2212 15.2201 27.4724 15.5388 28.0073 15.7569C31.0931 17.0181 34.1726 18.2971 37.2542 19.5688C39.4806 20.4882 40.7419 22.1352 40.9962 24.5423C41.0978 25.5005 40.8235 26.4084 40.6037 27.3184C39.7433 30.884 38.8651 34.4443 37.9994 38.0077C37.5232 39.965 36.2315 40.9945 34.2239 40.9945C29.1231 40.9966 24.0234 40.9914 18.9226 40.9977C17.8947 40.9987 17.0176 40.6548 16.2922 39.9283C12.4036 36.0315 8.50445 32.1452 4.63571 28.2295C2.6804 26.2501 2.46268 23.0526 4.06001 20.7818C5.90959 18.1514 9.93849 17.7184 12.4245 19.9263C13.4388 20.8269 14.362 21.8312 15.3271 22.7863C15.4464 22.9036 15.574 23.0126 15.7152 23.1415C15.7154 23.1416 15.7154 23.1418 15.7154 23.142V23.142ZM18.4835 16.0856C18.4833 16.0854 18.483 16.0855 18.483 16.0858C18.483 19.52 18.4809 22.9543 18.4851 26.3885C18.4851 27.0091 18.2423 27.4788 17.6686 27.722C17.1003 27.9632 16.58 27.8405 16.1404 27.3991C15.9803 27.2387 15.8191 27.0794 15.66 26.919C14.0354 25.2919 12.4234 23.6512 10.7811 22.0419C9.20786 20.5008 6.69674 20.9611 5.94937 22.9289C5.41972 24.3232 5.74839 25.5561 6.80037 26.6087C10.5435 30.3545 14.2856 34.1025 18.0214 37.8567C18.326 38.1629 18.6526 38.2918 19.0859 38.2918C24.0988 38.2813 29.1126 38.2845 34.1255 38.2855C34.989 38.2855 35.1848 38.1398 35.3889 37.3021C36.3184 33.486 37.2458 29.6689 38.1732 25.8528C38.5961 24.1135 37.9073 22.7443 36.2587 22.0618C33.13 20.7661 30.0003 19.4724 26.8695 18.1818C25.3685 17.5633 24.5509 16.3629 24.5499 14.7379C24.5468 11.7395 24.5551 8.7401 24.5436 5.74174C24.5373 3.99933 23.164 2.66894 21.438 2.70144C19.8291 2.73079 18.4924 4.15554 18.4861 5.88746C18.4746 9.28711 18.483 12.6868 18.4841 16.0853C18.4841 16.0856 18.4837 16.0858 18.4835 16.0856V16.0856Z" fill="white"></path>
                            <path d="M38.2853 6.44512C37.9754 6.14528 37.6593 5.85279 37.3579 5.54561C36.756 4.93336 36.7173 4.15336 37.2511 3.58829C37.7996 3.00853 38.6056 3.00853 39.2441 3.62708C40.3442 4.69433 41.4339 5.77206 42.512 6.86133C43.1652 7.52076 43.1652 8.2672 42.512 8.93607C41.4286 10.0442 40.3327 11.1408 39.2284 12.229C38.637 12.8119 37.8132 12.8119 37.272 12.2636C36.7392 11.7227 36.7518 10.9469 37.3181 10.3482C37.5033 10.1527 37.696 9.96392 37.8899 9.7756C38.1154 9.55665 38.0982 9.26945 37.7839 9.26945V9.26945C36.1478 9.26211 34.5118 9.26421 32.8768 9.26316C32.5261 9.26316 32.1786 9.23905 31.8656 9.05978C31.3454 8.76204 31.091 8.12043 31.2502 7.52285C31.3915 6.99028 31.8939 6.58036 32.4853 6.57512C34.2082 6.56149 35.9312 6.56778 37.6541 6.56568C37.8236 6.56568 37.9923 6.56568 38.1616 6.56568C38.1985 6.56568 38.2325 6.54561 38.25 6.51312C38.2618 6.49124 38.2735 6.46935 38.2856 6.44747C38.286 6.4467 38.2859 6.44574 38.2853 6.44512V6.44512Z" fill="white"></path>
                            <path d="M4.78775 6.58716C4.78803 6.58702 4.78834 6.58695 4.78865 6.58695C6.6297 6.58695 8.4718 6.58276 10.3129 6.58905C11.122 6.59219 11.6925 7.03041 11.795 7.70138C11.9322 8.59669 11.3271 9.28653 10.3819 9.29072C8.7124 9.29701 7.04285 9.29177 5.3733 9.29072V9.29072C5.09722 9.29072 4.94529 9.58697 5.14103 9.78167C5.33489 9.97451 5.53708 10.1434 5.71454 10.3349C6.06938 10.7176 6.24837 11.1505 6.10288 11.6705C5.8391 12.613 4.70234 13.0282 3.98323 12.3677C2.72924 11.2145 1.53073 9.99838 0.343725 8.77387C-0.114746 8.30105 -0.116839 7.60178 0.351053 7.10904C1.52445 5.87196 2.72715 4.66213 3.95497 3.47956C4.46473 2.98891 5.25397 3.07488 5.74594 3.57181C6.25465 4.08447 6.27768 4.83721 5.78886 5.41381C5.62033 5.61196 5.42983 5.79333 5.24037 5.9726C5.08582 6.11899 4.92135 6.2546 4.75945 6.39345C4.72465 6.4233 4.71709 6.474 4.74106 6.51309C4.75593 6.53734 4.77067 6.56173 4.78514 6.58639C4.78567 6.58729 4.78681 6.58763 4.78775 6.58716V6.58716Z" fill="white"></path>
                        </svg>
                    </div>
                    <div class="col-12 col-xl-6 second-screen-image d-flex justify-content-center">
                        <div id="mobile-slider" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img class="d-block" src="/img/slider/slide1.png">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block" src="/img/slider/slide2.png">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block" src="/img/slider/slide3.png">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block" src="/img/slider/slide4.png">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block" src="/img/slider/slide5.png">
                                </div>
                            </div>
                            <ol class="carousel-indicators">
                                <li data-target="#mobile-slider-indicators" data-slide-to="0" class="active"></li>
                                <li data-target="#mobile-slider-indicators" data-slide-to="1"></li>
                                <li data-target="#mobile-slider-indicators" data-slide-to="2"></li>
                                <li data-target="#mobile-slider-indicators" data-slide-to="3"></li>
                                <li data-target="#mobile-slider-indicators" data-slide-to="4"></li>
                            </ol>
                        </div>
                        <div style="display:none;">
                            <a class="carousel-control-prev" href="#mobile-slider-indicators" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#mobile-slider-indicators" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-xl-6 section-content text-white">
                        <div class="block">
                            <h2>Dahub Payment Systems</h2>
                            <div class="description-block">
                                <p>Dahub P2P wallet позволяет в 2 клика подключиться к системе через Telegram и является интерфейсом к ядру Dahub</p>
                                <p>Все события обмена происходят только между участниками сообщества. Платформа не хранит и не накапливает средства, они хранятся на личных кошельках участников. Функция платформы — быстрый подбор подходящих партнеров для осуществления обмена и соблюдения условий исполнения.</p>
                                <p>*Главное отличие платформы Dahub от других P2P систем — конкуренция со стороны кипера за более быструю и качественно исполненную сделку, что формирует его рейтинг на платформе и преимущество в борьбе за вознаграждение.</p>
                            </div>
                            <div class="button-wrapper">
                                @auth
                                    <a class="button" href="/dashboard">Войти в кошелек</a>
                                @endauth
                                @guest
                                    <a class="button" href="https://t.me/{{env('TELEGRAM_BOT_NAME')}}?start=login{{ app('request')->input('ref') }}">Войти в кошелек</a>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <section id="third-screen">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-xl-6 col-md-10">
                        <div class="section-content">
                            <h2>Что еще?</h2>
                            <div class="accordion" id="accordionFlushExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingOne">
                                        <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                            Dahub's P2P Gateway
                                        </button>
                                    </h2>
                                    <div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-parent="#accordionFlushExample">
                                        <div class="accordion-body">Интелектуальная рейтинговая система, учитывающая вовлеченность участников в проект и сообщество. Выполняй простые действия и получай вознаграждения.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                            Proof of Trust History
                                        </button>
                                    </h2>
                                    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            Бесплатные транзакции в Dahub Chain. Лёгкий апгрейд безопасности хранения информации о транзакциях. Быстрый переезд с одного блокчейна на другой. Возможность выбора блокчейна пользователем для хранения информации о созданных им токенов.
                                            Практически незаметный для пользователя и легкий переход при апгрейде ядра на уровень Layer2 и Layer1 (достижение полной децентрализации).
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingFour">
                                        <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                            Open accounting system
                                        </button>
                                    </h2>
                                    <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-parent="#accordionFlushExample">
                                        <div class="accordion-body">Открытая бухгалтерия для вашего проекта. Позволяет быть полностью прозрачными для сообщества, отображать все транзакции, которые совершаются в системе.</div>
                                    </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingFour">
                                        <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseThree">
                                            Constructor Token Service
                                        </button>
                                    </h2>
                                    <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-parent="#accordionFlushExample">
                                        <div class="accordion-body">Открытый протокол хранения и анализа данных о транзакциях из различных систем ставит нас в ряд с другими блокчейн проектами.
                                            Конструктор позволяет в несколько кликов развернуть свою токеномику, интегрировать телеграм-ботов, настроить свап-токенов, сохранив доверие и историческую непрерывность развития своей токеномики в едином обозревателе Dahub Explorer.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 button-wrapper">
                                @auth
                                    <a class="button" href="/dashboard">Войти в кошелек</a>
                                @endauth
                                @guest
                                    <a class="button" href="https://t.me/{{env('TELEGRAM_BOT_NAME')}}?start=login{{ app('request')->input('ref') }}">Войти в кошелек</a>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="row h-100 justify-content-center justify-content-xl-end main-screen-image align-items-start business-kit">
                        <img src="/img/duck.png">
                    </div>
                </div>
            </div>
        </section>
        <section id="token-sale">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 justify-content-center d-flex flex-column align-items-center text-center">
                        <h2>Получить DHB</h2>
                        <p class="description">
                            Максимальный лимит в одни руки {{number_format($system->amount_per_order,0,' ', ',')}}&nbsp;DHB
                        </p>
                        <div class="progress-section">
                            <div class="progress">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: calc({{((2000000 - $balance) / 2000000) * 100}}% + 10px)" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                            <div class="progress-content">
                                <p class="progress-desc">Продано {{ number_format((2000000 - $balance),0,' ', ' ') }} DHB из 2&nbsp;000&nbsp;000&nbsp;DHB</p>
                            </div>
                        </div>


                        <div class="available-tokens">
                            <p class="">доступно для покупки</p>
                            <p class="amount">{{number_format($balance,0,' ', ',')}}</p>
                            <p class="left">токенов по цене ${{Rate::getRates('DHB')}}</p>
                        </div>


                        <div class="get-tokens">
                            <div class="deposit-block">
                                <div class="form-group">
                                    <input type="number" name="deposit-amount" value="2000" step="1000" data-min="2000" data-max="{{$system->amount_per_order}}">
                                    <span class="equals">≈</span>
                                    <input class="deposit-receive" name="deposit-receive" value="{{number_format(Rate::getRates('DHB') * 2000, 2, '.', '')}}">
                                    <select name="deposit-currency">
                                        @foreach ($currencies->all() as $currency)
                                            @if ($currency->title != 'DHB')
                                                <option value="{{$currency->title}}" @if ($currency->title == 'USDT') selected="selected" @endif}}>{{$currency->title}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="button-wrapper">
                                @auth
                                    <a class="button" href="/dashboard">Получить DHB</a>
                                @endauth
                                @guest
                                    <a class="button" href="https://t.me/{{env('TELEGRAM_BOT_NAME')}}?start=login{{ app('request')->input('ref') }}">Получить DHB</a>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="explorer">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <h2 class="text-center d-flex w-100 justify-content-center">Dahub Explorer</h2>
                    <div class="mobile-scroll-icon animate-flicker">
                        <svg width="43" height="41" viewBox="0 0 43 41" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.7154 23.142C15.7154 23.1426 15.7164 23.1428 15.7166 23.1422C15.8334 22.8885 15.7824 22.6629 15.7824 22.4466C15.7856 17.0066 15.7803 11.5676 15.7856 6.12754C15.7887 3.46885 17.2039 1.31338 19.536 0.379277C22.8238 -0.938535 26.6978 1.32911 27.151 4.84223C27.3478 6.36971 27.218 7.90664 27.2379 9.43832C27.261 11.164 27.261 12.8906 27.2316 14.6163C27.2212 15.2201 27.4724 15.5388 28.0073 15.7569C31.0931 17.0181 34.1726 18.2971 37.2542 19.5688C39.4806 20.4882 40.7419 22.1352 40.9962 24.5423C41.0978 25.5005 40.8235 26.4084 40.6037 27.3184C39.7433 30.884 38.8651 34.4443 37.9994 38.0077C37.5232 39.965 36.2315 40.9945 34.2239 40.9945C29.1231 40.9966 24.0234 40.9914 18.9226 40.9977C17.8947 40.9987 17.0176 40.6548 16.2922 39.9283C12.4036 36.0315 8.50445 32.1452 4.63571 28.2295C2.6804 26.2501 2.46268 23.0526 4.06001 20.7818C5.90959 18.1514 9.93849 17.7184 12.4245 19.9263C13.4388 20.8269 14.362 21.8312 15.3271 22.7863C15.4464 22.9036 15.574 23.0126 15.7152 23.1415C15.7154 23.1416 15.7154 23.1418 15.7154 23.142V23.142ZM18.4835 16.0856C18.4833 16.0854 18.483 16.0855 18.483 16.0858C18.483 19.52 18.4809 22.9543 18.4851 26.3885C18.4851 27.0091 18.2423 27.4788 17.6686 27.722C17.1003 27.9632 16.58 27.8405 16.1404 27.3991C15.9803 27.2387 15.8191 27.0794 15.66 26.919C14.0354 25.2919 12.4234 23.6512 10.7811 22.0419C9.20786 20.5008 6.69674 20.9611 5.94937 22.9289C5.41972 24.3232 5.74839 25.5561 6.80037 26.6087C10.5435 30.3545 14.2856 34.1025 18.0214 37.8567C18.326 38.1629 18.6526 38.2918 19.0859 38.2918C24.0988 38.2813 29.1126 38.2845 34.1255 38.2855C34.989 38.2855 35.1848 38.1398 35.3889 37.3021C36.3184 33.486 37.2458 29.6689 38.1732 25.8528C38.5961 24.1135 37.9073 22.7443 36.2587 22.0618C33.13 20.7661 30.0003 19.4724 26.8695 18.1818C25.3685 17.5633 24.5509 16.3629 24.5499 14.7379C24.5468 11.7395 24.5551 8.7401 24.5436 5.74174C24.5373 3.99933 23.164 2.66894 21.438 2.70144C19.8291 2.73079 18.4924 4.15554 18.4861 5.88746C18.4746 9.28711 18.483 12.6868 18.4841 16.0853C18.4841 16.0856 18.4837 16.0858 18.4835 16.0856V16.0856Z" fill="white"/>
                            <path d="M38.2853 6.44512C37.9754 6.14528 37.6593 5.85279 37.3579 5.54561C36.756 4.93336 36.7173 4.15336 37.2511 3.58829C37.7996 3.00853 38.6056 3.00853 39.2441 3.62708C40.3442 4.69433 41.4339 5.77206 42.512 6.86133C43.1652 7.52076 43.1652 8.2672 42.512 8.93607C41.4286 10.0442 40.3327 11.1408 39.2284 12.229C38.637 12.8119 37.8132 12.8119 37.272 12.2636C36.7392 11.7227 36.7518 10.9469 37.3181 10.3482C37.5033 10.1527 37.696 9.96392 37.8899 9.7756C38.1154 9.55665 38.0982 9.26945 37.7839 9.26945V9.26945C36.1478 9.26211 34.5118 9.26421 32.8768 9.26316C32.5261 9.26316 32.1786 9.23905 31.8656 9.05978C31.3454 8.76204 31.091 8.12043 31.2502 7.52285C31.3915 6.99028 31.8939 6.58036 32.4853 6.57512C34.2082 6.56149 35.9312 6.56778 37.6541 6.56568C37.8236 6.56568 37.9923 6.56568 38.1616 6.56568C38.1985 6.56568 38.2325 6.54561 38.25 6.51312C38.2618 6.49124 38.2735 6.46935 38.2856 6.44747C38.286 6.4467 38.2859 6.44574 38.2853 6.44512V6.44512Z" fill="white"/>
                            <path d="M4.78775 6.58716C4.78803 6.58702 4.78834 6.58695 4.78865 6.58695C6.6297 6.58695 8.4718 6.58276 10.3129 6.58905C11.122 6.59219 11.6925 7.03041 11.795 7.70138C11.9322 8.59669 11.3271 9.28653 10.3819 9.29072C8.7124 9.29701 7.04285 9.29177 5.3733 9.29072V9.29072C5.09722 9.29072 4.94529 9.58697 5.14103 9.78167C5.33489 9.97451 5.53708 10.1434 5.71454 10.3349C6.06938 10.7176 6.24837 11.1505 6.10288 11.6705C5.8391 12.613 4.70234 13.0282 3.98323 12.3677C2.72924 11.2145 1.53073 9.99838 0.343725 8.77387C-0.114746 8.30105 -0.116839 7.60178 0.351053 7.10904C1.52445 5.87196 2.72715 4.66213 3.95497 3.47956C4.46473 2.98891 5.25397 3.07488 5.74594 3.57181C6.25465 4.08447 6.27768 4.83721 5.78886 5.41381C5.62033 5.61196 5.42983 5.79333 5.24037 5.9726C5.08582 6.11899 4.92135 6.2546 4.75945 6.39345C4.72465 6.4233 4.71709 6.474 4.74106 6.51309C4.75593 6.53734 4.77067 6.56173 4.78514 6.58639C4.78567 6.58729 4.78681 6.58763 4.78775 6.58716V6.58716Z" fill="white"/>
                        </svg>
                    </div>
                    <div class="transactions actions">
                        <input type="text" class="transactions" placeholder="Номер транзакции или ID пользователя">
                        <svg width="23" height="23" viewBox="0 0 23 23" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.36682 19.4918C7.14792 18.7108 7.14794 17.4444 6.36687 16.6633L6.33654 16.633C5.55548 15.8519 4.28911 15.852 3.50807 16.6331L1.41412 18.7272C0.633114 19.5082 0.633135 20.7745 1.41417 21.5555L1.44434 21.5857C2.22537 22.3667 3.49166 22.3668 4.27272 21.5858L6.36682 19.4918Z"
                                  fill="url(#paint0_linear)"/>
                            <path d="M14.2402 5.39062C12.8227 5.39062 11.4324 6.58002 10.4797 7.67952C9.94236 8.29959 9.94381 9.21058 10.4771 9.83411C11.3741 10.883 12.7529 12.1289 14.2402 12.1289C15.6577 12.1289 17.0479 10.9395 18.0007 9.84001C18.538 9.21994 18.5365 8.30895 18.0033 7.68542C17.1062 6.63655 15.7275 5.39062 14.2402 5.39062ZM14.2402 10.7812C13.1255 10.7812 12.2187 9.87439 12.2187 8.75977C12.2187 7.64514 13.1255 6.73828 14.2402 6.73828C15.3548 6.73828 16.2617 7.64514 16.2617 8.75977C16.2617 9.87439 15.3548 10.7812 14.2402 10.7812Z"
                                  fill="url(#paint1_linear)"/>
                            <path d="M14.2402 8.08594C13.8684 8.08594 13.5664 8.38793 13.5664 8.75977C13.5664 9.1316 13.8684 9.43359 14.2402 9.43359C14.6121 9.43359 14.9141 9.1316 14.9141 8.75977C14.9141 8.38793 14.6121 8.08594 14.2402 8.08594Z"
                                  fill="url(#paint2_linear)"/>
                            <path d="M14.2402 0C9.41026 0 5.48047 3.92979 5.48047 8.75977C5.48047 10.2013 5.8317 11.5988 6.50325 12.8582C6.66061 13.1533 6.62083 13.52 6.38438 13.7565C6.10302 14.0379 6.10304 14.4941 6.38443 14.7755L8.22448 16.6156C8.50587 16.897 8.96209 16.897 9.24351 16.6156C9.48 16.3792 9.84669 16.3394 10.1418 16.4967C11.4012 17.1683 12.7987 17.5195 14.2402 17.5195C19.0702 17.5195 23 13.5897 23 8.75977C23 3.92979 19.0702 0 14.2402 0ZM20.2092 9.10528C20.1027 9.28356 17.5613 13.4766 14.2402 13.4766C10.9192 13.4766 8.37775 9.28356 8.27124 9.10528C8.14395 8.89252 8.14395 8.62701 8.27124 8.41425C8.37775 8.23597 10.9192 4.04297 14.2402 4.04297C17.5613 4.04297 20.1027 8.23597 20.2092 8.41425C20.3365 8.62701 20.3365 8.89252 20.2092 9.10528Z"
                                  fill="url(#paint3_linear)"/>
                            <defs>
                                <linearGradient id="paint0_linear" x1="2.8355" y1="0.953346" x2="14.4232"
                                                y2="5.69971" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#85F362"/>
                                    <stop offset="0.958837" stop-color="#02AAFF"/>
                                </linearGradient>
                                <linearGradient id="paint1_linear" x1="12.9957" y1="-6.96289" x2="25.168"
                                                y2="-0.171759" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#85F362"/>
                                    <stop offset="0.958837" stop-color="#02AAFF"/>
                                </linearGradient>
                                <linearGradient id="paint2_linear" x1="14.0575" y1="5.61523" x2="16.0644"
                                                y2="6.43728" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#85F362"/>
                                    <stop offset="0.958837" stop-color="#02AAFF"/>
                                </linearGradient>
                                <linearGradient id="paint3_linear" x1="11.8647" y1="-32.1191" x2="37.9548"
                                                y2="-21.4325" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#85F362"/>
                                    <stop offset="0.958837" stop-color="#02AAFF"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                    <div class="col-12 explorer-wrapper">
                        <div class="order-list-header">
                            <div class="order">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-4">Хеш</div>
                                        <div class="col-3">Время</div>
                                        <div class="col-3">Отправлено</div>
                                        <div class="col-2">Получено</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="orders-list explorer-list">
                            <div class="orders-list-wrapper">
                                @foreach ($transactions as $transaction)
                                    <div class="order">
                                        <div class="col-12 order-wrapper">
                                            <div class="row justify-content-between align-items-center">
                                                <div class="hash">
                                                    <div class="row justify-content-center">
                                                        <a>{{ $transaction['uuid'] }}</a>
                                                    </div>
                                                </div>
                                                <div class="date">
                                                    {{ $transaction['date'] }}
                                                </div>
                                                <div class="amount-source">
                                                    <strong>{!! $transaction['amount'] . '&nbsp;' . $transaction['currency'] !!}</strong>
                                                </div>
                                                <div class="amount">
                                                    <strong>{{ $transaction['amount_dhb'] }}&nbsp;DHB</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="search-items">
                            <p>По вашему запросу ничего не найдено</p>
                        </div>
                    </div>
                </div>

                <div class="text-center w-100">
                    <a style="margin:30px 0;" onclick="infinteLoadMore()"
                       class="button button-blue loadmore">Загрузить еще</a>
                    <div class="alert"></div>
                </div>
            </div>
        </section>
        <footer>
            <div class="container-fluid">
                <div class="col-12">
                    <div class="row justify-content-center align-items-center justify-content-md-between">
                        <div class="footer-logo">
                            <svg width="122" height="40" viewBox="0 0 122 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_544_171)">
                                    <path d="M61.2191 21.2044C61.2191 19.3795 61.2301 17.56 61.2136 15.7351C61.2136 15.3051 61.3562 15.1727 61.773 15.1782C63.2044 15.2003 64.6357 15.1452 66.0616 15.1948C68.2607 15.272 70.1802 15.9556 71.3977 17.957C72.8894 20.405 72.6042 25.1024 69.0066 26.6517C68.184 27.0046 67.3339 27.2251 66.4345 27.2306C64.888 27.2416 63.336 27.2196 61.7895 27.2472C61.3507 27.2527 61.2027 27.1314 61.2082 26.6738C61.2301 24.8488 61.2191 23.0294 61.2191 21.2044ZM63.4896 21.1603C63.4896 22.3733 63.5005 23.5862 63.4841 24.8047C63.4841 25.1355 63.5938 25.2513 63.9173 25.2403C64.729 25.2237 65.5406 25.2513 66.3468 25.2237C68.0688 25.1576 69.3466 24.1596 69.7634 22.5828C69.9444 21.8991 69.9389 21.1989 69.8731 20.5097C69.7086 18.8502 68.6666 17.6979 67.0488 17.3395C66.0177 17.1135 64.9648 17.2237 63.9228 17.1851C63.5608 17.1741 63.4731 17.3175 63.4786 17.6538C63.495 18.8226 63.4841 19.9915 63.4841 21.1603H63.4896Z" fill="white"/>
                                    <path d="M114.278 18.8392C115.512 17.8578 116.911 17.6373 118.408 17.9626C119.483 18.1941 120.366 18.7731 121.029 19.6552C122.417 21.4912 122.296 24.2589 120.821 25.9516C119.45 27.5284 116.439 28.3058 114.092 26.4423C114.07 26.4588 114.037 26.4753 114.031 26.4974C113.929 26.9899 113.622 27.2362 113.11 27.2362C112.342 27.2362 111.958 26.8539 111.958 26.0894C111.958 22.5332 111.958 18.9771 111.958 15.4209C111.958 14.7703 111.975 14.7538 112.633 14.7538C112.973 14.7538 113.313 14.7703 113.648 14.7538C114.064 14.7262 114.223 14.8695 114.212 15.3051C114.185 16.3251 114.202 17.3506 114.207 18.3706C114.207 18.5139 114.163 18.6628 114.278 18.8337V18.8392ZM119.746 22.6766C119.746 21.006 118.6 19.8316 116.966 19.8316C115.331 19.8316 114.108 21.0611 114.119 22.6986C114.13 24.3085 115.359 25.5656 116.933 25.5766C118.534 25.5932 119.746 24.3416 119.746 22.6766Z" fill="white"/>
                                    <path d="M89.139 20.995C89.139 19.1149 89.139 17.2293 89.139 15.3492C89.139 14.8034 89.1774 14.7648 89.7094 14.7593C90.0933 14.7593 90.4771 14.7758 90.861 14.7538C91.2723 14.7262 91.393 14.9026 91.3875 15.2996C91.3656 16.3361 91.3765 17.3726 91.3875 18.4092C91.3875 18.5194 91.3272 18.6683 91.4643 18.7234C91.5685 18.762 91.6453 18.6463 91.7275 18.5911C93.0931 17.6979 94.5519 17.6042 96.0435 18.1445C97.5901 18.7014 98.1494 19.9915 98.2756 21.5243C98.4182 23.2555 98.3194 24.9867 98.3524 26.7179C98.3578 27.1259 98.2153 27.2748 97.8094 27.2472C97.3817 27.2196 96.9539 27.2196 96.5261 27.2472C96.1587 27.2693 96.0326 27.1204 96.0326 26.762C96.0435 25.312 96.0381 23.8565 96.0326 22.4064C96.0326 21.9929 96.0326 21.5794 95.9119 21.1714C95.6761 20.3885 95.1222 19.9309 94.3106 19.8537C92.4624 19.6773 91.382 20.6531 91.3765 22.5167C91.3711 23.9226 91.3656 25.3341 91.3765 26.74C91.3765 27.1314 91.2559 27.2748 90.8665 27.2472C90.4552 27.2196 90.0384 27.2196 89.6271 27.2472C89.2268 27.2748 89.1226 27.0984 89.1226 26.729C89.1335 24.8158 89.1226 22.9081 89.1226 20.995H89.139Z" fill="white"/>
                                    <path d="M80.4465 26.3266C79.5526 26.9993 78.5764 27.3466 77.518 27.4569C76.5254 27.5561 75.5547 27.4459 74.754 26.7953C73.8272 26.0455 73.5859 25.0144 73.7833 23.8732C73.9588 22.8642 74.7101 22.39 75.5876 22.1199C76.9312 21.7064 78.3187 21.7119 79.7007 21.8222C80.1943 21.8608 80.2326 21.8442 80.2381 21.348C80.2436 20.521 79.9365 20.0854 79.1413 19.8539C78.4284 19.6499 77.7209 19.6554 77.0244 19.9421C76.7283 20.0634 76.4267 20.2288 76.3225 20.5155C76.1689 20.918 75.9002 20.9345 75.5602 20.9235C75.1488 20.9069 74.7375 20.9124 74.3207 20.9235C74.0191 20.929 73.9259 20.7801 73.9643 20.51C74.052 19.8318 74.3701 19.2805 74.8746 18.8339C75.5218 18.266 76.3005 18.0069 77.1286 17.9076C78.3406 17.7588 79.5471 17.8029 80.6823 18.3156C81.8669 18.8504 82.514 19.7491 82.5031 21.0944C82.4866 22.9579 82.4866 24.827 82.5031 26.6905C82.5031 27.1096 82.3824 27.3025 81.9547 27.2419C81.8669 27.2308 81.7792 27.2419 81.6914 27.2419C81.0516 27.2419 80.6348 26.9368 80.441 26.3266H80.4465ZM78.8397 23.4155C78.1925 23.399 77.5454 23.399 76.9147 23.581C76.295 23.7629 76.0373 24.0441 76.0373 24.5348C76.0373 25.053 76.3608 25.4445 76.9422 25.5823C77.9293 25.8249 78.8342 25.5934 79.6787 25.0586C80.1559 24.7553 80.2985 24.3087 80.2491 23.7629C80.2272 23.5203 80.1449 23.4155 79.9036 23.4211C79.5526 23.4266 79.1961 23.4211 78.8452 23.4211L78.8397 23.4155Z" fill="white"/>
                                    <path d="M100.529 21.0501C100.529 20.2231 100.54 19.3905 100.529 18.5635C100.529 18.2437 100.634 18.1004 100.963 18.1114C101.418 18.1279 101.878 18.1279 102.334 18.1114C102.69 18.0949 102.794 18.2603 102.789 18.5911C102.778 19.997 102.789 21.4084 102.789 22.8144C102.789 23.1838 102.805 23.5532 102.887 23.9171C103.173 25.1686 104.056 25.6648 105.3 25.549C106.704 25.4167 107.324 24.6283 107.341 23.0956C107.357 21.629 107.357 20.1624 107.341 18.6958C107.335 18.2492 107.461 18.0783 107.916 18.1114C108.339 18.1445 108.772 18.1279 109.2 18.1169C109.479 18.1114 109.611 18.2217 109.606 18.5084C109.567 20.3113 109.715 22.1252 109.529 23.9226C109.315 25.9956 107.867 27.374 105.783 27.4953C105.18 27.5284 104.577 27.5559 103.979 27.4457C101.813 27.0377 100.612 25.6373 100.551 23.4098C100.529 22.6269 100.551 21.8385 100.551 21.0556L100.529 21.0501Z" fill="white"/>
                                    <path d="M85.9254 24.3801C86.6341 24.3801 87.2087 23.8025 87.2087 23.0899C87.2087 22.3774 86.6341 21.7998 85.9254 21.7998C85.2166 21.7998 84.6421 22.3774 84.6421 23.0899C84.6421 23.8025 85.2166 24.3801 85.9254 24.3801Z" fill="white"/>
                                    <path opacity="0.9" d="M17.0503 18.0236C-8.51122 15.5536 0.460817 5.94922 7.11855 3.55087C33.914 -6.10316 61.044 4.52124 48.0466 28.3503C46.9443 30.3682 45.2771 29.4034 43.7142 27.8762C39.4256 23.6804 31.6052 19.4241 17.0503 18.0181V18.0236Z" fill="white"/>
                                    <g opacity="0.9">
                                        <path d="M36.9136 20.2397C37.1165 20.2894 37.3194 20.339 37.5168 20.3996C37.3139 20.3445 37.1165 20.2894 36.9136 20.2397Z" fill="white"/>
                                        <path d="M38.1968 20.6424C38.4052 20.7251 38.6081 20.8078 38.8055 20.8905C41.1418 21.916 42.6115 23.6031 43.308 25.8361C43.9222 27.8044 42.6883 31.7355 40.1436 33.8416C37.4509 36.0745 34.0179 37.7341 31.731 38.5501C24.2561 41.2296 17.1048 40.2647 15.657 34.9333C13.9405 28.5818 28.1444 18.2441 36.9025 20.2399C37.3522 20.3557 37.78 20.488 38.1858 20.6369L38.1968 20.6424Z" fill="white"/>
                                    </g>
                                    <path opacity="0.9" d="M16.7213 14.0152C22.4522 15.2944 16.7213 27.2475 12.345 25.9904C5.78047 24.0993 10.4146 12.6038 16.7213 14.0152Z" fill="white"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0_544_171">
                                        <rect width="122" height="40" fill="white"/>
                                    </clipPath>
                                </defs>
                            </svg>
                            <p>2022 Copyright. <br />All Rights Reserved. </p>
                        </div>
                        <div class="footer-menu menu">
                            <a class="button totop" href="#totop">Наверх</a>
                            <nav class="nav justify-content-lg-end justify-content-center">
                                <li class="nav-item">
                                    <a class="nav-link" href="https://docs.dahub.app/" target="_blank">Gitbook</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="https://t.me/DA_HUB" target="_blank">Telegram</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="https://t.me/DaHubSupportBot?start=dashboard" target="_blank">Поддержка</a>
                                </li>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <div class="mobile-hidden">
            <div class="mobile-wrapper w-100 h-100 d-flex flex-column justify-content-between">
                <a class="menu-close">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="2.12109" width="41" height="3" rx="1.5" transform="rotate(45 2.12109 0)" fill="white"/>
                        <rect width="41" height="3" rx="1.5" transform="matrix(-0.707107 0.707107 0.707107 0.707107 28.9912 0)" fill="white"/>
                    </svg>
                </a>
                <div class="mobile-menu">
                    @auth
                        <a class="button logined text-left" href="/dashboard/profile">
                            <span class="icon-wrapper">
                                <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="17" cy="17" r="17" fill="#0D1B34"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M13.25 13.25C13.25 11.15 14.9 9.5 17 9.5C19.1 9.5 20.75 11.15 20.75 13.25C20.75 15.35 19.1 17 17 17C14.9 17 13.25 15.35 13.25 13.25ZM23.75 22.25V23.75C23.75 24.2 23.45 24.5 23 24.5C22.55 24.5 22.25 24.2 22.25 23.75V22.25C22.25 20.975 21.275 20 20 20H14C12.725 20 11.75 20.975 11.75 22.25V23.75C11.75 24.2 11.45 24.5 11 24.5C10.55 24.5 10.25 24.2 10.25 23.75V22.25C10.25 20.15 11.9 18.5 14 18.5H20C22.1 18.5 23.75 20.15 23.75 22.25ZM17 15.5C15.725 15.5 14.75 14.525 14.75 13.25C14.75 11.975 15.725 11 17 11C18.275 11 19.25 11.975 19.25 13.25C19.25 14.525 18.275 15.5 17 15.5Z" fill="black"/>
                                    <mask id="mask0_0_1" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="10" y="9" width="14" height="16">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M13.25 13.25C13.25 11.15 14.9 9.5 17 9.5C19.1 9.5 20.75 11.15 20.75 13.25C20.75 15.35 19.1 17 17 17C14.9 17 13.25 15.35 13.25 13.25ZM23.75 22.25V23.75C23.75 24.2 23.45 24.5 23 24.5C22.55 24.5 22.25 24.2 22.25 23.75V22.25C22.25 20.975 21.275 20 20 20H14C12.725 20 11.75 20.975 11.75 22.25V23.75C11.75 24.2 11.45 24.5 11 24.5C10.55 24.5 10.25 24.2 10.25 23.75V22.25C10.25 20.15 11.9 18.5 14 18.5H20C22.1 18.5 23.75 20.15 23.75 22.25ZM17 15.5C15.725 15.5 14.75 14.525 14.75 13.25C14.75 11.975 15.725 11 17 11C18.275 11 19.25 11.975 19.25 13.25C19.25 14.525 18.275 15.5 17 15.5Z" fill="white"/>
                                    </mask>
                                    <g mask="url(#mask0_0_1)">
                                    <rect x="8" y="8" width="18" height="18" fill="#848FAD"/>
                                    </g>
                                </svg>

                            </span>
                            {{ auth()->user()->name }}</a>
                    @endauth
                    <nav class="nav flex-column">
                        @auth
                        <li class="nav-item">
                            <a class="nav-link" href="/wallet" target="_blank">Кошелек</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/dashboard" target="_blank">Токен Сейл</a>
                        </li>
                        @endauth
                        <li class="nav-item">
                            <a class="nav-link" href="https://docs.dahub.app/" target="_blank">Gitbook</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://t.me/DA_HUB" target="_blank">Telegram</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://t.me/DaHubSupportBot?start=dashboard" target="_blank">Поддержка</a>
                        </li>
                    </nav>
                </div>
                <div class="menu-footer">
                    @auth
                        <a class="button" href="/logout">Выйти</a>
                    @endauth
                    @guest
                        <a class="button" href="https://t.me/{{env('TELEGRAM_BOT_NAME')}}?start=login{{ app('request')->input('ref') }}">Войти / Регистрация</a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(window).on('load', function() { // makes sure the whole site is loaded
        $('#loader').delay(2500).fadeOut('slow');
    })
</script>
<script src="/js/jquery.paroller.min.js"></script>
<script>
    let ENDPOINT = "{{ url('/') }}";
    let page = 1;
    let _token = $('meta[name="csrf-token"]').attr('content');

    function infinteLoadMore() {
        page++;
        $.ajax({
            url: ENDPOINT + "/dashboard/explorer?page=" + page,
            datatype: "html",
            type: "GET",
            cache: false,
            headers: { "cache-control": "no-cache" },
            data: {
                _token: _token,
            }
        })
        .done(function (response) {
            if (!Object.keys(JSON.parse(response)).length) {
                $('.alert').html("Вы загрузили все транзакции").show();
                $('.loadmore').hide()
                return;
            }
            $.each(JSON.parse(response), function (index, value) {
                $('.orders-list.explorer-list .orders-list-wrapper').append(
                    ' <div class="order">\n' +
                    '<div class="col-12 order-wrapper">\n' +
                    '<div class="row">\n' +
                    '<div class="hash">\n' +
                    '<a>' + value.uuid + '</a>\n' +
                    '</div>\n' +
                    '<div class="date">\n' + value.date + '\n' +
                    '</div>\n' +
                    '<div class="amount-source">\n' +
                    '<strong>' + value.amount + '&nbsp;' + value.currency + '</strong>\n' +
                    '</div>\n' +
                    '<div class="amount">\n' +
                    '<strong>' + value.amount_dhb + '&nbsp;DHB</strong>\n' +
                    '</div>\n' +
                    '</div>\n' +
                    '</div>\n' +
                    '</div>'
                )
            });
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            console.log('Ошибка при попытке выполнения запроса');
        });
    }

    $('input.transactions').on('input', function (e) {
        $('.searching').removeClass('error')
        var transaction = $(this).val();
        if (!transaction) $('.explorer-wrapper').removeClass('searching');
        else {
            $.ajax({
                url: ENDPOINT + "/api/getTransactions",
                datatype: "json",
                type: "post",
                data: {
                    _token: _token,
                    value: transaction
                },
                beforeSend: function () {
                    $('.explorer-wrapper').addClass('searching');
                }
            })
            .done(function (response) {
                $('.searching').removeClass('error')
                if (!Object.keys(JSON.parse(response)).length) {
                    return;
                }
                $('.search-items').html('')
                $.each(JSON.parse(response), function (index, value) {
                    $('.search-items').append(
                        ' <div class="order">\n' +
                        '<div class="col-12 order-wrapper">\n' +
                        '<div class="row">\n' +
                        '<div class="col-lg-4 hash">\n' +
                        '<a>' + value.uuid + '</a>\n' +
                        '</div>\n' +
                        '<div class="date">\n' + value.date + '\n' +
                        '</div>\n' +
                        '<div class="amount-source">\n' +
                        '<strong>' + value.amount + '&nbsp;' + value.currency + '</strong>\n' +
                        '</div>\n' +
                        '<div class="amount">\n' +
                        '<strong>' + value.dhb_amount + '&nbsp;DHB</strong>\n' +
                        '</div>\n' +
                        '</div>\n' +
                        '</div>\n' +
                        '</div>'
                    )
                });
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                $('.searching').addClass('error')
                $('.search-items').html('<p>По вашему запросу ничего не найдено</p>')
            });
        }
    })

    window.currencies = {};
    @foreach (\App\Models\Currency::all() as $currency)
        window.currencies.{{$currency->title}} = {}
    window.currencies.{{$currency->title}}.decimalPlaces = {{$currency->decimal_places}}
    @endforeach

    $('.deposit-block input, .deposit-block select').on('change', function (e) {
        changeInputValues(e)
    })

    function changeInputValues(e) {
        let amount = $('input[name="deposit-amount"]')
        let currency = $('select[name="deposit-currency"]')
        let depositRecieve = $('.deposit-receive')
        let rate = {
            DHB: '{!! Rate::getRates('DHB') !!}',
            @foreach ($currencies as $currency)
                {{$currency->title}} : '{!! Rate::getRates($currency->title) !!}',
            @endforeach
        }

        let min = parseInt($('.deposit-block input[name="deposit-amount"]').data('min'));
        let max = parseInt($('.deposit-block input[name="deposit-amount"]').data('max'));

        if ($(e.target).is(depositRecieve)) {
            let amountTotal = rate[currency.val()] * depositRecieve.val() / rate['DHB']
            amount.val(amountTotal.toFixed(window.currencies[currency.val()]['decimalPlaces']))
        }
        if (amount.val() > max) amount.val(max)
        if (amount.val() < min) amount.val(min)
        let amountTotal = rate['DHB'] * amount.val() / rate[currency.val()]
        depositRecieve.val(amountTotal.toFixed(window.currencies[currency.val()]['decimalPlaces']))
        amount.val(parseInt(amount.val()))


    }
    $('.header-wrapper .menu-icon, .mobile-hidden .menu-close').click(function(){
        $('.mobile-hidden').toggleClass('opened')
    })

    $(function () {
        $(window).paroller();
    });

    $("a[href='#totop']").click(function() {
        $("html, body").animate({ scrollTop: 0 }, "slow");
        return false;
    });

    $('.carousel').carousel({
        interval: 20000
    })

</script>
</body>
</html>
