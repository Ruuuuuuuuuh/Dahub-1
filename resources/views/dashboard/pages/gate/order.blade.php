@extends('dashboard.layouts.app')
@section('content')
    <section class="screen opened order-page" data-status="{{$order->status}}">
        <div class="section-header">
            <div class="top-nav">
                <a href="{{ Route('main') }}" class="back-link">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M15.7071 17.2929C16.0976 17.6834 16.0976 18.3166 15.7071 18.7071C15.3166 19.0976 14.6834 19.0976 14.2929 18.7071L8.29289 12.7071C7.90237 12.3166 7.90237 11.6834 8.29289 11.2929L14.2929 5.29289C14.6834 4.90237 15.3166 4.90237 15.7071 5.29289C16.0976 5.68342 16.0976 6.31658 15.7071 6.70711L10.4142 12L15.7071 17.2929Z" fill="#0D1F3C"></path>
                        <mask id="back-link" mask-type="alpha" maskUnits="userSpaceOnUse" x="8" y="5" width="8" height="14">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M15.7071 17.2929C16.0976 17.6834 16.0976 18.3166 15.7071 18.7071C15.3166 19.0976 14.6834 19.0976 14.2929 18.7071L8.29289 12.7071C7.90237 12.3166 7.90237 11.6834 8.29289 11.2929L14.2929 5.29289C14.6834 4.90237 15.3166 4.90237 15.7071 5.29289C16.0976 5.68342 16.0976 6.31658 15.7071 6.70711L10.4142 12L15.7071 17.2929Z" fill="white"></path>
                        </mask>
                        <g mask="url(#back-link)">
                            <rect width="24" height="24" fill="#0D1F3C"></rect>
                        </g>
                    </svg>
                </a>
                @if ($order->status != 'completed')
                    <h2>Заявка в обработке</h2>
                    <svg class="status" width="64" height="62" viewBox="0 0 64 62" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M32 60C48.5685 60 62 46.5685 62 30C62 13.4315 48.5685 0 32 0C15.4315 0 2 13.4315 2 30C2 46.5685 15.4315 60 32 60Z" fill="#FFA500" stroke="white" stroke-width="4"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M37.1838 12.0705C36.2845 11.8042 35.3391 12.3152 35.0693 13.2135L30.6345 28.7582L21.8677 36.4277C21.159 37.055 21.0876 38.1359 21.7077 38.8509C22.3349 39.5596 23.4158 39.6309 24.1308 39.0109L33.2748 31.0099C33.5229 30.7917 33.7017 30.5057 33.7891 30.187L38.3611 14.1851C38.4877 13.7485 38.4345 13.2794 38.2134 12.8823C37.9923 12.4851 37.6216 12.1929 37.1838 12.0705Z" fill="white"/>
                    </svg>
                @elseif ($order->status == 'completed')
                    <h2>Заявка выполнена</h2>
                    <svg class="status" width="64" height="65" viewBox="0 0 64 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M32 63C48.5685 63 62 49.5685 62 33C62 16.4315 48.5685 3 32 3C15.4315 3 2 16.4315 2 33C2 49.5685 15.4315 63 32 63Z" fill="#75BF72" stroke="white" stroke-width="4"/>
                        <path d="M46.3625 25.1542L27.5708 43.9458C27.2292 44.2875 26.8875 44.4583 26.375 44.4583C25.8625 44.4583 25.5208 44.2875 25.1792 43.9458L16.6375 35.4042C15.9542 34.7208 15.9542 33.6958 16.6375 33.0125C17.3208 32.3292 18.3458 32.3292 19.0292 33.0125L26.375 40.3583L43.9708 22.7625C44.6542 22.0792 45.6792 22.0792 46.3625 22.7625C47.0458 23.4458 47.0458 24.4708 46.3625 25.1542Z" fill="white"/>
                        <mask id="mask0_525:4523" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="16" y="22" width="31" height="23">
                            <path d="M46.3625 25.1542L27.5708 43.9458C27.2292 44.2875 26.8875 44.4583 26.375 44.4583C25.8625 44.4583 25.5208 44.2875 25.1792 43.9458L16.6375 35.4042C15.9542 34.7208 15.9542 33.6958 16.6375 33.0125C17.3208 32.3292 18.3458 32.3292 19.0292 33.0125L26.375 40.3583L43.9708 22.7625C44.6542 22.0792 45.6792 22.0792 46.3625 22.7625C47.0458 23.4458 47.0458 24.4708 46.3625 25.1542Z" fill="white"/>
                        </mask>
                        <g mask="url(#mask0_525:4523)">
                        </g>
                    </svg>
                @endif
            </div>
        </div>
        <div class="section-main">
            <div class="text-block">
                <p><small>Заявка #</small></p>
                <p>{{$order->id}}</p>
            </div>
            <div class="text-block">
                <p><small>На пополнение</small></p>
                <p>{{$order->amount}} {{$order->currency}}</p>
            </div>
            <div class="text-block">
                <p><small>Оставшееся время:</small></p>
                <p>4:59 минут</p>
            </div>
            @if ($order->status != 'completed')
            <div class="text-block">
                <p><small>Статус:</small></p>
                <p style="color:#347AF0">Ожидание перевода</p>
            </div>
            <div class="footer">
                <a class="button button-blue" onclick="confirmOrder()">Подтвердить получение</a>
            </div>
            @else
            <div class="text-block">
                <p><small>Статус:</small></p>
                <p style="color:#347AF0">Выполнена. Получение подтверждено</p>
            </div>
            @endif
        </div>
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

    </script>
@endsection
