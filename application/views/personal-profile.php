<?php require_once(APPPATH.'/views/includes/header.php'); ?>
<!-- <div class="preloader-it">
	<div class="la-anim-1"></div>
</div> -->
<div class="wrapper theme-1-active">
	<?php require_once(APPPATH.'/views/includes/navbar&sidebar.php'); ?>
	<?php require_once(APPPATH.'/views/includes/home-sidebar-data.php'); ?>
	<div class="page-wrapper">
		<div class="container">
			<div class="row heading-bg">
				<div class="col-lg-6 col-md-6">
					<h2 class="m-heading">Employee </h2>
				</div>
				<div class="col-lg-6 col-md-6">
					<ol class="breadcrumb">
						<li><a href="#"><span>User Profile </span></a></li>
						<li><span>Profile</span></li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<div class="box-white m-b-30">
						<h2 class="mt-0">User Profile</h2>
						<div class="form-wrap _user-profile">
							<form action="#">
								<div class="form-body">
									<div class="row">
										<div class="col-md-6 p-col-L">
											<div class="form-group">
												<label class="control-label mb-10">First Name</label>
												<p>
													<?= $info->employee_first_name; ?>
													<p>
											</div>
										</div>
										<div class="col-md-6 p-col-R">
											<div class="form-group">
												<label class="control-label mb-10">Last Name</label>
												<p>
													<?= $info->employee_last_name; ?>
												</p>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 p-col-L">
											<div class="form-group">
												<label class="control-label mb-10">Phone No</label>
												<p>
													<?= $info->employee_phone; ?>
												</p>
											</div>
										</div>
										<div class="col-md-6 p-col-R">
											<div class="form-group">
												<label class="control-label mb-10">Email ID</label>
												<p>
													<?= $info->employee_email; ?>
												</p>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 p-col-L">
											<div class="form-group">
												<label class="control-label mb-10">CNIC</label>
												<p>
													<?= $info->employee_cnic; ?>
												</p>
											</div>
										</div>
										<div class="col-md-6 p-col-R">
											<div class="form-group">
												<label class="control-label mb-10">City</label>
												<p>
													<?= $info->employee_city; ?>
												</p>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label mb-10">Address</label>
												<p>
													<?= $info->employee_address; ?>
												</p>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 p-col-L">
											<div class="form-group">
												<label class="control-label mb-10">Designation</label>
												<p>
													<?= $info->employee_designation; ?>
												</p>
											</div>
										</div>
										<div class="col-md-6 p-col-R">
											<div class="form-group">
												<label class="control-label mb-10">Reporting To</label>
												<p>
													<?= $info->reporting_to; ?>
												</p>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="box-white m-b-30 _user-profile-R">
						<h2 class="mt-0">Setting</h2>
						<div class="form-wrap">
							<div class="upload-pic">Upload logo image maximam size 500X500 px</div>
							<form id="updateProfileImgForm" enctype="multipart/form-data" method="post" accept-charset="utf-8">
								<input type="file" id="input-file-now" name="employee_picture" class="dropify" data-default-file="<?= file_exists($_SERVER['DOCUMENT_ROOT'].$info->employee_picture) ? $info->employee_picture : "/assets/images/no-image.png";
								 ?>" />
							</form>
						</div>
						<hr>
						<div class="form-wrap">
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label mb-10">Password</label>
											<input type="password" name="changePw" class="form-control" value="******">
										</div>
									</div>
									<div class="col-md-12">
										<a id="changePw" class="btn btn-blue-sm" data-toggle="modal" data-target="#MainCategory" data-whatever="@mdo">Change
											Password</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="form-bottom">
					<div class="button-section align-right">
						<!-- <a href="#" class="btn btn-cancel">Cancel</a> -->
						<a href="#" class="btn btn-save" id="saveImg">Save</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script type="text/javascript">
	$(document).ready(function () {

		$(document).on('click', '#saveImg', function () {
			var thisRef = $(this);
			thisRef.attr('disabled', 'disabled');
			thisRef.text("Please Wait...");
			$('#updateProfileImgForm').ajaxSubmit({
				type: 'POST',
				url: '/Employees/UpdateEmployeeProfilePicture',
				data: $('#updateProfileImgForm').serialize(),
				success: function (response) {
					var response = JSON.parse(response);
					if (response["status"]) {
						thisRef.text("Picture saved");
						thisRef.css("background-color", "green");
						setTimeout(() => {
							thisRef.text("Save");
							thisRef.css("background-color", "#001e35");
							thisRef.removeAttr('disabled');
						}, 3000);
						$('.user-auth-img').attr('src', response["image"])
					}
				}
			});
		});

		$(document).on('click', '#changePw', function () {
			var thisRef = $(this);
			thisRef.attr('disabled', 'disabled');
			thisRef.text("Please Wait...");
			$.ajax({
				type: 'POST',
				url: '/Employees/ChangePwAjax',
				data: {
					'pw': $('input[name="changePw"]').val()
				},
				success: function (response) {
					if (response) {
						thisRef.text("Password Changed");
						thisRef.css("background-color", "green");
						setTimeout(() => {
							thisRef.text("Change Password");
							thisRef.css("background-color", "#001e35");
							thisRef.removeAttr('disabled');
						}, 3000);
					}
				}
			});
		});

	});

</script>
