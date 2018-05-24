<?php require_once(APPPATH.'/views/includes/header.php'); ?>

<div class="container">
	<br>
	<?= isset($sub_invent_exist) ? '<div class="alert alert-dismissible alert-warning">'.$sub_invent_exist.'</div>' : ''; ?>
	<?php $attributes = array('class' => 'form-control', 'id' => 'updateSubInventForm');
	echo form_open('Inventory/UpdateSubInventoryOps/'.$this->uri->segment(3), $attributes);
	echo form_hidden('subInventData', base_url('Inventory/SubInventDataForAjax'));
	echo form_hidden('thisSubInventData', base_url('Inventory/GetSingleSubInventory/'.$this->uri->segment(3)));
	echo form_hidden('currentController', $this->uri->segment(2)); ?>
	<fieldset>
		<legend>Update Sub Inventory</legend>
		<hr>
		<h3>Parent Item</h3>
		<hr>
		<div class="row">
			<div class="col-md-8">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="exampleInputEmail1">Item Name*</label>
							<select class="form-control" name="item_name_inside_this_item">
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="exampleInputEmail1">Unit*</label>
							<select class="form-control" name="unit_id_inside_this_item">
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<?php echo form_error('item_name_inside_this_item', '<div class="alert alert-dismissible alert-danger">', '</div>');?>
				<?php echo form_error('unit_id_inside_this_item', '<div class="alert alert-dismissible alert-danger">', '</div>');?>
			</div>
		</div>
		<hr>
		<h3>Quantity</h3>
		<div class="row">
			<div class="col-md-8">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="exampleInputEmail1">Quantity*</label>
							<input type="number" class="form-control" name="quantity" min="1" placeholder="Quantity" />
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<?php echo form_error('quantity', '<div class="alert alert-dismissible alert-danger">', '</div>');?>
			</div>
		</div>
		<hr>
		<h3>Child Item</h3>
		<hr>
		<div class="row">
			<div class="col-md-8">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="exampleInputEmail1">Item Name*</label>
							<select class="form-control" name="item_name_item_inside">
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="exampleInputEmail1">Unit*</label>
							<select class="form-control" name="unit_id_item_inside">
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<?php echo form_error('item_name_item_inside', '<div class="alert alert-dismissible alert-danger">', '</div>');?>
				<?php echo form_error('unit_id_item_inside', '<div class="alert alert-dismissible alert-danger">', '</div>');?>
			</div>
		</div>
		<a href="<?= base_url('Inventory/ListSubInventory'); ?>">
			<button type="button" id="backFromSubInventoryButton" class="btn btn-secondary">Back</button>
		</a>
		&nbsp;
		<button type="button" id="updateSubInventoryButton" class="btn btn-primary">Update</button>
	</fieldset>
</form>

</div>

<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<!-- Page level JS -->
<script type="text/javascript" src="<?= base_url('assets/js/Inventory.js').'?v='.time(); ?>"></script>
