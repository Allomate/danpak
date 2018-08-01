<?php require_once(APPPATH.'/views/includes/header.php'); ?>
<div class="wrapper theme-1-active">
	<?php require_once(APPPATH.'/views/includes/navbar&sidebar.php'); ?>
	<div class="page-wrapper">
		<div class="container">
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
				<div class="col-md-12 BS_div">
					<div class="box-white p-20">
						<div class="invoice-logo m-b-5">
							<img class="float-L" src="<?= base_url('assets/images/logo.jpg'); ?>" alt="" />
							<h3 class="font-20 float-R">Booking Sheet</h3>
							<hr class="clearfix m-b-10">
						</div>
						<div class="form-wrap order-detail">
							<form action="#">
								<div class="form-body">
									<div class="row">
										<div class="float-L m-l-15">
											Date:
											<strong>
												<?= $this->uri->segment(4); ?>
											</strong>
											<br> Total Outlets:
											<strong>
												<?= sizeOf($details["results"]); ?>
											</strong>
											<br> Total Amount:
											<strong>
												<?= number_format($details["totalAmount"]); ?>
											</strong>
										</div>
										<div class="float-R m-r-15">
											Order Booker
											<strong>
												<?= $details["results"][0]["main_order"]->employee_username; ?>
											</strong>
											<br> Territory:
											<strong>
												<?= $details["results"][0]["main_order"]->territory; ?>
											</strong>
											<!-- <br> Distributor:
											<strong>Lala Khan</strong> -->
										</div>
									</div>
									<h4 class="font-20" align="center">Outlets Information</h4>

									<div>
										<div class="invoice-bill-table">
											<div class="table-responsive">
												<table class="table table-hover">
													<thead>
														<tr>
															<th>SN</th>
															<th>Retailer</th>
															<th>Address</th>
															<th>Phone</th>
															<th>Product</th>
															<th>Unit</th>
															<th>TP</th>
															<th>DIS %</th>
															<th>Total</th>
															<th>Status</th>
														</tr>
													</thead>
													<tbody>
														<?php $sno = 1; foreach($details["results"] as $orders) : ?>
														<tr>
															<td style="padding: 5px; text-align: center" rowspan="<?= sizeOf($orders['order_contents'])+2; ?>">
																<?= $sno; ?>
															</td>
															<td style="padding: 5px" rowspan="<?= sizeOf($orders['order_contents'])+2; ?>">
																<?= $orders["main_order"]->retailer_name; ?>
															</td>
															<td style="padding: 5px" rowspan="<?= sizeOf($orders['order_contents'])+2; ?>">
																<?= $orders["main_order"]->retailer_address; ?>
															</td>
															<td style="padding: 5px" rowspan="<?= sizeOf($orders['order_contents'])+2; ?>">
																<?= $orders["main_order"]->retailer_phone; ?>
															</td>
														</tr>
														<?php $subTotal = 0; foreach($orders['order_contents'] as $contents): ?>
														<tr>
															<td style="padding: 5px">
																<?= $contents->product;?>
															</td>
															<td style="padding: 5px">
																<?= $contents->unit_type;?>
															</td>
															<td style="padding: 5px">
																<?= number_format($contents->trade_price);?>
															</td>
															<td style="padding: 5px">
																<?= $contents->booker_discount;?>
															</td>
															<td style="padding: 5px">
																<?= number_format($contents->amount);?>
															</td>
															<td style="padding: 5px">
																<?= $contents->status ? $contents->status : "Pending";?>
															</td>
														</tr>
														<?php $subTotal += $contents->amount; endforeach; ?>
														<tr>
															<td style="padding: 5px; font-weight: bolder; text-align: center" colspan="4">Total Order Amount</td>
															<td style="padding: 5px; font-weight: bolder">
																<?= number_format($subTotal); ?>
															</td>
															<td style="padding: 5px"></td>
														</tr>
														<?php $sno++; endforeach; ?>
													</tbody>
													<!-- <tfoot>
														<tr class="txt-dark">
															<td></td>
															<td>Subtotal</td>
															<td>
																<?= number_format($subTotal); ?>
															</td>
															<td>-
																<?= $discTotal; ?>%</td>
															<td></td>
															<td></td>
															<td></td>
														</tr>
														<tr class="txt-dark">
															<td></td>
															<td></td>
															<td></td>
															<td></td>
															<td>Total</td>
															<td>Rs:
																<?= number_format($orderTotal); ?>
															</td>
															<td></td>
														</tr>
													</tfoot> -->
												</table>
											</div>
											<div class="clearfix"></div>
										</div>
									</div>

									<div class="button-list pull-right">
										<div class="seprator-block"></div>
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
							</form>
						</div>
					</div>
				</div>
				<!-- /Row -->
			</div>
			<!-- Footer -->
		</div>
	</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script src="<?= base_url('assets/js/jquery.printElement.min.js'); ?>" />
