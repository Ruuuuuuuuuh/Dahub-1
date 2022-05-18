<div id="menu-swipe">
    <div class="user-info position-relative">
        <a class="menu-close icon-close">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.37981 1.89591C2.96533 1.56247 2.35748 1.58812 1.97274 1.97286C1.56052 2.38508 1.56052 3.05342 1.97274 3.46564L10.5071 12L1.97274 20.5344L1.89579 20.6201C1.56235 21.0346 1.588 21.6425 1.97274 22.0272C2.38496 22.4394 3.0533 22.4394 3.46552 22.0272L11.9999 13.4928L20.5343 22.0272L20.62 22.1041C21.0345 22.4376 21.6423 22.4119 22.0271 22.0272C22.4393 21.615 22.4393 20.9466 22.0271 20.5344L13.4927 12L22.0271 3.46564L22.104 3.37994C22.4375 2.96545 22.4118 2.3576 22.0271 1.97286C21.6149 1.56064 20.9465 1.56064 20.5343 1.97286L11.9999 10.5072L3.46552 1.97286L3.37981 1.89591Z" fill="black"/>
                <mask id="mask0_871_903" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="1" y="1" width="22" height="22">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3.37981 1.89591C2.96533 1.56247 2.35748 1.58812 1.97274 1.97286C1.56052 2.38508 1.56052 3.05342 1.97274 3.46564L10.5071 12L1.97274 20.5344L1.89579 20.6201C1.56235 21.0346 1.588 21.6425 1.97274 22.0272C2.38496 22.4394 3.0533 22.4394 3.46552 22.0272L11.9999 13.4928L20.5343 22.0272L20.62 22.1041C21.0345 22.4376 21.6423 22.4119 22.0271 22.0272C22.4393 21.615 22.4393 20.9466 22.0271 20.5344L13.4927 12L22.0271 3.46564L22.104 3.37994C22.4375 2.96545 22.4118 2.3576 22.0271 1.97286C21.6149 1.56064 20.9465 1.56064 20.5343 1.97286L11.9999 10.5072L3.46552 1.97286L3.37981 1.89591Z" fill="white"/>
                </mask>
                <g mask="url(#mask0_871_903)">
                    <rect width="24" height="24" fill="#0D1F3C"/>
                </g>
            </svg>
        </a>
        <h2 class="username">{{Auth::user()->name}}</h2>
        <p class="user-id">ID: {{Auth::user()->uid}}</p>
    </div>
    @if (Auth::user()->isGate())
    <div class="version-pro w-100 d-flex align-items-center justify-content-between">
        <h2>Da·Hub Pro</h2>
        <a class="switch-pro">
            <svg width="44" height="24" viewBox="0 0 44 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="44" height="24" rx="12" fill="#75BF72"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M32.5 21.5C37.7467 21.5 42 17.2467 42 12C42 6.75329 37.7467 2.5 32.5 2.5C27.2533 2.5 23 6.75329 23 12C23 17.2467 27.2533 21.5 32.5 21.5Z" fill="white"/>
            </svg>
        </a>
    </div>
    @endif
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="{{Route('wallet')}}" class="nav-link">
                <span class="svg-wrapper">
                    <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#wallet-icon)">
                            <path d="M20.7336 4.07273C20.6096 2.47281 19.2691 1.20865 17.638 1.20865H3.10599C1.39334 1.20865 0 2.60199 0 4.31464V18.6853C0 20.398 1.39334 21.7913 3.10599 21.7913H19.8941C21.6067 21.7913 23 20.398 23 18.6853V7.06246C23 5.64078 22.0395 4.44001 20.7336 4.07273ZM3.10599 2.65962H17.638C18.4276 2.65962 19.0894 3.21557 19.2535 3.95652H3.10599C2.49789 3.95652 1.93052 4.13286 1.45097 4.43611V4.31464C1.45097 3.40207 2.19342 2.65962 3.10599 2.65962ZM19.894 20.3404H3.10599C2.19342 20.3404 1.45097 19.5979 1.45097 18.6853V7.06246C1.45097 6.14989 2.19342 5.40745 3.10599 5.40745H19.8941C20.8066 5.40745 21.5491 6.14989 21.5491 7.06246V9.59432H16.9229C15.0897 9.59432 13.5983 11.0858 13.5983 12.919C13.5983 14.7522 15.0898 16.2437 16.9229 16.2437H21.549V18.6853C21.549 19.5979 20.8066 20.3404 19.894 20.3404ZM21.549 14.7927H16.9229C15.8898 14.7927 15.0493 13.9522 15.0493 12.919C15.0493 11.8858 15.8898 11.0453 16.9229 11.0453H21.549V14.7927Z" fill="#CFD2D8" stroke="#CFD2D8" stroke-width="0.3"/>
                            <path d="M17.1923 13.7294C17.6095 13.7294 17.9477 13.3912 17.9477 12.974C17.9477 12.5569 17.6095 12.2187 17.1923 12.2187C16.7752 12.2187 16.437 12.5569 16.437 12.974C16.437 13.3912 16.7752 13.7294 17.1923 13.7294Z" fill="#CFD2D8" stroke="#CFD2D8" stroke-width="0.3"/>
                        </g>
                        <defs>
                            <clipPath id="wallet-icon">
                                <rect width="23" height="23" fill="white"/>
                            </clipPath>
                        </defs>
                    </svg>
                </span>
                <span>Кошелёк</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{Route('dashboard.explorer')}}" class="nav-link">
                <span class="svg-wrapper">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M17.2 15.8L21.7 20.3C22.1 20.7 22.1 21.3 21.7 21.7C21.5 21.9 21.2 22 21 22C20.8 22 20.5 21.9 20.3 21.7L15.8 17.2C14.3 18.3 12.5 19 10.5 19C5.8 19 2 15.2 2 10.5C2 5.8 5.8 2 10.5 2C15.2 2 19 5.8 19 10.5C19 12.5 18.3 14.4 17.2 15.8ZM10.5 4C6.9 4 4 6.9 4 10.5C4 14.1 6.9 17 10.5 17C12.3 17 13.9 16.3 15.1 15.1C16.3 13.9 17 12.3 17 10.5C17 6.9 14.1 4 10.5 4Z" fill="#CFD2D8"/>
                    </svg>
                </span>
                <span>Обозреватель</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{Route('settings')}}" class="nav-link">
                <span class="svg-wrapper">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M20.3 15.4C20.4 15.2 20.6 15 21 15C22.7 15 24 13.7 24 12C24 10.3 22.7 9 21 9H20.8C20.6 9 20.4 8.9 20.3 8.7C20.3 8.6 20.3 8.6 20.2 8.5C20.1 8.3 20.1 8 20.4 7.7C21.6 6.5 21.6 4.6 20.4 3.5C19.8 2.9 19.1 2.6 18.3 2.6C17.5 2.6 16.7 2.9 16.1 3.5C15.9 3.7 15.6 3.7 15.4 3.6C15.2 3.6 15 3.3 15 3C15 1.3 13.7 0 12 0C10.3 0 9 1.3 9 3V3.2C9 3.4 8.9 3.6 8.7 3.7C8.6575 3.7 8.63307 3.7 8.61134 3.70767C8.58194 3.71806 8.5575 3.7425 8.5 3.8C8.3 3.9 8 3.8 7.7 3.6C6.5 2.4 4.6 2.4 3.5 3.6C2.3 4.8 2.3 6.7 3.6 7.9C3.8 8.1 3.8 8.4 3.7 8.7C3.6 8.9 3.3 9.1 3 9.1C1.3 9.1 0 10.4 0 12.1C0 13.8 1.3 15.1 3 15.1H3.2C3.5 15.1 3.7 15.3 3.8 15.5C3.9 15.7 3.9 16 3.6 16.3C3 16.9 2.7 17.6 2.7 18.4C2.7 19.2 3 19.9 3.6 20.5C4.8 21.7 6.7 21.7 7.9 20.4C8.1 20.2 8.4 20.2 8.7 20.3C9 20.4 9.1 20.6 9.1 21C9.1 22.7 10.4 24 12.1 24C13.8 24 15.1 22.7 15.1 21V20.8C15.1 20.5 15.3 20.3 15.5 20.2C15.7 20.1 16 20.1 16.3 20.4C17.5 21.6 19.4 21.6 20.5 20.4C21.7 19.2 21.7 17.3 20.4 16.1C20.3 15.9 20.2 15.6 20.3 15.4ZM8 12C8 9.8 9.8 8 12 8C14.2 8 16 9.8 16 12C16 14.2 14.2 16 12 16C9.8 16 8 14.2 8 12ZM10 12C10 13.1 10.9 14 12 14C13.1 14 14 13.1 14 12C14 10.9 13.1 10 12 10C10.9 10 10 10.9 10 12ZM19.1 17.6C18.3 16.7 18.1 15.6 18.5 14.6C18.9 13.6 19.9 13 20.9 13C21.6 13 22 12.6 22 12C22 11.4 21.6 11 21 11H20.8C19.8 11 18.8 10.4 18.4 9.4C18.3 9.3 18.3 9.2 18.3 9.1C18 8.2 18.2 7.1 18.9 6.4C19.4 5.9 19.4 5.3 19 4.9C18.8 4.7 18.6 4.6 18.3 4.6C18 4.6 17.8 4.7 17.6 4.9C16.7 5.7 15.6 5.9 14.6 5.5C13.6 5.1 13 4.2 13 3.1C13 2.4 12.6 2 12 2C11.4 2 11 2.4 11 3V3.2C11 4.2 10.4 5.2 9.4 5.6C9.3 5.7 9.2 5.7 9.1 5.7C8.2 6 7.1 5.8 6.4 5.1C5.9 4.6 5.3 4.6 4.9 5C4.5 5.4 4.5 6 4.9 6.4C5.7 7.3 5.9 8.4 5.5 9.4C5.1 10.4 4.2 11.1 3.1 11.1H3C2.4 11.1 2 11.5 2 12.1C2 12.7 2.4 13.1 3 13.1H3.2C4.2 13.1 5.2 13.7 5.6 14.7C6.1 15.7 5.9 16.8 5.1 17.6C4.8 17.9 4.7 18.1 4.7 18.4C4.7 18.7 4.8 18.9 5 19.1C5.4 19.5 6 19.5 6.4 19.1C6.9 18.6 7.6 18.3 8.3 18.3C8.7 18.3 9.1 18.3 9.4 18.5C10.4 18.9 11.1 19.8 11.1 20.9V21C11.1 21.6 11.5 22 12.1 22C12.7 22 13.1 21.6 13.1 21V20.8C13.1 19.8 13.7 18.8 14.7 18.4C15.7 17.9 16.8 18.1 17.6 18.9C17.9 19.2 18.1 19.3 18.4 19.3C18.7 19.3 18.9 19.2 19.1 19C19.3 18.8 19.4 18.6 19.4 18.3C19.4 18 19.3 17.8 19.1 17.6Z" fill="#CFD2D8"/>
                    </svg>
                </span>
                <span>Настройки</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="https://t.me/DA_HUB" class="nav-link">
                <span class="svg-wrapper">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M20.9 3.0227C18.2 0.325766 13.7 0.325766 11 3.0227L4.3 9.81498C4.1 10.0148 4 10.2145 4 10.5142V18.605L1.3 21.3019C0.9 21.7015 0.9 22.3008 1.3 22.7003C1.5 22.9001 1.7 23 2 23C2.3 23 2.5 22.9001 2.7 22.7003L5.4 20.0034H13.5C13.8 20.0034 14 19.9035 14.2 19.7037L20.9 12.9115C23.7 10.2145 23.7 5.81952 20.9 3.0227ZM13.1 18.0057H7.4L9.4 16.0079H15.1L13.1 18.0057ZM17.1 14.0102L19.5 11.5131C21.5 9.61521 21.5 6.41884 19.6 4.42111C17.6 2.42338 14.5 2.42338 12.5 4.42111L6 10.9137V16.6073L8.3 14.3099L15.3 7.31782C15.7 6.91827 16.3 6.91827 16.7 7.31782C17.1 7.71737 17.1 8.31669 16.7 8.71623L11.4 14.0102H17H17.1Z" fill="#CFD2D8"/>
                    </svg>
                </span>
                <span>Паблик</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="https://t.me/DaHubSupportBot?start=wallet" class="nav-link">
                <span class="svg-wrapper">
                    <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0 11.388C0.575 5.91719 4.8875 1.50216 10.4458 1.02226C16.7708 0.350411 22.425 5.05338 23 11.388C23 11.6759 22.9042 11.9639 22.7125 12.1558C22.6167 12.3478 22.3292 12.4438 22.0417 12.4438H12.4583V18.2025C12.4583 19.2583 13.3208 20.1221 14.375 20.1221C15.4292 20.1221 16.2917 19.2583 16.2917 18.2025C16.2917 17.6266 16.675 17.2427 17.25 17.2427C17.825 17.2427 18.2083 17.6266 18.2083 18.2025C18.2083 20.314 16.4833 22.0417 14.375 22.0417C12.2667 22.0417 10.5417 20.314 10.5417 18.2025V12.4438H0.958333C0.670833 12.4438 0.383333 12.3478 0.2875 12.1558C0.0958333 11.9639 0 11.6759 0 11.388ZM2.10833 10.5242H11.5H20.8917C19.9333 5.72524 15.4292 2.36597 10.5417 2.84587C6.325 3.32576 2.875 6.39709 2.10833 10.5242Z" fill="#CFD2D8"/>
                        <mask id="mask0_871_582" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="23" height="23">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0 11.388C0.575 5.91719 4.8875 1.50216 10.4458 1.02226C16.7708 0.350411 22.425 5.05338 23 11.388C23 11.6759 22.9042 11.9639 22.7125 12.1558C22.6167 12.3478 22.3292 12.4438 22.0417 12.4438H12.4583V18.2025C12.4583 19.2583 13.3208 20.1221 14.375 20.1221C15.4292 20.1221 16.2917 19.2583 16.2917 18.2025C16.2917 17.6266 16.675 17.2427 17.25 17.2427C17.825 17.2427 18.2083 17.6266 18.2083 18.2025C18.2083 20.314 16.4833 22.0417 14.375 22.0417C12.2667 22.0417 10.5417 20.314 10.5417 18.2025V12.4438H0.958333C0.670833 12.4438 0.383333 12.3478 0.2875 12.1558C0.0958333 11.9639 0 11.6759 0 11.388ZM2.10833 10.5242H11.5H20.8917C19.9333 5.72524 15.4292 2.36597 10.5417 2.84587C6.325 3.32576 2.875 6.39709 2.10833 10.5242Z" fill="white"/>
                        </mask>
                        <g mask="url(#mask0_871_582)">
                        <rect width="23" height="23" fill="#D2D5DA"/>
                        </g>
                    </svg>
                </span>
                <span>Поддержка</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{Route('wallet')}}" class="nav-link">
                <span class="svg-wrapper">
                    <svg width="22" height="18" viewBox="0 0 22 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 10.15C20.35 10.15 19.82 9.63 19.82 9C19.82 8.37 20.35 7.85 21 7.85C21.27 7.85 21.52 7.75 21.71 7.56C21.89 7.37 22 7.12 22 6.85V4.26C22 1.91 20.07 0 17.7 0H4.3C1.93 0 0 1.91 0 4.26V6.94C0 7.2 0.11 7.46 0.29 7.64C0.48 7.83 0.74 7.94 1 7.94C1.67 7.94 2.18 8.4 2.18 9.01C2.18 9.64 1.65 10.16 1 10.16C0.45 10.16 0 10.61 0 11.16V13.75C0 16.09 1.93 18 4.3 18H17.7C20.07 18 22 16.09 22 13.74V11.15C22 10.6 21.55 10.15 21 10.15ZM12.85 13.76C12.3 13.76 11.85 14.21 11.85 14.76V16H4.3C3.03 16 2 14.99 2 13.74V11.99C3.29 11.57 4.18 10.36 4.18 9C4.18 7.64 3.31 6.49 2 6.08V4.25C2 3.01 3.03 2 4.3 2H11.85V3.67C11.85 4.22 12.3 4.67 12.85 4.67C13.4 4.67 13.85 4.22 13.85 3.67V2H17.7C18.97 2 20 3.01 20 4.26V6.01C18.71 6.44 17.82 7.64 17.82 9C17.82 10.36 18.71 11.56 20 11.99V13.74C20 14.99 18.97 16 17.7 16H13.85V14.76C13.85 14.21 13.4 13.76 12.85 13.76Z" fill="#D2D5DA"/>
                        <path d="M13.8501 6.5C13.8501 5.95 13.4001 5.5 12.8501 5.5C12.3001 5.5 11.8501 5.95 11.8501 6.5V11.32C11.8501 11.87 12.3001 12.32 12.8501 12.32C13.4001 12.32 13.8501 11.87 13.8501 11.32V6.5Z" fill="#D2D5DA"/>
                    </svg>
                </span>
                <span>Токен Сейл</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <span class="svg-wrapper" style="padding-left:4px;">
                    <svg width="25" height="25" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.6783 26.8334C12.3791 26.8334 12.8464 26.3667 12.8464 25.6667C12.8464 24.9667 12.3791 24.5 11.6783 24.5H5.83763C5.13676 24.5 4.66951 24.0334 4.66951 23.3334V4.66669C4.66951 3.96669 5.13676 3.50002 5.83763 3.50002H11.6783C12.3791 3.50002 12.8464 3.03335 12.8464 2.33335C12.8464 1.63335 12.3791 1.16669 11.6783 1.16669H5.83763C3.85182 1.16669 2.33325 2.68335 2.33325 4.66669V23.3334C2.33325 25.3167 3.85182 26.8334 5.83763 26.8334H11.6783ZM25.579 13.5334C25.6958 13.8834 25.6958 14.2334 25.579 14.4667C25.579 14.5834 25.4622 14.7 25.3454 14.8167L20.6728 19.4834C20.4392 19.7167 20.0888 19.8334 19.8552 19.8334C19.6215 19.8334 19.2711 19.7167 19.0375 19.4834C18.5702 19.0167 18.5702 18.3167 19.0375 17.85L21.7242 15.1667H10.5101C9.80926 15.1667 9.34201 14.7 9.34201 14C9.34201 13.3 9.80926 12.8334 10.5101 12.8334H21.7242L19.0375 10.15C18.5702 9.68335 18.5702 8.98335 19.0375 8.51669C19.5047 8.05002 20.2056 8.05002 20.6728 8.51669L25.3454 13.1834C25.4038 13.2417 25.433 13.3 25.4622 13.3584C25.4914 13.4167 25.5206 13.475 25.579 13.5334Z" fill="#CFD2D8"/>
                    </svg>
                </span>
                <span>Выйти</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
</div>

