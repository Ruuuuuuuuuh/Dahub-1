<div class="section-header">
    <div class="top-nav">
        <a href="{{ Route('dashboard') }}" class="back-link">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M15.7071 17.2929C16.0976 17.6834 16.0976 18.3166 15.7071 18.7071C15.3166 19.0976 14.6834 19.0976 14.2929 18.7071L8.29289 12.7071C7.90237 12.3166 7.90237 11.6834 8.29289 11.2929L14.2929 5.29289C14.6834 4.90237 15.3166 4.90237 15.7071 5.29289C16.0976 5.68342 16.0976 6.31658 15.7071 6.70711L10.4142 12L15.7071 17.2929Z" fill="#0D1F3C"></path>
                <mask id="back-link" mask-type="alpha" maskUnits="userSpaceOnUse" x="8" y="5" width="8" height="14">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.7071 17.2929C16.0976 17.6834 16.0976 18.3166 15.7071 18.7071C15.3166 19.0976 14.6834 19.0976 14.2929 18.7071L8.29289 12.7071C7.90237 12.3166 7.90237 11.6834 8.29289 11.2929L14.2929 5.29289C14.6834 4.90237 15.3166 4.90237 15.7071 5.29289C16.0976 5.68342 16.0976 6.31658 15.7071 6.70711L10.4142 12L15.7071 17.2929Z" fill="white"></path>
                </mask>
                <g mask="url(#back-link)">
                    <rect width="24" height="24" fill="#0D1F3C"></rect>
                </g>
            </svg>
        </a>

        <h2>Заявка выполнена</h2>
        <svg class="status" width="64" height="65" viewBox="0 0 64 65" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M32 63C48.5685 63 62 49.5685 62 33C62 16.4315 48.5685 3 32 3C15.4315 3 2 16.4315 2 33C2 49.5685 15.4315 63 32 63Z" fill="#75BF72" stroke="white" stroke-width="4"/>
            <path d="M46.3625 25.1542L27.5708 43.9458C27.2292 44.2875 26.8875 44.4583 26.375 44.4583C25.8625 44.4583 25.5208 44.2875 25.1792 43.9458L16.6375 35.4042C15.9542 34.7208 15.9542 33.6958 16.6375 33.0125C17.3208 32.3292 18.3458 32.3292 19.0292 33.0125L26.375 40.3583L43.9708 22.7625C44.6542 22.0792 45.6792 22.0792 46.3625 22.7625C47.0458 23.4458 47.0458 24.4708 46.3625 25.1542Z" fill="white"/>
            <mask id="mask0_525:4523" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="16" y="22" width="31" height="23">
                <path d="M46.3625 25.1542L27.5708 43.9458C27.2292 44.2875 26.8875 44.4583 26.375 44.4583C25.8625 44.4583 25.5208 44.2875 25.1792 43.9458L16.6375 35.4042C15.9542 34.7208 15.9542 33.6958 16.6375 33.0125C17.3208 32.3292 18.3458 32.3292 19.0292 33.0125L26.375 40.3583L43.9708 22.7625C44.6542 22.0792 45.6792 22.0792 46.3625 22.7625C47.0458 23.4458 47.0458 24.4708 46.3625 25.1542Z" fill="white"/>
            </mask>
            <g mask="url(#mask0_525:4523)">
            </g>
        </svg>
    </div>
</div>
<div class="section-main">
    <div class="text-block">
        <p><small>Заявка #</small></p>
        <p>{{$order->id}}</p>
    </div>
    <div class="text-block">
        <p><small>Статус:</small></p>
        <p style="color:#347AF0">Заявка выполнена. <br />Отправлено {{number_format($order->amount, Auth::user()->getWallet($order->currency)->decimal_places, ',', ' ')}} {{$order->currency}}</p>
    </div>
    <div class="footer">
        <a href="{{ Route('dashboard') }}" class="button button-blue">Закрыть</a>
    </div>
</div>
