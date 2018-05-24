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
					<h2 class="m-heading">Distributor Management</h2>
				</div>
				<div class="col-lg-6 col-md-6">
					<ol class="breadcrumb">
						<li><a href="#"><span>Organization</span></a></li>
						<li><span>Distributor Management</span></li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="box-white m-b-30">
						<h2>Add Distributor</h2>
						<?php $attributes = array('id' => 'updateRetailerForm');
						echo form_open('Retailers/UpdateRetailerOps/'.$Retailer->id, $attributes); ?>
						<div class="form-wrap">
							<div class="form-body">
								<div class="row"> 
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Distributor Name*</label>
											<input type="text" name="retailer_name" class="form-control" value="<?= $Retailer->retailer_name; ?>">
											<?= form_error('retailer_name', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Distributor Territory*</label>
											<select class="selectpicker" name="retailer_territory_id" data-style="form-control btn-default btn-outline">
												<?php foreach( $Territories as $territory ) : ?>
													<option value="<?= $territory->id; ?>"><?= $territory->territory_name; ?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>	
								</div>
								<div class="row"> 
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Distributor Phone</label>
											<input type="text" name="retailer_phone" class="form-control" value="<?= $Retailer->retailer_phone; ?>">
											<?= form_error('retailer_phone', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Distributor Email</label>
											<input type="text" name="retailer_email" class="form-control" value="<?= $Retailer->retailer_email; ?>">
											<?= form_error('retailer_email', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
								</div>
								<div class="row"> 
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Distributor Latitude</label>
											<input type="text" name="retailer_lats" class="form-control" value="<?= $Retailer->retailer_lats; ?>">
											<?= form_error('retailer_lats', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Distributor Longitude</label>
											<input type="text" name="retailer_longs" class="form-control" value="<?= $Retailer->retailer_longs; ?>">
											<?= form_error('retailer_longs', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
								</div>
								<div class="row"> 
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Distributor City*</label>
											<input type="text" name="retailer_city" class="form-control" value="<?= $Retailer->retailer_city; ?>">
											<?= form_error('retailer_city', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Distributor Type*</label>
											<select class="selectpicker" name="retailer_type_id" data-style="form-control btn-default btn-outline">
												<?php foreach( $RetailerTypes as $type ) : ?>
													<option value="<?= $type->id; ?>"><?= $type->retailer_type_name; ?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>	
								</div>
								<div class="row"> 
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label mb-10">Distributor Address*</label>
											<textarea type="text" name="retailer_address" class="form-control" placeholder="Enter Address" rows="5"><?= $Retailer->retailer_address; ?></textarea>
											<?= form_error('retailer_address', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
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
			<a type="button" href="<?= base_url('Retailers/ListRetailers'); ?>" id="backFromRetailersButton" class="btn btn-cancel">Cancel</a>
			<a type="button" id="updateRetailerButton" class="btn btn-save">Save</a>						
		</div>
	</div>
</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script type="text/javascript" src="<?= base_url('assets/js/Retailers.js').'?v='.time(); ?>"></script>