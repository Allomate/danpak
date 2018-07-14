<footer class="footer" style="position: relative !important;">
	<div class="container">
		<div class="row">
			<div class="col-md-12 align-center">
				<p>2018 &copy; Allomate All rights reserved</p>
			</div>
		</div>
	</div>
</footer>

<div class="overlay" style="background-color: rgba(240, 224, 224, 0.7); bottom: 0; left: 0; position: fixed; right: 0; top: 0;bottom: 0;left: 0; position: fixed; right: 0; top: 0; display: none">
	<img src="<?= base_url('assets/images/table-loader.gif'); ?>" style="display: block; margin: 0 auto; width: auto; position: absolute; top: 40%; left: 50%; height: 50px;">
</div>

<script src="<?= base_url('assets/vendors/bower_components/jquery/dist/jquery.min.js');?> "></script>
<script src="<?= base_url('assets/vendors/bower_components/jquery.steps/build/jquery.steps.js?v=1.0');?> "></script>
<script src="<?= base_url('assets/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js');?> "></script>
<script src="<?= base_url('assets/dist/js/form-wizard-data.js');?> "></script>
<script src="<?= base_url('assets/vendors/bower_components/dropify/dist/js/dropify.min.js');?> "></script>
<script src="<?= base_url('assets/dist/js/form-file-upload-data.js');?> "></script>
<script src="<?= base_url('assets/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js'); ?> "></script>
<script src="<?= base_url('assets/dist/js/dataTables-data.js'); ?> "></script>
<script src="<?= base_url('assets/vendors/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js'); ?> "></script>
<script type="text/javascript" src="<?= base_url('assets/vendors/bower_components/moment/min/moment-with-locales.min.js'); ?> "></script>
<script src="<?= base_url('assets/vendors/bower_components/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js'); ?> "></script>
<script type="text/javascript" src="<?= base_url('assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js'); ?> "></script>
<script src="<?= base_url('assets/dist/js/jquery.slimscroll.js'); ?> "></script>
<script src="<?= base_url('assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.min.js'); ?> "></script>
<script src="<?= base_url('assets/vendors/bower_components/owl.carousel/dist/owl.carousel.min.js'); ?> "></script>
<script src="<?= base_url('assets/vendors/bower_components/multiselect/js/jquery.multi-select.js'); ?> "></script>
<script src="<?= base_url('assets/vendors/bower_components/nestable2/jquery.nestable.js'); ?> "></script>
<script src="<?= base_url('assets/dist/js/nestable-data.js'); ?> "></script>
<script src="<?= base_url('assets/dist/js/dropdown-bootstrap-extended.js'); ?> "></script>
<script src="<?= base_url('assets/dist/js/init.js'); ?> "></script>
<script src="<?= base_url('assets/multi/multi.min.js'); ?> "></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.18.0/sweetalert2.all.min.js"></script>
<script type="text/javascript">
	$(document).ready(function () {
		var pathname = window.location.pathname;
		if (pathname.indexOf("DashboardHrm") == -1 && pathname.indexOf("Dashboardv1") == -1) {
			$('.table').DataTable();
		}
	});

</script>
<script src="<?= base_url('assets/js/sidebar.js?v='.time()); ?>"></script>

</body>

</html>
