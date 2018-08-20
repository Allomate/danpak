<?php require_once(APPPATH.'/views/includes/header.php'); ?>
<link href="<?= base_url('assets/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css'); ?>" rel="stylesheet"
type="text/css">
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once(APPPATH.'/views/includes/navbar&sidebar.php'); ?>
	<div class="page-wrapper p-b-20">
		<div class="container-fluid">
			<div class="row mt-15">
				<div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
					<div class="panel panel-default card-view pa-0 emp-stats">
						<div class="container-fluid">
							<div class="row">
								<div class="col-sm-7 col-xs-8 text-center pl-0 pr-0 data-wrap-left">
									<span class="txt-dark block counter counter-anim">125</span>
									<span class="weight-500 uppercase-font block">MTD Sale</span>
								</div>
								<div class="col-sm-5ss col-xs-4 text-center pl-0 pr-0">
									<img src="<?= base_url('assets/images/icon-all-sale.svg'); ?>" alt="brand">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 ">
					<div class="panel panel-default card-view pa-0 emp-stats">
						<div class="container-fluid">
							<div class="row">
								<div class="col-sm-7 col-xs-8 text-center pl-0 pr-0 data-wrap-left">
									<span class="txt-dark block counter counter-anim">375</span>
									<span class="weight-500 uppercase-font block font-13">Sales Target</span>
								</div>
								<div class="col-sm-5 col-xs-4 text-center  pl-0 pr-0">
									<img src="<?= base_url('assets/images/icon-all-order.svg'); ?>" alt="brand">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 ">
					<div class="panel panel-default card-view pa-0 emp-stats">
						<div class="container-fluid">
							<div class="row">
								<div class="col-sm-7 col-xs-8 text-center pl-0 pr-0 data-wrap-left">
									<span class="txt-dark block counter counter-anim">475</span>
									<span class="weight-500 uppercase-font block font-13">Target Deficit</span>
								</div>
								<div class="col-sm-5 col-xs-4 text-center  pl-0 pr-0">
									<img src="<?= base_url('assets/images/icon-order-done.svg'); ?>" alt="brand">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
					<div class="panel panel-default card-view pa-0 emp-stats">
						<div class="container-fluid">
							<div class="row">
								<div class="col-sm-7 col-xs-8 text-center pl-0 pr-0 data-wrap-left">
									<span class="txt-dark block counter counter-anim">800</span>
									<span class="weight-500 uppercase-font block font-13">Projected MTD Sale</span>
								</div>
								<div class="col-sm-5 col-xs-4 text-center  pl-0 pr-0">
									<img src="<?= base_url('assets/images/icon-active-devices.svg'); ?>" alt="brand">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
					<div class="panel panel-default card-view w-box-sec" style="min-height: 471px">
						<div class="panel-heading">
							<div class="pull-left">
								<h6 class="panel-title txt-dark">Sales Analytics</h6>
							</div>
							<div class="pull-right m-r-10">
								<div class="pull-left form-group mb-0 sm-bootstrap-select mr-15 pt-5">
									<select class="selectpicker" data-style="form-control">
										<option selected value='1'>Janaury</option>
										<option value='2'>February</option>
										<option value='3'>March</option>
										<option value='4'>April</option>
										<option value='5'>May</option>
										<option value='6'>June</option>
										<option value='7'>July</option>
										<option value='8'>August</option>
										<option value='9'>September</option>
										<option value='10'>October</option>
										<option value='11'>November</option>
										<option value='12'>December</option>
									</select>
								</div>
								<a href="#" class="pull-left inline-block refresh mr-15">
									<i class="zmdi zmdi-replay"></i>
								</a>
								<a href="#" class="pull-left inline-block full-screen mr-15">
									<i class="zmdi zmdi-fullscreen"></i>
								</a>
								<div class="pull-left inline-block dropdown">
									<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" role="button">
										<i class="zmdi zmdi-more-vert"></i>
									</a>
									<ul class="dropdown-menu bullet dropdown-menu-right" role="menu">
										<li role="presentation">
											<a href="javascript:void(0)" role="menuitem">
												<i class="icon wb-reply" aria-hidden="true"></i>By Territory</a>
										</li>
										<li role="presentation">
											<a href="javascript:void(0)" role="menuitem">
												<i class="icon wb-share" aria-hidden="true"></i>By Regin</a>
										</li>
										<li role="presentation">
											<a href="javascript:void(0)" role="menuitem">
												<i class="icon wb-trash" aria-hidden="true"></i>By Area</a>
										</li>
									</ul>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="panel-wrapper collapse in">
							<div class="panel-body p-0">
								<div id="columnchart_material" style="width: 100%; height:400px"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
					<div class="panel panel-default card-view pa-0 emp-stats">
						<div class="container-fluid">
							<div class="row">
								<div class="col-sm-7 col-xs-8 text-center pl-0 pr-0 data-wrap-left">
									<span class="txt-dark block counter counter-anim">800</span>
									<span class="weight-500 uppercase-font block font-13">Total Profit</span>
								</div>
								<div class="col-sm-5 col-xs-4 text-center  pl-0 pr-0">
									<img src="<?= base_url('assets/images/icon-active-devices.svg'); ?>" alt="brand">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
					<div class="panel panel-default card-view pa-0 emp-stats">
						<div class="container-fluid">
							<div class="row">
								<div class="col-sm-7 col-xs-8 text-center pl-0 pr-0 data-wrap-left">
									<span class="txt-dark block counter counter-anim">800</span>
									<span class="weight-500 uppercase-font block font-13">Total Orders</span>
								</div>
								<div class="col-sm-5 col-xs-4 text-center  pl-0 pr-0">
									<img src="<?= base_url('assets/images/icon-active-devices.svg'); ?>" alt="brand">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
					<div class="panel panel-default card-view pa-0 emp-stats">
						<div class="container-fluid">
							<div class="row">
								<div class="col-sm-7 col-xs-8 text-center pl-0 pr-0 data-wrap-left">
									<span class="txt-dark block counter counter-anim">800</span>
									<span class="weight-500 uppercase-font block font-13">Total Retail Visits</span>
								</div>
								<div class="col-sm-5 col-xs-4 text-center  pl-0 pr-0">
									<img src="<?= base_url('assets/images/icon-active-devices.svg'); ?>" alt="brand">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
					<div class="panel panel-default card-view pa-0 emp-stats">
						<div class="container-fluid">
							<div class="row">
								<div class="col-sm-7 col-xs-8 text-center pl-0 pr-0 data-wrap-left">
									<span class="txt-dark block counter counter-anim">800</span>
									<span class="weight-500 uppercase-font block font-13">Orders Success Ratio</span>
								</div>
								<div class="col-sm-5 col-xs-4 text-center  pl-0 pr-0">
									<img src="<?= base_url('assets/images/icon-active-devices.svg'); ?>" alt="brand">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<div class="panel panel-default card-view w-box-sec">
						<div class="panel-heading">
							<div class="pull-left">
								<h6 class="panel-title txt-dark">Top Product Sales</h6>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="panel-wrapper collapse in">
							<div class="panel-body p-t-0">
								<span class="font-12 head-font txt-dark">Chocolate
									<span class="pull-right">85%</span>
								</span>
								<div class="progress mt-10 mb-25">
									<div class="progress-bar progress-bar-info" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 85%" role="progressbar">
										<span class="sr-only">85% Complete (success)</span>
									</div>
								</div>
								<span class="font-12 head-font txt-dark">Candy Red
									<span class="pull-right">80%</span>
								</span>
								<div class="progress mt-10 mb-25">
									<div class="progress-bar progress-bar-success" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 80%"
									role="progressbar">
										<span class="sr-only">85% Complete (success)</span>
									</div>
								</div>
								<span class="font-12 head-font txt-dark">Candy Big
									<span class="pull-right">70%</span>
								</span>
								<div class="progress mt-10 mb-25">
									<div class="progress-bar progress-bar-danger" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 70%"
									role="progressbar">
										<span class="sr-only">85% Complete (success)</span>
									</div>
								</div>
								<span class="font-12 head-font txt-dark">Candy Chocolate
									<span class="pull-right">45%</span>
								</span>
								<div class="progress mt-10 mb-25">
									<div class="progress-bar progress-bar-inverse" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 45%"
									role="progressbar">
										<span class="sr-only">85% Complete (success)</span>
									</div>
								</div>
								<span class="font-12 head-font txt-dark">Small Candy
									<span class="pull-right">80%</span>
								</span>
								<div class="progress mt-10 mb-25">
									<div class="progress-bar progress-bar-success" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%"
									role="progressbar">
										<span class="sr-only">80% Complete (success)</span>
									</div>
								</div>
								<span class="font-12 head-font txt-dark">Chocolate
									<span class="pull-right">85%</span>
								</span>
								<div class="progress mt-10 mb-25">
									<div class="progress-bar progress-bar-info" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 85%" role="progressbar">
										<span class="sr-only">85% Complete (success)</span>
									</div>
								</div>
								<span class="font-12 head-font txt-dark">Candy Red
									<span class="pull-right">80%</span>
								</span>
								<div class="progress mt-10 mb-25">
									<div class="progress-bar progress-bar-success" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 80%"
									role="progressbar">
										<span class="sr-only">85% Complete (success)</span>
									</div>
								</div>
								<span class="font-12 head-font txt-dark">Candy Big
									<span class="pull-right">70%</span>
								</span>
								<div class="progress mt-10 mb-25">
									<div class="progress-bar progress-bar-danger" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 70%"
									role="progressbar">
										<span class="sr-only">85% Complete (success)</span>
									</div>
								</div>
								<span class="font-12 head-font txt-dark">Candy Chocolate
									<span class="pull-right">45%</span>
								</span>
								<div class="progress mt-10 mb-25">
									<div class="progress-bar progress-bar-inverse" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 45%"
									role="progressbar">
										<span class="sr-only">85% Complete (success)</span>
									</div>
								</div>
								<span class="font-12 head-font txt-dark">Small Candy
									<span class="pull-right">80%</span>
								</span>
								<div class="progress mt-10">
									<div class="progress-bar progress-bar-success" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%"
									role="progressbar">
										<span class="sr-only">80% Complete (success)</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<div class="panel panel-default card-view panel-refresh w-box-sec" style=" ">
						<div class="refresh-container">
							<div class="la-anim-1"></div>
						</div>
						<div class="panel-heading">
							<div class="pull-left">
								<h6 class="panel-title txt-dark">Products By Category</h6>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="panel-wrapper collapse in">
							<div class="panel-body row">
								<div class="col-sm-6 pa-0">
									<div id="e_chart_3" class="" style="height:185px;"></div>
								</div>
								<div class="col-sm-6 pr-0">
									<div class="label-chatrs">
										<div class="p-10" style="padding-top:4px!important;">
											<span class="clabels circular-clabels inline-block darkblueBG mr-5"></span>
											<span class="clabels-text font-12 inline-block txt-dark capitalize-font">BLUEBERRY CANDY BARS</span>
										</div>
										<div class="p-10">
											<span class="clabels circular-clabels inline-block redBG mr-5"></span>
											<span class="clabels-text font-12 inline-block txt-dark capitalize-font">BUTTER SCOTCH CANDY</span>
										</div>
										<div class="p-10">
											<span class="clabels circular-clabels inline-block blueBG mr-5"></span>
											<span class="clabels-text font-12 inline-block txt-dark capitalize-font">CHINI MINI JAR</span>
										</div>
										<div class="p-10">
											<span class="clabels circular-clabels inline-block bg-gray mr-5"></span>
											<span class="clabels-text font-12 inline-block txt-dark capitalize-font">BUBBLE BOOM JAR</span>
										</div>
										<div class="p-10">
											<span class="clabels circular-clabels inline-block bg-gray mr-5"></span>
											<span class="clabels-text font-12 inline-block txt-dark capitalize-font">BUBBLE BOOM JAR</span>
										</div>
										<div class="p-10">
											<span class="clabels circular-clabels inline-block bg-gray mr-5"></span>
											<span class="clabels-text font-12 inline-block txt-dark capitalize-font">BUBBLE BOOM JAR</span>
										</div>
										<div class="p-10">
											<span class="clabels circular-clabels inline-block bg-gray mr-5"></span>
											<span class="clabels-text font-12 inline-block txt-dark capitalize-font">BUBBLE BOOM JAR</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="panel panel-default card-view w-box-sec" style="min-height:292px;">
						<div class="panel-wrapper collapse in">
							<div class="panel-body sm-data-box-1 pt-0 pb-20">
								<div class="pull-left">
									<h6 class="panel-title txt-dark p-0">Average Sale/day</h6>
								</div>
								<div class="clearfix"></div>
								<div class="cus-sat-stat weight-500 txt-info text-center mt-30">
									<span class="counter-anim">70.13</span>
									<span>%</span>
								</div>
								<div class="progress-anim mt-5">
									<div class="progress">
										<div class="progress-bar progress-bar-info
							wow animated progress-animated" role="progressbar" aria-valuenow="70.13" aria-valuemin="0" aria-valuemax="100"></div>
									</div>
								</div>
								<ul class="flex-stat mt-5">
									<li>
										<span class="block">Average Sale Employee</span>
										<span class="block txt-dark weight-500 font-15">79.82%</span>
									</li>
									<li class="float-R">
										<span class="block">Average Sale Retail</span>
										<span class="block txt-dark weight-500 font-15">+14.29%</span>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
					<div class="panel panel-default card-view panel-refresh w-box-sec" style="min-height:333px;">
						<div class="refresh-container">
							<div class="la-anim-1"></div>
						</div>
						<div class="panel-heading">
							<div class="pull-left">
								<h6 class="panel-title txt-dark">Top XX</h6>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="panel-wrapper collapse in">
							<div class="panel-body row">
								<div class="col-sm-6 pa-0">
									<div id="e_chart_2" class="" style="height:185px;"></div>
								</div>
								<div class="col-sm-6 pr-0 pt-25">
									<div class="label-chatrs">
										<div class="mb-5">
											<span class="clabels inline-block blueBG mr-5"></span>
											<span class="clabels-text font-12 inline-block txt-dark capitalize-font">CHOCO HEART JAR</span>
										</div>
										<div class="mb-5">
											<span class="clabels inline-block redBG mr-5"></span>
											<span class="clabels-text font-12 inline-block txt-dark capitalize-font">BUTTER SCOTCH CANDY</span>
										</div>
										<div class="mb-5">
											<span class="clabels inline-block darkblueBG mr-5"></span>
											<span class="clabels-text font-12 inline-block txt-dark capitalize-font">CHINI MINI JAR</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="panel panel-default card-view sm-data-box-3 w-box-sec" style="min-height:333px;">
						<div class="panel-heading">
							<div class="pull-left">
								<h6 class="panel-title txt-dark">Sales Daily</h6>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="panel-wrapper collapse in">
							<div class="panel-body">
								<div class="col-sm-6 pa-0">
									<span id="pie_chart_4" class="easypiechart" data-percent="33">
										<span class="percent block txt-dark weight-500"></span>
										<span class="block darkbluetext text-center">
											<i class="zmdi zmdi-caret-up pr-5 font-20"></i>
											<span class="weight-500">+33%</span>
										</span>
									</span>
								</div>
								<div class="col-sm-6 pr-0">
									<ul class="flex-stat mb-15">
										<li class="text-left block no-float full-width mb-15">
											<span class="block">Cart Abandonment</span>
											<span class="block txt-dark weight-500  font-18">
												<span class="counter-anim">73</span>%</span>
											<span class="block darkbluetext pull-left mt-5">
												<i class="zmdi zmdi-caret-up pr-5 font-20 pull-left"></i>
												<span class="weight-500 pull-left">+15%</span>
											</span>
											<div class="clearfix"></div>
										</li>
										<li class="text-left block no-float full-width">
											<span class="block">Revenue Left</span>
											<span class="block txt-dark weight-500  font-18">Rs:
												<span class="counter-anim">12,432</span>
											</span>
											<span class="block darkbluetext pull-left mt-5">
												<i class="zmdi zmdi-caret-up pr-5 font-20 pull-left"></i>
												<span class="weight-500 pull-left">+4%</span>
											</span>
											<div class="clearfix"></div>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<footer class="footer" style="position: relative !important;">
	<div class="container">
		<div class="row">
			<div class="col-md-12 align-center">
				<p>2018 &copy; Allomate All rights reserved</p>
			</div>
		</div>
	</div>
</footer>
<?php //require_once(APPPATH.'/views/includes/footer.php'); ?>
<script src="<?= base_url('assets/vendors/bower_components/jquery/dist/jquery.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?= base_url('assets/dist/js/jquery.slimscroll.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/bower_components/moment/min/moment.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/bower_components/simpleWeather/jquery.simpleWeather.min.js'); ?>"></script>
<script src="<?= base_url('assets/dist/js/simpleweather-data.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/bower_components/waypoints/lib/jquery.waypoints.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/bower_components/jquery.counterup/jquery.counterup.min.js'); ?>"></script>
<script src="<?= base_url('assets/dist/js/dropdown-bootstrap-extended.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/jquery.sparkline/dist/jquery.sparkline.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/bower_components/owl.carousel/dist/owl.carousel.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/chart.js/Chart.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/bower_components/echarts/dist/echarts-en.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/echarts-liquidfill.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/bower_components/switchery/dist/switchery.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.min.js'); ?>"></script>
<script src="<?= base_url('assets/dist/js/init.js'); ?>"></script>
<script src="<?= base_url('assets/dist/js/ecommerce-data.js'); ?>"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
	google.charts.load('current', {
		'packages': ['bar']
	});
	google.charts.setOnLoadCallback(drawChart);
	window.addEventListener('resize', drawChart, false);

	function drawChart() {
		var data = google.visualization.arrayToDataTable([
			['Monthly Sales & Profit', 'Actual Sales', 'Expected Sales', 'Profit'],
			['January', 1000, 400, 200],
			['February', 1170, 460, 250],
			['March', 660, 1120, 300],
			['April', 1030, 540, 350],
			['May', 1030, 540, 350],
			['June', 1030, 540, 350]
		]);

		var options = {
			chart: {
				//title: 'Company Performance',
				subtitle: 'Actual Sales, Expected Sales and Profit: 2017-2018',
			}
		};

		var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

		chart.draw(data, google.charts.Bar.convertOptions(options));

	}

</script>
</body>

</html>
