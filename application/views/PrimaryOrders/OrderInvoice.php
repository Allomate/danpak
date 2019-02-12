<?php require_once(APPPATH.'/views/includes/header.php'); ?>
<style type="text/css">
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
			<div class="row heading-bg">
				<div class="col-lg-6 col-md-6">
					<h2 class="m-heading">Invoice</h2>
				</div>
				<div class="col-lg-6 col-md-6">
					<ol class="breadcrumb">
						<li>
							<a href="#">
								<span>Order Management</span>
							</a>
						</li>
						<li>
							<span>Invoice</span>
						</li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="box-white p-20">
						<div class="invoice-logo">
							<img src="<?= base_url('assets/images/allomate-logo.png'); ?>" alt="" />
						</div>
						<h2>Order Detail
							<span class="float-R">Order #
								<?= $OrderInvoice->order_number;?>
							</span>
						</h2>
						<div class="form-wrap order-detail">
							<form action="#">
								<div class="form-body">
									<div class="row">
										<div class="col-md-6">
											Distributor Name:
											<strong>
												<?= $OrderInvoice->distributor_name; ?>
											</strong>
											<br> Phone NO:
											<strong>
												<?= $OrderInvoice->retailer_phone; ?>
											</strong>
											<br>
										</div>
										<div class="col-md-6 text-right">
											Status:
											<strong>
												<?= $OrderInvoice->status; ?>
											</strong>
											<br> Booking Date:
											<strong>
												<?= $OrderInvoice->order_date; ?>
											</strong>
											<br> Employee Name:
											<strong>
												<?= $OrderInvoice->employee_name; ?>
											</strong>
										</div>
									</div>
									<div class="seprator-block"></div>
									<div class="invoice-bill-table">
										<div class="table-responsive">
											<table class="table table-hover">
												<thead>
													<tr>
														<th>Item</th>
														<th>Unit Type</th>
														<th>Unit Price</th>
														<th>Quantity</th>
														<th>Individual Discount</th>
														<th>Campaign Used</th>
														<th>Totals</th>
													</tr>
												</thead>
												<tbody>
													<?php $totalOrderWorth = 0; foreach($OrderInvoice->items as $details) : ?>
													<tr>
														<td>
															<?= $details['item_details']->item_sku; ?>
														</td>
														<td>
															<?= $details['item_details']->unit_name; ?>
														</td>
														<td>
															<?= $details['item_details']->after_discount; ?>
														</td>
														<td>
															<?= $details["item_quantity_booker"]; ?>
														</td>
														<td>
															<?= $details["booker_discount"]."%"; ?>
														</td>
														<td>
															<?= $details["campaign_used"] ? "Yes" : "No"; ?>
														</td>
														<td>
															<?= $details["final_price"]; ?>
														</td>
													</tr>
													<?php $totalOrderWorth += $details["final_price"]; endforeach;?>
												</tbody>
												<tfoot>
													<tr class="txt-dark">
														<td></td>
														<td></td>
														<td></td>
														<td></td>
														<td></td>
														<td>Total</td>
														<td>Rs:
															<?= $totalOrderWorth; ?>
														</td>
													</tr>
												</tfoot>
											</table>
										</div>
										<div class="button-list pull-right">
											<button type="button" class="btn btn-primary btn-outline btn-icon left-icon" onclick="#">
												<i class="fa fa-file-pdf-o"></i>
												<span> Save PDF</span>
											</button>
											<button type="button" class="btn btn-primary btn-outline btn-icon left-icon" onclick="#">
												<i class="fa fa-envelope"></i>
												<span> Send Email</span>
											</button>
											<button type="button" class="btn btn-primary btn-outline btn-icon left-icon" onclick="javascript:window.print();">
												<i class="fa fa-print"></i>
												<span> Print</span>
											</button>
										</div>
										<div class="clearfix"></div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
