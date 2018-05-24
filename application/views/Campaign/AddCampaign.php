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
						<li><a href="#"><span>Organization</span></a></li>
						<li><span>Campaign Management</span></li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="box-white m-b-30">
						<h2>Add Campaign</h2>
						<?php $attributes = array('id' => 'addCampaignFOrm');
						echo form_open('CampaignManagement/AddCampaignOps', $attributes); ?>
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
													<option value="<?= $item->pref_id; ?>"><?= $item->item_name; ?></option>
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
														<option value="<?= $item->pref_id; ?>"><?= $item->item_name; ?></option>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label mb-10">Quantity given free</label>
												<input type="number" name="quantity_for_free_item" class="form-control" value="<?= set_value('quantity_for_free_item'); ?>">
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
												<label class="control-label mb-10">Distributor Discount (%)</label>
												<input type="number" name="discount_on_scheme" class="form-control" value="<?= set_value('discount_on_scheme'); ?>">
												<?= form_error('discount_on_scheme', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
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
														<option value="<?= $item->pref_id; ?>"><?= $item->item_name; ?></option>
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
												<label class="control-label mb-10">Distributor Discount (%)</label>
												<input type="number" name="distributor_discount" class="form-control" value="<?= set_value('distributor_discount'); ?>">
												<?= form_error('distributor_discount', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<input type="text" id="urlForItemTradePrice" value="<?= base_url('CampaignManagement/GetItemPriceForSchemeAmountCalculationAjax'); ?>" hidden>
		<div class="row button-section">
			<a type="button" href="<?= base_url('CampaignManagement/ListCampaigns'); ?>" id="backFromTerritoryButton" class="btn btn-cancel">Cancel</a>
			<a type="button" id="addCampaignBtn" class="btn btn-save">Save</a>						
		</div>
	</div>
</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script type="text/javascript" src="<?= base_url('assets/js/Campaign.js').'?v='.time(); ?>"></script>