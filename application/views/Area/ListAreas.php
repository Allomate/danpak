<?php require_once(APPPATH.'/views/includes/header.php'); ?>
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
	<?php require_once(APPPATH.'/views/includes/navbar&sidebar.php'); ?>
	<div class="page-wrapper">
		<div class="container-fluid">
			<?php if ($feedback = $this->session->flashdata('area_added')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Added</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('area_add_failed')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Failed</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('area_updated')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Updated</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('area_update_failed')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Failed</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('area_deleted')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Deleted</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('area_delete_failed')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Failed</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<div class="row heading-bg">
				<div class="col-lg-6 col-md-6">
					<h2 class="m-heading">Area Management</h2>
				</div>
				<div class="col-lg-6 col-md-6">
					<ol class="breadcrumb">

						<li><a href="#"><span>Organization</span></a></li>
						<li><span>Area Management</span></li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="box-white p-20"><a href="<?= base_url('Areas/AddArea');?>" class="btn add-emp"><i class="fa fa-plus"> </i> New Area</a>
						<h2 class="m-b-0">Areas List </h2>
						<div class="table-wrap">
							<div class="table-responsive">
								<table  class="table table-hover display  pb-30" >
									<thead>
										<tr>
											<th>Name</th>
											<th>Area Poc</th>
											<th>Region</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Name</th>
											<th>Area Poc</th>
											<th>Region</th>
											<th>Actions</th>
										</tr>
									</tfoot>
									<tbody>
										<?php foreach ($Areas as $area) : ?>
											<tr>
												<td><?= $area->area_name; ?></td>
												<td><?= $area->area_poc; ?></td>
												<td><?= $area->region_name; ?></td>
												<td>
													<a href="<?= base_url('Areas/UpdateArea/'.$area->id); ?>"><i class="fa fa-pencil"></i></a>
													&nbsp;
													<a class="deleteConfirmation" href="<?= base_url('Areas/DeleteArea/'.$area->id); ?>"><i class="fa fa-close"></i></a>
													<a class="view-report viewDetail" id="<?= $area->id; ?>" style="cursor: pointer">View Detail</a>
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
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Distributors/Retailers Locations</h4>
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
<input type="text" id="urlForAjaxCall" value="<?= base_url('Areas/ReturnMerchantsInArea'); ?>" hidden>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script type="text/javascript">
	$(document).ready(function(){

		$(document).on('click', '.viewDetail', function(){
			var lats = [];
			var longs = [];
			var areaId = $(this).attr('id');
			$.ajax({
				type: 'POST',
				data: { area_id: areaId },
				url: $('#urlForAjaxCall').val(),
				success: function(response){
					var response = JSON.parse(response);
					for(var i = 0; i < response.length; i++){
						lats.push(response[i].retailer_lats);
						longs.push(response[i].retailer_longs);
					}
					$('#myModal').modal('show');
					initMap(lats, longs);
				}
			});
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

	function initMap(lats, longs) {
		var uluru = {lat: parseFloat(lats[0]), lng: parseFloat(longs[0])};
		var map = new google.maps.Map(document.getElementById('map'), {
			zoom: 15,
			center: uluru
		});

		for (var i = 0; i < lats.length; i++) {
			marker = new google.maps.Marker({
				position: new google.maps.LatLng(lats[i],longs[i]),
				title: "Area",
				map: map,
				animation: google.maps.Animation.DROP
			}); 

			google.maps.event.addListener( marker, 'click', function(e){
				infowindow.setContent( this.name );
				infowindow.open( map, this );
			}.bind( marker ) );
		}
	}
</script>
<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAap-vz0Ju0d3oO8eAhdwFfIvjaautw-eU">
</script>