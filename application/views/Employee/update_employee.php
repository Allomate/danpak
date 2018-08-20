<?php require_once(APPPATH.'/views/includes/header.php'); ?>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once(APPPATH.'/views/includes/navbar&sidebar.php'); ?>
	<div class="page-wrapper">
		<div class="container-fluid">
			<div class="row heading-bg">
				<div class="col-lg-6 col-md-6 col-sm-6">
					<h2 class="m-heading">Update Employee</h2>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6">
					<ol class="breadcrumb">
						<!--<li>
							<a href="#">
								<span>Organization</span>
							</a>
						</li>-->
						<li>
							<span>Employee Management</span>
						</li>
						<li class="active">
							<span>Update Employee</span>
						</li>
					</ol>
				</div>
			</div>
			<div class="row">
				<?php $attributes = array('id' => 'updateEmployeeForm');
				echo form_open_multipart('employees/update_employee_operation/'.$employee->employee_id, $attributes); ?>
				<div class="col-md-8">
					<div class="box-white m-b-30">
						<h2>Employee Details</h2>
						<div class="form-wrap">
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">First Name*</label>
											<input type="text" name="employee_first_name" class="form-control" placeholder="" value="<?= $employee->employee_first_name; ?>">
											<?= form_error('employee_first_name', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Last Name</label>
											<input type="text" name="employee_last_name" class="form-control" value="<?= $employee->employee_last_name;?>" />
											<?= form_error('employee_last_name', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Phone No</label>
											<input type="text" name="employee_phone" class="form-control" value="<?= $employee->employee_phone;?>" />
											<?= form_error('employee_phone', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Email ID</label>
											<input type="text" name="employee_email" class="form-control" value="<?= $employee->employee_email;?>" />
											<?= form_error('employee_email', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">CNIC</label>
											<input type="text" name="employee_cnic" class="form-control" value="<?= $employee->employee_cnic;?>" />
											<?= form_error('employee_cnic', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">City*</label>
											<input type="text" name="employee_city" class="form-control" value="<?= $employee->employee_city;?>" />
											<?= form_error('employee_city', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Employee Base Station Latitude*</label>
											<input type="text" name="employee_base_station_lats" class="form-control" value="<?= $employee->employee_base_station_lats;?>"
											/>
											<?= form_error('employee_base_station_lats', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Employee Base Station Longitude*</label>
											<input type="text" name="employee_base_station_longs" class="form-control" value="<?= $employee->employee_base_station_longs;?>"
											/>
											<?= form_error('employee_base_station_longs', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label mb-10">Address*</label>
											<input type="text" name="employee_address" class="form-control" value="<?= $employee->employee_address;?>" />
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
											<?php
											$options["CEO"] = "CEO";
											$options["Director"] = "Director";
											$options["GM Sales"] = "GM Sales";
											$options["NSM"] = "NSM";
											$options["RSM"] = "RSM";
											$options["ASM"] = "ASM";
											$options["TSO"] = "TSO";
											$options["Order Booker"] = "Order Booker";
											$options["Office Staff"] = "Office Staff";
											$atts = array( 'class' => 'selectpicker', 'data-style' => 'form-control btn-default btn-outline' );
											echo form_dropdown('employee_designation', $options, $employee->employee_designation, $atts); ?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Salary</label>
											<input type="text" name="employee_salary" class="form-control" value="<?= $employee->employee_salary;?>" />
											<?= form_error('employee_salary', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Reporting To</label>
											<?php
											$optionsReporting["0"] = "No reporting";
											foreach ($employees_list as $employee_detail) : 
												$optionsReporting[$employee_detail->employee_id] = $employee_detail->employee_username;
											endforeach; 
											$atts = array( 'class' => 'selectpicker', 'data-style' => 'form-control btn-default btn-outline' );
											echo form_dropdown('reporting_to', $optionsReporting, $employee->reporting_to, $atts); ?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Territory*</label>
											<?php
											$optionsNew["0"] = "Please select a territory";
											foreach ($territories as $territory) : 
												$optionsNew[$territory->id] = $territory->territory_name;
											endforeach; 
											$atts = array( 'class' => 'selectpicker', 'data-style' => 'form-control btn-default btn-outline', 'id' => 'territoryDD' );
											echo form_dropdown('territory_id', $optionsNew, $employee->territory_id, $atts); ?>
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
							<input type="file" name="employee_picture" id="employee_picture" class="dropify" data-default-file="<?= str_replace('./', base_url(), $employee->employee_picture); ?>"
							/>
						</div>
					</div>
					<div class="box-white m-b-30">
						<h2>Update User</h2>
						<div class="form-wrap">
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label mb-10">Password</label>
											<input type="Password" name="employee_password" class="form-control" />
											<?= form_error('employee_password', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="box-white m-t-30 m-b-30">
						<h2>Access Rights</h2>
						<div class="form-wrap">
							<h5>Is this employee an Admin?</h5>
							<div class="radio radio-info m-b-15">
								<?php if($employee->is_admin == "1") : ?>
								<input type="radio" name="is_admin" id="radio1" value="1" checked>
								<?php else: ?>
								<input type="radio" name="is_admin" id="radio1" value="1">
								<?php endif; ?>
								<label for="radio1" class="rad-large">Yes
									<strong>(Be Careful)</strong>
								</label>
							</div>
							<div class="radio radio-info m-b-15">
								<?php if($employee->is_admin !== "1") : ?>
								<input type="radio" name="is_admin" id="radio2" value="0" checked>
								<?php else: ?>
								<input type="radio" name="is_admin" id="radio2" value="0">
								<?php endif; ?>
								<label for="radio2" class="rad-large">No</label>
							</div>
						</div>
					</div>
				</div>
				<input type="text" name="picture_deleted" hidden>
				</form>
			</div>
			<div class="row button-section">
				<a href="<?= base_url('Employees/ListEmployees'); ?>" type="button" class="btn btn-cancel" id="backFromEmployeeButton">Cancel</a>
				<a type="button" id="updateEmployeeButton" class="btn btn-save">Save</a>
			</div>
		</div>
	</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script type="text/javascript" src="<?= base_url('assets/js/Employee.js').'?v='.time(); ?>"></script>
