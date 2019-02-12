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
					<h2 class="m-heading">Scheme Management</h2>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6">
					<ol class="breadcrumb">
						<li>
							<a href="#">
								<span>Organization</span>
							</a>
						</li>
						<li>
							<span>Scheme Management</span>
						</li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="box-white m-b-30">
						<h2>Add Scheme</h2>
						<?php $attributes = array('id' => 'addCampaignFOrm');
						echo form_open_multipart('CampaignManagement/AddCampaignOps', $attributes);
						echo form_hidden('bulk_assignment', ''); ?>
						<div class="form-wrap">
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="checkbox checkbox-primary checkbox-circle">
											<input id="region" type="checkbox" value="">
											<label for="region" class="lab-large"> Assign catalogue by Region </label>
										</div>
										<div id="checkbox-circle001">
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label class="control-label mb-10">Region</label>
														<select class="selectpicker" name="region_id" data-style="form-control btn-default btn-outline">
															<?php foreach ($Regions as $region) : ?>
															<option value="<?= $region->id; ?>">
																<?= $region->region_name; ?>
															</option>
															<?php endforeach; ?>
														</select>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="checkbox checkbox-primary checkbox-circle">
											<input id="area" type="checkbox" value="">
											<label for="area" class="lab-large"> Assign catalogue by Area </label>
										</div>
										<div id="checkbox-circle001">
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label class="control-label mb-10">Areas</label>
														<select class="selectpicker" name="area_id" data-style="form-control btn-default btn-outline">
															<?php foreach ($Areas as $area) : ?>
															<option value="<?= $area->id; ?>">
																<?= $area->area_name; ?>
															</option>
															<?php endforeach; ?>
														</select>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="checkbox checkbox-primary checkbox-circle">
											<input id="territory" type="checkbox" value="">
											<label for="territory" class="lab-large"> Assign catalogue by Territory </label>
										</div>
										<div id="checkbox-circle001">
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label class="control-label mb-10">Territory</label>
														<select class="selectpicker" name="territory_id" data-style="form-control btn-default btn-outline">
															<?php foreach ($Territories as $territory) : ?>
															<option value="<?= $territory->id; ?>">
																<?= $territory->territory_name; ?>
															</option>
															<?php endforeach; ?>
														</select>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label mb-10" for="Scheme Type">Scheme Type</label>
											<select name="scheme_type" id="scheme_type" class="form-control">
												<option value="1">+1 Scheme</option>
												<option value="2">Discount on TP</option>
												<option value="3">Gift Item</option>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label mb-10">Scheme Name*</label>
											<input type="text" name="campaign_name" class="form-control" value="<?= set_value('campaign_name'); ?>">
											<?= form_error('campaign_name', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Eligibility Criteria</label>
											<select class="selectpicker" name="eligibility_criteria_pref_id" data-style="form-control btn-default btn-outline">
												<?php foreach( $Inventory as $item ) : ?>
												<?php foreach( explode("<-->", $item->variants) as $units ) : ?>
												<option value="<?= explode('<>', $units)[0]; ?>">
													<?= $item->item_name . " (" .explode('<>', $units)[1].")"; ?>
												</option>
												<?php endforeach; ?>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Minimum Quantity for Eligibility</label>
											<input type="number" name="minimum_quantity_for_eligibility" class="form-control" value="<?= set_value('minimum_quantity_for_eligibility'); ?>">
											<?= form_error('minimum_quantity_for_eligibility', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
								</div>
								<div id="schemeContent">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label mb-10">+1 Item</label>
												<select class="selectpicker" name="item_given_free_pref_id" data-style="form-control btn-default btn-outline">
													<?php foreach( $Inventory as $item ) : ?>
													<?php foreach( explode("<-->", $item->variants) as $units ) : ?>
													<option value="<?= explode('<>', $units)[0]; ?>">
														<?= $item->item_name . " (" .explode('<>', $units)[1].")"; ?>
													</option>
													<?php endforeach; ?>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label mb-10">Quantity given free</label>
												<input type="number" name="quantity_for_free_item" class="form-control" value="<?= set_value('quantity_for_free_item'); ?>">
												<small id="validQuantityErr" style="color: red; font-weight: bold; margin-top: 5px; display: none">Please
													provide valid quantity</small>
												<?= form_error('quantity_for_free_item', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label mb-10">Scheme Amount</label>
												<input type="number" name="scheme_amount" class="form-control" value="<?= set_value('scheme_amount'); ?>"
												 readonly>
												<?= form_error('scheme_amount', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label mb-10">Scheme Image</label>
												<small>Dimensions (1080x495)</small>
												<input type="file" id="scheme_image" name="scheme_image" class="form-control" accept=".jpg,.bmp,.jpeg,png" />
												<?= isset($scheme_image_error) ? '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">'.$scheme_image_error.'</small>' : '';?>
												<small>
													<?php $max_upload = (int)(ini_get('upload_max_filesize')); $max_post = (int)(ini_get('post_max_size')); $memory_limit = (int)(ini_get('memory_limit')); echo "Maximum file size limit: (" . $upload_mb = min($max_upload, $max_post, $memory_limit)." mb)"; ?>
												</small>
											</div>
										</div>
									</div>
								</div>
								<div id="discountOnTpContent" style="display: none">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label mb-10">Item for discount (Each)</label>
												<select class="selectpicker" name="price_discount_of_this_pref_id" data-style="form-control btn-default btn-outline">
													<?php foreach( $Inventory as $item ) : ?>
													<?php foreach( explode("<-->", $item->variants) as $units ) : ?>
													<option value="<?= explode('<>', $units)[0]; ?>">
														<?= $item->item_name . " (" .explode('<>', $units)[1].")"; ?>
													</option>
													<?php endforeach; ?>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label mb-10">Discount on TP (PKR)</label>
												<input type="number" name="discount_on_tp" class="form-control" value="<?= set_value('discount_on_tp'); ?>">
												<?= form_error('discount_on_tp', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label mb-10">Scheme Image</label>
												<small>Dimensions (1080x495)</small>
												<input type="file" id="scheme_image_disc_tp" name="scheme_image_disc_tp" class="form-control" accept=".jpg,.bmp,.jpeg,png" />
												<?= isset($scheme_image_error) ? '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">'.$scheme_image_error.'</small>' : '';?>
												<small>
													<?php $max_upload = (int)(ini_get('upload_max_filesize')); $max_post = (int)(ini_get('post_max_size')); $memory_limit = (int)(ini_get('memory_limit')); echo "Maximum file size limit: (" . $upload_mb = min($max_upload, $max_post, $memory_limit)." mb)"; ?>
												</small>
											</div>
										</div>
									</div>
								</div>
								<div id="giftItemContent" style="display: none">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label mb-10">Gift Item</label>
												<input type="text" class="form-control" name="gift_item" maxlength="150">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label mb-10">Offered Gift Price (PKR)</label>
												<input type="number" name="offered_gift_price" class="form-control" value="<?= set_value('offered_gift_price'); ?>"
												 min="1">
												<?= form_error('offered_gift_price', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label mb-10">Scheme Image</label>
												<small>Dimensions (1080x495)</small>
												<input type="file" id="scheme_image_gift" name="scheme_image_gift" class="form-control" accept=".jpg,.bmp,.jpeg,png" />
												<?= isset($scheme_image_error) ? '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">'.$scheme_image_error.'</small>' : '';?>
												<small>
													<?php $max_upload = (int)(ini_get('upload_max_filesize')); $max_post = (int)(ini_get('post_max_size')); $memory_limit = (int)(ini_get('memory_limit')); echo "Maximum file size limit: (" . $upload_mb = min($max_upload, $max_post, $memory_limit)." mb)"; ?>
												</small>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						</form>
						<div class="alert alert-warning" style="background-color: #f1ece4; color: red">
							<strong>Note: </strong> Please double-check the entries after providing all the information as you won't be able
							to update
							this scheme
						</div>
					</div>
				</div>
			</div>
			<input type="text" id="urlForItemTradePrice" value="<?= base_url('CampaignManagement/GetItemPriceForSchemeAmountCalculationAjax'); ?>"
			 hidden>
			<div class="row button-section">
				<a type="button" href="<?= base_url('CampaignManagement/ListCampaigns'); ?>" id="backFromTerritoryButton" class="btn btn-cancel">Cancel</a>
				<a type="button" id="addCampaignBtn" class="btn btn-save">Save</a>
			</div>
		</div>
	</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script type="text/javascript" src="<?= base_url('assets/js/Campaign.js').'?v='.time(); ?>"></script>
