<div class="orders">

    <div class="order-owned">
        @if (isset($orders['owned']))
        @foreach ($orders['owned'] as $order)
            <a href="{{Route('getOrder', $order->id)}}" class="order-item @if ($order->destination == 'TokenSale') order-deposit @else order-{{$order->destination}} @endif order-{{$order->status}} gate-order d-flex justify-content-between align-items-center" data-id="{{$order->id}}">
                <div class="d-flex align-items-start flex-column justify-content-center order-destination">
                    @if ($order->destination == 'deposit' || $order->destination == 'TokenSale')
                        <svg width="26" height="18" viewBox="0 0 26 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1.49995 10.5L14.8787 10.5L9.93935 15.4394C9.35355 16.0251 9.35355 16.9748 9.93935 17.5606C10.525 18.1464 11.4749 18.1464 12.0607 17.5606L19.5607 10.0607C20.1465 9.47496 20.1465 8.52516 19.5607 7.93936L12.0607 0.439363C11.7678 0.146463 11.3839 -3.69929e-05 11 -3.70264e-05C10.6161 -3.706e-05 10.2322 0.146463 9.93935 0.439363C9.35355 1.02506 9.35355 1.97486 9.93935 2.56066L14.8787 7.49996L1.49995 7.49996C0.671552 7.49996 -4.87318e-05 8.17156 -4.88043e-05 8.99996C-4.88767e-05 9.82835 0.671551 10.5 1.49995 10.5Z" fill="#347AF0"/>
                            <rect x="23" y="18" width="18" height="3" rx="1.5" transform="rotate(-90 23 18)" fill="#347AF0"/>
                        </svg>
                    @elseif ($order->destination == 'withdraw')
                        <svg width="26" height="18" viewBox="0 0 26 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.5 7.50004L5.12135 7.50004L10.0607 2.56065C10.6465 1.97495 10.6465 1.02515 10.0607 0.43935C9.47495 -0.14645 8.52515 -0.14645 7.93935 0.43935L0.43935 7.93934C-0.14645 8.52504 -0.14645 9.47484 0.43935 10.0606L7.93935 17.5606C8.23225 17.8535 8.61615 18 9.00005 18C9.38395 18 9.76785 17.8535 10.0607 17.5606C10.6465 16.9749 10.6465 16.0251 10.0607 15.4393L5.12135 10.5L18.5 10.5C19.3284 10.5 20 9.82844 20 9.00004C20 8.17164 19.3284 7.50004 18.5 7.50004Z" fill="#347AF0"/>
                            <rect x="23" y="18" width="18" height="3" rx="1.5" transform="rotate(-90 23 18)" fill="#347AF0"/>
                        </svg>
                    @endif
                </div>
                <div class="d-flex align-items-end flex-column justify-content-center w-100">
                    <div class="d-flex justify-content-between w-100">
                        <div class="amount">{{number_format($order->amount, Auth::user()->getWallet($order->currency)->decimal_places, '.', ' ')}} {{$order->currency}}</div>
                        <div class="datetime">{{$order->created_at->format('H:i')}}</div>
                        <div class="order-id">#{{$order->id}}</div>
                        <div class="order-status">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.0055 0H7.99695C5.85947 0 3.84894 0.833625 2.33647 2.34709C0.82644 3.85689 -0.0036501 5.86345 1.20659e-05 7.9945C0.00367423 10.316 0.874048 12.2981 2.58916 13.8848C4.10041 15.2835 5.91807 15.9951 7.99329 16H8.01282C10.1357 16 12.1364 15.1712 13.6452 13.6675C15.1626 12.1553 15.9988 10.1463 16 8.00793C16.0024 3.59692 12.416 0.00488214 8.0055 0ZM3.96369 12.0394C2.85284 10.8884 2.29131 9.52871 2.29253 7.99572C2.29375 6.46639 2.8565 5.11038 3.96247 3.9643C4.53255 3.41506 5.15634 2.99641 5.81553 2.72057C6.48814 2.43985 7.22302 2.29705 8.00184 2.29705C9.55948 2.29705 10.9169 2.86093 12.0363 3.97162C13.1203 5.04691 13.7148 6.4786 13.7087 8.0006C13.6953 9.54946 13.1301 10.9104 12.0375 12.0357C10.8876 13.1439 9.52896 13.7066 7.99207 13.7066C6.46373 13.7054 5.10873 13.1439 3.96369 12.0394Z" fill="#FFA500"/>
                                <path d="M11.0308 8.89528C10.9307 8.81228 10.8306 8.73905 10.733 8.66582L10.3655 8.39242C10.2813 8.33017 10.1971 8.26792 10.1141 8.20446C10.0518 8.15808 9.98955 8.11047 9.92851 8.06287L9.9041 8.04457C9.84306 7.99819 9.78203 7.9518 9.72099 7.90542C9.63432 7.84074 9.54765 7.77605 9.4622 7.71258L9.20463 7.51974C9.18509 7.50509 9.16678 7.49044 9.14725 7.4758C9.14969 6.64217 9.14847 5.79878 9.14847 4.98102V4.63927C9.14847 4.34268 9.05326 4.07295 8.87381 3.85813C8.70291 3.65308 8.47341 3.5176 8.20852 3.46878C8.0071 3.43094 7.81056 3.44559 7.62623 3.51394C7.42481 3.58717 7.2649 3.69458 7.13672 3.84226C6.94873 4.0583 6.84863 4.33414 6.84863 4.63805C6.84863 4.99933 6.84863 5.36183 6.84863 5.72311V6.31019V6.79718C6.84863 7.19263 6.84863 7.60273 6.84985 8.00551C6.85107 8.42171 7.03907 8.78055 7.37965 9.01611C7.45167 9.06615 7.52735 9.12108 7.61158 9.18699C7.79591 9.32857 7.98512 9.46893 8.16823 9.60563L8.19753 9.62638C8.3135 9.71182 8.42947 9.80092 8.54299 9.88757C8.63943 9.96081 8.73465 10.034 8.83108 10.106C8.94827 10.1939 9.06546 10.2806 9.18265 10.3672L9.20096 10.3807C9.33158 10.4771 9.4622 10.5735 9.59159 10.6712C9.81132 10.8359 10.0481 10.9189 10.296 10.9189C10.4046 10.9189 10.5145 10.9031 10.6219 10.8701C11.0443 10.7432 11.336 10.4246 11.4227 9.99498C11.5069 9.5739 11.3641 9.17234 11.0308 8.89528Z" fill="#FFA500"/>
                            </svg>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between w-100">
                        <div class="tax">Комиссия 0.5%  (+{{round($order->amount * Rate::getRates($order->currency) / 200 / Rate::getRates('DHB'))}} DHB)</div>
                        <div class="payment_details">
                            @if ($order->payment)
                                <svg width="19" height="13" viewBox="0 0 19 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="19" height="13" rx="3" fill="#B5BBC9"/>
                                    <rect x="1" y="8" width="17" height="2" fill="#EDF1F9"/>
                                </svg>
                                <span>{{$order->payment}}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    @endif
    </div>
    <div class="orders-deposit">
        @foreach ($orders['deposit'] as $order)
            @if ($order->amount <= $user->getBalanceFree($order->currency))
            <a href="{{Route('getOrder', $order->id)}}" class="order-item @if ($order->destination == 'TokenSale') order-deposit @else order-{{$order->destination}} @endif order-{{$order->status}} gate-order d-flex justify-content-between align-items-center" data-id="{{$order->id}}" data-crypto="{{\App\Models\Currency::where('title', $order->currency)->first()->crypto}}">
                <div class="d-flex align-items-start flex-column justify-content-center order-destination">
                    @if ($order->destination == 'deposit' || $order->destination == 'TokenSale')
                    <svg width="26" height="18" viewBox="0 0 26 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.49995 10.5L14.8787 10.5L9.93935 15.4394C9.35355 16.0251 9.35355 16.9748 9.93935 17.5606C10.525 18.1464 11.4749 18.1464 12.0607 17.5606L19.5607 10.0607C20.1465 9.47496 20.1465 8.52516 19.5607 7.93936L12.0607 0.439363C11.7678 0.146463 11.3839 -3.69929e-05 11 -3.70264e-05C10.6161 -3.706e-05 10.2322 0.146463 9.93935 0.439363C9.35355 1.02506 9.35355 1.97486 9.93935 2.56066L14.8787 7.49996L1.49995 7.49996C0.671552 7.49996 -4.87318e-05 8.17156 -4.88043e-05 8.99996C-4.88767e-05 9.82835 0.671551 10.5 1.49995 10.5Z" fill="#347AF0"/>
                        <rect x="23" y="18" width="18" height="3" rx="1.5" transform="rotate(-90 23 18)" fill="#347AF0"/>
                    </svg>
                    @elseif ($order->destination == 'withdraw')
                        <svg width="26" height="18" viewBox="0 0 26 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.5 7.50004L5.12135 7.50004L10.0607 2.56065C10.6465 1.97495 10.6465 1.02515 10.0607 0.43935C9.47495 -0.14645 8.52515 -0.14645 7.93935 0.43935L0.43935 7.93934C-0.14645 8.52504 -0.14645 9.47484 0.43935 10.0606L7.93935 17.5606C8.23225 17.8535 8.61615 18 9.00005 18C9.38395 18 9.76785 17.8535 10.0607 17.5606C10.6465 16.9749 10.6465 16.0251 10.0607 15.4393L5.12135 10.5L18.5 10.5C19.3284 10.5 20 9.82844 20 9.00004C20 8.17164 19.3284 7.50004 18.5 7.50004Z" fill="#347AF0"/>
                            <rect x="23" y="18" width="18" height="3" rx="1.5" transform="rotate(-90 23 18)" fill="#347AF0"/>
                        </svg>
                    @endif
                </div>
                <div class="d-flex align-items-end flex-column justify-content-center w-100">
                    <div class="d-flex justify-content-between w-100">
                        <div class="amount">{{number_format($order->amount, Auth::user()->getWallet($order->currency)->decimal_places, '.', ' ')}} {{$order->currency}}</div>
                        <div class="datetime">{{$order->created_at->format('H:i')}}</div>
                        <div class="datetime">#{{$order->id}}</div>
                    </div>
                    <div class="d-flex justify-content-between w-100">
                        <div class="tax">Комиссия 0.5%  (+{{round($order->amount * Rate::getRates($order->currency) / 200 / Rate::getRates('DHB'))}} DHB)</div>
                        <div class="payment_details">
                            @if ($order->payment)
                            <svg width="19" height="13" viewBox="0 0 19 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="19" height="13" rx="3" fill="#B5BBC9"/>
                                <rect x="1" y="8" width="17" height="2" fill="#EDF1F9"/>
                            </svg>
                            <span>{{$order->payment}}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </a>
            @endif
        @endforeach
    </div>
    <div class="orders-withdraw" style="display:none;">
        @foreach ($orders['withdraw'] as $order)
            @if ($order->amount <= $user->getBalance($order->currency.'_gate'))
            <a href="{{Route('getOrder', $order->id)}}" class="order-item order-{{$order->destination}} order-{{$order->status}} gate-order d-flex justify-content-between align-items-center" data-id="{{$order->id}}">
                <div class="d-flex align-items-start flex-column justify-content-center order-destination">
                    @if ($order->destination == 'deposit')
                        <svg width="26" height="18" viewBox="0 0 26 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1.49995 10.5L14.8787 10.5L9.93935 15.4394C9.35355 16.0251 9.35355 16.9748 9.93935 17.5606C10.525 18.1464 11.4749 18.1464 12.0607 17.5606L19.5607 10.0607C20.1465 9.47496 20.1465 8.52516 19.5607 7.93936L12.0607 0.439363C11.7678 0.146463 11.3839 -3.69929e-05 11 -3.70264e-05C10.6161 -3.706e-05 10.2322 0.146463 9.93935 0.439363C9.35355 1.02506 9.35355 1.97486 9.93935 2.56066L14.8787 7.49996L1.49995 7.49996C0.671552 7.49996 -4.87318e-05 8.17156 -4.88043e-05 8.99996C-4.88767e-05 9.82835 0.671551 10.5 1.49995 10.5Z" fill="#347AF0"/>
                            <rect x="23" y="18" width="18" height="3" rx="1.5" transform="rotate(-90 23 18)" fill="#347AF0"/>
                        </svg>
                    @elseif ($order->destination == 'withdraw')
                        <svg width="26" height="18" viewBox="0 0 26 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.5 7.50004L5.12135 7.50004L10.0607 2.56065C10.6465 1.97495 10.6465 1.02515 10.0607 0.43935C9.47495 -0.14645 8.52515 -0.14645 7.93935 0.43935L0.43935 7.93934C-0.14645 8.52504 -0.14645 9.47484 0.43935 10.0606L7.93935 17.5606C8.23225 17.8535 8.61615 18 9.00005 18C9.38395 18 9.76785 17.8535 10.0607 17.5606C10.6465 16.9749 10.6465 16.0251 10.0607 15.4393L5.12135 10.5L18.5 10.5C19.3284 10.5 20 9.82844 20 9.00004C20 8.17164 19.3284 7.50004 18.5 7.50004Z" fill="#347AF0"/>
                            <rect x="23" y="18" width="18" height="3" rx="1.5" transform="rotate(-90 23 18)" fill="#347AF0"/>
                        </svg>
                    @endif
                </div>
                <div class="d-flex align-items-end flex-column justify-content-center w-100">
                    @if ($order->rate)
                        <div class="amount">{{number_format($order->amount / $order->rate, Auth::user()->getWallet($order->currency)->decimal_places, '.', ' ')}} {{$order->currency}}</div>
                        <div class="datetime">{{$order->created_at->format('d.m.Y H:i')}}</div>
                    @else
                        <div class="d-flex justify-content-between w-100">
                            <div class="amount">{{number_format($order->amount, Auth::user()->getWallet($order->currency)->decimal_places, '.', ' ')}} {{$order->currency}}</div>
                            <div class="datetime">{{$order->created_at->format('H:i')}}</div>
                            <div class="datetime">#{{$order->id}}</div>
                        </div>
                        <div class="d-flex justify-content-between w-100">
                            <div class="tax">Комиссия 1%  (+{{$order->amount / 100}} {{$order->currency}})</div>
                            <div class="payment_details">
                                @if ($order->payment)
                                    <svg width="19" height="13" viewBox="0 0 19 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="19" height="13" rx="3" fill="#B5BBC9"/>
                                        <rect x="1" y="8" width="17" height="2" fill="#EDF1F9"/>
                                    </svg>
                                    <span>{{$order->payment}}</span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </a>
            @endif
        @endforeach
    </div>
</div>
