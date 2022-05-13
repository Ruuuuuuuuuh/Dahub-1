@extends('wallet.layouts.app')
@section('content')
    <section class="screen opened order-page" data-status="{{$order->status}}">
        @if ($order->destination == 'TokenSale')
            @include('wallet.components.gate.order.deposit.'.$order->status)
        @else
            @include('wallet.components.gate.order.'.$order->destination.'.'.$order->status)
        @endif
    </section>
    @if ($order->status == 'created')
        @include('wallet.components.gate.accept_form')
    @endif
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"
            type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.19/jquery.touchSwipe.min.js"
            type="text/javascript"></script>


    <script>

        function confirmOrder() {
            let _token = "{{ csrf_token() }}";
            let id = {{$order->id}}
            $.ajax({
                url: "/api/orders/confirmOrderByGate",
                type: "POST",
                data: {
                    _token: _token,
                    id: id,
                },
                success: function (response) {
                    window.location.href = "{{Request::url()}}"
                },
            });
        }

        function acceptOrder() {
            let _token = "{{ csrf_token() }}";
            let id = {{$order->id}}
            $.ajax({
                url: "/api/orders/acceptOrderByGate",
                type: "POST",
                data: {
                    _token: _token,
                    id: id,
                },
                success: function (response) {
                    window.location.href = '/wallet/orders/' + id;
                },
            });
        }


        function openAcceptForm() {
            $('#accept-order').addClass('opened');
        }


        $('#accept-order .payment-items').on('click', '.payment-item', function (e) {
            $('.payment-item').removeClass('active-accept-order')
            $(this).addClass('active-accept-order')
            $('.order-accept').removeClass('disabled').attr('data-address', $(this).attr('data-address'))
        })

        // $('#payment-details-list .payment-items').on('click', '.payment-item', function() {
        //     $('.payment-item').removeClass('active')
        //     $(this).addClass('active')
        //     let address = $(this).find('.address').text();
        //     $('#payment-details-list').removeClass('opened')
        //     $('.input-address').val(address)
        // })

        // $('.add-payment_item').click(function() {
        //     $('.payment-details-form').find('input[name="title"]').val('')
        //     $('.payment-details-form').find('input[name="address"]').val('')
        //     $('#add-payment-details').modal()
        //     $('input[name="payment"]').val($('#accept-order').data('payment'))
        // })


        $('.order-accept').click(function (e) {
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
                            window.location.href = '/wallet/orders/' + data;
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
                type: "POST",
                data: {
                    _token: _token,
                    id: id,
                },
                success: function (response) {
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
                    type: "POST",
                    data: {
                        _token: _token,
                        id: id,
                    },
                    success: function (response) {
                        window.location.href = "{{Route('wallet')}}"
                    },
                });
            }
        }

    </script>
@endsection
