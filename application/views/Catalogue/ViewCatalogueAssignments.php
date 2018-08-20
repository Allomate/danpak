<?php require_once(APPPATH.'/views/includes/header.php'); ?>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once(APPPATH.'/views/includes/navbar&sidebar.php'); ?>
	<div class="page-wrapper">
		<div class="container-fluid">
			<?php if ($feedback = $this->session->flashdata('catalogue_assigned')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Assigned</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('catalogue_assignment_failed')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Failed</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('catalogue_assignment_updated')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Updated</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('catalogue_assignment_update_failed')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Failed</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('already_exist')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Already Exist</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('catalogue_assignment_deleted')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Deleted</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('catalogue_assignment_delete_failed')) : ?>
				<div class="alert alert-dismissible alert-danger">
					<strong>Failed!</strong> <?= $feedback; ?>
				</div>
			<?php endif; ?>
			<div class="row heading-bg">
				<div class="col-lg-6 col-md-6 col-sm-6">
					<h2 class="m-heading">Catalogue Management</h2>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6">
					<ol class="breadcrumb">

						<li><a href="#"><span>Organization</span></a></li>
						<li><span>Catalogue Management</span></li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="box-white p-20"><a href="<?= base_url('Catalogue/AssignCatalogue');?>" class="btn add-emp"><i class="fa fa-plus"> </i> New Catalogue Assignment</a>
						<h2 class="m-b-0 less_600">Catalogue Assignments List </h2>
						<div class="table-wrap">
							<div class="table-responsive">
								<table  class="table table-hover display  pb-30" >
									<thead>
										<tr>
											<th>Catalogue</th>
											<th>Assigned To</th>
											<th>Active From</th>
											<th>Active Till</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Catalogue</th>
											<th>Assigned To</th>
											<th>Active From</th>
											<th>Active Till</th>
											<th>Actions</th>
										</tr>
									</tfoot>
									<tbody>
										<?php foreach ($Assignments as $assignment) : ?>
											<tr>
												<td><?= $assignment->catalogue_name; ?> <a href="" id="<?= $assignment->id; ?>" ></a> </td>
												<td><?= $assignment->employee_username; ?></td>
												<td><?= $assignment->active_from; ?></td>
												<td><?= $assignment->active_till; ?></td>
												<td>
													<a href="<?= base_url('Catalogue/UpdateCatalogueAssignment/'.$assignment->id); ?>"><i class="fa fa-pencil"></i></a>
													&nbsp;
													<a class="deleteConfirmation" href="<?= base_url('Catalogue/DeleteCatalogueAssignment/'.$assignment->id); ?>"><i class="fa fa-close"></i></a>
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