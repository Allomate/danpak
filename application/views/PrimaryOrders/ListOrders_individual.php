<?php require_once(APPPATH.'/views/includes/header.php'); ?>
<style>
	#map {
		height: 400px;
		width: 100%;
	}

</style>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once(APPPATH.'/views/includes/navbar&sidebar.php'); ?>
	<div class="fixed-sidebar-right">
		<a href="#" id="open_right_sidebar" class="close-btn-pl"></a>
		<div class="pro-header-text">
			<h3>Update Order</h3>
			<div id="addProductNew" class="collapse">
				<div class="form-wrap">
					<div class="row">
						<div class="col-md-12">
							<h4 class="heading">Add New Product</h4>
						</div>
						<input type="text" id="newProductPrice" hidden>
						<input type="text" id="newProductPrefId" hidden>
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label class="control-label">Select Item</label>
								<select id="item_id" class="form-control" data-style="form-control btn-default btn-outline">
									<?php foreach( $inventory as $inv ) : ?>
									<option value="<?= $inv->item_id; ?>">
										<?= $inv->item_name; ?>
									</option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label class="control-label">Select Unit</label>
								<select id="unit_id_dd" class="form-control" data-style="form-control btn-default btn-outline">
								</select>
							</div>
						</div>
						<div class="col-md-3 col-sm-6">
							<div class="form-group">
								<label class="control-label">Quantity</label>
								<input type="text" id="quantityForNewItem" class="form-control" placeholder="">
							</div>
						</div>
						<div class="col-md-3 col-sm-6">
							<div class="form-group">
								<label class="control-label">Discount (%)</label>
								<input type="text" id="discountForNewItem" class="form-control" placeholder="">
							</div>
						</div>
						<div class="col-md-3 col-sm-6">
							<div class="form-group">
								<label class="control-label">Product Amount</label>
								<span id="newProductAmount" style="line-height: 40px;">0</span>
							</div>
						</div>
						<div class="col-md-12" id="campaignAvailableAlert" style="display: none">
							<strong>Campaign Available</strong> There is a campaign available for this product. Do you want to avail?
							<br>
							<strong>Minimum Quantity</strong> <span id="minimumQuant"></span>
							<br>
							<strong>Total Price</strong> <span id="totalPrice"> </span>
							<br><br>
							<div class="row">
								<div class="col-md-12">
									<button class="btn btn-sm" style="color: white; background: #001e35; padding: 10px; font-size: 8pt; width: 50px;"
									 id="yesAddCampaign">YES</button>
								</div>
							</div>
							<hr>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<button type="button" class="btn btn-save mr-5 m-t-10" id="addNewProductButton">Add Product</button>
								<button type="button" class="btn btn-cancel  m-t-10" data-toggle="collapse" data-target="#addProductNew">Cancel</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="pc-cartlist">
			<div class="overflow-plist">
				<div class="plist-content">
					<div class="_left-filter">
						<div class="row RE-info">
							<div class="col-md-8 col-sm-7">
								<span class="block">Order booker: <span id="obName"><strong></strong></span> </span>
								<span class="font-16 block"><span id="retailerName"><strong></strong></span></span>
								<span class="mr-20">Date: <span id="orderDate"><strong></strong></span> </span>
								<span class="mr-20">ID: <span id="orderId"><strong></strong></span> </span>
								<span class="mr-20">Territory: <span id="terrName"><strong>Jahor Town</strong></span></span>
							</div>
							<div class="col-md-4 col-sm-5">
								<div class="total_am">Total Amount: <span id="orderTotal"></span></div>
							</div>
						</div>
						<div id="updateItemsHolder"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="_cl-bottom">
			<button type="submit" class="btn btn-save mr-5" id="saveUpdatedOrder">Save</button>
			<button type="button" class="btn btn-save mr-5" data-toggle="collapse" data-target="#addProductNew">Add Product</button>
			<button id="open_right_sidebar" class="btn btn-cancel">Cancel</button>
		</div>
	</div>
	<style>
		.heading {
			font-size: 18px;
			font-weight: 500;
			border-bottom: solid 2px #d9dde1;
			line-height: normal;
			padding-bottom: 15px;
			margin-bottom: 10px;
		}

		#addProductNew .form-wrap {
			padding: 20px;
			margin-top: 0px;
			background-color: #fff;
			border-bottom: solid 2px #001e35;
		}

		#addProductNew .control-label {
			font-size: 13px;
			color: #5f5f67 !important;
			padding: 0 !important;
			margin: 0 !important;
			font-weight: normal;
			display: block;
			height: 30px;
			line-height: 30px;
		}

		#addProductNew .form-wrap .form-group {
			margin-bottom: 10px
		}

		.pro_list-update {
			width: 100%;
			overflow: hidden;
			float: left;
			padding: 15px 130px 15px 15px;
			border-bottom: solid 1px #e9e9e9;
			position: relative
		}

		.-amont-pr {
			font-size: 16px;
			font-weight: 600;
			position: absolute;
			top: 40px;
			right: 40px
		}

		.pro_list-update .control-label {
			font-size: 12px;
			padding: 0 !important;
			margin: 0 !important
		}

		.pro_list-update .form-control {
			height: 28px;
			font-size: 14px
		}

		.pro_list-update input {
			width: 80px;
			padding-left: 7px;
			padding-right: 7px
		}

		.pro_list-update .-wselect {
			width: 150px !important;
		}

		.pro_list-update .del-btn,
		.pro_list-update .del-btn:HOVER,
		.pro_list-update .del-btn:focus {
			position: absolute;
			padding: 0;
			margin: 0;
			top: 10px;
			right: 10px;
			background-color: transparent !important;
			color: #f12300;
			box-shadow: nonne
		}

		.pro_list-update .p-name {
			font-family: noir_prolight !important;
			font-size: 14px;
			font-weight: 600;
			padding: 0;
			margin: 0;
			line-height: normal;
			letter-spacing: 0.5px
		}

		.pro_list-update .del-btn .fa-times {
			font-size: 16px;
		}

		.pro_img {
			float: left;
			height: 75px;
			padding-right: 15px
		}

		.pro_img img {
			width: 75px;
			height: 75px;
		}

		.up-info-list {
			padding: 5px 0px 0px;
			margin: 0;
		}

		.up-info-list li {
			padding: 0;
			margin: 0;
			float: left;
			margin-right: 10px
		}

		.total_am {
			border: solid 1px #001e35;
			font-weight: 600;
			padding: 10px 15px;
			float: right;
			margin-top: 12px;
			border-radius: 6px;
			box-shadow: 2px 2px 10px 0 rgba(79, 79, 79, .2);
		}

		.RE-info {
			float: left;
			background-color: #f7f7f7;
			display: block;
			width: 100%;
			margin: 0;
			padding: 15px 5px;
			font-size: 15px;
			font-weight: 500;
			-webkit-transition: 450ms cubic-bezier(0.23, 1, 0.32, 1);
			-moz-transition: 450ms cubic-bezier(0.23, 1, 0.32, 1);
			transition: 450ms cubic-bezier(0.23, 1, 0.32, 1);
		}

		.RE-info span {
			letter-spacing: 0.5px
		}

		.no-scroll {
			overflow: hidden
		}

		.fixed-sidebar-right {
			position: fixed;
			top: 0px;
			right: 0;
			width: 850px;
			margin-right: -850px;
			bottom: 0;
			z-index: 1500;
			transition: all .4s ease;
			height: 100vh;
			overflow-y: auto;
			-webkit-overflow-scrolling: touch;
			display: flex;
			flex-direction: column;
			background-color: #FFF;
		}

		.open-right-sidebar .fixed-sidebar-right {
			-webkit-box-shadow: 0 0px 220px 0 rgba(79, 79, 79, 1);
			-moz-box-shadow: 0 0px 220px 0 rgba(79, 79, 79, 1);
			box-shadow: 0 0px 220px 0 rgba(79, 79, 79, 1);
		}

		.overlay {
			display: none;
			position: fixed;
			width: 100vw;
			height: 100vh;
			background: rgba(0, 0, 0, .5);
			z-index: 998;
			opacity: 0;
		}

		.overlay.active {
			display: block;
			opacity: 1;
		}

		.pro-header-text {
			border-bottom: solid 1px #fff;
			background-color: #001e35;
			position: relative;
			margin-left: 0;
			width: inherit;
		}

		.pro-header-text h3 {
			font-size: 18px;
			padding: 0px;
			margin: 0;
			font-weight: 500;
			color: #fff;
			padding: 5px 5px 5px 15px;
		}

		.pc-cartlist {
			display: flex;
			flex: 1;
			min-height: 0px;
			padding-bottom: 65px;
		}

		.overflow-plist {
			flex: 1;
			overflow: auto;
		}

		.plist-content {
			color: black;
			height: 100%;
		}

		.custom-select:focus,
		.form-control:focus {
			box-shadow: none
		}

		._cl-checkout {
			background-color: #001e35;
			font-size: 18px;
			color: #fff;
			font-weight: 500;
			width: 100%;
			text-align: left;
			padding: 10px;
			padding-left: 15px;
			-webkit-border-radius: 0;
			-moz-border-radius: 0;
			border-radius: 0;
			-khtml-border-radius: 0;
		}

		.close-btn-pl {
			position: absolute;
			right: 10px;
			top: 15px;
			width: 30px;
			height: 30px;
			z-index: 100;
		}

		.close-btn-pl:hover {
			opacity: 1
		}

		.close-btn-pl:after,
		.close-btn-pl:before {
			position: absolute;
			left: 15px;
			content: ' ';
			height: 19px;
			width: 2px;
			background-color: #fff
		}

		.close-btn-pl:before {
			transform: rotate(45deg)
		}

		.close-btn-pl:after {
			transform: rotate(-45deg)
		}

		._cl-bottom {
			height: 60px;
			margin: 0;
			padding: 10px;
			position: fixed;
			width: 0;
			right: 0;
			bottom: -1px;
			z-index: 100;
			opacity: 0;
			background-color: #f6f6f6;
			padding-left: 15px;
		}

		.open-right-sidebar .fixed-sidebar-right ._cl-bottom {
			opacity: 1;
			transition: opacity 0.7s linear;
			-webkit-transition: 0.7s cubic-bezier(0.23, 1, 0.32, 1);
			-moz-transition: 0.7s cubic-bezier(0.23, 1, 0.32, 1);
			transition: 0.7s cubic-bezier(0.23, 1, 0.32, 1);
			width: 850px;
		}

		._cl-bottom .btn,
		#addProductNew .btn {
			font-size: 14px;
			margin-top: 2px;
			font-weight: 500;
			box-shadow: none;
			box-shadow: 2px 2px 10px 0 rgba(79, 79, 79, .2);
		}

		@media (max-width:800px) {
			.open-right-sidebar .fixed-sidebar-right ._cl-bottom {
				width: 100%
			}

			.fixed-sidebar-right {
				width: 100%;
				margin-right: -100%;
			}

			.pro_img {
				margin-bottom: 35px
			}

			.up-info-list li {
				padding-bottom: 5px
			}
		}

		@media (max-width:767px) {
			.total_am {
				float: none;
				text-align: center;
			}
		}

		@media (max-width:480px) {
			.pro_img {
				margin-bottom: 0px
			}

			.-amont-pr {
				right: 20px
			}

			.pro_list-update {
				padding: 15px 108px 15px 15px
			}
		}

	</style>
	<div class="page-wrapper">
		<div class="container-fluid">
			<?php if ($feedback = $this->session->flashdata('order_updated')) : ?>
			<div class="row" style="margin-top: 20px;">
				<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
					<strong>Updated</strong>
					<?= $feedback; ?>
				</div>
			</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('order_update_failed')) : ?>
			<div class="row" style="margin-top: 20px;">
				<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
					<strong>Failed</strong>
					<?= $feedback; ?>
				</div>
			</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('order_processed')) : ?>
			<div class="row" style="margin-top: 20px;">
				<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
					<strong>Processed</strong>
					<?= $feedback; ?>
				</div>
			</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('order_process_failed')) : ?>
			<div class="row" style="margin-top: 20px;">
				<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
					<strong>Failed</strong>
					<?= $feedback; ?>
				</div>
			</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('order_completed')) : ?>
			<div class="row" style="margin-top: 20px;">
				<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
					<strong>Completed</strong>
					<?= $feedback; ?>
				</div>
			</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('order_complete_failed')) : ?>
			<div class="row" style="margin-top: 20px;">
				<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
					<strong>Failed</strong>
					<?= $feedback; ?>
				</div>
			</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('order_cancelled')) : ?>
			<div class="row" style="margin-top: 20px;">
				<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
					<strong>Cancelled</strong>
					<?= $feedback; ?>
				</div>
			</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('order_cancel_failed')) : ?>
			<div class="row" style="margin-top: 20px;">
				<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
					<strong>Failed</strong>
					<?= $feedback; ?>
				</div>
			</div>
			<?php endif; ?>
			<?php if($this->uri->segment(3) !== 'EmployeesList') :?>
			<div class="row p-t-30">
				<div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
					<div class="panel panel-default card-view pa-0 emp-stats pr-box">
						<div class="panel-wrapper collapse in">
							<div class="panel-body pa-0">
								<div class="sm-data-box">
									<div class="container-fluid">
										<div class="row">
											<div class="col-sm-7 col-xs-8 text-center pl-0 pr-0 data-wrap-left">
												<span class="txt-dark block counter">
													<?= $Orders["stats"]["Total"]; ?>
												</span>
												<span class="weight-500 uppercase-font block">Total Orders</span>
											</div>
											<div class="col-sm-5 col-xs-4 text-center pl-0 pr-0">
												<img src="<?= base_url('assets/images/icon-all-orders.svg'); ?>" alt="brand" />
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
					<div class="panel panel-default card-view pa-0 emp-stats absent-box">
						<div class="panel-wrapper">
							<div class="panel-body pa-0">
								<div class="sm-data-box">
									<div class="container-fluid">
										<div class="row">
											<div class="col-sm-7 col-xs-8 text-center pl-0 pr-0 data-wrap-left">
												<span class="txt-dark block counter">
													<?= $Orders["stats"]["Cancelled"]; ?>
												</span>
												<span class="weight-500 uppercase-font block">Cancel Orders</span>
											</div>
											<div class="col-sm-5 col-xs-4 text-center  pl-0 pr-0 ">
												<img src="<?= base_url('assets/images/icon-order-cancelled.svg'); ?>" alt="brand" />
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
					<div class="panel panel-default card-view pa-0 emp-stats blue-box">
						<div class="panel-wrapper collapse in">
							<div class="panel-body pa-0">
								<div class="sm-data-box">
									<div class="container-fluid">
										<div class="row">
											<div class="col-sm-7 col-xs-8 text-center pl-0 pr-0 data-wrap-left">
												<span class="txt-dark block counter">
													<?= $Orders["stats"]["Pending"]; ?>
												</span>
												<span class="weight-500 uppercase-font block font-13">Pending Orders</span>
											</div>
											<div class="col-sm-5 col-xs-4 text-center  pl-0 pr-0">
												<img src="<?= base_url('assets/images/icon-order-pending.svg'); ?>" alt="brand" />
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
					<div class="panel panel-default card-view pa-0 emp-stats total-box">
						<div class="panel-wrapper collapse in">
							<div class="panel-body pa-0">
								<div class="sm-data-box">
									<div class="container-fluid">
										<div class="row">
											<div class="col-sm-7 col-xs-8 text-center pl-0 pr-0 data-wrap-left">
												<span class="txt-dark block counter">
													<?= $Orders["stats"]["Completed"]; ?>
												</span>
												<span class="weight-500 uppercase-font block font-13">Complete Orders</span>
											</div>
											<div class="col-sm-5 col-xs-4 text-center  pl-0 pr-0">
												<img src="<?= base_url('assets/images/icon-order-done.svg'); ?>" alt="brand" />
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php else: ?>
			<div class="row p-t-30">
				<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 ">
					<div class="panel panel-default card-view pa-0 emp-stats blue-box">
						<div class="panel-wrapper collapse in">
							<div class="panel-body pa-0">
								<div class="sm-data-box">
									<div class="container-fluid">
										<div class="row">
											<div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
												<span class="txt-dark block counter">
													<?= $Orders["stats"]["Compliance"]; ?>
												</span>
												<span class="weight-500 uppercase-font block font-13">Orders Compliance</span>
											</div>
											<div class="col-xs-6 text-center  pl-0 pr-0">
												<img src="<?= base_url('assets/images/icon-order-done.svg'); ?>" alt="brand" />
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 ">
					<div class="panel panel-default card-view pa-0 emp-stats total-box">
						<div class="panel-wrapper collapse in">
							<div class="panel-body pa-0">
								<div class="sm-data-box">
									<div class="container-fluid">
										<div class="row">
											<div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
												<span class="txt-dark block counter">
													<?= $Orders["stats"]["NonCompliance"]; ?>
												</span>
												<span class="weight-500 uppercase-font block font-13">Orders None Compliance</span>
											</div>
											<div class="col-xs-6 text-center  pl-0 pr-0">
												<img src="<?= base_url('assets/images/icon-order-cancelled.svg'); ?>" alt="brand" />
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php endif; ?>

			<div class="row">
				<div class="col-md-12">
					<div class="box-white p-20">
						<?php if($this->uri->segment(5) == "Pending") : ?>
						<div class="row" style="font-size: 22px; border-bottom: solid 2px #d9dde1; line-height: normal; padding-bottom: 15px;">
							<div class="col-md-9">
								<h3>Orders List (
									<?= $this->uri->segment(5); ?> )
								</h3>
							</div>
							<div class="col-md-3" style="text-align: right; padding-right: 50px;">
								<a href="<?= base_url('PrimaryOrders/ProcessAll/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'); ?>">
									<button class="btn view-report">Process All</button>
								</a>
							</div>
						</div>
						<?php elseif($this->uri->segment(5) == "Processed"): ?>
						<div class="row" style="font-size: 22px; border-bottom: solid 2px #d9dde1; line-height: normal; padding-bottom: 15px;">
							<div class="col-md-9">
								<h3>Orders List (
									<?= $this->uri->segment(5); ?> )
								</h3>
							</div>
							<div class="col-md-3" style="text-align: right; padding-right: 50px;">
								<a href="<?= base_url('PrimaryOrders/CompleteAll/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'); ?>">
									<button class="btn view-report">Complete All</button>
								</a>
							</div>
						</div>
						<?php else: ?>
						<h2 class="m-b-0">Orders List (
							<?= $this->uri->segment(5); ?> )
						</h2>
						<?php endif; ?>
						<div class="table-wrap">
							<div class="table-responsive">
								<table class="table table-hover display pb-30">
									<thead>
										<tr>
											<th>Date</th>
											<th>Employee Id</th>
											<th>Employee Name</th>
											<th>Distributor Id</th>
											<th>Distributor Name</th>
											<th>Region</th>
											<th>Area</th>
											<th>Territory</th>
											<?php if($this->uri->segment(3) == "EmployeesList") : ?>
											<th>Order Within Circle</th>
											<?php else : ?>
											<th>Total Price</th>
											<?php endif; ?>
											<th>Status</th>
											<th style="width: 150px">Action</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Date</th>
											<th>Employee Id</th>
											<th>Employee Name</th>
											<th>Distributor Id</th>
											<th>Distributor Name</th>
											<th>Region</th>
											<th>Area</th>
											<th>Territory</th>
											<?php if($this->uri->segment(3) == "EmployeesList") : ?>
											<th>Order Within Circle</th>
											<?php else : ?>
											<th>Total Price</th>
											<?php endif; ?>
											<th>Status</th>
											<th style="width: 150px">Action</th>
										</tr>
									</tfoot>
									<tbody>
										<?php foreach ($Orders["orderDetails"] as $order) : ?>
										<tr>
											<td>
												<?= $order->created_at; ?>
											</td>
											<td>
												<?= $order->employee_id; ?>
											</td>
											<td>
												<?= $order->employee_username; ?>
											</td>
											<td>
												<?= $order->distributor_id; ?>
											</td>
											<td>
												<?= $order->distributor_name; ?>
											</td>
											<td>
												<?= $order->region; ?>
											</td>
											<td>
												<?= $order->area; ?>
											</td>
											<td>
												<?= $order->territory; ?>
											</td>
											<?php if($this->uri->segment(3) == "EmployeesList") : ?>
											<td>
												<?= $order->within_radius ? "Yes" : "No"; ?>
											</td>
											<?php else : ?>
											<td>
												<?= number_format($order->final_price); ?>
											</td>
											<?php endif; ?>
											<td>
												<?= $order->status ? $order->status : "Pending"; ?>
											</td>
											<td>
												<?php if($this->uri->segment(3) !== "EmployeesList") : ?>
												<?php if (strtolower($order->status) == strtolower("Processed")) : ?>

												<a href="#" id="open_right_sidebar" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i
													 class="fa fa-pencil"></i> <input type="number" value="<?= $order->id; ?>" hidden></a>

												<a href="<?= base_url('PrimaryOrders/OrderInvoice/'.$order->id); ?>" data-toggle="tooltip" data-placement="top"
												 title="" data-original-title="Invoice">
													<i class="fa fa-list-alt"></i>
												</a>
												<a id="<?= $order->id; ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Cancel">
													<i class="fa fa-close cancelOrder"></i>
												</a>
												<a id="<?= $order->id; ?>">
													<button class="btn view-report completeOrder">Complete</button>
												</a>
												<?php elseif (!$order->status || $order->status == '') : ?>

												<a href="#" id="open_right_sidebar" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i
													 class="fa fa-pencil"></i> <input type="number" value="<?= $order->id; ?>" hidden></a>

												<a href="<?= base_url('PrimaryOrders/OrderInvoice/'.$order->id); ?>" data-toggle="tooltip" data-placement="top"
												 title="" data-original-title="Invoice">
													<i class="fa fa-list-alt"></i>
												</a>
												<a id="<?= $order->id; ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Cancel">
													<i class="fa fa-close cancelOrder"></i>
												</a>
												<a id="<?= $order->id; ?>">
													<button class="btn view-report processOrder">Process</button>
												</a>
												<?php else: ?>
												<a href="<?= base_url('PrimaryOrders/OrderInvoice/'.$order->id); ?>">
													<button class="btn view-report">View Order Detail</button>
												</a>
												<?php endif; ?>
												<?php else: ?>
												<input type="text" id="empLats" value="<?= $order->booker_lats; ?>" hidden>
												<input type="text" id="empLongs" value="<?= $order->booker_longs; ?>" hidden>
												<input type="text" id="retailerLats" value="<?= $order->retailer_lats; ?>" hidden>
												<input type="text" id="retailerLongs" value="<?= $order->retailer_longs; ?>" hidden>
												<a class="view-report" id="viewDetail" style="cursor: pointer">View Detail</a>
												<?php endif; ?>
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

			<div class="row">
				<div id="myModal" class="modal fade" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Order Location</h4>
							</div>
							<div class="modal-body">
								<div id="map"></div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<input type="text" value="<?= base_url('assets/images/base-station.png'); ?>" id="greenIconUrl" hidden>
<input type="text" value="<?= base_url('assets/images/attendance-location.png'); ?>" id="redIconUrl" hidden>

<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script>
	var imagesLooped = [];
	var selectedProductPropsForNewItem = [];
	var orderId = 0;
	$(document).ready(function () {
		var itemsRemovedFromOrder = [];
		var totalOrderAm = 0;
		var unitProps = [];
		var imgElemCounter = 0;
		var priceForThisUnit = 0;

		$(document).on('click', '#yesAddCampaign', function () {

			if (!$('#unit_id_dd').val()) {
				alert('Please provide valid unit');
				return;
			}

			$('#campaignAvailableAlert').hide();

			var unitObj = selectedProductPropsForNewItem.find(function (item) {
				return item.unit_id == $('#unit_id_dd').val()
			});
			var productExistAlready = false;

			$('.pro_list-update').each(function () {
				var tempData = [];
				if ($(this).find('.prefIdForThisRow').val() == unitObj.pref_id) {
					alert('This product is already added in the cart. Kindly update if necessary');
					productExistAlready = true;
				}
			});

			if (productExistAlready) {
				return;
			}
			$('#updateItemsHolder').append(
				'<div class="pro_list-update"><button class="btn del-btn removeItemFromOrder" id="-1"><i class="fa fa-times"></i></button><div class="pro_img"><img id="imgElem' +
				imgElemCounter + '" src="' +
				unitObj.campaign.scheme_image +
				'" alt="" /></div><div><h3 class="p-name campaignLabel" style="color: gray">-CAMPAIGN-</h3><h3 class="p-name">' +
				unitObj.item_name +
				'</h3><ul class="up-info-list"><li><label class="control-label mb-10">Unit</label><select class="form-control unitsInContentsDD" style="height: 30px" name="units' +
				imgElemCounter +
				'" data-style="form-control btn-default btn-outline"></select></li><li><label class="control-label mb-10">Discount (%)</label><input type="text" value="' +
				$('#discountForNewItem').val() +
				'" id="bookerDiscountToAdd" class="form-control" placeholder="5%"></li><li><label class="control-label mb-10">Qty</label><input type="number" value="' +
				unitObj.campaign.item_quantity +
				'" name="quantity" class="form-control" disabled="disabled"/></li><li style="display:none"><label class="control-label mb-10">Campaign</label><input type="text" id="" class="form-control -wselect" placeholder="use select2"></li><li style="display:none"><label class="control-label mb-10">Campaign Qty</label><input type="number" name="quantity" class="form-control"></li></ul><input value="' +
				unitObj.campaign.pref_id + '" class="prefIdForThisRow" hidden /><input value="' +
				unitObj.item_id +
				'" class="itemIdForThisRow" hidden /><input value="' + unitObj.campaign.final_price +
				'" class="priceForThisUnit" hidden /><input value="' + unitObj.campaign.campaign_id +
				'" class="campaign_id" hidden /><div class="-amont-pr">Rs: ' +
				unitObj.campaign.final_price + '</div></div></div>');
			imageExist(unitObj.campaign.scheme_image, imgElemCounter, unitObj.campaign.pref_id);
			selectedProductPropsForNewItem.forEach(unitsElem => {
				if (unitsElem['unit_id'] == $('#unit_id_dd').val()) {
					$('[name="units' + imgElemCounter + '"]').append('<option value="' + unitsElem['unit_id'] +
						'" selected>' +
						unitsElem['unit_name'] + '</option>');
				}
			});
			totalOrderAm = 0;
			$('.pro_list-update').each(function () {
				totalOrderAm += parseFloat($(this).find('.-amont-pr').text().split(" ")[1]);
			});
			$('#orderTotal').text(totalOrderAm);
			imgElemCounter++;
		});

		$(document).on('click', '#addNewProductButton', function () {
			if (!$('#quantityForNewItem').val() || !$('#unit_id_dd').val() || parseInt($('#quantityForNewItem').val()) <= 0) {
				alert('Please provide valid quantity');
				return;
			}

			var unitObj = selectedProductPropsForNewItem.find(function (item) {
				return item.unit_id == $('#unit_id_dd').val()
			});

			var productExistAlready = false;

			$('.pro_list-update').each(function () {
				var tempData = [];
				if ($(this).find('.prefIdForThisRow').val() == unitObj.pref_id) {
					alert('This product is already added in the cart. Kindly update if necessary');
					productExistAlready = true;
				}
			});
			if (productExistAlready) {
				return;
			}

			$('#updateItemsHolder').append(
				'<div class="pro_list-update"><button class="btn del-btn removeItemFromOrder" id="-1"><i class="fa fa-times"></i></button><div class="pro_img"><img id="imgElem' +
				imgElemCounter + '" src="' +
				unitObj.item_thumbnail + '" alt="" /></div><div><h3 class="p-name">' + unitObj.item_name +
				'</h3><ul class="up-info-list"><li><label class="control-label mb-10">Unit</label><select class="form-control unitsInContentsDD" style="height: 30px" name="units' +
				imgElemCounter +
				'" data-style="form-control btn-default btn-outline"></select></li><li><label class="control-label mb-10">Discount (%)</label><input type="text" value="' +
				$('#discountForNewItem').val() +
				'" id="bookerDiscountToAdd" class="form-control" placeholder="5%"></li><li><label class="control-label mb-10">Qty</label><input type="number" value="' +
				$('#quantityForNewItem').val() +
				'" name="quantity" class="form-control"></li><li style="display:none"><label class="control-label mb-10">Campaign</label><input type="text" id="" class="form-control -wselect" placeholder="use select2"></li><li style="display:none"><label class="control-label mb-10">Campaign Qty</label><input type="number" name="quantity" class="form-control"></li></ul><input value="' +
				$('#newProductPrefId').val() + '" class="prefIdForThisRow" hidden /><input value="' +
				unitObj.item_id +
				'" class="itemIdForThisRow" hidden /><input value="' + priceForThisUnit +
				'" class="priceForThisUnit" hidden /><div class="-amont-pr">Rs: ' +
				$('#newProductAmount').text() + '</div></div></div>');
			imageExist(unitObj.item_thumbnail, imgElemCounter, unitObj.pref_id);
			selectedProductPropsForNewItem.forEach(unitsElem => {
				if (unitsElem['unit_id'] == $('#unit_id_dd').val()) {
					$('[name="units' + imgElemCounter + '"]').append('<option value="' + unitsElem['unit_id'] +
						'" selected>' +
						unitsElem['unit_name'] + '</option>');
				} else {
					$('[name="units' + imgElemCounter + '"]').append('<option value="' + unitsElem['unit_id'] + '" >' +
						unitsElem['unit_name'] + '</option>');
				}
			});
			totalOrderAm = 0;
			$('.pro_list-update').each(function () {
				totalOrderAm += parseFloat($(this).find('.-amont-pr').text().split(" ")[1]);
			});
			$('#orderTotal').text(totalOrderAm);
			$('#quantityForNewItem').val(0);
			$('#discountForNewItem').val(0);
			$('#newProductAmount').text(0);
			imgElemCounter++;
		});

		$(document).on('change', '.unitsInContentsDD', function () {
			var unitIdSelected = $(this).val();
			var itemId = $(this).parent().parent().parent().find('.itemIdForThisRow').val();
			var quant = parseInt($(this).parent().parent().find('li:eq(2) [name="quantity"]').val());
			var thisRef = $(this);
			$('#orderTotal').text('...');
			thisRef.parent().parent().parent().find('.-amont-pr').text('...');
			$.ajax({
				type: 'GET',
				url: '/PrimaryOrders/GetPriceForThisVariant/' + itemId + '/' + unitIdSelected + '/' + orderId,
				success: function (response) {
					var origPrice = parseFloat(JSON.parse(response)) * quant;
					var discount = (parseInt(thisRef.parent().parent().find('li:eq(1) #bookerDiscountToAdd').val()) / 100) *
						origPrice;
					var discountedPrice = Math.round(origPrice - discount);
					thisRef.parent().parent().parent().find('.priceForThisUnit').val(JSON.parse(response));
					thisRef.parent().parent().parent().find('.-amont-pr').text('Rs: ' + discountedPrice);
					totalOrderAm = 0;
					$('.pro_list-update').each(function () {
						totalOrderAm += parseFloat($(this).find('.-amont-pr').text().split(" ")[1]);
					});
					$('#orderTotal').text(totalOrderAm);
				}
			});
		});

		$(document).on('click', '#open_right_sidebar', function () {
			var thisRef = $(this);
			itemsRemovedFromOrder = [];
			imagesLooped = [];
			unitProps = [];

			getUnitsForCurrentitem(thisRef.find('[type="number"]').val());
			orderId = thisRef.find('[type="number"]').val();

			$.ajax({
				type: 'GET',
				url: '/PrimaryOrders/UpdateOrderAjax/' + thisRef.find('[type="number"]').val(),
				success: function (response) {
					var response = JSON.parse(response);
					$('#updateItemsHolder').empty();
					$('#obName strong').text(response.Order.employee_username);
					$('#retailerName strong').text(response.Order.retailer_name);
					$('#orderDate strong').text(response.Order.booking_date);
					$('#orderId strong').text(response.Order.id);
					$('#booking_territory strong').text(response.Order.booking_territory);
					$('#orderTotal').text(response.Order.total_amount);
					totalOrderAm = parseFloat(response.Order.total_amount);
					response.Order.items.forEach(element => {
						if (element.campaign_id != 0) {
							$('#updateItemsHolder').append(
								'<div class="pro_list-update"><button class="btn del-btn removeItemFromOrder" id="' + element.order_content_id +
								'"><i class="fa fa-times"></i></button><div class="pro_img"><img id="imgElem' +
								imgElemCounter + '" src="' +
								element.campaign_thumbnail +
								'" alt="" /></div><div><h3 class="p-name campaignLabel" style="color: gray">-CAMPAIGN-</h3><h3 class="p-name">' +
								element.item_details.item_name +
								'</h3><ul class="up-info-list"><li><label class="control-label mb-10">Unit</label><select class="form-control unitsInContentsDD" style="height: 30px" name="units' +
								imgElemCounter +
								'" data-style="form-control btn-default btn-outline"></select></li><li><label class="control-label mb-10">Discount (%)</label><input type="text" value="' +
								element.booker_discount +
								'" id="bookerDiscountToAdd" class="form-control" placeholder="5%" disabled="disabled"></li><li><label class="control-label mb-10">Qty</label><input type="number" value="' +
								element.item_quantity_booker +
								'" name="quantity" class="form-control" disabled="disabled"/></li><li style="display:none"><label class="control-label mb-10">Campaign</label><input type="text" id="" class="form-control -wselect" placeholder="use select2"></li><li style="display:none"><label class="control-label mb-10">Campaign Qty</label><input type="number" name="quantity" class="form-control"></li></ul><input value="' +
								element.item_details.pref_id + '" class="prefIdForThisRow" hidden /><input value="' +
								element.item_details.item_id +
								'" class="itemIdForThisRow" hidden /><input value="' + element.final_price +
								'" class="priceForThisUnit" hidden /><input value="' +
								element.order_content_id + '" class="contentIdForThisRow" hidden /><input value="' + element.campaign_id +
								'" class="campaign_id" hidden /><div class="-amont-pr">Rs: ' +
								element.final_price + '</div></div></div>');
							imageExist(element.campaign_thumbnail, imgElemCounter, element.item_details.pref_id);
							element.units_available.forEach(unitsElem => {
								if (unitsElem['unit_id'] == element.item_details.unit_id) {
									$('[name="units' + imgElemCounter + '"]').append('<option value="' + unitsElem['unit_id'] +
										'" selected>' +
										unitsElem['unit_name'] + '</option>');
								}
								unitProps.push({
									id: unitsElem['unit_id'],
									pref_id: element.item_details.pref_id,
									name: unitsElem['unit_name'],
									price: unitsElem['unit_price_for_this_item']
								});
							});
						} else {
							$('#updateItemsHolder').append(
								'<div class="pro_list-update"><button class="btn del-btn removeItemFromOrder" id="' + element.order_content_id +
								'"><i class="fa fa-times"></i></button><div class="pro_img"><img id="imgElem' +
								imgElemCounter + '" src="' +
								element.item_details.item_thumbnail + '" alt="" /></div><div><h3 class="p-name">' + element.item_details
								.item_name +
								'</h3><ul class="up-info-list"><li><label class="control-label mb-10">Unit</label><select class="form-control unitsInContentsDD" style="height: 30px" name="units' +
								imgElemCounter +
								'" data-style="form-control btn-default btn-outline"></select></li><li><label class="control-label mb-10">Discount (%)</label><input type="text" value="' +
								element.booker_discount +
								'" id="bookerDiscountToAdd" class="form-control" placeholder="5%"></li><li><label class="control-label mb-10">Qty</label><input type="number" value="' +
								element.item_quantity_booker +
								'" name="quantity" class="form-control"></li><li style="display:none"><label class="control-label mb-10">Campaign</label><input type="text" id="" class="form-control -wselect" placeholder="use select2"></li><li style="display:none"><label class="control-label mb-10">Campaign Qty</label><input type="number" name="quantity" class="form-control"></li></ul><input value="' +
								element.item_details.pref_id + '" class="prefIdForThisRow" hidden /><input value="' +
								element.order_content_id + '" class="contentIdForThisRow" hidden /><input value="' +
								element.item_details.item_id +
								'" class="itemIdForThisRow" hidden /><input value="' + element.item_details.after_discount +
								'" class="priceForThisUnit" hidden /><div class="-amont-pr">Rs: ' +
								element.final_price + '</div></div></div>');
							imageExist(element.item_details.item_thumbnail, imgElemCounter, element.item_details.pref_id);
							element.units_available.forEach(unitsElem => {
								if (unitsElem['unit_id'] == element.item_details.unit_id) {
									$('[name="units' + imgElemCounter + '"]').append('<option value="' + unitsElem['unit_id'] +
										'" selected>' +
										unitsElem['unit_name'] + '</option>');
								} else {
									$('[name="units' + imgElemCounter + '"]').append('<option value="' + unitsElem['unit_id'] + '" >' +
										unitsElem['unit_name'] + '</option>');
								}
								unitProps.push({
									id: unitsElem['unit_id'],
									pref_id: element.item_details.pref_id,
									name: unitsElem['unit_name'],
									price: unitsElem['unit_price_for_this_item']
								});
							});
						}

						imgElemCounter++;
					});
				}
			});
		});

		$(document).on('input', '#bookerDiscountToAdd', function () {
			var disc = parseFloat($(this).val());
			if (!disc) {
				disc = 0;
				$(this).val("0");
			}
			if (disc > 100) {
				disc = 100;
				$(this).val("100");
			}
			var origPrice = parseFloat($(this).parent().parent().parent().find('.priceForThisUnit').val()) * parseInt($(this)
				.parent().parent().find('li:eq(2) [name="quantity"]').val());
			if ($(this).parent().parent().parent().find('.campaignLabel').length) {
				origPrice = parseFloat($(this).parent().parent().parent().find('.priceForThisUnit').val());
			}
			var discount = (disc / 100) * origPrice;
			var discountedPrice = Math.round(origPrice - discount);
			$(this).parent().parent().parent().find('.-amont-pr').text('Rs: ' + discountedPrice);
			totalOrderAm = 0;
			$('.pro_list-update').each(function () {
				totalOrderAm += parseFloat($(this).find('.-amont-pr').text().split(" ")[1]);
			});
			$('#orderTotal').text(totalOrderAm);
		});

		var campaignOldQuant = 0;

		$(document).on('keydown', '[name="quantity"]', function () {
			campaignOldQuant = parseInt($(this).val());
		});

		$(document).on('input', '[name="quantity"]', function () {
			var quant = parseInt($(this).val());
			if ($(this).parent().parent().parent().find('.campaignLabel').length) {
				quant = campaignOldQuant;
				$(this).val(campaignOldQuant);
			}
			if (!quant) {
				quant = 0;
				$(this).val("0");
			}
			var origPrice = parseFloat($(this).parent().parent().parent().find('.priceForThisUnit').val()) * quant;
			if ($(this).parent().parent().parent().find('.campaignLabel').length) {
				origPrice = parseFloat($(this).parent().parent().parent().find('.priceForThisUnit').val());
			}
			var discount = (parseInt($(this).parent().parent().find('li:eq(1) #bookerDiscountToAdd').val()) / 100) *
				origPrice;
			var discountedPrice = Math.round(origPrice - discount);

			$(this).parent().parent().parent().find('.-amont-pr').text('Rs: ' + discountedPrice);
			totalOrderAm = 0;
			$('.pro_list-update').each(function () {
				totalOrderAm += parseFloat($(this).find('.-amont-pr').text().split(" ")[1]);
			});
			$('#orderTotal').text(totalOrderAm);
		});

		$(document).on('change', '#unit_id_dd', function () {
			$('#quantityForNewItem').val(0);
			$('#discountForNewItem').val(0);
			$('#newProductAmount').text(0);
			var unitSelected = selectedProductPropsForNewItem.find(function (item) {
				return item.unit_id == $('#unit_id_dd').val()
			});

			if (unitSelected.campaign) {
				$('#campaignAvailableAlert').fadeIn();
				$('#minimumQuant').text(unitSelected.campaign.item_quantity);
				$('#totalPrice').text(unitSelected.campaign.final_price);
			} else {
				$('#campaignAvailableAlert').hide();
			}
			$('#newProductPrefId').val(unitSelected.pref_id);
		});

		$(document).on('input', '#quantityForNewItem', function () {
			var quant = parseInt($(this).val());
			if (!quant) {
				quant = 0;
				$(this).val("0");
			}

			var unitIdSelected = $('#unit_id_dd').val();
			var unitProps = selectedProductPropsForNewItem.find(function (item) {
				return item.unit_id == unitIdSelected
			});
			var origPrice = unitProps.after_discount * quant;
			priceForThisUnit = unitProps.after_discount;
			var discount = ((parseFloat($('#discountForNewItem').val()) / 100) *
					origPrice) ? (parseFloat($('#discountForNewItem').val()) / 100) *
				origPrice : 0;
			var discountedPrice = Math.round(origPrice - discount);
			$('#newProductAmount').text(discountedPrice);
		});

		$(document).on('input', '#discountForNewItem', function () {
			var quant = parseInt($('#quantityForNewItem').val());
			if (!quant) {
				quant = 0;
				$(this).val("0");
			}
			if (parseFloat($(this).val()) > 100) {
				$(this).val(100);
			}

			var unitIdSelected = $('#unit_id_dd').val();
			var unitProps = selectedProductPropsForNewItem.find(function (item) {
				return item.unit_id == unitIdSelected
			});
			var origPrice = unitProps.after_discount * quant;
			priceForThisUnit = unitProps.after_discount;
			var discount = ((parseFloat($('#discountForNewItem').val()) / 100) *
					origPrice) ? (parseFloat($('#discountForNewItem').val()) / 100) *
				origPrice : 0;
			var discountedPrice = Math.round(origPrice - discount);
			$('#newProductAmount').text(discountedPrice);
		});

		$(document).on('click', '.removeItemFromOrder', function () {
			if ($('.pro_list-update').length == 1) {
				alert('You cannot save an empty order');
				return;
			}
			var id = $(this).attr("id");
			if ($(this).parent().find('.contentIdForThisRow').length) {
				itemsRemovedFromOrder.push(id);
			}
			totalOrderAm -= parseFloat($(this).parent().find('.-amont-pr').text().split(" ")[1]);
			$('#orderTotal').text(totalOrderAm);
			var thisParRef = $(this);
			$(this).parent().fadeOut('fast');
			setTimeout(() => {
				thisParRef.parent().remove();
			}, 100);
		});

		$(document).on('change', '#item_id', function () {
			getUnitsForCurrentitem(orderId);
		});

		$(document).on('click', '#saveUpdatedOrder', function () {
			var existingContents = [];
			var newContents = [];
			$('.pro_list-update').each(function () {
				var tempData = [];
				if ($(this).find('.contentIdForThisRow').length) {
					//Find the pref_id where item-id and unit_id is this
					existingContents.push({
						content_id: $(this).find('.contentIdForThisRow').val(),
						item_id: $(this).find('.itemIdForThisRow').val(),
						unit_id: $(this).find('li:eq(0) select').val(),
						final_price: $(this).find('.-amont-pr').text().split(" ")[1],
						booker_discount: $(this).find('#bookerDiscountToAdd').val(),
						booker_quantity: $(this).find('[name="quantity"]').val(),
						campaign_id: ($(this).find('[class="campaign_id"]').length ? $(this).find('[class="campaign_id"]').val() :
							0)
					});
				} else {
					newContents.push({
						item_id: $(this).find('.itemIdForThisRow').val(),
						unit_id: $(this).find('li:eq(0) select').val(),
						final_price: $(this).find('.-amont-pr').text().split(" ")[1],
						booker_discount: $(this).find('#bookerDiscountToAdd').val(),
						booker_quantity: $(this).find('[name="quantity"]').val(),
						order_id: orderId,
						campaign_id: ($(this).find('[class="campaign_id"]').length ? $(this).find('[class="campaign_id"]').val() :
							0)
					});
				}
			});

			if (!existingContents.length && !newContents.length) {
				alert('You cannot save an empty order');
				return;
			}

			var thisRef = $(this);
			thisRef.attr('disabled', 'disabled');
			$.ajax({
				type: 'POST',
				url: '/PrimaryOrders/CommitOrderChanges',
				data: {
					removed: itemsRemovedFromOrder.join(","),
					existing: existingContents,
					new: newContents
				},
				success: function (response) {
					thisRef.text("Order Saved");
					setTimeout(() => {
						thisRef.removeAttr('disabled');
						thisRef.text("Save");
						$('.close-btn-pl').click();
					}, 800);
				}
			});
		});

		$(document).on('click', '.cancelOrder', function () {
			var id = $(this).parent().attr("id");
			var thisRef = $(this);
			$.ajax({
				url: "/PrimaryOrders/UpdateOrderStatus/" + id + "/cancelled",
				success: function (response) {
					if (response === "success") {
						thisRef.parent().parent().parent().fadeOut();
					} else {
						alert("Unable to update order status");
					}
				}
			})
		});

		$(document).on('click', '.processOrder', function () {
			var id = $(this).parent().attr("id");
			var thisRef = $(this);
			$.ajax({
				url: "/PrimaryOrders/UpdateOrderStatus/" + id + "/processed",
				success: function (response) {
					if (response === "success") {
						thisRef.parent().parent().parent().fadeOut();
					} else {
						alert("Unable to update order status");
					}
				}
			})
		});

		$(document).on('click', '.completeOrder', function () {
			var id = $(this).parent().attr("id");
			var thisRef = $(this);
			$.ajax({
				url: "/PrimaryOrders/UpdateOrderStatus/" + id + "/completed",
				success: function (response) {
					if (response === "success") {
						thisRef.parent().parent().parent().fadeOut();
					} else {
						alert("Unable to update order status");
					}
				}
			})
		});

		$(document).on('click', '#viewDetail', function () {
			var lats = $(this).parent().find('#empLats').val();
			var longs = $(this).parent().find('#empLongs').val();
			var baseLats = $(this).parent().find('#retailerLats').val();
			var baseLongs = $(this).parent().find('#retailerLongs').val();
			$('#myModal').modal('show');
			initMap(lats, longs, baseLats, baseLongs, $('#greenIconUrl').val(), $('#redIconUrl').val());
		});
	});

	function getUnitsForCurrentitem(orderId) {
		$('#quantityForNewItem').val(0);
		$('#discountForNewItem').val(0);
		$('#newProductAmount').text(0);
		$('#unit_id_dd').empty();
		$('#unit_id_dd').append('<option value="-1">Loading Units..</option>');
		$.ajax({
			type: 'GET',
			url: '/PrimaryOrders/GetUnits/' + $('#item_id').val() + '/' + orderId,
			success: function (response) {
				selectedProductPropsForNewItem = JSON.parse(response);
				$('#unit_id_dd').empty();
				JSON.parse(response).forEach(element => {
					$('#unit_id_dd').append('<option value="' + element['unit_id'] + '">' + element['unit_name'] + '</option>');
				});
				var unitSelected = selectedProductPropsForNewItem.find(function (item) {
					return item.unit_id == $('#unit_id_dd').val()
				});
				if (unitSelected.campaign) {
					$('#campaignAvailableAlert').fadeIn();
					$('#minimumQuant').text(unitSelected.campaign.item_quantity);
					$('#totalPrice').text(unitSelected.campaign.final_price);
				} else {
					$('#campaignAvailableAlert').hide();
				}
				$('#newProductPrefId').val(unitSelected.pref_id);
			}
		});
	}

	function imageExist(imgSrc, elemCounter, prefId) {
		$.get(imgSrc)
			.done(function () {
				var recordFound = imagesLooped.find(function (item) {
					return item.src == imgSrc && item.pref == prefId
				});

				if (!recordFound) {
					imagesLooped.push({
						src: imgSrc,
						pref: prefId
					});
					elemCounter++;
				}
			}).fail(function () {
				var recordFound = imagesLooped.find(function (item) {
					return item.src == imgSrc && item.pref == prefId
				});

				if (!recordFound) {
					imagesLooped.push({
						src: imgSrc,
						pref: prefId
					});
					$('#imgElem' + elemCounter).attr('src', '/assets/images/no-product-image.jpg');
					elemCounter++;
				}
			}).error(function () {
				var recordFound = imagesLooped.find(function (item) {
					return item.src == imgSrc && item.pref == prefId
				});

				if (!recordFound) {
					imagesLooped.push({
						src: imgSrc,
						pref: prefId
					});
					$('#imgElem' + elemCounter).attr('src', '/assets/images/no-product-image.jpg');
					elemCounter++;
				}
			});
	}

	function initMap(lats, longs, baseLats, baseLongs, greenIcon, redIcon) {
		var uluru = {
			lat: parseFloat(lats),
			lng: parseFloat(longs)
		};
		var map = new google.maps.Map(document.getElementById('map'), {
			zoom: 18,
			center: uluru
		});

		for (var i = 0; i < 2; i++) {
			if (i == 0) {
				marker = new google.maps.Marker({
					position: new google.maps.LatLng(lats, longs),
					title: "Order Location",
					map: map,
					animation: google.maps.Animation.DROP,
					icon: redIcon
				});

				google.maps.event.addListener(marker, 'click', function (e) {
					infowindow.setContent(this.name);
					infowindow.open(map, this);
				}.bind(marker));
			} else {
				marker = new google.maps.Marker({
					position: new google.maps.LatLng(baseLats, baseLongs),
					title: "Distributor Location",
					map: map,
					animation: google.maps.Animation.DROP,
					icon: greenIcon
				});

				google.maps.event.addListener(marker, 'click', function (e) {
					infowindow.setContent(this.name);
					infowindow.open(map, this);
				}.bind(marker));
			}
		}

	}

</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAap-vz0Ju0d3oO8eAhdwFfIvjaautw-eU">


</script>
