<?php require_once APPPATH . '/views/includes/header.php';?>
<link href="<?=base_url('assets/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css');?>" rel="stylesheet" type="text/css">
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once APPPATH . '/views/includes/navbar&sidebar.php';?>
	<div class="page-wrapper">
		<div class="container-fluid">
			<div class="row m-t-30">
				<div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
					<div class="panel panel-default card-view w-box-sec" style="min-height: 571px;">
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
								<a href="#" class="pull-left inline-block full-screen">
									<i class="zmdi zmdi-fullscreen"></i>
								</a>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="panel-wrapper collapse in">
							<div class="panel-body">
								<ul class="flex-stat mb-10 ml-15 ">
									<li class="text-left auto-width mr-60">
										<span class="block">Traffic</span>
										<span class="block txt-dark weight-500 font-18"><span class="counter-anim">3,24,222</span></span>
										<span class="block darkbluetext mt-5">
											<i class="zmdi zmdi-caret-up pr-5 font-20"></i><span class="weight-500">+15%</span>
										</span>
										<div class="clearfix"></div>
									</li>
									<li class="text-left auto-width mr-60">
										<span class="block">Orders</span>
										<span class="block txt-dark weight-500 font-18"><span class="counter-anim">1,23,432</span></span>
										<span class="block darkbluetext mt-5">
											<i class="zmdi zmdi-caret-up pr-5 font-20"></i><span class="weight-500">+4%</span>
										</span>
										<div class="clearfix"></div>
									</li>
									<li class="text-left auto-width">
										<span class="block">Revenue</span>
										<span class="block txt-dark weight-500 font-18">Rs: <span class="counter-anim">324,222</span></span>
										<span class="block txt-danger mt-5">
											<i class="zmdi zmdi-caret-down pr-5 font-20"></i><span class="weight-500">-5%</span>
										</span>
										<div class="clearfix"></div>
									</li>
								</ul>
								<div id="e_chart_1" class="" style="height:345px;"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
					<div class="panel panel-default card-view panel-refresh w-box-sec">
						<div class="refresh-container">
							<div class="la-anim-1"></div>
						</div>
						<div class="panel-heading">
							<div class="pull-left">
								<h6 class="panel-title txt-dark">Top 5 Products</h6>
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
					<div class="panel panel-default card-view sm-data-box-3 w-box-sec">
						<div class="panel-heading">
							<div class="pull-left">
								<h6 class="panel-title txt-dark">Conversion Rate</h6>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="panel-wrapper collapse in">
							<div class="panel-body">
								<div class="col-sm-6 pa-0">
									<span id="pie_chart_4" class="easypiechart" data-percent="33">
										<span class="percent block txt-dark weight-500"></span>
										<span class="block darkbluetext text-center">
											<i class="zmdi zmdi-caret-up pr-5 font-20"></i><span class="weight-500">+33%</span>
										</span>
									</span>
								</div>
								<div class="col-sm-6 pr-0">
									<ul class="flex-stat mb-15">
										<li class="text-left block no-float full-width mb-15">
											<span class="block">Cart Abandonment</span>
											<span class="block txt-dark weight-500  font-18"><span class="counter-anim">73</span>%</span>
											<span class="block darkbluetext pull-left mt-5">
												<i class="zmdi zmdi-caret-up pr-5 font-20 pull-left"></i><span class="weight-500 pull-left">+15%</span>
											</span>
											<div class="clearfix"></div>
										</li>
										<li class="text-left block no-float full-width">
											<span class="block">Revenue Left</span>
											<span class="block txt-dark weight-500  font-18">Rs: <span class="counter-anim">12,432</span></span>
											<span class="block darkbluetext pull-left mt-5">
												<i class="zmdi zmdi-caret-up pr-5 font-20 pull-left"></i><span class="weight-500 pull-left">+4%</span>
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
			<div class="row">
				<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
					<div class="panel panel-default card-view panel-refresh w-box-sec" style="min-height: 349px;">
						<div class="refresh-container">
							<div class="la-anim-1"></div>
						</div>
						<div class="panel-heading">
							<div class="pull-left">
								<h6 class="panel-title txt-dark">Sale by Category</h6>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="panel-wrapper collapse in">
							<div class="panel-body row">
								<div class="col-sm-6 pa-0">
									<div id="e_chart_3" class="" style="height:185px;"></div>
								</div>
								<div class="col-sm-6 pr-0 pt-30">
									<div class="label-chatrs">
										<div class="mb-5">
											<span class="clabels circular-clabels inline-block darkblueBG mr-5"></span>
											<span class="clabels-text font-12 inline-block txt-dark capitalize-font">BLUEBERRY CANDY BARS</span>
										</div>
										<div class="mb-5">
											<span class="clabels circular-clabels inline-block redBG mr-5"></span>
											<span class="clabels-text font-12 inline-block txt-dark capitalize-font">BUTTER SCOTCH CANDY</span>
										</div>
										<div class="mb-5">
											<span class="clabels circular-clabels inline-block blueBG mr-5"></span>
											<span class="clabels-text font-12 inline-block txt-dark capitalize-font">CHINI MINI JAR</span>
										</div>
										<div class="">
											<span class="clabels circular-clabels inline-block bg-gray mr-5"></span>
											<span class="clabels-text font-12 inline-block txt-dark capitalize-font">BUBBLE BOOM JAR</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
					<div class="panel panel-default card-view pt-0 w-box-sec">
						<div class="panel-wrapper collapse in">
							<div class="panel-body pa-0">
								<div class="sm-data-box bg-white">
									<div class="container-fluid">
										<div class="row">
											<div class="col-xs-6 text-left pl-0 pr-0 data-wrap-left">
												<span class="txt-dark block counter">Rs: <span class="counter-anim">15,678</span></span>
												<span class="block"><span class="weight-500 uppercase-font txt-grey font-13">Visits</span><i class="zmdi zmdi-caret-down txt-danger font-21 ml-5 vertical-align-middle"></i></span>
											</div>
											<div class="col-xs-6 text-left  pl-0 pr-0 pt-25 data-wrap-right">
												<div id="sparkline_4" style="width: 100px; overflow: hidden; margin: 0px auto;"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="panel panel-default card-view pt-0 w-box-sec">
						<div class="panel-wrapper collapse in">
							<div class="panel-body pa-0">
								<div class="sm-data-box bg-white">
									<div class="container-fluid">
										<div class="row">
											<div class="col-xs-6 text-left pl-0 pr-0 data-wrap-left">
												<span class="txt-dark block counter"><span class="counter-anim">46.41</span>%</span>
												<span class="block"><span class="weight-500 uppercase-font txt-grey font-13">Bounce Rate</span><i class="zmdi zmdi-caret-up darkbluetext font-21 ml-5 vertical-align-middle"></i></span>
											</div>
											<div class="col-xs-6 text-left  pl-0 pr-0 pt-25 data-wrap-right">
												<div id="sparkline_5" style="width: 100px; overflow: hidden; margin: 0px auto;"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="panel panel-default card-view pt-0 w-box-sec">
						<div class="panel-wrapper collapse in">
							<div class="panel-body pa-0">
								<div class="sm-data-box bg-white">
									<div class="container-fluid">
										<div class="row">
											<div class="col-xs-6 text-left pl-0 pr-0 data-wrap-left">
												<span class="txt-dark block counter"><span class="counter-anim">142,357</span></span>
												<span class="block"><span class="weight-500 uppercase-font txt-grey font-13">Products</span><i class="zmdi zmdi-caret-down txt-danger font-21 ml-5 vertical-align-middle"></i></span>
											</div>
											<div class="col-xs-6 text-left  pl-0 pr-0 pt-25 data-wrap-right">
												<div id="sparkline_6" style="width: 100px; overflow: hidden; margin: 0px auto;"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-xs-12">
					<div class="panel panel-default border-panel card-view w-box-sec" style="min-height: 349px;">
						<div class="panel-heading">
							<div class="pull-left">
								<h6 class="panel-title txt-dark">Recent Activity</h6>
							</div>
							<a class="txt-danger pull-right right-float-sub-text inline-block" href="javascript:void(0)"> clear all </a>
							<div class="clearfix"></div>
						</div>
						<div class="panel-wrapper task-panel collapse in">
							<div class="panel-body row pa-0">
								<div class="list-group mb-0">
									<a href="#" class="list-group-item">
										<span class="badge transparent-badge badge-info capitalize-font">just now</span>
										<i class="zmdi zmdi-calendar-check pull-left"></i><p class="pull-left">Calendar updated</p>
										<div class="clearfix"></div>
									</a>
									<a href="#" class="list-group-item">
										<span class="badge transparent-badge badge-success capitalize-font">4 min</span>
										<i class="zmdi zmdi-comment-alert pull-left"></i><p class=" pull-left">Commented on a post</p>
										<div class="clearfix"></div>
									</a>
									<a href="#" class="list-group-item">
										<span class="badge transparent-badge badge-warning capitalize-font">23 min </span>
										<i class="zmdi zmdi-truck pull-left"></i><p class=" pull-left">Order 392 shipped</p>
										<div class="clearfix"></div>
									</a>
									<a href="#" class="list-group-item">
										<span class="badge transparent-badge badge-success capitalize-font">46 min</span>
										<i class="zmdi zmdi-money pull-left"></i><p class=" pull-left">Invoice 653 has been paid</p>
										<div class="clearfix"></div>
									</a>
									<a href="#" class="list-group-item">
										<span class="badge transparent-badge badge-danger capitalize-font">1 hr</span>
										<i class="zmdi zmdi-account pull-left"></i><p class="pull-left">A new user has been added</p>
										<div class="clearfix"></div>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-xs-12">
					<div class="panel panel-default card-view panel-refresh w-box-sec">
						<div class="refresh-container">
							<div class="la-anim-1"></div>
						</div>
						<div class="panel-heading">
							<div class="pull-left">
								<h6 class="panel-title txt-dark">Invoice List</h6>
							</div>
							<div class="pull-right m-r-10">
								<a href="javascript:void(0)" class="pull-left btn view-report btn-xs mr-15">view all</a>
								<a href="#" class="pull-left inline-block refresh mr-15">
									<i class="zmdi zmdi-replay"></i>
								</a>
								<a href="#" class="pull-left inline-block full-screen mr-15">
									<i class="zmdi zmdi-fullscreen"></i>
								</a>
								<div class="pull-left inline-block dropdown">
									<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="zmdi zmdi-more-vert"></i></a>
									<ul class="dropdown-menu bullet dropdown-menu-right"  role="menu">
										<li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-reply" aria-hidden="true"></i>option 1</a></li>
										<li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-share" aria-hidden="true"></i>option 2</a></li>
										<li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-trash" aria-hidden="true"></i>option 3</a></li>
									</ul>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="panel-wrapper collapse in">
							<div class="panel-body row pa-0">
								<div class="table-wrap">
									<div class="table-responsive">
										<table id="datable_1_new" class="table  display table-hover border-none">
											<thead>
												<tr>
													<th>#Invoice</th>
													<th>Product Name</th>
													<th>Amount</th>
													<th>Status</th>
													<th>issue date</th>
													<th>due date</th>
													<th>View</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>#5012</td>
													<td>CHINI MINI JAR</td>
													<td>Rs: 205,500</td>
													<td>
														<span class="label label-danger">unpaid</span>
													</td>
													<td>2011/04/25</td>
													<td>2012/12/02</td>
													<td>
														<a href="#">
															<i class="fa fa-file-text-o" aria-hidden="true"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>#5013</td>
													<td>CAR CHOCOLATE</td>
													<td>Rs: 205,500</td>
													<td>
														<span class="label label-success">paid</span>
													</td>
													<td>2011/07/25</td>
													<td>2012/12/02</td>
													<td>
														<a href="#">
															<i class="fa fa-file-text-o" aria-hidden="true"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>#5014</td>
													<td>DAILY DELIGHT CRISP</td>
													<td>Rs: 205,500</td>
													<td>
														<span class="label label-warning">pending</span>
													</td>
													<td>2009/01/12</td>
													<td>2012/12/02</td>
													<td>
														<a href="#">
															<i class="fa fa-file-text-o" aria-hidden="true"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>#5015</td>
													<td>MOUNTAIN GOLD</td>
													<td>Rs: 205,500</td>
													<td>
														<span class="label label-success">paid</span>
													</td>
													<td>2012/03/29</td>
													<td>2012/12/02</td>
													<td>
														<a href="#">
															<i class="fa fa-file-text-o" aria-hidden="true"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>#5010</td>
													<td>BUTTER SCOTCH CANDY</td>
													<td>Rs: 205,500</td>
													<td>
														<span class="label label-success">paid</span>
													</td>
													<td>2010/10/14</td>
													<td>2014/09/15</td>
													<td>
														<a href="#">
															<i class="fa fa-file-text-o" aria-hidden="true"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>#5011</td>
													<td>3D PUZZLE JAR</td>
													<td>Rs: 205,500</td>
													<td>
														<span class="label label-success">paid</span>
													</td>
													<td>2009/09/15</td>
													<td>2013/09/15</td>
													<td>
														<a href="#">
															<i class="fa fa-file-text-o" aria-hidden="true"></i>
														</a>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
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

<script src="<?=base_url('assets/vendors/bower_components/jquery/dist/jquery.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js');?>"></script>
<script src="<?=base_url('assets/dist/js/jquery.slimscroll.js');?>"></script>
<script src="<?=base_url('assets/vendors/bower_components/moment/min/moment.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bower_components/simpleWeather/jquery.simpleWeather.min.js');?>"></script>
<script src="<?=base_url('assets/dist/js/simpleweather-data.js');?>"></script>
<script src="<?=base_url('assets/vendors/bower_components/waypoints/lib/jquery.waypoints.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bower_components/jquery.counterup/jquery.counterup.min.js');?>"></script>
<script src="<?=base_url('assets/dist/js/dropdown-bootstrap-extended.js');?>"></script>
<script src="<?=base_url('assets/vendors/jquery.sparkline/dist/jquery.sparkline.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bower_components/owl.carousel/dist/owl.carousel.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/chart.js/Chart.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bower_components/echarts/dist/echarts-en.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/echarts-liquidfill.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bower_components/switchery/dist/switchery.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
<script src="<?=base_url('assets/dist/js/init.js');?>"></script>
<script src="<?=base_url('assets/dist/js/ecommerce-data.js');?>"></script>

</body>
</html>