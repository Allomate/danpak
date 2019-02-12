<?php require_once(APPPATH.'/views/includes/header.php'); ?>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once(APPPATH.'/views/includes/navbar&sidebar.php'); ?>
	<!-- Right Sidebar Menu -->
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
				<?php 
				$attributes = array('id' => 'updateOrderForm');
				echo form_open('Orders/UpdateOrderOps/'.$Order->id, $attributes);
				echo form_hidden('items_deleted', '');
				echo form_hidden('existing_items', '');
				echo form_hidden('existing_quantities', '');?>
				<div class="col-md-12">
					<div class="box-white p-20">
						<h2 class="m-b-0">Stock Order </h2>
						<div class="table-wrap">
							<div class="table-responsive">
								<table class="table table-hover display stockOrderTable pb-30">
									<thead>
										<tr>
											<th>Sku</th>
											<th>Item</th>
											<th>Unit Type</th>
											<th>Unit Price</th>
											<th>Quantity</th>
											<th>Quantity Available</th>
											<th>Individual Discount</th>
											<th>Sub-Total</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>
												<a href="<?= base_url('Orders/ListOrders'); ?>" type="button" class="btn btn-cancel">Cancel</a>
											</th>
											<th>Item</th>
											<th>Unit Type</th>
											<th>Unit Price</th>
											<th>Quantity</th>
											<th>Quantity Available</th>
											<th>Individual Discount</th>
											<th>Sub-Total</th>
											<th style="text-align: center;">
												<button class="btn btn-success updateStockQuantityBtn" type="button">UPDATE</button>
											</th>
										</tr>
									</tfoot>
									<tbody>
										<?php foreach ($Order->items as $item) : ?>
										<tr>
											<td>
												<?= $item['item_details']->item_sku; ?>
											</td>
											<td>
												<?= $item['item_details']->item_name; ?>
											</td>
											<td>
												<?= $item['item_details']->unit_name; ?>
											</td>
											<td>
												<?= $item['item_details']->after_discount; ?>
											</td>
											<td>
												<input type="text" name="item_quantity_booker_existing_stocked" value="<?= $item['item_quantity_booker']; ?>"
												 hidden>
												<input class="form-control form-control-sm" name="item_quantity_booker_existing" type="number" placeholder="Quantity"
												 min="1" id="iqmasdas" value="<?= $item['item_quantity_booker']; ?>">
												<input name="item_id_existing" type="number" value="<?= $item['item_details']->pref_id; ?>" hidden>
											</td>
											<td>
												<?= $item['item_details']->item_quantity; ?>
											</td>
											<td>
												<?= $item['booker_discount'] ? $item['booker_discount'].'%' : 'No Discount'; ?>
											</td>
											<td>
												<?= $item['final_price']; ?>
											</td>
											<td>
												<a class="removeItemFromStockOrderBtn" id="<?= $item['order_content_id']; ?>">
													<i class="fa fa-close"></i>
												</a>
											</td>
										</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				</form>
			</div>
			<div class="row" style="margin-top: 20px">
				<?php 
			$attributes = array('id' => 'expandOrderForm');
			echo form_open('Orders/ExpandOrderOps/'.$Order->id, $attributes);
			echo form_hidden('item_quantities_expansion', '');
			echo form_hidden('booker_discounts_expansion', '');
			echo form_hidden('item_ids_expansion', '');?>
				<div class="row" id="dynamicInventoryExpansionDiv" style="display: none; padding: 10px">
				</div>
				<div class="col-md-12">
					<div class="box-white p-20">
						<h2 class="m-b-0">Stock Order </h2>
						<div class="table-wrap">
							<div class="table-responsive">
								<table class="table table-hover display inventoryTable pb-30">
									<thead>
										<tr>
											<th>Sku</th>
											<th>Item</th>
											<th>Unit</th>
											<th>Price</th>
											<th>Quantity</th>
											<th>Quantity Available</th>
											<th>Booker Discount</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>
												<a href="<?= base_url('Orders/ListOrders'); ?>" type="button" class="btn btn-cancel">Cancel</a>
											</th>
											<th>Item</th>
											<th>Unit</th>
											<th>Price</th>
											<th>Quantity</th>
											<th>Quantity Available</th>
											<th>Booker Discount</th>
											<th>
												<button type="button" id="expandOrderButton" class="btn btn-primary" style="width: 100%">Expand</button>
											</th>
										</tr>
									</tfoot>
									<tbody>
										<?php foreach ($Inventory as $inventory) : ?>
										<tr>
											<td>
												<?= $inventory->item_sku; ?>
											</td>
											<td>
												<?= $inventory->item_name; ?>
											</td>
											<td>
												<?= $inventory->unit_name; ?>
											</td>
											<td>
												<?= $inventory->after_discount; ?>
											</td>
											<td>
												<input class="form-control form-control-sm" name="item_quantity" type="number" placeholder="Quantity" min="1">
											</td>
											<td>
												<?= $inventory->item_quantity; ?>
											</td>
											<td>
												<input class="form-control form-control-sm" name="booker_discount" type="number" placeholder="Discount" min="0"
												 max="100" style="width: 100%" value="0">
											</td>
											<td>
												<button class="btn btn-sm btn-success addQuantityBtn" type="button" id="<?= $inventory->pref_id;?>">ADD</button>
											</td>
										</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script type="text/javascript" src="<?= base_url('assets/js/Order.js').'?v='.time(); ?>"></script>
