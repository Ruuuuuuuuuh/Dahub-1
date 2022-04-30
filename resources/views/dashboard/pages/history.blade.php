@extends('dashboard.layouts.app')
@section('content')
<section id=history-page class="screen opened history">
    <div class="section-header">
        <div class="top-nav">
            <a href="{{ Route('wallet') }}" class="back-link-no-js">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.7071 17.2929C16.0976 17.6834 16.0976 18.3166 15.7071 18.7071C15.3166 19.0976 14.6834 19.0976 14.2929 18.7071L8.29289 12.7071C7.90237 12.3166 7.90237 11.6834 8.29289 11.2929L14.2929 5.29289C14.6834 4.90237 15.3166 4.90237 15.7071 5.29289C16.0976 5.68342 16.0976 6.31658 15.7071 6.70711L10.4142 12L15.7071 17.2929Z"></path>
                </svg>
            </a>
            <h2>История</h2>
            <div class="section-header__icon">
                <svg width="44" height="44" viewBox="0 0 44 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M22 44.238C34.1503 44.238 44 34.3883 44 22.238C44 10.0878 34.1503 0.238037 22 0.238037C9.84974 0.238037 0 10.0878 0 22.238C0 34.3883 9.84974 44.238 22 44.238Z" fill="#EDF1F9"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M30 11H16.5C14.6 11 13 12.6 13 14.5V29.5C13 31.4 14.6 33 16.5 33H30C30.6 33 31 32.6 31 32V12C31 11.4 30.6 11 30 11ZM16.5 13H29V26H16.5C16 26 15.5 26.1 15 26.4V14.5C15 13.7 15.7 13 16.5 13ZM15 29.5C15 30.3 15.7 31 16.5 31H29V28H16.5C15.7 28 15 28.7 15 29.5Z"/>
                <mask id="mask0_1194_2725" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="13" y="11" width="18" height="22">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M30 11H16.5C14.6 11 13 12.6 13 14.5V29.5C13 31.4 14.6 33 16.5 33H30C30.6 33 31 32.6 31 32V12C31 11.4 30.6 11 30 11ZM16.5 13H29V26H16.5C16 26 15.5 26.1 15 26.4V14.5C15 13.7 15.7 13 16.5 13ZM15 29.5C15 30.3 15.7 31 16.5 31H29V28H16.5C15.7 28 15 28.7 15 29.5Z" fill="white"/>
                </mask>
                <g mask="url(#mask0_1194_2725)">
                <rect x="10" y="10" width="24" height="24" fill="url(#paint0_linear_1194_2725)"/>
                </g>
                <defs>
                <linearGradient id="paint0_linear_1194_2725" x1="-20.8571" y1="27" x2="26.8851" y2="23.0207" gradientUnits="userSpaceOnUse">
                <stop stop-color="#85F362"/>
                <stop offset="1" stop-color="#02AAFF"/>
                </linearGradient>
                </defs>
                </svg>
        </div>
        </div>
    </div>
    <div class="section-main">
        <transaction-list></transaction-list>
    </div>
</section>
@include('dashboard.components.footer')

@endsection

@section('scripts')
    <script>

    </script>
@endsection
