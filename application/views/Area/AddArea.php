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
					<h2 class="m-heading">Area Management</h2>
				</div>
				<div class="col-lg-6 col-md-6">
					<ol class="breadcrumb">
						<li><a href="#"><span>Organization</span></a></li>
						<li><span>Area Management</span></li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="box-white m-b-30">
						<h2>Add Area</h2>
						<?php $attributes = array('id' => 'addAreaForm');
						echo form_open('Areas/AddAreaOps', $attributes); ?>
						<div class="form-wrap">
							<div class="form-body">
								<div class="row"> 
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Area Name*</label>
											<input type="text" name="area_name" class="form-control" value="<?= set_value('area_name'); ?>">
											<?= form_error('area_name', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Area POC</label>
											<select class="selectpicker" name="area_poc_id" data-style="form-control btn-default btn-outline">
												<?php foreach( $employees as $employee ) : ?>
													<option value="<?= $employee->employee_id; ?>"><?= $employee->employee_username; ?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-md-12">
										<label class="control-label mb-10">Region*</label>
										<select class="form-control" name="region_id" id="regionIdDD">
											<?php foreach( $regions as $region ) : ?>
												<option value="<?= $region->id; ?>"><?= $region->region_name; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="row button-section">
			<a type="button" href="<?= base_url('Areas/ListAreas'); ?>" id="backFromAreasButton" class="btn btn-cancel">Cancel</a>
			<a type="button" id="addAreaButton" class="btn btn-save">Save</a>						
		</div>
	</div>
</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script type="text/javascript" src="<?= base_url('assets/js/RegionAndArea.js').'?v='.time(); ?>"></script>