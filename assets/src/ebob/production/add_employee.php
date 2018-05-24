<?php 
require 'verify_permission.php';
include 'header.php';?>
<style type="text/css">
.uploadBulkSpinner, .downloadCsvSampleSpinner{
    right: 5px; 
    top: 6px; 
    width: 30px; 
    height: 30px;
    display: none;
}
</style>
<!-- begin #page-loader -->
<div id="page-loader" class="fade in"><span class="spinner"></span></div>
<!-- end #page-loader -->
<!-- begin #page-container -->
<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
   <?php include 'navbar.php';?>
   <?php include 'sidebar.php';?>
   <div id="content" class="content">
     <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li class="active">Locations</li>
    </ol>
    <h1 class="page-header">Employee Details <small>Add Employee details from this page</small></h1>

    <div class="row">
        <!-- begin col-6 -->
        <div class="col-md-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Employee Details</h4>
                </div>
                <div class="panel-body" style="padding: 0px">
                    <form action="server_scripts/add_employee.php" method="post" class="form-horizontal" enctype="multipart/form-data" id="employeeForm">
                        <div style="padding: 15px">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group has-success has-feedback">
                                        <label class="col-md-3 control-label" style="color: black">Employee Username</label>
                                        <div class="col-md-9">
                                            <input type="text" name="empUn" id="empUsername" class="form-control" maxlength="30" required />
                                            <div id="usernameWarning"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Employee Location</label>
                                        <div class="col-md-9">
                                            <select name="franchiseId" class="form-control" id="franchiseDD">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Employee Name</label>
                                        <div class="col-md-9">
                                            <input type="text" name="empName" class="form-control" placeholder="Employee Name" />
                                        </div>
                                    </div>  
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Employee Password</label>
                                        <div class="col-md-9">
                                            <input type="password" class="form-control" name="empPw" placeholder="Employee Password" maxlength="30" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Employee Cnic</label>
                                        <div class="col-md-9">
                                            <input type="number" name="empCnic" class="form-control" required>
                                        </div>
                                    </div> 
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Employee Role</label>
                                        <div class="col-md-9">
                                            <select name="empRole" class="form-control" id="empRole">
                                                <?php
                                                $sql = "SELECT role_id, role_name from employee_roles";
                                                $stmt = $conn->prepare($sql);
                                                $stmt->execute();
                                                $stmt->bind_result($role_id, $role_name);
                                                while($stmt->fetch()){?>
                                                <option value="<?php echo $role_id;?>"> <?php echo $role_name;?> </option>
                                                <?php }
                                                $stmt->close();
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Employee Department</label>
                                        <div class="col-md-9">

                                            <?php
                                            $sql = "SELECT department_id, department_name from departments_info";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->execute();
                                            $stmt->bind_result($department_id, $department_name);
                                            while($stmt->fetch()){?>
                                            <div class="checkbox checkbox-css checkbox-inline checkbox-warning">
                                                <input type="checkbox" name="department_list[]" value="<?php echo $department_id;?>" id="<?php echo $department_id;?>"/>
                                                <label for="<?php echo $department_id;?>"><?php echo $department_name?></label>
                                            </div>
                                            <?php }
                                            $stmt->close(); ?>

                                        </div>              
                                    </div>    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Employee City</label>
                                        <div class="col-md-9">
                                            <input class="form-control" type="text" name="empCity" placeholder="Employee City" maxlength="60"  required />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Reporting To</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="reporting_to">
                                                <?php
                                                require_once 'database/config.php';
                                                $sql = "SELECT employee_id, employee_username from employees_info where company_id = (SELECT company_id from employees_info WHERE employee_username = (SELECT employee from employee_session where session = ?))";
                                                $stmt = $conn->prepare($sql);
                                                $stmt->bind_param('s', $_COOKIE["US-K"]);
                                                $stmt->execute();
                                                $stmt->bind_result($employee_id, $employee_username);
                                                while($stmt->fetch()){?>
                                                <option value="<?php echo $employee_id;?>"> <?php echo $employee_username;?> </option>
                                                <?php }
                                                $stmt->close();
                                                ?>
                                            </select>
                                        </div>
                                    </div> 
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Employee Address</label>
                                        <div class="col-md-9">
                                            <input class="form-control" type="text" name="empAddress" placeholder="Employee Complete Address" maxlength="100" required />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Employee Phone</label>
                                        <div class="col-md-9">
                                            <input class="form-control" pattern="\d*" name="empPhone" placeholder="Employee Phone Number" maxlength="20" required/>
                                        </div>
                                    </div>  
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Employee Picture</label>
                                        <div class="col-md-9">
                                            <input type="file" name="empImage" id="empImg" class="filestyle form-control" data-input="false" accept=".png,.jpg,.bmp,.jpeg">
                                        </div>
                                    </div> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Employee Hiring</label>
                                        <div class="col-md-9">
                                            <div class="input-group date" id="hireDate">
                                                <input type="text" class="form-control" name="hireDate" required/>
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>  
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Employee Salary</label>
                                        <div class="col-md-9">
                                            <input type="number" name="empSalary" class="form-control" required>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="row" style="background-color: #454558; margin: 0px">
                            <center>
                                <h4 style="color: white;">Access Rights</h4>
                            </center>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="padding: 50px 50px 0px 50px;">
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
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-1"></div>
                                <div class="col-md-3">
                                    <button class="btn btn-sm btn-success" id="addEmployeeButton" style="width: 100%; height: 50px">Add Employee</button>
                                </div>
                                <div class="col-md-8"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end panel -->
        </div>
    </div>

    <div class="row">
        <div class="col-md-5">
            <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Bulk Upload</h4>
                </div>
                <div class="panel-body">
                    <form method="post" enctype="multipart/form-data" id="csvUploadingForm">
                        <div class="form-group">
                            <label>Upload CSV</label>
                            <input class="form-control" type="file" name="csvSheet" id="csvSheet" accept=".csv" />
                        </div>
                    </form>
                    <p>
                        <strong>Hint: </strong> Data added in excel sheet can be converted to CSV format just by saving as .CSV
                    </p>
                    <div class="alert alert-warning" style="color: red; display: none" id="failedUploadsDiv">
                        <strong>Failed!</strong> Following employees are not added due to errors
                        <br>
                        <span id="errorsThrown"></span>
                    </div>
                    <div id="failedUploadsTable" style="display: none">
                        <table class="table table-stripped">
                            <thead>
                                <tr>
                                    <th>Employee Username</th>
                                    <th>Issue</th>
                                </tr>
                            </thead>
                            <tbody id="failedUploadsTbody">
                            </tbody>
                        </table>
                    </div>
                    <div style="text-align: center">
                        <button class="btn btn-warning" style="margin-left: 22px; text-align: center" id="uploadBulkButton">
                            <img src="assets/raw/view-details-loader.gif" class="uploadBulkSpinner">
                            <span id="uploadBulkText">Upload Bulk</span>
                        </button>
                        <a href="csv-sheet/sample-employees.csv"> 
                            <button class="btn btn-default" style="text-align: center" id="downloadCsvSample">
                                <img src="assets/raw/view-details-loader.gif" class="downloadCsvSampleSpinner">
                                <span id="downloadCsvSampleText">Download Sample</span>
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- end #content -->

<!-- begin scroll to top btn -->
<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>

<?php include 'footer.php';?>
<script src="http://malsup.github.com/jquery.form.js"></script> 
<script src="assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="script/add_employee_script.js?v=<?php echo time();?>"></script>
<script type="text/javascript" src="script/sidebar-script.js?v=<?php echo time();?>"></script>

<script type="text/javascript">
    $(document).ready(function(){
        App.init();
        Dashboard.init();
        $('#hireDate').datepicker();
        $('.nav li').removeClass('active');
        $('#employeeDetailsLi').addClass('active');
        $('#employeeDetailsLi #addEmployee').addClass('active');
    });
</script>