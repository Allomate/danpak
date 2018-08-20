<?php require_once(APPPATH.'/views/includes/header.php'); ?>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once(APPPATH.'/views/includes/navbar&sidebar.php'); ?>
	<div class="page-wrapper">
		<div class="container-fluid">
			<?= isset($sub_invent_exist) ? '<div class="alert alert-danger" style="background: white; color: red; margin-top: 20px">'.$sub_invent_exist.'</div>' : ''; ?>
			<div class="row heading-bg">
				<div class="col-lg-6 col-md-6 col-sm-6">
					<h2 class="m-heading">Sub-Inventory Management</h2>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6">
					<ol class="breadcrumb">
						<li><a href="#"><span>Organization</span></a></li>
						<li><span>Sub-Inventory Management</span></li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="box-white m-b-30">
						<h2>Convert Sub-Inventory</h2>
						<?php $attributes = array('id' => 'convertQuantityForm');
						echo form_open('Inventory/ConvertSubInventoryOps/'.$SubInventoryData->id, $attributes);
						echo form_hidden('each_parent_contains_quantity', $SubInventoryData->quantity);
						echo form_hidden('quantityAddingToChild');
						echo form_hidden('quantityRemainingForParent');?>
						<div class="form-wrap">
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<br>
										<div class="row">
											<div class="col-md-4">
												<h5>Parent Item: </h5>
												<strong><?= $SubInventoryData->parent_item; ?></strong>
											</div>
											<div class="col-md-4">
												<h5>Child Item: </h5>
												<strong><?= $SubInventoryData->child_item; ?></strong>
											</div>
										</div>
										<br>
										<h4>Information</h4>
										<p class="m-b-20">
											<strong><?= $SubInventoryData->parent_item; ?></strong> quantity is: <strong><?= $SubInventoryData->parent_quantity; ?></strong> and Each <strong><?= $SubInventoryData->parent_item; ?></strong> contains <strong><?= $SubInventoryData->quantity;?></strong> quantity of <strong><?= $SubInventoryData->child_item; ?></strong>
										</p>
									</div>
								</div>
								<div class="row"> 
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label mb-10">Convert Parent Quantity</label>
											<input type="number" name="convert_parent_quantity" class="form-control" placeholder="Add parent quantity to convert to child" max="<?= $SubInventoryData->parent_quantity; ?>" min="1">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label mb-10">Quantity Add To <strong><?= $SubInventoryData->child_item; ?></strong> - Child</label>
											<h5 id="quantityAddingToChild"></h5>
										</div>
									</div>	
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label mb-10">Remaining Items of <strong><?= $SubInventoryData->parent_item; ?></strong> - Parent</label>
											<h5 id="quantityRemainingForParent"></h5>
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
			<a type="button" href="<?= base_url('Inventory/ListSubInventory'); ?>" id="backFromConversionButton" class="btn btn-cancel">Cancel</a>
			<a type="button" id="convertQuantityBtn" class="btn btn-save">Save</a>						
		</div>
	</div>
</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script type="text/javascript" src="<?= base_url('assets/js/SubInventory.js').'?v='.time(); ?>"></script>