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
					<h2 class="m-heading">Add New Product</h2>
				</div>
				<div class="col-lg-6 col-md-6">
					<ol class="breadcrumb">
						<li><span>Inventory Management</span></li>
						<li class="active"><span>Add New Inventory</span></li>
					</ol>
				</div>
			</div>

			<?php $attributes = array('id' => 'addInventoryForm');
			echo form_open_multipart('Inventory/AddInventoryOps', $attributes);
			echo form_open_multipart('baseUrlString', base_url());
			echo form_hidden('subCatDataForAjax', base_url('Inventory/FetchSubCategoriesForMainCategoryAjax'));
			echo form_hidden('skuDataRuntimeForAjax', base_url('Inventory/GetRuntimeSku'));
			echo form_hidden('unitsDefinedForSku', base_url('Inventory/GetDefinedUnitsForThisSKuAjax')); ?>
			<div class="row">
				<div class="col-md-8">
					<div class="box-white m-b-30">
						<h2>New Product</h2>
						<div class="form-wrap">
							<div class="form-body">
								<!-- <div class="row">
									<div class="col-md-12">
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label for="exampleInputEmail1">Pre-Defined Items</label>
													<select class="form-control" name="pre_defined_item">
														<option value="0" selected="selected">No predefined item</option>
														<?php foreach ($PreDefinedItems as $item) : ?>
															<option value="<?= $item->item_id; ?>"><?= $item->item_name; ?></option>
														<?php endforeach;?>
													</select>
												</div>
											</div>
										</div>
									</div>
								</div> -->

								<div class="row" id="skuandnameDiv">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Product Sku*</label>
											<input type="text" name="item_sku" class="form-control" value="<?= set_value('item_sku'); ?>" placeholder="" max="20">
											<small id="skuExistError" style="color: red; font-weight: bold; margin-top: 5px; display: none">This sku already exist</small>
											<?= form_error('item_sku', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Product Name*</label>
											<input type="text" name="item_name" class="form-control" value="<?= set_value('item_name'); ?>" placeholder="">
											<?= form_error('item_name', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label mb-10">Description</label>
											<input type="text" name="totalInventoryAdded" hidden>
											<textarea name="item_main_description" class="form-control" rows="5"><?= set_value('item_main_description'); ?></textarea>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="box-white m-b-30">
						<h2>Packaging Options</h2>
						<div class="form-wrap">
							<div class="form-body">
								<div id="collapse_1" class="panel-collapse collapse in" role="tabpanel">
									<div class="bg-gl clearfix" id="moreVariants">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label mb-10">Variants*</label>
													<select name="unit_id_0" class="form-control unitIdsDd" data-style="form-control btn-default btn-outline">
														<option value="0">No type selected</option>
														<?php $unitTypeIds='';$unitTypeNames='';foreach ($UnitTypes as $unit) : ?>
														<option value="<?= $unit->unit_id; ?>"><?= $unit->unit_name; ?></option>
														<?php $unitTypeIds .= ',' . $unit->unit_id;
														$unitTypeNames .= ',' . $unit->unit_name; endforeach;?>
													</select>
													<?= isset($PropExist) ? '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">'.$PropExist.'</small>' : '';?>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label mb-10">Product Quantity*</label>
													<input type="text" name="item_quantity_0" class="form-control" max="11">
													<?= form_error('item_quantity', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label mb-10">Child</label>
													<select name="child_item_0" class="form-control childItems" data-style="form-control btn-default btn-outline">
														<option value="0">No type selected</option>
														<?php $unitTypeIds='';$unitTypeNames='';foreach ($UnitTypes as $unit) : ?>
														<option value="<?= $unit->unit_id; ?>"><?= $unit->unit_name; ?></option>
														<?php $unitTypeIds .= ',' . $unit->unit_id;
														$unitTypeNames .= ',' . $unit->unit_name; endforeach;?>
													</select>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label mb-10">Child Quantity</label>
													<input type="text" name="child_item_quantity_0" class="form-control" max="11">
													<?= form_error('item_quantity', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label mb-10">Cost Price*</label>
													<input type="text" name="item_warehouse_price_0" class="form-control" placeholder="Rs:0.00" max="11">
													<?= form_error('item_warehouse_price', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label mb-10">Trade Price*</label>
													<input type="text" name="item_trade_price_0" class="form-control" placeholder="Rs:0.00" max="11">
													<?= form_error('item_trade_price', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label mb-10">Retail Price*</label>
													<input type="text" name="item_retail_price_0" class="form-control" placeholder="Rs:0.00" max="11">
													<?= form_error('item_retail_price', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label mb-10">Product Barcode*</label>
													<input type="text" name="item_barcode_0" class="form-control" placeholder="" max="20">
													<?= form_error('item_barcode', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label mb-10">Expiry Date</label>
													<input type="text" id="firstName" class="form-control" placeholder="">
												</div>
											</div> 
										</div>
										<div class="row">
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label class="control-label mb-10">Description</label>
													<input type="text" name="totalInventoryAdded" hidden>
													<textarea name="item_description_0" class="form-control" rows="5"></textarea>
												</div>
											</div> 
										</div>
									</div>
									<div class="row">
										<div class="col-md-12 m-t-15 align-right"> 
											<a class="btn btn-blue-sm m-b-15" id="addAnotherVariantButton">Add another option</a>
										</div>
									</div>
									<input type="text" id="unitTypeIdsCombined" value="<?= $unitTypeIds;?>" hidden>
									<input type="text" id="unitTypeNameCombined" value="<?= $unitTypeNames;?>" hidden>
								</div>
							</div>
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
									<input type="file" id="itemThumbnail" name="item_thumbnail" class="dropify" accept=".png, .jpeg, .jpg, .bmp"/>
									<?= isset($item_thumbnail_error) ? '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">'.$item_thumbnail_error.'</small>' : '';?>
								</div>
							</div> 
						</div>
						<div class="panel-wrapper collapse in">
							<div class="panel-body p-0">
								<input name="item_images[]" class="form-control" type="file" accept=".png, .jpeg, .jpg, .bmp" multiple />
								<?= isset($imagesUploadError) ? '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">'.$imagesUploadError.'</small>' : '';?>
							</div>
						</div>
					</div>
					<div class="box-white m-b-30">
						<h2>Assign Catalogue</h2>
						<div class="form-wrap">
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label mb-10">Main Category*</label>
											<select class="form-control" id="mainCategoryDd_0" data-style="form-control btn-default btn-outline">
												<?php $mainCatIds = '';$mainCatNames = '';foreach ($MainCategories as $category) { ?>
												<option value="<?= $category->main_category_id; ?>"><?= $category->main_category_name; ?></option>
												<?php $mainCatIds .= ',' . $category->main_category_id;
												$mainCatNames .= ',' . $category->main_category_name;}?>
											</select>
										</div>
										<div class="form-group">
											<label class="control-label mb-10">Sub Category*</label>
											<select class="form-control" id="forFindingInMainCat" name="sub_category_id_0" data-style="form-control btn-default btn-outline">
											</select>
										</div>
									</div>
								</div>		 	  
							</div>
							<input type="text" id="mainCatIdsCombined" value="<?= $mainCatIds;?>" hidden>
							<input type="text" id="mainCatNamesCombined" value="<?= $mainCatNames;?>" hidden>
						</div> 
					</div>
				</div>
				<div class="form-bottom">
					<div class="button-section align-right">
						<a href="<?= base_url('Inventory/ListInventory'); ?>" class="btn btn-cancel">Cancel</a>
						<a id="addInventoryButton" class="btn btn-save">Save</a>						
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script type="text/javascript" src="<?= base_url('assets/js/Inventory.js').'?v='.time(); ?>"></script>