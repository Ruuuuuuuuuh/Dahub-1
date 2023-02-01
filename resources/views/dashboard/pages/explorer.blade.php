@extends('dashboard.layouts.app')
@section('css')
    <link rel="stylesheet" href="/css/bootstrap-tagsinput.css">
    <style>
        .label {
            display: inline;
            padding: .2em .6em .3em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25em;
        }

        .label-info {
            background-color: #5bc0de;
        }

        .bootstrap-tagsinput {
            width: 100%;
            height: 37px;
            padding-top: 5px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid explorer">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="inline-block mb-0">
                                <svg width="21" height="21" viewBox="0 0 21 21" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0)">
                                        <path d="M-4.58968e-07 10.5C-2.05389e-07 16.3012 4.69876 21 10.5 21C16.3012 21 21 16.3012 20.9999 10.5C20.9999 4.69881 16.3012 -7.1255e-07 10.5 -4.58968e-07C4.69871 -2.05387e-07 -7.1255e-07 4.69876 -4.58968e-07 10.5ZM7.34998 16.275L3.67496 12.6L7.34998 8.92498L7.34998 11.55L11.55 11.55L11.55 13.65L7.34998 13.65L7.34998 16.275ZM17.325 8.40001L13.65 12.075L13.65 9.45004L9.44999 9.45004L9.44999 7.35003L13.65 7.35003L13.65 4.72505L17.325 8.40001Z"
                                              fill="white"/>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0">
                                            <rect width="21" height="21" fill="white"
                                                  transform="translate(0 21) rotate(-90)"/>
                                        </clipPath>
                                    </defs>
                                </svg>
                                Последние транзакции
                            </p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="transactions actions">
                            <input type="text" class="transactions" placeholder="Номер транзакции или ID пользователя">
                            <svg width="23" height="23" viewBox="0 0 23 23" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.36682 19.4918C7.14792 18.7108 7.14794 17.4444 6.36687 16.6633L6.33654 16.633C5.55548 15.8519 4.28911 15.852 3.50807 16.6331L1.41412 18.7272C0.633114 19.5082 0.633135 20.7745 1.41417 21.5555L1.44434 21.5857C2.22537 22.3667 3.49166 22.3668 4.27272 21.5858L6.36682 19.4918Z"
                                      fill="url(#paint0_linear)"/>
                                <path d="M14.2402 5.39062C12.8227 5.39062 11.4324 6.58002 10.4797 7.67952C9.94236 8.29959 9.94381 9.21058 10.4771 9.83411C11.3741 10.883 12.7529 12.1289 14.2402 12.1289C15.6577 12.1289 17.0479 10.9395 18.0007 9.84001C18.538 9.21994 18.5365 8.30895 18.0033 7.68542C17.1062 6.63655 15.7275 5.39062 14.2402 5.39062ZM14.2402 10.7812C13.1255 10.7812 12.2187 9.87439 12.2187 8.75977C12.2187 7.64514 13.1255 6.73828 14.2402 6.73828C15.3548 6.73828 16.2617 7.64514 16.2617 8.75977C16.2617 9.87439 15.3548 10.7812 14.2402 10.7812Z"
                                      fill="url(#paint1_linear)"/>
                                <path d="M14.2402 8.08594C13.8684 8.08594 13.5664 8.38793 13.5664 8.75977C13.5664 9.1316 13.8684 9.43359 14.2402 9.43359C14.6121 9.43359 14.9141 9.1316 14.9141 8.75977C14.9141 8.38793 14.6121 8.08594 14.2402 8.08594Z"
                                      fill="url(#paint2_linear)"/>
                                <path d="M14.2402 0C9.41026 0 5.48047 3.92979 5.48047 8.75977C5.48047 10.2013 5.8317 11.5988 6.50325 12.8582C6.66061 13.1533 6.62083 13.52 6.38438 13.7565C6.10302 14.0379 6.10304 14.4941 6.38443 14.7755L8.22448 16.6156C8.50587 16.897 8.96209 16.897 9.24351 16.6156C9.48 16.3792 9.84669 16.3394 10.1418 16.4967C11.4012 17.1683 12.7987 17.5195 14.2402 17.5195C19.0702 17.5195 23 13.5897 23 8.75977C23 3.92979 19.0702 0 14.2402 0ZM20.2092 9.10528C20.1027 9.28356 17.5613 13.4766 14.2402 13.4766C10.9192 13.4766 8.37775 9.28356 8.27124 9.10528C8.14395 8.89252 8.14395 8.62701 8.27124 8.41425C8.37775 8.23597 10.9192 4.04297 14.2402 4.04297C17.5613 4.04297 20.1027 8.23597 20.2092 8.41425C20.3365 8.62701 20.3365 8.89252 20.2092 9.10528Z"
                                      fill="url(#paint3_linear)"/>
                                <defs>
                                    <linearGradient id="paint0_linear" x1="2.8355" y1="0.953346" x2="14.4232"
                                                    y2="5.69971" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#85F362"/>
                                        <stop offset="0.958837" stop-color="#02AAFF"/>
                                    </linearGradient>
                                    <linearGradient id="paint1_linear" x1="12.9957" y1="-6.96289" x2="25.168"
                                                    y2="-0.171759" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#85F362"/>
                                        <stop offset="0.958837" stop-color="#02AAFF"/>
                                    </linearGradient>
                                    <linearGradient id="paint2_linear" x1="14.0575" y1="5.61523" x2="16.0644"
                                                    y2="6.43728" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#85F362"/>
                                        <stop offset="0.958837" stop-color="#02AAFF"/>
                                    </linearGradient>
                                    <linearGradient id="paint3_linear" x1="11.8647" y1="-32.1191" x2="37.9548"
                                                    y2="-21.4325" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#85F362"/>
                                        <stop offset="0.958837" stop-color="#02AAFF"/>
                                    </linearGradient>
                                </defs>
                            </svg>
                        </div>
                        <div class="order-list-header">
                            <div class="order">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-lg-4">Хеш</div>
                                        <div class="col-lg-3">Время</div>
                                        <div class="col-lg-3">Отправлено</div>
                                        <div class="col-lg-2">Получено</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="orders-list explorer-list">
                            <div class="orders-list-wrapper">
                                @foreach ($transactions as $transaction)
                                    <div class="order">
                                        <div class="col-12 order-wrapper">
                                            <div class="row justify-content-between align-items-center">
                                                <div class="hash">
                                                    <div class="row justify-content-center">
                                                        <a>{{ $transaction['uuid'] }}</a>
                                                    </div>
                                                </div>
                                                <div class="date">
                                                    {{ $transaction['date'] }}
                                                </div>
                                                <div class="amount-source">
                                                    <strong>{!! $transaction['amount'] . '&nbsp;' . $transaction['currency'] !!}</strong>
                                                </div>
                                                <div class="amount">
                                                    <strong>{{ $transaction['amount_dhb'] }}&nbsp;DHB</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="text-center w-100">
                                <a style="margin:30px 0;" onclick="infinteLoadMore()"
                                   class="button button-blue loadmore">Загрузить еще</a>
                                <div class="alert"></div>
                            </div>
                        </div>
                        <div class="search-items">
                            <p>По вашему запросу ничего не найдено</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    <script>
        var ENDPOINT = "{{ url('/') }}";
        var page = 1;
        let _token = $('meta[name="csrf-token"]').attr('content');

        function infinteLoadMore() {
            page++;
            $.ajax({
                url: ENDPOINT + "/dashboard/explorer?page=" + page,
                datatype: "html",
                type: "get",
                data: {
                    _token: _token,
                }
            })
                .done(function (response) {
                    if (!Object.keys(JSON.parse(response)).length) {
                        $('.alert').html("Вы загрузили все транзакции").show();
                        $('.loadmore').hide()
                        return;
                    }
                    $.each(JSON.parse(response), function (index, value) {
                        $('.orders-list.explorer-list .orders-list-wrapper').append(
                            ' <div class="order">\n' +
                            '                                <div class="col-12 order-wrapper">\n' +
                            '                                    <div class="row">\n' +
                            '                                        <div class="hash">\n' +
                            '                                            <a>' + value.uuid + '</a>\n' +
                            '                                        </div>\n' +
                            '                                        <div class="date">\n' +
                            '                                            ' + value.date + '\n' +
                            '                                        </div>\n' +
                            '                                        <div class="amount-source">\n' +
                            '                                            <strong>' + value.amount + '&nbsp;' + value.currency + '</strong>\n' +
                            '                                        </div>\n' +
                            '                                        <div class="amount">\n' +
                            '                                            <strong>' + value.amount_dhb + '&nbsp;DHB</strong>\n' +
                            '                                        </div>\n' +
                            '                                    </div>\n' +
                            '                                </div>\n' +
                            '                            </div>'
                        )
                    });
                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    console.log('Ошибка при попытке выполнения запроса');
                });
        }

        $('input.transactions').on('input', function (e) {
            $('.searching').removeClass('error')
            var transaction = $(this).val();
            if (!transaction) $('.card-body').removeClass('searching');
            else {
                $.ajax({
                    url: ENDPOINT + "/api/getTransactions",
                    datatype: "json",
                    type: "post",
                    data: {
                        _token: _token,
                        value: transaction
                    },
                    beforeSend: function () {
                        $('.card-body').addClass('searching');
                    }
                })
                    .done(function (response) {
                        $('.searching').removeClass('error')
                        if (!Object.keys(JSON.parse(response)).length) {
                            return;
                        }
                        $('.search-items').html('')
                        $.each(JSON.parse(response), function (index, value) {
                            $('.search-items').append(
                                ' <div class="order">\n' +
                                '                                <div class="col-12 order-wrapper">\n' +
                                '                                    <div class="row">\n' +
                                '                                        <div class="col-lg-4 hash">\n' +
                                '                                            <a>' + value.uuid + '</a>\n' +
                                '                                        </div>\n' +
                                '                                        <div class="date">\n' +
                                '                                            ' + value.date + '\n' +
                                '                                        </div>\n' +
                                '                                        <div class="amount-source">\n' +
                                '                                            <strong>' + value.amount + '&nbsp;' + value.currency + '</strong>\n' +
                                '                                        </div>\n' +
                                '                                        <div class="amount">\n' +
                                '                                            <strong>' + value.amount_dhb + '&nbsp;DHB</strong>\n' +
                                '                                        </div>\n' +
                                '                                    </div>\n' +
                                '                                </div>\n' +
                                '                            </div>'
                            )
                        });
                    })
                    .fail(function (jqXHR, ajaxOptions, thrownError) {
                        $('.searching').addClass('error')
                        $('.search-items').html('<p>По вашему запросу ничего не найдено</p>')
                    });
            }
        })
    </script>
@endsection
