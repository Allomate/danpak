<?php require_once APPPATH . '/views/includes/header.php';?>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once APPPATH . '/views/includes/navbar&sidebar.php';?>
	<div class="page-wrapper">
		<div class="container">
			<!-- Title -->
			<div class="row heading-bg">
				<div class="col-lg-6 col-md-6">
					<h2 class="m-heading">Employee Management</h2>
				</div>
				<!-- Breadcrumb -->
				<div class="col-lg-6 col-md-6">
					<ol class="breadcrumb">
						<li>
							<a href="#">
								<span>Organization</span>
							</a>
						</li>
						<li>
							<span>Employee Management</span>
						</li>
						<li>
							<span>Add KPI</span>
						</li>
					</ol>
				</div>
				<!-- /Breadcrumb -->
			</div>
			<!-- /Title -->
			<div class="row">
				<div class="col-md-12">
					<div class="box-white p-20">
						<h2 class="m-b-0">Employee Info</h2>
						<div class="bg-gl clearfix m-b-30">
							<div class="col-md-4">
								<div class="form-group">
									<label class="control-label mb-10">
										<strong>Name:</strong> Saad Khan</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="control-label mb-10">
										<strong>Designation:</strong> Sales Manager</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="control-label mb-10">
										<strong>Mobile No:</strong> 03220122444</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="control-label mb-10">
										<strong>Territory:</strong> Wapda/PIA</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="control-label mb-10">
										<strong>Area:</strong> Lahore</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="control-label mb-10">
										<strong>Region:</strong> Central</label>
								</div>
							</div>
						</div>
						<h2 class="m-b-15">Selected the KPI Evaluation Period</h2>
						<div class="radio radio-info m-b-15">
							<input type="radio" name="radio" id="radio1" value="option1" checked="">
							<label for="radio1" class="rad-large">Monthly</label>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<select class="selectpicker" data-style="form-control btn-default btn-outline">
										<option>Select month</option>
									</select>
								</div>
							</div>
						</div>
						<hr>
						<div class="radio radio-info">
							<input type="radio" name="radio" id="radio2" value="option1" checked="">
							<label for="radio2" class="rad-large">Quarterly</label>
						</div>
						<div class="row m-t-10">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label mb-10">Start</label>
									<select class="selectpicker" data-style="form-control btn-default btn-outline">
										<option>Select month</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label mb-10">End</label>
									<select class="selectpicker" data-style="form-control btn-default btn-outline">
										<option>Select month</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<button type="button" class="btn btn-save m-t-10" data-toggle="modal" data-target="#MainCategory">
									<i class="fa fa-plus"> </i> Add KPI</button>
							</div>
						</div>
					</div>
					<div class="modal fade bs-example-modal-lg" id="MainCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
									<h5 class="modal-title" id="exampleModalLabel1">Select KPI Type</h5>
								</div>
								<div class="modal-body">
									<div class="col-md-12  m-b-30">
										<div class="checkbox checkbox-primary checkbox-circle m-b-20">
											<input id="Product001" type="checkbox" value="">
											<label for="Product001" class="lab-large"> Product Wise Sales </label>
										</div>
										<div class="checkbox checkbox-primary checkbox-circle m-b-20">
											<input id="quantity001" type="checkbox" value="">
											<label for="quantity001" class="lab-large">Quantity Wise Sales </label>
										</div>
										<div class="checkbox checkbox-primary checkbox-circle m-b-20">
											<input id="revenue001" type="checkbox" value="">
											<label for="revenue001" class="lab-large">Revenue Wise Sales </label>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									<button type="button" class="btn btn-primary">Save</button>
								</div>
							</div>
						</div>
					</div>
					<div class="box-white p-20 m-t-30">
						<h2 class="m-b-15">Add KPI </h2>
						<h5>Product Wise </h5>
						<br>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label mb-10">Product</label>
									<select class="selectpicker" data-style="form-control btn-default btn-outline">
										<option>Select product</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label mb-10">Unit</label>
									<select class="selectpicker" data-style="form-control btn-default btn-outline">
										<option>Select unit</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label mb-10">Target</label>
									<input type="text" id="Target" class="form-control" placeholder="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label mb-10">Eligibility</label>
									<input type="text" id="Eligibility" class="form-control" placeholder="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label mb-10">Weightage</label>
									<input type="text" id="Incentive" class="form-control" placeholder="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label mb-10">Incentive</label>
									<input type="text" id="Incentive" class="form-control" placeholder="">
								</div>
							</div>
							<div class="col-md-12">
								<div class="progress progress-lg m-t-30">
									<div class="progress-bar progress-bar-danger" style="width: 75%;" role="progressbar">75%</div>
								</div>
							</div>
						</div>
						<br>
						<br>
						<br>
						<h5>Quantity Wise </h5>
						<br>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label mb-10">Unit</label>
									<select class="selectpicker" data-style="form-control btn-default btn-outline">
										<option>Select unit</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label mb-10">Target</label>
									<input type="text" id="Target" class="form-control" placeholder="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label mb-10">Eligibility</label>
									<input type="text" id="Eligibility" class="form-control" placeholder="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label mb-10">Weightage</label>
									<input type="text" id="Incentive" class="form-control" placeholder="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label mb-10">Incentive</label>
									<input type="text" id="Incentive" class="form-control" placeholder="">
								</div>
							</div>
							<div class="col-md-12">
								<div class="progress progress-lg m-t-30">
									<div class="progress-bar progress-bar-danger" style="width: 75%;" role="progressbar">75%</div>
								</div>
							</div>
						</div>
						<br>
						<br>
						<br>
						<h5>Revenue Wise </h5>
						<br>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label mb-10">Target</label>
									<input type="text" id="Target" class="form-control" placeholder="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label mb-10">Eligibility</label>
									<input type="text" id="Eligibility" class="form-control" placeholder="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label mb-10">Weightage</label>
									<input type="text" id="Incentive" class="form-control" placeholder="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label mb-10">Incentive</label>
									<input type="text" id="Incentive" class="form-control" placeholder="">
								</div>
							</div>
							<div class="col-md-12">
								<div class="progress progress-lg m-t-30">
									<div class="progress-bar progress-bar-danger" style="width: 75%;" role="progressbar">75%</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /Row -->
		</div>
	</div>
</div>
<?php require_once APPPATH . '/views/includes/footer.php';?>
<script type="text/javascript" src="<?=base_url('assets/js/Retailers.js') . '?v=' . time();?>"></script>
