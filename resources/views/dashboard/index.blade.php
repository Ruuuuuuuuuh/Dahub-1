@extends('dashboard.layouts.app')
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
    @endif
@endsection
@section('scripts')

    <script>
        function createOrderScreenOpen() {
            $('#create-order').toggleClass('opened');
        }
        $('.back-link').click(function(){
            $('.screen').removeClass('opened');
        })
        $(function() {

            $('.select-currency').on('change', function(e) {
                let currency = $(this).val()
                let form = $(this).closest('form')
                getPayments(currency).then(function(data) {
                    // Run this when your request was successful
                    let payments = '';
                    $.each(data, function(key, item) {
                        payments += "<option value='" + item.title + "'>" + item.title + "</option>";
                        // $(this).closest('form').find('.select-payment').html(payments)
                    })
                    console.log(form.find('select-payments'))
                    form.find('select[name="payment-network"]').html(payments)
                }).catch(function(err) {
                    // Run this when promise was rejected via reject()
                    console.log(err)
                })
            })
            $('.section-main .create-order').click(function(){
                let form = $(this).parent().find('form')
                let currency = form.find('select[name="currency"]').val()
                let amount = form.find('input[name="amount"]').val()
                let payment = form.find('select[name="payment-network"]').val()
                let destination = form.find('input[name="destination"]').val()
                let data = {
                    "_token": "{{ csrf_token() }}",
                    "currency": currency,
                    "amount": amount,
                    "payment": payment,
                    "destination": destination
                }
                createOrder(data)
            })
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
            $('.gate-controls .gate-action').removeClass('active')
            $(this).addClass('active')
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
                $('#accept-order a.order-accept').attr('data-id', orderID);
                $('#accept-order').addClass('opened');
                $('.payment-items .payment-item').removeClass('d-flex').addClass('d-none')
                $('.payment-item[data-payment="' + payment + '"]').removeClass('d-none').addClass('d-flex')
            }
        })
        $('.add-payment_item').click(function(){
            $('#add-payment-details').modal()
        })
        @endif
        $('.payment-details-form input').on('change keyup', function(){
            let filledtextboxes = 1;
            $('.payment-details-form input:text').each(function(i) {
                if ($(this).val().length == 0) {
                    filledtextboxes = 0
                }
            });
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
                            $('.payment-items').append('<a class="payment-item d-flex align-items-center justify-content-start" data-id="' + data[0].id + '" data-payment="' + data[0].payment + '">' +
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
        $('.payment-items').on('click', '.payment-item', function() {
            $('.payment-item').removeClass('active')
            $(this).addClass('active')
            $('.order-accept').removeClass('disabled').attr('data-address', $(this).data('id'))
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
    </script>
@endsection
