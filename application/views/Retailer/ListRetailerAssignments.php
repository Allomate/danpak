<?php require_once(APPPATH.'/views/includes/header.php'); ?>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once(APPPATH.'/views/includes/navbar&sidebar.php'); ?>
	<div class="page-wrapper">
		<div class="container-fluid">
			<?php if ($feedback = $this->session->flashdata('retailer_added')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Added</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('retailer_add_failed')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Failed</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('retailer_updated')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Updated</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('retailer_update_failed')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Failed</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('retailer_deleted')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Deleted</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('retailer_delete_failed')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Failed</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('retailer_assignment_Exist')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Failed</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('retailer_assignment_updated')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Updated</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('retailer_assignment_update_failed')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Failed</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<div class="row heading-bg">
				<div class="col-lg-6 col-md-6">
					<h2 class="m-heading">Distributors Management</h2>
				</div>
				<div class="col-lg-6 col-md-6">
					<ol class="breadcrumb">

						<li><a href="#"><span>Organization</span></a></li>
						<li><span>Distributors Management</span></li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="box-white p-20"><a href="<?= base_url('Retailers/AddMoreAssignments');?>" class="btn add-emp"><i class="fa fa-plus"> </i> New Assignments</a>
						<h2 class="m-b-0">Distributors Assignment List </h2>
						<div class="table-wrap">
							<div class="table-responsive">
								<table class="table table-hover display  pb-30" >
									<thead>
										<tr>
											<th>S.No</th>
											<th>Employee</th>
											<th>Distributors Assigned</th>
											<th>Day</th>
											<th>Territory</th>
											<th>Action</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Distributors</th>
											<th>Addresses</th>
											<th>Employee</th>
											<th>Day</th>
											<th>Territory</th>
											<th>Action</th>
										</tr>
									</tfoot>
									<tbody>
										<?php $sno = 1; foreach ($RetailersAssignments as $assignment) : ?>
										<tr>
											<td><?= $sno++; ?></td>
											<td><?= $assignment->employee; ?></td>
											<td><?= $assignment->total_distributors_assigned; ?> <small class="viewCompleteDistributorsList" id="<?= $assignment->employee_id; ?>" style="font-weight: bold; cursor: pointer;">(VIEW)</small><input type="text" class="assignedDay" value="<?= $assignment->assigned_for_day; ?>" hidden/> </td>
											<td><?= strtoupper($assignment->assigned_for_day); ?></td>
											<td><?= $assignment->territory_name; ?></td>
											<td>
												<a href="<?= base_url('Retailers/UpdateRetailersAssignments/'.$assignment->employee_id.'/'.$assignment->assigned_for_day); ?>"><i class="fa fa-pencil"></i></a>
												&nbsp;
												<a class="deleteConfirmation" href="<?= base_url('Retailers/DeleteRetailersAssignments/'.$assignment->employee_id.'/'.$assignment->assigned_for_day); ?>"><i class="fa fa-close"></i></a>
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
<div class="row">
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog" style="width: 1000px;">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Distributors</h4>
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
<input type="text" value="<?= base_url('Retailers/ViewCompleteRetailersListForAnEmployeeAjaxRequest'); ?>" id="getRetailersList">
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script type="text/javascript">
	$(document).ready(function(){

		$(document).on('click', '.viewCompleteDistributorsList', function(){
			var employeeId = $(this).attr('id');
			var day = $(this).parent().find('.assignedDay').val();
			debugger;
			$.ajax({
				type: 'POST',
				url: $('#getRetailersList').val(),
				data: { employee_id: employeeId, assignedDay: day },
				success: function(response){
					var response = JSON.parse(response);
					$('.modal-body').html('<table class="table" id="distributorsDetailsTable"><thead><tr><th>Name</th><th>Address</th><th>Territory</th></tr></thead><tfoot><tr><th>Name</th><th>Address</th><th>Territory</th></tr></tfoot><tbody>');
					for (var i = 0; i < response.length; i++) {
						$('#distributorsDetailsTable tbody').append('<tr><td>'+response[i].retailer_name+'</td><td>'+response[i].retailer_address+'</td><td>'+response[i].territory_name+'</td></tr>');
					}
					$('.modal-body').append('</tbody></table>');
					$("#distributorsDetailsTable").DataTable();
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