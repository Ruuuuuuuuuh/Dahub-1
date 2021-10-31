<div class="balance-items">

    <div class="balances-gate">
        <div class="progress w-100">
            <div class="progress-bar bg-success" role="progressbar" style="width: 47.67915%" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <div class="col-12">
            <div class="row justify-content-between">
                <div class="col-6">
                    <div class="row">
                        <div class="balance-item balance-available"><span class="balance-color bg-success"></span>${{ Auth::user()->getWallet('USDT')->balanceFloat }}</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row justify-content-end">
                        <div class="balance-item balance-frozen"><span class="balance-color bg-dark"></span>${{ Auth::user()->getWallet('USDT')->balanceFloat }}</div>
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
