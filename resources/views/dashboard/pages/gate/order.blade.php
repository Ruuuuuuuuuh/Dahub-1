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
                        "title": form.find('input[name="title"]').val(),
                    }
                    $.ajax({
                        url: "/api/payment_details/add",
                        type: "POST",
                        data: data,
                        success: function (data) {
                            resolve(data)
                            console.log(data)
                            $('.payment-items').append(`
                            <a class="payment-item d-flex align-items-center justify-content-between" data-address="${data[0].address}" data-id="${data[0].id}" data-payment="${data[0].payment}">
                                <svg class="payment-details-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="10" cy="10" r="10" fill="#EDF1F9"/>
                                    <circle class="payment-item-icon-inner" cx="10" cy="10" r="6" fill="#EDF1F9"/>
                                </svg>
                                <div class="payment-details">
                                    <div class="name">${data[0].title ? data[0].title : '<span class="text-danger"> Имя кошелька не задано</span>'}</div>
                                    <span class="address">${data[0].address}</span>
                                </div>
                                <div class="action-btn">
                                    <button type="button" class="icon icon-edit edit-payment_item" data-address="${data[0].address}" data-id="${data[0].id}" data-title="${data[0].title}">
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
                                    <button type="button" class="icon icon-delete delete-payment_item" data-id="${data[0].id}">
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

                            </a>`);
                            $('#add-payment-details').modal('hide')
                        },
                        error: function (err) {
                            reject(err)
                        }
                    })
                })
            }
        })

        $('#accept-order .payment-items').on('click', '.payment-item', function(e) {
            $('.payment-item').removeClass('active')
            $(this).addClass('active')
            $('.order-accept').removeClass('disabled').attr('data-address', $(this).attr('data-address'))
        })

        $('#payment-details-list .payment-items').on('click', '.payment-item', function() {
            $('.payment-item').removeClass('active')
            $(this).addClass('active')
            let address = $(this).find('.address').text();
            $('#payment-details-list').removeClass('opened')
            $('.input-address').val(address)
        })

        $('.add-payment_item').click(function() {
            $('.payment-details-form').find('input[name="title"]').val('')
            $('.payment-details-form').find('input[name="address"]').val('')
            $('#add-payment-details').modal()
            $('input[name="payment"]').val($('#accept-order').data('payment'))
        })




        //Отправка формы редактирование реквизитов
        $('.edit-payment-details-form .confirm-modal').click(function(e){
            e.preventDefault()
                return new Promise(function (resolve, reject) {
                    let form = $('.edit-payment-details-form');
                    let data = {
                        "_token": "{{ csrf_token() }}",
                        "address": form.find('input[name="address"]').val(),
                        "title": form.find('input[name="title"]').val(),
                        "id": parseInt(form.find('input[name="id"]').val())
                    }
                    $.ajax({
                        url: "/api/payment_details/edit",
                        type: "POST",
                        data: data,
                        success: function (data) {
                            resolve(data)
                            $("[data-id='" + data.id + "'] .name").html(data.title ? data.title : '<span class="text-danger"> Имя кошелька не задано</span>')
                            $("[data-id='" + data.id + "'] .address").html(data.address)

                            $(".payment-item[data-id='" + data.id + "']").attr('data-title', data.title)
                            $(".payment-item[data-id='" + data.id + "']").attr('data-address', data.address)

                            if($(".payment-item[data-id='" + data.id + "']").hasClass('active') ) {
                                $('.order-accept').attr('data-address', data.address)
                            }
                            $('#edit-payment-details').modal('hide')
                        },
                        error: function (err) {
                            reject(err)
                            alert('Ошибка, повторите позже или напишите в поддержку')
                        }
                    })
                })
        })
        //Вызов модалки для редактирование реквизитов
        $('.payment-items').delegate('.edit-payment_item', 'click', function() {
            let id = $(this).data('id')
            // let title = $(this).data('title')
            // let address = $(this).data('address')
            let $modal = $('#edit-payment-details')
            $modal.find('input[name="address"]').val('')
            $modal.find('input[name="title"]').val('')
            $modal.find('input[name="id"]').val(id)
            $modal.modal()
        })
        //Удаление реквизитов
        $('.payment-items').delegate('.delete-payment_item', 'click', function() {
            let confirmation = confirm("Точно удалить?")
            let id = $(this).data('id')
            if(confirmation) {
                return new Promise(function (resolve, reject) {
                    let form = $('.edit-payment-details-form');
                    let data = {
                        "_token": "{{ csrf_token() }}",
                        "id": id,
                    }
                    $.ajax({
                        url: "/api/payment_details/remove",
                        type: "POST",
                        data: data,
                        success: function (data) {
                            resolve(data)
                            console.log(data)
                            $(".payment-item[data-id='" + data.id + "']").remove()
                            alert('Реквизиты c адресом «'+ data.address + '» удалены')
                            if($('.payment-items').html().trim()===''){
                                $('.order-accept').addClass('disabled')
                            }
                        },
                        error: function (err) {
                            reject(err)
                            alert('Ошибка, повторите позже или напишите в поддержку')
                        }
                    })
                })
            }
        })

        $('.edit-payment-details-form input').on('change keyup', function() {
            let filledtextboxes = 1;
            if ($('.edit-payment-details-form input[name="address"]').val().length == 0) filledtextboxes = 0;
            if (filledtextboxes != 0) $('.edit-payment-details-form .confirm-modal').removeClass('disabled')
            else $('.edit-payment-details-form .confirm-modal').addClass('disabled')
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
