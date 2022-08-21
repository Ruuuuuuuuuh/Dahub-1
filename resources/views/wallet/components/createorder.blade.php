<section id="create-order" class="screen">
    <div class="section-header">
        <div class="top-nav">
            <a href="#" class="back-link">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M15.7071 17.2929C16.0976 17.6834 16.0976 18.3166 15.7071 18.7071C15.3166 19.0976 14.6834 19.0976 14.2929 18.7071L8.29289 12.7071C7.90237 12.3166 7.90237 11.6834 8.29289 11.2929L14.2929 5.29289C14.6834 4.90237 15.3166 4.90237 15.7071 5.29289C16.0976 5.68342 16.0976 6.31658 15.7071 6.70711L10.4142 12L15.7071 17.2929Z"
                          fill="#0D1F3C"/>
                    <mask id="back-link" mask-type="alpha" maskUnits="userSpaceOnUse" x="8" y="5" width="8" height="14">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M15.7071 17.2929C16.0976 17.6834 16.0976 18.3166 15.7071 18.7071C15.3166 19.0976 14.6834 19.0976 14.2929 18.7071L8.29289 12.7071C7.90237 12.3166 7.90237 11.6834 8.29289 11.2929L14.2929 5.29289C14.6834 4.90237 15.3166 4.90237 15.7071 5.29289C16.0976 5.68342 16.0976 6.31658 15.7071 6.70711L10.4142 12L15.7071 17.2929Z"
                              fill="white"/>
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
        <ul class="nav nav-pills justify-content-between" id="create-order-tab" role="tablist">
            <li class="nav-item">
                <button class="nav-link" id="pills-deposit-tab" data-toggle="pill" data-target="#pills-deposit"
                        type="button" role="tab" aria-controls="pills-deposit" aria-selected="false">Получить
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="pills-exchange-tab" data-toggle="pill" data-target="#pills-exchange"
                        type="button" role="tab" aria-controls="pills-exchange" aria-selected="false">Обмен
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link active" id="pills-withdraw-tab" data-toggle="pill" data-target="#pills-withdraw"
                        type="button" role="tab" aria-controls="pills-withdraw" aria-selected="true">Отправить
                </button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade" id="pills-deposit" role="tabpanel"
                 aria-labelledby="pills-deposit-tab">
                @include('wallet.components.createorder.deposit')
            </div>
            <div class="tab-pane fade" id="pills-exchange" role="tabpanel" aria-labelledby="pills-exchange-tab">
                @include('wallet.components.createorder.exchange')
            </div>
            <div class="tab-pane fade show active" id="pills-withdraw" role="tabpanel" aria-labelledby="pills-withdraw-tab">
                @include('wallet.components.createorder.withdraw')
            </div>
        </div>
    </div>
</section>
