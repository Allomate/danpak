<?php
// require 'verify_permission.php';
if (!isset($_COOKIE["US-K"])) {
	header("Location: login.php");
	die;
}
include 'header.php';
?>
<!-- begin #page-loader -->
<div id="page-loader" class="fade in"><span class="spinner"></span></div>
<!-- end #page-loader -->
<!-- begin #page-container -->
<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
	<?php include 'navbar.php';?>
	<?php include 'sidebar.php';?>

	<!-- begin #content -->
	<div id="content" class="content">
		
		<div class="row">
			<div class="col-md-5">
				<div class="panel panel-inverse" data-sortable-id="chart-js-6">
					<div class="panel-heading">
						<div class="panel-heading-btn">
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
						</div>
						<h4 class="panel-title">Doughnut Chart</h4>
					</div>
					<div class="panel-body">
						<p>
							Pie and doughnut charts are registered under two aliases in the Chart core. Other than their different default value, and different alias, they are exactly the same.
						</p>
						<div>
							<canvas id="doughnut-chart" data-render="chart-js"></canvas>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-7">
				<div class="panel panel-inverse" data-sortable-id="chart-js-1">
					<div class="panel-heading">
						<div class="panel-heading-btn">
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
						</div>
						<h4 class="panel-title">Line Chart</h4>
					</div>
					<div class="panel-body">
						<p>
							A line chart is a way of plotting data points on a line.
							Often, it is used to show trend data, and the comparison of two data sets.
						</p>
						<div>
							<canvas id="line-chart" data-render="chart-js"></canvas>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-inverse" data-sortable-id="flot-chart-4">
					<div class="panel-heading">
						<div class="panel-heading-btn">
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
						</div>
						<h4 class="panel-title">Flot Live Updated Chart</h4>
					</div>
					<div class="panel-body">
						<div id="live-updated-chart" class="height-sm"></div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-inverse" data-sortable-id="flot-chart-4">
					<div class="panel-heading">
						<div class="panel-heading-btn">
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
						</div>
						<h4 class="panel-title">Morris Area Chart</h4>
					</div>
					<div class="panel-body">
						<h4 class="text-center">Quarterly Apple iOS device unit sales</h4>
						<div id="morris-area-chart" class="height-sm"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-inverse" data-sortable-id="morris-chart-4">
					<div class="panel-heading">
						<div class="panel-heading-btn">
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
						</div>
						<h4 class="panel-title">Morris Donut Chart</h4>
					</div>
					<div class="panel-body">
						<h4 class="text-center">Donut flavours</h4>
						<div id="morris-donut-chart" class="height-sm"></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- begin scroll to top btn -->
	<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
	<!-- end scroll to top btn -->
</div>

<?php include 'footer.php';?>
<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="assets/plugins/flot/jquery.flot.stack.min.js"></script>
<script src="assets/plugins/flot/jquery.flot.crosshair.min.js"></script>
<script src="assets/plugins/flot/jquery.flot.categories.js"></script>
<script src="assets/js/chart-flot.demo.min.js"></script>
<script src="assets/plugins/bootstrap-calendar/js/bootstrap_calendar.min.js"></script>
<script src="assets/plugins/morris/raphael.min.js"></script>
<script src="assets/plugins/morris/morris.js"></script>
<script src="assets/js/dashboard-v2.js"></script>
<script src="assets/plugins/chart-js/Chart.min.js"></script>
<script src="assets/js/chart-js.demo.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->
<script type="text/javascript" src="script/d_v2_script.js?v=<?php echo time();?>"></script>
<script type="text/javascript" src="script/sidebar-script.js?v=<?php echo time();?>"></script>
<script type="text/javascript">
	$(document).ready(function(){
		App.init();
		$('.nav li').removeClass('active');
		$('#dashboardv2').addClass('active');
	});
</script>