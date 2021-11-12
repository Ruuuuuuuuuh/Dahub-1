<div class="balance-items">

    <div class="balances-gate">
        <div class="progress w-100">
            <div class="progress-bar bg-success" role="progressbar" style="width: @php if ($user->getBalanceFrozen($visibleWallets[0]) != 0) echo 100 * $user->getBalanceFree($visibleWallets[0]) / $user->getBalanceFrozen($visibleWallets[0]); else echo '100'; @endphp%; max-width:100%;" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <div class="col-12">
            <div class="row justify-content-between">
                <div class="col-6">
                    <div class="row">
                        <div class="balance-item balance-available"><span class="balance-color bg-success"></span><span class="balance-amount">$ <span>{{ $user->getBalanceFree($visibleWallets[0]) * $rates::getRates($visibleWallets[0]) }}</span></span></div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row justify-content-end">
                        <div class="balance-item balance-frozen"><span class="balance-color bg-dark"></span><span class="balance-amount">$ <span>{{ $user->getBalanceFrozen($visibleWallets[0]) * $rates::getRates($visibleWallets[0])  }}</span></span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="gate-controls col-12">
            <div class="row align-items-center">
                <div class="col-6">
                    <div class="row">
                        <a class="gate-action active" data-action="deposit">Принять</a>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <a class="gate-action" data-action="withdraw">Отправить</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
