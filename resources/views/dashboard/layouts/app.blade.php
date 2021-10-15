<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" id="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="icon" href="/img/favicon.ico">
    <title>Da HUB - первая децентрализованная платформа</title>
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
<div class="app" data-mode="{{$mode}}">

    @include('dashboard.components.header')
    @include('dashboard.components.menu')
    @yield('content')

</div>

@yield('scripts')
<script>
    $(function() {
        window.mode = $('.app').data('mode')
        if (window.mode == 'pro') $('.switch-pro').addClass('active')
    })
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
</script>
</body>

</html>
