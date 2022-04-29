<section id="payments-screen" class="screen">
    <div class="section-header">
        <div class="top-nav">
            <a href="#" class="back-link">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.7071 17.2929C16.0976 17.6834 16.0976 18.3166 15.7071 18.7071C15.3166 19.0976 14.6834 19.0976 14.2929 18.7071L8.29289 12.7071C7.90237 12.3166 7.90237 11.6834 8.29289 11.2929L14.2929 5.29289C14.6834 4.90237 15.3166 4.90237 15.7071 5.29289C16.0976 5.68342 16.0976 6.31658 15.7071 6.70711L10.4142 12L15.7071 17.2929Z"/>
                </svg>
            </a>
            <h2>Реквизиты</h2>
            <div class="section-header__icon">
                <svg width="44" height="45" viewBox="0 0 44 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M22 44.238C34.1503 44.238 44 34.3883 44 22.238C44 10.0878 34.1503 0.238037 22 0.238037C9.84974 0.238037 0 10.0878 0 22.238C0 34.3883 9.84974 44.238 22 44.238Z" fill="#EDF1F9"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M31 13H13C11.3 13 10 14.3 10 16V28C10 29.7 11.3 31 13 31H31C32.7 31 34 29.7 34 28V16C34 14.3 32.7 13 31 13ZM13 15H31C31.6 15 32 15.4 32 16V19H12V16C12 15.4 12.4 15 13 15ZM13 29H31C31.6 29 32 28.6 32 28V21H12V28C12 28.6 12.4 29 13 29Z"/>
                    <mask id="mask0_1411_9462" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="10" y="13" width="24" height="18">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M31 13H13C11.3 13 10 14.3 10 16V28C10 29.7 11.3 31 13 31H31C32.7 31 34 29.7 34 28V16C34 14.3 32.7 13 31 13ZM13 15H31C31.6 15 32 15.4 32 16V19H12V16C12 15.4 12.4 15 13 15ZM13 29H31C31.6 29 32 28.6 32 28V21H12V28C12 28.6 12.4 29 13 29Z" fill="white"/>
                    </mask>
                    <g mask="url(#mask0_1411_9462)">
                    <rect x="10" y="10" width="24" height="24" fill="url(#paint0_linear_1411_9462)"/>
                    </g>
                    <defs>
                    <linearGradient id="paint0_linear_1411_9462" x1="-20.8571" y1="27" x2="26.8851" y2="23.0207" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#85F362"/>
                    <stop offset="1" stop-color="#02AAFF"/>
                    </linearGradient>
                    </defs>
            </svg>
            </div>
        </div>

    </div>
    <div class="section-main">

        <payments-screen
        _token="{{ csrf_token() }}"
        ></payments-screen>
    </div>
</section>
