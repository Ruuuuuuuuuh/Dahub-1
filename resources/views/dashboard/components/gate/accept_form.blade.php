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
            <h2>Принять {{$order->amount}} {{$order->currency}} </h2>
        </div>
    </div>
    <div class="section-main">
        <h4 class="accept-order-title crypto-hidden">Выберите реквизиты {{$order->payment}}</h4>
        <div class="payment-items">
            @foreach (Auth::user()->paymentDetails()->get() as $payment)

                @if ($payment->payment()->first()->title == $order->payment)
                <a class="payment-item d-flex align-items-center justify-content-between" data-address="{{$payment->address}}" data-id="{{ $payment->id }}" data-payment="{{$payment->payment()->first()->title}}">
                        <svg class="payment-details-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="10" cy="10" r="10" fill="#EDF1F9"/>
                            <circle class="payment-item-icon-inner" cx="10" cy="10" r="6" fill="#EDF1F9"/>
                        </svg>
                        <div class="payment-details">
                            <div class="name">Кошелек 1</div>
                            <span class="address">{{$payment->address}}</span>
                        </div>
                        <div class="action-btn">
                            <button type="button" class="icon icon-edit edit-payment_item">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3 18H7C7.3 18 7.5 17.9 7.7 17.7L18.7 6.7C19.1 6.3 19.1 5.7 18.7 5.3L14.7 1.3C14.3 0.9 13.7 0.9 13.3 1.3L2.3 12.3C2.1 12.5 2 12.7 2 13V17C2 17.6 2.4 18 3 18ZM4 13.4L14 3.4L16.6 6L6.6 16H4V13.4ZM21 23C21.6 23 22 22.6 22 22C22 21.4 21.6 21 21 21H3C2.4 21 2 21.4 2 22C2 22.6 2.4 23 3 23H21Z" fill="black"/>
                                    <mask id="mask0_856_1420" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="2" y="1" width="20" height="22">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3 18H7C7.3 18 7.5 17.9 7.7 17.7L18.7 6.7C19.1 6.3 19.1 5.7 18.7 5.3L14.7 1.3C14.3 0.9 13.7 0.9 13.3 1.3L2.3 12.3C2.1 12.5 2 12.7 2 13V17C2 17.6 2.4 18 3 18ZM4 13.4L14 3.4L16.6 6L6.6 16H4V13.4ZM21 23C21.6 23 22 22.6 22 22C22 21.4 21.6 21 21 21H3C2.4 21 2 21.4 2 22C2 22.6 2.4 23 3 23H21Z" fill="white"/>
                                    </mask>
                                    <g mask="url(#mask0_856_1420)">
                                    <rect width="24" height="24" fill="white"/>
                                    </g>
                                </svg>
                            </button>
                            <button type="button" class="icon icon-delete delete-payment_item">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M21 5H17V4C17 2.3 15.7 1 14 1H10C8.3 1 7 2.3 7 4V5H3C2.4 5 2 5.4 2 6C2 6.6 2.4 7 3 7H4V20C4 21.7 5.3 23 7 23H17C18.7 23 20 21.7 20 20V7H21C21.6 7 22 6.6 22 6C22 5.4 21.6 5 21 5ZM9 4C9 3.4 9.4 3 10 3H14C14.6 3 15 3.4 15 4V5H9V4ZM17 21C17.6 21 18 20.6 18 20V7H6V20C6 20.6 6.4 21 7 21H17ZM11 11V17C11 17.6 10.6 18 10 18C9.4 18 9 17.6 9 17V11C9 10.4 9.4 10 10 10C10.6 10 11 10.4 11 11ZM15 17V11C15 10.4 14.6 10 14 10C13.4 10 13 10.4 13 11V17C13 17.6 13.4 18 14 18C14.6 18 15 17.6 15 17Z" fill="black"/>
                                    <mask id="mask0_856_1417" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="2" y="1" width="20" height="22">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M21 5H17V4C17 2.3 15.7 1 14 1H10C8.3 1 7 2.3 7 4V5H3C2.4 5 2 5.4 2 6C2 6.6 2.4 7 3 7H4V20C4 21.7 5.3 23 7 23H17C18.7 23 20 21.7 20 20V7H21C21.6 7 22 6.6 22 6C22 5.4 21.6 5 21 5ZM9 4C9 3.4 9.4 3 10 3H14C14.6 3 15 3.4 15 4V5H9V4ZM17 21C17.6 21 18 20.6 18 20V7H6V20C6 20.6 6.4 21 7 21H17ZM11 11V17C11 17.6 10.6 18 10 18C9.4 18 9 17.6 9 17V11C9 10.4 9.4 10 10 10C10.6 10 11 10.4 11 11ZM15 17V11C15 10.4 14.6 10 14 10C13.4 10 13 10.4 13 11V17C13 17.6 13.4 18 14 18C14.6 18 15 17.6 15 17Z" fill="white"/>
                                    </mask>
                                    <g mask="url(#mask0_856_1417)">
                                    <rect width="24" height="24" fill="white"/>
                                    </g>
                                </svg>
                            </button>
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
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content ">
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


<div class="modal fade" id="edit-payment-details" tabindex="-1" role="dialog" aria-labelledby="edit-payment-details" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="2.82812" width="40" height="4" rx="2" transform="rotate(45 2.82812 0)" fill="white"/>
                        <rect width="40" height="4" rx="2" transform="matrix(-0.707107 0.707107 0.707107 0.707107 28.2842 0)" fill="white"/>
                    </svg>
                </button>
                <h4>Изменить реквизиты</h4>
            </div>
        </div>
    </div>
</div>


