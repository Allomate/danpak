<?php require_once APPPATH . '/views/includes/header.php';?>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once APPPATH . '/views/includes/navbar&sidebar.php';?>
	<div class="page-wrapper">
		<div class="container">
			<div class="row heading-bg">
				<div class="col-lg-6 col-md-6 col-sm-6">
					<h2 class="m-heading">KPI Management</h2>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6">
					<ol class="breadcrumb">
						 
						<li>
							<span>KPI Management</span>
						</li>
						<li>
							<span>Hierarchy Tree</span>
						</li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="box-white p-20">
						<h2 class="m-b-0">Employees List </h2>
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
												<a href="<?= base_url('Kpi/CreateHierarchy/'.$employee->employee_username);?>" class="view-report">Generate Tree</a>
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
