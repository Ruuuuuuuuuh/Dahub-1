@extends('dashboard.layouts.app')
@section('content')
    <section class="screen opened order-page" data-status="{{$order->status}}">
        @if ($order->destination != 'TokenSale')
        @include('dashboard.components.order.'.$order->destination.'.'.$order->status)
        @else
            @include('dashboard.components.order.deposit.'.$order->status)
        @endif
    </section>
@endsection

@section('scripts')

    <script>
        function declineOrder() {
            if (confirm('Вы собираетесь отменить заявку, вы уверены?')) {
                let _token = "{{ csrf_token() }}";
                let id = {{$order->id}}
                $.ajax({
                    url: "/api/orders/declineOrder",
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

        function acceptOrder() {
            let _token = "{{ csrf_token() }}";
            let id = {{$order->id}}
            $.ajax({
                url: "/api/orders/confirmOrderByUser",
                type:"POST",
                data:{
                    _token: _token,
                    id: id,
                },
                success:function(response){
                    window.location.href = "{{Request::url()}}"
                },
            });
        }

        function acceptSending(id) {
            let _token = '{{@csrf_token()}}';
            let comment = prompt('Чтобы подтвердить отправление средств, ведите последние 4 цифры номера карты или счета, с которого были отправлены средства')
            if (comment) {
                $.ajax({
                    url: "/api/orders/acceptSendingByUser",
                    type:"POST",
                    data:{
                        _token: _token,
                        id: id,
                        comment: comment
                    },
                    error: function () {
                        alert('При попытке подтвердить заявку произошла ошибка')
                    },
                    success:function(response){
                        alert('Вы успешно подтвердили отправку средств')
                        window.location.href = '/wallet/orders/' + id
                    },
                });
            }
        }
    </script>
@endsection
