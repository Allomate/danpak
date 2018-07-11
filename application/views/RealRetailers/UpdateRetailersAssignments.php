<?php require_once(APPPATH.'/views/includes/header.php'); ?>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once(APPPATH.'/views/includes/navbar&sidebar.php'); ?>
	<div class="page-wrapper">
		<div class="container-fluid">
			<?php if ($feedback = $this->session->flashdata('missing_information')) : ?>
			<div class="row" style="margin-top: 20px;">
				<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
					<strong>Missing Information</strong>
					<?= $feedback; ?>
				</div>
			</div>
			<?php endif; ?>
			<div class="row heading-bg">
				<div class="col-lg-6 col-md-6">
					<h2 class="m-heading">Retailer Assignment Management</h2>
				</div>
				<div class="col-lg-6 col-md-6">
					<ol class="breadcrumb">
						<li>
							<a href="#">
								<span>Organization</span>
							</a>
						</li>
						<li>
							<span>Retailer Assignment Management</span>
						</li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="box-white m-b-30">
						<h2>Update Retailer Assignment</h2>
						<?php $attributes = array('id' => 'updateRetailerAssignmentForm');
						echo form_open('RealRetailers/UpdateRetailerAssignemntsOps/'.$RetailersAssignment->employee_id, $attributes);
						echo form_hidden('existingAssignmentIds', $RetailersAssignment->retailer_assignment_id); ?>
						<div class="form-wrap">
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Select Employee</label>
											<?php
											foreach ($Employees as $employee) : 
												$options[$employee->employee_id] = $employee->employee_username;
											endforeach; 
											$atts = array( 'class' => 'selectpicker', "data-style" => "form-control btn-default btn-outline" );
											echo form_dropdown('employee', $options, $RetailersAssignment->employee_id, $atts); ?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Select Employee</label>
											<?php
											$optionsNew["monday"] = "Monday";
											$optionsNew["tuesday"] = "Tuesday";
											$optionsNew["wednesday"] = "Wednesday";
											$optionsNew["thursday"] = "Thursday";
											$optionsNew["friday"] = "Friday";
											$optionsNew["saturday"] = "Saturday";
											$optionsNew["sunday"] = "Sunday";
											$atts = array( 'class' => 'selectpicker', "data-style" => "form-control btn-default btn-outline" );
											echo form_dropdown('assigned_for_day', $optionsNew, $RetailersAssignment->assigned_for_day, $atts); ?>
										</div>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-md-6">
										<label class="control-label mb-10">Retailers Added</label>
										<ul style="list-style: none; padding: 0px" id="addedAssignmentsList">
											<?php 
											$RetailersAssignmentsUlListRetIds = explode(",", $RetailersAssignment->retailer_id);
											$RetailersAssignmentsUlListRetNames = explode("<>", $RetailersAssignment->retailer_names);
											for($i = 0; $i < sizeof($RetailersAssignmentsUlListRetIds); $i++) : ?>
											<li style="margin-top: 10px">
												<div>
													<input type="text" value="<?= $RetailersAssignmentsUlListRetNames[$i] ?> " class="form-control" style="width: 70%; display: inline; height: 50px"
													disabled="disabled">
													<button type="button" class="btn btn-danger removeAddedAssignment" id="<?= $RetailersAssignmentsUlListRetIds[$i]; ?>">Remove</button>
												</div>
											</li>
											<?php endfor; ?>
										</ul>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="table-wrap">
											<div class="table-responsive">
												<table class="table table-hover">
													<thead>
														<tr>
															<th>Retailer Name</th>
															<th>Retailer Address</th>
															<th>Action</th>
														</tr>
													</thead>
													<tbody>
														<?php foreach ($Distributors as $retailer) : ?>
														<tr>
															<td>
																<?= $retailer->retailer_name; ?>
															</td>
															<td>
																<?= $retailer->retailer_address; ?>
															</td>
															<td>
																<?php if($retailer->assigned) : ?>
																<span style="font-weight: bold">Already Assigned</span>
																<?php else: ?>
																<input type="number" value="<?= $retailer->id; ?>" hidden>
																<a type="button" class="btn btn-save addRetailerForAssignment">ADD</a>
																<?php endif;?>
															</td>
														</tr>
														<?php endforeach; ?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
								<input type="text" name="retailersForAssignments" value="<?= $RetailersAssignment->retailer_id; ?>" id="retailersForAssignments"
								hidden>
							</div>
						</div>
						</form>
					</div>
				</div>
			</div>
			<div class="row button-section">
				<a type="button" href="<?= base_url('RealRetailers/ListRetailersAssignments'); ?>" id="backFromUpdateRetailersAssignmentsButton"
				class="btn btn-cancel">Cancel</a>
				<a type="button" id="updateRetailersAssignmentsButton" class="btn btn-save">Save</a>
			</div>
		</div>
	</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script type="text/javascript" src="<?= base_url('assets/js/Retailers.js').'?v='.time(); ?>"></script>
