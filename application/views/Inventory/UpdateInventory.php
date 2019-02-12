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
		<div class="container-fluid">
			<div class="row heading-bg">
				<div class="col-lg-6 col-md-6 col-sm-6">
					<h2 class="m-heading">Update Product</h2>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6">
					<ol class="breadcrumb">
						<li><span>Inventory Management</span></li>
						<li class="active"><span>Update Inventory</span></li>
					</ol>
				</div>
			</div>

			<?php $attributes = array('id' => 'updateInventoryForm');
			echo form_open_multipart('Inventory/UpdateInventoryOps/'.$item->pref_id.'/'.$this->uri->segment(4), $attributes);
			echo form_hidden('subCatDataForAjax', base_url('Inventory/FetchSubCategoriesForMainCategoryAjax')); 
			echo form_hidden('subCatSelected', $item->sub_category_id);
			echo form_hidden('images_deleted', '');
			$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
			$hostUrl = $protocol.'://'.$_SERVER['HTTP_HOST'];
			echo form_hidden('existing_images', str_replace($hostUrl, ".", $item->item_image));
			echo form_hidden('existing_thumbnail', $item->item_thumbnail);
			// echo form_hidden('thumb_deleted', ''); ?>
			<div class="row">
				<div class="col-md-8">
					<div class="box-white m-b-30">
						<h2>Product Details</h2>
						<div class="form-wrap">
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Product Sku*</label>
											<input type="text" name="item_sku" class="form-control" value="<?= $item->item_sku; ?>" placeholder="" max="20">
											<?= form_error('item_sku', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
											<?= isset($skuExist) ? '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">'.$skuExist.'</small>' : '';?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Product Name*</label>
											<input type="text" name="item_name" class="form-control" value="<?= $item->item_name; ?>" placeholder="">
											<?= form_error('item_name', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label mb-10">Description</label>
											<input type="text" name="totalInventoryAdded" hidden>
											<textarea name="item_main_description" class="form-control" rows="5"><?= $item->item_main_description; ?></textarea>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="box-white m-b-30">
						<h2>Packaging Options</h2>
						<div class="form-wrap">
							<form action="#">
								<div class="form-body">
									<div id="collapse_1" class="panel-collapse collapse in" role="tabpanel">
										<div class="bg-gl clearfix" id="moreVariants">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label mb-10">Variant*</label>
														<?php 
														foreach ($UnitTypes as $unit) : 
															$options[$unit->unit_id] = $unit->unit_name;
														endforeach;
														$atts = array( 'class' => 'form-control', 'data-style' => 'form-control btn-default btn-outline' );
														echo form_dropdown('unit_id', $options, $item->unit_id, $atts); ?>
														<?= isset($PropExist) ? '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">'.$PropExist.'</small>' : '';?>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label mb-10">Trade Price*</label>
														<input type="text" name="item_trade_price" class="form-control" value="<?= $item->item_trade_price; ?>"
														 placeholder="Rs:0.00" max="11">
														<?= form_error('item_trade_price', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label mb-10">Main Category*</label>
														<?php 
														foreach ($MainCategories as $category) : 
															$optionsNew[$category->main_category_id] = $category->main_category_name;
														endforeach;
														$atts = array( 'class' => 'form-control', 'data-style' => 'form-control btn-default btn-outline', 'id' => 'mainCategoryDd' );
														echo form_dropdown('', $optionsNew, $item->main_category_id, $atts); ?>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label mb-10">Sub Category*</label>
														<select class="form-control" id="forFindingInMainCat" name="sub_category_id" data-style="form-control btn-default btn-outline">
														</select>
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
				<div class="col-md-4">
					<div class="box-white m-b-30">
						<h2>Images</h2>
						<div class="box-white m-b-30">
							<div class="form-wrap">
								<div class="thumb-c">
									<div class="upload-pic custom-thumb">Add Product thumbnail<br>maximam size 500X500 px</div>
									<input type="file" id="itemThumbnail" name="item_thumbnail" class="dropify" accept=".png, .jpeg, .jpg, .bmp"
									 data-default-file="<?= $item->item_thumbnail; ?>" />
									<?= isset($item_thumbnail_error) ? '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">'.$item_thumbnail_error.'</small>' : '';?>
								</div>
							</div>
						</div>
						<div class="panel-wrapper collapse in">
							<div class="panel-body p-0">
								<div class="row">
									<input name="item_images[]" type="file" accept=".png, .jpeg, .jpg, .bmp" multiple />
									<?= isset($imagesUploadError) ? '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">'.$imagesUploadError.'</small>' : '';?>
								</div>
								<?php if($item->item_image) :
								$itemImages = explode(",", $item->item_image); ?>
								<div class="row">
									<?php foreach ($itemImages as $image) : ?>
									<div class="col-md-6" style="padding: 0px">
										<div style="position: absolute; top: 70%; width: 100%; text-align: center;">
											<button class="btn btn-sm btn-danger deleteImages" style="opacity: 0.5;" type="button">REMOVE</button>
										</div>
										<img src="<?= $image?>" width="100%" height="200px" />
									</div>
									<?php endforeach; ?>
								</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
				<div class="form-bottom">
					<div class="button-section align-right">
						<a href="<?= base_url('Inventory/UpdateInventorySku/'.$this->uri->segment(4)); ?>" class="btn btn-cancel">Cancel</a>
						<a id="updateInventoryButton" class="btn btn-save">Save</a>
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>
	<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
	<script src="<?= base_url('assets/vendors/bower_components/dropzone/dist/dropzone.js');?>"></script>
	<script src="<?= base_url('assets/dist/js/dropzone-data.js')?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/js/UpdateInventory.js').'?v='.time(); ?>"></script>
