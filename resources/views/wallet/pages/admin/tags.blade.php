
@extends('wallet.layouts.app')

@section('content')
    <style>
        .currencies .nav-item {
            padding:15px 25px;
            font-size:18px;
            background:#f9f9f9;
            border-radius: 15px;
            margin:0 0 15px;
        }
        .currencies .nav-item a {
            padding:0;
            color:#1a202c;
        }
    </style>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card main-screen">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="inline-block mb-0">Теги</p>
                            <div class="d-flex justify-content-end">
                                <a class="btn btn-primary" href="/wallet/" >Вернуться назад</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h2>Список тегов</h2>
                        <a class="btn btn-success action">Добавить новый тег</a>
                        <ul class="nav flex-column currencies tags">
                            @foreach ($tags as $tag)
                                <li class="nav-item d-flex justify-content-between align-items-center">
                                    <p>{{$tag->name}}</p>
                                    <a class="icon-remove remove-tag">
                                        <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="25" cy="25" r="25" fill="#DF5060"></circle>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M34 18H30V17C30 15.3 28.7 14 27 14H23C21.3 14 20 15.3 20 17V18H16C15.4 18 15 18.4 15 19C15 19.6 15.4 20 16 20H17V33C17 34.7 18.3 36 20 36H30C31.7 36 33 34.7 33 33V20H34C34.6 20 35 19.6 35 19C35 18.4 34.6 18 34 18ZM22 17C22 16.4 22.4 16 23 16H27C27.6 16 28 16.4 28 17V18H22V17ZM30 34C30.6 34 31 33.6 31 33V20H19V33C19 33.6 19.4 34 20 34H30ZM24 24V30C24 30.6 23.6 31 23 31C22.4 31 22 30.6 22 30V24C22 23.4 22.4 23 23 23C23.6 23 24 23.4 24 24ZM28 30V24C28 23.4 27.6 23 27 23C26.4 23 26 23.4 26 24V30C26 30.6 26.4 31 27 31C27.6 31 28 30.6 28 30Z" fill="black"></path>
                                            <mask id="mask0_850_736" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="15" y="14" width="20" height="22">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M34 18H30V17C30 15.3 28.7 14 27 14H23C21.3 14 20 15.3 20 17V18H16C15.4 18 15 18.4 15 19C15 19.6 15.4 20 16 20H17V33C17 34.7 18.3 36 20 36H30C31.7 36 33 34.7 33 33V20H34C34.6 20 35 19.6 35 19C35 18.4 34.6 18 34 18ZM22 17C22 16.4 22.4 16 23 16H27C27.6 16 28 16.4 28 17V18H22V17ZM30 34C30.6 34 31 33.6 31 33V20H19V33C19 33.6 19.4 34 20 34H30ZM24 24V30C24 30.6 23.6 31 23 31C22.4 31 22 30.6 22 30V24C22 23.4 22.4 23 23 23C23.6 23 24 23.4 24 24ZM28 30V24C28 23.4 27.6 23 27 23C26.4 23 26 23.4 26 24V30C26 30.6 26.4 31 27 31C27.6 31 28 30.6 28 30Z" fill="white"></path>
                                            </mask>
                                            <g mask="url(#mask0_850_736)">
                                                <rect x="13" y="13" width="24" height="24" fill="white"></rect>
                                            </g>
                                        </svg>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('.action').bind('click', function(e) {

                e.preventDefault();
                let title = prompt("Введите название тега");
                if (title != null) {
                    $.post( "/api/tags/add", {
                        "_token": "{{ csrf_token() }}",
                        "title": title,
                    })
                    .done(function( data ) {
                        alert('Тег успешно добавлен')
                        window.location.href = '{{Request::url()}}';
                    });
                }
            })

            $('.remove-tag').bind('click', function(e) {
                if (confirm("Удалить выбранный тег?") == true) {
                    $.post("/api/tags/remove", {
                        "_token": "{{ csrf_token() }}",
                        "title": $(this).parent().find('p').text(),
                    })
                    .done(function (data) {
                        alert('Выбранный тег успешно удален')
                        window.location.href = '{{Request::url()}}';
                    });
                }
            })


        })
    </script>
@endsection
