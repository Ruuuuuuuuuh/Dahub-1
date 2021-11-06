<form class="form-withdraw form-create-order" action="index.html" method="post">
    <input type="hidden" name="destination" value="withdraw"/>
    <div class="form-control">
        <label for="currency">Валюта</label>
        <div class="select-wrapper">
            <select name="currency" class="form-select select-currency">
                @foreach ($currency::all() as $currency)
                    @if ($currency->title != 'HFT')
                        <option data-crypto="{{$currency->crypto}}" value="{{$currency->title}}">{{$currency->title}}</option>
                    @endif
                @endforeach
            </select>
            <svg class="select-angle" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18.7 9.7L12.7 15.7C12.5 15.9 12.3 16 12 16C11.7 16 11.5 15.9 11.3 15.7L5.3 9.7C4.9 9.3 4.9 8.7 5.3 8.3C5.7 7.9 6.3 7.9 6.7 8.3L12 13.6L17.3 8.3C17.7 7.9 18.3 7.9 18.7 8.3C19.1 8.7 19.1 9.3 18.7 9.7Z" fill="black"/>
                <mask id="angle-down2" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="5" y="8" width="14" height="8">
                    <path d="M18.7 9.7L12.7 15.7C12.5 15.9 12.3 16 12 16C11.7 16 11.5 15.9 11.3 15.7L5.3 9.7C4.9 9.3 4.9 8.7 5.3 8.3C5.7 7.9 6.3 7.9 6.7 8.3L12 13.6L17.3 8.3C17.7 7.9 18.3 7.9 18.7 8.3C19.1 8.7 19.1 9.3 18.7 9.7Z" fill="white"/>
                </mask>
                <g mask="url(#angle-down2)">
                    <rect width="24" height="24" fill="#0D1F3C"/>
                </g>
            </svg>
        </div>
    </div>
    <div class="form-control amount-wrapper">
        <label for="amount">Сумма</label>
        <div class="select-wrapper">
            <input type="number" name="amount" class="input-amount" placeholder="0" min="0" />
        </div>
    </div>
    <div class="form-control">
        <label for="payment-network">Платёжная система</label>
        <div class="select-wrapper">
            <select name="payment-network" class="form-select select-payment">
                <option value="ERC20" selected>ERC20</option>
                <option value="TRC">TRC</option>
            </select>
            <svg class="select-angle" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18.7 9.7L12.7 15.7C12.5 15.9 12.3 16 12 16C11.7 16 11.5 15.9 11.3 15.7L5.3 9.7C4.9 9.3 4.9 8.7 5.3 8.3C5.7 7.9 6.3 7.9 6.7 8.3L12 13.6L17.3 8.3C17.7 7.9 18.3 7.9 18.7 8.3C19.1 8.7 19.1 9.3 18.7 9.7Z" fill="black"/>
                <mask id="angle-down1" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="5" y="8" width="14" height="8">
                    <path d="M18.7 9.7L12.7 15.7C12.5 15.9 12.3 16 12 16C11.7 16 11.5 15.9 11.3 15.7L5.3 9.7C4.9 9.3 4.9 8.7 5.3 8.3C5.7 7.9 6.3 7.9 6.7 8.3L12 13.6L17.3 8.3C17.7 7.9 18.3 7.9 18.7 8.3C19.1 8.7 19.1 9.3 18.7 9.7Z" fill="white"/>
                </mask>
                <g mask="url(#angle-down1)">
                    <rect width="24" height="24" fill="#0D1F3C"/>
                </g>
            </svg>
        </div>
    </div>
    <div class="form-control address">
        <label for="address">Адрес</label>
        <div class="select-wrapper">
            <input type="button" name="address" class="input-address crypto"/>
        </div>
    </div>
</form>
<a class="button button-blue create-order">Далее</a>
