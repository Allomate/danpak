<?php require_once(APPPATH.'/views/includes/header.php'); ?>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once(APPPATH.'/views/includes/navbar&sidebar.php'); ?>
	<div class="page-wrapper p-b-20">
		<div class="container-fluid">
			<div class="row p-t-30">
				<div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
					<div class="panel panel-default card-view pa-0 emp-stats pr-box">
						<div class="panel-wrapper collapse in">
							<div class="panel-body pa-0">
								<div class="sm-data-box">
									<div class="container-fluid">
										<div class="row">
											<div class="col-sm-7 col-xs-8 text-center pl-0 pr-0 data-wrap-left">
												<span class="txt-dark block counter">
													<?= $stats['stat']->total_orders; ?>
												</span>
												<span class="weight-500 uppercase-font block">Total Orders</span>
											</div>
											<div class="col-sm-5 col-xs-4 text-center pl-0 pr-0">
												<img src="<?= base_url('assets/images/icon-all-sale.svg'); ?>" alt="brand">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
					<div class="panel panel-default card-view pa-0 emp-stats blue-box">
						<div class="panel-wrapper collapse in">
							<div class="panel-body pa-0">
								<div class="sm-data-box">
									<div class="container-fluid">
										<div class="row">
											<div class="col-sm-7 col-xs-8 text-center pl-0 pr-0 data-wrap-left">
												<span class="txt-dark block counter">
													<?= $stats['stat']->completed_orders; ?>
												</span>
												<span class="weight-500 uppercase-font block font-13">Completed Orders</span>
											</div>
											<div class="col-sm-5 col-xs-4 text-center  pl-0 pr-0">
												<img src="<?= base_url('assets/images/icon-all-order.svg'); ?>" alt="brand">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
					<div class="panel panel-default card-view pa-0 emp-stats total-box">
						<div class="panel-wrapper collapse in">
							<div class="panel-body pa-0">
								<div class="sm-data-box">
									<div class="container-fluid">
										<div class="row">
											<div class="col-sm-7 col-xs-8 text-center pl-0 pr-0 data-wrap-left">
												<span class="txt-dark block counter">
													<?= $stats['stat']->retail_visits; ?>
												</span>
												<span class="weight-500 uppercase-font block font-13">Retail Visits</span>
											</div>
											<div class="col-sm-5 col-xs-4 text-center  pl-0 pr-0">
												<img src="<?= base_url('assets/images/icon-order-done.svg'); ?>" alt="brand">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
					<div class="panel panel-default card-view pa-0 emp-stats lblue-box">
						<div class="panel-wrapper collapse in">
							<div class="panel-body pa-0">
								<div class="sm-data-box">
									<div class="container-fluid">
										<div class="row">
											<div class="col-sm-7 col-xs-8 text-center pl-0 pr-0 data-wrap-left">
												<span class="txt-dark block counter">
													<?= $stats['stat']->cancelled_orders; ?>
												</span>
												<span class="weight-500 uppercase-font block font-13">Cancelled Orders</span>
											</div>
											<div class="col-sm-5 col-xs-4 text-center  pl-0 pr-0">
												<img src="<?= base_url('assets/images/icon-active-devices.svg'); ?>" alt="brand">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
					<div class="panel panel-default card-view panel-refresh w-box-sec">
						<div class="refresh-container">
							<div class="la-anim-1"></div>
						</div>
						<div class="panel-heading">
							<div class="pull-left">
								<h6 class="panel-title txt-dark">Sale Statistics</h6>
							</div>
							<div class="pull-right">
								<a href="#" class="pull-left inline-block refresh mr-15">
									<i class="zmdi zmdi-replay"></i>
								</a>
								<a href="#" class="pull-left inline-block full-screen mr-15">
									<i class="zmdi zmdi-fullscreen"></i>
								</a>
								<div class="pull-left inline-block dropdown mr-15">
									<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" role="button">
										<i class="zmdi zmdi-more-vert"></i>
									</a>
									<ul class="dropdown-menu bullet dropdown-menu-right" role="menu">
										<li role="presentation">
											<a href="javascript:void(0)" role="menuitem">
												<i class="icon wb-reply" aria-hidden="true"></i>Devices</a>
										</li>
										<li role="presentation">
											<a href="javascript:void(0)" role="menuitem">
												<i class="icon wb-share" aria-hidden="true"></i>General</a>
										</li>
										<li role="presentation">
											<a href="javascript:void(0)" role="menuitem">
												<i class="icon wb-trash" aria-hidden="true"></i>Referral</a>
										</li>
									</ul>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="panel-wrapper collapse in">
							<div class="panel-body">
								<div id="e_chart_1" class="" style="height:313px;"></div>
								<ul class="flex-stat mt-20">
									<li>
										<span class="block">Weekly Sale</span>
										<span class="block txt-dark weight-500 font-18">
											<span class="counter-anim">3,24,222</span>
										</span>
									</li>
									<li>
										<span class="block">Monthly Sale</span>
										<span class="block txt-dark weight-500 font-18">
											<span class="counter-anim">1,23,432</span>
										</span>
									</li>
									<li>
										<span class="block">Trend</span>
										<span class="block">
											<i class="zmdi zmdi-trending-up txt-success font-24"></i>
										</span>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<div class="panel panel-default card-view w-box-sec">
						<div class="panel-wrapper collapse in">
							<div class="panel-body sm-data-box-1 pt-0 pb-20">

								<div class="pull-left">
									<h6 class="panel-title txt-dark">Goal Progress</h6>
								</div>
								<div class="clearfix"></div>

								<div class="cus-sat-stat weight-500 txt-info text-center mt-10">
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
										<span class="block">Previous</span>
										<span class="block txt-dark weight-500 font-15">79.82</span>
									</li>
									<li>
										<span class="block">% Change</span>
										<span class="block txt-dark weight-500 font-15">+14.29</span>
									</li>
									<li>
										<span class="block">Trend</span>
										<span class="block">
											<i class="zmdi zmdi-trending-up txt-success font-20"></i>
										</span>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<div class="panel panel-default card-view pa-0 w-box-sec">
						<div class="panel-wrapper collapse in">
							<div class="panel-body pa-0">
								<div class="sm-data-box">
									<div class="container-fluid">
										<div class="row">
											<div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
												<span class="txt-dark block counter">
													<span class="counter-anim">
														<?= $stats['stat']->total_sale; ?>
													</span>
												</span>
												<span class="weight-500 uppercase-font block">Total Sale</span>
											</div>
											<div class="dist-profile-icons">
												<img src="images/icon-all-orders-b.svg" alt="">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<div class="panel panel-default card-view pa-0 w-box-sec">
						<div class="panel-wrapper collapse in">
							<div class="panel-body pa-0">
								<div class="sm-data-box">
									<div class="container-fluid">
										<div class="row">
											<div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
												<span class="txt-dark block counter">
													<span class="counter-anim">
														<?= $stats['stat']->average_order; ?>
													</span>
												</span>
												<span class="weight-500 uppercase-font block font-13">Average Order</span>
											</div>
											<div class="dist-profile-icons">
												<img src="images/icon-all-order.svg" alt="">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div class="panel panel-default card-view w-box-sec">
						<div class="panel-heading">
							<div class="pull-left">
								<h6 class="panel-title txt-dark">Top Product Sales</h6>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="panel-wrapper collapse in">
							<div class="panel-body p-t-0">
								<?php foreach($stats["top_products"] as $tops) : ?>
								<span class="font-12 head-font txt-dark">
									<?= $tops->product; ?>
										<span class="pull-right">
											<?= $tops->percent_value; ?>%</span>
								</span>
								<div class="progress mt-10 mb-30">
									<div class="progress-bar progress-bar-info" aria-valuenow="<?= $tops->percent_value; ?>" aria-valuemin="0" aria-valuemax="<?= $tops->percent_value; ?>"
									style="width: <?= $tops->percent_value; ?>%" role="progressbar">
										<span class="sr-only">
											<?= $tops->percent_value; ?>% Complete (success)</span>
									</div>
								</div>
								<?php endforeach; ?>
								<!-- <span class="font-12 head-font txt-dark">Candy Red
									<span class="pull-right">80%</span>
								</span>
								<div class="progress mt-10 mb-30">
									<div class="progress-bar progress-bar-success" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 80%"
									role="progressbar">
										<span class="sr-only">85% Complete (success)</span>
									</div>
								</div>
								<span class="font-12 head-font txt-dark">Candy Big
									<span class="pull-right">70%</span>
								</span>
								<div class="progress mt-10 mb-30">
									<div class="progress-bar progress-bar-danger" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 70%"
									role="progressbar">
										<span class="sr-only">85% Complete (success)</span>
									</div>
								</div>
								<span class="font-12 head-font txt-dark">Candy Chocolate
									<span class="pull-right">45%</span>
								</span>
								<div class="progress mt-10 mb-30">
									<div class="progress-bar progress-bar-inverse" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 45%"
									role="progressbar">
										<span class="sr-only">85% Complete (success)</span>
									</div>
								</div>
								<span class="font-12 head-font txt-dark">Small Candy
									<span class="pull-right">80%</span>
								</span>
								<div class="progress mt-10 mb-30">
									<div class="progress-bar progress-bar-success" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%"
									role="progressbar">
										<span class="sr-only">80% Complete (success)</span>
									</div>
								</div> -->
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div class="panel panel-default card-view w-box-sec">
						<div class="panel-heading">
							<div class="pull-left">
								<h6 class="panel-title txt-dark">Sales Target</h6>
							</div>

							<div class="clearfix"></div>
						</div>
						<div class="panel-wrapper collapse in">
							<div class="panel-body row pa-0">
								<div class="table-wrap">
									<div class="table-responsive">
										<table class="table table-hover mb-0">
											<thead>
												<tr>
													<th>Task</th>
													<th>Progress</th>
													<th>Deadline</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>Sales Target 1</td>
													<td>
														<div class="progress progress-xs mb-0 ">
															<div class="progress-bar progress-bar-danger" style="width: 35%"></div>
														</div>
													</td>
													<td>Jan 18, 2017</td>

												</tr>
												<tr>
													<td>Sales Target 2</td>
													<td>
														<div class="progress progress-xs mb-0 ">
															<div class="progress-bar progress-bar-warning" style="width: 50%"></div>
														</div>
													</td>
													<td>Dec 1, 2016</td>

												</tr>
												<tr>
													<td>Sales Target 3</td>
													<td>
														<div class="progress progress-xs mb-0 ">
															<div class="progress-bar progress-bar-success" style="width: 100%"></div>
														</div>
													</td>
													<td>Nov 12, 2016</td>

												</tr>
												<tr>
													<td>Sales Target 4</td>
													<td>
														<div class="progress progress-xs mb-0 ">
															<div class="progress-bar progress-bar-primary" style="width: 70%"></div>
														</div>
													</td>
													<td>Oct 9, 2016</td>

												</tr>
												<tr>
													<td>Sales Target 5</td>
													<td>
														<div class="progress progress-xs mb-0 ">
															<div class="progress-bar progress-bar-primary" style="width: 85%"></div>
														</div>
													</td>
													<td>Sept 2, 2016</td>

												</tr>
												<tr>
													<td>Sales Target 6</td>
													<td>
														<div class="progress progress-xs mb-0 ">
															<div class="progress-bar progress-bar-warning" style="width: 50%"></div>
														</div>
													</td>
													<td>August 11, 2015</td>

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
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script src="<?= base_url('assets/vendors/bower_components/waypoints/lib/jquery.waypoints.min.js');?>"></script>
<script src="<?= base_url('assets/vendors/bower_components/jquery.counterup/jquery.counterup.min.js');?>"></script>
<script src="<?= base_url('assets/vendors/jquery.sparkline/dist/jquery.sparkline.min.js');?>"></script>
<script src="<?= base_url('assets/vendors/bower_components/echarts/dist/echarts-en.min.js');?>"></script>
<script src="<?= base_url('assets/vendors/echarts-liquidfill.min.js');?>"></script>
<script src="<?= base_url('assets/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js');?>"></script>
<script src="<?= base_url('assets/vendors/bower_components/peity/jquery.peity.min.js');?>"></script>
<script src="<?= base_url('assets/dist/js/peity-data.js');?>"></script>
<script src="<?= base_url('assets/dist/js/dashboard-data.js');?>"></script>
