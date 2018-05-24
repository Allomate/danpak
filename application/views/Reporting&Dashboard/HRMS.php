<?php require_once(APPPATH.'/views/includes/header.php'); ?>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once(APPPATH.'/views/includes/navbar&sidebar.php'); ?>
	<div class="page-wrapper">
		<div class="container-fluid">
			<div class="row m-t-30">
				<div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
					<div class="panel panel-default card-view panel-refresh w-box-sec">
						<div class="refresh-container">
							<div class="la-anim-1"></div>
						</div>
						<div class="panel-heading">
							<div class="pull-left">
								<h6 class="panel-title txt-dark">Total Employees</h6>
							</div>
							<div class="pull-right m-r-10">
								<a href="#" class="pull-left inline-block refresh mr-15">
									<i class="zmdi zmdi-replay"></i>
								</a>
								<div class="pull-left inline-block dropdown">
									<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="zmdi zmdi-more-vert"></i></a>
									<ul class="dropdown-menu bullet dropdown-menu-right"  role="menu">
										<li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-reply" aria-hidden="true"></i>Edit</a></li>
										<li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-share" aria-hidden="true"></i>Delete</a></li>
										<li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-trash" aria-hidden="true"></i>New</a></li>
									</ul>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>

						<div class="panel-wrapper collapse in">
							<div id="e_chart_1" class="" style="height:370px;"></div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
					<div class="panel panel-default card-view panel-refresh w-box-sec">
						<div class="refresh-container">
							<div class="la-anim-1"></div>
						</div>
						<div class="panel-heading">
							<div class="pull-left">
								<h6 class="panel-title txt-dark">Employee Churn </h6>
							</div>
							<div class="pull-right m-r-10">
								<a href="#" class="pull-left inline-block refresh">
									<i class="zmdi zmdi-replay"></i>
								</a>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="panel-wrapper collapse in">
							<div class="panel-body">
								<div id="e_chart_2" class="" style="height:330px;"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
					<div class="panel panel-default card-view w-box-sec">
						<div class="panel-heading">
							<div class="pull-left">
								<h6 class="panel-title txt-dark">Attendance Metrics</h6>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="panel-wrapper collapse in">
							<div class="panel-body">
								<div id="e_chart_3" class="" style="height:330px;"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
					<div class="panel panel-default card-view w-box-sec">
						<div class="panel-heading">
							<div class="pull-left">
								<h6 class="panel-title txt-dark">Key Metrics</h6>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="panel-wrapper collapse in">
							<div  class="panel-body">
								<span class="font-12 head-font txt-dark">Employee Turnover<span class="pull-right">85%</span></span>
								<div class="progress mt-10 mb-30">
									<div class="progress-bar progress-bar-info" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 85%" role="progressbar"> <span class="sr-only">85% Complete (success)</span> </div>
								</div>
								<span class="font-12 head-font txt-dark">Speed to Hire (Days)<span class="pull-right">80%</span></span>
								<div class="progress mt-10 mb-30">
									<div class="progress-bar progress-bar-success" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 80%" role="progressbar"> <span class="sr-only">85% Complete (success)</span> </div>
								</div>
								<span class="font-12 head-font txt-dark">Promotion Rates<span class="pull-right">70%</span></span>
								<div class="progress mt-10 mb-30">
									<div class="progress-bar progress-bar-danger" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 70%" role="progressbar"> <span class="sr-only">85% Complete (success)</span> </div>
								</div>
								<span class="font-12 head-font txt-dark">Success Rate<span class="pull-right">45%</span></span>
								<div class="progress mt-10 mb-30">
									<div class="progress-bar progress-bar-inverse" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 45%" role="progressbar"> <span class="sr-only">85% Complete (success)</span> </div>
								</div>
								<span class="font-12 head-font txt-dark">Performance<span class="pull-right">80%</span></span>
								<div class="progress mt-10 mb-30">
									<div class="progress-bar progress-bar-success" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%" role="progressbar"> <span class="sr-only">80% Complete (success)</span> </div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
					<div class="panel panel-default card-view panel-refresh w-box-sec">
						<div class="refresh-container">
							<div class="la-anim-1"></div>
						</div>
						<div class="panel-heading">
							<div class="pull-left">
								<h6 class="panel-title txt-dark">Open Positions by Division</h6>
							</div>
							<div class="pull-right m-r-10">
								<a href="#" class="pull-left inline-block refresh">
									<i class="zmdi zmdi-replay"></i>
								</a>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="panel-wrapper collapse in">
							<div class="panel-body">
								<div id="e_chart_4" class="" style="height:342px;"></div>	
							</div>	
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
							<div class="panel panel-default card-view w-box-sec">
							<div class="panel-heading">
								<div class="pull-left">
									<h6 class="panel-title txt-dark">Employees Targets</h6>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="panel-wrapper collapse in">
								<div class="panel-body row pa-0">
									<div class="table-wrap">
										<div class="table-responsive">
											<table class="table display product-overview border-none" id="employee_targets_table">
												<thead>
													<tr>
														<th>Employee ID</th>
														<th>Name</th> 
														<th>Date</th>
														<th>Status</th>
														<th>Actions</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>#85457898</td>
														<td>Tayyab Khan</td> 
														<td>Oct 27</td>
														<td>
															<span class="label label-success">done</span>
														</td>
														<td><a href="javascript:void(0)" class="pr-10" data-toggle="tooltip" title="completed" ><i class="zmdi zmdi-check"></i></a> <a href="javascript:void(0)" class="text-inverse" title="Delete" data-toggle="tooltip"><i class="zmdi zmdi-delete"></i></a></td>
													</tr>
													<tr>
														<td>#85457897</td>
														<td>Sulman  Khan</td> 
														<td>Oct 26</td>
														<td>
															<span class="label label-warning ">Pending</span>
														</td>
														<td><a href="javascript:void(0)" class="pr-10" data-toggle="tooltip" title="completed" ><i class="zmdi zmdi-check"></i></a> <a href="javascript:void(0)" class="text-inverse" title="Delete" data-toggle="tooltip"><i class="zmdi zmdi-delete"></i></a></td>
													</tr>
													<tr>
														<td>#85457896</td>
														<td>Rafique  Khan</td> 
														<td>Oct 25</td>
														<td>
															<span class="label label-success ">done</span>
														</td>
														<td><a href="javascript:void(0)" class="pr-10" data-toggle="tooltip" title="completed" ><i class="zmdi zmdi-check"></i></a> <a href="javascript:void(0)" class="text-inverse" title="Delete" data-toggle="tooltip"><i class="zmdi zmdi-delete"></i></a></td>
													</tr>
													<tr>
														<td>#85457895</td>
														<td>Saad  Khan</td> 
														<td>Oct 25</td>
														<td>
															<span class="label label-danger">pending</span>
														</td>
														<td><a href="javascript:void(0)" class="pr-10" data-toggle="tooltip" title="completed" ><i class="zmdi zmdi-check"></i></a> <a href="javascript:void(0)" class="text-inverse" title="Delete" data-toggle="tooltip"><i class="zmdi zmdi-delete"></i></a></td>
													</tr>
													<tr>
														<td>#85457896</td>
														<td>Fahad ALi Khan</td> 
														<td>Oct 25</td>
														<td>
															<span class="label label-success ">done</span>
														</td>
														<td><a href="javascript:void(0)" class="pr-10" data-toggle="tooltip" title="completed" ><i class="zmdi zmdi-check"></i></a> <a href="javascript:void(0)" class="text-inverse" title="Delete" data-toggle="tooltip"><i class="zmdi zmdi-delete"></i></a></td>
													</tr>
													<tr>
														<td>#85457894</td>
														<td>Shabir ali  Khan</td> 
														<td>Oct 25</td>
														<td>
															<span class="label label-success ">done</span>
														</td>
														<td><a href="javascript:void(0)" class="pr-10" data-toggle="tooltip" title="completed" ><i class="zmdi zmdi-check"></i></a> <a href="javascript:void(0)" class="text-inverse" title="Delete" data-toggle="tooltip"><i class="zmdi zmdi-delete"></i></a></td>
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
<script src="<?= base_url('assets/dist/js/dashboard5-data.js');?>"></script>
