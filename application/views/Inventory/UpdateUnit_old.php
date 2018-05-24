<?php require_once(APPPATH.'/views/includes/header.php'); ?>

<div class="container">
	<br>
	<?php $attributes = array('class' => 'form-control', 'id' => 'updateUnitForm');
	echo form_open('Inventory/UpdateUnitOps/'.$UnitType->unit_id, $attributes); ?>
	<fieldset>
		<legend>Update Unit</legend>
		<div class="row">
			<div class="col-md-8">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="exampleInputEmail1">Unit Name*</label>
							<input type="text" name="unit_name" value="<?= $UnitType->unit_name; ?>" class="form-control" placeholder="Enter Unit name" maxlength="100"> 
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="exampleInputEmail1">Unit Short Name</label>
							<input type="text" name="unit_short_name" value="<?= $UnitType->unit_short_name; ?>" class="form-control" placeholder="Enter Unit Short name" maxlength="100"> 
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="exampleInputEmail1">Unit Plural Name</label>
							<input type="text" name="unit_plural_name" value="<?= $UnitType->unit_plural_name; ?>" class="form-control" placeholder="Enter Unit Plural name" maxlength="100"> 
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<?php echo form_error('unit_name', '<div class="alert alert-dismissible alert-danger">', '</div>');?>
				<?php echo form_error('unit_short_name', '<div class="alert alert-dismissible alert-danger">', '</div>');?>
				<?php echo form_error('unit_plural_name', '<div class="alert alert-dismissible alert-danger">', '</div>');?>
			</div>
		</div>
		<a href="<?= base_url('Inventory/ListUnits'); ?>">
			<button type="button" id="backFromAddUnitButton" class="btn btn-secondary">Back</button>
		</a>
		&nbsp;
		<button type="button" id="updateUnitButton" class="btn btn-primary">Update</button>
	</fieldset>
</form>

</div>

<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<!-- Page level JS -->
<script type="text/javascript" src="<?= base_url('assets/js/Units.js').'?v='.time(); ?>"></script>
