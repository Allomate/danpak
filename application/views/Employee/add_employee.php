<?php require_once(APPPATH.'/views/includes/header.php'); ?>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once(APPPATH.'/views/includes/navbar&sidebar.php'); ?>
	<div class="page-wrapper">
		<div class="container-fluid">
			<div class="row heading-bg">
				<div class="col-lg-6 col-md-6">
					<h2 class="m-heading">Add New Employee</h2>
				</div>
				<div class="col-lg-6 col-md-6">
					<ol class="breadcrumb">
						<li><a href="#"><span>Organization</span></a></li>
						<li><span>Employee Management</span></li>
						<li class="active"><span>Add New Employee</span></li>
					</ol>
				</div>
			</div>
			<div class="row">
				<?php $attributes = array('id' => 'addEmployeeForm');
				echo form_open_multipart('employees/add_employee_operation', $attributes); ?>
				<div class="col-md-8">
					<div class="box-white m-b-30">
						<h2>Employee Details</h2>
						<div class="form-wrap">
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">First Name*</label>
											<input type="text" name="employee_first_name" class="form-control" placeholder="" value="<?= set_value('employee_first_name'); ?>">
											<?= form_error('employee_first_name', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Last Name</label>
											<input type="text" name="employee_last_name" class="form-control" value="<?= set_value('employee_last_name');?>"/>
											<?= form_error('employee_last_name', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Phone No</label>
											<input type="text" name="employee_phone" class="form-control" value="<?= set_value('employee_phone');?>"/>
											<?= form_error('employee_phone', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Email ID</label>
											<input type="text" name="employee_email" class="form-control" value="<?= set_value('employee_email');?>"/>
											<?= form_error('employee_email', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">CNIC</label>
											<input type="text" name="employee_cnic" class="form-control" value="<?= set_value('employee_cnic');?>"/>
											<?= form_error('employee_cnic', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">City*</label>
											<input type="text" name="employee_city" class="form-control" value="<?= set_value('employee_city');?>"/>
											<?= form_error('employee_city', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Employee Base Station Latitude*</label>
											<input type="text" name="employee_base_station_lats" class="form-control" value="<?= set_value('employee_base_station_lats');?>"/>
											<?= form_error('employee_base_station_lats', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Employee Base Station Longitude*</label>
											<input type="text" name="employee_base_station_longs" class="form-control" value="<?= set_value('employee_base_station_longs');?>"/>
											<?= form_error('employee_base_station_longs', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label mb-10">Address*</label>
											<input type="text" name="employee_address" class="form-control" value="<?= set_value('employee_address');?>"/>
											<?= form_error('employee_address', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="box-white m-b-30">
						<h2>Assign</h2>
						<div class="form-wrap">
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Designation*</label>
											<input type="text" name="employee_designation" class="form-control" value="<?= set_value('employee_designation');?>"/>
											<?= form_error('employee_designation', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Salary</label>
											<input type="text" name="employee_salary" class="form-control" value="<?= set_value('employee_salary');?>"/>
											<?= form_error('employee_salary', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Reporting To</label>
											<select class="selectpicker" data-style="form-control btn-default btn-outline" name="reporting_to">
												<option value="0" disabled="disabled" selected="selected">No reporting</option>
												<?php foreach ($employees as $employee) : ?>
													<option value="<?= $employee->employee_id; ?>"> <?= $employee->employee_username; ?> </option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Territory*</label>
											<select class="selectpicker" data-style="form-control btn-default btn-outline" id="territoryDD" name="territory_id">
												<option value="0" disabled="disabled" selected="selected">Please select a territory</option>
												<?php foreach ($territories as $territory) : ?>
													<option value="<?= $territory->id; ?>"> <?= $territory->territory_name; ?> </option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="box-white m-b-30">    	
						<div class="form-wrap">
							<div class="upload-pic">Upload picture maximam size 500X500 px</div>
							<input type="file" name="employee_picture" id="employee_picture" class="dropify"/>
							<?= isset($employee_picture_error) ? '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">'.$employee_picture_error.'</small>' : '';?>
						</div> 
					</div>
					<div class="box-white m-b-30">
						<h2>Create User</h2>
						<div class="form-wrap">
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label mb-10">Username*</label>
											<input type="text" name="employee_username" class="form-control" value="<?= set_value('employee_username');?>"/>
											<?= form_error('employee_username', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label mb-10">Password*</label>
											<input type="Password" name="employee_password" class="form-control"/>
											<?= form_error('employee_password', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
								</div>		 	  
							</div>
						</div> 
					</div>
					<div class="box-white m-t-30">
						<h2>Access Rights</h2>
						<!-- <div class="form-wrap">
							<form action="#">
								<div class="row">
									<div class="col-md-12">
										<div class="switch-sec">
											<label class="control-label float-L">Admin User</label>
											<div class="float-R"><input type="checkbox" checked class="js-switch js-switch-1"  data-color="#001f37" data-size="small"/></div>
										</div>
										<div class="switch-sec">
											<label class="control-label float-L">Inventory Management</label>
											<div class="float-R"><input type="checkbox" checked class="js-switch js-switch-1"  data-color="#001f37" data-size="small"/></div>
										</div>
										<div class="switch-sec">
											<label class="control-label float-L">Catalogue Management</label>
											<div class="float-R"><input type="checkbox" checked class="js-switch js-switch-1"  data-color="#001f37" data-size="small"/></div>
										</div>
										<div class="switch-sec">
											<label class="control-label float-L">Active/Inactive</label>
											<div class="float-R"><input type="checkbox" checked class="js-switch js-switch-1"  data-color="#001f37" data-size="small"/></div>
										</div>
									</div>
								</div>		 	  
							</form>
						</div>  -->
					</div>					
				</div>
			</form>
		</div>
		<div class="row button-section">
			<a href="<?= base_url('Employees/ListEmployees'); ?>" type="button" class="btn btn-cancel" id="backFromEmployeeButton">Cancel</a>
			<a type="button" id="addEmployeeButton" class="btn btn-save">Save</a>
		</div>
	</div>
</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script type="text/javascript" src="<?= base_url('assets/js/Employee.js').'?v='.time(); ?>"></script>