<?php require_once(APPPATH.'/views/includes/header.php'); ?>
<!-- <div class="preloader-it">
	<div class="la-anim-1"></div>
</div> -->
<div class="wrapper theme-1-active">
	<?php require_once(APPPATH.'/views/includes/navbar&sidebar.php'); ?>
	<?php require_once(APPPATH.'/views/includes/home-sidebar-data.php'); ?>
	<div class="page-wrapper">
		<div class="container">
			<div class="row m-t-30">
				<div class="col-md-12 align-center">
					<h1 class="txt-dark uppercase-font f_size">Sales and Distributor</h1>
					<h3 class="txt-grey">Management System</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 m-t-30">
					<a style="cursor: pointer" class="Dashboardv1" id="open_right_sidebar">
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
							<div class="box-sec">
								<span class="icon-dash2-icon"></span>
								<h2>Dashboard</h2>
							</div>
						</div>
					</a>
					<a style="cursor: pointer" class="Organization" id="open_right_sidebar">
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
							<div class="box-sec">
								<span class="icon-emp2-icon"></span>
								<h2>Organization Management</h2>
							</div>
						</div>
					</a>
					<a style="cursor: pointer" class="ListEmployees" id="open_right_sidebar">
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
							<div class="box-sec">
								<span class="img-svg">
									<img src="<?= base_url('assets/images/sale-icon-home.svg'); ?>" alt="" />
								</span>
								<h2>Sales Force Management</h2>
							</div>
						</div>
					</a>
					<a style="cursor: pointer" class="ListInventory" id="open_right_sidebar">
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
							<div class="box-sec">
								<span class="icon-inv2-icon"></span>
								<h2>Inventory Management</h2>
							</div>
						</div>
					</a>
					<a style="cursor: pointer" class="ViewCatalogues" id="open_right_sidebar">
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
							<div class="box-sec">
								<span class="icon-cat2-icon"></span>
								<h2>Catalogue Management</h2>
							</div>
						</div>
					</a>
					<a style="cursor: pointer" class="ListRetailers" id="open_right_sidebar">
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
							<div class="box-sec">
								<span class="icon-ret2-icon"></span>
								<h2>Retailers Management</h2>
							</div>
						</div>
					</a>
					<a style="cursor: pointer" class="ListPrimOrders" id="open_right_sidebar">
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
							<div class="box-sec">
								<span class="icon-ord2-icon"></span>
								<h2>Primary Orders Management </h2>
							</div>
						</div>
					</a>
					<a style="cursor: pointer" class="ListMessages" id="open_right_sidebar">
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
							<div class="box-sec">
								<span class="img-svg">
									<img src="<?= base_url('assets/images/bulletins-icon-home.svg'); ?>" alt="" />
								</span>
								<h2>Bulletins Management</h2>
							</div>
						</div>
					</a>
					<!-- <a style="cursor: pointer" class="Reports" id="open_right_sidebar">
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
							<div class="box-sec">
								<span class="img-svg">
									<img src="<?= base_url('assets/images/reports-icon-home.svg'); ?>" alt="" />
								</span>
								<h2>Reports Management</h2>
							</div>
						</div>
					</a> -->
				</div>
			</div>
		</div>
	</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script type="text/javascript">
	$(document).ready(function () {
		// var backupExist = "<?= $db_backup->exist; ?>";
		// if (!backupExist || backupExist == "0") {
		// 	$.ajax({
		// 		url: '../../db_backup/backup.php'
		// 	});
		// }
	});

</script>
