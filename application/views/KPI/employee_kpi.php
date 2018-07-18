<?php require_once APPPATH . '/views/includes/header.php';?>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once APPPATH . '/views/includes/navbar&sidebar.php';?>
	<div class="page-wrapper">
		<div class="container">
			<?php if ($feedback = $this->session->flashdata('kpi_succes')) : ?>
			<div class="row" style="margin-top: 20px;">
				<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
					<strong>Added</strong>
					<?= $feedback; ?>
				</div>
			</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('kpi_updated')) : ?>
			<div class="row" style="margin-top: 20px;">
				<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
					<strong>Updated</strong>
					<?= $feedback; ?>
				</div>
			</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('kpi_activation_failed')) : ?>
			<div class="row" style="margin-top: 20px;">
				<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
					<strong>Failed</strong>
					<?= $feedback; ?>
				</div>
			</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('kpi_activated')) : ?>
			<div class="row" style="margin-top: 20px;">
				<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
					<strong>Activated</strong>
					<?= $feedback; ?>
				</div>
			</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('kpi_deactivated')) : ?>
			<div class="row" style="margin-top: 20px;">
				<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
					<strong>De-Activated</strong>
					<?= $feedback; ?>
				</div>
			</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('kpi_deactivation_failed')) : ?>
			<div class="row" style="margin-top: 20px;">
				<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
					<strong>Failed</strong>
					<?= $feedback; ?>
				</div>
			</div>
			<?php endif; ?>
			<div class="row heading-bg">
				<div class="col-lg-6 col-md-6">
					<h2 class="m-heading">Employee Management</h2>
				</div>
				<div class="col-lg-6 col-md-6">
					<ol class="breadcrumb">
						<li>
							<a href="#">
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
			<div class="row">
				<div class="col-md-12">
					<div class="box-white p-20">
						<h2 class="m-b-0">Employee List </h2>
						<div class="table-wrap">
							<div class="table-responsive">
								<table id="datable_1" class="table table-hover display  pb-30">
									<thead>
										<tr>
											<th>Serial No</th>
											<th>Employee Name</th>
											<th>Designation</th>
											<th>Territory</th>
											<th>Area</th>
											<th>Region</th>
											<th>Status</th>
											<th>Total KPIs</th>
											<th>Action</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Serial No</th>
											<th>Employee Name</th>
											<th>Designation</th>
											<th>Territory</th>
											<th>Area</th>
											<th>Region</th>
											<th>Status</th>
											<th>Total KPIs</th>
											<th>Action</th>
										</tr>
									</tfoot>
									<tbody>
										<?php foreach($Employees as $employee) : ?>
										<tr>
											<td>
												<?= $employee->employee_id; ?>
											</td>
											<td>
												<?= $employee->employee_first_name." ".$employee->employee_last_name;?>
											</td>
											<td>Sales</td>
											<td>
												<?= $employee->territory;?>
											</td>
											<td>
												<?= $employee->area;?>
											</td>
											<td>
												<?= $employee->region;?>
											</td>
											<td>
												<?php if($employee->kpi_status == "1") : echo "Active"; elseif($employee->kpi_status == "0") : echo "Inactive"; else: echo "Not Set"; endif; ?>
											</td>
											<td>
												<?= $employee->total_kpis ? $employee->total_kpis . " <span style='cursor: pointer; font-weight: bolder' class='viewEmpKpis'><small>(VIEW)</small></span> " : "NA"; ?>
													<input type="text" id="empUn" value="<?= $employee->employee_username; ?>" hidden>
											</td>
											<td>
												<?php if($employee->kpi_status == "1") : ?>
												<a href="<?= base_url('Kpi/UpdateKpiSettings/'.$employee->employee_username);?>">
													<i class="fa fa-pencil"></i>
												</a>
												<a href="<?= base_url('Kpi/DeactivateKpi/'.$employee->employee_username);?>" class="view-report">De-Active</a>
												<?php elseif($employee->kpi_status == "0") : ?>
												<a href="<?= base_url('Kpi/ActivateKpi/'.$employee->employee_username);?>" class="view-report">Active</a>
												<?php else : ?>
												<a href="<?= base_url('Kpi/EmpKpiSettings/'.$employee->employee_username);?>" class="view-report">Set KPI</a>
												<?php endif; ?>
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
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width: 90%">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">List of KPIs</h4>
			</div>
			<div class="modal-body">
				<table id="datable_2" class="table table-hover display pb-30 kpisTable">
					<thead>
						<tr>
							<th>Type</th>
							<th>Criteria</th>
							<th>Month/Quarter</th>
							<th>Item</th>
							<th>Unit</th>
							<th>Target</th>
							<th>Eligibility</th>
							<th>Weightage</th>
							<th>Incentive</th>
							<th>Progress</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<?php require_once APPPATH . '/views/includes/footer.php';?>
<script type="text/javascript" src="<?=base_url('assets/js/KPI.js') . '?v=' . time();?>"></script>
