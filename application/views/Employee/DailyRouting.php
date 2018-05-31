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
					for (var i = 0; i < response.length; i++) {
						if (jQuery.inArray(response[i].route_lats, latRepeated) != -1) {
							if (lngRepeated[jQuery.inArray(response[i].route_lats, latRepeated)] == response[i].route_longs) {
								repeatCounter++;
								continue;
							}
						}
						latRepeated.push(response[i].route_lats);
						lngRepeated.push(response[i].route_longs);
						completeLocations.push([parseFloat(response[i].route_lats), parseFloat(response[i].route_longs)]);
						if (i == 1) {
							centerLat = parseFloat(response[i].route_lats);
							centerLng = parseFloat(response[i].route_longs);
						}
					}
					for (var i = 0; i < completeLocations.length; i++) {
						stations.push({
							lat: completeLocations[i][0],
							lng: completeLocations[i][1],
							name: 'Location ' + (i + 1)
						});
					}
					initMap();
				}
			});
		});

	});

	// function initialize() {
	// 	directionsDisplay = new google.maps.DirectionsRenderer();
	// 	var map = new google.maps.Map(document.getElementById('map'), {
	// 		zoom: 13,
	// 		center: new google.maps.LatLng(centerLat, centerLng),
	// 	});
	// 	directionsDisplay.setMap(map);
	// 	var infowindow = new google.maps.InfoWindow();
	// 	var marker, i;
	// 	var request = {
	// 		travelMode: google.maps.TravelMode.DRIVING
	// 	};
	// 	for (i = 0; i < locations.length; i++) {
	// 		marker = new google.maps.Marker({
	// 			position: new google.maps.LatLng(locations[i][1], locations[i][2]),
	// 		});

	// 		google.maps.event.addListener(marker, 'click', (function (marker, i) {
	// 			return function () {
	// 				infowindow.setContent(locations[i][0]);
	// 				infowindow.open(map, marker);
	// 			}
	// 		})(marker, i));

	// 		if (i == 0) {
	// 			request.origin = marker.getPosition();
	// 		} else if (i == locations.length - 1) {
	// 			request.destination = marker.getPosition();
	// 		} else {
	// 			if (!request.waypoints) {
	// 				request.waypoints = [];
	// 			}
	// 			request.waypoints.push({
	// 				location: marker.getPosition(),
	// 				stopover: true
	// 			});
	// 		}

	// 	}
	// 	directionsService.route(request, function (result, status) {
	// 		if (status == google.maps.DirectionsStatus.OK) {
	// 			directionsDisplay.setDirections(result);
	// 		}
	// 	});
	// }

	function initMap() {
		var service = new google.maps.DirectionsService;
		var map = new google.maps.Map(document.getElementById('map'));

		// list of points
		// var stations = [{
		// 		lat: 48.9812840,
		// 		lng: 21.2171920,
		// 		name: 'Station 1'
		// 	},
		// 	{
		// 		lat: 48.9832841,
		// 		lng: 21.2176398,
		// 		name: 'Station 2'
		// 	},
		// 	{
		// 		lat: 48.9856443,
		// 		lng: 21.2209088,
		// 		name: 'Station 3'
		// 	},
		// 	{
		// 		lat: 48.9861461,
		// 		lng: 21.2261563,
		// 		name: 'Station 4'
		// 	},
		// 	{
		// 		lat: 48.9874682,
		// 		lng: 21.2294855,
		// 		name: 'Station 5'
		// 	},
		// 	{
		// 		lat: 48.9909244,
		// 		lng: 21.2295512,
		// 		name: 'Station 6'
		// 	},
		// 	{
		// 		lat: 48.9928871,
		// 		lng: 21.2292352,
		// 		name: 'Station 7'
		// 	},
		// 	{
		// 		lat: 48.9921334,
		// 		lng: 21.2246742,
		// 		name: 'Station 8'
		// 	},
		// 	{
		// 		lat: 48.9943196,
		// 		lng: 21.2234792,
		// 		name: 'Station 9'
		// 	},
		// 	{
		// 		lat: 48.9966345,
		// 		lng: 21.2221262,
		// 		name: 'Station 10'
		// 	},
		// 	{
		// 		lat: 48.9981191,
		// 		lng: 21.2271386,
		// 		name: 'Station 11'
		// 	},
		// 	{
		// 		lat: 49.0009168,
		// 		lng: 21.2359527,
		// 		name: 'Station 12'
		// 	},
		// 	{
		// 		lat: 49.0017950,
		// 		lng: 21.2392890,
		// 		name: 'Station 13'
		// 	},
		// 	{
		// 		lat: 48.9991912,
		// 		lng: 21.2398272,
		// 		name: 'Station 14'
		// 	},
		// 	{
		// 		lat: 48.9959850,
		// 		lng: 21.2418410,
		// 		name: 'Station 15'
		// 	},
		// 	{
		// 		lat: 48.9931772,
		// 		lng: 21.2453901,
		// 		name: 'Station 16'
		// 	},
		// 	{
		// 		lat: 48.9963512,
		// 		lng: 21.2525850,
		// 		name: 'Station 17'
		// 	},
		// 	{
		// 		lat: 48.9985134,
		// 		lng: 21.2508423,
		// 		name: 'Station 18'
		// 	},
		// 	{
		// 		lat: 49.0085000,
		// 		lng: 21.2508000,
		// 		name: 'Station 19'
		// 	},
		// 	{
		// 		lat: 49.0093000,
		// 		lng: 21.2528000,
		// 		name: 'Station 20'
		// 	},
		// 	{
		// 		lat: 49.0103000,
		// 		lng: 21.2560000,
		// 		name: 'Station 21'
		// 	},
		// 	{
		// 		lat: 49.0112000,
		// 		lng: 21.2590000,
		// 		name: 'Station 22'
		// 	},
		// 	{
		// 		lat: 49.0124000,
		// 		lng: 21.2620000,
		// 		name: 'Station 23'
		// 	},
		// 	{
		// 		lat: 49.0135000,
		// 		lng: 21.2650000,
		// 		name: 'Station 24'
		// 	},
		// 	{
		// 		lat: 49.0149000,
		// 		lng: 21.2680000,
		// 		name: 'Station 25'
		// 	},
		// 	{
		// 		lat: 49.0171000,
		// 		lng: 21.2710000,
		// 		name: 'Station 26'
		// 	},
		// 	{
		// 		lat: 49.0198000,
		// 		lng: 21.2740000,
		// 		name: 'Station 27'
		// 	},
		// 	{
		// 		lat: 49.0305000,
		// 		lng: 21.3000000,
		// 		name: 'Station 28'
		// 	},
		// 	// ... as many other stations as you need
		// ];

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
			new google.maps.Marker({
				position: stations[i],
				map: map,
				title: stations[i].name
			});
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
