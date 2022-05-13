<div class="section-header">
    <div class="top-nav">
        <a href="{{ Route('wallet') }}" class="back-link">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M15.7071 17.2929C16.0976 17.6834 16.0976 18.3166 15.7071 18.7071C15.3166 19.0976 14.6834 19.0976 14.2929 18.7071L8.29289 12.7071C7.90237 12.3166 7.90237 11.6834 8.29289 11.2929L14.2929 5.29289C14.6834 4.90237 15.3166 4.90237 15.7071 5.29289C16.0976 5.68342 16.0976 6.31658 15.7071 6.70711L10.4142 12L15.7071 17.2929Z"
                      fill="#0D1F3C"></path>
                <mask id="back-link" mask-type="alpha" maskUnits="userSpaceOnUse" x="8" y="5" width="8" height="14">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M15.7071 17.2929C16.0976 17.6834 16.0976 18.3166 15.7071 18.7071C15.3166 19.0976 14.6834 19.0976 14.2929 18.7071L8.29289 12.7071C7.90237 12.3166 7.90237 11.6834 8.29289 11.2929L14.2929 5.29289C14.6834 4.90237 15.3166 4.90237 15.7071 5.29289C16.0976 5.68342 16.0976 6.31658 15.7071 6.70711L10.4142 12L15.7071 17.2929Z"
                          fill="white"></path>
                </mask>
                <g mask="url(#back-link)">
                    <rect width="24" height="24" fill="#0D1F3C"></rect>
                </g>
            </svg>
        </a>
        <h2>
            Принять {{number_format($order->amount, Auth::user()->getWallet($order->currency)->decimal_places, ',', ' ')}} {{$order->currency}}</h2>
        <svg class="status" width="64" height="62" viewBox="0 0 64 62" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M32 60C48.5685 60 62 46.5685 62 30C62 13.4315 48.5685 0 32 0C15.4315 0 2 13.4315 2 30C2 46.5685 15.4315 60 32 60Z"
                  fill="#FFA500" stroke="white" stroke-width="4"/>
            <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M37.1838 12.0705C36.2845 11.8042 35.3391 12.3152 35.0693 13.2135L30.6345 28.7582L21.8677 36.4277C21.159 37.055 21.0876 38.1359 21.7077 38.8509C22.3349 39.5596 23.4158 39.6309 24.1308 39.0109L33.2748 31.0099C33.5229 30.7917 33.7017 30.5057 33.7891 30.187L38.3611 14.1851C38.4877 13.7485 38.4345 13.2794 38.2134 12.8823C37.9923 12.4851 37.6216 12.1929 37.1838 12.0705Z"
                  fill="white"/>
        </svg>
    </div>
</div>
<div class="section-main">
    <div class="text-block">
        <p><small>Заявка #</small></p>
        <p>{{$order->id}}</p>
    </div>
    <div class="text-block">
        <p><small>На пополнение:</small></p>
        <p>{{$order->amount}} {{$order->currency}}</p>
    </div>
    <div class="text-block">
        <p><small>@if (\App\Models\Payment::where('title', $order->payment)->first()->crypto)
                    Cеть:
                @else
                    Платежная система:
                @endif</small></p>
        <p>{{$order->payment}}</p>
    </div>
    <div class="text-block">
        <p><small>Оставшееся время:</small></p>
        <p class="timeleft">@include('wallet.components.order.timeleft')</p>
    </div>
    <div class="text-block">
        <p><small>Статус:</small></p>
        <p style="color:#347AF0">Новая заявка</p>
    </div>
    <div class="text-block">
        <p><small>Бонус кипера:</small></p>
        <p>{{round($order->amount * Rate::getRates($order->currency) / 200 / Rate::getRates('DHB'))}} DHB</p>
    </div>
    @if (Auth::user()->getBalanceFree($order->currency) >= $order->amount)
        <div class="footer">
            <a class="button button-blue" onclick="openAcceptForm()">Принять заявку</a>
        </div>
    @else
        <div class="footer">
            <div class="text-block mt-0 pt-0">
                <h4 class="text-left">Вы не можете принять заявку,<br/> не достаточно средств</h4>
            </div>
            <a href="/wallet/" class="button button-red">Вернуться на главную</a>
        </div>
    @endif
</div>
