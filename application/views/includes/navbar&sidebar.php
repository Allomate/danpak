<nav class="navbar navbar-inverse navbar-fixed-top" style="z-index: 10;">
	<div class="mobile-only-brand pull-left">
		<a id="toggle_nav_btn" class="toggle-left-nav-btn inline-block ml-20 pull-left" href="javascript:void(0);">
			<i class="zmdi zmdi-menu"></i>
		</a>
		<div class="m-logo">
			<a href="<?= base_url('Dashboard/Home'); ?>">
				<img class="brand-img" src="<?= base_url('assets/images/allomate-logo.svg?v=1.0'); ?>" alt="brand" />
			</a>
		</div>
	</div>

	<div id="mobile_only_nav" class="mobile-only-nav pull-right">

		<ul class="nav navbar-right top-nav pull-right">
			<li class="dropdown auth-drp">
				<a href="#" class="dropdown-toggle pr-0" data-toggle="dropdown">
					<img src="<?= base_url(); ?>" alt="" class="user-auth-img img-circle" />
					<span class="user-online-status"></span>
				</a>
				<ul class="dropdown-menu user-auth-dropdown" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
					<li>
						<a href="profile.html">
							<i class="zmdi zmdi-account"></i>
							<span>Profile</span>
						</a>
					</li>

					<li>
						<a href="#">
							<i class="zmdi zmdi-settings"></i>
							<span>Settings</span>
						</a>
					</li>
					<li class="divider"></li>
					<li>
						<a href="<?= base_url('Login/SignOut'); ?>">
							<i class="zmdi zmdi-power"></i>
							<span>Log Out</span>
						</a>
					</li>
				</ul>
			</li>
		</ul>
	</div>
</nav>
<div class="fixed-sidebar-left">
	<ul class="nav navbar-nav side-nav nicescroll-bar">
		<li>
			<li>
				<a href="javascript:void(0);" data-toggle="collapse" data-target="#dashboard_dr">
					<div class="pull-left">
						<i class="icon-dash1-icon mr-20"></i>
						<span class="right-nav-text">Dashboard</span>
					</div>
					<div class="pull-right m-t-5">
						<i class="zmdi zmdi-caret-down"></i>
					</div>
					<div class="clearfix"></div>
				</a>
				<ul id="dashboard_dr" class="innerUl collapse collapse-level-1">
					<li>
						<a href="<?= base_url('Dashboard/Dashboardv1'); ?>">Sales Dashboard</a>
					</li>
					<li>
						<a href="<?= base_url('Dashboard/DashboardHrm'); ?>">Employee Dashboard</a>
					</li>
					<li>
						<a href="<?= base_url('Dashboard/DashboardSales'); ?>">Inventory Analytics</a>
					</li>
					<li>
						<a href="<?= base_url('Dashboard/Reports'); ?>">Reporting</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="javascript:void(0);" data-toggle="collapse" data-target="#org_dr">
					<div class="pull-left">
						<i class="icon-org1-icon mr-20"></i>
						<span class="right-nav-text">Organization</span>
					</div>
					<div class="pull-right m-t-5">
						<i class="zmdi zmdi-caret-down"></i>
					</div>
					<div class="clearfix"></div>
				</a>
				<ul id="org_dr" class="innerUl collapse collapse-level-1">
					<li>
						<a href="<?= base_url('Organization/Profile'); ?>">Company Profile</a>
					</li>
					<li>
						<a href="<?= base_url('Regions/ListRegions');?>">Region</a>
					</li>
					<li>
						<a href="<?= base_url('Areas/ListAreas');?>">Area</a>
					</li>
					<li>
						<a href="<?= base_url('Territories/ListTerritories');?>">Territory</a>
						</i>
					</li>
					<li>
						<a href="<?= base_url('Employees/ListEmployees');?>">Employees</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="javascript:void(0);" data-toggle="collapse" data-target="#sfm_dr">
					<div class="pull-left">
						<i class="zmdi zmdi-chart mr-20"></i>
						<span class="right-nav-text">Sales Force Management</span>
					</div>
					<div class="pull-right m-t-5">
						<i class="zmdi zmdi-caret-down"></i>
					</div>
					<div class="clearfix"></div>
				</a>
				<ul id="sfm_dr" class="innerUl collapse collapse-level-1">
					<li>
						<a href="<?= base_url('Employees/AddEmployee'); ?>">Add New Sales Agent</a>
					</li>
					<li>
						<a href="<?= base_url('Employees/ListEmployees'); ?>">Sales Agent</a>
					</li>
					<li>
						<a href="<?= base_url('Employees/Attendance');?>">Attendance Management</a>
					</li>
					<li>
						<a href="<?= base_url('Orders/ListOrders/EmployeesList/'); ?>">Order Compliance</a>
					</li>
					<li>
						<a href="<?= base_url('Employees/DailyRouting');?>">Daily Routing</a>
					</li>
					<li>
						<a href="<?= base_url('AccRights/ListRights');?>">Access Rights</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="javascript:void(0);" data-toggle="collapse" data-target="#inv_dr">
					<div class="pull-left">
						<i class="icon-inv-icon mr-20"></i>
						<span class="right-nav-text">Inventory Management</span>
					</div>
					<div class="pull-right m-t-5">
						<i class="zmdi zmdi-caret-down"></i>
					</div>
					<div class="clearfix"></div>
				</a>
				<ul id="inv_dr" class="innerUl collapse collapse-level-1">
					<li>
						<a href="<?= base_url('Inventory/AddInventory'); ?>">Add New Product</a>
					</li>
					<li>
						<a href="<?= base_url('Inventory/ListInventory'); ?>">Update Product</a>
					</li>
					<li>
						<a href="<?= base_url('Inventory/ProductGallery'); ?>">Product Gallery</a>
					</li>
					<li>
						<a href="<?= base_url('Inventory/ListSubInventory'); ?>">Sub-Inventory Management</a>
					</li>
					<li>
						<a href="<?= base_url('Inventory/ListUnits'); ?>">Packaging Options</a>
					</li>
					<li>
						<a href="<?= base_url('Categories/ListMainCategories'); ?>">Main Categories</a>
					</li>
					<li>
						<a href="<?= base_url('Categories/ListSubCategories'); ?>">Sub Categories</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="javascript:void(0);" data-toggle="collapse" data-target="#cat_dr">
					<div class="pull-left">
						<i class="icon-cat1-icon mr-20"></i>
						<span class="right-nav-text">Catalogue</span>
					</div>
					<div class="pull-right m-t-5">
						<i class="zmdi zmdi-caret-down"></i>
					</div>
					<div class="clearfix"></div>
				</a>
				<ul id="cat_dr" class="innerUl collapse collapse-level-1">
					<li>
						<a href="<?= base_url('Catalogue/ViewCatalogues');?>">Catalogue Management</a>
					</li>
					<li>
						<a href="<?= base_url('Catalogue/ViewCatalogueAssignments');?>">Catalogue Assignments</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="javascript:void(0);" data-toggle="collapse" data-target="#ret_dr">
					<div class="pull-left">
						<i class="icon-ret1-icon mr-20"></i>
						<span class="right-nav-text">Distributors</span>
					</div>
					<div class="pull-right m-t-5">
						<i class="zmdi zmdi-caret-down"></i>
					</div>
					<div class="clearfix"></div>
				</a>
				<ul id="ret_dr" class="innerUl collapse collapse-level-1">
					<li>
						<a href="<?= base_url('Retailers/ListRetailers'); ?>">Distributors Management</a>
						<a href="<?= base_url('Retailers/ListRetailerTypes'); ?>">Distributor Type Management</a>
						<a href="<?= base_url('Retailers/ListRetailersAssignments'); ?>">Distributors Assignment</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="javascript:void(0);" data-toggle="collapse" data-target="#real_ret_dr">
					<div class="pull-left">
						<i class="icon-ret1-icon mr-20"></i>
						<span class="right-nav-text">Retailers</span>
					</div>
					<div class="pull-right m-t-5">
						<i class="zmdi zmdi-caret-down"></i>
					</div>
					<div class="clearfix"></div>
				</a>
				<ul id="real_ret_dr" class="innerUl collapse collapse-level-1">
					<li>
						<a href="<?= base_url('RealRetailers/ListRetailers'); ?>">Retailers Management</a>
						<a href="<?= base_url('RealRetailers/ListRetailerTypes'); ?>">Retailer Type Management</a>
						<a href="<?= base_url('RealRetailers/ListRetailersAssignments'); ?>">Retailers Assignment</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="javascript:void(0);" data-toggle="collapse" data-target="#ord_dr">
					<div class="pull-left">
						<i class="icon-ord1-icon mr-20"></i>
						<span class="right-nav-text">Orders</span>
					</div>
					<div class="pull-right m-t-5">
						<i class="zmdi zmdi-caret-down"></i>
					</div>
					<div class="clearfix"></div>
				</a>
				<ul id="ord_dr" class="innerUl collapse collapse-level-1">
					<li>
						<a href="<?= base_url('Orders/ManualOrders'); ?>">Order Entry</a>
					</li>
					<!-- <li>
						<a href="<?= base_url('Orders/ListOrders/Latest'); ?>">Today's Orders</a>
					</li> -->
					<li>
						<a href="<?= base_url('Orders/ListOrders/Pending'); ?>">New Orders</a>
					</li>
					<li>
						<a href="<?= base_url('Orders/ListOrders/Processed'); ?>">Processed Orders</a>
					</li>
					<li>
						<a href="<?= base_url('Orders/ListOrders/Completed'); ?>">Completed Orders</a>
					</li>
					<li>
						<a href="<?= base_url('Orders/ListOrders/Cancelled'); ?>">Cancelled Orders</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="javascript:void(0);" data-toggle="collapse" data-target="#bulletins_dr">
					<div class="pull-left">
						<i class="zmdi zmdi-widgets"></i>
						<span class="right-nav-text">Bulletins & Questionnaires</span>
					</div>
					<div class="pull-right m-t-5">
						<i class="zmdi zmdi-caret-down"></i>
					</div>
					<div class="clearfix"></div>
				</a>
				<ul id="bulletins_dr" class="innerUl collapse collapse-level-1">
					<li>
						<a href="<?= base_url('Bulletins/ListGroups'); ?>">Groups Management</a>
					</li>
					<li>
						<a href="<?= base_url('Bulletins/ListMessages'); ?>">Message Broadcast</a>
					</li>
					<li>
						<a href="<?= base_url('Questionnaires/ListQuestionnaires'); ?>">Questionnaires</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="javascript:void(0);" data-toggle="collapse" data-target="#kpi_dr">
					<div class="pull-left">
						<i class="zmdi zmdi-widgets"></i>
						<span class="right-nav-text">KPI Management</span>
					</div>
					<div class="pull-right m-t-5">
						<i class="zmdi zmdi-caret-down"></i>
					</div>
					<div class="clearfix"></div>
				</a>
				<ul id="kpi_dr" class="innerUl collapse collapse-level-1">
					<li>
						<a href="<?= base_url('Kpi/EmpKpi'); ?>">KPI Settings</a>
					</li>
					<li>
						<a href="<?= base_url('Kpi/Hierarchy'); ?>">Hierarchy Tree</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="<?= base_url('CampaignManagement/ListCampaigns');?>">
					<div class="pull-left">
						<i class="zmdi zmdi-chart-donut"></i>
						<span class="right-nav-text">Campaign Management</span>
					</div>
					<div class="clearfix"></div>
				</a>
			</li>
		</li>
	</ul>
</div>
<input type="text" id="getAccRightsUrlAjax" value="<?= base_url('AccRights/GetRightsForLoggedInAdminAjax'); ?>" hidden>
<input type="text" id="getUserProfile" value="<?= base_url('Employees/GetEmployeeProfilePicture'); ?>" hidden>
