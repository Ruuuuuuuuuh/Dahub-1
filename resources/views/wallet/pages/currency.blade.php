
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
                        <h2>Список платежных систем</h2>
                        <ul class="nav flex-column payments">
                            @foreach ($currency->payments as $payment)
                                <li class="nav-item d-flex justify-content-between align-items-center">
                                    <a href="{{Route('wallet.currencies')}}/{{$payment->title}}">{{$payment->title}}</a>
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


        })
    </script>
@endsection
