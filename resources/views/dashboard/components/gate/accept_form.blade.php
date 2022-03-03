<section id="accept-order" class="screen" data-payment="{{$order->payment}}">
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
            <h2>Принять {{$order->amount}} {{$order->currency}}</h2>
        </div>
    </div>
    <div class="section-main">
        <h4 class="accept-order-title crypto-hidden">Выберите подходящие реквизиты</h4>
        <div class="payment-items">
            @foreach (Auth::user()->paymentDetails()->get() as $payment)

                @if ($payment->payment()->first()->title == $order->payment)
                <a class="payment-item d-flex align-items-center justify-content-start" data-address="{{$payment->address}}" data-payment="{{$payment->payment()->first()->title}}">
                    <svg class="payment-details-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="10" cy="10" r="10" fill="#EDF1F9"/>
                        <circle class="payment-item-icon-inner" cx="10" cy="10" r="6" fill="#EDF1F9"/>
                    </svg>
                    <div class="payment-details">
                        <span class="address">{{$payment->address}}</span>
                    </div>
                </a>
                @endif
            @endforeach
        </div>
        <a class="add-payment_item d-flex align-items-cente justify-content-center">
            <span>Добавить реквизиты</span>
        </a>

        <a href="#" class="btn btn-primary order-accept disabled">Принять заявку</a>
    </div>
</section>
<div class="modal fade" id="add-payment-details" tabindex="-1" role="dialog" aria-labelledby="add-payment-details" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="2.82812" width="40" height="4" rx="2" transform="rotate(45 2.82812 0)" fill="white"/>
                        <rect width="40" height="4" rx="2" transform="matrix(-0.707107 0.707107 0.707107 0.707107 28.2842 0)" fill="white"/>
                    </svg>
                </button>
                <h4>Добавить реквизиты</h4>
                <form class="payment-details-form">
                    @csrf
                    <input type="hidden" name="payment" value="{{$order->payment}}">
                    <div class="form-group">
                        <input type="text" class="form-control" name="address" placeholder="Адрес кошелька">
                    </div>
                    <a href="#" class="btn btn-primary confirm-modal disabled">Добавить</a>
                </form>
            </div>
        </div>
    </div>
</div>
