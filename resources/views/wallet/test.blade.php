<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" id="viewport" content="user-scalable=no, initial-scale=1, width=device-width">
    <title>Da HUB - первая децентрализованная платформа</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ mix('css/wallet.css') }}">

    <link rel="apple-touch-icon" sizes="180x180" href="/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#9f00a7">
    <meta name="theme-color" content="#ffffff">

    <script>
        window.user = {!! Auth::User()->toJson(JSON_PRETTY_PRINT) !!}
        window.mode = "{{$mode}}"
        window.gate = {!! Auth::user()->isGate() !!}
        window.currency = {!! $user->getBalances() !!}
        window.visibleWallets = {!! json_encode($visibleWallets) !!}
        window.orders = {!! json_encode($orders) !!}
        window.payments = {!! \App\Models\Currency::with('payments')->get()->toJson(JSON_PRETTY_PRINT) !!}
        window.onload = function () {
            if (screen.width < 450) {
                let mvp = document.getElementById('viewport');
                mvp.setAttribute('content','user-scalable=no,width=450');
            }
        }
    </script>
</head>

<body>
<div  class="app" id="new-vue-app" data-mode="{{$mode}}" data-page="{{Route::current()->getName()}}">
<app/>
</div>
<script src="{{ asset('js/app.js') }}"></script>

<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(86626209, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
    });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/86626209" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</body>
</html>
