<?php 
require 'verify_permission.php';
$company_added = false;
if (isset($_COOKIE["company_added"])) {
    setcookie('company_added', null, -1, '/');
    $company_added = true;
}

include 'header.php';?>
<!-- begin #page-loader -->
<div id="page-loader" class="fade in"><span class="spinner"></span></div>
<!-- end #page-loader -->
<!-- begin #page-container -->
<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">

    <?php 
    include 'navbar.php';
    include 'sidebar.php';?>
    <div id="content" class="content">
     <!-- begin breadcrumb -->
     <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li class="active">Locations</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Location Details <small>Add company locations from this page</small></h1>
    <!-- end page-header -->


    <div class="row">
        <!-- begin col-6 -->
        <div class="col-md-6">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Location Details</h4>
                </div>
                <div class="panel-body">
                    <?php if($company_added){?>
                    <div class="alert alert-success">
                        <strong>Success!</strong> Location added successfully
                    </div>
                    <?php }?>
                    <form action="server_scripts/add_franchise.php" method="post" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Location Name</label>
                            <div class="col-md-9">
                                <input type="text" name="franchiseName" class="form-control" placeholder="Location Name" />
                            </div>
                        </div>
                        <!-- <div class="form-group">
                            <label class="col-md-3 control-label">Select</label>
                            <div class="col-md-9">
                                <select class="form-control" name="companyId">
                                    <?php
                                    require_once 'database/config.php';
                                    $sql = "SELECT company_id, company_name from company_info";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();
                                    $stmt->bind_result($company_id, $company_name);
                                    while($stmt->fetch()){?>
                                    <option value="<?php echo $company_id;?>"> <?php echo $company_name;?> </option>
                                    <?php }
                                    $stmt->close();
                                    ?>
                                </select>
                            </div>
                        </div> -->
                        <div class="form-group">
                            <label class="col-md-3 control-label">Location CIty</label>
                            <div class="col-md-9">
                                <input type="text" name="franchiseCity" class="form-control" placeholder="Location Address" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Location Area</label>
                            <div class="col-md-9">
                                <select class="form-control" name="franchiseLocation">
                                    <?php
                                    require_once 'database/config.php';
                                    $sql = "SELECT area_id, area_name from company_areas where area_company = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param('s', $_COOKIE["US-K"]);
                                    $stmt->execute();
                                    $stmt->bind_result($area_id, $area_name);
                                    while($stmt->fetch()){?>
                                    <option value="<?php echo $area_id;?>"> <?php echo $area_name;?> </option>
                                    <?php }
                                    $stmt->close();
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Location Region</label>
                            <div class="col-md-9">
                                <select class="form-control" name="locationRegion">
                                    <?php
                                    require_once 'database/config.php';
                                    $sql = "SELECT region_id, region_name from company_regions where region_company = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param('s', $_COOKIE["US-K"]);
                                    $stmt->execute();
                                    $stmt->bind_result($region_id, $region_name);
                                    while($stmt->fetch()){?>
                                    <option value="<?php echo $region_id;?>"> <?php echo $region_name;?> </option>
                                    <?php }
                                    $stmt->close();
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Location Address</label>
                            <div class="col-md-9">
                                <input type="text" name="franchiseAddress" class="form-control" placeholder="Location Address" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-9">
                                    <button type="submit" class="btn btn-sm btn-success" style="float: right">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end panel -->
        </div>

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                            <h4 class="panel-title">Add Region</h4>
                        </div>
                        <div class="panel-body">
                            <form action="server_scripts/add_regions.php" method="post" class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Region Name</label>
                                    <div class="col-md-9">
                                        <input type="text" name="regionName" class="form-control" placeholder="Add region name" maxlength="50" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-9">
                                            <button type="submit" class="btn btn-sm btn-success" style="float: right">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                            <h4 class="panel-title">Add Area</h4>
                        </div>
                        <div class="panel-body">
                            <form action="server_scripts/add_areas.php" method="post" class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Add Area</label>
                                    <div class="col-md-9">
                                        <input type="text" name="areaName" class="form-control" placeholder="Add area" maxlength="100" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-9">
                                            <button type="submit" class="btn btn-sm btn-success" style="float: right">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col-6 -->
    </div>
</div>

<!-- begin scroll to top btn -->
<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>

<?php include 'footer.php';?>
<script type="text/javascript" src="script/sidebar-script.js?v=<?php echo time();?>"></script>

<script type="text/javascript">
    $(document).ready(function(){
        App.init();
        Dashboard.init();
        $('.nav li').removeClass('active');
        $('#companyDetailsLi').addClass('active');
        $('#companyDetailsLi #addLocations').addClass('active');
    });
</script>