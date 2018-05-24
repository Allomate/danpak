<?php require_once(APPPATH.'/views/includes/header.php'); ?>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once(APPPATH.'/views/includes/navbar&sidebar.php'); ?>
	<div class="page-wrapper">
		<div class="container-fluid">
			<?php if ($feedback = $this->session->flashdata('campaign_created')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Added</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('campaign_creation_failed')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Failed</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
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
					<?= form_hidden('urlForCampaignDetails', base_url('CampaignManagement/GetCampaignDetailsForAjax')); ?>
					<div class="box-white p-20"><a href="<?= base_url('CampaignManagement/AddCampaign');?>" class="btn add-emp"><i class="fa fa-plus"> </i> Create Campaign</a>
						<h2 class="m-b-0">Campaigns List </h2>
						<div class="table-wrap">
							<div class="table-responsive">
								<table  class="table table-hover display  pb-30" >
									<thead>
										<tr>
											<th>Campaign Name</th>
											<th>Campaign Type</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Campaign Name</th>
											<th>Campaign Type</th>
											<th>Actions</th>
										</tr>
									</tfoot>
									<tbody>
										<?php foreach ($Campaigns as $campaign) : ?>
											<tr>
												<td><?= $campaign->campaign_name; ?></td>
												<td><?= $campaign->scheme_type == "1" ? '+1 Scheme ' : 'Discount on TP' ?></td>
												<td>
													<a class="view-report viewDetail" id="<?= $campaign->campaign_id; ?>" style="cursor: pointer">View Detail</a>
													<a href="<?= base_url('CampaignManagement/UpdateCampaign/'.$campaign->campaign_id); ?>"><i class="fa fa-pencil"></i></a>
													&nbsp;
													<a class="deleteConfirmation" href="<?= base_url('CampaignManagement/DeleteCampaign/'.$campaign->campaign_id); ?>"><i class="fa fa-close"></i></a>
												</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog" style="width: 80%;">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Campaign Details</h4>
				</div>
				<div class="modal-body">
					<div id="schemeOfferDetailsModalBody">
						<table class="table table-stripped viewCampaignDetailsTable">
							<thead>
								<tr>
									<th>Item Name</th>
									<th>Minimum Eligibility Criteria</th>
									<th>Item Given Free</th>
									<th>Scheme Amount</th>
									<th>Discount (%)</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<div id="discountOnTpDetailsModalBody">
						<div class="row">
							<div class="col-md-6" style="text-align: center">
								<h3>Packaging: </h3> <span style="font-weight: bolder" id="packaging"> </span>
							</div>
							<div class="col-md-6" style="text-align: center">
								<h3>Contains: </h3> <span style="font-weight: bolder" id="contains"> </span>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-6" style="text-align: center">
								<h3>Minimum Quantity for Eligibility: </h3> <span style="font-weight: bolder" id="minimum_quantity_for_eligibility"></span>
							</div>
							<div class="col-md-6" style="text-align: center">
								<h3>Actual Bill (5 CTN): </h3> <span style="font-weight: bolder" id="actual_bill"></span>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-6" style="text-align: center">
								<h3>Scheme offer on TP: </h3> <span style="font-weight: bolder" id="scheme_offer_on_tp"> </span>
							</div>
							<div class="col-md-6" style="text-align: center">
								<h3>Price of each CTN: <small>(after scheme)</small> </h3> <span style="font-weight: bolder" id="price_of_each_packaging"> </span>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-6" style="text-align: center">
								<h3>Net Discount: </h3> <span style="font-weight: bolder" id="savings_each_cartan"> </span>
							</div>
							<div class="col-md-6" style="text-align: center">
								<h3>Savings on Scheme Minimum Eligible Quantity: </h3> <span style="font-weight: bolder" id="savings_on_scheme"></span>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script type="text/javascript" src="<?= base_url('assets/js/Campaign.js?v='.time()); ?>"></script>