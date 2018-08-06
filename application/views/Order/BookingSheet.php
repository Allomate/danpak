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
					<div class="box-white p-20" id="printResult" style="display: block; width: auto; height: auto; overflow: visible;">
						<div class="form-wrap order-detail">
							<form action="#">
								<div class="form-body">
									<div class="row">
										<div class="float-L m-l-15" style="font-size: 7pt; font-family: tahoma;">
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
										<div class="float-R m-r-15" style="font-size: 7pt; font-family: tahoma;">
											Order Booker
											<strong>
												<?= $details["results"][0]["main_order"]->employee_username; ?>
											</strong>
											<br> Territory:
											<strong>
												<?= $details["results"][0]["main_order"]->territory; ?>
											</strong>
										</div>
									</div>
									<center>
										<h6 style="font-weight: bolder">Load Sheet</h6>
									</center>
									<div>
										<div class="invoice-bill-table">
											<div class="table-responsive">
												<table class="table table-hover dataTable no-footer table-bordered">
													<thead>
														<tr>
															<th style="font-size: 7pt; font-family: tahoma; padding: 1px !important;">SN</th>
															<th style="font-size: 7pt; font-family: tahoma; padding: 1px !important;">Retailer</th>
															<th style="font-size: 7pt; font-family: tahoma; padding: 1px !important;">Address</th>
															<th style="font-size: 7pt; font-family: tahoma; padding: 1px !important;">Phone</th>
															<th style="font-size: 7pt; font-family: tahoma; padding: 1px !important;">Product</th>
															<th style="font-size: 7pt; font-family: tahoma; padding: 1px !important;">Unit</th>
															<th style="font-size: 7pt; font-family: tahoma; padding: 1px !important;">TP</th>
															<th style="font-size: 7pt; font-family: tahoma; padding: 1px !important;">Scheme</th>
															<th style="font-size: 7pt; font-family: tahoma; padding: 1px !important;">Scheme Amount/Discount</th>
															<th style="font-size: 7pt; font-family: tahoma; padding: 1px !important;">DIS %</th>
															<th style="font-size: 7pt; font-family: tahoma; padding: 1px !important;">Total</th>
															<th style="font-size: 7pt; font-family: tahoma; padding: 1px !important;">Status</th>
														</tr>
													</thead>
													<tbody>
														<?php $sno = 1; foreach($details["results"] as $orders) : ?>
														<tr>
															<td style="font-size: 7pt; font-family: tahoma; padding: 1px !important; padding: 5px; text-align: center" rowspan="<?= sizeOf($orders['order_contents'])+2; ?>">
																<?= $sno; ?>
															</td>
															<td style="font-size: 7pt; font-family: tahoma; padding: 1px !important; padding: 5px" rowspan="<?= sizeOf($orders['order_contents'])+2; ?>">
																<?= $orders["main_order"]->retailer_name; ?>
															</td>
															<td style="font-size: 7pt; font-family: tahoma; padding: 1px !important; padding: 5px" rowspan="<?= sizeOf($orders['order_contents'])+2; ?>">
																<?= $orders["main_order"]->retailer_address; ?>
															</td>
															<td style="font-size: 7pt; font-family: tahoma; padding: 1px !important; padding: 5px" rowspan="<?= sizeOf($orders['order_contents'])+2; ?>">
																<?= $orders["main_order"]->retailer_phone; ?>
															</td>
														</tr>
														<?php $subTotal = 0; foreach($orders['order_contents'] as $contents): ?>
														<tr>
															<td style="font-size: 7pt; font-family: tahoma; padding: 1px !important; padding: 5px">
																<?= $contents->product;?>
															</td>
															<td style="font-size: 7pt; font-family: tahoma; padding: 1px !important; padding: 5px">
																<?= $contents->unit_type;?>
															</td>
															<td style="font-size: 7pt; font-family: tahoma; padding: 1px !important; padding: 5px">
																<?= number_format($contents->trade_price);?>
															</td>
															<td style="font-size: 7pt; font-family: tahoma; padding: 1px !important; padding: 5px">
																<?= $contents->scheme; ?>
															</td>
															<td style="font-size: 7pt; font-family: tahoma; padding: 1px !important; padding: 5px">
																<?= $contents->scheme_amount_or_discount; ?>
															</td>
															<td style="font-size: 7pt; font-family: tahoma; padding: 1px !important; padding: 5px">
																<?= $contents->booker_discount;?>
															</td>
															<td style="font-size: 7pt; font-family: tahoma; padding: 1px !important; padding: 5px">
																<?= number_format($contents->amount);?>
															</td>
															<td style="font-size: 7pt; font-family: tahoma; padding: 1px !important; padding: 5px">
															</td>
														</tr>
														<?php $subTotal += $contents->amount; endforeach; ?>
														<tr>
															<td style="font-size: 7pt; font-family: tahoma; padding: 1px !important; padding: 5px; font-weight: bolder; text-align: center"
															colspan="5">Total Order Amount</td>
															<td style="font-size: 7pt; font-family: tahoma; padding: 1px !important; padding: 5px; font-weight: bolder">
																<?= number_format($subTotal); ?>
															</td>
															<td style="font-size: 7pt; font-family: tahoma; padding: 1px !important; padding: 5px"></td>
														</tr>
														<?php $sno++; endforeach; ?>
													</tbody>
												</table>
												<br>
												<center>
													<h6 style="font-weight: bolder">Delivery Challan</h6>
												</center>
												<table class="table table-hover dataTable no-footer table-bordered">
													<thead>
														<tr>
															<th style="font-size: 7pt; font-family: tahoma; padding: 1px !important;">SN</th>
															<th style="font-size: 7pt; font-family: tahoma; padding: 1px !important;">Product</th>
															<th style="font-size: 7pt; font-family: tahoma; padding: 1px !important;">Unit</th>
															<th style="font-size: 7pt; font-family: tahoma; padding: 1px !important;">Quantity</th>
															<th style="font-size: 7pt; font-family: tahoma; padding: 1px !important;">Return Stock</th>
														</tr>
													</thead>
													<tbody>
														<?php $sno = 0; foreach ($delivChallan["data"] as $data): ?>
														<tr>
															<td style="font-size: 7pt; font-family: tahoma; padding: 1px !important;">
																<?= ++$sno; ?>
															</td>
															<td style="font-size: 7pt; font-family: tahoma; padding: 1px !important;">
																<?=$data->product;?>
															</td>
															<td style="font-size: 7pt; font-family: tahoma; padding: 1px !important;">
																<?=$data->unit;?>
															</td>
															<td style="font-size: 7pt; font-family: tahoma; padding: 1px !important;">
																<?=$data->required_stock;?>
															</td>
															<td style="font-size: 7pt; font-family: tahoma; padding: 1px !important;"></td>
														</tr>
														<?php endforeach;?>
													</tbody>
												</table>
												<div class="seprator-block"></div>
												<div class="float-R">
													<span class="D_C_line">Issued By</span>
													<span class="D_C_line">Entered By</span>
													<span class="D_C_line">Checked By</span>
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
									<div class="clearfix"></div>
								</div>
							</form>
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
						<button type="button" class="btn btn-primary btn-outline btn-icon left-icon" onclick="printDiv();">
							<i class="fa fa-print"></i>
							<span> Print</span>
						</button>
					</div>
				</div>
				<!-- /Row -->
			</div>
			<!-- Footer -->
		</div>
	</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script type="text/javascript">
	function printDiv() {
		var printContents = document.getElementById('printResult').innerHTML;
		var originalContents = document.body.innerHTML;
		document.body.innerHTML = printContents;
		window.print();
		document.body.innerHTML = originalContents;
	}

</script>
<script src="<?= base_url('assets/js/jquery.printElement.min.js'); ?>" />
