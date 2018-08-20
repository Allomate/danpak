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
								<a href="<?= base_url('Orders/ProcessAll/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'); ?>">
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
								<a href="<?= base_url('Orders/CompleteAll/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'); ?>">
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
												<a href="<?= base_url('Orders/UpdateOrder/'.$order->id); ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
													<i class="fa fa-pencil"></i>
												</a>
												<a href="<?= base_url('Orders/OrderInvoice/'.$order->id); ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Invoice">
													<i class="fa fa-list-alt"></i>
												</a>
												<a href="<?= base_url('Orders/CancelOrder/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$order->id); ?>"
												data-toggle="tooltip" data-placement="top" title="" data-original-title="Cancel">
													<i class="fa fa-close"></i>
												</a>
												<a href="<?= base_url('Orders/CompleteOrder/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$order->id); ?>">
													<button class="btn view-report">Complete</button>
												</a>
												<?php elseif (!$order->status || $order->status == '') : ?>
												<a href="<?= base_url('Orders/UpdateOrder/'.$order->id); ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
													<i class="fa fa-pencil"></i>
												</a>
												<a href="<?= base_url('Orders/OrderInvoice/'.$order->id); ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Invoice">
													<i class="fa fa-list-alt"></i>
												</a>
												<a href="<?= base_url('Orders/CancelOrder/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$order->id); ?>"
												data-toggle="tooltip" data-placement="top" title="" data-original-title="Cancel">
													<i class="fa fa-close"></i>
												</a>
												<a href="<?= base_url('Orders/ProcessOrder/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$order->id); ?>">
													<button class="btn view-report">Process</button>
												</a>
												<?php else: ?>
												<a href="<?= base_url('Orders/OrderInvoice/'.$order->id); ?>">
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
	$(document).ready(function () {
		$(document).on('click', '#viewDetail', function () {
			var lats = $(this).parent().find('#empLats').val();
			var longs = $(this).parent().find('#empLongs').val();
			var baseLats = $(this).parent().find('#retailerLats').val();
			var baseLongs = $(this).parent().find('#retailerLongs').val();
			$('#myModal').modal('show');
			initMap(lats, longs, baseLats, baseLongs, $('#greenIconUrl').val(), $('#redIconUrl').val());
		});
	});

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
