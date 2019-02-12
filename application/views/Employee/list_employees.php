<?php require_once(APPPATH.'/views/includes/header.php'); ?>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once(APPPATH.'/views/includes/navbar&sidebar.php'); ?>
	<div class="page-wrapper">
		<div class="container-fluid">
			<?php if ($feedback = $this->session->flashdata('update_success')) : ?>
			<div class="row" style="margin-top: 20px;">
				<div class="alert alert-dismissible alert-success" style=" background: white; color: black;">
					<strong>Updated</strong>
					<?= $feedback; ?>
				</div>
			</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('employee_activated')) : ?>
			<div class="row" style="margin-top: 20px;">
				<div class="alert alert-dismissible alert-success" style=" background: white; color: black;">
					<strong>Activated</strong>
					<?= $feedback; ?>
				</div>
			</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('employee_deactivated')) : ?>
			<div class="row" style="margin-top: 20px;">
				<div class="alert alert-dismissible alert-success" style=" background: white; color: black;">
					<strong>Deactivated</strong>
					<?= $feedback; ?>
				</div>
			</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('update_failed')) : ?>
			<div class="row" style="margin-top: 20px;">
				<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
					<strong>Failed</strong>
					<?= $feedback; ?>
				</div>
			</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('employee_added')) : ?>
			<div class="row" style="margin-top: 20px;">
				<div class="alert alert-dismissible alert-success " style=" background: white; color: black; ">
					<strong>Added</strong>
					<?= $feedback; ?>
				</div>
			</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('employee_add_failed')) : ?>
			<div class="row " style="margin-top: 20px; ">
				<div class="alert alert-dismissible alert-danger " style=" background: white; color: black; ">
					<strong>Failed</strong>
					<?= $feedback; ?>
				</div>
			</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('employee_deleted')) : ?>
			<div class="row " style="margin-top: 20px; ">
				<div class="alert alert-dismissible alert-success " style=" background: white; color: black; ">
					<strong>Deleted</strong>
					<?= $feedback; ?>
				</div>
			</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('employee_delete_failed')) : ?>
			<div class="row " style="margin-top: 20px; ">
				<div class="alert alert-dismissible alert-danger " style=" background: white; color: black; ">
					<strong>Failed</strong>
					<?= $feedback; ?>
				</div>
			</div>
			<?php endif; ?>
			<div class="row heading-bg ">
				<div class="col-lg-6 col-md-6 col-sm-6 ">
					<h2 class="m-heading ">Employee Management</h2>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 ">
					<ol class="breadcrumb ">

						<li>
							<a href="# ">
								<span>Organization</span>
							</a>
						</li>
						<li>
							<span>Employee Management</span>
						</li>
						<li>
							<span>Employee List</span>
						</li>
					</ol>
				</div>
			</div>
			<div class="row ">
				<div class="col-md-12 ">
					<div class="box-white p-20 ">
						<a href="<?=base_url('Employees/AddEmployee');?>" class="btn add-emp">
							<i class="fa fa-plus"> </i> New Employee</a>
						<h2 class="m-b-0 less_600">Employee List </h2>
						<div class="table-wrap">
							<div class="table-responsive">
								<table class="table table-hover display  pb-30">
									<thead>
										<tr>
											<th>S.no</th>
											<th>Employee ID:</th>
											<th>Name</th>
											<th>Username</th>
											<th>Designation</th>
											<th>Area</th>
											<th>Territory</th>
											<th>Reporting To</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>S.no</th>
											<th>Employee ID:</th>
											<th>Name</th>
											<th>Username</th>
											<th>Designation</th>
											<th>Area</th>
											<th>Territory</th>
											<th>Reporting To</th>
											<th>Actions</th>
										</tr>
									</tfoot>
									<tbody>
										<?php $sno = 1; foreach ($employees as $employee) : ?>
										<tr>
											<td>
												<?= $sno++; ?>
											</td>
											<td>
												<?= $employee->employee_id; ?>
											</td>
											<td>
												<?= $employee->employee_first_name . " " . $employee->employee_last_name; ?>
											</td>
											<td>
												<?= $employee->employee_username; ?>
											</td>
											<td>
												<?= $employee->employee_designation; ?>
											</td>
											<td>
												<?= $employee->area; ?>
											</td>
											<td>
												<?= $employee->territory; ?>
											</td>
											<td>
												<?= $employee->reporting_to != "" ? $employee->reporting_to : 'No one'; ?>
											</td>
											<td>
												<a href="<?= base_url('Employees/UpdateEmployee/'.$employee->employee_id); ?>">
													<i class="fa fa-pencil"></i>
												</a>
												<a class="deleteConfirmation" href="<?= base_url('Employees/DeleteEmployee/'.$employee->employee_id); ?>">
													<i class="fa fa-close"></i>
												</a>
												<a class="view-report" href="<?= base_url('Employees/EmployeeProfile/'.$employee->employee_id); ?>">
													View Profile
												</a>
												<?php if($employee->status){ ?>
												<a class="view-report" href="<?= base_url('Employees/Deactivate/'.$employee->employee_id); ?>">
													Deactivate
												</a>
												<?php }else{ ?>
												<a class="view-report" href="<?= base_url('Employees/Activate/'.$employee->employee_id); ?>">
													Activate
												</a>
												<?php } ?>
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
	$(document).ready(function () {
		$(document).on('click', '.deleteConfirmation', function (e) {
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
