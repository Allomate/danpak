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
						<h2>Update Sub-Inventory</h2>
						<?php $attributes = array('id' => 'updateSubInventForm');
						echo form_open('Inventory/UpdateSubInventoryOps/'.$this->uri->segment(3), $attributes);
						echo form_hidden('subInventData', base_url('Inventory/SubInventDataForAjax'));
						echo form_hidden('thisSubInventData', base_url('Inventory/GetSingleSubInventory/'.$this->uri->segment(3)));
						echo form_hidden('currentController', $this->uri->segment(2)); ?>
						<div class="form-wrap">
							<div class="form-body">
								<div class="row"> 
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Parent Item</label>
											<select class="form-control" name="item_name_inside_this_item">
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Unit</label>
											<select class="form-control" name="unit_id_inside_this_item">
											</select>
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label mb-10">Quantity*</label>
											<input type="number" name="quantity" class="form-control" value="<?= set_value('quantity'); ?>" placeholder="">
											<?= form_error('quantity', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
								</div>
								<div class="row"> 
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Child Item</label>
											<select class="form-control" name="item_name_item_inside">
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Unit</label>
											<select class="form-control" name="unit_id_item_inside">
											</select>
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
			<a type="button" href="<?= base_url('Inventory/ListSubInventory'); ?>" id="backFromAreasButton" class="btn btn-cancel">Cancel</a>
			<a type="button" id="updateSubInventoryButton" class="btn btn-save">Save</a>						
		</div>
	</div>
</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script type="text/javascript" src="<?= base_url('assets/js/SubInventory.js').'?v='.time(); ?>"></script>