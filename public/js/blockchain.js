$(document).ready(function(){
    $('.balance-chart-description').css('opacity', 1);
    var ctx = document.getElementById("balance-chart").getContext('2d');

    //HFTColor
    var HFTColor = ctx.createLinearGradient(100, 0, 500, 500);
    HFTColor.addColorStop(0, "#fed593");
    HFTColor.addColorStop(1, "#ff7e00");
    //bitcoinColor
    var BitcoinColor = ctx.createLinearGradient(100, 0, 500, 500);
    BitcoinColor.addColorStop(0, "#00c6b0");
    BitcoinColor.addColorStop(1, "#b8dfdc");
    //EthereumColor
    var EthereumColor = ctx.createLinearGradient(100, 0, 0, 500);
    EthereumColor.addColorStop(0, "#e3e3ff");
    EthereumColor.addColorStop(1, "#5252fa");
    //USDColor
    var USDColor = ctx.createLinearGradient(100, 0, 0, 500);
    USDColor.addColorStop(0, "#aed9ff");
    USDColor.addColorStop(1, "#4092fe");
    var balanceChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["HFT", "BTC", "ETH", "USD"],
            datasets: [{
                data: [12, 19, 3, 5],
                backgroundColor: [
                    HFTColor,
                    BitcoinColor,
                    EthereumColor,
                    USDColor
                ],
                hoverBackgroundColor: [
                    '#ff7e00',
                    '#00c6b0',
                    '#5252fa',
                    '#4092fe'
                ],
                borderWidth: 0
            }]
        },
        options: {
            cutoutPercentage: 65,
            responsive: true,
            legend: {
                display: false,
            },
            hover: {
              onHover: function(e) {
                 var point = this.getElementAtEvent(e);
                 if (point.length) e.target.style.cursor = 'pointer';
                 else e.target.style.cursor = 'default';
              }
            },
            title: {
                display: true
            },
            animation: {
                animateScale: true,
                animateRotate: true
            }
        },

    });
    document.getElementById('balance-chart-legend').innerHTML = balanceChart.generateLegend();

    //currency charts
    var ctxCurrency = document.getElementById("currency-chart").getContext('2d');

    var BTCColor = ctxCurrency.createLinearGradient(500, 800, 0, 0);
    BTCColor.addColorStop(1, "#ffc58b");
    BTCColor.addColorStop(0, "#ffe1a7");
    //bitcoinColor
    var BTCBorderColor = ctxCurrency.createLinearGradient(400, 0, 0, 0);
    BTCBorderColor.addColorStop(0, "#ffbf45");
    BTCBorderColor.addColorStop(1, "#ff8309");

    var btcTimeline = ['items','labels'];
    let promise = new Promise((resolve, reject) => {
        $.getJSON( "https://coincap.io/history/1day/ETH", function( data ) {
          var items = new Object();
          var today = new Date();
          today.setDate(today.getDate() - 1);
          items.values = [];
          items.labels = [];
          var options = {
            month: 'short',
            day: 'numeric',
            hour: 'numeric',
            minute: 'numeric'
          };
          $.each( data.price, function( key, val ) {
            if(key%12==0) {
                items.values.push(val[1]);
                today.setMinutes(today.getMinutes() + 60);
                items.labels.push(today.toLocaleString("ru", options));
            }
          });
          resolve(items);
        });
    });
    promise
  .then(
    result => {
        console.log(result);
        var currencyChart = new Chart(ctxCurrency, {
            type: 'line',
            data: {
                labels: result.labels,
                datasets: [{
                    label: 'Цена',
                    borderColor: BTCBorderColor,
                    backgroundColor: BTCColor,
                    fill: true,
                    data: result.values,
                    pointRadius: 0,
                    pointHitRadius: 10,
                    pointBackgroundColor: BTCColor,
                    pointBorderColor: 'rgba(255,255,255,1)',
                    pointBorderWidth: 6,
                    pointHoverRadius: 12,
                    pointHoverBackgroundColor: '#ff8006',
                    borderWidth: 5
                }]
            },
            options: {
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
                    callbacks: {
                       label: function(tooltipItem) {
                              return tooltipItem.yLabel;
                       }
                    }
                },
                scales:
                {
                    yAxes: [{
                        display: false
                    }],
                    xAxes: [{
                        display: false
                    }]
                }
            }

        });

    },
    error => {
      // вторая функция - запустится при вызове reject
      alert("Rejected: " + error); // error - аргумент reject
    }
  );
})
