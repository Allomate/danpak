<?php require_once(APPPATH.'/views/includes/header.php'); ?>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once(APPPATH.'/views/includes/navbar&sidebar.php'); ?>
	<div class="page-wrapper">
		<div class="container-fluid">
			<div class="row heading-bg">
				<div class="col-lg-6 col-md-6">
					<h2 class="m-heading">Access Rights Management</h2>
				</div>
				<div class="col-lg-6 col-md-6">
					<ol class="breadcrumb">
						<li><a href="#"><span>Organization</span></a></li>
						<li><span>Access Rights Management</span></li>
					</ol>
				</div>
			</div>
			<div class="row">
                <div class="col-md-12">
                    <div class="box-white m-b-30">
                        <h2>Create Access Rights</h2>
                        <?php $attributes = array('id' => 'addAccessRightsForm');
                        echo form_open('AccRights/AddAccRightsOps', $attributes); ?>
                            <input type="text" name="permisData" id="permisData" hidden>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="employee">Select employee</label>
                                        <select name="admin_id" class="form-control">
                                            <?php foreach($Admins as $admin) :?>
                                                <option value="<?= $admin->id; ?>"><?= $admin->admin_un?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                    </form>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="rights">Access Rights</label>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <strong>- Dashboard</strong>
                                                <div class="form-group" style="margin-top: 10px">
                                                    <input type="checkbox" name="access_rights" value="Dashboardv1"> Sales Dashboard
                                                    <br><br>
                                                    <input type="checkbox" name="access_rights" value="DashboardHrm"> HRMS    
                                                    <br><br>
                                                    <input type="checkbox" name="access_rights" value="DashboardSales"> DashboardSales
                                                    <br><br>
                                                    <input type="checkbox" name="access_rights" value="Reports"> Reports
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <strong>- Organization</strong>
                                                <div class="form-group" style="margin-top: 10px">
                                                    <input type="checkbox" name="access_rights" value="Profile"> Company Profile
                                                    <br><br>
                                                    <input type="checkbox" name="access_rights" value="ListRegions"> View Regions    
                                                    <br><br>
                                                    <input type="checkbox" name="access_rights" value="ListAreas"> View Areas 
                                                    <br><br>
                                                    <input type="checkbox" name="access_rights" value="ListTerritories"> View Territories
                                                    <br><br>
                                                    <input type="checkbox" name="access_rights" value="ListEmployees"> View Employees
                                                    <br><br>
                                                    <input type="checkbox" name="access_rights" value="ListCampaigns"> View Campaigns
                                                    <br><br>
                                                    <input type="checkbox" name="access_rights" value="DailyRouting"> View Daily Employee Routes
                                                    <br><br>
                                                    <input type="checkbox" name="access_rights" value="ListRights"> View Access Rights
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <strong>- Order Management</strong>
                                                <div class="form-group" style="margin-top: 10px">
                                                    <input type="checkbox" name="access_rights" value="Latest"> View Today's Orders
                                                    <br><br>
                                                    <input type="checkbox" name="access_rights" value="Pending"> View Pending Orders
                                                    <br><br>
                                                    <input type="checkbox" name="access_rights" value="Processed"> View Processed Orders
                                                    <br><br>
                                                    <input type="checkbox" name="access_rights" value="Completed"> View Completed Orders
                                                    <br><br>
                                                    <input type="checkbox" name="access_rights" value="Cancelled"> View Cancelled Orders
                                                    <br><br>
                                                    <input type="checkbox" name="access_rights" value="EmployeesList"> View Order Compliance
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <strong>- Inventory Management</strong>
                                                <div class="form-group" style="margin-top: 10px">
                                                    <input type="checkbox" name="access_rights" value="AddInventory"> Add Inventory
                                                    <br><br>
                                                    <input type="checkbox" name="access_rights" value="ListInventory"> View Inventory
                                                    <br><br>
                                                    <input type="checkbox" name="access_rights" value="ProductGallery"> View Inventory Gallery
                                                    <br><br>
                                                    <input type="checkbox" name="access_rights" value="ListMainCategories"> View Main Categories
                                                    <br><br>
                                                    <input type="checkbox" name="access_rights" value="ListSubCategories"> View Sub Categories
                                                    <br><br>
                                                    <input type="checkbox" name="access_rights" value="ListSubInventory"> View Sub Inventory
                                                    <br><br>
                                                    <input type="checkbox" name="access_rights" value="ListUnits"> View Inventory Units/Variants
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <strong>- Catalogue Management</strong>
                                                <div class="form-group" style="margin-top: 10px">
                                                    <input type="checkbox" name="access_rights" value="ViewCatalogues"> View Catalogue
                                                    <br><br>
                                                    <input type="checkbox" name="access_rights" value="ViewCatalogueAssignments"> View Catalogue Assignments
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <strong>- Distributors Management</strong>
                                                <div class="form-group" style="margin-top: 10px">
                                                    <input type="checkbox" name="access_rights" value="ListRetailers"> View Distributors
                                                    <br><br>
                                                    <input type="checkbox" name="access_rights" value="ListRetailerTypes"> View Distributor Types
                                                    <br><br>
                                                    <input type="checkbox" name="access_rights" value="ListRetailersAssignments"> View Distributor Assignments
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <strong>- Sales Force Management</strong>
                                                <div class="form-group" style="margin-top: 10px">
                                                    <input type="checkbox" name="access_rights" value="AddEmployee"> Add Employee
                                                    <br><br>
                                                    <input type="checkbox" name="access_rights" value="Attendance"> View Attendance
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <strong>- Bulletins</strong>
                                                <div class="form-group" style="margin-top: 10px">
                                                    <input type="checkbox" name="access_rights" value="ListGroups"> View Groups
                                                    <br><br>
                                                    <input type="checkbox" name="access_rights" value="ListMessages"> View Messages
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <strong>- Questionnaires</strong>
                                                <div class="form-group" style="margin-top: 10px">
                                                    <input type="checkbox" name="access_rights" value="ListQuestionnaires"> View Questionnaires
                                                    <br><br>
                                                    <input type="checkbox" name="access_rights" value="CreateQuestionnaire"> Create Questionnaires
                                                    <br><br>
                                                    <input type="checkbox" name="access_rights" value="UpdateQuestionnaire"> Update Questionnaires
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
			<a type="button" id="addAccessRightsButton" class="btn btn-save">Save</a>						
		</div>
	</div>
</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script type="text/javascript" src="<?= base_url('assets/js/AccessRights.js').'?v='.time(); ?>"></script>