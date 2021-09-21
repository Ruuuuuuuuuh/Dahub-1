<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" id="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="icon" href="favicon.ico">
    <title></title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ mix('css/dashboard.css') }}">

    <script>
        window.user = {!! Auth::User()->toJson(JSON_PRETTY_PRINT) !!}
    </script>
    <script
        src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
</head>

<body>
<div class="app">

    @include('dashboard.components.menu')
    <section class="screen opened">
        <div class="section-header">
            <div class="top-nav">

                @if ($order->status != 'completed')
                <h2>Заявка в обработке</h2>
                <svg class="status" width="64" height="62" viewBox="0 0 64 62" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M32 60C48.5685 60 62 46.5685 62 30C62 13.4315 48.5685 0 32 0C15.4315 0 2 13.4315 2 30C2 46.5685 15.4315 60 32 60Z" fill="#FFA500" stroke="white" stroke-width="4"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M37.1838 12.0705C36.2845 11.8042 35.3391 12.3152 35.0693 13.2135L30.6345 28.7582L21.8677 36.4277C21.159 37.055 21.0876 38.1359 21.7077 38.8509C22.3349 39.5596 23.4158 39.6309 24.1308 39.0109L33.2748 31.0099C33.5229 30.7917 33.7017 30.5057 33.7891 30.187L38.3611 14.1851C38.4877 13.7485 38.4345 13.2794 38.2134 12.8823C37.9923 12.4851 37.6216 12.1929 37.1838 12.0705Z" fill="white"/>
                </svg>
                @elseif ($order->status == 'completed')
                <h2>Заявка выполнена</h2>
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
            <div class="text-block">
                <p><small>Статус:</small></p>
                <p style="color:#347AF0">Заявка в обработке.<br />
                    Ожидание подтверждения шлюза...</p>
            </div>
            <div class="footer" style="margin-top:60px;">
                <a class="button button-red" onclick="declineOrder()">Отменить заявку</a>
            </div>
        </div>
    </section>
</div>

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
        $('.navbar-open').click(function () {
            $('#menu-swipe').addClass('opened');
        })
        $('body').swipe({
            swipeStatus: function (event, phase, direction, distance, duration, fingerCount, fingerData, currentDirection) {
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
            triggerOnTouchEnd: true,
            threshold: 30 // сработает через 20 пикселей
        });
    })
    function declineOrder() {
        let _token = "{{ csrf_token() }}";
        let id = {{$order->id}}
        $.ajax({
            url: "/api/orders/declineOrder",
            type:"POST",
            data:{
                _token: _token,
            },
            success:function(response){
                window.location.href = "{{Route('main')}}"
            },
        });
    }

</script>
</body>

</html>

