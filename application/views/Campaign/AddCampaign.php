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
					<h2 class="m-heading">Campaign Management</h2>
				</div>
				<div class="col-lg-6 col-md-6">
					<ol class="breadcrumb">
						<li>
							<a href="#">
								<span>Organization</span>
							</a>
						</li>
						<li>
							<span>Campaign Management</span>
						</li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="box-white m-b-30">
						<h2>Add Campaign</h2>
						<?php $attributes = array('id' => 'addCampaignFOrm');
						echo form_open_multipart('CampaignManagement/AddCampaignOps', $attributes); ?>
						<div class="form-wrap">
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label mb-10" for="Scheme Type">Scheme Type</label>
											<select name="scheme_type" id="scheme_type" class="form-control">
												<option value="1">+1 Campaign</option>
												<option value="2">Discount on TP</option>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label mb-10">Campaign Name*</label>
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
												<option value="<?= $item->pref_id; ?>">
													<?= $item->item_name; ?>
												</option>
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
													<option value="<?= $item->pref_id; ?>">
														<?= $item->item_name; ?>
													</option>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label mb-10">Quantity given free</label>
												<input type="number" name="quantity_for_free_item" class="form-control" value="<?= set_value('quantity_for_free_item'); ?>">
												<small id="validQuantityErr" style="color: red; font-weight: bold; margin-top: 5px; display: none">Please provide valid quantity</small>
												<?= form_error('quantity_for_free_item', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label mb-10">Scheme Amount</label>
												<input type="number" name="scheme_amount" class="form-control" value="<?= set_value('scheme_amount'); ?>" readonly>
												<?= form_error('scheme_amount', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label mb-10">Scheme Image</label>
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
													<option value="<?= $item->pref_id; ?>">
														<?= $item->item_name; ?>
													</option>
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
												<input type="file" id="scheme_image_disc_tp" name="scheme_image_disc_tp" class="form-control" accept=".jpg,.bmp,.jpeg,png"
												/>
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
							<strong>Note: </strong> Please double-check the entries after providing all the information as you won't be able to update
							this campaign
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
