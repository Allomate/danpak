<?php require_once(APPPATH.'/views/includes/header.php'); ?>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once(APPPATH.'/views/includes/navbar&sidebar.php'); ?>
	<div class="page-wrapper">
		<div class="container">
			<?php if ($feedback = $this->session->flashdata('missing_information')) : ?>
			<div class="row" style="margin-top: 20px;">
				<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
					<strong>Missing Information</strong>
					<?= $feedback; ?>
				</div>
			</div>
			<?php endif; ?>
			<div class="row heading-bg">
				<div class="col-lg-6 col-md-6 col-sm-6">
					<h2 class="m-heading">Retailer Assignment Management</h2>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6">
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
												<option value="everyday">Everyday</option>
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

										<div class="checkbox checkbox-primary checkbox-circle">
											<!-- <input id="checkbox-002" type="checkbox"> -->
											<input id="territoryRadio" name="bunchAssignment" type="checkbox" value="territory">
											<label for="territoryRadio" class="lab-large"> Assign Retailers by Territory </label>
										</div>

										<div id="checkbox-circle001">
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label class="control-label mb-10">Territory</label>
														<select class="selectpicker" name="territory_id" data-style="form-control btn-default btn-outline">
															<?php foreach ($Territories as $territory) : ?>
															<option value="<?= $territory->id; ?>">
																<?= $territory->territory_name; ?>
															</option>
															<?php endforeach; ?>
														</select>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-md-12">
										<a href="#" id="viewAssigns" class="_viewAssign" data-toggle="modal" data-target="#ViewAssignments">VIEW
											ASSIGNMENTS</a>
									</div>
									<div id="myModal" class="modal fade" role="dialog">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
													<h5 class="modal-title" id="exampleModalLabel1">Assignments</h5>
												</div>
												<div class="modal-body" style="overflow: auto; max-height: 450px" id="addedAssignmentsList">
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
												</div>
											</div>
										</div>
									</div>
								</div>
								<input type="text" name="retailersForAssignments" id="retailersForAssignments" hidden>
							</div>
						</div>
						</form>
					</div>
					<div class="box-white p-20 m-b-30">
						<div class="table-wrap">
							<div class="table-responsive" id="retailersTableDiv">
							</div>
							<div id="tableLoader" style="text-align: center">
								<img style="width: auto; height: 50px;" src="/assets/images/wl-loader-2.gif" alt="">
							</div>
						</div>
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
