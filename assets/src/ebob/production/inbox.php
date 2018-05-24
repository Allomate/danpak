<?php 
require 'verify_permission.php';
include 'header.php';?>
<style type="text/css">
.userComplain:hover{
	background-color: #e9edef
}
</style>
<!-- begin #page-loader -->
<div id="page-loader" class="fade in"><span class="spinner"></span></div>
<!-- end #page-loader -->
<!-- begin #page-container -->
<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
	<?php include 'navbar.php';?>
	<?php include 'sidebar.php';?>

	<?php if(!isset($_COOKIE["commentDetail"])){?>

	<div id="content" class="content content-full-width">
		<div class="row">
			<div class="col-md-11">
				<ul class="nav navbar-nav navbar-right">
					<li>
						<form class="navbar-form full-width">
							<div class="form-group">
								<input type="text" class="form-control" id="searchComplain" placeholder="Complain Id OR User name" />
								<button type="button" class="btn btn-search"><i class="fa fa-search"></i></button>
							</div>
						</form>
					</li>
				</ul>
			</div>
		</div>
		<!-- begin vertical-box -->
		<div class="vertical-box">
			<!-- begin vertical-box-column -->
			<div class="vertical-box-column width-250">
				<div class="wrapper">
					<p><b>Inbox</b></p>
					<ul class="nav nav-pills nav-stacked nav-sm">
						<?php
						require_once 'database/config.php';
						$sql = "SELECT complain_status, count(complain_id) from complains where company_id = (SELECT company_id from employees_info ei where ei.employee_username = (SELECT employee from employee_session where session = ?)) and department_id in (SELECT department_id from employee_departments_mapping where employee_id = (SELECT employee_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))) group by complain_status";
						$stmt=$conn->prepare($sql);
						$stmt->bind_param('ss', $_COOKIE["US-K"], $_COOKIE["US-K"]);
						$stmt->execute();
						$stmt->bind_result($complain_status, $numOfComplains);
						while($stmt->fetch()){
							if($complain_status == "resolved"){?>
							<li id="resolvedTab" style="cursor: pointer;"><a id="resolvedComplains"><i class="fa fa-flag fa-fw m-r-5"></i> Resolved <span class="badge pull-right"><?php echo $numOfComplains;?></span></a></li>
							<?php }else{ ?>
							<li id="pendingTab" class="active" style="cursor: pointer;"><a id="pendingComplains"><i class="fa fa-inbox fa-fw m-r-5"></i> Pending <span class="badge pull-right"><?php echo $numOfComplains;?></span></a></li>
							<?php }
						}
						$stmt->close();
						?>
					</ul>
				</div>
			</div>
			<div class="vertical-box-column">
				<ul class="list-group list-group-lg no-radius list-email pendingComplainsUl">
				</ul>
				<!-- end list-email -->
				<!-- begin wrapper -->
				<div class="wrapper bg-silver-lighter clearfix">
					<div class="btn-group pull-right">
						<button class="btn btn-white btn-sm">
							<i class="fa fa-chevron-left"></i>
						</button>
						<button class="btn btn-white btn-sm">
							<i class="fa fa-chevron-right"></i>
						</button>
					</div>
				</div>
				<!-- end wrapper -->
			</div>
			<!-- end vertical-box-column -->
		</div>
		<!-- end vertical-box -->
	</div>

	<?php }else{
		require_once 'database/config.php';
		$sql = "SELECT (SELECT user_name from users where user_id = com.user_id) as user, (SELECT user_email from users where user_id = com.user_id) as email, user_comments, (SELECT user_dp from users where user_id = com.user_id) as user_dp, tad_time_start, complain_status, (SELECT complain_head from complain_heads where id = com.head_id) as head, (SELECT complain_subhead from complain_subhead where id = com.subhead_id) as  subhead_id, (SELECT level from complain_subhead where id = com.subhead_id) as subhead_level, (SELECT employee_name from employees_info where employee_id = com.employee_id) as employee_name, employee_comments, tad_time_close, TIMESTAMPDIFF(HOUR, tad_time_start, tad_time_close) as tad_time_diff from complains com where complain_id = ?";
		$stmt=$conn->prepare($sql);
		$stmt->bind_param('s', $_COOKIE["commentDetail"]);
		$stmt->execute();
		$stmt->bind_result($user, $email, $user_comments, $user_dp, $time, $complain_status, $head, $subhead, $level, $employee_name, $employee_comments, $tad_time_close, $tad_time_diff);
		while($stmt->fetch()){?>
		<!-- begin #content -->
		<div id="content" class="content content-full-width">
			<!-- begin vertical-box -->
			<div class="vertical-box">
				<div class="vertical-box-column bg-white">
					<div class="wrapper">
						<h4 class="m-b-15 m-t-0 p-b-10 underline"><?php echo $user;?></h4>
						<ul class="media-list underline m-b-20 p-b-15">
							<li class="media media-sm clearfix">
								<a href="javascript:;" class="pull-left">
									<img class="media-object rounded-corner" alt="" src="assets/img/user-14.jpg" />
								</a>
								<div class="media-body">
									<span class="email-from text-inverse f-w-600">
										from <?php echo $email;?>
									</span><span class="text-muted m-l-5"><i class="fa fa-clock-o fa-fw"></i> 8:30 AM</span><br />
									<br>
									<label>Complain Head: </label> <?php echo $head;?>
									<br>
									<label>Complain Sub-Head: </label> <?php echo $subhead;?>
									<input type="text" id="hiddenEmail" value="<?php echo $email;?>" style="display: none">
									<div id="crankCustomerDiv" style="display: none">
										<a id="crankCustomer" class="btn btn-white btn-sm" style="background-color: #b39cb3; color: white">CRANK CUSTOMER</a>
									</div>
								</div>
							</li>
						</ul>

						<p class="f-s-12 text-inverse"> 
							<?php echo $user_comments;?>
						</p>

						<?php if($complain_status == "pending"){?>
						<hr>

						<div style="margin-left: 10px">
							<div class="row">
								<div class="col-md-2" style="border-left: 2px solid green">
									<div class="row" style="margin-left: 0px">
										<div class="form-group">
											<label>Complain Head</label>
											<br>
											<?php echo $head;?>
										</div>
									</div>
								</div>
								<div class="col-md-2" style="border-left: 2px solid green">
									<div class="row" style="margin-left: 0px">
										<div class="form-group">
											<label>Complain Subhead <?php //echo "Level ".$level;?></label>
											<br>
											<?php echo $subhead;?>
										</div>
									</div>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="form-group">
									<label>Resolution</label>
									<div class="row">
										<div class="col-md-5">
											<textarea id="resolutionBox" rows="10" cols="100" class="form-control" maxlength="500"></textarea>
										</div>
									</div>
								</div>
							</div>
							maxlength: <span id="maxLength">500</span>
							<br><br>
							<div class="row" id="rewardPointsDiv" style="display: none">
								<div class="col-md-3">
									<div class="form-group">
										<label>Reward Points</label>
										<input class="form-control" type="number" id="rewardPoints" placeholder="Max. 5000" max="5000"></input>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Discount (%)</label>
										<input class="form-control" type="number" id="discountPrice" placeholder="20" max="5000"></input>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Product</label>
										<select id="productId" class="form-control">
											<option value="11">Product</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<?php }else{?>
						<hr>
						<div id="resolutionStats" style="margin-left: 20px">
							<div class="row">
								<div class="col-md-2" style="border-left: 2px solid green">
									<div class="row" style="margin-left: 0px">
										<div class="form-group">
											<label>Resolved By</label>
											<br>
											<?php echo $employee_name;?>
										</div>
									</div>
								</div>
								<div class="col-md-2" style="border-left: 2px solid #9eb4d8">
									<div class="row" style="margin-left: 0px">
										<div class="form-group">
											<label>Resolved In</label>
											<br>
											<?php echo ($tad_time_diff == 0) ? "Less than an hour" : $tad_time_diff . " hrs";?>
										</div>
									</div>
								</div>
								<div class="col-md-2" style="border-left: 2px solid #445675">
									<div class="row" style="margin-left: 0px">
										<div class="form-group">
											<label>Complain Initiated On</label>
											<br>
											<?php echo $time;?>
										</div>
									</div>
								</div>
								<div class="col-md-2" style="border-left: 2px solid #c8cece">
									<div class="row" style="margin-left: 0px">
										<div class="form-group">
											<label>Complain Resolved On</label>
											<br>
											<?php echo $tad_time_close;?>
										</div>
									</div>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-md-5" style="border-left: 2px solid #e0ae62">
									<div class="row" style="margin-left: 0px">
										<div class="form-group">
											<label>- User Comments</label>
											<br>
											<?php echo $user_comments;?>
										</div>
									</div>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-md-5" style="border-left: 2px solid #51adcc">
									<div class="row" style="margin-left: 0px">
										<div class="form-group">
											<label>- Resolution Comments</label>
											<br>
											<?php echo $employee_comments;?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php }?>

					</div>

					<div class="wrapper bg-silver-lighter text-left clearfix">
						<div class="btn-group m-l-5">
							<a id="goBackButton" class="btn btn-white btn-sm" style="margin-right: 5px">GO BACK</a>
							<?php if($complain_status == "pending"){?>
							<a id="submitResolution" class="btn btn-white btn-sm" style="background-color: #ba924a; color: white;margin-right: 5px">RESOLVE</a>
							<a id="counterDeal" class="btn btn-white btn-sm" style="background-color: #815082; color: white">COUNTER DEAL</a>
							<?php }?>
						</div>
					</div>
					<!-- end wrapper -->
				</div>
				<!-- end vertical-box-column -->
			</div>
			<!-- end vertical-box -->
		</div>
		<?php }?>
		<!-- end #content -->

		<?php } ?>
		<!-- end #content -->
		<!-- end theme-panel -->

		<!-- begin scroll to top btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		<!-- end scroll to top btn -->
	</div>

	<?php include 'footer.php';?>
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script src="assets/plugins/flot/jquery.flot.min.js"></script>
	<script src="assets/plugins/flot/jquery.flot.time.min.js"></script>
	<script src="assets/plugins/flot/jquery.flot.resize.min.js"></script>
	<script src="assets/plugins/flot/jquery.flot.pie.min.js"></script>
	<script src="assets/plugins/flot/jquery.flot.stack.min.js"></script>
	<script src="assets/plugins/flot/jquery.flot.crosshair.min.js"></script>
	<script src="assets/plugins/flot/jquery.flot.categories.js"></script>
	<script src="assets/js/chart-flot.demo.min.js"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->
	<script type="text/javascript" src="script/inbox.js?v=<?php echo time();?>"></script>
	<script type="text/javascript" src="script/sidebar-script.js?v=<?php echo time();?>"></script>
	<script type="text/javascript">
		$(document).ready(function(){

			$('#complaintMgmtLi').addClass('active');
			$('#inboxLi').addClass('active');

			App.init();
			Dashboard.init();
			Chart.init();
		});
	</script>