


        <p><strong>1-й этап </strong></p>
        <p style="margin-bottom:35px;">Цена 1 DHB = {{Rate::getRates('DHB')}} USD</p>
        <div class="progress w-100">
            <div class="progress-bar bg-success" role="progressbar" style="width: {{($balances / 2000000) * 100 }}%" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <p style="margin-top:10px; font-size:18px;">Продано {{number_format($balances, 0, ',', ' ')}} DHB из 2 000 000 DHB</p>
        <p class="our_balance"><strong>Ваш баланс</strong></p>
        <p>{{ number_format(Auth::User()->getWallet('DHB')->balanceFloat, 2, ',',' ') }} DHB = {{ number_format((Auth::User()->getWallet('DHB')->balanceFloat * Rate::getRates('DHB')), 2, ',' , ' ')}} USD</p>
        <a onclick="$('#deposit-tab').click()" style="margin-top:40px;" class="button button-orange">Получить DHB</a>








