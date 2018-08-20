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
					<h2 class="m-heading">Packaging Management</h2>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6">
					<ol class="breadcrumb">
						<li><a href="#"><span>Organization</span></a></li>
						<li><span>Packaging Management</span></li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="box-white m-b-30">
						<h2>Add Packaging</h2>
						<?php $attributes = array('id' => 'addUnitForm');
						echo form_open('Inventory/AddUnitOps', $attributes); ?>
						<div class="form-wrap">
							<div class="form-body">
								<div class="row"> 
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label mb-10">Packaging Name*</label>
											<input type="text" name="unit_name" class="form-control" value="<?= set_value('unit_name'); ?>">
											<?= form_error('unit_name', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div> 
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label mb-10">Packaging Short Name*</label>
											<input type="text" name="unit_short_name" class="form-control" value="<?= set_value('unit_short_name'); ?>">
											<?= form_error('unit_short_name', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label mb-10">Packaging Plural Name*</label>
											<input type="text" name="unit_plural_name" class="form-control" value="<?= set_value('unit_plural_name'); ?>">
											<?= form_error('unit_plural_name', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
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
			<a type="button" href="<?= base_url('Inventory/ListUnits'); ?>" id="backFromAddUnitButton" class="btn btn-cancel">Cancel</a>
			<a type="button" id="addUnitButton" class="btn btn-save">Save</a>						
		</div>
	</div>
</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script type="text/javascript" src="<?= base_url('assets/js/Units.js').'?v='.time(); ?>"></script>