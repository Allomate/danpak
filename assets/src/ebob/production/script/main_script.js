$(document).ready(function(){

	var pendingComplains = 0;
	var resolvedComplains = 0;

	getSatisfactionRatio();

	var handleRewardDiscountLineChart = function(chartData) {
		var green = '#0D888B';
		var greenLight = '#00ACAC';
		var blue = '#3273B1';
		var blueLight = '#348FE2';
		var blackTransparent = 'rgba(0,0,0,0.6)';
		var whiteTransparent = 'rgba(255,255,255,0.4)';
		Morris.Line({
			element: 'visitors-line-chart',
			data: chartData,
			xkey: 'x',
			ykeys: ['y', 'z'],
			xLabelFormat: function(x) {
				x = getMonthName(x.getMonth());
				return x.toString();
			},
			labels: ['Page Views', 'Unique Visitors'],
			lineColors: [green, blue],
			pointFillColors: [greenLight, greenLight],
			lineWidth: '2px',
			pointStrokeColors: [blackTransparent, blackTransparent],
			resize: true,
			gridTextFamily: 'Open Sans',
			gridTextColor: whiteTransparent,
			gridTextWeight: 'normal',
			gridTextSize: '11px',
			gridLineColor: 'rgba(0,0,0,0.5)',
			hideHover: 'auto',
		});
	};

	fetchRemediesChartData();
	
	$('#employeeIdForRemedies').change(function(){
		fetchRemediesChartData();
	});

	var handleBarChart = function () {
		"use strict";
		$.ajax({
			type:'POST',
			url: "ajax_scripts/getComplainHeadsStats.php",
			success: function(response) {
				var response = JSON.parse(response);
				var testData = [];

				for (var i = 0; i < response.length; i++) {
					var tempArr = new Array();
					tempArr[0] = response[i]["head"];
					tempArr[1] = response[i]["total"];
					testData[i] = tempArr;	
				}

				$.plot("#bar-chart", [ {data: testData, color: purple} ], {
					series: {
						bars: {
							show: true,
							barWidth: 0.4,	
							align: 'center',
							fill: true,
							fillColor: purple,
							zero: true
						}
					},
					xaxis: {
						mode: "categories",
						tickColor: '#ddd',
						tickLength: 0
					},
					grid: {
						borderWidth: 0
					}
				});				

			},
			error:function(jqXHR,textStatus,errorThrown ){
				alert('Exception:'+errorThrown );
			}
		});
	};

	handleBarChart();

	var handleDonutChart = function (pending, resolved, filter) {
		"use strict";
		if (filter == "complain") {
			$('#donut-chart-complain').css('display', '');
			$('#donut-chart-franchise').css('display', 'none');
			var donutData = [{ label: "Pending",  data: pending, color: purpleDark},
			{ label: "Resolved",  data: resolved, color: purple}];
			$.plot('#donut-chart-complain', donutData, {
				series: {
					pie: {
						innerRadius: 0.5,
						show: true,
						label: {
							show: true
						}
					}
				},
				legend: {
					show: true
				}
			});
		}else if(filter == "franchise"){
			$('#donut-chart-complain').css('display', 'none');
			$('#donut-chart-franchise').css('display', '');
			$.ajax({
				type:'POST',
				url: "ajax_scripts/getFranchiseForChartFilter.php",
				success: function(data) {
					var data = JSON.parse(data);
					var donutData = [];
					var colorsArray = ["#617aa3", "#4286f4", "#afbfd8", "#092044", "#818791"];
					for (var i = 0; i < data["franchise"].length; i++) {
						var tempArr = [];
						tempArr['label'] = data["franchise"][i];
						tempArr['data'] = data["totalComplains"][i];
						tempArr['color'] = colorsArray[i];
						donutData[i] = tempArr;
					}
					$.plot('#donut-chart-franchise', donutData, {
						series: {
							pie: {
								innerRadius: 0.5,
								show: true,
								label: {
									show: true
								}
							}
						},
						legend: {
							show: true
						}
					});
				},
				error:function(jqXHR,textStatus,errorThrown ){
					alert('Exception:'+errorThrown );
				}
			}); 
		}else if(filter == "city"){
			$('#donut-chart-city').css('display', '');
			$('#donut-chart-region').css('display', 'none');
			$.ajax({
				type:'POST',
				url: "ajax_scripts/getCitiesForChartFilter.php",
				success: function(data) {
					var data = JSON.parse(data);
					var donutData = [];
					var doneComplains = [];
					var doneCities = [];
					var colorsArray = ["#617aa3", "#4286f4", "#afbfd8", "#092044", "#818791"];
					for (var i = 0; i < data.length; i++) {
						var tempArr = [];
						if(i != 0){
							var city = data[i]["city"].toLowerCase();
							var lowerCaseCities = $.map(doneCities, function(n,i){return n.toLowerCase();});
							var found = lowerCaseCities.indexOf(city);
							if(found >= 0){
								doneCities[i] = "";
								doneComplains[i] = "";
								donutData[found]["data"] += data[i]["complains"];
							}else{
								doneCities[i] = data[i]["city"];
								doneComplains[i] = data[i]["complains"];
							}
						}else{
							doneCities[i] = data[i]["city"];
							doneComplains[i] = data[i]["complains"];
						}
						var testA = doneCities[i];
						var testB = doneComplains[i];
						tempArr['label'] = testA;
						tempArr['data'] = testB;
						tempArr['color'] = colorsArray[i];
						donutData[i] = tempArr;
					}
					$.plot('#donut-chart-city', donutData, {
						series: {
							pie: {
								innerRadius: 0.5,
								show: true,
								label: {
									show: true
								}
							}
						},
						legend: {
							show: true
						}
					});
				},
				error:function(jqXHR,textStatus,errorThrown ){
					alert('Exception:'+errorThrown );
				}
			}); 
		}else if(filter == "region"){
			$('#donut-chart-city').css('display', 'none');
			$('#donut-chart-region').css('display', '');
			$.ajax({
				type:'POST',
				url: "ajax_scripts/getRegionsForChartFilter.php",
				success: function(data) {
					var data = JSON.parse(data);
					var donutData = [];
					var doneComplains = [];
					var doneCities = [];
					console.log(data);
					var colorsArray = ["#617aa3", "#4286f4", "#afbfd8", "#092044", "#818791"];
					for (var i = 0; i < data.length; i++) {
						var colorsArray = ["#617aa3", "#4286f4", "#afbfd8", "#092044", "#818791"];
						var tempArr = [];

						tempArr['label'] = data[i]["region"];
						tempArr['data'] = data[i]["totalComplains"];
						tempArr['color'] = colorsArray[i];
						donutData[i] = tempArr;
					}

					$.plot('#donut-chart-region', donutData, {
						series: {
							pie: {
								innerRadius: 0.5,
								show: true,
								label: {
									show: true
								}
							}
						},
						legend: {
							show: true
						}
					});
				},
				error:function(jqXHR,textStatus,errorThrown ){
					alert('Exception:'+errorThrown );
				}
			}); 
		}
		hideLoader();
	};

	$('#filterDD').change(function(){
		if($(this).val() == "complain"){
			handleDonutChart(pendingComplains, resolvedComplains, "complain");
		}else if($(this).val() == "franchise"){
			handleDonutChart(pendingComplains, resolvedComplains, "franchise");
		}
	});

	$('#cityRegionFilter').change(function(){
		if($(this).val() == "city"){
			handleDonutChart(pendingComplains, resolvedComplains, "city");
		}else if($(this).val() == "region"){
			handleDonutChart(pendingComplains, resolvedComplains, "region");
		}
	});

	showLoader();

	$.ajax({
		type:'POST',
		url: "ajax_scripts/getTatOverComplains.php",
		success: function(data) {
			if(data != null && data != "")
				$('#tatOverComplains').html(data);
			else
				$('#tatOverComplains').html(data);
		}
	});

	$.ajax({
		type:'POST',
		url: "ajax_scripts/getAvgTatComplains.php",
		success: function(data) {
			if(data == null || data == "")
				data = 0;
			data = parseInt(data);
			$('#avgTatResolutionTime').html(data);
		}
	});

	$.ajax({
		type:'POST',
		url: "ajax_scripts/getComplainsInfo.php",
		success: function(data) {
			var data = JSON.parse(data);
			$('#totalComplains').html(data[0]["complains"]+data[1]["complains"]);
			if(data[0]["status"] == "pending"){
				$('#pendingComplains').html(data[0]["complains"]);
				pendingComplains = data[0]["complains"];
			}else{
				$('#resolvedComplains').html(data[0]["complains"]);
				resolvedComplains = data[0]["complains"];
			}

			if(data[1]["status"] == "resolved"){
				$('#resolvedComplains').html(data[1]["complains"]);
				resolvedComplains = data[1]["complains"];
			}else{
				$('#pendingComplains').html(data[1]["complains"]);
				pendingComplains = data[0]["complains"];
			}
			handleDonutChart(pendingComplains, resolvedComplains, "complain");
			handleDonutChart(pendingComplains, resolvedComplains, "city");
		},
		error:function(jqXHR,textStatus,errorThrown ){
			alert('Exception:'+errorThrown );
		}
	});

	function fetchRemediesChartData(){
		$.ajax({
			type: 'POST',
			url: './ajax_scripts/getRewardDiscountLineChartData.php',
			data: { empId: $('#employeeIdForRemedies').val() },
			success: function(data){
				var data = JSON.parse(data);
				var dateOfRec = [];
				var discounts = [];
				var rewardPoints = [];
				for (var i = 0; i < data.length; i++) {
					dateOfRec[i] = data[i]["date"];
					discounts[i] = data[i]["discount"];
					rewardPoints[i] = data[i]["rewards"];
				}
				var rewardDiscountLineChartData = [];
				for (var i = 0; i < dateOfRec.length; i++) {
					var tempArr = [];
					tempArr['x'] = dateOfRec[i];
					tempArr['y'] = discounts[i];
					tempArr['z'] = rewardPoints[i];
					rewardDiscountLineChartData[i] = tempArr;
				}
				handleRewardDiscountLineChart(rewardDiscountLineChartData);

				$.ajax({
					type: 'POST',
					url: './ajax_scripts/getRemediesDetails.php',
					data: { employee: $('#employeeIdForRemedies').val() },
					success: function(data){
						var data = JSON.parse(data);
						$('#totalRemedies').html(data["total"]);
						$('#totalRewards').html(data["rewards"]);
						$('#totalDiscounts').html(data["discounts"]);
					}
				});

				$.ajax({
					type: 'POST',
					url: './ajax_scripts/getCrankCustomers.php',
					success: function(data){
						$('#crankCustomers').html(data);
					}
				});

			}
		});
	}

	function getSatisfactionRatio(){
		$.ajax({
			type: 'POST',
			url: './ajax_scripts/getCustomerSatisfactionRatio.php',
			success: function(data){
				$('#customerSatisfactionRatio').html("");
				$('#customerSatisfactionRatio').html(data);				
			}
		});		
	}

	function showLoader(){
		$('#page-loader').removeClass();
		$('#page-loader').addClass('fade');
		$('#page-loader').addClass('in');
	}

	function hideLoader(){
		$('#page-loader').removeClass();
		if(!$('#page-loader').hasClass('fade')){
			$('#page-loader').addClass('fade');
		}
	}

});