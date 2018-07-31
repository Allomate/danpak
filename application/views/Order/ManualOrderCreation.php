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
					<h2 class="m-heading">Orders Management</h2>
				</div>
				<div class="col-lg-6 col-md-6">
					<ol class="breadcrumb">
						<li>
							<a href="#">
								<span>Organization</span>
							</a>
						</li>
						<li>
							<span>Orders Management</span>
						</li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="box-white m-b-30">
						<h2>Create Order</h2>
						<?php $attributes = array('id' => 'createOrderForm');
						echo form_open('Orders/CreateManualOrders', $attributes); 
						echo form_hidden('finalResult', ''); ?>
						<div class="form-wrap">
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label mb-10">Select Date</label>
											<div class='input-group date' id='orderDate'>
												<input type='text' name="custom_order_data" class="form-control r-l-0" />
												<span class="input-group-addon r-l-6">
													<span class="fa fa-calendar"></span>
												</span>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Select Employee</label>
											<select class="selectpicker" name="employee_id" data-style="form-control btn-default btn-outline">
												<?php foreach( $employees as $employee ) : ?>
												<option value="<?= $employee->employee_id; ?>">
													<?= $employee->employee_username; ?>
												</option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label mb-10">Select Item</label>
													<select class="selectpicker" name="item_id" data-style="form-control btn-default btn-outline">
														<?php foreach( $inventorySku as $item ) : ?>
														<option value="<?= $item->item_id; ?>">
															<?= $item->item_name; ?> (
																<?= $item->item_sku; ?> )
														</option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label mb-10">Select Unit</label>
													<select class="form-control" name="pref_id" data-style="form-control btn-default btn-outline">
													</select>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<label class="control-label mb-10">Select Distributor/Retailer</label>
										<select class="form-control" name="distributor_id">
										</select>
									</div>
									<div class="col-md-6">
										<label class="control-label mb-10">Quantity</label>
										<input type="number" name="quantity" class="form-control">
									</div>
								</div>
								<div class="row" style="padding-top: 10px">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Discount (%)</label>
											<input type="number" name="discount" class="form-control">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Visit Status</label>
											<div class="radio-group">
												<input type="radio" name="visit_status" value="1" checked="checked"> Visit marked with no order
												<br>
												<input type="radio" name="visit_status" value="2"> Visit marked with order
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
			<div class="row button-section">
				<a type="button" href="/" class="btn btn-cancel">Cancel</a>
				<a type="button" id="addToCartBtn" class="btn btn-save">Add to cart</a>
				<a type="button" id="createOrderBtn" class="btn btn-save">Save</a>
			</div>
		</div>
		<div class="row" id="totalCartDiv" style="display: none; margin: 50px 20px 20px 20px; background: white">
			<table class="table">
				<thead>
					<tr>
						<th>Date</th>
						<th>Employee</th>
						<th>Item</th>
						<th>Unit</th>
						<th>Distributor</th>
						<th>Quantity</th>
						<th>Discount</th>
						<th>Distributor Discount</th>
						<th>Total Bill</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
	</div>
</div>
<input type="text" value="<?= base_url('Orders/GetUnitsForSku'); ?>" id="getItemsForSku" hidden>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script type="text/javascript" src="<?= base_url('assets/js/Order.js').'?v='.time(); ?>"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
	$(document).ready(function () {
		$('#orderDate').datepicker({
			format: 'yyyy-mm-dd'
		});
	});

</script>
