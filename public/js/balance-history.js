
function drawHistory(range = 7) {

    $('.balance-history').addClass('loading');
    var start = moment().subtract(range, 'days');
    var end   = moment();

    var data = 'start=' + start.toISOString() + '&end=' + end.toISOString();
    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    $('.chartjs-tooltip-balance-history').html('');
    var chartHeight = 400;
    var success = function(success) {
        if ((typeof historyChart)  !== "undefined") {
            historyChart.destroy()
        }
        var prices = [];
        var labels = [];
        var prevDate,prevPrice, change, date, diffPrice, changeText;
        var options = { month: 'long', day: 'numeric', year: 'numeric' };
        var data = JSON.parse(success);

        var table = '<table class="table list-table table-striped header-fixed"><thead><tr><th>Дата</th><th>Баланс, $</th><th>Изменение, %</th><th>Изменение, $</th></thead><tbody>';
        var j = 0;
        $.each(data, function(i, item) {
            if (i == 0) {
                price = parseFloat(item.amount).toFixed(2);
                prevPrice = price;
                date = new Date(item.timestamp);
                date = date.toLocaleDateString('ru-RU', options);
                prevDate = date;
                change = '+ 0.00';
                prices.push(price);
                labels.push(date);
                //table += '<tr class="up"><td>' + date + '</td><td class="price">' + price + '</td><td class="change">' + change + '</td>' + '<td class="change">+ 0.00</td></tr>';
            }
            if (i > 0 && i < (data.length)) {
                price = parseFloat(item.amount).toFixed(2);
                prevPrice = prices[j];
                prevDate  = labels[j];


                date = new Date(item.timestamp);
                date = date.toLocaleDateString('ru-RU', options);
                if (date != prevDate) {

                    diffPrice = parseFloat((price - prevPrice)).toFixed(2);
                    if (prevPrice != 0) {
                        change = 100 * (price - prevPrice) / prevPrice;
                    }
                    else if (price != 0) {
                        change = 100;
                    }
                    else change = 0;

                    if (change > 0) {
                        changeText = '+ ' + change.toFixed(2);
                        var changeClass = 'up';
                        diffPrice = '+ ' + diffPrice;
                    }
                    else if (change == 0) {
                        changeText = '+ 0.00';
                        var changeClass = 'up';
                        diffPrice = '+ ' + diffPrice;
                    }
                    else {
                        changeText = '– ' + ((-1) * change.toFixed(2))
                        var changeClass = 'down';
                        diffPrice = '– ' + ((-1) * diffPrice)
                    }
                    prices.push(price);
                    labels.push(date);
                    if (change != 0) {
                        table += '<tr class="'+ changeClass + '"><td class="date">' + date + '</td><td class="price">' + price + '</td><td class="change">' + changeText + '</td>' + '<td class="change">' + diffPrice + '</td></tr>';
                    }
                    prevPrice = price;
                    j++;
                }
                $('.balance-table').height($('.balance-history').height())

            }

            if (i == (data.length)) {
                prevDate = labels[j];
                date = new Date(item.timestamp);
                date = date.toLocaleDateString('ru-RU', options);

                if (date == prevDate) {
                    prices.pop();
                    labels.pop()
                    --j;
                    prevDate = labels[j]
                }

                price = parseFloat(item.amount).toFixed(2);
                prevPrice = prices[j];



                change = 100 * (price - prevPrice) / prevPrice;
                diffPrice = (price - prevPrice).toFixed(2);
                if (change > 0) {
                    changeText = '+ ' + change.toFixed(2);
                    var changeClass = 'up';
                    diffPrice = '+ ' + diffPrice;
                }
                else if (change == 0) {
                    changeText = '+ 0.00';
                    var changeClass = 'up';
                    diffPrice = '+ ' + diffPrice;
                }
                else {
                    changeText = '– ' + ((-1) * change.toFixed(2))
                    var changeClass = 'down';
                    diffPrice = '– ' + ((-1) * diffPrice)
                }
                prices.push(price);
                labels.push(date);
                table += '<tr class="'+ changeClass + '"><td class="date">' + date + '</td><td class="price">' + price + '</td><td class="change">' + changeText + '</td>' + '<td class="change">' + diffPrice + '</td></tr>';
                prevPrice = price;
            }

        });
        table += '</tbody></table>';
        var profit = prices[prices.length - 1] - prices[0];
        if (profit >= 0) {
            profit = '<span class="profit up">+ ' + profit.toFixed(2) + '$</span>'
        }
        else {
            profit = '<span class="profit down">– ' + (-1)*profit.toFixed(2) + '$</span>'
        }
        $('.profit-wrapper').html('Изменение за период:&nbsp;' + profit);
        var options = {
            name : 'balance-history',
            bgColorStart : 'rgba(255, 255, 255, 0.1)',
            bgColorEnd : 'rgba(255, 255, 255, 0.1)',
            bgBorderColorStart : '#047188',
            bgBorderColorEnd : '#107186',
            height : chartHeight + 35,
            data : prices,
            labels : labels
        };

        ctxBalanceHistory = document.getElementById(options.name).getContext('2d');
        ctxBalanceHistory.height = options.height;

        var bgColor = ctxBalanceHistory.createLinearGradient(500, 800, 0, 0);
        bgColor.addColorStop(1, options.bgColorStart);
        bgColor.addColorStop(0, options.bgColorEnd);
        //bitcoinColor
        var borderColor = ctxBalanceHistory.createLinearGradient(400, 0, 0, 0);
        borderColor.addColorStop(0, options.bgBorderColorStart);
        borderColor.addColorStop(1, options.bgBorderColorEnd);
        var label = [];
        var labels = [];
        if (options.labels) {
            labels = options.labels;
        }
        for (let i=0; i<options.data.length; i++) {
          label.push('$' + options.data[i] + '<br />' + labels[i]);
        }
        var btcTimeline = ['items','labels'];
        window.historyChart = new Chart(ctxBalanceHistory, {
            type: 'line',
            data: {
                labels: label,
                title: options.name,
                datasets: [{
                    label: false,
                    borderColor: borderColor,
                    backgroundColor: bgColor,
                    fill: true,
                    data: options.data,
                    pointRadius: 0,
                    pointHitRadius: 35,
                    pointBackgroundColor: borderColor,
                    pointBorderColor: borderColor,
                    pointBorderWidth: 4,
                    pointHoverRadius: 7,
                    pointHoverBorderColor: borderColor,
                    pointHoverBackgroundColor:  '#ffffff',
                    borderWidth: 3
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: false
                },
                layout: {
                    padding: {
                        top: 50
                    }
                },
                tooltips: {
                    enabled: false,
                    mode: 'index',
                    position: 'nearest',
                    custom:  function(tooltip) {
                        customTooltips(tooltip, options, ctxBalanceHistory);
                    }
                },
                scales:
                {
                    yAxes: [{
                        stacked: true
                    }],
                    xAxes: [{
                        display:false
                    }]
                }
            }

        });
        $('.balance-table').html(table);
        $('.balance-history').removeClass('loading');
    }

    var error = function(error) {
        $.each(error.responseJSON.errors, function(index, value) {
            console.log(value);
        })
    }

    $.ajax({
        url: '/response/balanceHistory',
        headers: headers,
        type: 'POST',
        datatype: 'json',
        data: data,
        success:  success,
        error :  error
   });

}

$('#detalization .btn').click(function() {
    var range = $(this).find('input').val();
    $(this).button('Загрузка');
    drawHistory(range, $(this));
})

drawHistory(7);
