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
					<h2 class="m-heading">Categories Management</h2>
				</div>
				<div class="col-lg-6 col-md-6">
					<ol class="breadcrumb">
						<li><a href="#"><span>Organization</span></a></li>
						<li><span>Main Categories Management</span></li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="box-white m-b-30">
						<h2>Add Main Category</h2>
						<?php $attributes = array('id' => 'updateSubCategoryForm');
						echo form_open('Categories/UpdateSubCategoryOps/'.$SubCategory->sub_category_id, $attributes); ?>
						<div class="form-wrap">
							<div class="form-body">
								<div class="row"> 
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Category Name*</label>
											<input type="text" name="sub_category_name" class="form-control" value="<?= $SubCategory->sub_category_name; ?>">
											<?= form_error('sub_category_name', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Main Category*</label>
											<?php
											foreach ($MainCategories as $category) : 
												$options[$category->main_category_id] = $category->main_category_name;
											endforeach; 
											$atts = array( 'class' => 'selectpicker', 'data-style'=>'form-control btn-default btn-outline' );
											echo form_dropdown('main_category_id', $options, $SubCategory->main_category_id, $atts); ?>
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
			<a type="button" href="<?= base_url('Categories/ListSubCategories'); ?>" id="backFromAddSubCategories" class="btn btn-cancel">Cancel</a>
			<a type="button" id="updateSubCatButton" class="btn btn-save">Save</a>						
		</div>
	</div>
</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script type="text/javascript" src="<?= base_url('assets/js/Categories.js').'?v='.time(); ?>"></script>