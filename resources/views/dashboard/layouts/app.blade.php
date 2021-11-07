<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" id="viewport" content="user-scalable=no, initial-scale=1, width=device-width">
    <title>Da HUB - первая децентрализованная платформа</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ mix('css/dashboard.css') }}">

    <link rel="apple-touch-icon" sizes="180x180" href="/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#9f00a7">
    <meta name="theme-color" content="#ffffff">

    <script>
        window.user = {!! Auth::User()->toJson(JSON_PRETTY_PRINT) !!}
        window.onload = function () {
            if (screen.width < 450) {
                let mvp = document.getElementById('viewport');
                mvp.setAttribute('content','user-scalable=no,width=450');
            }
        }
    </script>
    <script
        src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
    @yield('css')
</head>

<body>
<div class="app" data-mode="{{$mode}}" data-page="{{Route::current()->getName()}}">

    @include('dashboard.components.header')
    @include('dashboard.components.menu')
    @yield('content')

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.19/jquery.touchSwipe.min.js" type="text/javascript"></script>

<script>
    $(function() {
        let screenHeight = window.innerHeight
        $('.resizable').resizable({
            handles: {
                'n': '.screen-rollover'
            },
            stop: function(e, ui) {
                if (ui.element.height() > window.innerHeight / 1.5) {
                    ui.element.height(window.innerHeight - 75)
                    ui.element.css('top', 75)
                }
                if (ui.element.height() < window.innerHeight / 1.5 && ui.element.height() > window.innerHeight / 3) {
                    ui.element.height(window.innerHeight / 2)
                    ui.element.css('top', window.innerHeight / 2)
                }
                if (ui.element.height() < window.innerHeight / 3) {
                    ui.element.height(145)
                    ui.element.css('top', window.innerHeight - 145)
                }
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
        window.mode = $('.app').data('mode')
        if (window.mode == 'pro') $('.switch-pro').addClass('active')

        window.onload = function() {
            window.addEventListener('wheel', { passive: false })
        }

        $('.switch-pro').click(function() {
            $(this).toggleClass('active')
            return new Promise(function (resolve, reject) {
                $.ajax({
                    url: "/api/saveUserConfig",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "meta": 'mode',
                        "value": window.mode == 'lite' ? 'pro': 'lite'
                    },
                    success: function (data) {
                        resolve(data) // Resolve promise and go to then()
                        window.location.href = '{{Request::url()}}'
                    },
                    error: function (err) {
                        reject(err) // Reject the promise and go to catch()
                    }
                })
            })
        })
        $('[data-toggle="popover"]').popover()
        $('.copy-link').click(function(e){
            e.preventDefault()
            let l = $(this).find('span').html()
            let i = document.createElement('input')
            i.setAttribute('value', l)
            document.body.appendChild(i)
            i.select()
            let r = document.execCommand('copy')
            document.body.removeChild(i)
        })

        $('body').on('click', function (e) {
            //did not click a popover toggle or popover
            if ($(e.target).data('toggle') !== 'popover'
                && $(e.target).parents('.popover.in').length === 0
                && $(e.target).parent().data('toggle') !== 'popover') {
                $('[data-toggle="popover"]').popover('hide');
            }
        });
    })
</script>
@yield('scripts')
</body>

</html>
