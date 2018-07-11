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
												<?= $employee->kpi_status ? "Active" : "Inactive" ; ?>
											</td>
											<td>
												<a href="<?= base_url('Kpi/EmpKpiSettings/'.$employee->employee_username);?>" class="view-report">Set KPI</a>
												<?php if($employee->kpi_status == "1") : ?>
												<a href="<?= base_url('Kpi/UpdateKpiSettings/'.$employee->employee_username);?>" class="view-report">Update KPI</a>
												<a href="<?= base_url('Kpi/DeactivateKpi/'.$employee->employee_username);?>" class="view-report">De-Active</a>
												<?php elseif($employee->kpi_status == "0") : ?>
												<a href="<?= base_url('Kpi/ActivateKpi/'.$employee->employee_username);?>" class="view-report">Active</a>
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
<?php require_once APPPATH . '/views/includes/footer.php';?>
<script type="text/javascript" src="<?=base_url('assets/js/Retailers.js') . '?v=' . time();?>"></script>
