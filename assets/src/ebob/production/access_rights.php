<?php 
require 'verify_permission.php';
include 'header.php';?>

<style type="text/css">
.updatePermissionsSpinner{
    right: 5px; 
    top: 6px; 
    width: 20px; 
    height: 20px;
    display: none
}
</style>
<!-- <div id="page-loader" class="fade in"><span class="spinner"></span></div> -->
<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
    <?php
    include 'navbar.php';
    include 'sidebar.php';?>
    <div id="content" class="content">
       <ol class="breadcrumb pull-right">
        <li>
            <a href="javascript:;">Home</a>
        </li>
        <li class="active">Locations</li>
    </ol>
    <h1 class="page-header">Employee Details <small>Add Employee details from this page</small></h1>
    <!-- end page-header -->
    <div id="mainContent">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Employee Username</label>
                    <select class="form-control" id="empUsername">
                        <?php 
                        require_once 'database/config.php';
                        $sql = "SELECT employee_id, employee_username from employees_info where company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param('s', $_COOKIE["US-K"]);
                        $stmt->execute();
                        $stmt->bind_result($id, $username);
                        while ($stmt->fetch()) {?>
                        <option value="<?php echo $id;?>"><?php echo $username;?></option>
                        <?php }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6"></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-inverse permissionsPanel" data-sortable-id="form-stuff-1">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title">Employee Profile</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>- Employee Management</label>&nbsp;&nbsp;&nbsp;<input type="checkbox" id="employee_main_checker">
                                    <div class="row">
                                        <br>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="checkbox" name="access_rights" value="add_employee"> Add Employee
                                                <br><br>
                                                <input type="checkbox" name="access_rights" value="view_employee"> View/Update Employee
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>- CX Dashboard</label>
                                    <div class="row">
                                        <br>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="checkbox" name="access_rights" value="cx_dashboard"> Dashboard
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>- Complains Management</label>
                                    <div class="row">
                                        <br>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="checkbox" name="access_rights" value="complain_heads"> Complains Setup
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>- POS Management</label>&nbsp;&nbsp;&nbsp;<input type="checkbox" id="pos_main_checker">
                                    <div class="row">
                                        <br>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="checkbox" name="access_rights" value="pos_setup"> POS Setup
                                            </div>
                                            <div class="form-group">
                                                <input type="checkbox" name="access_rights" value="item_sale"> Item Selling
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>- Inventory Management</label>&nbsp;&nbsp;&nbsp;<input type="checkbox" id="inventory_main_checker">
                                    <div class="row">
                                        <br>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="checkbox" name="access_rights" value="warehouse_inventory"> View Warehouse Inventory
                                                <br><br>
                                                <input type="checkbox" name="access_rights" value="location_inventory"> View Location Inventory
                                                <br><br>
                                                <input type="checkbox" name="access_rights" value="inventory_requests"> Handle Inventory Requests
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>- Warehouse Management</label>&nbsp;&nbsp;&nbsp;<input type="checkbox" id="warehouse_main_checker">
                                    <div class="row">
                                        <br>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="checkbox" name="access_rights" value="add_warehouse"> Add Warehouse
                                                <br><br>
                                                <input type="checkbox" name="access_rights" value="dispatch_items"> Dispatch Items from warehouse
                                                <br><br>
                                                <input type="checkbox" name="access_rights" value="add_items"> Add Warehouse Inventory
                                                <br><br>
                                                <input type="checkbox" name="access_rights" value="update_items"> Update Warehouse Inventory
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>- Targets Management</label>&nbsp;&nbsp;&nbsp;<input type="checkbox" id="targets_main_checker">
                                    <div class="row">
                                        <br>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="checkbox" name="access_rights" value="add_targets"> Add Targets
                                                <br><br>
                                                <input type="checkbox" name="access_rights" value="update_targets"> Update Targets
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="form-group">
                                        <label>- Access Rights</label>
                                        <div class="row">
                                            <br>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="checkbox" name="access_rights" value="permissions"> Access Rights
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="text-align: center">
                         <button type="button" class="btn btn-sm btn-success" id="updatePermissionsButton" style="width: 150px; height: 40px;">
                            <img src="assets/raw/button-loader.gif" class='updatePermissionsSpinner'/>
                            <span id="updatePermissionsText">Update</span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- end panel -->
        </div>
    </div>
</div>
<!-- end #content -->

<!-- begin scroll to top btn -->
<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
<!-- end scroll to top btn -->
</div>

<?php include 'footer.php';?>
<script type="text/javascript" src="script/access_rights_script.js?v=<?php echo time();?>"></script>
<script type="text/javascript" src="script/sidebar-script.js?v=<?php echo time();?>"></script>

<script type="text/javascript">
    $(document).ready(function(){
        App.init();
        Dashboard.init();
        $('.nav li').removeClass('active');
        $('#employeeDetailsLi').addClass('active');
        $('#accessRights').addClass('active');
    });
</script>