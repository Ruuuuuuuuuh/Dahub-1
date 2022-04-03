<section id="accept-order" class="screen" data-payment="{{$order->payment}}"  >
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
            <h2>Принять {{number_format($order->amount, Auth::user()->getWallet($order->currency)->decimal_places, ',', ' ')}} {{$order->currency}} </h2>
        </div>
    </div>
    <div class="section-main">
        <h4 class="accept-order-title crypto-hidden">Выберите реквизиты {{$order->payment}}</h4>
        <payments-list
            payment="{{$order->payment}}"
            _token="{{csrf_token()}}"
            crypto= "{{ \App\Models\Currency::where('title', $order->currency)->first()->crypto }}">
        </payments-list>

        <a href="#" class="btn btn-primary order-accept disabled">Принять заявку</a>
    </div>
</section>
