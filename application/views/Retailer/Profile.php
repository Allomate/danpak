<?php require_once APPPATH . '/views/includes/header.php';?>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once APPPATH . '/views/includes/navbar&sidebar.php';?>
	<div class="page-wrapper">
		<div class="container-fluid">
			<div class="row pt-25">
				<div class="col-md-3">
					<div class="panel panel-success contact-card card-view w-box-sec" style="min-height: 454px">
						<div class="panel-wrapper collapse in">
							<div class="panel-body  pa-0">
								<div class="profile-box">
									<div class="profile-info">
										<h5 class="block mb-5 weight-500 capitalize-font txt-info">Company Name</h5>
									</div>
									<div class="contact-info">
										<div class="row">
											<div class="col-md-12 p-t-20 p-b-40">
												<p>
													<i class="zmdi zmdi-account-calendar"> </i>
													<?= $retailer->retailer_name; ?>
												</p>
												<p>
													<i class="zmdi zmdi-phone"> </i>
													<?= $retailer->retailer_phone; ?>
												</p>
												<p class="m-t-5 m-b-40">
													<i class="fa fa-map-marker"> </i>
													<?= $retailer->retailer_address; ?>
												</p>
												<p class="m-t-5 m-b-5">
													<strong>Territory:</strong>
													<?= $data["retailer_additional_info"]->territory; ?>
												</p>
												<p class="m-t-5 m-b-5">
													<strong>Area:</strong>
													<?= $data["retailer_additional_info"]->area; ?>
												</p>
												<p class="m-t-5 m-b-5">
													<strong>Region:</strong>
													<?= $data["retailer_additional_info"]->region; ?>
												</p>
											</div>
										</div>
										<a href="<?= base_url('Retailers/UpdateRetailer/'.$this->uri->segment(3)); ?>">
											<button class="btn btn-blue btn-block btn-anim">
												<i class="fa fa-pencil"></i>
												<span class="btn-text">edit profile</span>
											</button>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-default card-view pa-0 w-box-sec">
						<img class="Store_img img-responsive" src="<?= base_url(str_replace('./', '', $retailer->retailer_image)); ?>"
						 alt="" />
					</div>
				</div>
				<div class="col-md-3">
					<div class="panel panel-default card-view pa-0 w-box-sec">
						<div class="panel-wrapper collapse in">
							<div class="panel-body pa-0">
								<div class="sm-data-box">
									<div class="container-fluid">
										<div class="row">
											<div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left H-Auto">
												<span class="txt-dark block counter">
													<span class="counter-anim">
														<?= $data["order_stats"]->total_orders_this_month;?>
													</span>
												</span>
												<span class="weight-500 uppercase-font block">This Month Orders</span>
											</div>
											<div class="dist-profile-icons">
												<img src="/assets/images/icon-order-month.svg" alt="" />
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="panel panel-default card-view pa-0 w-box-sec">
						<div class="panel-wrapper collapse in">
							<div class="panel-body pa-0">
								<div class="sm-data-box">
									<div class="container-fluid">
										<div class="row">
											<div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left H-Auto">
												<span class="txt-dark block counter">
													<span class="counter-anim">
														<?= $data["order_stats"]->total_visits;?>
													</span>
												</span>
												<span class="weight-500 uppercase-font block">Total Visits</span>
											</div>
											<div class="dist-profile-icons">
												<img src="/assets/images/icon-sale-month.svg" alt="" />
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="panel panel-default card-view pa-0 w-box-sec">
						<div class="panel-wrapper collapse in">
							<div class="panel-body pa-0">
								<div class="sm-data-box">
									<div class="container-fluid">
										<div class="row">
											<div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left H-Auto">
												<span class="txt-dark block counter">
													<span class="counter-anim">
														<?= number_format($data["order_stats"]->total_sale);?>
													</span>
												</span>
												<span class="weight-500 uppercase-font block">Total Sale</span>
											</div>
											<div class="dist-profile-icons">
												<img src="/assets/images/icon-all-sale.svg" alt="" />
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="panel panel-default card-view pa-0 w-box-sec">
						<div class="panel-wrapper collapse in">
							<div class="panel-body pa-0">
								<div class="sm-data-box">
									<div class="container-fluid">
										<div class="row">
											<div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left H-Auto">
												<span class="txt-dark block counter">
													<span class="counter-anim">
														<?= $data["order_stats"]->total_orders;?>
													</span>
												</span>
												<span class="weight-500 uppercase-font block font-13">Total Orders</span>
											</div>
											<div class="dist-profile-icons">
												<img src="/assets/images/icon-all-order.svg" alt="" />
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-9">
					<div class="panel panel-default card-view panel-refresh w-box-sec p-b-20">
						<div class="tab-struct custom-tab-1">
							<ul role="tablist" class="nav nav-tabs" id="myTabs_7">
								<li class="active" role="presentation">
									<a aria-expanded="true" data-toggle="tab" role="tab" id="home_tab_7" href="#visits-list">VISITS</a>
								</li>
								<li role="presentation" class="">
									<a data-toggle="tab" id="profile_tab_7" role="tab" href="#orders-list" aria-expanded="false">ORDERS</a>
								</li>
							</ul>
							<div class="tab-content" id="myTabContent_7">
								<div id="visits-list" class="tab-pane fade active in" role="tabpanel">
									<div class="table-wrap">
										<div class="table-responsive">
											<table id="datable_1" class="table table-hover display  pb-30">
												<thead>
													<tr>
														<th>Time</th>
														<th>Date</th>
														<th>Employee Name</th>
														<th>Picture</th>
													</tr>
												</thead>
												<tfoot>
													<tr>
														<th>Time</th>
														<th>Date</th>
														<th>Employee Name</th>
														<th>Picture</th>
													</tr>
												</tfoot>
												<tbody>
													<?php foreach($data['visits'] as $visits):?>
													<tr>
														<td>
															<?= $visits->time; ?>
														</td>
														<td>
															<?= $visits->date; ?>
														</td>
														<td>
															<?= $visits->employee; ?>
														</td>
														<td>
															<?php if($visits->picture && $visits->picture !== ""): ?>
															<img id="storeImg" alt="<?= $retailer->retailer_name; ?>" src="<?= $visits->picture; ?>" width="70" />
															<?php else: ?>
															<strong>No Picture</strong>
															<?php endif; ?>
														</td>
													</tr>
													<?php endforeach;?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div id="orders-list" class="tab-pane fade" role="tabpanel">
									<div class="table-wrap">
										<div class="table-responsive">
											<table id="datable_2" class="table table-hover display  pb-30">
												<thead>
													<tr>
														<th>Date</th>
														<th>Employee Id</th>
														<th>Employee Name</th>
														<th>Total Orders</th>
														<th>Action</th>
													</tr>
												</thead>
												<tfoot>
													<tr>
														<th>Date</th>
														<th>Employee Id</th>
														<th>Employee Name</th>
														<th>Total Orders</th>
														<th>Action</th>
													</tr>
												</tfoot>
												<tbody>
													<?php foreach($data['orders'] as $order):?>
													<tr>
														<td>
															<?= $order["date"]; ?>
														</td>
														<td>
															<?= $order["employee_id"]; ?>
														</td>
														<td>
															<?= $order["employee_username"]; ?>
														</td>
														<td>
															<span class="bluetext">
																<?= $order["totalOrders"]; ?>
															</span>
														</td>
														<td>
															<a href="<?= base_url('Orders/ListOrdersIndividualAgainstRetailer/'.$order['employee_id'].'/'.$order['date'].'/'.$order['retailer_id']); ?>">
																<button class="btn view-report">View Orders List</button>
															</a>
														</td>
													</tr>
													<?php endforeach;?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
					<div class="panel panel-default card-view w-box-sec">
						<div class="panel-heading">
							<div class="pull-left">
								<h6 class="panel-title txt-dark">Top Product Sales</h6>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="panel-wrapper collapse in">
							<div class="panel-body p-t-0">
								<?php foreach($data["top_products"] as $products):?>
								<span class="font-12 head-font txt-dark">
									<?= $products->product; ?>
									<span class="pull-right">
										<?= $products->percent_value; ?>%</span>
								</span>
								<div class="progress mt-5 mb-30">
									<div class="progress-bar progress-bar-info" aria-valuenow="<?= $products->percent_value; ?>" aria-valuemin="0"
									 aria-valuemax="100" style="width: <?= $products->percent_value; ?>%" role="progressbar">
										<span class="sr-only">
											<?= $products->percent_value; ?>% Complete (success)</span>
									</div>
								</div>
								<?php endforeach;?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- show large image-->
<div id="myModal" class="modal">
	<span class="close">&times;</span>
	<img class="modal-content" id="img01">
	<div id="caption"></div>
</div>
<?php require_once APPPATH . '/views/includes/footer.php';?>
<script>
	var modal = document.getElementById('myModal');
	var img = document.getElementById('storeImg');
	var modalImg = document.getElementById("img01");
	var captionText = document.getElementById("caption");
	img.onclick = function () {
		modal.style.display = "block";
		modalImg.src = this.src;
		captionText.innerHTML = this.alt;
	}
	var span = document.getElementsByClassName("close")[0];
	span.onclick = function () {
		modal.style.display = "none";
	}

</script>
<style>
	.Store_img {
		height: 452px;
		width: 100%;
		border-radius: 10px;
	}

	@media (max-width:1200px) {
		.Store_img {
			height: 390px;
		}
	}

	#storeImg {
		border-radius: 5px;
		cursor: pointer;
		transition: .3s
	}

	#storeImg:hover {
		opacity: .7
	}

	.modal {
		display: none;
		position: fixed;
		z-index: 5000;
		padding-top: 100px;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		overflow: auto;
		background-color: #000;
		background-color: rgba(0, 0, 0, .9)
	}

	#caption,
	.modal-content {
		margin: auto;
		display: block;
		width: 80%;
		max-width: 700px
	}

	#caption {
		text-align: center;
		color: #ccc;
		padding: 10px 0;
		height: 150px
	}

	#caption,
	.modal-content {
		-webkit-animation-name: zoom;
		-webkit-animation-duration: .6s;
		animation-name: zoom;
		animation-duration: .6s
	}

	@-webkit-keyframes zoom {
		from {
			-webkit-transform: scale(0)
		}

		to {
			-webkit-transform: scale(1)
		}
	}

	@keyframes zoom {
		from {
			transform: scale(0)
		}

		to {
			transform: scale(1)
		}
	}

	.close {
		position: absolute;
		top: 15px;
		right: 35px;
		color: #fff;
		font-size: 40px;
		font-weight: 700;
		transition: .3s;
		opacity: 1 !important
	}

	.close:focus,
	.close:hover {
		color: #fff;
		text-decoration: none;
		cursor: pointer
	}

	@media only screen and (max-width:700px) {
		.modal-content {
			width: 100%
		}
	}

	}

</style>
