@extends('wallet.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card main-screen frontpage">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-start">
                            <ul class="nav nav-pills" id="balance-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link btn btn-outline-secondary active" id="dashboard-tab" data-toggle="tab" href="#dashboard-area" role="tab" aria-controls="dashboard-area" aria-selected="true">
                                        <svg width="26" height="20" viewBox="0 0 26 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M17.16 1.56257C8.19 -1.29743 0 5.33257 0 13.9126C0 15.0826 0.13 17.2926 0.52 18.5926C0.52 18.8526 0.78 19.1126 1.04 19.1126H24.83C25.09 19.1126 25.35 18.8526 25.48 18.5926C25.74 17.2926 26 15.0826 26 13.9126C26 8.32257 22.49 3.25257 17.16 1.56257ZM13 3.51257C13.78 3.51257 14.3 4.03257 14.3 4.81257C14.3 5.59257 13.78 6.11257 13 6.11257C12.22 6.11257 11.7 5.59257 11.7 4.81257C11.7 4.03257 12.22 3.51257 13 3.51257ZM3.9 15.2126C3.12 15.2126 2.6 14.6926 2.6 13.9126C2.6 13.1326 3.12 12.6126 3.9 12.6126C4.68 12.6126 5.2 13.1326 5.2 13.9126C5.2 14.6926 4.68 15.2126 3.9 15.2126ZM7.54 8.45257C7.02 8.97257 6.24 8.97257 5.72 8.45257C5.2 7.93257 5.2 7.02257 5.59 6.50257C6.11 5.98257 6.89 5.98257 7.41 6.50257C7.93 7.02257 7.93 7.93257 7.54 8.45257ZM13 16.5126C11.57 16.5126 10.27 15.2126 10.66 13.9126C11.05 12.6126 13 8.71257 13 8.71257C13 8.71257 14.95 12.6126 15.34 13.9126C15.73 15.2126 14.43 16.5126 13 16.5126ZM20.41 8.45257C19.89 8.97257 19.11 8.97257 18.59 8.45257C18.07 7.93257 18.07 7.15257 18.59 6.63257C19.11 6.11257 19.89 6.11257 20.41 6.63257C20.8 7.02257 20.8 7.93257 20.41 8.45257ZM22.1 15.2126C21.32 15.2126 20.8 14.6926 20.8 13.9126C20.8 13.1326 21.32 12.6126 22.1 12.6126C22.88 12.6126 23.4 13.1326 23.4 13.9126C23.4 14.6926 22.88 15.2126 22.1 15.2126Z" fill="#DDFFE9"/>
                                        </svg>
                                        <span>Dashboard</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn btn-outline-secondary" id="deposit-tab" @if (Auth::user()->hasActiveOrder()) href="/dashboard/orders/{{Auth::user()->orders()->where('status', '!=', 'completed')->first()->id}}" @else data-toggle="tab" href="#deposit-area" role="tab" aria-controls="deposit-area" aria-selected="false" @endif>
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.00011 9.96508C4.99278 9.96508 1.6489 8.50562 0.856695 6.56348C0.738086 6.84953 0.675293 7.14574 0.675293 7.44892C0.675293 9.81793 4.40164 11.7391 9.00011 11.7391C13.5967 11.7391 17.3243 9.81856 17.3243 7.44892C17.3243 7.1451 17.2583 6.84953 17.1435 6.56348C16.3488 8.50562 13.0049 9.96508 9.00011 9.96508Z" fill="white"/>
                                            <path d="M9.00011 13.0465C4.99278 13.0465 1.6489 11.5864 0.856695 9.64551C0.738086 9.93156 0.675293 10.2278 0.675293 10.5322C0.675293 12.9 4.40164 14.8212 9.00011 14.8212C13.5967 14.8212 17.3243 12.9006 17.3243 10.5322C17.3243 10.2278 17.2583 9.93156 17.1435 9.64551C16.3488 11.587 13.0049 13.0465 9.00011 13.0465Z" fill="white"/>
                                            <path d="M9.00011 16.2258C4.99278 16.2258 1.6489 14.7676 0.856695 12.8242C0.738086 13.1103 0.675293 13.4071 0.675293 13.7109C0.675293 16.0799 4.40164 17.9999 9.00011 17.9999C13.5967 17.9999 17.3243 16.0806 17.3243 13.7109C17.3243 13.4071 17.2583 13.1103 17.1435 12.8242C16.3488 14.7676 13.0049 16.2258 9.00011 16.2258Z" fill="white"/>
                                            <path d="M9.00045 8.57789C13.5978 8.57789 17.3246 6.65767 17.3246 4.28895C17.3246 1.92023 13.5978 0 9.00045 0C4.40313 0 0.67627 1.92023 0.67627 4.28895C0.67627 6.65767 4.40313 8.57789 9.00045 8.57789Z" fill="white"/>
                                        </svg>
                                        <span>Получить DHB</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn btn-outline-secondary" id="orders-tab" data-toggle="tab" href="#orders-area" role="tab" aria-controls="orders-area" aria-selected="false">
                                        <svg width="19" height="23" viewBox="0 0 19 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M18.3281 22.0892L17.5127 6.33913C17.49 5.90091 17.128 5.55724 16.6893 5.55724H14.2828V4.78327C14.2828 2.14575 12.1369 0 9.49933 0C6.86181 0 4.71618 2.14575 4.71618 4.78327V5.55724H2.30972C1.87089 5.55724 1.50888 5.90091 1.48616 6.33913L0.668575 22.1328C0.656941 22.3585 0.738444 22.5793 0.89414 22.7432C1.04977 22.9071 1.26596 23 1.49207 23H17.507C17.5074 23.0001 17.5077 23.0001 17.5081 23C17.9635 23 18.3326 22.6308 18.3326 22.1755C18.3325 22.1462 18.3311 22.1175 18.3281 22.0892ZM5.89085 8.89471C5.40311 8.89471 5.0076 8.4992 5.0076 8.01146C5.0076 7.52372 5.40311 7.12821 5.89085 7.12821C6.37858 7.12821 6.7741 7.52372 6.7741 8.01146C6.7741 8.4992 6.37858 8.89471 5.89085 8.89471ZM11.8297 5.55724H7.16919V4.78327C7.16919 3.49829 8.21447 2.453 9.49933 2.453C10.7844 2.453 11.8297 3.49829 11.8297 4.78327V5.55724ZM13.1091 8.89471C12.6214 8.89471 12.2259 8.4992 12.2259 8.01146C12.2259 7.52372 12.6214 7.12821 13.1091 7.12821C13.5969 7.12821 13.9924 7.52372 13.9924 8.01146C13.9924 8.4992 13.5969 8.89471 13.1091 8.89471Z" fill="#DDFFE9"/>
                                        </svg>
                                        <span>Мои заявки</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn btn-outline-secondary" id="ref-tab" data-toggle="tab" href="#ref-area" role="tab" aria-controls="ref-area" aria-selected="false">
                                        <svg width="22" height="19" viewBox="0 0 22 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8.24141 10.5688C10.7759 10.5688 12.8305 8.20286 12.8305 5.28438C12.8305 2.3659 10.7759 0 8.24141 0C5.70694 0 3.65234 2.3659 3.65234 5.28438C3.65234 8.20286 5.70694 10.5688 8.24141 10.5688Z" fill="#DDFFE9"/>
                                            <path d="M16.4785 17.9607C16.4785 15.175 15.443 12.6565 13.7629 10.9198C13.3762 10.519 12.7918 10.5042 12.4008 10.895C10.0031 13.2502 6.48398 13.2552 4.08633 10.895C3.69102 10.5091 3.10664 10.519 2.72422 10.9198C1.05273 12.6565 0 15.1651 0 17.9557C0 18.5297 0.403906 18.9997 0.902344 18.9997H15.5762C16.0746 18.9997 16.4785 18.5346 16.4785 17.9607Z" fill="#DDFFE9"/>
                                            <path d="M20.2813 12.5033C19.7828 12.9734 19.1942 13.3197 18.5496 13.5127C18.0598 13.6562 17.7676 14.2401 17.9051 14.8041C18.3348 16.5458 18.2875 18.0104 18.2875 17.9609C18.2875 18.5348 18.6914 19 19.1899 19H21.0891C21.5875 19 21.9914 18.5348 21.9914 17.9609C21.9914 14.72 22.0774 14.0916 21.695 12.9239C21.4758 12.2609 20.7582 12.058 20.2813 12.5033Z" fill="#DDFFE9"/>
                                            <path d="M17.4193 11.6225C18.9405 11.6225 20.1736 10.2026 20.1736 8.45092C20.1736 6.69928 18.9405 5.2793 17.4193 5.2793C15.8982 5.2793 14.665 6.69928 14.665 8.45092C14.665 10.2026 15.8982 11.6225 17.4193 11.6225Z" fill="#DDFFE9"/>
                                        </svg>
                                        <span>Партнерская программа</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="tab-content pb-3" id="balance-tabs-content">
                            <div class="tab-pane fade show active" id="dashboard-area" role="tabpanel" aria-labelledby="dashboard-tab">
                                @include('wallet.components.main')
                            </div>
                            <div class="tab-pane fade" id="deposit-area" role="tabpanel" aria-labelledby="deposit-tab">
                                @include('wallet.components.deposit')
                            </div>
                            <div class="tab-pane fade" id="orders-area" role="tabpanel" aria-labelledby="orders-tab">
                                @include('wallet.components.user_orders')
                            </div>
                            <div class="tab-pane fade" id="ref-area" role="tabpanel" aria-labelledby="ref-tab">
                                @include('wallet.components.referral')
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script>
        window.user = {!! Auth::User()->toJson(JSON_PRETTY_PRINT) !!}
        window.currencies = {};
            @foreach (\App\Models\Currency::all() as $currency)
            window.currencies.{{$currency->title}} = {}
            window.currencies.{{$currency->title}}.decimalPlaces = {{$currency->decimal_places}}
            @endforeach


        $('[data-toggle="popover"]').popover()
        $('.copy-link, .copy-link *').click(function(e){
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
        $('.deposit-block input, .deposit-block select').on('change', function(e) {
            changeInputValues(e)
        })


        $('select[name="deposit-currency').on('change', function(e) {
            let currency = $(this).val()
            getPayments(currency).then(function(data) {
                // Run this when your request was successful
                let payments = '';
                $.each(data, function(key, item) {
                    payments += "<option value='" + item.title + "'>" + item.title + "</option>";
                    // $(this).closest('form').find('.select-payment').html(payments)
                })
                $('select[name="deposit-payment"]').html(payments)
            }).catch(function(err) {
                // Run this when promise was rejected via reject()
                console.log(err)
            })
        })

        function changeInputValues(e) {
            let balance = {{ Auth::User()->getBalance('DHB') }}
            let amount = $('input[name="deposit-amount"]')
            let currency = $('select[name="deposit-currency"]')
            let depositRecieve = $('.deposit-receive')
            let subtotal = $('.subtotal-amount span').html() + 0
            let rate = {
                DHB : '{!! Rate::getRates('DHB') !!}',
                @foreach (\App\Models\Currency::payableCurrencies()->get() as $currency)
                {{$currency->title}} : '{!! Rate::getRates($currency->title) !!}',
                @endforeach
            }

            let min = parseInt($('.deposit-block input[name="deposit-amount"]').data('min'));
            let max = parseInt($('.deposit-block input[name="deposit-amount"]').data('max'));

            if ($(e.target).is(depositRecieve)) {
                let amountTotal = rate[currency.val()] * depositRecieve.val() / rate['DHB']
                amount.val(amountTotal.toFixed(window.currencies[currency.val()]['decimalPlaces']))
            }
            if (amount.val() > max) amount.val(max)
            if (amount.val() < min) amount.val(min)
            let amountTotal = rate['DHB'] * amount.val() / rate[currency.val()]
            depositRecieve.val(amountTotal.toFixed(window.currencies[currency.val()]['decimalPlaces']))

            subtotal = parseFloat(balance) + parseFloat(amount.val())
            $('.subtotal-amount span').html( new Intl.NumberFormat('ru-RU').format(subtotal) + ',00' )
            amount.val(parseInt(amount.val()))


        }
        function deposit() {
            let _token = $('meta[name="csrf-token"]').attr('content');
            let amount = $('input[name="deposit-receive"]').val()
            let currency = $('select[name="deposit-currency"]').val()
            let payment = $('select[name="deposit-payment"]').val()
            let dhb_amount = $('input[name="deposit-amount"]').val()
            $.ajax({
                url: "/api/createOrderByUser",
                type:"POST",
                data:{
                    _token: _token,
                    destination:    'TokenSale',
                    currency:       currency,
                    amount:         amount,
                    payment:        payment,
                    dhb_amount:     dhb_amount
                },
                success:function(response){
                    window.location.href = '/dashboard/orders/' + response
                },
            });
        }

        function assignee() {
            let _token = $('meta[name="csrf-token"]').attr('content');
            let id = $('.deposit-section').data('id')
            $.ajax({
                url: "/api/orders/assigneeOrder",
                type:"POST",
                data:{
                    _token: _token,
                    id: id
                },
                success:function(response){
                    $('.deposit-section').removeClass('created').addClass('assignee');
                    $('.assignee-section h2').text('Заявка #' + id)
                },
            });
        }


        function getPayments(currency) {
            return new Promise(function (resolve, reject) {
                $.ajax({
                    url: "/api/getPayments",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "currency": currency,
                    },
                    success: function (data) {
                        resolve(data)
                    },
                    error: function (err) {
                        reject(err)
                    }
                })
            })
        }


    </script>
@endsection
