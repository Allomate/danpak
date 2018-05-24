<?php
require 'verify_permission.php';
include 'header.php';?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">
<style type="text/css">
    .dispatchItemsSpinner{
        right: 5px; 
        top: 6px; 
        width: 20px;
        height: 20px;
        display: none
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

<h1 class="page-header">Dispatch Inventory <small>Dispatch items to your desired location from this page</small></h1>

<div class="row">
    <div class="col-md-5">
        <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title">Inventory Dispatch</h4>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-md-3" style="text-align: center;line-height: 30px;">Inventory</label>
                    <div class="col-md-9">
                        <span id="totalInventAdded" style="line-height: 30px;">0</span>
                    </div>
                </div>
                <br><br>
                <div class="form-group">
                    <label class="col-md-3" style="text-align: center;line-height: 30px;">Location</label>
                    <div class="col-md-9">
                        <select class="form-control" id="franchises">
                            <?php
                            require_once 'database/config.php';
                            $sql = "SELECT franchise_id, franchise_name from franchise_info where company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param('s', $_COOKIE["US-K"]);
                            $stmt->execute();
                            $stmt->bind_result($id, $name);
                            while ($stmt->fetch()) {?>
                            <option value="<?php echo $id;?>"><?php echo $name;?></option>
                            <?php }
                            $stmt->close();
                            ?>
                        </select>
                    </div>
                </div>
                <br>
                <div class="form-group" style="padding-right: 10px">
                    <div class="form-group">
                        <div class="col-md-12">
                         <button type="button" class="btn btn-sm btn-success" id="dispatchItemsButton" style="width: 150px; height: 40px; float: right">
                            <img src="assets/raw/button-loader.gif" class='dispatchItemsSpinner'/>
                            <span id="dispatchItemsText">Dispatch</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-7">
    <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
            </div>
            <h4 class="panel-title">Inventory List</h4>
        </div>
        <div class="panel-body" style="height: 197px; overflow: auto;">

            <table class="table table-stripped" id="addedInventoryTable">
                <h5 id="emptyInventoryTitle">No items added to the inventory</h5>
            </table>

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
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" id="inventoryList" data-click="panel-reload-inventory"><i class="fa fa-repeat"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title">Inventory</h4>
            </div>
            <div class="panel-body">

                <table class="table table-stripped" id="inventoryTable">
                    <thead>
                        <tr>
                            <th>Barcode</th>
                            <th>Item</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Quantity</th>
                            <th>Required</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="inventoryTbody">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>

<?php include 'footer.php';?>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
<script src="assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="script/dispatch_items.js?v=<?php echo time();?>"></script>
<script type="text/javascript" src="script/sidebar-script.js?v=<?php echo time();?>"></script>

<script type="text/javascript">
    $(document).ready(function(){
        App.init();
        Dashboard.init();
        $('.nav li').removeClass('active');
        $('#warehouseLi').addClass('active');
        $('#dispatchItems').addClass('active');
    });
</script>