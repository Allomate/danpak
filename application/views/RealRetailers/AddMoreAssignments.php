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
						<h2>Add Retailer Assignment</h2>
						<?php $attributes = array('id' => 'addRetailerAssignmentForm');
						echo form_open('RealRetailers/RetailerAssignemntOps', $attributes); ?>
						<div class="form-wrap">
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Select Employee</label>
											<select class="selectpicker" name="employee" data-style="form-control btn-default btn-outline">
												<?php foreach ($Employees as $employee): ?>
												<option value="<?= $employee->employee_id; ?>">
													<?= $employee->employee_username; ?>
												</option>
												<?php endforeach ?>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Select Day</label>
											<select class="selectpicker" name="assigned_for_day" data-style="form-control btn-default btn-outline">
												<option value="monday">Monday</option>
												<option value="tuesday">Tuesday</option>
												<option value="wednesday">Wednesday</option>
												<option value="thursday">Thursday</option>
												<option value="friday">Friday</option>
												<option value="saturday">Saturday</option>
												<option value="sunday">Sunday</option>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Retailers Added</label>
											<ul style="list-style: none; padding: 0px" id="addedAssignmentsList">
											</ul>
										</div>
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
															<th>Retailer Type</th>
															<th>Retailer Territory</th>
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
																<?= $retailer->retailer_type; ?>
															</td>
															<td>
																<?= $retailer->retailer_territory; ?>
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
								<input type="text" name="retailersForAssignments" id="retailersForAssignments" hidden>
							</div>
						</div>
						</form>
					</div>
				</div>
			</div>
			<div class="row button-section">
				<a type="button" href="<?= base_url('RealRetailers/ListRetailersAssignments'); ?>" id="backFromRetailersAssignmentsButton"
				class="btn btn-cancel">Cancel</a>
				<a type="button" id="addRetailersAssignmentsButton" class="btn btn-save">Save</a>
			</div>
		</div>
	</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script type="text/javascript" src="<?= base_url('assets/js/Retailers.js').'?v='.time(); ?>"></script>
