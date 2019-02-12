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

			<div class="row p-t-20">
				<div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
					<div class="panel panel-default card-view pa-0 emp-stats pr-box">
						<div class="panel-wrapper collapse in">
							<div class="panel-body pa-0">
								<div class="sm-data-box">
									<div class="container-fluid">
										<div class="row">
											<div class="col-sm-7 col-xs-8 text-center pl-0 pr-0 data-wrap-left">
												<span class="txt-dark block counter">
													<?= $AttendanceStats["present_today"]; ?></span>
												<span class="weight-500 uppercase-font block">Present Today</span>
											</div>
											<div class="col-sm-5 col-xs-4 text-center  pl-0 pr-0">
												<img src="<?= base_url('assets/images/icon-present-employees.svg'); ?>" alt="brand" />
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
					<div class="panel panel-default card-view pa-0 emp-stats absent-box">
						<div class="panel-wrapper">
							<div class="panel-body pa-0">
								<div class="sm-data-box">
									<div class="container-fluid">
										<div class="row">
											<div class="col-sm-7 col-xs-8 text-center pl-0 pr-0 data-wrap-left">
												<span class="txt-dark block counter">
													<?= $AttendanceStats["absent_today"]; ?></span>
												<span class="weight-500 uppercase-font block">Absent Today</span>
											</div>
											<div class="col-sm-5 col-xs-4 text-center  pl-0 pr-0">
												<img src="<?= base_url('assets/images/icon-absent-employees.svg'); ?>" alt="brand" />
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
					<div class="panel panel-default card-view pa-0 emp-stats blue-box">
						<div class="panel-wrapper collapse in">
							<div class="panel-body pa-0">
								<div class="sm-data-box">
									<div class="container-fluid">
										<div class="row">
											<div class="col-sm-7 col-xs-8 text-center pl-0 pr-0 data-wrap-left">
												<span class="txt-dark block counter">
													<?= $AttendanceStats["location_compliance"]; ?></span>
												<span class="weight-500 uppercase-font block">Location Compliance</span>
											</div>
											<div class="col-sm-5 col-xs-4 text-center  pl-0 pr-0">
												<img src="<?= base_url('assets/images/icon-location.svg'); ?>" alt="brand" />
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
					<div class="panel panel-default card-view pa-0 emp-stats total-box">
						<div class="panel-wrapper collapse in">
							<div class="panel-body pa-0">
								<div class="sm-data-box">
									<div class="container-fluid">
										<div class="row">
											<div class="col-sm-7 col-xs-8 text-center pl-0 pr-0 data-wrap-left">
												<span class="txt-dark block counter">
													<?= $AttendanceStats["none_compliance"]; ?></span>
												<span class="weight-500 uppercase-font block">None Compliance</span>
											</div>
											<div class="col-sm-5 col-xs-4 text-center  pl-0 pr-0">
												<img src="<?= base_url('assets/images/icon-error-location.svg'); ?>" alt="brand" />
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="box-white p-20">
						<h2 class="m-b-0">Employee Attendance</h2>
						<div class="table-wrap">
							<div class="table-responsive">
								<table class="table table-hover display  pb-30">
									<thead>
										<tr>
											<th>Date</th>
											<th>Employee ID</th>
											<th>Name</th>
											<th>Region</th>
											<th>Area</th>
											<th>Territory</th>
											<th>Check In time</th>
											<th>Check out Time</th>
											<th>Attendance within circle</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Date</th>
											<th>Employee ID</th>
											<th>Name</th>
											<th>Region</th>
											<th>Area</th>
											<th>Territory</th>
											<th>Check In time</th>
											<th>Check out Time</th>
											<th>Attendance within circle</th>
											<th>Actions</th>
										</tr>
									</tfoot>
									<tbody>
										<?php foreach($AttendanceData as $data) :
										// echo "<pre>";print_r($data["date"]);
										for ($i=0; $i < sizeof($data["data"]); $i++) : ?>
										<tr>
											<td>
												<?= $data["date"]; ?>
											</td>
											<td>
												<?= $data["data"][$i]->employee_name; ?>
											</td>
											<td>
												<?= $data["data"][$i]->employee_name; ?>
											</td>
											<td>
												<?= $data["data"][$i]->region; ?>
											</td>
											<td>
												<?= $data["data"][$i]->area; ?>
											</td>
											<td>
												<?= $data["data"][$i]->territory; ?>
											</td>
											<td>
												<?= $data["data"][$i]->check_in_time; ?>
											</td>
											<td>
												<?= $data["data"][$i]->check_out_time; ?>
											</td>
											<td>
												<?= $data["data"][$i]->within_radius; ?>
											</td>
											<td>
												<?php if($data["data"][$i]->check_in_time != "Not checked in") : ?>
												<input type="text" id="empLats" value="<?= $data[" data"][$i]->check_in_lat; ?>" hidden>
												<input type="text" id="empLongs" value="<?= $data[" data"][$i]->check_in_long; ?>" hidden>
												<input type="text" id="empBaseLats" value="<?= $data[" data"][$i]->employee_base_station_lats; ?>" hidden>
												<input type="text" id="empBaseLongs" value="<?= $data[" data"][$i]->employee_base_station_longs; ?>"
												hidden>
												<a class="view-report" id="viewDetail" style="cursor: pointer">View Detail</a>
												<?php else: ?>
												<a class="view-report" id="nonchecked">Not checked in</a>
												<?php endif; ?>
											</td>
										</tr>
										<?php endfor;
									endforeach; ?>
									</tbody>
								</table>
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
	<input type="text" value="<?= base_url('assets/images/base-station.png'); ?>" id="baseStation" hidden>
	<input type="text" value="<?= base_url('assets/images/attendance-location.png'); ?>" id="attendaceLocation" hidden>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script>
	$(document).ready(function () {
		$(document).on('click', '#viewDetail', function () {
			var lats = $(this).parent().find('#empLats').val();
			var longs = $(this).parent().find('#empLongs').val();
			var baseLats = $(this).parent().find('#empBaseLats').val();
			var baseLongs = $(this).parent().find('#empBaseLongs').val();
			$('#myModal').modal('show');
			// load(lats, longs, baseLats, baseLongs);
			initMap(lats, longs, baseLats, baseLongs, $('#baseStation').val(), $('#attendaceLocation').val());
		});
	});

	function initMap(lats, longs, baseLats, baseLongs, baseStation, attendaceLocation) {
		var uluru = {
			lat: parseFloat(lats),
			lng: parseFloat(longs)
		};
		var map = new google.maps.Map(document.getElementById('map'), {
			zoom: 18,
			center: uluru
		});

		for (var i = 0; i < 2; i++) {
			if (i == 0) {
				marker = new google.maps.Marker({
					position: new google.maps.LatLng(lats, longs),
					title: "Attendance Location",
					map: map,
					animation: google.maps.Animation.DROP,
					icon: attendaceLocation
				});

				google.maps.event.addListener(marker, 'click', function (e) {
					infowindow.setContent(this.name);
					infowindow.open(map, this);
				}.bind(marker));
			} else {
				marker = new google.maps.Marker({
					position: new google.maps.LatLng(baseLats, baseLongs),
					title: "Base Station",
					map: map,
					animation: google.maps.Animation.DROP,
					icon: baseStation
				});

				google.maps.event.addListener(marker, 'click', function (e) {
					infowindow.setContent(this.name);
					infowindow.open(map, this);
				}.bind(marker));
			}
		}

	}

	// function load(lat, lng, baseLat, baseLong) {
	// 	var map = new google.maps.Map(
	// 		document.getElementById("map"),
	// 		{zoom: 14, mapTypeId: google.maps.MapTypeId.HYBRID}
	// 		);

	// 	var infoWindow = new google.maps.InfoWindow;
	// 	var type = "house";
	// 	var dist = "500";
	// 	var point = new google.maps.LatLng(
	// 		parseFloat(lat),
	// 		parseFloat(lng));
	// 	var html = "Radius: " + dist + "m";
	// 	var marker = new google.maps.Marker({
	// 		map: map,
	// 		position: point,
	// 		icon: $('#baseStation').val(),
	// 		shadow: "http://labs.google.com/ridefinder/images/mm_20_shadow.png"
	// 	});

	// 	bindInfoWindow(marker, map, infoWindow, html);
	// 	map.setCenter(new google.maps.LatLng(lat, lng));
	// }

	// function bindInfoWindow(marker, map, infoWindow, html) {
	// 	google.maps.event.addListener(marker, 'click', function() {
	// 		infoWindow.setContent(html);
	// 		infoWindow.open(map, marker);
	// 	});
	// }

	// function downloadUrl(url, callback) {
	// 	var request = window.ActiveXObject ?
	// 	new ActiveXObject('Microsoft.XMLHTTP') :
	// 	new XMLHttpRequest;

	// 	request.onreadystatechange = function() {
	// 		if (request.readyState == 4) {
	// 			request.onreadystatechange = doNothing;
	// 			callback(request, request.status);
	// 		}
	// 	};

	// 	request.open('GET', url, true);
	// 	request.send(null);
	// }

	// function doNothing() {}

</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBn18w20jx4MkFCQ_UtR1rVbgLFZshuBsw">
</script>
