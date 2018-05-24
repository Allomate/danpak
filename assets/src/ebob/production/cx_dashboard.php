<?php
require 'verify_permission.php';
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
		<!-- begin breadcrumb -->
		<ol class="breadcrumb pull-right">
			<li><a href="javascript:;">Home</a></li>
			<li class="active">Dashboard</li>
		</ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header">Dashboard <small>header small text goes here...</small></h1>
		<!-- end page-header -->

<!-- 		<div class="row">
			<div class="form-group">
				<div class="col-md-5">
					<select name="companyId" class="form-control" id="companyDD">
						<?php
						require_once 'database/config.php';
						$sql = "SELECT company_id, company_name from company_info where company_id IN (SELECT company_id from franchise_info group by company_id)";
						$stmt = $conn->prepare($sql);
						$stmt->execute();
						$stmt->bind_result($company_id, $company_name);
						while($stmt->fetch()){?>
						<option value="<?php echo $company_id;?>"> <?php echo $company_name;?> </option>
						<?php }

						$stmt->close();
						?>
					</select>
				</div>
				<div class="col-md-7"></div>
			</div>
		</div>
		<hr> -->
		<div class="row">
			<div class="col-md-4" style="background-color: #2d2d55; height: 200px; padding: 10px">
				<span style="color: white; font-size: 25px">Customer Satisfaction Ratio</span>
				<div style="height: 100%; padding: 22px; font-size: 50px;">
					<span style="color: white; font-weight: bold" id="customerSatisfactionRatio"></span>
				</div>
			</div>
		</div>
		<br>
		<!-- begin row -->
		<div class="row">
			<!-- begin col-3 -->
			<div class="col-md-2 col-sm-6">
				<div class="widget widget-stats bg-green">
					<div class="stats-icon"><i class="fa fa-desktop"></i></div>
					<div class="stats-info">
						<h4>TOTAL COMPLAINS</h4>
						<p id="totalComplains"></p>	
					</div>
					<div class="stats-link">
						<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
					</div>
				</div>
			</div>
			<!-- end col-3 -->
			<!-- begin col-3 -->
			<div class="col-md-2 col-sm-6">
				<div class="widget widget-stats bg-blue">
					<div class="stats-icon"><i class="fa fa-chain-broken"></i></div>
					<div class="stats-info">
						<h4>RESOLVED COMPLAINS</h4>
						<p id="resolvedComplains"></p>
					</div>
					<div class="stats-link">
						<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
					</div>
				</div>
			</div>
			<!-- end col-3 -->
			<!-- begin col-3 -->
			<div class="col-md-2 col-sm-6">
				<div class="widget widget-stats bg-purple">
					<div class="stats-icon"><i class="fa fa-users"></i></div>
					<div class="stats-info">
						<h4>PENDING COMPLAINS</h4>
						<p id="pendingComplains"></p>
					</div>
					<div class="stats-link">
						<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
					</div>
				</div>
			</div>

			<div class="col-md-2 col-sm-6">
				<div class="widget widget-stats bg-red">
					<div class="stats-icon"><i class="fa fa-clock-o"></i></div>
					<div class="stats-info">
						<h4>TAT OVER COMPLAINS</h4>
						<p id="tatOverComplains"></p>
					</div>
					<div class="stats-link">
						<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
					</div>
				</div>
			</div>

			<div class="col-md-2 col-sm-6">
				<div class="widget widget-stats bg-red">
					<div class="stats-icon"><i class="fa fa-clock-o"></i></div>
					<div class="stats-info">
						<h4>AVG. RESOLUTION TIME</h4>
						<p id="avgTatResolutionTime"></p>
					</div>
					<div class="stats-link">
						<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
					</div>
				</div>
			</div>
			<div class="col-md-2 col-sm-6">
				<div class="widget widget-stats bg-blue">
					<div class="stats-icon"><i class="fa fa-chain-broken"></i></div>
					<div class="stats-info">
						<h4>CRANK CUSTOMERS</h4>
						<p id="crankCustomers"></p>
					</div>
					<div class="stats-link">
						<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-8">
				<div class="widget-chart with-sidebar bg-black">
					<div class="widget-chart-content">
						<h4 class="chart-title">
							Remedies by 
							<select style="background-color: #2d353c; border: 0px; padding: 10px; color: white;" id="employeeIdForRemedies">
								<?php
								require_once 'database/config.php';
								$sql = "SELECT employee_id, employee_username from employees_info where company_id IN (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
								$stmt = $conn->prepare($sql);
								$stmt->bind_param('s', $_COOKIE["US-K"]);
								$stmt->execute();
								$stmt->bind_result($empId, $empUsername);
								while($stmt->fetch()){?>
								<option value="<?php echo $empId;?>"> <?php echo $empUsername;?> </option>
								<?php }

								$stmt->close();
								?>
							</select>
							<small>Rewards and discounts given by junaid.qureshi</small>
						</h4>
						<div id="visitors-line-chart" class="morris-inverse" style="height: 260px;"></div>
					</div>
					<div class="widget-chart-sidebar bg-black-darker">
						<div class="chart-number">
							<span id="totalRemedies"></span>
							<small>Total Remedies</small>
						</div>
						<div style="height: 160px; text-align: center">
							<img src="assets/img/user-14.jpg" width="100%" height="100%">
						</div>
						<div id="visitors-donut-chart" style="height: 160px; display: none"></div>
						<ul class="chart-legend">
							<li><i class="fa fa-circle-o fa-fw text-success m-r-5"></i> <span id="totalDiscounts"></span> <span>Discounts</span></li>
							<li><i class="fa fa-circle-o fa-fw text-primary m-r-5"></i> <span id="totalRewards"></span> <span>Reward Points</span></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-inverse" data-sortable-id="index-10">
					<div class="panel-heading">
						<div class="panel-heading-btn">
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
						</div>
						<h4 class="panel-title">Calendar</h4>
					</div>
					<div class="panel-body">
						<div id="datepicker-inline" class="datepicker-full-width"><div></div></div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<!-- begin col-8 -->
			<div class="col-md-5">
				<div class="panel panel-inverse" data-sortable-id="index-7">
					<div class="panel-heading">
						<div class="panel-heading-btn">
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
						</div>
						<h4 class="panel-title">Complains Chart Stat</h4>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<lable class="col-md-3">Filter</lable>
									<div class="col-md-9">
										<select class="form-control" id="filterDD">
											<option value="complain">Complain</option>
											<option value="franchise">Franchise</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="row" id="doughChartDiv">
							<div id="donut-chart-complain" class="height-sm" style="display: none"></div>
							<div id="donut-chart-franchise" class="height-sm" style="display: none"></div>
						</div>
					</div>
				</div>
			</div>
			<!-- end col-8 -->
			<!-- begin col-4 -->
			<div class="col-md-7">
				<div class="panel panel-inverse" data-sortable-id="flot-chart-3">
					<div class="panel-heading">
						<div class="panel-heading-btn">
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
						</div>
						<h4 class="panel-title">Trending Complain Heads</h4>
					</div>
					<div class="panel-body">
						<div id="bar-chart" class="height-sm"></div>
					</div>
				</div>
			</div>
			<!-- end col-4 -->
		</div>
		<!-- end row -->
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-inverse" data-sortable-id="index-7">
					<div class="panel-heading">
						<div class="panel-heading-btn">
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
						</div>
						<h4 class="panel-title">Complains Chart Stat</h4>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<lable class="col-md-3">Filter</lable>
									<div class="col-md-9">
										<select class="form-control" id="cityRegionFilter">
											<option value="city">City</option>
											<option value="region">Region</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="row" id="doughChartDiv">
							<div id="donut-chart-city" class="height-sm" style="display: none"></div>
							<div id="donut-chart-region" class="height-sm" style="display: none"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end #content -->

	<!-- begin theme-panel -->
	<div class="theme-panel">
		<a href="javascript:;" data-click="theme-panel-expand" class="theme-collapse-btn"><i class="fa fa-cog"></i></a>
		<div class="theme-panel-content">
			<h5 class="m-t-0">Color Theme</h5>
			<ul class="theme-list clearfix">
				<li class="active"><a href="javascript:;" class="bg-green" data-theme="default" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Default">&nbsp;</a></li>
				<li><a href="javascript:;" class="bg-red" data-theme="red" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Red">&nbsp;</a></li>
				<li><a href="javascript:;" class="bg-blue" data-theme="blue" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Blue">&nbsp;</a></li>
				<li><a href="javascript:;" class="bg-purple" data-theme="purple" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Purple">&nbsp;</a></li>
				<li><a href="javascript:;" class="bg-orange" data-theme="orange" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Orange">&nbsp;</a></li>
				<li><a href="javascript:;" class="bg-black" data-theme="black" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Black">&nbsp;</a></li>
			</ul>
			<div class="divider"></div>
			<div class="row m-t-10">
				<div class="col-md-5 control-label double-line">Header Styling</div>
				<div class="col-md-7">
					<select name="header-styling" class="form-control input-sm">
						<option value="1">default</option>
						<option value="2">inverse</option>
					</select>
				</div>
			</div>
			<div class="row m-t-10">
				<div class="col-md-5 control-label">Header</div>
				<div class="col-md-7">
					<select name="header-fixed" class="form-control input-sm">
						<option value="1">fixed</option>
						<option value="2">default</option>
					</select>
				</div>
			</div>
			<div class="row m-t-10">
				<div class="col-md-5 control-label double-line">Sidebar Styling</div>
				<div class="col-md-7">
					<select name="sidebar-styling" class="form-control input-sm">
						<option value="1">default</option>
						<option value="2">grid</option>
					</select>
				</div>
			</div>
			<div class="row m-t-10">
				<div class="col-md-5 control-label">Sidebar</div>
				<div class="col-md-7">
					<select name="sidebar-fixed" class="form-control input-sm">
						<option value="1">fixed</option>
						<option value="2">default</option>
					</select>
				</div>
			</div>
			<div class="row m-t-10">
				<div class="col-md-5 control-label double-line">Sidebar Gradient</div>
				<div class="col-md-7">
					<select name="content-gradient" class="form-control input-sm">
						<option value="1">disabled</option>
						<option value="2">enabled</option>
					</select>
				</div>
			</div>
			<div class="row m-t-10">
				<div class="col-md-5 control-label double-line">Content Styling</div>
				<div class="col-md-7">
					<select name="content-styling" class="form-control input-sm">
						<option value="1">default</option>
						<option value="2">black</option>
					</select>
				</div>
			</div>
			<div class="row m-t-10">
				<div class="col-md-12">
					<a href="#" class="btn btn-inverse btn-block btn-sm" data-click="reset-local-storage"><i class="fa fa-refresh m-r-3"></i> Reset Local Storage</a>
				</div>
			</div>
		</div>
	</div>
	<!-- end theme-panel -->

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
<!-- ================== END PAGE LEVEL JS ================== -->
<script type="text/javascript" src="script/main_script.js?v=<?php echo time();?>"></script>
<script type="text/javascript" src="script/sidebar-script.js?v=<?php echo time();?>"></script>
<script type="text/javascript">
	$(document).ready(function(){
		App.init();
		Dashboard.init();
		Chart.init();

		$('.nav li').removeClass('active');
		$('#dashboard').addClass('active');
	});
</script>