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
					<h2 class="m-heading">Distributor Management</h2>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6">
					<ol class="breadcrumb">
						<li>
							<a href="#">
								<span>Organization</span>
							</a>
						</li>
						<li>
							<span>Distributor Management</span>
						</li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="box-white m-b-30">
						<h2>Add Distributor</h2>
						<?php $attributes = array('id' => 'updateRetailerForm');
						echo form_open('Retailers/UpdateRetailerOps/'.$Retailer->id, $attributes);
						echo form_hidden("assignedEmployees", "") ?>
						<div class="form-wrap">
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Distributor Username*</label>
											<input type="text" name="retailer_email" class="form-control" value="<?= $Retailer->retailer_email; ?>">
											<?= form_error('retailer_email', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Distributor Password*</label>
											<input type="password" name="distributor_password" class="form-control" value="<?= $Retailer->distributor_password; ?>">
											<?= form_error('distributor_password', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Distributor Name*</label>
											<input type="text" name="retailer_name" class="form-control" value="<?= $Retailer->retailer_name; ?>">
											<?= form_error('retailer_name', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Distributor Phone</label>
											<input type="text" name="retailer_phone" class="form-control" value="<?= $Retailer->retailer_phone; ?>">
											<?= form_error('retailer_phone', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Distributor Type*</label>
											<select class="selectpicker" name="retailer_type_id" data-style="form-control btn-default btn-outline">
												<?php foreach( $RetailerTypes as $type ) : ?>
												<option value="<?= $type->id; ?>">
													<?= $type->retailer_type_name; ?>
												</option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Distributor Territory*</label>
											<?php
												foreach ($Territories as $territory) : 
													$options[$territory->id] = $territory->territory_name;
												endforeach; 
												$atts = array( 'class' => 'form-control' );
												echo form_dropdown('retailer_territory_id', $options, $Retailer->retailer_territory_id, $atts); ?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Distributor Latitude</label>
											<input type="text" name="retailer_lats" class="form-control" value="<?= $Retailer->retailer_lats; ?>">
											<?= form_error('retailer_lats', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Distributor Longitude</label>
											<input type="text" name="retailer_longs" class="form-control" value="<?= $Retailer->retailer_longs; ?>">
											<?= form_error('retailer_longs', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Distributor City*</label>
											<input type="text" name="retailer_city" class="form-control" value="<?= $Retailer->retailer_city; ?>">
											<?= form_error('retailer_city', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
								</div>
								<hr>
								<center>
									<h3>T.S.O & O.B Assignments</h3>
								</center>
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label class="control-label mb-10">Select ASM/RSM</label>
											<select class="form-control" name="asmOrRsm" data-style="form-control btn-default btn-outline">
												<?php foreach( $RsmAsm as $rsm ) : ?>
												<option value="<?= $rsm->employee_id; ?>">
													<?= $rsm->employee_username; ?>
												</option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label class="control-label mb-10">Select T.S.O</label>
											<div style="width: 100%">
												<select style="width: 75%; display: inline-block" class="form-control" name="tso" data-style="form-control btn-default btn-outline">
													<option value="0">Select T.S.O</option>
													<?php foreach( $RsmAsm as $rsm ) : ?>
													<option value="<?= $rsm->employee_id; ?>">
														<?= $rsm->employee_username; ?>
													</option>
													<?php endforeach; ?>
												</select>
												<span id="addTso" style="cursor: pointer; width: 20%;display: inline-block;padding-top: 8px;padding-bottom: 8px;text-align: center;background: #001e35;color: white;font-weight: bold;box-shadow: 0 2px 8px 0 #e5d6d6;">+</span>
											</div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label class="control-label mb-10">Select O.B</label>
											<div style="width: 100%">
												<select style="width: 75%; display: inline-block" class="form-control" name="orderBooker" data-style="form-control btn-default btn-outline">
													<option value="0">Select O.B</option>
													<?php foreach( $RsmAsm as $rsm ) : ?>
													<option value="<?= $rsm->employee_id; ?>">
														<?= $rsm->employee_username; ?>
													</option>
													<?php endforeach; ?>
												</select>
												<span id="addOb" style="cursor: pointer; width: 20%;display: inline-block;padding-top: 8px;padding-bottom: 8px;text-align: center;background: #001e35;color: white;font-weight: bold;box-shadow: 0 2px 8px 0 #e5d6d6;">+</span>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label mb-10">Added O.B(s) & T.S.O(s)</label>
											<ul id="addedEmployees">
												<?php foreach($EmployeesAssigned as $emp ){ ?>
												<li style="cursor:pointer; display: inline-block; width: 300px !important;">
													<span style="box-shadow: 0 2px 8px 0 #e5d6d6; padding: 10px; width: 75%; margin-bottom: 10px; display: inline-block;">
														<?= $emp->username." ".($emp->username == "TSO" ? " (T.S.O)" : " (O.B)"); ?></span>
													<span id="<?= $emp->employee_id; ?>" class="removeAddedEmployee" style="width: 20%; height: 42px; display: inline-block;padding-top: 8px;padding-bottom: 8px;text-align: center;background: red;color: white;font-weight: bold;box-shadow: 0 2px 8px 0 #e5d6d6;">x</span>
												</li>
												<?php } ?>
											</ul>
										</div>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label mb-10">Distributor Address*</label>
											<textarea type="text" name="retailer_address" class="form-control" placeholder="Enter Address" rows="5">
												<?= $Retailer->retailer_address; ?>
											</textarea>
											<?= form_error('retailer_address', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
								</div>
							</div>
						</div>
						</form>
					</div>
				</div>
			</div>
			<div class="row button-section">
				<a type="button" href="<?= base_url('Retailers/ListRetailers'); ?>" id="backFromRetailersButton" class="btn btn-cancel">Cancel</a>
				<a type="button" id="updateRetailerButton" class="btn btn-save">Save</a>
			</div>
		</div>
	</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script type="text/javascript" src="<?= base_url('assets/js/Retailers.js').'?v='.time(); ?>"></script>
