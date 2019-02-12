<?php require_once(APPPATH.'/views/includes/header.php'); ?>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once(APPPATH.'/views/includes/navbar&sidebar.php'); ?>
	<div class="page-wrapper">
		<div class="container-fluid">
			<div class="row heading-bg">
				<div class="col-lg-6 col-md-6 col-sm-6">
					<h2 class="m-heading">Access Rights Management</h2>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6">
					<ol class="breadcrumb">
						<li>
							<a href="#">
								<span>Organization</span>
							</a>
						</li>
						<li>
							<span>Access Rights Management</span>
						</li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="box-white m-b-30">
						<h2>Update Rights</h2>
						<input type="text" id="updateUrl" value="<?= base_url('AccRights/GetRightsForAdminAjax'); ?>" hidden>
						<input type="text" id="currentRecord" value="<?= $this->uri->segment(3); ?>" hidden>
						<?php $attributes = array('id' => 'updateAccessRightsForm');
                        echo form_open('AccRights/UpdateAccRightsOps/'.$this->uri->segment(3), $attributes); ?>
						<input type="text" name="permisData" id="permisData" hidden>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="p-b-10" for="employee">Select employee</label>
									<?php $options = array('null' => 'Select Employee'); foreach ($Employees as $employee) : 
											$options[$employee->employee_id] = $employee->employee_username;
										endforeach; 
										$atts = array( 'class' => 'form-control' );
										echo form_dropdown('admin_id', $options, $RightsData->admin_id, $atts); ?>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="p-b-10" for="employee">Select Distributor</label>
									<?php $optionsDist = array('null' => 'Select Distributor'); foreach ($Distributors as $distributor) : 
											$optionsDist[$distributor->id] = $distributor->distributor_username;
										endforeach; 
										$atts = array( 'class' => 'form-control' );
										echo form_dropdown('distributor_id', $optionsDist, $RightsData->distributor_id, $atts); ?>
								</div>
							</div>
						</div>
						</form>
						<div class="row">
							<div class="col-md-12">
								<h2 class="p-t-20" for="rights">Access Rights</h2>
								<div class="row">
									<div class="col-md-3 col-sm-6">
										<div class="form-group">
											<h5>Dashboard</h5>
											<div class="form-group p-b-10 p-t-10">
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="dbV1" name="access_rights" value="Dashboardv1">
													<label for="dbV1" class="lab-medium">Sales Dashboard</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="hrm" name="access_rights" value="DashboardHrm">
													<label for="hrm" class="lab-medium">HRMS</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="dbSales" name="access_rights" value="DashboardSales">
													<label for="dbSales" class="lab-medium">DashboardSales</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="reports" name="access_rights" value="Reports">
													<label for="reports" class="lab-medium">Reports</label>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-3 col-sm-6">
										<div class="form-group">
											<h5>Organization</h5>
											<div class="form-group p-b-10 p-t-10">
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="Profile" name="access_rights" value="Profile">
													<label for="Profile" class="lab-medium">Company Profile</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="ListRegions" name="access_rights" value="ListRegions">
													<label for="ListRegions" class="lab-medium">View Regions</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="ListAreas" name="access_rights" value="ListAreas">
													<label for="ListAreas" class="lab-medium">View Areas</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="ListTerritories" name="access_rights" value="ListTerritories">
													<label for="ListTerritories" class="lab-medium">View Territories</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="ListEmployees" name="access_rights" value="ListEmployees">
													<label for="ListEmployees" class="lab-medium">View Employees</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="ListCampaigns" name="access_rights" value="ListCampaigns">
													<label for="ListCampaigns" class="lab-medium">View Campaigns</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="DailyRouting" name="access_rights" value="DailyRouting">
													<label for="DailyRouting" class="lab-medium">View Daily Employee Routes</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="CompleteEmployeeRoutingList" name="access_rights" value="CompleteEmployeeRoutingList">
													<label for="CompleteEmployeeRoutingList" class="lab-medium">Employees List for Routing</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="ListRights" name="access_rights" value="ListRights">
													<label for="ListRights" class="lab-medium">View Access Rights</label>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-3 col-sm-6">
										<div class="form-group">
											<h5>Secondary Order Management</h5>
											<div class="form-group p-b-10 p-t-10">
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="ManualOrders" name="access_rights" value="ManualOrders">
													<label for="ManualOrders" class="lab-medium">Manual Order Entry</label>
												</div>
												<!-- <div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="Latest" name="access_rights" value="Latest">
													<label for="Latest" class="lab-medium">View Today's Orders</label>
												</div> -->
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="Pending" name="access_rights" value="Pending">
													<label for="Pending" class="lab-medium">View Pending Orders</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="Processed" name="access_rights" value="Processed">
													<label for="Processed" class="lab-medium">View Processed Orders</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="Completed" name="access_rights" value="Completed">
													<label for="Completed" class="lab-medium">View Completed Orders</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="Cancelled" name="access_rights" value="Cancelled">
													<label for="Cancelled" class="lab-medium">View Cancelled Orders</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="EmployeesList" name="access_rights" value="EmployeesList">
													<label for="EmployeesList" class="lab-medium">View Order Compliance</label>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-3 col-sm-6">
										<div class="form-group">
											<h5>Primary Order Management</h5>
											<div class="form-group p-b-10 p-t-10">
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="ManualPrimaryOrders" name="access_rights" value="ManualPrimaryOrders">
													<label for="ManualPrimaryOrders" class="lab-medium">Manual Order Entry</label>
												</div>
												<!-- <div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="LatestPrimary" name="access_rights" value="LatestPrimary">
													<label for="LatestPrimary" class="lab-medium">View Today's Orders</label>
												</div> -->
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="PendingPrimary" name="access_rights" value="PendingPrimary">
													<label for="PendingPrimary" class="lab-medium">View Pending Orders</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="ProcessedPrimary" name="access_rights" value="ProcessedPrimary">
													<label for="ProcessedPrimary" class="lab-medium">View Processed Orders</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="CompletedPrimary" name="access_rights" value="CompletedPrimary">
													<label for="CompletedPrimary" class="lab-medium">View Completed Orders</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="CancelledPrimary" name="access_rights" value="CancelledPrimary">
													<label for="CancelledPrimary" class="lab-medium">View Cancelled Orders</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="EmployeesListPrimary" name="access_rights" value="EmployeesListPrimary">
													<label for="EmployeesListPrimary" class="lab-medium">View Order Compliance</label>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-3 col-sm-6">
										<div class="form-group">
											<h5>Inventory Management</h5>
											<div class="form-group p-b-10 p-t-10">
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="AddInventory" name="access_rights" value="AddInventory">
													<label for="AddInventory" class="lab-medium">Add Inventory</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="ListInventory" name="access_rights" value="ListInventory">
													<label for="ListInventory" class="lab-medium">View Inventory</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="UpdateInventorySku" name="access_rights" value="UpdateInventorySku">
													<label for="UpdateInventorySku" class="lab-medium">Update Inventory</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="UpdateCentralizedTradePrice" name="access_rights" value="UpdateCentralizedTradePrice">
													<label for="UpdateCentralizedTradePrice" class="lab-medium">Centralized Trade Price</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="ProductGallery" name="access_rights" value="ProductGallery">
													<label for="ProductGallery" class="lab-medium">View Inventory Gallery</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="ListMainCategories" name="access_rights" value="ListMainCategories">
													<label for="ListMainCategories" class="lab-medium">View Main Categories</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="ListSubCategories" name="access_rights" value="ListSubCategories">
													<label for="ListSubCategories" class="lab-medium">View Sub Categories</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="ListSubInventory" name="access_rights" value="ListSubInventory">
													<label for="ListSubInventory" class="lab-medium">View Sub Categories</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="ListUnits" name="access_rights" value="ListUnits">
													<label for="ListUnits" class="lab-medium">View Inventory Units/Variants</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="DistributorStockManagement" name="access_rights" value="DistributorStockManagement">
													<label for="DistributorStockManagement" class="lab-medium">Distributor Stock Management</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="StockManagement" name="access_rights" value="StockManagement">
													<label for="StockManagement" class="lab-medium">Danpak Stock Management</label>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-3 col-sm-6">
										<div class="form-group">
											<h5>Catalogue Management</h5>
											<div class="form-group p-b-10 p-t-10">
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="ViewCatalogues" name="access_rights" value="ViewCatalogues">
													<label for="ViewCatalogues" class="lab-medium">View Catalogue</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="ViewCatalogueAssignments" name="access_rights" value="ViewCatalogueAssignments">
													<label for="ViewCatalogueAssignments" class="lab-medium">View Catalogue Assignments</label>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-3 col-sm-6">
										<div class="form-group">
											<h5>Distributors Management</h5>
											<div class="form-group p-b-10 p-t-10">
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="ListRetailers" name="access_rights" value="ListRetailers">
													<label for="ListRetailers" class="lab-medium">View Distributors</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="ListRetailerTypes" name="access_rights" value="ListRetailerTypes">
													<label for="ListRetailerTypes" class="lab-medium">View Distributor Types</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="DistributorProfile" name="access_rights" value="DistributorProfile">
													<label for="DistributorProfile" class="lab-medium">View Distributor Profile</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="RetailerProfile" name="access_rights" value="RetailerProfile">
													<label for="RetailerProfile" class="lab-medium">View Retailer Profile</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="ListRetailersAssignments" name="access_rights" value="ListRetailersAssignments">
													<label for="ListRetailersAssignments" class="lab-medium">View Distributor Assignments</label>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-3 col-sm-6">
										<div class="form-group">
											<h5>Sales Force Management</h5>
											<div class="form-group p-b-10 p-t-10">
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="AddEmployee" name="access_rights" value="AddEmployee">
													<label for="AddEmployee" class="lab-medium">Add Employee</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="EmployeeProfile" name="access_rights" value="EmployeeProfile">
													<label for="EmployeeProfile" class="lab-medium">View Employee Profile</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="Attendance" name="access_rights" value="Attendance">
													<label for="Attendance" class="lab-medium">View Attendance</label>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-3 col-sm-6">
										<div class="form-group">
											<h5>Bulletins</h5>
											<div class="form-group p-b-10 p-t-10">
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="ListGroups" name="access_rights" value="ListGroups">
													<label for="ListGroups" class="lab-medium">View Groups</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="ListMessages" name="access_rights" value="ListMessages">
													<label for="ListMessages" class="lab-medium">View Messages</label>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-3 col-sm-6">
										<div class="form-group">
											<h5>Questionnaires</h5>
											<div class="form-group p-b-10 p-t-10">
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="ListQuestionnaires" name="access_rights" value="ListQuestionnaires">
													<label for="ListQuestionnaires" class="lab-medium">View Questionnaires</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="CreateQuestionnaire" name="access_rights" value="CreateQuestionnaire">
													<label for="CreateQuestionnaire" class="lab-medium">Create Questionnaires</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="UpdateQuestionnaire" name="access_rights" value="UpdateQuestionnaire">
													<label for="UpdateQuestionnaire" class="lab-medium">Update Questionnaires</label>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-3 col-sm-6">
										<div class="form-group">
											<h5>KPI Management</h5>
											<div class="form-group p-b-10 p-t-10">
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="EmpKpi" name="access_rights" value="EmpKpi">
													<label for="EmpKpi" class="lab-medium">View Employee KPI</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="EmpKpiSettings" name="access_rights" value="EmpKpiSettings">
													<label for="EmpKpiSettings" class="lab-medium">Add Employee Kpi</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="UpdateKpiSettings" name="access_rights" value="UpdateKpiSettings">
													<label for="UpdateKpiSettings" class="lab-medium">Update Employee Kpi</label>
												</div>
												<div class="checkbox checkbox-primary checkbox-circle m-b-10">
													<input type="checkbox" id="Hierarchy" name="access_rights" value="Hierarchy">
													<label for="Hierarchy" class="lab-medium">View Employee Hierarchy</label>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row button-section">
				<a type="button" href="<?= base_url('AccRights/ListRights'); ?>" id="backFromNewAccRightsButton" class="btn btn-cancel">Cancel</a>
				<a type="button" id="updateAccessRightsButton" class="btn btn-save">Save</a>
			</div>
		</div>
	</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script type="text/javascript" src="<?= base_url('assets/js/AccessRights.js').'?v='.time(); ?>"></script>
