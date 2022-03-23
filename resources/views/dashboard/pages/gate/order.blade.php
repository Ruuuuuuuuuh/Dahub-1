@extends('dashboard.layouts.app')
@section('content')
    <section class="screen opened order-page" data-status="{{$order->status}}">
        @if ($order->destination == 'TokenSale')
            @include('dashboard.components.gate.order.deposit.'.$order->status)
        @else
            @include('dashboard.components.gate.order.'.$order->destination.'.'.$order->status)
        @endif
    </section>
    @if ($order->status == 'created')
        @include('dashboard.components.gate.accept_form')
    @endif
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.19/jquery.touchSwipe.min.js" type="text/javascript"></script>


    <script>

        function confirmOrder() {
            let _token = "{{ csrf_token() }}";
            let id = {{$order->id}}
            $.ajax({
                url: "/api/orders/confirmOrderByGate",
                type:"POST",
                data:{
                    _token: _token,
                    id: id,
                },
                success:function(response) {
                    window.location.href = "{{Request::url()}}"
                },
            });
        }

        function acceptOrder() {
            let _token = "{{ csrf_token() }}";
            let id = {{$order->id}}
            $.ajax({
                url: "/api/orders/acceptOrderByGate",
                type:"POST",
                data:{
                    _token: _token,
                    id: id,
                },
                success:function(response) {
                    window.location.href = '/dashboard/orders/' + id;
                },
            });
        }



        function openAcceptForm() {
            $('#accept-order').addClass('opened');
        }

        $('.payment-details-form .confirm-modal').click(function(e){
            e.preventDefault()
            if (!$(this).hasClass('disabled')) {
                return new Promise(function (resolve, reject) {
                    let form = $('.payment-details-form');
                    let data = {
                        "_token": "{{ csrf_token() }}",
                        "address": form.find('input[name="address"]').val(),
                        "payment": form.find('input[name="payment"]').val(),
                    }
                    $.ajax({
                        url: "/api/payment_details/add",
                        type: "POST",
                        data: data,
                        success: function (data) {
                            resolve(data)
                            console.log(data)
                            $('.payment-items').append('<a class="payment-item d-flex align-items-center justify-content-start" data-address="' + data[0].address + '" data-id="' + data[0].id + '" data-payment="' + data[0].payment + '">' +
                                '<svg class="payment-details-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">' +
                                '<circle cx="10" cy="10" r="10" fill="#EDF1F9"/>' +
                                '<circle class="payment-item-icon-inner" cx="10" cy="10" r="6" fill="#EDF1F9"/>' +
                                '</svg>' +
                                '<div class="payment-details">' +
                                '<span class="address">' + data[0].address + '</span>' +
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

        //Swipe по реквизитам

        $('.payment-item').swipe({
            swipeStatus: function(event, phase, direction, distance, duration, fingerCount, fingerData,
                currentDirection) {
                if (phase == "start") {
                    // сработает в начале swipe
                }
                if (phase == "end") {
                    //сработает через 20 пикселей то число которое выбрали в threshold
                    if (direction == 'left') {
                        $('.payment-item_content').removeClass('swipe')
                        $(this).find('.payment-item_content').addClass('swipe')
                    }
                    if (direction == 'right') {
                        $(this).find('.payment-item_content').removeClass('swipe')
                    }
                    if (direction == 'up') {
                        //сработает при движении вверх
                    }
                    if (direction == 'down') {
                        //сработает при движении вниз
                    }
                }
            },
            triggerOnTouchEnd: true,
            threshold: 30,
        });
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

        $('.add-payment_item').click(function() {
            $('#add-payment-details').modal()
            $('input[name="payment"]').val($('#accept-order').data('payment'))
        })

        $('.payment-details-form input').on('change keyup', function() {
            let filledtextboxes = 1;
            if ($('.payment-details-form input[name="address"]').val().length == 0) filledtextboxes = 0;
            // if ($('.payment-details-form').closest('#add-payment-details').hasClass('crypto') && $('.payment-details-form input[name="address"]').val().length != 0) filledtextboxes = 1
            if (filledtextboxes != 0) $('.payment-details-form .confirm-modal').removeClass('disabled')
            else $('.payment-details-form .confirm-modal').addClass('disabled')
        })

        $('.order-accept').click(function(e) {
            e.preventDefault()
            if (!$(this).hasClass('disabled')) {
                let data = {
                    "_token": "{{ csrf_token() }}",
                    "id": {{$order->id}},
                    "payment_details": $(this).data('address'),
                }
                return new Promise(function (resolve, reject) {
                    $.ajax({
                        url: "/api/orders/acceptOrderByGate",
                        type: "POST",
                        data: data,
                        success: function (data) {
                            resolve(data)
                            window.location.href = '/dashboard/orders/' + data;
                        },
                        error: function (err) {
                            reject(err)
                        }
                    })
                })
            }
        })

        function acceptSending() {
            let _token = "{{ csrf_token() }}";
            let id = {{$order->id}}
            $.ajax({
                url: "/api/orders/acceptSendingByGate",
                type:"POST",
                data:{
                    _token: _token,
                    id: id,
                },
                success:function(response) {
                    window.location.href = "{{Request::url()}}"
                },
            });
        }

        function declineOrder() {
            if (confirm('Вы собираетесь отменить заявку, вы уверены?')) {
                let _token = "{{ csrf_token() }}";
                let id = {{$order->id}}
                $.ajax({
                    url: "/api/orders/declineOrderByGate",
                    type:"POST",
                    data:{
                        _token: _token,
                        id: id,
                    },
                    success:function(response){
                        window.location.href = "{{Route('dashboard')}}"
                    },
                });
            }
        }

    </script>
@endsection
