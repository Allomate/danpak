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
						<h2>Update Main Category</h2>
						<?php $attributes = array('id' => 'updateMainCategoryForm');
						echo form_open('Categories/UpdateMainCategoryOps/'.$MainCategory->main_category_id, $attributes); ?>
						<div class="form-wrap">
							<div class="form-body">
								<div class="row"> 
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label mb-10">Category Name*</label>
											<input type="text" name="main_category_name" class="form-control" value="<?= $MainCategory->main_category_name; ?>">
											<?= form_error('main_category_name', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
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
			<a type="button" href="<?= base_url('Categories/ListMainCategories'); ?>" id="backFromUpdateMainCategories" class="btn btn-cancel">Cancel</a>
			<a type="button" id="updateMainCatButton" class="btn btn-save">Save</a>						
		</div>
	</div>
</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script type="text/javascript" src="<?= base_url('assets/js/Categories.js').'?v='.time(); ?>"></script>