<?php require_once(APPPATH.'/views/includes/header.php'); ?>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once(APPPATH.'/views/includes/navbar&sidebar.php'); ?>
	<div class="page-wrapper">
		<div class="container-fluid">
			<?php if ($feedback = $this->session->flashdata('main_category_added')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Added</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('main_category_add_failed')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Failed</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('main_category_updated')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Updated</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('main_category_update_failed')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Failed</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('main_category_deleted')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Deleted</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('main_category_delete_failed')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Failed</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('main_category_activated')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-success" style=" background: white; color: black;">
						<strong>Activated</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('main_category_activate_failed')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Failed</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('main_category_deactivated')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-success" style=" background: white; color: black;">
						<strong>De-Activated</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('main_category_deactivate_failed')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Failed</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<div class="row heading-bg">
				<div class="col-lg-6 col-md-6 col-sm-6">
					<h2 class="m-heading">Categories Management</h2>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6">
					<ol class="breadcrumb">

						<li><a href="#"><span>Organization</span></a></li>
						<li><span>Main Categories Management</span></li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="box-white p-20"><a href="<?= base_url('Categories/AddMainCategory');?>" class="btn add-emp"><i class="fa fa-plus"> </i> Add Main Category</a>
						<h2 class="m-b-0 less_600">Main Categories List </h2>
						<div class="table-wrap">
							<div class="table-responsive">
								<table  class="table table-hover display  pb-30" >
									<thead>
										<tr>
											<th>S.No</th>
											<th>Category Name</th>
											<th>Category Status</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>S.No</th>
											<th>Category Name</th>
											<th>Category Status</th>
											<th>Actions</th>
										</tr>
									</tfoot>
									<tbody>
										<?php $sno = 1; foreach ($MainCategories as $category) : ?>
										<tr>
											<td><?= $sno++; ?></td>
											<td><?= $category->main_category_name; ?></td>
											<td><?= $category->is_active ? "Active" : 'In Active'; ?></td>
											<td>
												<a href="<?= base_url('Categories/UpdateMainCategory/'.$category->main_category_id); ?>"><i class="fa fa-pencil"></i></a>
												&nbsp;
												<?php if($category->is_active) : ?>
													<a href="<?= base_url('Categories/DeactivateMainCategory/'.$category->main_category_id); ?>">
														<button class="btn view-report">De-Activate</button>
													</a>
												<?php else: ?>
													<a href="<?= base_url('Categories/ActivateMainCategory/'.$category->main_category_id); ?>">
														<button class="btn view-report">Activate</button>
													</a>
												<?php endif;?>
												&nbsp;
												<a class="deleteConfirmation" href="<?= base_url('Categories/DeleteMainCategory/'.$category->main_category_id); ?>"><i class="fa fa-close"></i></a>
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
<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('click', '.deleteConfirmation', function(e){
			var thisRef = $(this);
			e.preventDefault();
			swal({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!'
			}).then((result) => {
				if (result.value) {
					window.location.href = thisRef.attr('href');
				}
			})	
		});
	});
</script>