<?php require_once(APPPATH.'/views/includes/header.php'); ?>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
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
							<img src="<?= base_url('assets/images/allomate-logo.png') ?>" alt="" />
						</div>
						<span class="D_C">D.C # 05485</span>
						<h2 class="font-20" align="center">Delivery Challan </h2>
						<div class="form-wrap order-detail">
							<form action="#">
								<div class="form-body">
									<div class="row">
										<div class="float-L m-l-15">
											Booking Date:
											<strong>07/03/2018</strong>
											<br> Territory:
											<strong>Wapda Town\PIA</strong>
										</div>
										<div class="float-R m-r-15">
											Order Booker:
											<strong>Khan Babo</strong>
											<br> Mobile No:
											<strong>03221515151</strong>
										</div>
									</div>
									<div class="seprator-block m-b-40"></div>
									<div class="invoice-bill-table">
										<div class="table-responsive">
											<table class="table table-hover">
												<thead>
													<tr>
														<th>Product</th>
														<th>Unit Type</th>
														<th>Required Stock</th>
														<th>Issue Stock</th>
														<th>Return</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>Boom 60</td>
														<td>Piece</td>
														<td>15</td>
														<td>10</td>
														<td></td>
													</tr>
													<tr>
														<td>Chew Mint</td>
														<td>Catan</td>
														<td>7</td>
														<td>25</td>
														<td></td>
													</tr>
													<tr>
														<td>Coin Jar</td>
														<td>Piece</td>
														<td>4</td>
														<td>10</td>
														<td></td>
													</tr>
													<tr>
														<td>Chew Mint</td>
														<td>Catan</td>
														<td>1</td>
														<td>25</td>
														<td></td>
													</tr>
													<tr>
														<td>Chew Mint</td>
														<td>Catan</td>
														<td>1</td>
														<td>25</td>
														<td></td>
													</tr>
													<tr>
														<td>Chew Mint</td>
														<td>Catan</td>
														<td>1</td>
														<td>25</td>
														<td></td>
													</tr>
													<tr>
														<td>Chew Mint</td>
														<td>Catan</td>
														<td>1</td>
														<td>25</td>
														<td></td>
													</tr>
													<tr>
														<td>Chew Mint</td>
														<td>Catan</td>
														<td>1</td>
														<td>25</td>
														<td></td>
													</tr>
													<tr>
														<td>Chew Mint</td>
														<td>Catan</td>
														<td>1</td>
														<td>25</td>
														<td></td>
													</tr>
												</tbody>
											</table>
										</div>
										<div class="seprator-block"></div>
										<div class="float-R">
											<span class="D_C_line">Issued By</span>
											<span class="D_C_line">Entered By</span>
											<span class="D_C_line">Checked By</span>
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
								</div>
							</form>
						</div>
					</div>
				</div>
				<!-- /Row -->
			</div>
		</div>
	</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script src="<?= base_url('assets/js/jquery.printElement.min.js'); ?>" />
