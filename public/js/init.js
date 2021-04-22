//AJAX
function ajaxResponse(url, method, headers, data, successResponse, errorResponse) {
    $.ajax({
        url: url,
        headers: headers,
        type: method,
        data: data,
        success:  successResponse,
        error :  errorResponse
   });
}

//bootstrap carousel activate
$('.carousel').carousel({
    interval: 5000
})

//bootstrap tooltip activate
$('body').tooltip({
    selector: '.is-invalid'
});

//to locale string datetime
$('.to-locale-string').each(function() {
    var val = number_format($(this).text(), 0);
    $(this).text(val);
})
//DEPOSIT-WITHDRAW
$(":input").inputmask();
function changeForm(form, param) {
    var form = form.closest('form');
    var amount = form.find('.autocounting');
    var minAmount = form.find('.min-amount');
    var otherWallet = form.find('.other-wallet');
    var btcWallet = form.find('.btc-wallet');
    var usdWallet = form.find('.usd-wallet');
    var hftWallet = form.find('.hft-wallet');
    var formComments = form.find('.form-comments');
    var city = form.find('.cash-group');
    var currencyAddon = form.find('.currency-addon');
    var currencyAvailable = form.find('.currency-available');
    var amountUSD = form.find('.amount-usd');
    var lastLiteral = (quote.rub*usdFree) % 10;
    var rubleSimbol = 'рублей';
    var origin = form.find('.form-check');
    var check = form.find('.form-check-input').prop('checked');
    if (lastLiteral == 1) rubleSimbol = 'рубль';
    if (lastLiteral > 1 && lastLiteral < 5) rubleSimbol = 'рубля';
    var option = form.find(':selected').prop('value');
    var selectMethod = form.find('.select-method');
    var selectMethodGroup = form.find('.select-method-group');
    var cardNumberBlock = form.find('.card-number-block');

    if (param) {
        $('.autocounting').val(0);
    }

    activateSubmit(form);

    switch (option) {
        case 'USD':
        origin.show();
        minAmount.show();
        minAmount.find('span').text('$100');
        formComments.show();
        cardNumberBlock.hide();
        selectMethodGroup.show();
        btcWallet.hide();
        usdWallet.show();
        otherWallet.hide();
        hftWallet.hide();
        amountUSD.hide();
        if (selectMethod.val() == 'bank') {
          usdWallet.show();
          city.hide();
        }
        else
        {
          usdWallet.hide();
          city.show();
          minAmount.find('span').text('$1,000');
        }
        $('.ru_notify').remove();
        currencyAddon.removeClass('btc rub hft').addClass('usd');
        if(check) {
            currencyAvailable.html(' ' + (hftFree*quote.hft).toFixed(2).toLocaleString('ru') + '$ USD');
            $('.available-input').val((hftFree*quote.hft).toFixed(2));
        }
        else {
            currencyAvailable.html(' ' + usdFree.toFixed(2).toLocaleString('ru') + '$ USD');
            $('.available-input').val(usdFree.toFixed(2));
        }
        break;

        case 'BTC':
        origin.show();
        city.hide();
        minAmount.hide();
        formComments.hide();
        cardNumberBlock.hide();
        selectMethodGroup.hide();
        btcWallet.hide();
        otherWallet.hide();
        usdWallet.hide();
        hftWallet.hide();
        amountUSD.show();
        $('.ru_notify').remove();
        currencyAddon.removeClass('usd rub hft').addClass('btc');
        if(check) {
            currencyAvailable.text(' ' + ((hftFree*quote.hft)/quote.btc).toFixed(7) + ' BTC');
            $('.available-input').val(((hftFree*quote.hft)/quote.btc).toFixed(7));
        }
        else {
            currencyAvailable.text(' ' + btcFree.toFixed(7) + ' BTC');
            $('.available-input').val(btcFree.toFixed(7));
        }
        break;

        case 'RUB':
        origin.show();
        minAmount.show();
        minAmount.find('span').text('5 000 ₽');
        formComments.show();
        selectMethodGroup.show();
        if (selectMethod.val() == 'bank') {
          cardNumberBlock.show();
          city.hide();
        }
        else {
          city.show();
          minAmount.find('span').text('50 000 ₽');
        }
        btcWallet.hide();
        otherWallet.show();
        usdWallet.hide();
        amountUSD.hide();
        hftWallet.hide();
        currencyAddon.removeClass('usd btc hft').addClass('rub');
        $('.ru_notify').remove();
        if(check) {
            currencyAvailable.text(' ' + ((hftFree*quote.hft)/quote.rub).toFixed(2).toLocaleString('ru') + ' ' + rubleSimbol).parent().find('.min-amount').before('<span class="ru_notify"><br /> по текущему курсу ЦБ USD:RUB = ' + (1/quote.rub).toFixed(2) + '</span>');
            $('.available-input').val(((hftFree*quote.hft)/quote.rub).toFixed(2));
        }
        else {
            currencyAvailable.text(' ' + (rubFree).toFixed(2).toLocaleString('ru') + ' ' + rubleSimbol).parent().find('.min-amount').before('<span class="ru_notify"><br /> по текущему курсу ЦБ USD:RUB = ' + (1/quote.rub).toFixed(2) + '</span>');
            $('.available-input').val((rubFree).toFixed(2));
        }
        break;

        case 'HFT':
        minAmount.hide();
        city.hide();
        formComments.show();
        selectMethodGroup.hide();
        cardNumberBlock.hide();
        btcWallet.hide();
        otherWallet.show();
        usdWallet.hide();
        hftWallet.show();
        amountUSD.hide();

        currencyAvailable.html(' ' + (hftFree).toFixed(2).toLocaleString('ru') + ' HFT');
        $('.available-input').val((hftFree*quote.hft).toFixed(2));

        currencyAddon.removeClass('usd btc rub').addClass('hft');
        $('.ru_notify').remove();
        origin.hide();
        break;
    }

}
$('.custom-select').change(function() {
    changeForm($(this), true);
});

$('.select-method').change(function(){
    var method = $(this).val();
    var form = $(this).closest('form');
    var currency = form.find('.custom-select').val();
    var cardNumberBlock = form.find('.card-number-block');
    var city = form.find('.cash-group');
    var minAmount = form.find('.min-amount span');
    form.find('input[name="cash_method"]').val(method);
    if (method == 'cash')
    {
      cardNumberBlock.hide();
      form.find('.usd-wallet').hide();
      city.show()
      if (currency == 'USD') {
        minAmount.text('$1,000')
      }
      if (currency == 'RUB') {
        minAmount.text('50 000 ₽')
      }
    }
    else {
      cardNumberBlock.show();
      if (currency == 'USD') form.find('.usd-wallet').show();
      city.hide();
      if (currency == 'USD') {
        minAmount.text('$100')
      }
      if (currency == 'RUB') {
        minAmount.text('5 000 ₽')
      }
    }
    activateSubmit(form);
})

$('.modal-body .autocounting').keyup(function (e) {
    activateSubmit($(this).closest('form'));
}).on('keypress change paste', function(e) {
    if(!e.ctrlKey) {
        var amountGroup = $(this).closest('.amount-group');
        var amountBTC = amountGroup.find('input[name="amount"]');
        var amountUSD = amountGroup.find('input[name="amount-usd"]');
        if ($(this).attr('name') == 'amount') {
            amountUSD.val((amountBTC.val()*quote.btc).toFixed(2));
        }
        else {
            amountBTC.val((amountUSD.val()/quote.btc).toFixed(7));
        }
    }
})
$('input[name="cash-city"], input[name="usd-wallet"]').keyup(function (e) {
    activateSubmit($(this).closest('form'));
}).on('keypress change paste', function(e) {
    activateSubmit($(this).closest('form'));
})
$('.select-method').change(function(){
    $(this).closest('form').find('input[name="cash_method"]').val($(this).val())
})

function activateSubmit(form) {
    var currency = form.find('.custom-select').val();
    var input = form.find('.autocounting');
    var button = form.closest('.modal-content').find('.btn-submit');
    if (currency == 'RUB') {
        var method = form.find('input[name="cash_method"]').val();
        if (method == 'bank') {
            var cardNumber = form.find('.card-number').val();

            if (parseFloat(input.val()) >= 5000 && checkMoon(cardNumber) && cardNumber.length > 0) {
                button.attr('disabled', false).addClass('btn-blue').removeClass('btn-disabled')
            }
            else {
                button.attr('disabled', true).addClass('btn-disabled').removeClass('btn-blue')
            }
        }
        else {
            var city = form.find('input[name="cash-city"]').val();
            if (city != '') {
                if (parseFloat(input.val()) >= 50000) {
                    button.attr('disabled', false).addClass('btn-blue').removeClass('btn-disabled')
                }
                else {
                    button.attr('disabled', true).addClass('btn-disabled').removeClass('btn-blue')
                }
            }
            else {
                button.attr('disabled', true).addClass('btn-disabled').removeClass('btn-blue')
            }
        }
    }
    else if (currency == 'USD') {
        var method = form.find('input[name="cash_method"]').val();
        var usdWallet = form.find('input[name="usd-wallet"]').val();
        var city = form.find('input[name="cash-city"]').val();
        if (method == 'bank') {
            if (usdWallet != '') {
                if (parseFloat(input.val()) >= 100) {
                    button.attr('disabled', false).addClass('btn-blue').removeClass('btn-disabled')
                }
                else {
                    button.attr('disabled', true).addClass('btn-disabled').removeClass('btn-blue')
                }
            }
            else {
                button.attr('disabled', true).addClass('btn-disabled').removeClass('btn-blue')
            }
        }
        else {
            if (city != '') {
                if (parseFloat(input.val()) >= 1000) {
                    button.attr('disabled', false).addClass('btn-blue').removeClass('btn-disabled')
                }
                else {
                    button.attr('disabled', true).addClass('btn-disabled').removeClass('btn-blue')
                }
            }
            else {
                button.attr('disabled', true).addClass('btn-disabled').removeClass('btn-blue')
            }
        }
    }
    else  {
        if (parseFloat(input.val()) > 0) {
            button.attr('disabled', false).addClass('btn-blue').removeClass('btn-disabled')
        }
        else {
            button.attr('disabled', true).addClass('btn-disabled').removeClass('btn-blue')
        }
    }
}


$('#widthraw-submit').click(function() {
    $(this).attr('disabled', true);
    $(this).closest('.modal-content').addClass('loading');
    var data = $('#form-withdraw').serialize();
    $('.is-invalid').tooltip('dispose').removeClass('is-invalid');
    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    var success = function(success) {
        $('.modal-content').removeClass('loading');
        $('.modal').modal('hide');
        if (currency == 'HFT') {
            window.location.href = '/dashboard/transactions';
        }
        else window.location.href = '/dashboard/operations/';
    }
    var error = function(error) {
        $(this).attr('disabled', false);
        $('.modal-content').removeClass('loading');
        $.each(error.responseJSON.errors, function(index, value) {
            $('#form-withdraw input[name="' + index + '"]').addClass('is-invalid').attr({
                'data-toggle': 'tooltip',
                'title': value,
                'data-placement': 'bottom'
            }).tooltip('update').tooltip('show');
            if (index == 'amount') {
                $('#widthraw-submit input[name="amount-usd"]').addClass('is-invalid').attr({
                    'data-toggle': 'tooltip',
                    'title': value,
                    'data-placement': 'bottom'
                }).tooltip('update').tooltip('show');
            }
        })
        if (typeof error.responseJSON.error.message != 'undefined') {

            $('#form-withdraw input[name="amount"]').addClass('is-invalid').attr({
                'data-toggle': 'tooltip',
                'title': 'Введите минимально необходимую сумму',
                'data-placement': 'bottom'
            }).tooltip('update').tooltip('show');
            console.log(error.responseJSON.error.message)
        }
    }
    var currency = $('#form-withdraw .custom-select').val();
    if (currency == 'HFT')  ajaxResponse('/response/sendHFT', 'POST', headers, data, success, error);
    else ajaxResponse('/response/withdraw', 'POST', headers, data, success, error);
})
$('.loading').click(function(e) {
    e.stopPropagation();
})
$('#deposit-submit').click(function() {
    $(this).closest('.modal-content').addClass('loading');
    $(this).attr('disabled', true);
    var data = $('#form-deposit').serialize();
    $('.is-invalid').tooltip('dispose').removeClass('is-invalid');
    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    var success = function(success) {
        $('.modal-content').removeClass('loading');
        $('.modal').modal('hide');

        window.location.href = '/dashboard/operations/' + success;
    }
    var error = function(error) {
        $(this).attr('disabled', false);
        $('.modal-content').removeClass('loading');
        $.each(error.responseJSON.errors, function(index, value) {
            $('#form-deposit input[name="' + index + '"]').addClass('is-invalid').attr({
                'data-toggle': 'tooltip',
                'title': value,
                'data-placement': 'bottom'
            }).tooltip('update').tooltip('show');

        })
        if (typeof error.responseJSON.error.message != 'undefined') {
            $('#form-deposit input[name="amount"]').addClass('is-invalid').attr({
                'data-toggle': 'tooltip',
                'title': 'Введите минимально необходимую сумму',
                'data-placement': 'bottom'
            }).tooltip('update').tooltip('show');
            console.log(error.responseJSON.error.message)
        }
    }
    ajaxResponse('/response/deposit', 'POST', headers, data, success, error);
})

$(function() {
  $("#sidebar").swipe( {
      preventDefaultEvents: false,
    //Generic swipe handler for all directions
    swipe:function(event, direction, distance, duration, fingerCount, fingerData) {

        switch(direction) {
            case 'right':
            $('#content').addClass('sidebar-open');
            break;
            case  'left':
            $('#content').removeClass('sidebar-open');
            break;
        }
    }
  });
});

$('.form-check-input').click(function() {
    changeForm($(this).closest('form').find('.custom-select'), false);
})

var hasUnread = $('.notification-counter');
if (hasUnread.length>0) {
    $('.icon-user-notification').addClass('has-unread');
}

$('.icon-user-notification').on('click', function () {
    if (($(this).attr('aria-expanded') == 'true') && ($(this).hasClass('has-unread'))) {
        var data = $('#user').serialize();
        var success = function(success) {
            $('.notification-item').removeClass('unerad');
            $('.notification-counter').hide();
        }
        var error = function(error) {
        }
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        ajaxResponse('/response/readnotifications', 'POST', headers, data, success, error);
    }
})


$('#loginform').submit(function(e) {
    $('#loginform').addClass('loading');
    e.preventDefault();
    $('.is-invalid').tooltip('dispose').removeClass('is-invalid');
    var data = $(this).serialize();
    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }

    var success = function(success) {
        location.reload(true);
    }

    var error = function(error) {
        $('#loginform').removeClass('loading');
        if (typeof error.responseJSON.errors == 'object') {
            console.log(error.responseJSON.errors)
            $.each(error.responseJSON.errors, function(index, value) {
                $('#loginform input[name="' + index + '"]').addClass('is-invalid').attr({
                    'data-toggle': 'tooltip',
                    'title': value,
                    'data-placement': 'bottom'
                }).tooltip('update').tooltip('show');

            })
        }
        else $('#loginform .error p').text(error.responseJSON.errors)
    }

    ajaxResponse('/login', 'POST', headers, data, success, error);
})


$(document).ready(function() {
    if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0)
    {
       document.getElementsByTagName("BODY")[0].className += " safari";
    }
    $('.custom-select').val('RUB').trigger('change');
    $('.select-method').val('bank').trigger('change');
})

//NUMBER FORMAT
function number_format( number, decimals, dec_point, thousands_sep ) {	// Format a number with grouped thousands
	//
	// +   original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
	// +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	// +	 bugfix by: Michael White (http://crestidg.com)
	var i, j, kw, kd, km;
	// input sanitation & defaults
	if( isNaN(decimals = Math.abs(decimals)) ){
		decimals = 2;
	}
	if( dec_point == undefined ){
		dec_point = ",";
	}
	if( thousands_sep == undefined ){
		thousands_sep = " ";
	}
	i = parseInt(number = (+number || 0).toFixed(decimals)) + "";
	if( (j = i.length) > 3 ){
		j = j % 3;
	} else{
		j = 0;
	}
	km = (j ? i.substr(0, j) + thousands_sep : "");
	kw = i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep);
	//kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).slice(2) : "");
	kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).replace(/-/, 0).slice(2) : "");

	return km + kw + kd;
}

// CARD INFO
if (typeof CardInfo  !== 'undefined') {
    CardInfo.setDefaultOptions({
        banksLogosPath: '/js/card-info-master/dist/banks-logos/',
        brandsLogosPath: '/js/card-info-master/dist/brands-logos/',
        backgroundColors: ['#048c86', '#7befe0'],
    })
}

$('.card-number').on('keyup change paste', function () {
    var modal = $(this).closest('.modal-content')
    var $front = modal.find('.card-front')
    var $bankLink = modal.find('.bank-link')
    var $brandLogo = modal.find('.brand-logo')
    var $number = modal.find('.card-number')
    var $code = modal.find('.code')
    var form = modal.find('form')
    var sendedPrefix = window.location.search.substr(1)
    if ($number.val().length > 0) {
        var cardInfo = new CardInfo($number.val(), {

        })

        if (cardInfo.bankUrl) {
         $bankLink
           .css('backgroundImage', 'url("' + cardInfo.bankLogo + '")')
           .show()
        } else {
         $bankLink.hide()
        }
        $front
         .css('background', cardInfo.backgroundGradient)
         .css('color', cardInfo.textColor)
        $code.attr('placeholder', cardInfo.codeName ? cardInfo.codeName : '')
        $number.mask(cardInfo.numberMask)
        if (cardInfo.brandLogo) {
         $brandLogo
           .attr('src', cardInfo.brandLogo)
           .attr('alt', cardInfo.brandName)
           .show()
        } else {
         $brandLogo.hide()
        }
        var $instance = cardInfo;
        if (checkMoon($number.val())) {
            $(this).addClass('is-valid').removeClass('is-invalid');
            modal.find('input[name="payment"]').val($instance.brandName);
            modal.find('input[name="bank"]').val($instance.bankName);
            modal.find('.cards-form-wrapper').addClass('sberbank')
        }
        else {
            $(this).addClass('is-invalid').removeClass('is-valid');
            modal.find('input[name="bank"]').val('');
            modal.find('.cards-form-wrapper').removeClass('sberbank')
        }
        activateSubmit(form);
    }

    }).trigger('keyup')

    //Алгоритм Луна для проверки валидности номера кредитной карты
function checkMoon(card_number) {

    var arr = [],
    card_number = card_number.toString().replace(/\s+/g, '');
    if (card_number.length > 0) {
        for(var i = 0; i < card_number.length; i++) {
        if(i % 2 === 0) {
          var m = parseInt(card_number[i]) * 2;
          if(m > 9) {
            arr.push(m - 9);
          } else {
            arr.push(m);
          }
        } else {
            var n = parseInt(card_number[i]);
            arr.push(n)
          }
        }
        //console.log(arr);
        var summ = arr.reduce(function(a, b) { return a + b; });
        if (card_number.length > 15) {
          return Boolean(!(summ % 10));
        }
        else return false;
    }
    else return false;
}
