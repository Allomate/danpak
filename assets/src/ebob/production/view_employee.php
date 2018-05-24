<?php 
require 'verify_permission.php';
include 'header.php';?>
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
                        $sql = "SELECT employee_id, employee_username from employees_info";
                        $stmt = $conn->prepare($sql);
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
            <div class="col-md-6">
                <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title">Employee Profile</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-4">
                                    <label>Name</label>
                                </div>
                                <div class="col-md-8">
                                    <span id="empName"></span>
                                    <input type="text" class="form-control" name="empName" id="empNameInput" style="display: none">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-4">
                                    <label>Address</label>
                                </div>
                                <div class="col-md-8">
                                    <span id="empAddress"></span>
                                    <input type="text" class="form-control" name="empAddress" id="empAddressInput" style="display: none">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-4">
                                    <label>City</label>
                                </div>
                                <div class="col-md-8">
                                    <span id="empCity"></span>
                                    <input type="text" class="form-control" name="empCity" id="empCityInput" style="display: none">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-4">
                                    <label>Country</label>
                                </div>
                                <div class="col-md-8">
                                    <span id="empCountry"></span>
                                    <input type="text" class="form-control" name="empCountry" id="empCountryInput" style="display: none">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-4">
                                    <label>Phone</label>
                                </div>
                                <div class="col-md-8">
                                    <span id="empPhone"></span>
                                    <input type="text" class="form-control" name="empPhone" id="empPhoneInput" style="display: none">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <button class="btn btn-sm btn-success" style="width: 100%; height: 40px;" id="updateEmpDetails">Update</button>
                            <button class="btn btn-sm btn-default" style="width: 29%; height: 40px; display: none" id="cancelEmpUpdate">Cancel</button>
                        </div>
                    </div>
                </div>
                <!-- end panel -->
            </div>
            <div class="col-md-6">
                <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title">Employee Official Details</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-4">
                                    <label>Company</label>
                                </div>
                                <div class="col-md-8">
                                    <span id="empCompany"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-4">
                                    <label>Location</label>
                                </div>
                                <div class="col-md-8">
                                    <span id="empLocation"></span>
                                    <select id="empLocationInput" class="form-control" style="display: none">
                                        <?php
                                        $sql = "SELECT franchise_id, franchise_name from franchise_info where company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->bind_param('s', $_COOKIE["US-K"]);
                                        $stmt->execute();
                                        $stmt->bind_result($franchise_id, $franchise_name);
                                        while($stmt->fetch()){?>
                                        <option value="<?php echo $franchise_id;?>"><?php echo $franchise_name;?></option>
                                        <?php }
                                        $stmt->close(); ?>
                                    </select>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-2">
                                    <label>Department</label>
                                </div>
                                <div class="col-md-10">
                                    <span id="empDept"></span>
                                    <div id="empDeptCheckboxes" style="display: none">
                                        <?php
                                        $sql = "SELECT department_id, department_name from departments_info";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();
                                        $stmt->bind_result($department_id, $department_name);
                                        while($stmt->fetch()){?>
                                        <div class="checkbox checkbox-css checkbox-inline checkbox-warning">
                                            <input type="checkbox" name="departments[]" value="<?php echo $department_id;?>" id="<?php echo $department_id;?>" checked/>
                                            <label for="<?php echo $department_id;?>"><?php echo $department_name?></label>
                                        </div>
                                        <?php }
                                        $stmt->close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <button class="btn btn-sm btn-success" style="width: 100%; height: 40px;" id="updateOfficialDetails">Update</button>
                            <button class="btn btn-sm btn-default" style="width: 29%; height: 40px; display: none" id="cancelOfficialDetailsUpdate">Cancel</button>
                        </div>
                    </div>
                </div>
                <!-- end panel -->
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title">Employee Performance Stats</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-4">
                                    <label>Complains</label>
                                </div>
                                <div class="col-md-8">
                                    <span id="empComplains"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end #content -->

    <!-- begin scroll to top btn -->
    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
    <!-- end scroll to top btn -->
</div>

<?php include 'footer.php';?>
<script type="text/javascript" src="script/view_employee_script.js?v=<?php echo time();?>"></script>
<script type="text/javascript" src="script/sidebar-script.js?v=<?php echo time();?>"></script>

<script type="text/javascript">
    $(document).ready(function(){
        App.init();
        Dashboard.init();
        $('.nav li').removeClass('active');
        $('#employeeDetailsLi').addClass('active');
        $('#employeeDetailsLi #viewEmployee').addClass('active');
    });
</script>