@extends('dashboard.layouts.app')
@section('content')
    <section class="screen opened order-page" data-status="{{$order->status}}">
        @include('dashboard.components.gate.order.'.$order->destination.'.'.$order->status)
    </section>
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
                    window.location.href = "{{Request::url()}}"
                },
            });
        }

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
                    window.location.href = "{{Route('main')}}"
                },
            });
        }

    </script>
@endsection
