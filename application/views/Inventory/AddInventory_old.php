<?php require_once(APPPATH.'/views/includes/header.php'); ?>

<div class="container">
	<br>
	<?php $attributes = array('class' => 'form-control', 'id' => 'addInventoryForm');
	echo form_open_multipart('Inventory/AddInventoryOps', $attributes); ?>
	<fieldset>
		<legend>Add Inventory</legend>
		<div class="row">
			<div class="col-md-8">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="exampleInputEmail1">Pre-Defined Items</label>
							<select class="form-control" name="pre_defined_item">
								<option value="0" selected="selected">No predefined item</option>
								<?php foreach ($PreDefinedItems as $item) : ?>
									<option value="<?= $item->item_id; ?>"><?= $item->item_name; ?></option>
								<?php endforeach;?>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="exampleInputEmail1">Item Sku*</label>
							<input type="text" name="item_sku" value="<?= set_value('item_sku'); ?>" class="form-control" placeholder="Enter item sku"> 
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="exampleInputEmail1">Item Name*</label>
							<input type="text" name="item_name" value="<?= set_value('item_name'); ?>" class="form-control" placeholder="Enter Item Name">
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<?php echo form_error('item_sku', '<div class="alert alert-dismissible alert-danger">', '</div>');?>
				<?php echo form_error('item_name', '<div class="alert alert-dismissible alert-danger">', '</div>');?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="exampleInputEmail1">Unit Name*</label>
							<select class="form-control" name="unit_id">
								<?php foreach ($UnitTypes as $unit) : ?>
									<option value="<?= $unit->unit_id; ?>"><?= $unit->unit_name; ?></option>
								<?php endforeach;?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="exampleInputPassword1">Item Quantity*</label>
							<input type="number" class="form-control" name="item_quantity" value="<?= set_value('item_quantity'); ?>" placeholder="Item Quantity">
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<?php echo form_error('unit_id', '<div class="alert alert-dismissible alert-danger">', '</div>');?>
				<?php if(isset($PropExist)) : ?> <div class="alert alert-dismissible alert-danger"> <?= $PropExist; ?> </div> <?php endif;
				echo form_error('item_quantity', '<div class="alert alert-dismissible alert-danger">', '</div>');?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8">
				<div class="form-group">
					<label for="exampleInputEmail1">Sub Category*</label>
					<select class="form-control" name="sub_category_id">
						<?php foreach ($SubCategories as $category) { ?>
						<option value="<?= $category->sub_category_id; ?>"><?= $category->sub_category_name; ?></option>
						<?php }?>
					</select>
				</div>
			</div>
			<div class="col-md-4">
				<?php echo form_error('sub_category_id', '<div class="alert alert-dismissible alert-danger">', '</div>');?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="exampleInputEmail1">Item Warehouse Price*</label>
							<input type="number" class="form-control" value="<?= set_value('item_warehouse_price'); ?>" name="item_warehouse_price" placeholder="Enter Warehouse price" />
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="exampleInputEmail1">Item Retail Price*</label>
							<input type="number" name="item_retail_price" value="<?= set_value('item_retail_price'); ?>" class="form-control" placeholder="Enter Retail price" />
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="exampleInputEmail1">Item Trade Price*</label>
							<input type="number" name="item_trade_price" value="<?= set_value('item_trade_price'); ?>" class="form-control" placeholder="Enter Trade price" />
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<?php echo form_error('item_warehouse_price', '<div class="alert alert-dismissible alert-danger">', '</div>');?>
				<?php echo form_error('item_retail_price', '<div class="alert alert-dismissible alert-danger">', '</div>');?>
				<?php echo form_error('item_trade_price', '<div class="alert alert-dismissible alert-danger">', '</div>');?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="exampleInputEmail1">Item Images</label>
							<input type="file" name="item_images[]" data-input="false" multiple="multiple" class="form-control" accept=".png, .jpeg, .jpg, .bmp">
							<small>Max 3 Mb</small>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="exampleInputEmail1">Item Thumbnail</label>
							<input type="file" id="item_thumbnail" name="item_thumbnail" data-input="false" class="form-control" accept=".png, .jpeg, .jpg, .bmp">
							<small>Max 3 Mb</small>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<?php if(isset($item_thumbnail_error)) : ?> <div class="alert alert-dismissible alert-danger"> <?= $item_thumbnail_error; ?> </div> <?php endif;
				if(isset($imagesUploadError)) : ?> <div class="alert alert-dismissible alert-danger"> <?= $imagesUploadError; ?> </div> <?php endif; ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8">
				<div class="form-group">
					<label for="exampleInputEmail1">Item Description</label>
					<textarea type="text" name="item_description" class="form-control" placeholder="Enter item Description" rows="5"><?= set_value('item_description'); ?></textarea>
				</div>
			</div>
			<div class="col-md-4">
				<?php echo form_error('item_description', '<div class="alert alert-dismissible alert-danger">', '</div>');?>
			</div>
		</div>
		<a href="<?= base_url('Inventory/ListInventory'); ?>">
			<button type="button" id="backFromInventoryButton" class="btn btn-secondary">Back</button>
		</a>
		&nbsp;
		<button type="button" id="addItemButton" class="btn btn-primary">Add Item</button>
	</fieldset>
</form>

</div>

<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<!-- Page level JS -->
<script type="text/javascript" src="<?= base_url('assets/js/Inventory.js').'?v='.time(); ?>"></script>
