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
			<div class="row" style="margin-top: 20px">
				<div class="table-responsive">
					<table class="table table-hover display  pb-30">
						<thead>
							<tr>
								<th>Date</th>
								<th>Employee Username</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Date</th>
								<th>Employee Username</th>
								<th>Actions</th>
							</tr>
						</tfoot>
						<tbody>
							<?php foreach($routing as $route) : ?>
							<tr>
								<td>
									<?= $route->route_date; ?>
								</td>
								<td>
									<?= $route->employee_username; ?>
								</td>
								<td>
									<button class="view-report" id="<?= $route->employee_id; ?>">View Activity</button>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
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
	<input type="text" value="<?= base_url('Employees/GetDailyRouteLatLongsAjax'); ?>" id="getLatLongs" hidden>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script>
	var map;
	var directionsDisplay;
	var directionsService = null;
	var stations = [];
	var centerLat = null;
	var centerLng = null;

	$(document).ready(function () {
		$(document).on('click', '.view-report', function () {
			stations = [];
			directionsService = new google.maps.DirectionsService();
			var empId = $(this).attr('id');
			var currDate = $(this).parent().parent().find('td:eq(0)').text();
			$.ajax({
				type: 'POST',
				url: $('#getLatLongs').val(),
				data: {
					employee_id: empId,
					curr_date: currDate
				},
				success: function (response) {
					var response = JSON.parse(response);
					var completeLocations = [];
					var latRepeated = [];
					var lngRepeated = [];
					var repeatCounter = 0;
					for (var i = 0; i < response.data.length; i++) {
						if (jQuery.inArray(response.data[i].route_lats, latRepeated) != -1) {
							if (lngRepeated[jQuery.inArray(response.data[i].route_lats, latRepeated)] == response.data[i].route_longs) {
								repeatCounter++;
								continue;
							}
						}
						latRepeated.push(response.data[i].route_lats);
						lngRepeated.push(response.data[i].route_longs);
						if (i == 0) {
							completeLocations.push([parseFloat(response.attendance.route_lats), parseFloat(response.attendance.route_longs),
								"", ""
							]);
						} else {
							completeLocations.push([parseFloat(response.data[i].route_lats), parseFloat(response.data[i].route_longs),
								response.data[i].took_order, response.data[i].retailer_name
							]);
						}
						if (i == 1) {
							centerLat = parseFloat(response.data[i].route_lats);
							centerLng = parseFloat(response.data[i].route_longs);
						}
					}

					for (var i = 0; i < completeLocations.length; i++) {
						stations.push({
							lat: completeLocations[i][0],
							lng: completeLocations[i][1],
							name: completeLocations[i][3],
							took_order: completeLocations[i][2]
						});
					}
					initMap();
				}
			});
		});

	});

	function initMap() {
		var service = new google.maps.DirectionsService;
		var map = new google.maps.Map(document.getElementById('map'), {
			zoom: 18
		});

		// Zoom and center map automatically by stations (each station will be in visible map area)
		var lngs = stations.map(function (station) {
			return station.lng;
		});
		var lats = stations.map(function (station) {
			return station.lat;
		});

		map.fitBounds({
			west: Math.min.apply(null, lngs),
			east: Math.max.apply(null, lngs),
			north: Math.min.apply(null, lats),
			south: Math.max.apply(null, lats),
		});
		// Show stations on the map as markers
		for (var i = 0; i < stations.length; i++) {
			if (i == 0) {
				new google.maps.Marker({
					position: stations[i],
					map: map,
					icon: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png",
					animation: google.maps.Animation.DROP,
					title: "Attendance Location"
				});
			} else {
				if (stations[i].took_order == "1") {
					new google.maps.Marker({
						position: stations[i],
						map: map,
						icon: "http://maps.google.com/mapfiles/ms/icons/green-dot.png",
						animation: google.maps.Animation.DROP,
						title: stations[i].name
					});
				} else {
					new google.maps.Marker({
						position: stations[i],
						map: map,
						icon: "http://maps.google.com/mapfiles/ms/icons/red-dot.png",
						animation: google.maps.Animation.DROP,
						title: stations[i].name
					});
				}
			}
		}

		// Divide route to several parts because max stations limit is 25 (23 waypoints + 1 origin + 1 destination)
		for (var i = 0, parts = [], max = 25 - 1; i < stations.length; i = i + max)
			parts.push(stations.slice(i, i + max + 1));

		// Service callback to process service results
		var service_callback = function (response, status) {
			if (status != 'OK') {
				console.log('Directions request failed due to ' + status);
				return;
			}
			var renderer = new google.maps.DirectionsRenderer;
			renderer.setMap(map);
			renderer.setOptions({
				suppressMarkers: true,
				preserveViewport: true
			});
			renderer.setDirections(response);
		};

		// Send requests to service to get route (for stations count <= 25 only one request will be sent)
		for (var i = 0; i < parts.length; i++) {
			// Waypoints does not include first station (origin) and last station (destination)
			var waypoints = [];
			for (var j = 1; j < parts[i].length - 1; j++)
				waypoints.push({
					location: parts[i][j],
					stopover: false
				});
			// Service options
			$('#myModal').modal('show');
			var service_options = {
				origin: parts[i][0],
				destination: parts[i][parts[i].length - 1],
				waypoints: waypoints,
				travelMode: 'WALKING'
			};
			// Send request
			service.route(service_options, service_callback);
		}
	}

</script>

<!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap"></script> -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAap-vz0Ju0d3oO8eAhdwFfIvjaautw-eU&callback=initMap"></script>
