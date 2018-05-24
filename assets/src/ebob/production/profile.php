<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
include 'header.php';
?>

<!-- begin #page-loader -->
<!-- <div id="page-loader" class="fade in"><span class="spinner"></span></div> -->
<!-- end #page-loader -->

<!-- begin #page-container -->
<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
	<?php include 'navbar.php';?>
	<?php include 'sidebar.php';?>

	<!-- begin #content -->
	<div id="content" class="content">
		<!-- begin breadcrumb -->
		<ol class="breadcrumb pull-right">
			<li class="active">Profile</li>
		</ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header">Profile Page <small>header small text goes here...</small></h1>
		<!-- end page-header -->
		<!-- begin profile-container -->
		<div class="profile-container">
			<!-- begin profile-section -->
			<div class="profile-section">
				<!-- begin profile-left -->
				<div class="profile-left">
					<!-- begin profile-image -->
					<?php
					require_once 'database/config.php';
					$sql = "SELECT `employee_id`, `employee_name`, `employee_username`, `employee_password`, `employee_address`, `employee_city`, `employee_country`, `employee_picture`, (SELECT franchise_name from franchise_info where franchise_id = ei.franchise_id) as `franchise_name`, (SELECT company_name from company_info where company_id = ei.company_id) as `company_id`, (SELECT employee_username from employees_info where employee_id = ei.reporting_to) as `reporting_to`, `employee_cnic`, `employee_hire_at`, (SELECT role_name from employee_roles where role_id = ei.employee_role_id) as `employee_role`, `employee_phone`, `employee_salary`FROM `employees_info` ei where employee_username = (SELECT employee from employee_session where session = ?)";
					$stmt = $conn->prepare($sql);
					$stmt->bind_param('s', $_COOKIE["US-K"]);
					$stmt->execute();
					$stmt->bind_result($id, $name, $username, $password, $address, $city, $country, $picture, $franchise, $company, $reportingTo, $cnic, $hiredAt, $role, $phone, $salary);
					$stmt->fetch();
					?>
					<div class="profile-image">
						<img src="<?php echo $picture;?>" />
						<i class="fa fa-user hide"></i>
					</div>
					<!-- end profile-image -->
					<div class="m-b-10">
						<a href="#" class="btn btn-warning btn-block btn-sm changePictureBtn" onclick="document.getElementById('profileImageInput').click()">Change Picture</a>
						<a href="#" class="btn btn-warning btn-block btn-sm updateProfileBtn" style="display: none">Update</a>
						<form method="POST" enctype="multipart/form-data" id="profImgUpload">
							<input type="file" id="profileImageInput" name="profile_picture" style="display: none" />
						</form>
					</div>
				</div>
				<!-- end profile-left -->
				<!-- begin profile-right -->
				<div class="profile-right">
					<!-- begin profile-info -->
					<div class="profile-info">
						<!-- begin table -->
						<div class="table-responsive">
							<table class="table table-profile">
								<thead>
									<tr>
										<th></th>
										<th>
											<h4><?php echo $name;?> <small><?php echo $role;?></small></h4>
										</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="field">Mobile</td>
										<td><i class="fa fa-mobile fa-lg m-r-5"></i> <span><?php echo $phone;?></span> <a href="#" class="m-l-5">Edit</a></td>
									</tr>
									<tr>
										<td class="field">Country/Region</td>
										<td><?php echo $country;?></td>
									</tr>
									<tr>
										<td class="field">City</td>
										<td><?php echo $city;?></td>
									</tr>
									<tr>
										<td class="field">Reporting To</td>
										<td><?php echo $reportingTo=="" ? "None" : $reportingTo; $stmt->close();?></td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- end table -->
					</div>
					<!-- end profile-info -->
				</div>
				<!-- end profile-right -->
			</div>
			<!-- end profile-section -->
			<!-- begin profile-section -->
			<div class="profile-section">
				<!-- begin row -->
				<div class="row">
					<!-- begin col-4 -->
					<div class="col-md-4">
						<?php
						require_once 'database/config.php';
						$sql = "SELECT count(complain_id) as totalComplains from complains com where company_id = (SELECT company_id from employees_info ei where ei.employee_username = (SELECT employee from employee_session where session = ?)) and department_id in (SELECT department_id from employee_departments_mapping where employee_id = (SELECT employee_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))) and complain_status = ?";
						$stmt=$conn->prepare($sql);
						$status = "pending";
						$tadTimeClose = date('Y:m:d H:m:s');
						$stmt->bind_param('sss', $_COOKIE["US-K"], $_COOKIE["US-K"], $status);
						$stmt->execute();
						$stmt->bind_result($totalComplains);
						$stmt->fetch();
						?>
						<h4 class="title">Message <small><?php echo $totalComplains; $stmt->close();?> messages</small></h4>
						<!-- begin scrollbar -->
						<div data-scrollbar="true" style="max-height: 280px" class="bg-silver">
							<!-- begin chats -->
							<ul class="chats">
								<li class="left">
									<?php
									require_once 'database/config.php';
									$sql = "SELECT complain_id, (SELECT user_name from users where user_id = com.user_id) as user, user_comments, (SELECT user_dp from users where user_id = com.user_id) as user_dp, tad_time_start, TIMESTAMPDIFF(HOUR, tad_time_start, ?) as tad_time_diff from complains com where company_id = (SELECT company_id from employees_info ei where ei.employee_username = (SELECT employee from employee_session where session = ?)) and department_id in (SELECT department_id from employee_departments_mapping where employee_id = (SELECT employee_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))) and complain_status = ?";
									$stmt=$conn->prepare($sql);
									$status = "pending";
									$tadTimeClose = date('Y:m:d H:m:s');
									$stmt->bind_param('ssss', $tadTimeClose, $_COOKIE["US-K"], $_COOKIE["US-K"], $status);
									$stmt->execute();
									$stmt->bind_result($complainId, $user, $user_comments, $user_dp, $time, $tadTimeDiff);
									while($stmt->fetch()){?>
									<li class="left">
										<span class="date-time"><?php echo $time;?> <strong>(TAD: <?php echo $tadTimeDiff." hrs";?>)</strong></span>
										<a href="javascript:;" class="name"><?php echo $user;?></a>
										<a href="javascript:;" class="image"><img alt="" src="assets/img/user-12.jpg"></a>
										<div class="message">
											<?php echo $user_comments;?>
										</div>
										<a style="float: right; margin-right: 10px; cursor: pointer;" class="viewInboxComplain" id="<?php echo $complainId;?>">View Inbox</a>
									</li>
									<?php }
									?>
								</li>
							</ul>
							<!-- end chats -->
						</div>
						<!-- end scrollbar -->
					</div>
					<!-- end col-4 -->
					<!-- begin col-4 -->
					<div class="col-md-4">
						<h4 class="title">Task <small>0 pending</small></h4>
						<!-- begin scrollbar -->
						<div data-scrollbar="true" style="max-height: 280px" class="bg-silver">
							<!-- begin todolist -->
							<ul class="todolist">
								<li>
									<a href="javascript:;" class="todolist-container" data-click="todolist">
										<div class="todolist-title">No tasks pending</div>
									</a>
								</li>
							</ul>
							<!-- end todolist -->
						</div>
						<!-- end scrollbar -->
					</div>
					<!-- end col-4 -->
				</div>
				<!-- end row -->
			</div>
			<!-- end profile-section -->
		</div>
		<!-- end profile-container -->
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
<?php 
include 'footer.php';?>
<script type="text/javascript" src="script/index-profile-script.js?v=<?php echo time();?>"></script>
<script type="text/javascript" src="script/sidebar-script.js?v=<?php echo time();?>"></script>
<script src="http://malsup.github.com/jquery.form.js"></script> 

<script type="text/javascript">
	$(document).ready(function(){
		App.init();
		Dashboard.init();
		$('.nav li').removeClass('active');
		$('#profileDashboardLi').addClass('active');
	});
</script>

<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo 'Page generated in '.$total_time.' seconds.';?>