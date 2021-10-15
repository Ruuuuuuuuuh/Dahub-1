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
            @include('dashboard.components.filter')
            @include('dashboard.components.orders')
        </div>
    </main>
    @include('dashboard.components.footer')
    @include('dashboard.components.createorder')
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.19/jquery.touchSwipe.min.js" type="text/javascript"></script>


    <script>
        window.onload = function() {
            if (screen.width < 375) {
                let mvp = document.getElementById('viewport');
                mvp.setAttribute('content','user-scalable=no,width=375,  height=device-height');
            }
        }
        function createOrderScreenOpen() {
            $('#create-order').toggleClass('opened');
        }
        $('.back-link').click(function(){
            $('.screen').removeClass('opened');
        })
        $(function() {
            $('.resizable').resizable({
                handles: {
                    'n': '.screen-rollover'
                }
            });
            $('.navbar-open').click(function(){
                $('#menu-swipe').addClass('opened');
            })
            $('body').swipe( {
                swipeStatus:function(event, phase, direction, distance, duration, fingerCount, fingerData, currentDirection) {
                    if (phase == "start") {
                        // сработает в начале swipe
                    }
                    if (phase == "end") {
                        //сработает через 20 пикселей то число которое выбрали в threshold
                        if (direction == 'left') {
                            jQuery('#menu-swipe').removeClass('opened');
                        }
                        if (direction == 'right') {
                            jQuery('#menu-swipe').addClass('opened');
                        }
                        if (direction == 'up') {
                            //сработает при движении вверх
                        }
                        if (direction == 'down') {
                            //сработает при движении вниз
                        }
                    }
                },
                triggerOnTouchEnd:true,
                threshold:30 // сработает через 20 пикселей
            });

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
                        resolve(data) // Resolve promise and go to then()
                    },
                    error: function (err) {
                        reject(err) // Reject the promise and go to catch()
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
                        resolve(data) // Resolve promise and go to then()
                        window.location.href = '{{Request::url()}}/orders/' + data;
                    },
                    error: function (err) {
                        reject(err) // Reject the promise and go to catch()
                    }
                })
            })
        }
    </script>
@endsection
