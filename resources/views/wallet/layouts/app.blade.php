<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta id="vp" name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Da·Hub - Dashboard</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="/fonts/Gotham/style.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#9f00a7">
    <meta name="theme-color" content="#ffffff">
    <script
        src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
    @yield('css')
</head>
<body>
<div class="app">
    <nav class="navbar navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{Route('wallet')}}">
                <svg height="34" viewBox="0 0 124 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.9" d="M10.9424 11.6964C-5.00206 10.1964 0.586711 4.3571 4.75089 2.91067C21.5172 -2.98219 38.4479 3.49996 30.3387 17.9642C29.6264 19.1964 28.5853 18.6071 27.6539 17.6964C24.9691 15.125 20.0378 12.5535 10.9424 11.6964Z" fill="white"/>
                    <g opacity="0.9">
                        <path opacity="0.9" d="M23.3794 13.0359C23.489 13.0895 23.6534 13.0895 23.7629 13.143C23.6534 13.0895 23.489 13.0895 23.3794 13.0359Z" fill="white"/>
                        <path opacity="0.9" d="M24.2015 13.3037C24.3111 13.3573 24.4755 13.4108 24.5851 13.4644C26.0644 14.1073 26.9411 15.1251 27.3794 16.4644C27.763 17.643 26.9959 20.0537 25.4069 21.3394C23.7084 22.6787 21.5715 23.6966 20.1469 24.1787C15.4896 25.7858 10.9967 25.1966 10.12 21.9823C9.02417 18.1251 17.9005 11.8573 23.3796 13.0358C23.6536 13.0894 23.9276 13.1966 24.2015 13.3037Z" fill="white"/>
                    </g>
                    <path opacity="0.9" d="M10.7778 9.28576C14.3392 10.0893 10.7778 17.3215 8.03817 16.5715C3.92878 15.3929 6.83275 8.42861 10.7778 9.28576Z" fill="white"/>
                    <path d="M45.5157 12.5355C45.5157 10.2855 45.5157 7.98196 45.5157 5.73196C45.5157 5.19624 45.6801 5.03553 46.228 5.03553C48.0362 5.03553 49.8991 4.98196 51.7072 5.03553C54.5016 5.14267 56.9672 5.99981 58.5562 8.4641C60.4739 11.5177 60.0904 17.357 55.4878 19.2855C54.4468 19.7141 53.351 19.982 52.2003 19.982C50.2278 19.982 48.2553 19.982 46.228 19.982C45.6801 19.982 45.4609 19.8212 45.4609 19.2855C45.5157 17.0891 45.5157 14.8391 45.5157 12.5355ZM48.4197 12.482C48.4197 13.982 48.4197 15.482 48.4197 17.0355C48.4197 17.4641 48.5841 17.5712 48.9676 17.5712C50.0087 17.5712 51.0497 17.5712 52.0908 17.5712C54.2824 17.4641 55.9262 16.232 56.4741 14.3034C56.6933 13.4462 56.6933 12.5891 56.6385 11.732C56.4193 9.64267 55.1043 8.24981 53.0222 7.76767C51.7072 7.49981 50.3374 7.60696 49.0224 7.55339C48.5841 7.55339 48.4197 7.7141 48.4745 8.14267C48.4197 9.5891 48.4197 11.0355 48.4197 12.482Z" fill="white"/>
                    <path d="M113.457 9.58918C115.046 8.35703 116.854 8.08918 118.717 8.51775C120.087 8.78561 121.238 9.53561 122.06 10.607C123.813 12.9106 123.703 16.3392 121.786 18.4285C120.032 20.4106 116.197 21.3749 113.183 19.0177L113.129 19.0713C112.909 19.982 112.909 19.982 111.923 19.982C110.444 19.982 110.444 19.982 110.444 18.5356C110.444 14.0892 110.444 9.69632 110.444 5.24989C110.444 4.44632 110.444 4.44632 111.321 4.39275C111.759 4.39275 112.197 4.39275 112.636 4.39275C113.183 4.33918 113.348 4.55346 113.348 5.08918C113.293 6.37489 113.348 7.66061 113.348 8.89275C113.348 9.21418 113.293 9.37489 113.457 9.58918ZM120.471 14.357C120.471 12.2677 118.991 10.8213 116.909 10.8213C114.827 10.8213 113.238 12.3749 113.238 14.4106C113.238 16.3927 114.827 17.9999 116.854 17.9999C118.882 17.9999 120.471 16.4463 120.471 14.357Z" fill="white"/>
                    <path d="M81.295 12.2678C81.295 9.91064 81.295 7.60707 81.295 5.24993C81.295 4.5535 81.3498 4.49993 82.0073 4.49993C82.5005 4.49993 82.9936 4.49993 83.4867 4.49993C84.0346 4.44635 84.1442 4.66064 84.1442 5.19635C84.0894 6.48207 84.1442 7.76778 84.1442 9.0535C84.1442 9.21421 84.0894 9.37493 84.2538 9.4285C84.3634 9.48207 84.473 9.32135 84.5825 9.26778C86.3359 8.14278 88.1988 8.03564 90.1165 8.73207C92.089 9.4285 92.8013 11.0356 92.9657 12.9642C93.1301 15.1071 93.0205 17.3035 93.0753 19.4464C93.0753 19.9285 92.9109 20.1428 92.363 20.0892C91.8151 20.0356 91.2672 20.0356 90.7192 20.0892C90.2261 20.0892 90.0617 19.9285 90.1165 19.4999C90.1165 17.6785 90.1165 15.8571 90.1165 14.0892C90.1165 13.5535 90.1165 13.0714 89.9522 12.5356C89.6234 11.5714 88.9659 10.9821 87.9248 10.8749C85.5688 10.6606 84.199 11.8928 84.1442 14.1964C84.1442 15.9642 84.1442 17.6785 84.1442 19.4464C84.1442 19.9285 83.9798 20.0892 83.4867 20.0892C82.9388 20.0356 82.4457 20.0356 81.8977 20.0892C81.4046 20.1428 81.2402 19.9285 81.2402 19.4464C81.295 17.0356 81.295 14.6785 81.295 12.2678Z" fill="white"/>
                    <path d="M70.1173 18.9105C68.9667 19.7677 67.7065 20.1962 66.3915 20.3034C65.1313 20.4105 63.8711 20.3034 62.83 19.4998C61.6246 18.5891 61.3507 17.3034 61.5698 15.8569C61.789 14.6248 62.7752 14.0355 63.8711 13.6605C65.5696 13.1248 67.3778 13.1784 69.1311 13.2855C69.7886 13.3391 69.7886 13.3391 69.8434 12.6962C69.8434 11.6784 69.4598 11.1427 68.4188 10.8212C67.4873 10.5534 66.6107 10.5534 65.6792 10.9284C65.2957 11.0891 64.9121 11.3034 64.8025 11.6248C64.5834 12.1069 64.2546 12.1605 63.8163 12.1605C63.2684 12.1605 62.7752 12.1605 62.2273 12.1605C61.8438 12.1605 61.7342 11.9998 61.789 11.6248C61.8986 10.7677 62.2821 10.0712 62.9396 9.53551C63.7615 8.83908 64.7477 8.51765 65.8436 8.35694C67.3778 8.19623 68.9119 8.2498 70.3913 8.83908C71.9255 9.48194 72.7474 10.6069 72.7474 12.3212C72.7474 14.6248 72.7474 16.9819 72.7474 19.2855C72.7474 19.8212 72.583 20.0355 72.0351 19.9819C71.9255 19.9819 71.8159 19.9819 71.7063 19.9819C70.5009 20.0355 70.5009 20.0355 70.1173 18.9105ZM68.09 15.2677C67.2682 15.2677 66.4463 15.2677 65.6244 15.4819C64.8573 15.6962 64.4738 16.0712 64.5286 16.6605C64.5286 17.3034 64.9669 17.7855 65.6792 17.9462C66.9394 18.2677 68.09 17.9462 69.1859 17.3034C69.7886 16.9284 70.0078 16.3927 69.8982 15.6962C69.8434 15.3748 69.7886 15.2677 69.4598 15.2677C68.9667 15.3212 68.5284 15.2677 68.09 15.2677Z" fill="white"/>
                    <path d="M95.8697 12.3212C95.8697 11.3033 95.8697 10.2319 95.8697 9.21403C95.8697 8.83903 95.9793 8.62474 96.4176 8.67831C97.0204 8.67831 97.5683 8.67831 98.171 8.67831C98.6093 8.67831 98.7737 8.83903 98.7737 9.2676C98.7737 11.0355 98.7737 12.7497 98.7737 14.5176C98.7737 14.9997 98.7737 15.4283 98.8833 15.9105C99.2668 17.464 100.363 18.1069 101.952 17.9462C103.76 17.7855 104.527 16.8212 104.582 14.8926C104.582 13.0712 104.582 11.2497 104.582 9.42831C104.582 8.8926 104.746 8.67831 105.294 8.67831C105.842 8.73188 106.39 8.67831 106.938 8.67831C107.266 8.67831 107.486 8.78545 107.431 9.16045C107.376 11.4105 107.595 13.6605 107.321 15.9105C107.047 18.4819 105.184 20.1962 102.5 20.3569C101.732 20.4105 100.965 20.4105 100.198 20.3033C97.4039 19.8212 95.8697 18.0533 95.8149 15.2676C95.8149 14.3033 95.8697 13.339 95.8697 12.3212Z" fill="white"/>
                    <path d="M77.1306 16.4999C78.0384 16.4999 78.7743 15.7804 78.7743 14.8928C78.7743 14.0052 78.0384 13.2856 77.1306 13.2856C76.2228 13.2856 75.4868 14.0052 75.4868 14.8928C75.4868 15.7804 76.2228 16.4999 77.1306 16.4999Z" fill="white"/>
                </svg>



            </a>

            <div class="d-flex" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto flex-row">
                    <li class="nav-item">
                        <a href="{{ route('wallet.explorer') }}" class="nav-link">
                            <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.5422 19.6494L19.6497 16.542L25 21.8927L21.8929 24.9997L16.5422 19.6494Z" fill="white"/>
                                <path d="M9.52142 5.85938C11.6071 5.85938 13.6384 8.2283 14.5095 9.5171C13.8265 10.5164 11.7902 13.1836 9.52142 13.1836C7.43574 13.1836 5.40441 10.8147 4.53333 9.52587C5.21635 8.52661 7.25263 5.85938 9.52142 5.85938ZM9.52142 11.7188C10.733 11.7188 11.7187 10.733 11.7187 9.52148C11.7187 8.30994 10.733 7.32422 9.52142 7.32422C8.30988 7.32422 7.32416 8.30994 7.32416 9.52148C7.32416 10.733 8.30988 11.7188 9.52142 11.7188Z" fill="white"/>
                                <path d="M9.52148 8.78906C9.92565 8.78906 10.2539 9.11732 10.2539 9.52148C10.2539 9.92565 9.92565 10.2539 9.52148 10.2539C9.11732 10.2539 8.78906 9.92565 8.78906 9.52148C8.78906 9.11732 9.11732 8.78906 9.52148 8.78906Z" fill="white"/>
                                <path d="M9.52148 0C14.7715 0 19.043 4.27151 19.043 9.52148C19.043 11.2967 18.553 13.0104 17.6218 14.514L18.6142 15.5066L15.5066 18.6142L14.514 17.6218C13.0104 18.553 11.2967 19.043 9.52148 19.043C4.27151 19.043 0 14.7715 0 9.52148C0 4.27151 4.27151 0 9.52148 0ZM3.03345 9.89704C3.14922 10.0908 5.91164 14.6484 9.52148 14.6484C13.1313 14.6484 15.8937 10.0908 16.0095 9.89704L16.2342 9.52148L16.0095 9.14593C15.8937 8.95214 13.1313 4.39453 9.52148 4.39453C5.91164 4.39453 3.14922 8.95214 3.03345 9.14593L2.80876 9.52148L3.03345 9.89704Z" fill="white"/>
                            </svg>

                            <span>Обозреватель</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="https://t.me/DA_HUB" class="nav-link" target="_blank">
                            <svg width="26" height="23" viewBox="0 0 26 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0)">
                                    <path opacity="0.9" d="M-1.71661e-05 0.818791C0.040535 1.19474 0.162199 1.63764 0.253445 2.08055C0.892166 5.22721 1.53596 8.37387 2.17974 11.5205C2.90971 15.105 3.64475 18.6894 4.37978 22.2686C4.52679 22.9948 5.0844 23.2059 5.68764 22.763C7.35541 21.5322 9.02318 20.3013 10.691 19.0756C10.9647 18.8748 11.2384 18.6739 11.5122 18.4731C11.9431 18.1538 12.3739 18.1538 12.7947 18.4988C13.8339 19.3486 14.8629 20.2086 15.897 21.0687C16.0947 21.2335 16.2975 21.3983 16.5662 21.388C16.9007 21.3777 17.1542 21.1665 17.2708 20.7854C17.5597 19.8687 17.8335 18.952 18.1174 18.0353C18.5685 16.5624 19.0197 15.0895 19.4658 13.6114C19.5266 13.4054 19.633 13.287 19.8409 13.2097C21.6861 12.5196 23.5262 11.8141 25.3714 11.1137C25.5387 11.0519 25.706 10.9849 25.8276 10.8459C26.1774 10.439 26.0101 9.85193 25.4728 9.63563C24.6871 9.31633 23.8963 9.01763 23.1105 8.70862C19.9828 7.48292 16.8602 6.25206 13.7325 5.03151C10.9951 3.9603 8.27294 2.8994 5.5457 1.8282C4.11112 1.26684 2.6816 0.700341 1.24701 0.138988C1.13549 0.097788 1.02397 0.0514378 0.912443 0.0205376C0.435936 -0.0979129 -1.71661e-05 0.247139 -1.71661e-05 0.818791ZM18.1072 13.1737C18.1021 13.2097 18.1021 13.3127 18.0768 13.4106C17.6662 14.8887 17.2556 16.3616 16.8399 17.8396C16.7943 17.9993 16.7233 18.128 16.5307 18.1177C16.333 18.1074 16.2924 17.9529 16.2671 17.7933C16.1911 17.2525 16.0998 16.7066 16.0542 16.1607C15.9832 15.2955 15.7551 14.5436 15.0809 13.9307C13.5399 12.5299 12.0394 11.0828 10.5237 9.65108C9.1195 8.32752 7.71533 7.00397 6.31116 5.67526C6.11852 5.49501 5.93096 5.30961 5.7434 5.12421C5.66736 5.04696 5.61667 4.95426 5.68764 4.85126C5.76875 4.73281 5.86506 4.78431 5.95631 4.83581C6.007 4.86671 6.05769 4.89761 6.10839 4.92851C6.9296 5.44351 7.74574 5.95336 8.56696 6.46837C11.5629 8.34297 14.5638 10.2176 17.5597 12.0922C17.9247 12.3291 18.1123 12.669 18.1072 13.1737Z" fill="white"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0">
                                        <rect width="26" height="23" fill="white" transform="matrix(-1 0 0 1 26 0)"/>
                                    </clipPath>
                                </defs>
                            </svg>
                            <span>Паблик</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="http://t.me/DA_HUB_CHAT" class="nav-link" target="_blank">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0)">
                                    <path opacity="0.9" d="M2.91194 18.8045H1.49483L2.49687 17.8025C3.03716 17.2622 3.37455 16.5595 3.46526 15.7971C1.15153 14.2788 0 12.0791 0 9.77307C0 5.51873 3.91015 1.19531 10.0339 1.19531C16.5213 1.19531 20 5.17366 20 9.40034C20 13.6549 16.4846 17.6306 10.0339 17.6306C8.90388 17.6306 7.72473 17.4797 6.67198 17.2029C5.67541 18.2251 4.32514 18.8045 2.91194 18.8045Z" fill="white"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0">
                                        <rect width="20" height="20" fill="white"/>
                                    </clipPath>
                                </defs>
                            </svg>
                            <span>Чат</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/docs/Dahub.pdf" class="nav-link" target="_blank">
                            <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.9" d="M10.4996 0C4.70133 0 0 4.70133 0 10.4996C0 16.2978 4.70133 21 10.4996 21C16.2978 21 21 16.2978 21 10.4996C21 4.70133 16.2978 0 10.4996 0ZM12.6853 16.2729C12.1449 16.4862 11.7147 16.648 11.392 16.76C11.0702 16.872 10.696 16.928 10.2702 16.928C9.616 16.928 9.10667 16.768 8.744 16.4489C8.38133 16.1298 8.20089 15.7253 8.20089 15.2338C8.20089 15.0427 8.21422 14.8471 8.24089 14.648C8.26844 14.4489 8.312 14.2249 8.37156 13.9733L9.048 11.584C9.10756 11.3547 9.15911 11.1369 9.2 10.9342C9.24089 10.7298 9.26044 10.5422 9.26044 10.3716C9.26044 10.0676 9.19733 9.85422 9.072 9.73422C8.94489 9.61422 8.70578 9.55556 8.34933 9.55556C8.17511 9.55556 7.99556 9.58133 7.81156 9.63556C7.62933 9.69156 7.47111 9.74222 7.34133 9.792L7.52 9.056C7.96267 8.87556 8.38667 8.72089 8.79111 8.59289C9.19556 8.46311 9.57778 8.39911 9.93778 8.39911C10.5876 8.39911 11.0889 8.55733 11.4418 8.87022C11.7929 9.184 11.9698 9.592 11.9698 10.0933C11.9698 10.1973 11.9573 10.3804 11.9333 10.6418C11.9093 10.904 11.864 11.1431 11.7982 11.3627L11.1253 13.7449C11.0702 13.936 11.0213 14.1547 10.9769 14.3991C10.9333 14.6436 10.912 14.8302 10.912 14.9556C10.912 15.272 10.9822 15.488 11.1244 15.6027C11.2649 15.7173 11.5111 15.7751 11.8596 15.7751C12.024 15.7751 12.208 15.7458 12.416 15.6889C12.6222 15.632 12.7716 15.5813 12.8658 15.5378L12.6853 16.2729ZM12.5662 6.60356C12.2524 6.89511 11.8747 7.04089 11.4329 7.04089C10.992 7.04089 10.6116 6.89511 10.2951 6.60356C9.98044 6.312 9.82133 5.95733 9.82133 5.54311C9.82133 5.12978 9.98133 4.77422 10.2951 4.48C10.6116 4.18489 10.992 4.03822 11.4329 4.03822C11.8747 4.03822 12.2533 4.18489 12.5662 4.48C12.88 4.77422 13.0373 5.12978 13.0373 5.54311C13.0373 5.95822 12.88 6.312 12.5662 6.60356Z" fill="white"/>
                            </svg>
                            <span>О проекте</span>
                        </a>
                    </li>
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5012 0C7.5012 0 5.04883 2.45237 5.04883 5.45239C5.04883 8.45241 7.5012 10.9048 10.5012 10.9048C13.5012 10.9048 15.9536 8.45241 15.9536 5.45239C15.9536 2.45237 13.5012 0 10.5012 0Z" fill="white"/>
                                    <path d="M19.8589 15.2618C19.7161 14.9046 19.5256 14.5713 19.3113 14.2618C18.2161 12.6427 16.5256 11.5713 14.6209 11.3094C14.3828 11.2856 14.1209 11.3332 13.9304 11.476C12.9304 12.2141 11.7399 12.5951 10.5018 12.5951C9.26369 12.5951 8.07323 12.2141 7.07322 11.476C6.88273 11.3332 6.62082 11.2617 6.38275 11.3094C4.47798 11.5713 2.76371 12.6427 1.69229 14.2618C1.47801 14.5713 1.28751 14.9285 1.14469 15.2618C1.07327 15.4046 1.09706 15.5713 1.16848 15.7142C1.35897 16.0475 1.59704 16.3809 1.81133 16.6666C2.14465 17.119 2.5018 17.5237 2.90658 17.9046C3.2399 18.238 3.62085 18.5475 4.00184 18.857C5.88277 20.2618 8.14469 20.9999 10.478 20.9999C12.8114 20.9999 15.0733 20.2618 16.9542 18.857C17.3351 18.5713 17.7161 18.238 18.0495 17.9046C18.4304 17.5237 18.8113 17.1189 19.1447 16.6666C19.3828 16.357 19.5971 16.0475 19.7876 15.7142C19.9066 15.5713 19.9303 15.4046 19.8589 15.2618Z" fill="white"/>
                                </svg>

                                <span>{{ Auth::user()->name }}</span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                <a class="dropdown-item" href="{{Route('wallet.profile')}}" >
                                    Профиль
                                </a>
                                @if (\Auth::user()->isAdmin())
                                    <hr class="dropdown-divider">
                                    <a class="dropdown-item" href="{{Route('wallet.users')}}" >
                                        Пользователи
                                    </a>
                                    <a class="dropdown-item" href="{{Route('wallet.orders')}}" >
                                        Заявки
                                    </a>
                                    <a class="dropdown-item" href="{{Route('wallet.reports')}}" >
                                        Бухгалтерия
                                    </a>
                                    <a class="dropdown-item" href="{{Route('wallet.stages')}}" >
                                        Токенсейл
                                    </a>
                                @endif
                                    <hr class="dropdown-divider">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Выйти
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script src="/js/qrcode.js"></script>
<script>
    window.onload = function() {
        if (screen.width < 420) {
            var mvp = document.getElementById('vp');
            mvp.setAttribute('content','user-scalable=no,width=420');
        }
    }
</script>
@yield('script')
</body>
</html>
