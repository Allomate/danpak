<?php require_once(APPPATH.'/views/includes/header.php'); ?>
<style type="text/css">
	.deleteImages:hover {
		opacity: 1.0 !important
	}

</style>
<link href="<?= base_url('assets/vendors/bower_components/dropzone/dist/dropzone.css'); ?>" rel="stylesheet" type="text/css" />
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once(APPPATH.'/views/includes/navbar&sidebar.php'); ?>
	<div class="page-wrapper">
		<div class="container">
			<?php if ($feedback = $this->session->flashdata('inventory_updated')) : ?>
			<div class="row" style="margin-top: 20px;">
				<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
					<strong>Updated</strong>
					<?= $feedback; ?>
				</div>
			</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('inventory_update_failed')) : ?>
			<div class="row" style="margin-top: 20px;">
				<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
					<strong>Failed</strong>
					<?= $feedback; ?>
				</div>
			</div>
			<?php endif; ?>
			<div class="row heading-bg">
				<div class="col-lg-6 col-md-6 col-sm-6">
					<h2 class="m-heading">Product Detail</h2>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6">
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
								<h3 id="namePara">
									<span>
										<?= $GetMainDetails->item_name;?></span>
									<a style="cursor: pointer" class="updateItemName" id="<?= $this->uri->segment(3);?>"><i class="fa fa-pencil"></i></a>
								</h3>

								<p>
									<input style="width: auto; display: none" id="nameInput" type="text" class="form-control" value="<?= $GetMainDetails->item_name; ?>">
									<button class="btn view-report" id="saveSettings" style="display: none">SAVE</button>
									<button class="btn view-report" id="cancelSettings" style="display: none">CANCEL</button>
								</p>
								<br>
								<p class="font-18"><strong>SKU:</strong>
									<span id="skuPara">
										<?= $GetMainDetails->item_sku; ?></span>
									<input style="width: auto; display: none" id="skuInput" type="text" class="form-control" value="<?= $GetMainDetails->item_sku; ?>">
								</p>
								<br>
								<p class="font-18"><strong>Brand:</strong>
									<span id="brandPara">
										<?= $GetMainDetails->item_brand; ?></span>
									<input style="width: auto; display: none" id="brandInput" type="text" class="form-control" value="<?= $GetMainDetails->item_brand; ?>">
								</p>
								<br>
								<p class="font-18"><strong>Main Category: </strong>
									<?= $GetMainDetails->main_category; ?>
								</p>
								<p class="font-18"><strong>Sub Category: </strong>
									<?= $GetMainDetails->sub_category; ?>
								</p>
								<h3 class="m-t-10">Description</h3>
								<p id="discPara" class="font-15">
									<?= $GetMainDetails->item_main_description; ?>
								</p>
								<textarea id="descriptionInput" class="form-control" cols="50" rows="5" style="display: none"><?= $GetMainDetails->item_main_description; ?></textarea>
							</div>
						</div>
						<div class="clearfix"></div>
						<h2 class="m-0 m-t-30">Packaging</h2>
						<div class="table-wrap">
							<div class="table-responsive">
								<table class="table table-hover display pb-30">
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
											<td>
												<?= $inventory->item_barcode ? $inventory->item_barcode : 'NA'; ?>
											</td>
											<td>
												<?= $inventory->unit_name; ?>
											</td>
											<td>
												<?= $inventory->item_quantity; ?>
											</td>
											<td>
												<?= 'Rs.' . $inventory->item_retail_price; ?>
											</td>
											<td>
												<?= 'Rs.' . $inventory->item_trade_price; ?>
											</td>
											<td>
												<?= 'Rs.' . $inventory->item_warehouse_price; ?>
											</td>
											<td>
												<?= $inventory->sub_category_name; ?>
											</td>
											<td style="text-align: center">
												<a href="<?= base_url('Inventory/UpdateInventory/'.$inventory->pref_id).'/'.$this->uri->segment(3); ?>"><i
													 class="fa fa-pencil"></i></a>
												<a class="deleteConfirmation" href="<?= base_url('Inventory/DeleteInventory/'.$inventory->pref_id); ?>"><i
													 class="fa fa-close"></i></a>
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
<script>
	$(document).ready(function () {
		$('.updateItemName').click(function () {
			$(this).hide();
			$('#saveSettings').show();
			$('#cancelSettings').show();
			$('#namePara').hide();
			$('#skuPara').hide();
			$('#brandPara').hide();
			$('#discPara').hide();

			$('#nameInput').css('display', 'inline');
			$('#nameInput').fadeIn();
			$('#skuInput').css('display', 'inline');
			$('#skuInput').fadeIn();
			$('#brandInput').css('display', 'inline');
			$('#brandInput').fadeIn();
			$('#descriptionInput').fadeIn();
		});

		$('#cancelSettings').click(function () {
			$(this).hide();

			$('.updateItemName').fadeIn();
			$('#saveSettings').hide();

			$('#nameInput').css('display', 'none');
			$('#nameInput').hide();
			$('#skuInput').css('display', 'none');
			$('#skuInput').hide();
			$('#brandInput').css('display', 'none');
			$('#brandInput').hide();
			$('#descriptionInput').hide();

			$('#namePara').fadeIn();
			$('#skuPara').fadeIn();
			$('#brandPara').fadeIn();
			$('#discPara').fadeIn();
		});

		$('#saveSettings').click(function () {
			$.ajax({
				type: "POST",
				url: "/Inventory/UpdateItemCoreDetails",
				data: {
					name: $('#nameInput').val(),
					sku: $('#skuInput').val(),
					description: $('#descriptionInput').val(),
					brand: $('#brandInput').val(),
					skuId: $('.updateItemName').attr("id")
				},
				success: function (response) {
					if (JSON.parse(response) == "Exist" || !response) {
						alert("This sku already exists");
						return;
					}

					$('#saveSettings').hide();

					$('#namePara span').text($('#nameInput').val());
					$('#skuPara').text($('#skuInput').val());
					$('#brandPara').text($('#brandInput').val());
					$('#discPara').text($('#descriptionInput').val());

					$('.updateItemName').fadeIn();
					$('#cancelSettings').hide();

					$('#nameInput').css('display', 'none');
					$('#nameInput').hide();
					$('#skuInput').css('display', 'none');
					$('#skuInput').hide();
					$('#brandInput').css('display', 'none');
					$('#brandInput').hide();
					$('#descriptionInput').hide();

					$('#namePara').fadeIn();
					$('#skuPara').fadeIn();
					$('#brandPara').fadeIn();
					$('#discPara').fadeIn();
				}
			});
		});
	});

</script>
