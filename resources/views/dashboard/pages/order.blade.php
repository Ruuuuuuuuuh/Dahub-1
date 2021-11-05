@extends('dashboard.layouts.app')
@section('content')
    <section class="screen opened order-page" data-status="{{$order->status}}">
        @include('dashboard.components.order.'.$order->destination.'.'.$order->status)
    </section>
@endsection

@section('scripts')

    <script>
        function declineOrder() {
            let _token = "{{ csrf_token() }}";
            let id = {{$order->id}}
            $.ajax({
                url: "/api/orders/declineOrder",
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
    </script>
@endsection
