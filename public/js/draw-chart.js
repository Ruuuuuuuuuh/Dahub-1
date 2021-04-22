function drawPrice(options) {
    var ctxCurrency = document.getElementById(options.name).getContext('2d');
    ctxCurrency.height = options.height;

    var bgColor = ctxCurrency.createLinearGradient(500, 800, 0, 0);
    bgColor.addColorStop(1, options.bgColorStart);
    bgColor.addColorStop(0, options.bgColorEnd);
    //bitcoinColor
    var borderColor = ctxCurrency.createLinearGradient(400, 0, 0, 0);
    borderColor.addColorStop(0, options.bgBorderColorEnd);
    borderColor.addColorStop(1, options.bgBorderColorStart);

    var btcTimeline = ['items','labels'];
    let promise = new Promise((resolve, reject) => {
        $.getJSON( "https://coincap.io/history/1day/" + options.currency, function( data ) {
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
                items.labels.push('$ ' + val[1].toFixed(2) + '<br />' + today.toLocaleString("ru", options));
            }
          });
          resolve(items);
        });
    });
    promise
  .then(
    result => {
        var currencyChart = new Chart(ctxCurrency, {
            type: 'line',
            data: {
                labels: result.labels,
                datasets: [{
                    label: false,
                    borderColor: borderColor,
                    backgroundColor: bgColor,
                    fill: true,
                    data: result.values,
                    pointRadius: 0,
                    pointHitRadius: 10,
                    pointBackgroundColor: bgColor,
                    pointBorderColor: 'rgba(255,255,255,1)',
                    pointBorderWidth: 6,
                    pointHoverRadius: 12,
                    pointHoverBackgroundColor: options.bgBorderColorEnd,
                    borderWidth: 5
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
                        customTooltips(tooltip, options, ctxCurrency);
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
      console.log("Rejected: " + error); // error - аргумент reject
    }
  );
  return ctxCurrency;
}

function drawPriceHFT(options) {

    var ctxCurrency = document.getElementById(options.name).getContext('2d');
    ctxCurrency.height = options.height;

    var bgColor = ctxCurrency.createLinearGradient(500, 800, 0, 0);
    bgColor.addColorStop(1, options.bgColorStart);
    bgColor.addColorStop(0, options.bgColorEnd);
    //bitcoinColor
    var borderColor = ctxCurrency.createLinearGradient(400, 0, 0, 0);
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
    var currencyChart = new Chart(ctxCurrency, {
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
                pointHitRadius: 10,
                pointBackgroundColor: bgColor,
                pointBorderColor: 'rgba(255,255,255,1)',
                pointBorderWidth: 6,
                pointHoverRadius: 12,
                pointHoverBackgroundColor: options.bgColorStart,
                borderWidth: 5
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
                    customTooltips(tooltip, options, ctxCurrency);
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
  return ctxCurrency;
}


var customTooltips = function(tooltip, options, ctxCurrency) {
	// Tooltip Element
    selector = 'chartjs-tooltip-' + options.name;
	var tooltipEl = document.getElementById(selector);

	// Hide if no tooltip
	if (tooltip.opacity === 0) {
		tooltipEl.style.opacity = 0;
		return;
	}

	// Set caret Position
	tooltipEl.classList.remove('above', 'below', 'no-transform');
	if (tooltip.yAlign) {
		tooltipEl.classList.add(tooltip.yAlign);
	} else {
		tooltipEl.classList.add('no-transform');
	}

	function getBody(bodyItem) {
		return bodyItem.lines;
	}

	// Set Text
	if (tooltip.body) {
		var titleLines = tooltip.title || [];
		var bodyLines = tooltip.body.map(getBody);

		var innerHtml = '<thead>';

		titleLines.forEach(function(title) {
			innerHtml += '<tr style="color:' + options.bgBorderColorEnd + '"><th>' + title + '</th></tr>';
		});
		innerHtml += '</thead><tbody>';

		bodyLines.forEach(function(body, i) {
			var colors = tooltip.labelColors[i];
			var style = 'background:' + colors.backgroundColor;
			style += '; border-color:' + colors.borderColor;
			style += '; border-width: 2px';
			var span = '<span class="chartjs-tooltip-key" style="' + style + '"></span>';
			innerHtml += '<tr><td>' + span + body + '</td></tr>';
		});
		innerHtml += '</tbody>';

		var tableRoot = tooltipEl.querySelector('table');
		tableRoot.innerHTML = innerHtml;
	}

    var positionY = ctxCurrency.canvas.offsetTop;
	var positionX = ctxCurrency.canvas.offsetLeft;

	// Display, position, and set styles for font
	tooltipEl.style.opacity = 1;
	tooltipEl.style.left = positionX + tooltip.caretX + 'px';
	tooltipEl.style.top = positionY + tooltip.caretY - 65 + 'px';
	tooltipEl.style.fontFamily = tooltip._bodyFontFamily;
	tooltipEl.style.fontSize = tooltip.bodyFontSize;
	tooltipEl.style.fontStyle = tooltip._bodyFontStyle;
	tooltipEl.style.padding = tooltip.yPadding + 'px ' + tooltip.xPadding + 'px';
};
