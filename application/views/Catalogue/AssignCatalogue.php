<?php require_once(APPPATH.'/views/includes/header.php'); ?>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once(APPPATH.'/views/includes/navbar&sidebar.php'); ?>
	<div class="page-wrapper">
		<div class="container-fluid">
			<?php if ($feedback = $this->session->flashdata('invalid_dates')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Improper Dates!</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<div class="row heading-bg">
				<div class="col-lg-6 col-md-6">
					<h2 class="m-heading">Catalogue Assignment</h2>
				</div>
				<div class="col-lg-6 col-md-6">
					<ol class="breadcrumb">
						<li><a href="#"><span>Organization</span></a></li>
						<li><span>Catalogue Assignment</span></li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="box-white m-b-30">
						<h2>Assign Catalogue</h2>
						<?php $attributes = array('id' => 'assignCatalogueForm');
						echo form_open('Catalogue/AssignCatalogueOps', $attributes); ?>

						<div class="form-wrap">
							<div class="form-body">
								<div class="row"> 
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Catalogue Name*</label>
											<select class="selectpicker" name="catalogue_id" data-style="form-control btn-default btn-outline">
												<?php foreach ($Catalogues as $catalogue) : ?>
													<option value="<?= $catalogue->id ?>"><?= $catalogue->catalogue_name; ?></option>
												<?php endforeach; ?>
											</select>
											<?= form_error('catalogue_id', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Active From*</label>
											<div class="input-group date" data-provide="datepicker">
												<input type="text" class="form-control" name="active_from" value="<?= set_value('active_from'); ?>" data-date-format="yyyy-mm-dd">
												<div class="input-group-addon">
													<span class="glyphicon glyphicon-th"></span>
												</div>
											</div>
											<?= form_error('active_from', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Active Till*</label>
											<div class="input-group date" data-provide="datepicker">
												<input type="text" class="form-control" name="active_till" value="<?= set_value('active_till'); ?>" data-date-format="yyyy-mm-dd">
												<div class="input-group-addon">
													<span class="glyphicon glyphicon-th"></span>
												</div>
											</div>
											<?= form_error('active_till', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Assign To*</label>
											<select class="form-control" name="employee_id" id="employeeIdDropdown">
												<?php foreach ($Employees as $employee) : ?>
													<option value="<?= $employee->employee_id ?>"><?= $employee->employee_username; ?></option>
												<?php endforeach; ?>
											</select>
											<?= form_error('employee_id', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
								</div>
								<div class="row" style="display: none">
									<div class="col-md-12">
										<div class="form-group">
											<label for="exampleInputEmail1">Inventory Selected*</label>
											<div id="dynamicInventSelected"></div>
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
			<a type="button" href="<?= base_url('Catalogue/ViewCatalogueAssignments'); ?>" id="backFromCataloguesAssignmentButton" class="btn btn-cancel">Cancel</a>
			<a type="button" id="assignCatalogueButton" class="btn btn-save">Save</a>						
		</div>
	</div>
</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script type="text/javascript" src="<?= base_url('assets/js/bootstrap-datepicker.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/AssignCatalogue.js').'?v='.time(); ?>"></script>