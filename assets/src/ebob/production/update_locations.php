<?php 
require 'verify_permission.php';
include 'header.php';?>
<!-- begin #page-loader -->
<div id="page-loader" class="fade in"><span class="spinner"></span></div>
<!-- end #page-loader -->
<!-- begin #page-container -->
<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
    <?php include 'navbar.php';
    include 'sidebar.php';?>
    <div id="content" class="content">
       <!-- begin breadcrumb -->
       <ol class="breadcrumb pull-right">
        <li>
            <a href="javascript:;">Home</a>
        </li>
        <li class="active">Locations</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Company Details <small>Update company & franchise details from this page</small></h1>
    <!-- end page-header -->
    <div id="mainContent">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label>Location</label>
                    <select class="form-control" id="locationId">
                    </select>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-8">
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
                        <form action="server_scripts/update_franchise.php" method="POST" id="updateFranchiseForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="col-md-4">
                                        <label>Name</label>
                                    </div>
                                    <div class="col-md-8">
                                        <span id="locationName"></span>
                                        <input type="text" class="form-control" name="locationName" id="locationNameInput" style="display: none">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-4">
                                        <label>City</label>
                                    </div>
                                    <div class="col-md-8">
                                        <span id="locationCity"></span>
                                        <input type="text" class="form-control" name="locationCity" id="locationCityInput" style="display: none">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="col-md-4">
                                        <label>Region</label>
                                    </div>
                                    <div class="col-md-8">
                                        <span id="locationRegion"></span>
                                        <select class="form-control" id="locationRegionDD" name="locationRegion" style="display: none">
                                            <?php 
                                            require_once 'database/config.php';
                                            $sql = "SELECT region_id, region_name from company_regions where region_company = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->bind_param('s', $_COOKIE["US-K"]);
                                            $stmt->execute();
                                            $stmt->bind_result($id, $region);
                                            while ($stmt->fetch()) {?>
                                            <option value="<?php echo $id;?>"><?php echo $region;?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-4">
                                        <label>Area</label>
                                    </div>
                                    <div class="col-md-8">
                                        <span id="locationArea"></span>
                                        <select class="form-control" name="locationArea" id="locationAreaDD" style="display: none">
                                            <?php 
                                            require_once 'database/config.php';
                                            $sql = "SELECT area_id, area_name from company_areas where area_company = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->bind_param('s', $_COOKIE["US-K"]);
                                            $stmt->execute();
                                            $stmt->bind_result($id, $area);
                                            while ($stmt->fetch()) {?>
                                            <option value="<?php echo $id;?>"><?php echo $area;?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <input type="text" class="form-control" name="locationId" id="locationIdInput" style="display: none">
                        </form>
                        <br>
                        <div>
                            <button type="button" id="updateLocation" class="btn btn-sm btn-success" style="width: 150px;height: 40px;">Update</button>
                            <button type="button" id="cancelLocationButton" class="btn btn-sm btn-default" style="margin-right: 10px; height: 40px; width: 100px; display: none">Cancel</button>
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
<script type="text/javascript" src="script/update_locations_script.js?v=<?php echo time();?>"></script>
<script type="text/javascript" src="script/sidebar-script.js?v=<?php echo time();?>"></script>

<script type="text/javascript">
    $(document).ready(function(){
        App.init();
        Dashboard.init();
        $('.nav li').removeClass('active');
        $('#companyDetailsLi').addClass('active');
        $('#companyDetailsLi #updateLocations').addClass('active');
    });
</script>