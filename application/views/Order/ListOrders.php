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
	<div class="page-wrapper">
		<div class="container-fluid">
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
				<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
					<div class="panel panel-default card-view pa-0 emp-stats pr-box">
						<div class="panel-wrapper collapse in">
							<div class="panel-body pa-0">
								<div class="sm-data-box">
									<div class="container-fluid">
										<div class="row">
											<div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
												<span class="txt-dark block counter">
													<?= $Orders["stats"]["Total"]; ?>
												</span>
												<span class="weight-500 uppercase-font block">Total Orders</span>
											</div>
											<div class="col-xs-6 text-center">
												<img src="<?= base_url('assets/images/icon-all-orders.svg'); ?>" alt="brand" />
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
					<div class="panel panel-default card-view pa-0 emp-stats absent-box">
						<div class="panel-wrapper">
							<div class="panel-body pa-0">
								<div class="sm-data-box">
									<div class="container-fluid">
										<div class="row">
											<div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
												<span class="txt-dark block counter">
													<?= $Orders["stats"]["Cancelled"]; ?>
												</span>
												<span class="weight-500 uppercase-font block">Cancel Orders</span>
											</div>
											<div class="col-xs-6 text-center  pl-0 pr-0 ">
												<img src="<?= base_url('assets/images/icon-order-cancelled.svg'); ?>" alt="brand" />
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 ">
					<div class="panel panel-default card-view pa-0 emp-stats blue-box">
						<div class="panel-wrapper collapse in">
							<div class="panel-body pa-0">
								<div class="sm-data-box">
									<div class="container-fluid">
										<div class="row">
											<div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
												<span class="txt-dark block counter">
													<?= $Orders["stats"]["Pending"]; ?>
												</span>
												<span class="weight-500 uppercase-font block font-13">Pending Orders</span>
											</div>
											<div class="col-xs-6 text-center  pl-0 pr-0">
												<img src="<?= base_url('assets/images/icon-order-pending.svg'); ?>" alt="brand" />
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
													<?= $Orders["stats"]["Completed"]; ?>
												</span>
												<span class="weight-500 uppercase-font block font-13">Complete Orders</span>
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
						<h2 class="m-b-0">Orders List (
							<?= $this->uri->segment(3)." Orders"; ?> ) </h2>
						<div class="table-wrap">
							<div class="table-responsive">
								<table class="table table-hover display pb-30">
									<thead>
										<tr>
											<th>Date</th>
											<th>Employee Id</th>
											<th>Employee Name</th>
											<th>Territory</th>
											<th>Total Orders</th>
											<th>Total Price</th>
											<th>Action</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Date</th>
											<th>Employee Id</th>
											<th>Employee Name</th>
											<th>Territory</th>
											<th>Total Orders</th>
											<th>Total Price</th>
											<th>Action</th>
										</tr>
									</tfoot>
									<tbody>
										<?php foreach ($Orders["orderDetails"] as $order) : ?>
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
												<?= $order["territory"]; ?>
											</td>
											<td>
												<?= $order["totalOrders"]; ?>
											</td>
											<td>
												<?= number_format($order["orders_price"]); ?>
											</td>
											<td>
												<a href="<?= base_url('Orders/ListOrdersIndividual/'.$order['employee_id'].'/'.urlencode($order['date']).'/'.$this->uri->segment(3)); ?>">
													<button class="btn view-report">View Orders List</button>
												</a>
												<?php if($this->uri->segment(3) == "Latest" || $this->uri->segment(3) == "Pending") : ?>
												<a href="<?= base_url('Orders/BookingSheet/'.$order['employee_id'].'/'.urlencode($order['date']).'/'.$this->uri->segment(3)); ?>">
													<button class="btn view-report">Load Sheet</button>
												</a>
												<!-- <a href="<?= base_url('Orders/DeliveryChallan/'.$order['employee_id'].'/'.urlencode($order['date']).'/'.$this->uri->segment(3)); ?>">
													<button class="btn view-report">Delivery Challan</button>
												</a> -->
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

		</div>
	</div>
</div>

<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
