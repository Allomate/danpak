<div id="sidebar" class="sidebar">
    <!-- begin sidebar scrollbar -->
    <div data-scrollbar="true" data-height="100%">
        <!-- begin sidebar user -->
        <ul class="nav">
            <li class="nav-profile">
                <div class="image">
                    <a href="javascript:;"><img src="assets/images/logo.png" alt="" /></a>
                </div>
                <div class="info">
                    E-Bob
                    <small>Dashboard</small>
                </div>
            </li>
        </ul>
        <?php
        require "database/config.php";
        $sql = "SELECT `id`, `employee_id`, `cx_dashboard`, `add_company`, `add_franchise`, `update_company`, `add_employee`, `view_employee`, `inbox`, `complain_heads`, `warehouse_inventory`, `location_inventory`, `inventory_requests`, `add_warehouse`, `dispatch_items`, `add_items`, `update_items`, `item_sale`, `pos_setup`, `add_targets`, `update_targets`, `permissions`, `update_locations`, `warehouse_inventory_gallery`, `location_inventory_gallery`, `customer_base`, `loyalty_setup` FROM `access_rights` WHERE employee_id = (SELECT employee_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $_COOKIE["US-K"]);
        $stmt->execute();
        $stmt->bind_result($id, $employeeId, $dashboard, $add_company, $add_franchise, $update_company, $add_employee, $view_employee, $inbox, $complain_heads, $warehouse_inventory, $location_inventory, $inventory_requests, $add_warehouse, $dispatch_items, $add_items, $update_items, $item_sale, $pos_setup, $add_targets, $update_targets, $access_rights, $update_locations, $warehouse_inventory_gallery, $location_inventory_gallery, $customer_base, $loyalty_setup);
        while ($stmt->fetch()) {?>
        <ul class="nav">
            <li class="nav-header">Navigation</li>
            <li id="dashboardv2"><a href="dashboardv2.php"><i class="fa fa-sign-out"></i>Dashboard V2</a></li>
            <li id="reports"><a href="reports.php"><i class="fa fa-sign-out"></i>Reports</a></li>
            <?php
            if ($dashboard) {?>
            <li id="dashboard"><a href="cx_dashboard.php"><i class="fa fa-sign-out"></i>Dashboard</a></li>
            <?php }
            if ($add_warehouse || $update_locations || $add_company || $update_company || $add_franchise) { ?>
            <li class="has-sub" id="companyDetailsLi">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-briefcase"></i>
                    <span>Company Management</span>
                </a>
                <ul class="sub-menu">
                    <?php
                    if ($update_company) {?>
                    <li id="updateCompany"><a href="update_company.php">Modify Company Details</a></li>
                    <?php }
                    if ($add_franchise) {?>
                    <li id="addLocations"><a href="add_franchise.php">Add Locations</a></li>
                    <?php }
                    if ($update_locations) {?>
                    <li id="updateLocations"><a href="update_locations.php">Modify Locations</a></li>
                    <?php }
                    if ($add_warehouse) {?>
                    <li id="addWarehouse"><a href="add_warehouse.php">Warehouse</a></li>
                    <?php }
                    if ($add_company) {?>
                    <li id="addCompany"><a href="add_company.php">Add Company</a></li>
                    <?php }
                    ?>
                </ul>
            </li>
            <?php } 
            if ($add_employee || $view_employee || $access_rights || $add_targets || $update_targets) { ?>
            <li class="has-sub" id="employeeDetailsLi">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-user"></i>
                    <span>Employee Management</span>
                </a>
                <ul class="sub-menu">
                    <?php
                    if ($add_employee) {?>
                    <li id="addEmployee"><a href="add_employee.php">Add Employee</a></li>
                    <?php }
                    if ($view_employee) {?>
                    <li id="viewEmployee"><a href="view_employee.php">Modify Employee Details</a></li>
                    <?php } 
                    if ($access_rights) {?>
                    <li style="cursor: pointer;" id="accessRights"><a href="access_rights.php"><span>Access Rights</span></a></li>
                    <?php } 
                    if ($add_targets || $update_targets) {?>
                    <li class="has-sub" id="kpiMgmtLi">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>KPI Management</span>
                        </a>
                        <ul class="sub-menu">
                            <?php
                            if ($add_targets) {?>
                            <li id="addTargets"><a href="add_targets.php">Add Targets</a></li>
                            <?php }
                            if ($update_targets) {?>
                            <li id="updateTargets"><a href="update_targets.php">Update Targets</a></li>
                            <?php }
                            ?>
                        </ul>
                    </li>
                    <?php }
                    ?>
                </ul>
            </li>
            <?php }
            if ($complain_heads || $inbox) {?>
            <li class="has-sub" id="complaintMgmtLi">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-user"></i>
                    <span>Complaint Management</span>
                </a>
                <ul class="sub-menu">
                    <?php
                    if ($complain_heads) {?>
                    <li style="cursor: pointer;" id="subheadsLi"><a href="complain_heads.php"><span>Complaint Setup</span></a></li>
                    <?php }
                    if ($inbox) {?>
                    <li style="cursor: pointer;" id="inboxLi"><a><span>Complaint Pool</span></a></li>
                    <?php }
                    ?>
                </ul>
            </li>
            <?php }
            if ($warehouse_inventory || $location_inventory || $inventory_requests || $location_inventory_requests ||
               $warehouse_inventory_gallery) {?>

               <li class="has-sub" id="inventoryLi">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-user"></i>
                    <span>Inventory Management</span>
                </a>
                <ul class="sub-menu">
                    <?php if ($warehouse_inventory) {?>
                    <li id="warehouseInvent"><a href="warehouse_inventory.php">Warehouse</a></li>
                    <?php }
                    if ($location_inventory) {?>
                    <li id="locationInvent"><a href="location_inventory.php">Location <div style="background-color: red;border-radius: 10em;font-weight: bold;color: white;width: 30px;height: 22px;display: inline-block;float: right;line-height: 22px;"><span style="text-align: center; line-height: 22px; display: block;" id="inventoryRequestsSidebarSpan">
                        <?php
                        $stmt->close();
                        $stmt = $conn->prepare("SELECT count(*) from requested_from_location_to_location_inventory where item_sent_from_location = 0 and to_franchise = (SELECT franchise_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))");
                        $stmt->bind_param('s', $_COOKIE["US-K"]);
                        $stmt->execute();
                        $stmt->bind_result($totalRequests);
                        $stmt->fetch();
                        echo $totalRequests;
                        ?>
                    </span></div></a></li>
                    <?php }
                    if ($inventory_requests) {?>
                    <li id="inventRequests"><a href="inventory_requests.php">Inventory Requests <div style="background-color: red;border-radius: 10em;font-weight: bold;color: white;width: 30px;height: 22px;display: inline-block;float: right;line-height: 22px;"><span style="text-align: center; line-height: 22px; display: block;" id="inventoryRequestsSidebarSpan">
                        <?php
                        $stmt->close();
                        $stmt = $conn->prepare("SELECT count(*) from location_inventory_requests where item_sent_from_warehouse = 0");
                        $stmt->execute();
                        $stmt->bind_result($totalRequests);
                        $stmt->fetch();
                        echo $totalRequests;
                        ?>
                    </span></div></a></li>
                    <?php }
                    if ($location_inventory_gallery) {?>
                    <li id="locationInventGallery"><a href="location_inventory_gallery.php">Location Inventory Gallery</a></li>
                    <?php }?>
                </ul>
            </li>

            <?php }
            if ($dispatch_items || $add_items || $update_items || $warehouse_inventory_gallery) {?>

            <li class="has-sub" id="warehouseLi">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-user"></i>
                    <span>Warehouse</span>
                </a>
                <ul class="sub-menu">
                    <?php
                    if ($dispatch_items) {?>
                    <li id="dispatchItems"><a href="dispatch_items.php">Dispatch</a></li>
                    <?php } 
                    if ($add_items || $update_items) {?>

                    <li class="has-sub" id="itemsLi">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Inventory</span>
                        </a>
                        <ul class="sub-menu">
                            <?php
                            if ($add_items) {?>
                            <li id="addItems"><a href="add_items.php">Add Items</a></li>
                            <?php }
                            if ($update_items) {?>
                            <li id="updateItems"><a href="update_items.php">Update Items</a></li>
                            <?php }
                            ?>
                        </ul>
                    </li>

                    <?php } 
                    if ($warehouse_inventory_gallery) {?>
                    <li id="warehouseInventGallery"><a href="warehouse_inventory_gallery.php">Warehouse Inventory Gallery</a></li>
                    <?php }?>
                </ul>
            </li>
            <?php } 
            if ($item_sale || $pos_setup) { ?>
            <li class="has-sub" id="postSetupLi">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-user"></i>
                    <span>POS Setup</span>
                </a>
                <ul class="sub-menu">
                    <?php
                    if ($pos_setup) {?>
                    <li id="posSetup"><a href="pos_setup.php">POS Setup</a></li>
                    <?php }
                    if ($item_sale) {?>
                    <li style="cursor: pointer;" id="itemSale"><a href="item_sale.php"><span>New Sale</span></a></li>
                    <?php }
                    ?>
                </ul>
            </li>
            <?php }
            if ($customer_base) {?>
            <li id="customerBase"><a href="customer_base.php"><i class="fa fa-sign-out"></i>Customer Base</a></li>
            <?php }
            if ($loyalty_setup) {?>
            <li id="loyaltySetup"><a href="loyalty_setup.php"><i class="fa fa-sign-out"></i>Loyalty Setup</a></li>
            <?php }
            ?>
            <!-- <li style="cursor: pointer;" id="profileDashboardLi"><a href="index.php"><i class="fa fa-sign-out"></i> <span>Profile</span></a></li> -->
            <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
        </ul>
        <?php 
    }
    $stmt->close();
    ?>
</div>
</div>
<div class="sidebar-bg"></div>