@extends('dashboard.layouts.app')
@section('css')
    <link rel="stylesheet" href="/css/swiper-bundle.min.css" >
@endsection
@section('balances')
    <section class="balance">

        @if ($mode=='pro' && $user->isGate())
            @include('dashboard.components.gate.gate_balances')
        @else
            @include('dashboard.components.balance_items')
        @endif
    </section>
@endsection
@section('content')
    <main id="main-screen" class="resizable">
        <div class="screen-rollover ui-resizable-handle ui-resizable-n">
            <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="18" cy="18" r="18" fill="#347AF0"/>
                <path d="M18.375 6.38571C18.125 6.12857 17.75 6 17.5 6C17.25 6 16.875 6.12857 16.625 6.38571L10.375 12.8143C9.875 13.3286 9.875 14.1 10.375 14.6143C10.875 15.1286 11.625 15.1286 12.125 14.6143L17.5 9.08571L22.875 14.6143C23.375 15.1286 24.125 15.1286 24.625 14.6143C25.125 14.1 25.125 13.3286 24.625 12.8143L18.375 6.38571Z" fill="white"/>
                <path d="M16.625 28.6143C16.875 28.8714 17.25 29 17.5 29C17.75 29 18.125 28.8714 18.375 28.6143L24.625 22.1857C25.125 21.6714 25.125 20.9 24.625 20.3857C24.125 19.8714 23.375 19.8714 22.875 20.3857L17.5 25.9143L12.125 20.3857C11.625 19.8714 10.875 19.8714 10.375 20.3857C9.875 20.9 9.875 21.6714 10.375 22.1857L16.625 28.6143Z" fill="white"/>
            </svg>
        </div>
        <div class="main-screen-wrapper">
            @if ($mode == 'lite')
                @include('dashboard.components.filter')
                @include('dashboard.components.orders')
            @else
                @include('dashboard.components.gate.filter')
                @include('dashboard.components.gate.orders')
            @endif
        </div>
    </main>
    @include('dashboard.components.footer')
    @include('dashboard.components.createorder')
    @if ($mode == 'pro')
        @include('dashboard.components.gate.accept_order')
    @else
        @include('dashboard.components.payment-details-list')
    @endif
@endsection
@section('scripts')
    <script src="/js/swiper-bundle.min.js"></script>
    <script>

        function createOrderScreenOpen() {
            $('#create-order').toggleClass('opened');
        }
        $('.back-link').click(function(){
            $(this).closest('.screen').removeClass('opened');
        })
        $(function() {
            const balances = {
                @foreach ($visibleWallets as $visibleWallet)
                {{$visibleWallet}}: {
                    amountFree : {{$user->getBalanceFree($visibleWallet)}},
                    amountFrozen : {{$user->getBalanceFrozen($visibleWallet)}},
                    rate : {{$rates::getRates($visibleWallet)}}
                },
                @endforeach
            }
            $('.select-currency').on('change', function(e) {
                let crypto = $(this).children('option:selected').data('crypto') == 1
                let currency = $(this).val()
                let form = $(this).closest('form')
                getPayments(currency).then(function(data) {
                    // Run this when your request was successful
                    let payments = '';
                    $.each(data, function(key, item) {
                        payments += "<option value='" + item.title + "'>" + item.title + "</option>";
                        // $(this).closest('form').find('.select-payment').html(payments)
                    })
                    form.find('select[name="payment-network"]').html(payments)
                }).catch(function(err) {
                    // Run this when promise was rejected via reject()
                    console.log(err)
                })
                $('.form-withdraw .input-address').val('')
                if (crypto) $('.form-withdraw .input-address').addClass('crypto')
            })

            $('.create-order').click(function() {
                let form = $('#create-order .tab-pane.active form')
                let currency = form.find('select[name="currency"]').val()
                let amount = form.find('input[name="amount"]').val()
                let payment = form.find('select[name="payment-network"]').val()
                let address = form.find('input[name="address"]').val()
                let destination = form.find('input[name="destination"]').val()
                let data = {
                    "_token": "{{ csrf_token() }}",
                    "currency": currency,
                    "amount": amount,
                    "payment": payment,
                    "address": address,
                    "destination": destination
                }
                createOrder(data)
            })
            const swiper = new Swiper('.swiper', {
                // Optional parameters
                direction: 'horizontal',
                loop: true,

                // And if we need scrollbar
                scrollbar: {
                    el: '.swiper-scrollbar',
                },
            });
            @if ($mode == 'lite')
            $('.filter-items .filter-item').click(function(){
                let filter = $(this).data('filter')
                let d = $(this)
                return new Promise(function (resolve, reject) {
                    $.ajax({
                        url: "/api/getOrdersByFilter",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "filter": filter,
                        },
                        success: function (data) {
                            resolve(data)
                            let orders = getOrders(data)
                            $('.orders').html(orders)
                            $('.filter-items .filter-item').removeClass('active')
                            d.addClass('active')
                        },
                        error: function (err) {
                            reject(err)
                        }
                    })
                })
            })
            @endif
            @if ($mode == 'pro')
                swiper.on('transitionEnd', function () {
                    let activeCurrency = $('.swiper-slide.swiper-slide-active .total-amount-title span').html()
                    console.log(activeCurrency)
                    $('.balance-item.balance-available .balance-amount span').html(balances[activeCurrency]['amountFree'] * balances[activeCurrency]['rate'])
                    $('.balance-item.balance-frozen .balance-amount span').html(balances[activeCurrency]['amountFrozen'] * balances[activeCurrency]['rate'])
                    let progressBarWidth;
                    if (balances[activeCurrency]['amountFrozen'] != 0) progressBarWidth = 100 * balances[activeCurrency]['amountFree'] / balances[activeCurrency]['amountFrozen']
                    else progressBarWidth = 100
                    console.log(progressBarWidth)
                    $('.progress-bar').css('width', progressBarWidth + '%')
                });
            @endif
        });
        function getPayments(currency) {
            return new Promise(function (resolve, reject) {
                $.ajax({
                    url: "/api/getPayments",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "currency": currency,
                    },
                    success: function (data) {
                        resolve(data)
                    },
                    error: function (err) {
                        reject(err)
                    }
                })
            })
        }
        function createOrder(data) {
            return new Promise(function (resolve, reject) {
                $.ajax({
                    url: "/api/createOrderByUser",
                    type: "POST",
                    data: data,
                    success: function (data) {
                        resolve(data)
                        window.location.href = '{{Request::url()}}/orders/' + data;
                    },
                    error: function (err) {
                        reject(err)
                    }
                })
            })
        }
        $('.gate-controls .gate-action').click(function(e){
            let action = $(this).data('action')
            $('.orders .orders-deposit, .orders .orders-withdraw').hide()
            $('.orders-' + action).show()
            $('.gate-controls .gate-action').removeClass('active')
            $(this).addClass('active')
        })
        $('.form-withdraw .input-address').click(function(e){
            e.preventDefault();
            let payment =  $('.form-withdraw .select-payment').val();
            if ($(this).hasClass('crypto'))
            {
                $('#payment-details-list').addClass('crypto')
                $('#add-payment-details').addClass('crypto')
                $('#add-payment-details input[name="address"]').attr('placeholder', 'Номер кошелька')
            }
            else {
                $('#payment-details-list').removeClass('crypto')
                $('#add-payment-details').removeClass('crypto')
                $('#add-payment-details input[name="address"]').attr('placeholder', 'Номер карты')
            }
            $('#payment-details-list').addClass('opened')
            $('#payment-details-list .payment-items .payment-item').removeClass('d-flex').addClass('d-none')
            $('#payment-details-list .payment-item[data-payment="' + payment + '"]').removeClass('d-none').addClass('d-flex')
            $('#payment-details-list .add-payment_item').attr('data-payment', payment)
        })
        $('.add-payment_item').click(function() {
            $('#add-payment-details').modal()
        })
        @if ($mode == 'pro')
        $('.gate-order.order-created').click(function(e){
            if ($(this).hasClass('order-deposit')) {
                e.preventDefault();
                let amount = $(this).find('.amount').html();
                let payment = $(this).find('.payment_details span').html();
                let orderID = $(this).data('id');
                $('#accept-order .top-nav h2').text('Принять ' + amount)
                $('.payment-details-form input[name="payment"]').val(payment);
                $('#accept-order').attr('data-payment', payment);
                $('#accept-order a.order-accept').attr('data-id', orderID);
                $('#accept-order').addClass('opened');
                $('.payment-items .payment-item').removeClass('d-flex').addClass('d-none')
                $('.payment-item[data-payment="' + payment + '"]').removeClass('d-none').addClass('d-flex')
            }
            if ($(this).data('crypto') == 1) {
                $('#accept-order').addClass('crypto')
                $('.payment-details-form input[name="address"]').attr('placeholder', 'Адрес кошелька')
                $('.payment-details-form').addClass('crypto')
            }
            else {
                $('#accept-order').removeClass('crypto')
                $('.payment-details-form input[name="address"]').attr('placeholder', 'Номер карты')
                $('.payment-details-form').removeClass('crypto')
            }
        })
        @endif
        $('.payment-details-form input').on('change keyup', function() {
            let filledtextboxes = 1;
            if ($('.payment-details-form input[name="address"]').val().length == 0) filledtextboxes = 0;
            // if ($('.payment-details-form').closest('#add-payment-details').hasClass('crypto') && $('.payment-details-form input[name="address"]').val().length != 0) filledtextboxes = 1
            if (filledtextboxes != 0) $('.payment-details-form .confirm-modal').removeClass('disabled')
            else $('.payment-details-form .confirm-modal').addClass('disabled')
        })
        $('.payment-details-form .confirm-modal').click(function(e){
            e.preventDefault()
            if (!$(this).hasClass('disabled')) {
                return new Promise(function (resolve, reject) {
                    let form = $('.payment-details-form');
                    let data = {
                        "_token": "{{ csrf_token() }}",
                        "address": form.find('input[name="address"]').val(),
                        "payment": form.find('input[name="payment"]').val(),
                        "holder_name": form.find('input[name="holder_name"]').val(),
                    }
                    $.ajax({
                        url: "/api/payment_details/add",
                        type: "POST",
                        data: data,
                        success: function (data) {
                            resolve(data)
                            console.log(data)
                            $('.payment-items').append('<a class="payment-item d-flex align-items-center justify-content-start" data-address="' + data[0].address + '" data-payment="' + data[0].payment + '">' +
                                '<svg class="payment-details-icon" width="55" height="36" viewBox="0 0 56 36" fill="none" xmlns="http://www.w3.org/2000/svg">' +
                                '<rect x="1" width="55" height="36" rx="5" fill="#EFF2F9"></rect>' +
                                '<rect y="23" width="56" height="6" fill="white"></rect>' +
                            '</svg>' +
                            '<div class="payment-details">' +
                                '<span class="payment-system">' + data[0].payment + '</span>' +
                                '<span class="address">' + data[0].address + '</span>' +
                                '<span class="holder-name">' + data[0].holder + '</span>' +
                            '</div></a>');
                            $('#add-payment-details').modal('hide')
                        },
                        error: function (err) {
                            reject(err)
                        }
                    })
                })
            }
        })
        $('#accept-order .payment-items').on('click', '.payment-item', function() {
            $('.payment-item').removeClass('active')
            $(this).addClass('active')
            $('.order-accept').removeClass('disabled').attr('data-address', $(this).data('address'))
        })
        $('#payment-details-list .payment-items').on('click', '.payment-item', function() {
            $('.payment-item').removeClass('active')
            $(this).addClass('active')
            let address = $(this).find('.address').text();
            $('#payment-details-list').removeClass('opened')
            $('.input-address').val(address)
        })
        $('.order-accept').click(function() {
            if (!$(this).hasClass('disabled')) {
                let data = {
                    "_token": "{{ csrf_token() }}",
                    "id": $(this).data('id'),
                    "payment_details": $(this).data('address'),
                }
                return new Promise(function (resolve, reject) {
                    $.ajax({
                        url: "/api/orders/acceptOrderByGate",
                        type: "POST",
                        data: data,
                        success: function (data) {
                            resolve(data)
                            window.location.href = '{{Request::url()}}/orders/' + data;
                        },
                        error: function (err) {
                            reject(err)
                        }
                    })
                })
            }
        })
        function getOrders(orders) {
            let a = '';
            orders.forEach(function(order, i, arr) {
                console.log(order)
                let options = {
                    year: 'numeric',
                    month: 'numeric',
                    day: 'numeric',
                    hour12: false,
                    hour: 'numeric',
                    minute: 'numeric',
                    timezone: 'UTC'
                };
                let date = new Date(order.created_at).toLocaleString("ru", options).replace(',','')
                let currency = order.currency
                let decimal = 2
                if (currency == 'BTC') decimal = 7
                if (currency == 'ETH') decimal = 6
                let amount = parseFloat(order.amount)

                a += '<a href="/dashboard/orders/' + order.id + '" class="order-item d-flex justify-content-between align-items-center">' +
                    '<div class="d-flex align-items-start flex-column justify-content-center">' +
                        '<div class="destination ' + order.destination + '">'
                if (order.destination == 'deposit') a += 'Ввод'
                if (order.destination == 'withdraw') a += 'Вывод'
                a += '</div>' +
                        '<div class="currency">' + order.currency + '</div>' +
                    '</div>' +
                    '<div class="d-flex align-items-end flex-column justify-content-center">' +
                        '<div class="d-flex align-items-center">' +
                            '<div class="datetime">' +
                    date +
                            '</div>' +
                            '<div class="order-status">'
                if (order.status == 'completed') a += '<svg width="14" height="10" viewBox="0 0 14 10" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_534:288)"><path d="M1.58575 3.47816C1.74321 3.4771 1.86381 3.48137 1.98106 3.50918C2.20217 3.56158 2.40876 3.64606 2.5919 3.7776C2.75493 3.89416 2.89117 4.03853 3.03411 4.17542C3.36353 4.48875 3.69072 4.80316 4.01792 5.11649C4.30714 5.39347 4.59748 5.67044 4.8867 5.94849C4.99056 6.04901 5.11563 6.09072 5.25856 6.06933C5.32556 6.05971 5.38922 6.03083 5.44393 5.98592C5.53327 5.9132 5.61256 5.82979 5.69631 5.75065C6.01345 5.44801 6.32947 5.1443 6.64662 4.84059C6.99614 4.50586 7.34455 4.17114 7.69408 3.83642C8.06147 3.48458 8.43109 3.13382 8.79849 2.78091C9.14019 2.45368 9.47967 2.12537 9.82138 1.7992C10.1363 1.49763 10.4534 1.19606 10.7683 0.894484C10.9124 0.756531 11.0564 0.617508 11.2016 0.478485C11.3356 0.351226 11.483 0.240008 11.6528 0.160872C11.7622 0.109541 11.8772 0.0699729 11.9978 0.0443072C12.1564 0.0100863 12.3161 -0.0123712 12.478 0.00260043C12.6287 0.0165027 12.7773 0.0432378 12.9224 0.0934998C13.0911 0.151248 13.2429 0.231453 13.3825 0.337324C13.5779 0.485971 13.7309 0.66777 13.8392 0.88379C13.8794 0.965065 13.9129 1.04848 13.9386 1.13296C13.9576 1.19606 13.9677 1.26236 13.9811 1.32759C14.0034 1.44309 14.0034 1.55645 13.9956 1.67087C13.9911 1.75108 13.9766 1.83128 13.9543 1.91042C13.9364 1.97244 13.9185 2.0334 13.8973 2.09436C13.8649 2.18526 13.8191 2.26974 13.7689 2.35208C13.6695 2.51677 13.5322 2.65045 13.3937 2.78412C13.1257 3.04078 12.8588 3.29744 12.5919 3.55302C12.3306 3.80326 12.0682 4.05244 11.8069 4.30268C11.4104 4.68231 11.0151 5.06195 10.6187 5.44159C10.2468 5.7977 9.87498 6.15275 9.50424 6.50886C9.11116 6.88529 8.71808 7.26279 8.32501 7.63922C7.95315 7.99533 7.58129 8.35144 7.20943 8.70755C6.92579 8.97918 6.64438 9.25188 6.35962 9.52244C6.22674 9.64863 6.07933 9.75878 5.9096 9.83471C5.80016 9.8839 5.68626 9.92667 5.56454 9.94913C5.4618 9.96838 5.36018 9.98656 5.25633 9.99512C5.12903 10.0058 5.00172 9.98977 4.87889 9.96624C4.5718 9.90529 4.29821 9.7791 4.07263 9.56415C3.85041 9.35134 3.62596 9.13959 3.40373 8.92785C3.03187 8.57174 2.66001 8.21563 2.28816 7.85952C1.99893 7.58254 1.70971 7.3045 1.42048 7.02752C1.10781 6.72809 0.796251 6.42758 0.48246 6.12922C0.325006 5.98057 0.205519 5.8084 0.121767 5.61377C0.0737494 5.50255 0.0413652 5.38598 0.0234981 5.26514C0.00786437 5.16248 -0.00441927 5.06088 0.0033976 4.95929C0.0156812 4.79888 0.0447153 4.64168 0.105017 4.48982C0.149685 4.37967 0.203286 4.27594 0.269171 4.17649C0.405408 3.97223 0.586312 3.81182 0.801834 3.68777C0.898987 3.63216 1.00172 3.58831 1.11116 3.55623C1.40597 3.47175 1.41713 3.48458 1.58575 3.47816Z" fill="#75BF72"></path></g><defs><clipPath id="clip0_534:288"><rect width="14" height="10" fill="white"></rect></clipPath></defs></svg>'
                            else a += '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.0055 0H7.99695C5.85947 0 3.84894 0.833625 2.33647 2.34709C0.82644 3.85689 -0.0036501 5.86345 1.20659e-05 7.9945C0.00367423 10.316 0.874048 12.2981 2.58916 13.8848C4.10041 15.2835 5.91807 15.9951 7.99329 16H8.01282C10.1357 16 12.1364 15.1712 13.6452 13.6675C15.1626 12.1553 15.9988 10.1463 16 8.00793C16.0024 3.59692 12.416 0.00488214 8.0055 0ZM3.96369 12.0394C2.85284 10.8884 2.29131 9.52871 2.29253 7.99572C2.29375 6.46639 2.8565 5.11038 3.96247 3.9643C4.53255 3.41506 5.15634 2.99641 5.81553 2.72057C6.48814 2.43985 7.22302 2.29705 8.00184 2.29705C9.55948 2.29705 10.9169 2.86093 12.0363 3.97162C13.1203 5.04691 13.7148 6.4786 13.7087 8.0006C13.6953 9.54946 13.1301 10.9104 12.0375 12.0357C10.8876 13.1439 9.52896 13.7066 7.99207 13.7066C6.46373 13.7054 5.10873 13.1439 3.96369 12.0394Z" fill="#FFA500"></path><path d="M11.0308 8.89528C10.9307 8.81228 10.8306 8.73905 10.733 8.66582L10.3655 8.39242C10.2813 8.33017 10.1971 8.26792 10.1141 8.20446C10.0518 8.15808 9.98955 8.11047 9.92851 8.06287L9.9041 8.04457C9.84306 7.99819 9.78203 7.9518 9.72099 7.90542C9.63432 7.84074 9.54765 7.77605 9.4622 7.71258L9.20463 7.51974C9.18509 7.50509 9.16678 7.49044 9.14725 7.4758C9.14969 6.64217 9.14847 5.79878 9.14847 4.98102V4.63927C9.14847 4.34268 9.05326 4.07295 8.87381 3.85813C8.70291 3.65308 8.47341 3.5176 8.20852 3.46878C8.0071 3.43094 7.81056 3.44559 7.62623 3.51394C7.42481 3.58717 7.2649 3.69458 7.13672 3.84226C6.94873 4.0583 6.84863 4.33414 6.84863 4.63805C6.84863 4.99933 6.84863 5.36183 6.84863 5.72311V6.31019V6.79718C6.84863 7.19263 6.84863 7.60273 6.84985 8.00551C6.85107 8.42171 7.03907 8.78055 7.37965 9.01611C7.45167 9.06615 7.52735 9.12108 7.61158 9.18699C7.79591 9.32857 7.98512 9.46893 8.16823 9.60563L8.19753 9.62638C8.3135 9.71182 8.42947 9.80092 8.54299 9.88757C8.63943 9.96081 8.73465 10.034 8.83108 10.106C8.94827 10.1939 9.06546 10.2806 9.18265 10.3672L9.20096 10.3807C9.33158 10.4771 9.4622 10.5735 9.59159 10.6712C9.81132 10.8359 10.0481 10.9189 10.296 10.9189C10.4046 10.9189 10.5145 10.9031 10.6219 10.8701C11.0443 10.7432 11.336 10.4246 11.4227 9.99498C11.5069 9.5739 11.3641 9.17234 11.0308 8.89528Z" fill="#FFA500"></path></svg>'

                a += '</div>' +
                        '</div>' +
                        '<div class="amount">' + amount.toFixed(decimal).replace(/\d(?=(\d{3})+\.)/g, '$& ') + '</div>' +
                    '</div>' +
                '</a>'
            });
            return a
        }
    </script>

@endsection
