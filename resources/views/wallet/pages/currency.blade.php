
@extends('wallet.layouts.app')

@section('content')
    <style>
        .payments .nav-item {
            padding:15px 25px;
            font-size:18px;
            background:#f9f9f9;
            border-radius: 15px;
            margin:0 0 15px;
        }
        .payments .nav-item a {
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
                            <p class="inline-block mb-0">{{$currency->title}} – редактирование валюты</p>
                            <div class="d-flex justify-content-end">
                                <a class="btn btn-primary" href="{{Route('wallet.currencies')}}" >Вернуться назад</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" data-crypto="{{$currency->crypto}}">
                        <h2 style="margin-bottom: 30px;">Редактирование валюты</h2>
                        <form action="{{url()->current()}}" method="POST">
                            <div class="form-group">
                                <label for="title">Название</label>
                                <input class="form-control" name="title" value="{{$currency->title}}">
                            </div>
                            <div class="form-group">
                                <label for="title">Включить (Да / Нет)</label>
                                <input name="visible" type="checkbox" class="form-control" style="width: 20px;display: inline-block;vertical-align: middle;margin-left: 15px;" @if($currency->visible) checked @endif>
                            </div>
                            <div class="form-group">
                                <label for="subtitle">Описание</label>
                                <input class="form-control" name="subtitle" value="{{$currency->subtitle}}">
                            </div>
                            <div class="form-group">
                                <label for="decimal_places">Количество знаков после нуля</label>
                                <input class="form-control" name="decimal_places" value="{{$currency->decimal_places}}">
                            </div>
                            <div class="form-group">
                                <label for="icon">Иконка (svg)</label>
                                <textarea class="form-control" id="icon-textarea" name="icon" rows="3">
                                    {{$currency->icon}}
                                </textarea>
                            </div>
                            <div class="form-group">
                                <a class="btn btn-success update-currency">Сохранить изменения</a>
                            </div>
                        </form>
                        <h2 style="margin-top:60px;margin-bottom: 30px;">Список платежных систем</h2>
                        <ul class="nav flex-column payments">
                            @foreach ($currency->payments as $payment)
                                <li class="nav-item d-flex justify-content-between align-items-center">
                                    <p>{{$payment->title}}</p>
                                    <a class="detach-payment">
                                        <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="25" cy="25" r="25" fill="#DF5060"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M34 18H30V17C30 15.3 28.7 14 27 14H23C21.3 14 20 15.3 20 17V18H16C15.4 18 15 18.4 15 19C15 19.6 15.4 20 16 20H17V33C17 34.7 18.3 36 20 36H30C31.7 36 33 34.7 33 33V20H34C34.6 20 35 19.6 35 19C35 18.4 34.6 18 34 18ZM22 17C22 16.4 22.4 16 23 16H27C27.6 16 28 16.4 28 17V18H22V17ZM30 34C30.6 34 31 33.6 31 33V20H19V33C19 33.6 19.4 34 20 34H30ZM24 24V30C24 30.6 23.6 31 23 31C22.4 31 22 30.6 22 30V24C22 23.4 22.4 23 23 23C23.6 23 24 23.4 24 24ZM28 30V24C28 23.4 27.6 23 27 23C26.4 23 26 23.4 26 24V30C26 30.6 26.4 31 27 31C27.6 31 28 30.6 28 30Z" fill="black"/>
                                            <mask id="mask0_850_736" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="15" y="14" width="20" height="22">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M34 18H30V17C30 15.3 28.7 14 27 14H23C21.3 14 20 15.3 20 17V18H16C15.4 18 15 18.4 15 19C15 19.6 15.4 20 16 20H17V33C17 34.7 18.3 36 20 36H30C31.7 36 33 34.7 33 33V20H34C34.6 20 35 19.6 35 19C35 18.4 34.6 18 34 18ZM22 17C22 16.4 22.4 16 23 16H27C27.6 16 28 16.4 28 17V18H22V17ZM30 34C30.6 34 31 33.6 31 33V20H19V33C19 33.6 19.4 34 20 34H30ZM24 24V30C24 30.6 23.6 31 23 31C22.4 31 22 30.6 22 30V24C22 23.4 22.4 23 23 23C23.6 23 24 23.4 24 24ZM28 30V24C28 23.4 27.6 23 27 23C26.4 23 26 23.4 26 24V30C26 30.6 26.4 31 27 31C27.6 31 28 30.6 28 30Z" fill="white"/>
                                            </mask>
                                            <g mask="url(#mask0_850_736)">
                                                <rect x="13" y="13" width="24" height="24" fill="white"/>
                                            </g>
                                        </svg>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <a class="btn btn-success action">Присоединить платежную систему / сеть</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="attachPayment">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Выберите платежную сеть</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <select class="form-control">
                        @foreach (\App\Models\Payment::where('crypto', $currency->crypto)->get() as $payment)
                        <option value="{{$payment->title}}">{{$payment->title}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Добавить</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
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
                $('#attachPayment').modal();
            });
            $('#attachPayment button.btn-primary').bind('click', function(e) {
                $.post( "/api/attach_payment_to_currency", {
                    "_token": "{{ csrf_token() }}",
                    "currency": "{{ $currency->title }}",
                    "payment": $('#attachPayment option:selected').val(),
                })
                .done(function( data ) {
                    alert('Платежная система / сеть успешно добавлена')
                    window.location.href = '{{Request::url()}}';
                });
            })
            $('.detach-payment').bind('click', function(e) {
                if (confirm("Отсоединить платежную сеть?") == true) {
                    $.post("/api/detach_payment_from_currency", {
                        "_token": "{{ csrf_token() }}",
                        "currency": "{{ $currency->title }}",
                        "payment": $(this).parent().find('p').text(),
                    })
                    .done(function (data) {
                        alert('Платежная система / сеть успешно отсоединена')
                        window.location.href = '{{Request::url()}}';
                    });
                }
            })

            $('.update-currency').bind('click', function(e) {
                $.post( "{{url()->current()}}", {
                    "_token": "{{ csrf_token() }}",
                    "title": $('input[name="title"]').val(),
                    "subtitle": $('input[name="subtitle"]').val(),
                    "visible": $('input[name="visible"]').is(':checked') ? 1 : 0,
                    "decimal_places": $('input[name="decimal_places"]').val(),
                    "icon": $('textarea[name="icon"]').val(),
                })
                    .done(function( data ) {
                        alert('Изменения сохранены')
                        window.location.href = '{{Request::url()}}';
                    });
            })


        })
    </script>
@endsection
