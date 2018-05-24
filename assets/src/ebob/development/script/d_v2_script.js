$(document).ready(function(){

	var handleLiveUpdatedChart = function () {
		"use strict";

		function update() {
			plot.setData([ getRandomData() ]);
			plot.draw();

			setTimeout(update, updateInterval);
		}

		function getRandomData() {
			if (data.length > 0) {
				data = data.slice(1);
			}

			while (data.length < totalPoints) {
				var prev = data.length > 0 ? data[data.length - 1] : 50;
				var y = prev + Math.random() * 10 - 5;
				if (y < 0) {
					y = 0;
				}
				if (y > 100) {
					y = 100;
				}
				data.push(y);
			}

			var res = [];
			for (var i = 0; i < data.length; ++i) {
				res.push([i, data[i]]);
			}
			return res;
		}

		if ($('#live-updated-chart').length !== 0) {
			var data = [], totalPoints = 500;

			var updateInterval = 500;
			$("#updateInterval").val(updateInterval).change(function () {
				var v = $(this).val();
				if (v && !isNaN(+v)) {
					updateInterval = +v;
					if (updateInterval < 1) {
						updateInterval = 1;
					}
					if (updateInterval > 2000) {
						updateInterval = 2000;
					}
					$(this).val("" + updateInterval);
				}
			});

			var options = {
            series: { shadowSize: 0, color: purple, lines: { show: true, fill:true } }, // drawing is faster without shadows
            yaxis: { min: 0, max: 100, tickColor: '#ddd' },
            xaxis: { show: false, tickColor: '#ddd' },
            grid: {
            	borderWidth: 1,
            	borderColor: '#ddd'
            }
        };
        var plot = $.plot($("#live-updated-chart"), [ getRandomData() ], options);
        
        update();
    }
};

var handleMorrisAreaChart = function() {
	Morris.Area({
		element: 'morris-area-chart',
		data: [
		{period: '2010 Q1', iphone: 2666, ipad: null, itouch: 2647},
		{period: '2010 Q2', iphone: 2778, ipad: 2294, itouch: 2441},
		{period: '2010 Q3', iphone: 4912, ipad: 1969, itouch: 2501},
		{period: '2010 Q4', iphone: 3767, ipad: 3597, itouch: 5689},
		{period: '2011 Q1', iphone: 6810, ipad: 1914, itouch: 2293},
		{period: '2011 Q2', iphone: 5670, ipad: 4293, itouch: 1881},
		{period: '2011 Q3', iphone: 4820, ipad: 3795, itouch: 1588},
		{period: '2011 Q4', iphone: 15073, ipad: 5967, itouch: 5175},
		{period: '2012 Q1', iphone: 10687, ipad: 4460, itouch: 2028},
		{period: '2012 Q2', iphone: 8432, ipad: 5713, itouch: 1791}
		],
		xkey: 'period',
		ykeys: ['iphone', 'ipad', 'itouch'],
		labels: ['iPhone', 'iPad', 'iPod Touch'],
		pointSize: 2,
		hideHover: 'auto',
		resize: true,
		lineColors: [red, orange, dark]
	});
};

var handleMorrisDonusChart = function() {
	Morris.Donut({
		element: 'morris-donut-chart',
		data: [
		{label: 'Jam', value: 25 },
		{label: 'Frosted', value: 40 },
		{label: 'Custard', value: 25 },
		{label: 'Sugar', value: 10 }
		],
		formatter: function (y) { return y + "%" },
		resize: true,
		colors: [dark, orange, red, grey]
	});
};

var white = 'rgba(255,255,255,1.0)';
var fillBlack = 'rgba(45, 53, 60, 0.6)';
var fillBlackLight = 'rgba(45, 53, 60, 0.2)';
var strokeBlack = 'rgba(45, 53, 60, 0.8)';
var highlightFillBlack = 'rgba(45, 53, 60, 0.8)';
var highlightStrokeBlack = 'rgba(45, 53, 60, 1)';

var fillBlue = 'rgba(52, 143, 226, 0.6)';
var fillBlueLight = 'rgba(52, 143, 226, 0.2)';
var strokeBlue = 'rgba(52, 143, 226, 0.8)';
var highlightFillBlue = 'rgba(52, 143, 226, 0.8)';
var highlightStrokeBlue = 'rgba(52, 143, 226, 1)';

var fillGrey = 'rgba(182, 194, 201, 0.6)';
var fillGreyLight = 'rgba(182, 194, 201, 0.2)';
var strokeGrey = 'rgba(182, 194, 201, 0.8)';
var highlightFillGrey = 'rgba(182, 194, 201, 0.8)';
var highlightStrokeGrey = 'rgba(182, 194, 201, 1)';

var fillGreen = 'rgba(0, 172, 172, 0.6)';
var fillGreenLight = 'rgba(0, 172, 172, 0.2)';
var strokeGreen = 'rgba(0, 172, 172, 0.8)';
var highlightFillGreen = 'rgba(0, 172, 172, 0.8)';
var highlightStrokeGreen = 'rgba(0, 172, 172, 1)';

var fillPurple = 'rgba(114, 124, 182, 0.6)';
var fillPurpleLight = 'rgba(114, 124, 182, 0.2)';
var strokePurple = 'rgba(114, 124, 182, 0.8)';
var highlightFillPurple = 'rgba(114, 124, 182, 0.8)';
var highlightStrokePurple = 'rgba(114, 124, 182, 1)';

var randomScalingFactor = function() { 
	return Math.round(Math.random()*100)
};

var lineChartData = {
	labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
	datasets: [{
		label: 'Dataset 1',
		borderColor: strokeBlue,
		pointBackgroundColor: strokeBlue,
		pointRadius: 2,
		borderWidth: 2,
		backgroundColor: fillBlueLight,
		data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]
	}, {
		label: 'Dataset 2',
		borderColor: strokeBlack,
		pointBackgroundColor: strokeBlack,
		pointRadius: 2,
		borderWidth: 2,
		backgroundColor: fillBlackLight,
		data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]
	}]
};

var doughnutChartData = {
	labels: ['Purple', 'Blue', 'Green', 'Grey', 'Black'],
	datasets: [{
		data: [300, 50, 100, 40, 120],
		backgroundColor: [fillPurple, fillBlue, fillGreen, fillGrey, fillBlack],
		borderColor: [strokePurple, strokeBlue, strokeGreen, strokeGrey, strokeBlack],
		borderWidth: 2,
		label: 'My dataset'
	}]
};

var handleChartJs = function() {
	var ctx = document.getElementById('line-chart').getContext('2d');
	var lineChart = new Chart(ctx, {
		type: 'line',
		data: lineChartData
	});
    
    var ctx6 = document.getElementById('doughnut-chart').getContext('2d');
    window.myDoughnut = new Chart(ctx6, {
        type: 'doughnut',
        data: doughnutChartData
    });
}

handleLiveUpdatedChart();
handleMorrisAreaChart();
handleMorrisDonusChart();
handleChartJs();
});