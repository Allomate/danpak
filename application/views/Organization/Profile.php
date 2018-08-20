<?php require_once(APPPATH.'/views/includes/header.php'); ?>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once(APPPATH.'/views/includes/navbar&sidebar.php'); ?>
	<div class="page-wrapper">
		<div class="container">
			<div class="row heading-bg">
				<div class="col-lg-6 col-md-6 col-sm-6">
					<h2 class="m-heading">Organization</h2>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6">
					<ol class="breadcrumb">
						<li><a href="#"><span>Organization</span></a></li>
						<li><span>Company Profile</span></li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="box-white m-b-30">    	
						<div class="form-wrap">
							<div class="upload-pic">Upload logo image maximam size 500X500 px</div>
							<input type="file" id="input-file-now" class="dropify" />
						</div> 
					</div>
					<div class="box-white m-b-30">
						<h2>Change password</h2>
						<div class="form-wrap">
							<form action="#">
								<div class="form-body">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label mb-10">Old password</label>
												<input type="text" id="firstName" class="form-control" placeholder="">
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label mb-10">New password</label>
												<input type="Password" id="firstName" class="form-control" placeholder="">
											</div>
										</div>
									</div>		 	  
								</div>
							</form>
						</div> 
					</div>
				</div>
				<div class="col-md-8">
					<div class="box-white m-b-30">
						<h2>Company Profile</h2>
						<div class="form-wrap">
							<form action="#">
								<div class="form-body">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label mb-10">POC</label>
												<input type="text" id="firstName" class="form-control" placeholder="">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label mb-10">Company Name</label>
												<input type="text" id="firstName" class="form-control" placeholder="">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label mb-10">Email</label>
												<input type="text" id="firstName" class="form-control" placeholder="">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label mb-10">Phone</label>
												<input type="text" id="firstName" class="form-control" placeholder="">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label mb-10">Website</label>
												<input type="text" id="firstName" class="form-control" placeholder="">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label mb-10">City</label>
												<input type="text" id="firstName" class="form-control" placeholder="">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label mb-10">Address</label>
												<input type="text" id="firstName" class="form-control" placeholder="">
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="form-bottom">
					<div class="button-section align-right">
						<a href="#" class="btn btn-cancel">Cancel</a>
						<a href="#" class="btn btn-save" type="button">Save</a>						
					</div>
					<div class="container">			    
						<div class="col-md-9">
							<div class="alert alert-success alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Opps! Somthing went wrong. 
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
