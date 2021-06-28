<ul class="nav nav-tabs" id="dashboard-tabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="tokensale-tab" data-toggle="tab" href="#tokensale" role="tab" aria-controls="home" aria-selected="true">Токенсейл</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="wallet-tab" data-toggle="tab" href="#wallet" role="tab" aria-controls="profile" aria-selected="false">Кошелек</a>
    </li>
</ul>

<div class="tab-content" id="dashboardContent">
    <div class="tab-pane fade show active" id="tokensale" role="tabpanel" aria-labelledby="tokensale-tab">
        <p><strong>1-й этап </strong></p>
        <p style="margin-bottom:35px;">Цена 1 DHB = {{$system->rate}} USD</p>
        <div class="progress w-100">
            <div class="progress-bar bg-success" role="progressbar" style="width: {{($balances / 2000000) * 100 }}%" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <p style="margin-top:10px; font-size:18px;">Продано {{number_format($balances, 0, ',', ' ')}} DHB из 2 000 000 DHB</p>
        <p class="our_balance"><strong>Ваш баланс</strong></p>
        <p>{{ number_format(Auth::User()->getWallet('DHB')->balanceFloat, 2, ',',' ') }} DHB = {{ number_format((Auth::User()->getWallet('DHB')->balanceFloat * $system->rate), 2, ',' , ' ')}} USD</p>
        <a onclick="$('#deposit-tab').click()" style="margin-top:40px;" class="button button-orange">Получить DHB</a>
    </div>
    <div class="tab-pane fade" id="wallet" role="tabpanel" aria-labelledby="wallet-tab">
        <hr />
        <h3 class="mb-5">ID Пользователя: {{Auth::User()->uid}}</h3>
        <p class="wallet-number">Номер кошелька: <strong>0x{{ md5(Auth::User()->getWallet('DHB')->id) }}</strong></p>
        <p>Баланс: <strong>{{Auth::User()->getWallet('DHB')->balanceFloat}} DHB</strong></p>
        <hr />
        <p class="wallet-number">Номер кошелька: <strong>0x{{ md5(Auth::User()->getWallet('ETH')->id) }}</strong></p>
        <p>Баланс: <strong>{{Auth::User()->getWallet('ETH')->balanceFloat}} ETH</strong></p>
        <hr />
        <p class="wallet-number">Номер кошелька: <strong>0x{{ md5(Auth::User()->getWallet('BTC')->id) }}</strong></p>
        <p>Баланс: <strong>{{Auth::User()->getWallet('BTC')->balanceFloat}} BTC</strong></p>
        <hr />
        <p class="wallet-number">Номер кошелька: <strong>0x{{ md5(Auth::User()->getWallet('USDT')->id) }}</strong></p>
        <p>Баланс: <strong>{{Auth::User()->getWallet('USDT')->balanceFloat}} USDT</strong></p>
    </div>
</div>






