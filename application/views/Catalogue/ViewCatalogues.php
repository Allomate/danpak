<?php require_once(APPPATH.'/views/includes/header.php'); ?>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once(APPPATH.'/views/includes/navbar&sidebar.php'); ?>
	<div class="page-wrapper">
		<div class="container-fluid">
			<?php if ($feedback = $this->session->flashdata('catalogue_added')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-success" style=" background: white; color: black;">
						<strong>Added!</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('catalogue_add_failed')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Failed!</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('catalogue_updated')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-success" style=" background: white; color: black;">
						<strong>Updated!</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('catalogue_update_failed')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Failed!</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('catalogue_deleted')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-success" style=" background: white; color: black;">
						<strong>Deleted!</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('catalogue_delete_failed')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Failed</strong> <?= $feedback; ?>
					</div>
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
					<div class="box-white p-20"><a href="<?= base_url('Catalogue/CreateCatalogue');?>" class="btn add-emp"><i class="fa fa-plus"> </i> New Catalogue</a>
						<h2 class="m-b-0 less_600">Catalogue List </h2>
						<div class="table-wrap">
							<div class="table-responsive">
								<table  class="table table-hover display  pb-30" >
									<thead>
										<tr>
											<th>Name</th>
											<th style="max-width: 150px">Inventory</th>
											<th>Created At</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Name</th>
											<th style="max-width: 150px">Inventory</th>
											<th>Created At</th>
											<th>Actions</th>
										</tr>
									</tfoot>
									<tbody>
										<?php foreach ($Catalogues as $catalogue) : ?>
											<tr>
												<td><?= $catalogue->catalogue_name; ?></td>
												<td style="max-width: 150px"><?= $catalogue->inventory; ?><small class="viewCompleteCatalogueList" id="<?= $catalogue->id; ?>" style="font-weight: bold; cursor: pointer;">(VIEW)</small></td>
												<td><?= $catalogue->created_at; ?></td>
												<td>
													<a href="<?= base_url('Catalogue/UpdateCatalogue/'.$catalogue->id); ?>"><i class="fa fa-pencil"></i></a>
													&nbsp;
													<a class="deleteConfirmation" href="<?= base_url('Catalogue/DeleteCatalogue/'.$catalogue->id); ?>"><i class="fa fa-close"></i></a>
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
<div class="row">
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog" style="width: 1000px;">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Catalogue</h4>
				</div>
				<div class="modal-body">
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>
<input type="text" value="<?= base_url('Catalogue/ViewCompleteCatalogueListAjax'); ?>" id="getCatalogueList">
<input type="text" value="<?= base_url(); ?>" id="baseUrlOnly">
<input type="text" id="baseUrlField" value="<?= base_url('Catalogue/GetCatalogueContentsAjaxCall');?>" hidden>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script type="text/javascript" src="<?= base_url('assets/js/ViewCatalogue.js?v='.time());?>"></script>
<script type="text/javascript">
	$(document).ready(function(){

		$(document).on('click', '.viewCompleteCatalogueList', function(){
			var catalogueId = $(this).attr('id');
			$.ajax({
				type: 'POST',
				url: $('#getCatalogueList').val(),
				data: { catalogue_id: catalogueId },
				success: function(response){
					var response = JSON.parse(response);
					$('.modal-body').html('<table class="table" id="catalogueDetailsTable"><thead><tr><th>Thumbnail</th><th>Name</th><th>Unit</th><th>Category</th></tr></thead><tfoot><tr><th>Thumbnail</th><th>Name</th><th>Unit</th><th>Category</th></tr></tfoot><tbody>');
					for (var i = 0; i < response.length; i++) {
						$('#catalogueDetailsTable tbody').append('<tr><td><img src="'+response[i].item_thumbnail+'" width="150px" height="auto" /></td><td><a href="'+$('#baseUrlOnly').val()+'Inventory/UpdateInventorySku/'+response[i].item_id+'" target="_blank">'+response[i].item_name+'</a></td><td>'+response[i].unit_name+'</td><td>'+response[i].category+'</td></tr>');
					}
					$('.modal-body').append('</tbody></table>');
					$("#catalogueDetailsTable").DataTable();
					$('select[name="catalogueDetailsTable_length"]').prepend('<option value="4">4</option>');
					$('#myModal').modal('show');
				}
			})
		});

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