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
					<h2 class="m-heading">Retailer Management</h2>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6">
					<ol class="breadcrumb">
						<li>
							<a href="#">
								<span>Organization</span>
							</a>
						</li>
						<li>
							<span>Retailer Management</span>
						</li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="box-white m-b-30">
						<h2>Add Retailer</h2>
						<?php $attributes = array('id' => 'updateRetailerForm');
						echo form_open('RealRetailers/UpdateRetailerOps/'.$Retailer->id, $attributes); ?>
						<input type="text" value="<?= $Retailer->zone_id; ?>" id="selectedZoneId" hidden>
						<div class="form-wrap">
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Retailer Name*</label>
											<input type="text" name="retailer_name" class="form-control" value="<?= $Retailer->retailer_name; ?>">
											<?= form_error('retailer_name', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label mb-10">Retailer Territory*</label>
													<?php
												foreach ($Territories as $territory) : 
													$options[$territory->id] = $territory->territory_name;
												endforeach; 
												$atts = array( 'class' => 'form-control' );
												echo form_dropdown('retailer_territory_id', $options, $Retailer->retailer_territory_id, $atts); ?>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label mb-10">Retailer Zone*</label>
													<select class="form-control" name="zone_id" data-style="form-control btn-default btn-outline">
														<option disabled selected>Select zone</option>
													</select>
													<?= form_error('zone_id', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Retailer Phone</label>
											<input type="text" name="retailer_phone" class="form-control" value="<?= $Retailer->retailer_phone; ?>">
											<?= form_error('retailer_phone', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Retailer Email</label>
											<input type="text" name="retailer_email" class="form-control" value="<?= $Retailer->retailer_email; ?>">
											<?= form_error('retailer_email', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Retailer Latitude</label>
											<input type="text" name="retailer_lats" class="form-control" value="<?= $Retailer->retailer_lats; ?>">
											<?= form_error('retailer_lats', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Retailer Longitude</label>
											<input type="text" name="retailer_longs" class="form-control" value="<?= $Retailer->retailer_longs; ?>">
											<?= form_error('retailer_longs', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Retailer City*</label>
											<input type="text" name="retailer_city" class="form-control" value="<?= $Retailer->retailer_city; ?>">
											<?= form_error('retailer_city', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Retailer Type*</label>
											<select class="selectpicker" name="retailer_type_id" data-style="form-control btn-default btn-outline">
												<?php foreach( $RetailerTypes as $type ) : ?>
												<option value="<?= $type->id; ?>">
													<?= $type->retailer_type_name; ?>
												</option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label mb-10">Retailer Address*</label>
											<textarea type="text" name="retailer_address" class="form-control" placeholder="Enter Address" rows="5">
												<?= $Retailer->retailer_address; ?>
											</textarea>
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
				<a type="button" href="<?= base_url('RealRetailers/ListRetailers'); ?>" id="backFromRetailersButton" class="btn btn-cancel">Cancel</a>
				<a type="button" id="updateRetailerButton" class="btn btn-save">Save</a>
			</div>
		</div>
	</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script type="text/javascript" src="<?= base_url('assets/js/Retailers.js').'?v='.time(); ?>"></script>

<script>
	$(document).ready(function () {
		$('select[name="zone_id"]').empty();
		$('select[name="zone_id"]').append('<option value="0" disabled selected>Loading zones..</option>');
		$.ajax({
			type: 'GET',
			url: '/RealRetailers/GetZones/' + $('select[name="retailer_territory_id"]').val(),
			success: function (response) {
				$('select[name="zone_id"]').empty();
				var response = JSON.parse(response);
				if (!response.length)
					$('select[name="zone_id"]').append('<option disabled selected>Select zone</option>');

				response.forEach(element => {
					if ($('#selectedZoneId').val() == element['id']) {
						$('select[name="zone_id"]').append('<option value="' + element['id'] + '" selected>' + element['zone_name'] +
							'</option>');
					} else {
						$('select[name="zone_id"]').append('<option value="' + element['id'] + '">' + element['zone_name'] +
							'</option>');
					}
				});
			}
		});

		$('select[name="retailer_territory_id"]').change(function () {
			$('select[name="zone_id"]').empty();
			$('select[name="zone_id"]').append('<option disabled selected>Loading zones..</option>');
			$.ajax({
				type: 'GET',
				url: '/RealRetailers/GetZones/' + $('select[name="retailer_territory_id"]').val(),
				success: function (response) {
					$('select[name="zone_id"]').empty();
					var response = JSON.parse(response);
					if (!response.length)
						$('select[name="zone_id"]').append('<option disabled selected>Select zone</option>');

					response.forEach(element => {
						$('select[name="zone_id"]').append('<option value="' + element['id'] + '">' + element['zone_name'] +
							'</option>');
					});
				}
			});
		});
	});

</script>
