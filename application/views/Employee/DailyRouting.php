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
                    <table class="table table-hover display  pb-30" >
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
                                    <td><?= $route->route_date; ?></td>
                                    <td><?= $route->employee_username; ?></td>
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
    var locations = [];
    var centerLat = null;
    var centerLng = null;

	$(document).ready(function(){
		$(document).on('click', '.view-report', function(){
            directionsService = new google.maps.DirectionsService();
            var empId = $(this).attr('id');
            var currDate = $(this).parent().parent().find('td:eq(0)').text();
            $.ajax({
                type: 'POST',
                url: $('#getLatLongs').val(),
                data: { employee_id: empId, curr_date: currDate },
                success: function(response){
                    var response = JSON.parse(response);
                    for(var i = 0; i < response.length; i++){
                        locations.push(['N/A', parseFloat(response[i].route_lats), parseFloat(response[i].route_longs), i+1]);
                        if(i == 1){
                            centerLat = parseFloat(response[i].route_lats);
                            centerLng = parseFloat(response[i].route_longs);
                        }
                    }
                    // google.maps.event.addDomListener(window, "load", initialize);
                    initialize();
                    $('#myModal').modal('show');
                }
            });
		});
        
	});

    function initialize() {
        directionsDisplay = new google.maps.DirectionsRenderer();
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10,
            center: new google.maps.LatLng(centerLat, centerLng),
        });
        directionsDisplay.setMap(map);
        var infowindow = new google.maps.InfoWindow();
        var marker, i;
        var request = {
            travelMode: google.maps.TravelMode.DRIVING
        };
        for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            });

            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
                    infowindow.setContent(locations[i][0]);
                    infowindow.open(map, marker);
                }
            })(marker, i));
            
            if (i == 0){
                request.origin = marker.getPosition();
            } else if (i == locations.length - 1){
                request.destination = marker.getPosition();
            } else {
                if (!request.waypoints){
                    request.waypoints = [];
                }
                request.waypoints.push({
                    location: marker.getPosition(),
                    stopover: true
                });
            }

        }
        directionsService.route(request, function (result, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(result);
            }
        });
    }
</script>
<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAap-vz0Ju0d3oO8eAhdwFfIvjaautw-eU">
</script>
