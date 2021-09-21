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
    <a class="create-order-open d-flex justify-content-center align-items-center flex-column" onclick="createOrderScreenOpen();">
        <svg width="72" height="72" viewBox="0 0 72 66" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g filter="url(#filterCreateIcon)">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M36 63C53.6731 63 68 48.6731 68 31C68 13.3269 53.6731 -1 36 -1C18.3269 -1 4 13.3269 4 31C4 48.6731 18.3269 63 36 63Z" fill="#EDF1F9"/>
            </g>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M36 60C52.0163 60 65 47.0163 65 31C65 14.9837 52.0163 2 36 2C19.9837 2 7 14.9837 7 31C7 47.0163 19.9837 60 36 60Z" fill="#3783F5"/>
            <path d="M46 31C46 31.75 45.5 32.25 44.75 32.25H37.25V39.75C37.25 40.5 36.75 41 36 41C35.25 41 34.75 40.5 34.75 39.75V32.25H27.25C26.5 32.25 26 31.75 26 31C26 30.25 26.5 29.75 27.25 29.75H34.75V22.25C34.75 21.5 35.25 21 36 21C36.75 21 37.25 21.5 37.25 22.25V29.75H44.75C45.5 29.75 46 30.25 46 31Z" fill="black"/>
            <mask id="create-order-icon" mask-type="alpha" maskUnits="userSpaceOnUse" x="26" y="21" width="20" height="20">
                <path d="M46 31C46 31.75 45.5 32.25 44.75 32.25H37.25V39.75C37.25 40.5 36.75 41 36 41C35.25 41 34.75 40.5 34.75 39.75V32.25H27.25C26.5 32.25 26 31.75 26 31C26 30.25 26.5 29.75 27.25 29.75H34.75V22.25C34.75 21.5 35.25 21 36 21C36.75 21 37.25 21.5 37.25 22.25V29.75H44.75C45.5 29.75 46 30.25 46 31Z" fill="white"/>
            </mask>
            <g mask="url(#create-order-icon)">
                <rect x="21" y="16" width="30" height="30" fill="white"/>
            </g>
            <defs>
                <filter id="filterCreateIcon" x="0" y="-6" width="72" height="72" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
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
