<?php
require 'verify_permission.php';
include 'header.php';?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">
<style type="text/css">
    .requestInventSpinner, .requestSpinner, .acceptInventorySpinner, .acceptAllSpinner, .deleteInventSpinner, .dispatchLocationInventorySpinner, .requestSentSpinner{
        right: 5px; 
        top: 6px; 
        width: 20px; 
        height: 20px;
        display: none
    }

    #inventoryTable thead tr th{
        width: auto !important
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

    <h1 class="page-header">Location Inventory <small>View your location inventory from this page</small></h1>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" id="locationInventory" data-click="panel-reload-inventory"><i class="fa fa-repeat"></i></a>
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
                                <th>Added on</th>
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

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" id="pendingInventory" data-click="panel-reload-inventory"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Pending Inventory</h4>
                </div>
                <div class="panel-body">


                    <table class="table table-stripped" id="pendingInventoryTable">
                        <thead>
                            <tr>
                                <th>Barcode</th>
                                <th>Item</th>
                                <th>Color</th>
                                <th>Size</th>
                                <th>Quantity</th>
                                <th>Added on</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="pendingInventoryTbody">
                        </tbody>
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
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" id="requestInventToLocation" data-click="panel-reload-inventory"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Inventory Requests from location</h4>
                </div>
                <div class="panel-body">
                    <table class="table table-stripped" id="requestToLocationInventoryTable">
                        <thead>
                            <tr>
                                <th>Barcode</th>
                                <th>Item</th>
                                <th>Color</th>
                                <th>Size</th>
                                <th>Quantity</th>
                                <th>Request To</th>
                                <th>Request From</th>
                                <th>Requested On</th>
                                <th>Sent from Location</th>
                                <th>Received at location</th>
                                <th>Stock</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="locationRequestInventoryTbody">
                        </tbody>
                    </table>
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
<script type="text/javascript" src="script/location_inventory.js?v=<?php echo time();?>"></script>
<script type="text/javascript" src="script/sidebar-script.js?v=<?php echo time();?>"></script>

<script type="text/javascript">
    $(document).ready(function(){
        App.init();
        Dashboard.init();
        $('.nav li').removeClass('active');
        $('#inventoryLi').addClass('active');
        $('#locationInvent').addClass('active');
    });
</script>