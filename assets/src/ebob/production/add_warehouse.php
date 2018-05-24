<?php
$exist = false;
$addedWh = false;
if (isset($_COOKIE["warehouse_code_exist"])) {
    setcookie('warehouse_code_exist', null, -1, '/');
    $exist = true;
}
if (isset($_COOKIE["warehouse_added"])) {
    setcookie('warehouse_added', null, -1, '/');
    $addedWh = true;
}
require 'verify_permission.php';
include 'header.php';?>
<style type="text/css">
.spinnerButton, .updateWarehouseDetailsSpinner{
    right: 5px; 
    top: 6px; 
    width: 30px; 
    height: 30px;
    display: none;
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

    <h1 class="page-header">Warehouse Details <small>Add warehouse details from this page</small></h1>

    <div class="row">
        <div class="col-md-5">
            <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Warehouse Details</h4>
                </div>
                <div class="panel-body">
                    <form action="server_scripts/add_warehouse_details.php" method="post" class="form-horizontal" id="warehouseForm">
                        <?php
                        if ($exist) {?>
                        <div class="alert alert-warning">
                            <strong>Failed!</strong> <?php echo "Code: " . $_COOKIE["warehouse_code_exist"];?> already exist
                        </div>
                        <?php }
                        if ($addedWh) {?>
                        <div class="alert alert-success">
                            <strong>Added!</strong> Warehouse successfully added
                        </div>
                        <?php }
                        ?>
                        <div class="form-group">
                            <label class="col-md-3" style="text-align: center;line-height: 30px;">Warehouse Code</label>
                            <div class="col-md-9">
                                <input type="text" name="warehousecode" placeholder="Enter warehouse code" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3" style="text-align: center;line-height: 30px;">Name</label>
                            <div class="col-md-9">
                                <input type="text" name="warehouseName" placeholder="Enter warehouse name" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3" style="text-align: center;line-height: 30px;">Location</label>
                            <div class="col-md-9">
                                <input type="text" name="warehouseLocation" placeholder="Enter warehouse location" class="form-control">
                            </div>
                        </div>

                        <div class="form-group" style="padding-right: 10px">
                            <div class="form-group">
                                <label class="col-md-3" style="text-align: center;line-height: 30px;"></label>
                                <div class="col-md-9">
                                   <button type="button" class="btn btn-sm btn-success" id="submitForm" style="width: 150px; height: 40px; float: right">
                                    <img src="assets/raw/button-loader.gif" class='spinnerButton'/>
                                    <span id="submitBtnText">Submit</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title">Update Warehouse Details</h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group">
                        <label class="col-md-2">Warehouse Code</label>
                        <div class="col-md-5">
                            <select id="warehouseCode" class="form-control">
                                <?php
                                require_once 'database/config.php';
                                $sql = "SELECT warehouse_code from warehouse where company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param('s', $_COOKIE["US-K"]);
                                $stmt->execute();
                                $stmt->bind_result($code);
                                while ($stmt->fetch()) {?>
                                <option value="<?php echo $code;?>"><?php echo $code;?></option>
                                <?php }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="form-group">
                        <label class="col-md-4">
                            <h4>Warehouse Name</h4>
                        </label>
                        <div class="col-md-5">
                            <span id="warehouseName" style="font-size: 15px; line-height: 2.5;"></span>
                            <input type="text" class="form-control" id="warehouseNameInput" style="display: none" />
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="form-group">
                        <label class="col-md-4">
                            <h4>Warehouse Location</h4>
                        </label>
                        <div class="col-md-5">
                            <span id="warehouseLocation" style="font-size: 15px; line-height: 2.5;"></span>
                            <input type="text" class="form-control" id="warehouseLocationInput" style="display: none" />
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row" style="text-align: center;">
                    <button type="button" class="btn btn-sm btn-success" id="updateWarehouseDetailsButton" style="width: 150px; height: 40px;">
                        <img src="assets/raw/button-loader.gif" class='updateWarehouseDetailsSpinner'/>
                        <span id="updateWarehouseDetailsText">Update</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>

<?php include 'footer.php';?>
<script type="text/javascript" src="script/sidebar-script.js?v=<?php echo time();?>"></script>

<script type="text/javascript">
    $(document).ready(function(){
        App.init();
        Dashboard.init();
        $('.nav li').removeClass('active');
        $('#companyDetailsLi').addClass('active');
        $('#addWarehouse').addClass('active');
        
        $('#submitForm').click(function(e){
            e.preventDefault();
            $('#submitBtnText').hide();
            $('.spinnerButton').fadeIn();
            $('#warehouseForm').submit();
        });

        $.ajax({
            type: 'POST',
            url: 'ajax_scripts/getWarehouseDetails.php',
            data: { code: $('#warehouseCode').val() },
            success: function(response){
                var response = JSON.parse(response);
                $('#warehouseLocation').text(response[0].location);
                $('#warehouseName').text(response[0].name);
                $('#warehouseLocationInput').val(response[0].location);
                $('#warehouseNameInput').val(response[0].name);
            }
        });

        $('#updateWarehouseDetailsButton').click(function(){
            if ($(this).find('#updateWarehouseDetailsText').text() == "Update") {
                $('#warehouseLocation').hide();
                $('#warehouseName').hide();
                $('#warehouseLocationInput').fadeIn();
                $('#warehouseNameInput').fadeIn();
                $(this).find('#updateWarehouseDetailsText').text("Save");
                $(this).removeClass('btn-success');
                $(this).addClass('btn-default');
            }else{
                $(this).find('.updateWarehouseDetailsSpinner').fadeIn();
                $(this).find('#updateWarehouseDetailsText').hide();
                $('button').attr('disabled', true);
                $.ajax({
                    url: 'ajax_scripts/updateWarehouseDetails.php',
                    type: 'POST',
                    data: { name: $('#warehouseNameInput').val(), location: $('#warehouseLocationInput').val(),
                    code: $('#warehouseCode').val() },
                    success: function(response){
                        if (response == "Success") {
                            $('#warehouseLocation').fadeIn();
                            $('#warehouseName').fadeIn();
                            $('#warehouseLocationInput').hide();
                            $('#warehouseNameInput').hide();
                            $('#warehouseLocation').text($('#warehouseLocationInput').val());
                            $('#warehouseName').text($('#warehouseNameInput').val());
                            $('#updateWarehouseDetailsButton').addClass('btn-success');
                            $('#updateWarehouseDetailsButton').removeClass('btn-default');
                            $('button').attr('disabled', false);
                            $('#updateWarehouseDetailsButton').find('.updateWarehouseDetailsSpinner').hide();
                            $('#updateWarehouseDetailsButton').find('#updateWarehouseDetailsText').fadeIn();
                            $('#updateWarehouseDetailsButton').find('#updateWarehouseDetailsText').text("Update");
                        }else{
                            swal('Failed', 'Unable to update warhouse details right now', 'error');
                            $('#updateWarehouseDetailsButton').addClass('btn-success');
                            $('#updateWarehouseDetailsButton').removeClass('btn-default');
                            $('button').attr('disabled', false);
                        }
                    }
                });
            }
        });

        $('#warehouseCode').change(function(){
            $.ajax({
                type: 'POST',
                url: 'ajax_scripts/getWarehouseDetails.php',
                data: { code: $(this).val() },
                success: function(response){
                    var response = JSON.parse(response);
                    $('#warehouseLocation').text(response[0].location);
                    $('#warehouseName').text(response[0].name);
                    $('#warehouseLocationInput').val(response[0].location);
                    $('#warehouseNameInput').val(response[0].name);
                }
            });
        });

    });
</script>