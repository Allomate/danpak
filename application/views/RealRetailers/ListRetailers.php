<?php require_once(APPPATH.'/views/includes/header.php'); ?>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once(APPPATH.'/views/includes/navbar&sidebar.php'); ?>
	<div class="page-wrapper">
		<div class="row" style="margin-top: 20px;">
			<div id="zoneAssignedAlert" class="alert alert-dismissible alert-succes" style=" background: white; color: black; display: none">
				<strong>Zone Assigned</strong>
			</div>
		</div>
		<div class="container-fluid">
			<?php if ($feedback = $this->session->flashdata('retailer_assignment_reserved')) : ?>
			<div class="row" style="margin-top: 20px;">
				<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
					<strong>Failed</strong>
					<?= $feedback; ?>
				</div>
			</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('retailer_added')) : ?>
			<div class="row" style="margin-top: 20px;">
				<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
					<strong>Added</strong>
					<?= $feedback; ?>
				</div>
			</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('retailer_add_failed')) : ?>
			<div class="row" style="margin-top: 20px;">
				<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
					<strong>Failed</strong>
					<?= $feedback; ?>
				</div>
			</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('retailer_updated')) : ?>
			<div class="row" style="margin-top: 20px;">
				<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
					<strong>Updated</strong>
					<?= $feedback; ?>
				</div>
			</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('retailer_update_failed')) : ?>
			<div class="row" style="margin-top: 20px;">
				<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
					<strong>Failed</strong>
					<?= $feedback; ?>
				</div>
			</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('retailer_deleted')) : ?>
			<div class="row" style="margin-top: 20px;">
				<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
					<strong>Deleted</strong>
					<?= $feedback; ?>
				</div>
			</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('retailer_delete_failed')) : ?>
			<div class="row" style="margin-top: 20px;">
				<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
					<strong>Failed</strong>
					<?= $feedback; ?>
				</div>
			</div>
			<?php endif; ?>
			<div class="row heading-bg">
				<div class="col-lg-6 col-md-6 col-sm-6">
					<h2 class="m-heading">Retailers Management</h2>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6">
					<ol class="breadcrumb">

						<li>
							<a href="#">
								<span>Organization</span>
							</a>
						</li>
						<li>
							<span>Retailers Management</span>
						</li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="box-white p-20">
						<a href="<?= base_url('RealRetailers/AddRetailer');?>" class="btn add-emp">
							<i class="fa fa-plus"> </i> New Retailer</a>
						<a type="button" href="/RealRetailers/ListRetailers/List/All" class="btn btn-cancel" style="float: right;">Back</a>
						<h2 class="m-b-0">Retailers List </h2>
						<div class="table-wrap">
							<div class="table-responsive">
								<table class="table table-hover display  pb-30">
									<thead>
										<tr>
											<th>Name</th>
											<th>Address</th>
											<th>Territory</th>
											<th>Zone</th>
											<th>Type</th>
											<!-- <th>ARPU</th> -->
											<th>Assigned To</th>
											<th style="width: 80px">Actions</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Name</th>
											<th>Address</th>
											<th>Territory</th>
											<th>Zone</th>
											<th>Type</th>
											<!-- <th>ARPU</th> -->
											<th>Assigned To</th>
											<th style="width: 80px">Actions</th>
										</tr>
									</tfoot>
									<tbody>
										<?php foreach ($Distributors as $retailer) : ?>
										<tr>
											<td>
												<?= $retailer->retailer_name; ?>
											</td>
											<td>
												<?= $retailer->retailer_address; ?>
											</td>
											<td>
												<?= $retailer->territory_name; ?>
											</td>
											<td>
												<select class="form-control" id="zone_select">
													<?php foreach($zones as $z): ?>
													<option value="<?= $z->id ?>" <?=($retailer->zone_id == $z->id) ? "selected" : "" ?> >
														<?= $z->zone_name; ?>
													</option>
													<?php endforeach; ?>
												</select>
											</td>
											<td>
												<?= $retailer->retailer_type; ?>
											</td>
											<!-- <td>
												 //$retailer->avg_revenue ? $retailer->avg_revenue : 'NA'; 
											</td> -->
											<td>
												<?= $retailer->assigned_to ? $retailer->assigned_to : "Unassigned"; ?>
											</td>
											<td>
												<a href="<?= base_url('RealRetailers/UpdateRetailer/'.$retailer->id); ?>">
													<i class="fa fa-pencil"></i>
												</a>
												<a class="view-report" href="<?=base_url('RealRetailers/RetailerProfile/' . $retailer->id);?>">
													View Profile
												</a>
												<a class="deleteConfirmation" href="<?= base_url('RealRetailers/DeleteRetailer/'.$retailer->id.'/'.$this->uri->segment(4)); ?>">
													<i class="fa fa-close"></i>
												</a>
												<a class="saveZone" id="<?= $retailer->id; ?>">
													<i class="fa fa-check"></i>
												</a>
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
		$(document).on('click', '.saveZone', function () {
			var thisRef = $(this);
			$.ajax({
				type: "GET",
				url: "/RealRetailers/SaveZone/" + $('#zone_select').val() + '/' + thisRef.attr('id'),
				success: function (response) {
					if (response) {
						$('#zoneAssignedAlert').fadeIn();
						setTimeout(() => {
							$('#zoneAssignedAlert').fadeOut();
						}, 2000);
					}
				}
			});
		});
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
