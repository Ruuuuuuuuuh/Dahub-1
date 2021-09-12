<section id="create-order" class="screen">
    <div class="section-header">
        <div class="top-nav">
            <a href="#" class="back-link">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.7071 17.2929C16.0976 17.6834 16.0976 18.3166 15.7071 18.7071C15.3166 19.0976 14.6834 19.0976 14.2929 18.7071L8.29289 12.7071C7.90237 12.3166 7.90237 11.6834 8.29289 11.2929L14.2929 5.29289C14.6834 4.90237 15.3166 4.90237 15.7071 5.29289C16.0976 5.68342 16.0976 6.31658 15.7071 6.70711L10.4142 12L15.7071 17.2929Z" fill="#0D1F3C"/>
                    <mask id="back-link" mask-type="alpha" maskUnits="userSpaceOnUse" x="8" y="5" width="8" height="14">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M15.7071 17.2929C16.0976 17.6834 16.0976 18.3166 15.7071 18.7071C15.3166 19.0976 14.6834 19.0976 14.2929 18.7071L8.29289 12.7071C7.90237 12.3166 7.90237 11.6834 8.29289 11.2929L14.2929 5.29289C14.6834 4.90237 15.3166 4.90237 15.7071 5.29289C16.0976 5.68342 16.0976 6.31658 15.7071 6.70711L10.4142 12L15.7071 17.2929Z" fill="white"/>
                    </mask>
                    <g mask="url(#back-link)">
                        <rect width="24" height="24" fill="#0D1F3C"/>
                    </g>
                </svg>
            </a>
            <h2>Создать заявку</h2>
        </div>
    </div>
    <div class="section-main">
        <ul class="nav nav-pills mb-3 justify-content-between" id="create-order-tab" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" id="pills-deposit-tab"  data-toggle="pill" data-target="#pills-deposit" type="button" role="tab" aria-controls="pills-deposit" aria-selected="true">Пополнить</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="pills-withdraw-tab"  data-toggle="pill" data-target="#pills-withdraw" type="button" role="tab" aria-controls="pills-withdraw" aria-selected="false">Обмен</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="pills-exchange-tab"  data-toggle="pill" data-target="#pills-exchange" type="button" role="tab" aria-controls="pills-exchange" aria-selected="false">Вывести</button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-deposit" role="tabpanel" aria-labelledby="pills-deposit-tab">
                <form class="form-exchange" action="index.html" method="post">
                    <div class="form-control">
                        <label for="currency">Валюта</label>
                        <div class="select-wrapper">
                            <select name="currency" class="select-currency">
                                <option value="USDT" selected>USDT</option>
                                <option value="BTC">BTC</option>
                                <option value="ETH">ETH</option>
                            </select>
                            <svg class="select-angle" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18.7 9.7L12.7 15.7C12.5 15.9 12.3 16 12 16C11.7 16 11.5 15.9 11.3 15.7L5.3 9.7C4.9 9.3 4.9 8.7 5.3 8.3C5.7 7.9 6.3 7.9 6.7 8.3L12 13.6L17.3 8.3C17.7 7.9 18.3 7.9 18.7 8.3C19.1 8.7 19.1 9.3 18.7 9.7Z" fill="black"/>
                                <mask id="angle-down" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="5" y="8" width="14" height="8">
                                    <path d="M18.7 9.7L12.7 15.7C12.5 15.9 12.3 16 12 16C11.7 16 11.5 15.9 11.3 15.7L5.3 9.7C4.9 9.3 4.9 8.7 5.3 8.3C5.7 7.9 6.3 7.9 6.7 8.3L12 13.6L17.3 8.3C17.7 7.9 18.3 7.9 18.7 8.3C19.1 8.7 19.1 9.3 18.7 9.7Z" fill="white"/>
                                </mask>
                                <g mask="url(#angle-down)">
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
                            <select name="payment-network" class="select-currency">
                                <option value="ERC20" selected>ERC20</option>
                                <option value="TRC">TRC</option>
                            </select>
                            <svg class="select-angle" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18.7 9.7L12.7 15.7C12.5 15.9 12.3 16 12 16C11.7 16 11.5 15.9 11.3 15.7L5.3 9.7C4.9 9.3 4.9 8.7 5.3 8.3C5.7 7.9 6.3 7.9 6.7 8.3L12 13.6L17.3 8.3C17.7 7.9 18.3 7.9 18.7 8.3C19.1 8.7 19.1 9.3 18.7 9.7Z" fill="black"/>
                                <mask id="angle-down" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="5" y="8" width="14" height="8">
                                    <path d="M18.7 9.7L12.7 15.7C12.5 15.9 12.3 16 12 16C11.7 16 11.5 15.9 11.3 15.7L5.3 9.7C4.9 9.3 4.9 8.7 5.3 8.3C5.7 7.9 6.3 7.9 6.7 8.3L12 13.6L17.3 8.3C17.7 7.9 18.3 7.9 18.7 8.3C19.1 8.7 19.1 9.3 18.7 9.7Z" fill="white"/>
                                </mask>
                                <g mask="url(#angle-down)">
                                    <rect width="24" height="24" fill="#0D1F3C"/>
                                </g>
                            </svg>
                        </div>
                    </div>
                    <div class="form-control address">
                        <label for="address">Адрес</label>
                        <div class="select-wrapper">
                            <input type="text" name="address" class="input-address"/>
                        </div>
                    </div>
                </form>
                <a class="button button-blue">Далее</a>
            </div>
            <div class="tab-pane fade" id="pills-withdraw" role="tabpanel" aria-labelledby="pills-withdraw-tab">

            </div>
            <div class="tab-pane fade" id="pills-exchange" role="tabpanel" aria-labelledby="pills-exchange-tab">

            </div>
        </div>
    </div>
</section>
