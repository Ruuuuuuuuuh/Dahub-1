$(document).ready(function(){
    if ($('#exchange').length>0) {
        var chartHeight = $('#exchange').height();
        var heightPrice = 25;
    }
    else {
        var chartHeight = $('.balance-chart .tab-content').height();
        var heightPrice = 35;
    }

    $('#nav-prices-content canvas').css('minHeight', chartHeight + heightPrice);
    var hftData = [];
    var labels = [];
    $.each(jsonDataHFT, function(i, item) {
        hftData.push(item.rate);
        var date = new Date(item.timestamp);
        var options = { month: 'long', day: 'numeric', year: 'numeric' };
        date = date.toLocaleDateString('ru-RU', options);
        labels.push(date)
    });

    var hftChart = drawPriceHFT({
        name : 'canvas-hft',
        currency : 'ETH',
        bgColorStart : '#78d5cc',
        bgColorEnd : '#19b3a4',
        bgBorderColorStart : '#2bb4d9',
        bgBorderColorEnd : '#0fa7d0',
        height : chartHeight + 35,
        data : hftData,
        labels : labels
    });

    var btcChart = drawPrice({
        name : 'canvas-btc',
        currency : 'BTC',
        bgColorStart : '#ffa364',
        bgColorEnd : '#ff4f6c',
        bgBorderColorStart : '#ffa264',
        bgBorderColorEnd : '#ff506d',
        height : chartHeight + 35
    });

    var ethChart = drawPrice({
        name : 'canvas-eth',
        currency : 'ETH',
        bgColorStart : '#9393fd',
        bgColorEnd : '#5a5af9',
        bgBorderColorStart : '#5a5af9',
        bgBorderColorEnd : '#2828f9',
        height : chartHeight + 35
    });
})
