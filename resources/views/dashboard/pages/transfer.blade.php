@extends('dashboard.layouts.app')

@section('content')
    <style>
        .payments .nav-item {
            padding: 15px 25px;
            font-size: 18px;
            background: #f9f9f9;
            border-radius: 15px;
            margin: 0 0 15px;
        }

        .payments .nav-item a {
            padding: 0;
            color: #1a202c;
        }

        .form-control, .add-all, .transfer-button {
            height: 42px;
            line-height: 42px;
            padding-top: 0;
            padding-bottom: 0;
        }

        a.add-all:hover {
            color: #fff !important;
        }

        a.add-all {
            cursor: pointer;
            text-decoration: none;
        }

        a.transfer-button {
            border-radius: 30px;
            padding: 0 35px;
        }

        .mb-5 {
            margin-bottom: 30px !important;
        }

        .badge {
            font-size: 14px;
            padding: 8px 20px;
            border-radius: 15px;
            cursor: pointer;
        }
    </style>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card main-screen">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="inline-block mb-0">Перевод средств</p>
                            <div class="d-flex justify-content-end">
                                <a class="btn btn-primary" href="{{Route('wallet')}}">Вернуться назад</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h2 style="margin-bottom: 30px;">Форма перевода DHB</h2>
                        <form action="" id="form-transfer">
                            @csrf
                            <div class="form-group input-group col-12 col-md-6 p-0 mb-5">
                                <label for="username">Введите id пользователя либо идентификатор фонда</label>
                                <input type="text" class="form-text form-control w-100" name="username"
                                       placeholder="Введите id пользователя либо идентификатор фонда">
                                <div class="d-flex mt-3">
                                    <span class="badge badge-success username-badge" data-username="DHBFundWallet">#DHBFundWallet</span>
                                </div>
                                <div class="invalid-feedback">Не верный идентификатор пользователя или фонда</div>
                            </div>
                            <label for="transfer-amount">Сколько DHB перевести. Доступно для
                                перевода: {{intval(Auth::user()->getWallet('DHB')->balanceFloat)}} DHB</label>
                            <div class="form-group input-group col-12 col-md-6 p-0 mb-5 w-100">
                                <div class="w-100 d-flex">
                                    <div class="col-7">
                                        <div class="row">
                                            <input type="number" class="form-number form-control w-100"
                                                   name="transfer-amount" placeholder="Сколько перевести">
                                            <div class="invalid-feedback">Введите количество DHB</div>
                                        </div>
                                    </div>
                                    <div class="col-5 pr-0">
                                        <a class="text-center d-flex w-100 align-items-center justify-content-center bg-danger text-light add-all"
                                           data-amount="{{intval(Auth::user()->getWallet('DHB')->balanceFloat)}}">Добавить
                                            все</a>
                                    </div>
                                </div>

                            </div>
                        </form>

                        <a class="btn btn-success transfer-button">Перевести средства</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('.add-all').click(function () {
                let amount = $(this).data('amount')
                $('input[name="transfer-amount"]').val(amount)
            })

            $('.username-badge').click(function () {
                let username = $(this).data('username')
                $('input[name="username"]').val(username)
            })

            $('#form-transfer .form-control').change(function () {
                $(this).removeClass('is-invalid')
            })

            $('.transfer-button').bind('click', function (e) {

                let amount = $('input[name="transfer-amount"]').val()
                let username = $('input[name="username"]').val()
                let error = []
                if (!amount) error.push('transfer-amount')
                if (!username) error.push('username')

                if (error.length == 0) {
                    return new Promise(function (resolve, reject) {
                        $.ajax({
                            url: "/api/transfer",
                            type: "POST",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "currency": 'DHB',
                                "amount": amount,
                                "username": username,
                            },
                            success: function (data) {
                                resolve(data)
                                alert('Успешно переведено!')
                                window.location.href = '{{Request::url()}}';
                            },
                            error: function (err) {
                                reject(err)
                            }
                        })
                    })
                } else {
                    error.forEach(function (item) {
                        $('input[name="' + item + '"]').addClass('is-invalid')
                    })
                }

            })
        })
    </script>
@endsection
