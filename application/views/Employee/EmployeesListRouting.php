<?php require_once APPPATH . '/views/includes/header.php';?>
<style type="text/css">
	#map {
		height: 400px;
		width: 100%;
	}

</style>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once APPPATH . '/views/includes/navbar&sidebar.php';?>
	<div class="page-wrapper">
		<div class="container-fluid">
			<div class="row m-t-20">
				<div class="col-md-12">
					<div class="box-white p-20">
						<h2 class="m-b-0">Daily Routing</h2>
						<div class="table-responsive">
							<table class="table table-hover display  pb-30">
								<thead>
									<tr>
										<th>Date</th>
										<th>Total Employees</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th>Date</th>
										<th>Total Employees</th>
										<th>Actions</th>
									</tr>
								</tfoot>
								<tbody>
									<?php foreach ($routing as $route): ?>
									<tr>
										<td>
											<?=$route->date;?>
										</td>
										<td>
											<?=$route->total_employees;?>
										</td>
										<td>
											<a href="CompleteEmployeeRoutingList/<?=$route->date;?>" class="btn view-report">View Complete List</a>
										</td>
									</tr>
									<?php endforeach;?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div id="myModal" class="modal fade" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Employee Location</h4>
							</div>
							<div class="modal-body">
								<div id="map"></div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php require_once APPPATH . '/views/includes/footer.php';?>
