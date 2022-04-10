@extends('dashboard.layouts.app')
@section('content')
<section class="screen opened settings">
    <div class="section-header">
        <div class="top-nav">
            <a href="{{ Route('wallet') }}" class="back-link">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.7071 17.2929C16.0976 17.6834 16.0976 18.3166 15.7071 18.7071C15.3166 19.0976 14.6834 19.0976 14.2929 18.7071L8.29289 12.7071C7.90237 12.3166 7.90237 11.6834 8.29289 11.2929L14.2929 5.29289C14.6834 4.90237 15.3166 4.90237 15.7071 5.29289C16.0976 5.68342 16.0976 6.31658 15.7071 6.70711L10.4142 12L15.7071 17.2929Z" fill="#0D1F3C"></path>
                    <mask id="back-link" mask-type="alpha" maskUnits="userSpaceOnUse" x="8" y="5" width="8" height="14">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M15.7071 17.2929C16.0976 17.6834 16.0976 18.3166 15.7071 18.7071C15.3166 19.0976 14.6834 19.0976 14.2929 18.7071L8.29289 12.7071C7.90237 12.3166 7.90237 11.6834 8.29289 11.2929L14.2929 5.29289C14.6834 4.90237 15.3166 4.90237 15.7071 5.29289C16.0976 5.68342 16.0976 6.31658 15.7071 6.70711L10.4142 12L15.7071 17.2929Z" fill="white"></path>
                    </mask>
                    <g mask="url(#back-link)">
                        <rect width="24" height="24" fill="#0D1F3C"></rect>
                    </g>
                </svg>
            </a>
            <h2>Настройки баланса</h2>
        </div>
    </div>
    <div class="section-main">
        <h4>Список сохраненных валют</h4>
        <div id="balance-items" class="balance-items" data-sortable-id="0" aria-dropeffect="move">
            @foreach ($visibleWallets as $visibleWallet)
                <div class="balance-item justify-content-between w-100 d-flex active"  data-item-sortable-id="{{$currency::where('title', $visibleWallet)->first()->id - 1}}" draggable="true" role="option" aria-grabbed="false" >
                    <div class="balance-item-currency d-flex align-items-center">
                        <div class="balance-item-currency-icon">
                            <div class="icon-wrapper">
                                {!! $currency::where('title', $visibleWallet)->first()->icon !!}
                            </div>
                        </div>
                        <div class="balance-item-currency-text">
                            <div class="balance-item-currency-title">{{$visibleWallet}}</div>
                            <div class="balance-item-currency-description">{{$currency::where('title', $visibleWallet)->first()->subtitle}}</div>
                        </div>
                    </div>
                </div>
            @endforeach
            @foreach ($currency::all() as $index => $visibleWallet)
                @if (!in_array($visibleWallet->title, $visibleWallets))

                <div class="balance-item justify-content-between w-100 d-flex"  data-item-sortable-id="{{$index}}" draggable="true" role="option" aria-grabbed="false" >
                    <div class="balance-item-currency d-flex align-items-center">
                        <div class="balance-item-currency-icon">
                            <div class="icon-wrapper">
                                {!! $visibleWallet->icon !!}
                            </div>
                        </div>
                        <div class="balance-item-currency-text">
                            <div class="balance-item-currency-title">{{$visibleWallet->title}}</div>
                            <div class="balance-item-currency-description">{{$visibleWallet->subtitle}}</div>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>

    <form class="w-100">
        @csrf
        <div class="form-group w-100">
            <select class="selectpicker w-100" multiple>
                @foreach($currency::all() as $item)
                    <option value="{{$item->title}}" @if (in_array($item->title, $visibleWallets)) selected @endif>{{$item->title}}</option>
                @endforeach
            </select>
        </div>

    </form>
</section>
@endsection

@section('scripts')
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script>
        $(function(){
            $('#balance-items').sortable({
                stop: function( event, ui ) {
                    updateUserConfig()
                }
            });
            $('#balance-items').disableSelection();

            $('.selectpicker').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
                if (isSelected) {
                    $('#balance-items .balance-item[data-item-sortable-id="' + clickedIndex + '"]').addClass('active')
                }
                else {
                    $('#balance-items .balance-item[data-item-sortable-id="' + clickedIndex + '"]').removeClass('active')
                }
                updateUserConfig()
            });

            function updateUserConfig() {
                let currency = []
                $('#balance-items .balance-item.active').each(function(index, value){
                    let title = $(this).find('.balance-item-currency-title').html()
                    currency[index] = title
                })
                return new Promise(function (resolve, reject) {
                    $.ajax({
                        url: "/api/saveUserConfig",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "meta": "visible_wallets",
                            "value": currency
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
        })

    </script>
@endsection
