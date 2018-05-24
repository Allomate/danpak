<?php require_once(APPPATH.'/views/includes/header.php'); ?>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once(APPPATH.'/views/includes/navbar&sidebar.php'); ?>
	<div class="page-wrapper">
		<div class="container">
			<div class="row heading-bg">
				<div class="col-lg-6 col-md-6">
					<h2 class="m-heading">Territory Management</h2>
				</div>
				<div class="col-lg-6 col-md-6">
					<ol class="breadcrumb">
						<li><a href="#"><span>Organization</span></a></li>
						<li><span>Territory Management</span></li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="box-white m-b-30">
						<h2>Add Territory</h2>
						<?php $attributes = array('id' => 'addTerritoryForm');
						echo form_open('Territories/AddTerritoryOps', $attributes); ?>
						<div class="form-wrap">
							<div class="form-body">
								<div class="row"> 
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Territory Name*</label>
											<input type="text" name="territory_name" class="form-control" value="<?= set_value('territory_name'); ?>">
											<?= form_error('territory_name', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Territory POC</label>
											<select class="selectpicker" name="territory_poc_id" data-style="form-control btn-default btn-outline">
												<?php foreach( $employees as $employee ) : ?>
													<option value="<?= $employee->employee_id; ?>"><?= $employee->employee_username; ?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-md-12">
										<label class="control-label mb-10">Area*</label>
										<select class="form-control" name="region_id" id="regionIdDD">
											<?php foreach( $areas as $area ) : ?>
												<option value="<?= $area->id; ?>"><?= $area->area_name; ?></option>
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
			<a type="button" href="<?= base_url('Territories/ListTerritories'); ?>" id="backFromTerritoryButton" class="btn btn-cancel">Cancel</a>
			<a type="button" id="addTerritoryButton" class="btn btn-save">Save</a>						
		</div>
	</div>
</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script type="text/javascript" src="<?= base_url('assets/js/RegionAndArea.js').'?v='.time(); ?>"></script>