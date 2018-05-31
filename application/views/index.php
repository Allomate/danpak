<?php require_once(APPPATH.'/views/includes/header.php'); ?>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once(APPPATH.'/views/includes/navbar&sidebar.php'); ?>
	<div class="page-wrapper">
		<div class="container">
			<?php if ($feedback = $this->session->flashdata('order_created')) : ?>
			<div class="row" style="margin-top: 20px;">
				<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
					<strong>Created</strong>
					<?= $feedback; ?>
				</div>
			</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('order_creation_failed')) : ?>
			<div class="row" style="margin-top: 20px;">
				<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
					<strong>Failed</strong>
					<?= $feedback; ?>
				</div>
			</div>
			<?php endif; ?>
			<div class="row m-t-30">
				<div class="col-md-12 align-center">
					<h1 class="txt-dark uppercase-font">Sales and Distributor</h1>
					<h3 class="txt-grey">Management System</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 m-t-30">
					<a href="<?= base_url('Dashboard/Dashboardv1'); ?>">
						<div class="col-md-4">
							<div class="box-sec">
								<span class="icon-dash2-icon"></span>
								<h2>Dashboard</h2>
							</div>
						</div>
					</a>
					<a href="<?= base_url('Employees/ListEmployees'); ?>">
						<div class="col-md-4">
							<div class="box-sec">
								<span class="icon-emp2-icon"></span>
								<h2>Organization Management</h2>
							</div>
						</div>
					</a>
					<a href="<?= base_url('Employees/ListEmployees'); ?>">
						<div class="col-md-4">
							<div class="box-sec">
								<span class="img-svg">
									<img src="<?= base_url('assets/images/sale-icon-home.svg'); ?>" alt="" />
								</span>
								<h2>Sales Force Management</h2>
							</div>
						</div>
					</a>
					<a href="<?= base_url('Inventory/ListInventory'); ?>">
						<div class="col-md-4">
							<div class="box-sec">
								<span class="icon-inv2-icon"></span>
								<h2>Inventory Management</h2>
							</div>
						</div>
					</a>
					<a href="<?= base_url('Catalogue/ViewCatalogues'); ?>">
						<div class="col-md-4">
							<div class="box-sec">
								<span class="icon-cat2-icon"></span>
								<h2>Catalogue Management</h2>
							</div>
						</div>
					</a>
					<a href="<?= base_url('Retailers/ListRetailers'); ?>">
						<div class="col-md-4">
							<div class="box-sec">
								<span class="icon-ret2-icon"></span>
								<h2>Distributor Management</h2>
							</div>
						</div>
					</a>
					<a href="<?= base_url('Orders/ListOrders/Pending'); ?>">
						<div class="col-md-4">
							<div class="box-sec">
								<span class="icon-ord2-icon"></span>
								<h2>Orders Management </h2>
							</div>
						</div>
					</a>
					<a href="<?= base_url('Bulletins/ListMessages'); ?>">
						<div class="col-md-4">
							<div class="box-sec">
								<span class="img-svg">
									<img src="<?= base_url('assets/images/bulletins-icon-home.svg'); ?>" alt="" />
								</span>
								<h2>Bulletins Management</h2>
							</div>
						</div>
					</a>
					<a href="<?= base_url('Dashboard/Reports'); ?>">
						<div class="col-md-4">
							<div class="box-sec">
								<span class="img-svg">
									<img src="<?= base_url('assets/images/reports-icon-home.svg'); ?>" alt="" />
								</span>
								<h2>Reports Management</h2>
							</div>
						</div>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
