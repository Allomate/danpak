<?php require_once APPPATH . '/views/includes/header.php';?>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once APPPATH . '/views/includes/navbar&sidebar.php';?>
	<div class="page-wrapper">
		<div class="container">
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
											<th>Set KPI</th>
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
											<th>Set KPI</th>
										</tr>
									</tfoot>
									<tbody>
										<tr>
											<td>0254</td>
											<td>Fizan Khan</td>
											<td>Sales</td>
											<td>Territory here</td>
											<td>Area here</td>
											<td>Region here</td>
											<td>Inactive</td>
											<td>
												<a href="<?= base_url('Kpi/EmpKpiSettings');?>" class="view-report">Set KPI</a>
											</td>
										</tr>
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
