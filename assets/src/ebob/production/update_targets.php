<?php
require 'verify_permission.php';
include 'header.php';?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">
<style type="text/css">

#targetsDynamic ul li{
    padding-bottom: 20px
}

#targetsDynamic ul{
    padding: 0px
}

.updateTargetsSpinner, .findTargetsSpinner{
    right: 5px; 
    top: 6px; 
    width: 20px; 
    height: 20px;
    display: none
}

table tr td{
    padding-bottom: 10px !important
}
</style>
<div id="page-loader" class="fade in"><span class="spinner"></span></div>
<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
 <?php include 'navbar.php';?>
 <?php include 'sidebar.php';?>

 <div id="content" class="content">
   <ol class="breadcrumb pull-right">
    <li><a href="javascript:;">Home</a></li>
    <li class="active">Locations</li>
</ol>

<h1 class="page-header">Set Targets <small>You can create a sale from this page</small></h1>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-inverse targetsPanel" data-sortable-id="form-stuff-1">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title">Targets</h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="col-md-3 control-label" style="line-height: 40px;">Employee:</label>
                            <div class="col-md-9" style="padding: 0px">
                                <select class="form-control" id="employeeId">
                                    <?php
                                    require_once 'database/config.php';
                                    $sql = "SELECT employee_id, employee_username from employees_info where company_id IN (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param('s', $_COOKIE["US-K"]);
                                    $stmt->execute();
                                    $stmt->bind_result($empId, $empUsername);
                                    while($stmt->fetch()){?>
                                    <option value="<?php echo $empId;?>"> <?php echo $empUsername;?> </option>
                                    <?php }
                                    $stmt->close();
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <label class="col-md-2 control-label" style="line-height: 40px;">Criteria:</label>
                            <div class="col-md-9" style="padding: 0px">
                                <select class="form-control" id="criteria" style="width: 30%; display: inline;">
                                    <option value="daily">Daily</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="quarterly">Quarterly</option>
                                    <option value="annually">Annually</option>
                                </select>
                                &nbsp;
                                <div id="crtieriaDefinition" style="display: inline;">
                                    <select class="form-control" id="definition" style="width: 30%; display: inline;">
                                        <option value="monday">MONDAY</option>
                                        <option value="tuesday">TUESDAY</option>
                                        <option value="wednesday">WEDNESDAY</option>
                                        <option value="thursday">THURSDAY</option><option value="friday">FRIDAY</option>
                                        <option value="saturday">SATURDAY</option>
                                        <option value="sunday">SUNDAY</option>
                                    </select>
                                </div>

                                <button type="button" class="btn btn-success" id="findTargetsBtn" style="width: 30%; height: 40px">
                                    <img src="assets/raw/view-details-loader.gif" class='findTargetsSpinner'/>
                                    <span id="findTargetsText">Find Targets</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="employeeTargetDetails">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group" style="text-align: center">
                                    <label class="control-label">
                                        <h4>Criteria</h4>
                                    </label>
                                    <div>
                                        <span id="criteriaSpan" style="font-weight: bold">Criteria</span>
                                        <select class="form-control" id="criteriaUpdateDD" style="display: none; width: 70%; text-align: center; margin: 0 auto;">
                                            <option value="daily">Daily</option>
                                            <option value="monthly">Monthly</option>
                                            <option value="quarterly">Quarterly</option>
                                            <option value="annually">Annually</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group" style="text-align: center">
                                    <label class="control-label">
                                        <h4>Quarter</h4>
                                    </label>
                                    <div style="text-align: center">
                                        <span id="quarterSpan" style="font-weight: bold">Q1</span>
                                        <div id="crtieriaDefinitionUpdateDiv" style="display: none; width: 70%; text-align: center; margin: 0 auto;">
                                            <select class="form-control" id="definitionUpdateDD">
                                                <option value="monday">MONDAY</option>
                                                <option value="tuesday">TUESDAY</option>
                                                <option value="wednesday">WEDNESDAY</option>
                                                <option value="thursday">THURSDAY</option><option value="friday">FRIDAY</option>
                                                <option value="saturday">SATURDAY</option>
                                                <option value="sunday">SUNDAY</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group" style="text-align: center">
                                    <label class="control-label">
                                        <h4>Target Sale</h4>
                                    </label>
                                    <div>
                                        <span id="targetSale" style="font-weight: bold">18500</span>
                                        <input type="number" class="form-control" id="targetSaleInput" style="display: none; width: 50%; margin: 0px auto">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group" style="text-align: center">
                                    <label class="control-label">
                                        <h4>Given at</h4>
                                    </label>
                                    <div>
                                        <span id="createdAt" style="font-weight: bold">2017-08-03</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group" style="padding: 20px">
                                <label class="col-md-1">Targets</label>
                                <div class="col-md-11" id="targetsDynamic">
                                    <ul style="list-style: none">
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <input type="text" id="rowId" hidden>
                        <br>
                    </div>
                    <div class="noDataFound" style="display: none; text-align: center; margin-top: 100px; margin-bottom: 50px">
                        <h4>No data found for this employee against this criteria</h4>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-7"></label>
                            <div class="col-md-5">
                                <button type="button" class="btn btn-success" id="updateTargetsBtn" style="width: 140px; height: 40px">
                                    <img src="assets/raw/view-details-loader.gif" class='updateTargetsSpinner'/>
                                    <span id="updateTargetsText">Update Targets</span>
                                </button>
                                <button type="button" class="btn btn-primary" id="addNewTargetBtn" style="width: 140px; height: 40px; display: none; background-color: #97589e">Add New Target</button>
                                <button type="button" class="btn btn-warning" id="cancelCommitBtn" style="width: 140px; height: 40px; display: none; background-color: #8eb0ce">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'requestInventory-modal.php';?>
<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>

<?php include 'footer.php';?>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="script/update_targets.js?v=<?php echo time();?>"></script>
<script type="text/javascript" src="script/sidebar-script.js?v=<?php echo time();?>"></script>

<script type="text/javascript">
    $(document).ready(function(){
        App.init();
        Dashboard.init();
        $('.nav li').removeClass('active');
        $('#employeeDetailsLi').addClass('active');
        $('#kpiMgmtLi').addClass('active');
        $('#updateTargets').addClass('active');
    });
</script>