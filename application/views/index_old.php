<?php require_once(APPPATH.'/views/includes/header.php'); ?>

<div id="topHeader" style="height: 80px; background-color: #9e9ad6; color: white; text-align: center;">
	<h3 style="line-height: 80px">DASHBOARD</h3>
</div>

<div class="container" style="margin-top: 30px">
	<h3>Employee Management</h3>
	<a href="<?= base_url('Employees/ListEmployees');?>">
		<button type="button" class="btn btn-success">Employee Management</button>
	</a>
	<hr>
	<h3>Bulletin Management</h3>
	<a href="<?= base_url('Bulletins/ListGroups');?>">
		<button type="button" class="btn btn-success">Groups Management</button>
	</a>
	<a href="<?= base_url('Bulletins/ListMessages');?>">
		<button type="button" class="btn btn-success">Message Broadcast</button>
	</a>
	<hr>
	<h3>Inventory Management</h3>
	<a href="<?= base_url('Inventory/ListInventory');?>">
		<button type="button" class="btn btn-success">Inventory Management</button>
	</a>
	<a href="<?= base_url('Inventory/ListSubInventory');?>">
		<button type="button" class="btn btn-success">Sub-Inventory Management</button>
	</a>
	<a href="<?= base_url('Inventory/ListUnits');?>">
		<button type="button" class="btn btn-success">Unit Types Management</button>
	</a>
	<hr>
	<h3>Category Management</h3>
	<a href="<?= base_url('Categories/ListMainCategories');?>">
		<button type="button" class="btn btn-success">Main Categories Management</button>
	</a>
	<a href="<?= base_url('Categories/ListSubCategories');?>">
		<button type="button" class="btn btn-success">Sub Categories Management</button>
	</a>
	<hr>
	<h3>Territory, Area & Region Management</h3>
	<a href="<?= base_url('Territories/ListTerritories');?>">
		<button type="button" class="btn btn-success">Territory Management</button>
	</a>
	<a href="<?= base_url('Regions/ListRegions');?>">
		<button type="button" class="btn btn-success">Region Management</button>
	</a>
	<a href="<?= base_url('Areas/ListAreas');?>">
		<button type="button" class="btn btn-success">Area Management</button>
	</a>
	<hr>
	<h3>Catalogue Management</h3>
	<a href="<?= base_url('Catalogue/ViewCatalogues');?>">
		<button type="button" class="btn btn-success">Catalogue Management</button>
	</a>
	<hr>
	<h3>Distributor Management</h3>
	<a href="<?= base_url('Retailers/ListRetailers');?>">
		<button type="button" class="btn btn-success">Distributor Management</button>
	</a>
	<a href="<?= base_url('Retailers/ListRetailerTypes');?>">
		<button type="button" class="btn btn-success">Distributor Type Management</button>
	</a>
	<a href="<?= base_url('Retailers/ListRetailersAssignments');?>">
		<button type="button" class="btn btn-success">Distributors Assignment</button>
	</a>
	<hr>
	<h3>Orders Management</h3>
	<a href="<?= base_url('Orders/ListOrders');?>">
		<button type="button" class="btn btn-success">Orders Management</button>
	</a>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
