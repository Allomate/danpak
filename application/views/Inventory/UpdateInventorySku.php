<?php require_once(APPPATH.'/views/includes/header.php'); ?>
<style type="text/css">
.deleteImages:hover{
	opacity: 1.0 !important
}
</style>
<link href="<?= base_url('assets/vendors/bower_components/dropzone/dist/dropzone.css'); ?>" rel="stylesheet" type="text/css"/>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once(APPPATH.'/views/includes/navbar&sidebar.php'); ?>
	<div class="page-wrapper">
		<div class="container">
			<div class="row heading-bg">
				<div class="col-lg-6 col-md-6">
					<h2 class="m-heading">Product Detail</h2>
				</div>
				<div class="col-lg-6 col-md-6">
					<ol class="breadcrumb">
						<li><a href="#"><span>Product Management</span></a></li>
						<li><span>Product Detail</span></li> 
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12"> 
					<div class="box-white m-b-30">
						<div class="row">
							<div class="col-md-4">
								<div class="item-big">
									<div id="carousel-example-captions-1" data-ride="carousel" class="carousel slide">
										<ol class="carousel-indicators">
											<?php $totalImages = explode(",", $GetMainDetails->item_image);
											for ($i=0; $i < sizeof($totalImages); $i++) : ?>
											<?php if ($i == 0) :?>
												<li data-target="#carousel-example-captions-1" data-slide-to="<?= $i; ?>" class="active"></li>
											<?php else: ?>
												<li data-target="#carousel-example-captions-1" data-slide-to="<?= $i; ?>"></li>
											<?php endif;?>
										<?php endfor; ?>
									</ol>
									<div role="listbox" class="carousel-inner">
										<?php for ($i=0; $i < sizeof($totalImages); $i++) : ?>
											<?php if ($i == 0) :?>
												<div class="item active"> <img src="<?= $totalImages[$i]; ?>" alt="First slide image"> </div>
											<?php else: ?>
												<div class="item"> <img src="<?= $totalImages[$i]; ?>" alt="First slide image"> </div>
											<?php endif;?>
										<?php endfor; ?>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-8">		 
							<h3><?= $GetMainDetails->item_name;?></h3>
							<p class="font-18"><strong>SKU:</strong> <?= $GetMainDetails->item_sku; ?></p>
							<p  class="font-18"><strong>Main Category: </strong> <?= $GetMainDetails->main_category; ?></p>
							<p  class="font-18"><strong>Sub Category: </strong> <?= $GetMainDetails->sub_category; ?></p>
							<h3 class="m-t-10">Description</h3>
							<p class="font-15"><?= $GetMainDetails->item_main_description; ?></p>
						</div>
					</div>
					<div class="clearfix"></div>	
					<h2 class="m-0 m-t-30">Packaging</h2>
					<div class="table-wrap">
						<div class="table-responsive">
							<table class="table table-hover display pb-30" >
								<thead>
									<tr>
										<th>Item Barcode</th>
										<th>Unit Name</th>
										<th>Quantity</th>
										<th>Retail Price</th>
										<th>Trade Price</th>
										<th>Cost Price</th>
										<th>Category</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th>Item Barcode</th>
										<th>Unit Name</th>
										<th>Quantity</th>
										<th>Retail Price</th>
										<th>Trade Price</th>
										<th>Cost Price</th>
										<th>Category</th>
										<th>Actions</th>
									</tr>
								</tfoot>
								<tbody>
									<?php foreach ($SkuInventory as $inventory) : ?>
										<tr>
											<td><?= $inventory->item_barcode ? $inventory->item_barcode : 'NA'; ?></td>
											<td><?= $inventory->unit_name; ?></td>
											<td><?= $inventory->item_quantity; ?></td>
											<td><?= 'Rs.' . $inventory->item_retail_price; ?></td>
											<td><?= 'Rs.' . $inventory->item_trade_price; ?></td>
											<td><?= 'Rs.' . $inventory->item_warehouse_price; ?></td>
											<td><?= $inventory->sub_category_name; ?></td>
											<td style="text-align: center">
												<a href="<?= base_url('Inventory/UpdateInventory/'.$inventory->pref_id); ?>"><i class="fa fa-pencil"></i></a>
												<a class="deleteConfirmation" href="<?= base_url('Inventory/DeleteInventory/'.$inventory->pref_id); ?>"><i class="fa fa-close"></i></a>
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
<script src="<?= base_url('assets/vendors/bower_components/dropzone/dist/dropzone.js');?>"></script>
<script src="<?= base_url('assets/dist/js/dropzone-data.js')?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/UpdateInventory.js').'?v='.time(); ?>"></script>