<?php require_once(APPPATH.'/views/includes/header.php'); ?>

<div class="container">
	<br>
	<?php $attributes = array('class' => 'form-control', 'id' => 'updateRegionForm');
	echo form_open('Regions/UpdateRegionOps/'.$region->id, $attributes); ?>
	<fieldset>
		<legend>Update Region</legend>
		<div class="row">
			<div class="col-md-8">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="exampleInputEmail1">Region Name*</label>
							<input type="text" name="region_name" value="<?= $region->region_name; ?>" class="form-control" placeholder="Enter Region name" maxlength="100"> 
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="exampleInputEmail1">Region POC*</label>
							<?php
							foreach ($employees as $employee) : 
								$options[$employee->employee_id] = $employee->employee_username;
							endforeach; 
							$atts = array( 'class' => 'form-control', 'id' => 'employeeIdDD' );
							echo form_dropdown('region_poc_id', $options, $region->region_poc_id, $atts); ?>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<?php echo form_error('region_name', '<div class="alert alert-dismissible alert-danger">', '</div>');?>
			</div>
		</div>
		<a href="<?= base_url('Regions/ListRegions'); ?>">
			<button type="button" id="backFromRegionsButton" class="btn btn-secondary">Back</button>
		</a>
		&nbsp;
		<button type="button" id="updateRegionButton" class="btn btn-primary">Update Region</button>
	</fieldset>
</form>

</div>

<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<!-- Page level JS -->
<script type="text/javascript" src="<?= base_url('assets/js/RegionAndArea.js').'?v='.time(); ?>"></script>
