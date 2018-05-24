<?php
require 'verify_permission.php';
include 'header.php';?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">
<style type="text/css">
.confirmNumberSpinner, .newCustomerModalSpinner, .createSaleSpinner{
    right: 5px; 
    top: 6px; 
    width: 20px; 
    height: 20px;
    display: none
}

#receiptItemsList li{
    display: inline;
    margin-right: 10px
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

<h1 class="page-header">Item Selling <small>You can create a sale from this page</small></h1>

<div class="row">
    <div class="col-md-7">
        <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title">User information</h4>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-md-3 control-label" style="line-height: 40px;">Customer Phone:</label>
                    <div class="col-md-9" style="padding: 0px">
                        <div class="row">
                            <div class="col-md-7">
                                <input type="text" id="phoneNumber" class="form-control" placeholder="Enter customer's phone number" style="height: 40px">
                            </div>
                            <div class="col-md-5">
                                <button type="button" class="btn btn-sm btn-success" style="width: 50%; height: 40px" id="confirmNumberButton">
                                    <img src="assets/raw/view-details-loader.gif" class='confirmNumberSpinner'/>
                                    <span id="confirmNumberText">Confirm</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-success" style="width: 40%; height: 40px" id="addNewBtn">New</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'new-customer-modal.php';?>
    <div class="col-md-5">
        <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title">Receipt Items</h4>
            </div>
            <div class="panel-body">
                <br>
                <div class="form-group">
                    <ul id="receiptItemsList" style="list-style: none; padding: 0px">
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-7">
        <div class="panel panel-inverse itemDetailsPanel" data-sortable-id="form-stuff-1">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title">Item Details</h4>
            </div>
            <div class="panel-body">
                <input type="text" id="itemBarcodeFetch" placeholder="Item Barcode" class="form-control" style="width: 20%; display: inline;" />
                <input type="text" id="itemNameFetch" placeholder="Item Name (Even match case)" class="form-control" style="width: 79%; display: inline;"/>

                <div id="addItemsFormDiv" style="display: none">
                    <form class="form-horizontal" enctype="multipart/form-data" id="addItemsForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label" style="text-align: center;">Name:</label>
                                    <div class="col-md-9" style="padding-top: 8px; padding-left: 20px;">
                                        <span id="itemName">Name</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" style="text-align: center;">Stock</label>
                                    <div class="col-md-9" style="padding-top: 8px; padding-left: 20px;">
                                        <span id="itemQuantityInStock">100</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" style="text-align: center;">Color</label>
                                    <div class="col-md-9" style="padding-top: 8px; padding-left: 20px;">
                                        <span id="itemColor">Blue</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" style="text-align: center;">Size</label>
                                    <div class="col-md-9" style="padding-top: 8px; padding-left: 20px;">
                                        <span id="itemSize">XXL</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" style="text-align: center;">Barcode</label>
                                    <div class="col-md-9" style="padding-top: 8px; padding-left: 20px;">
                                        <span id="itemBarcode">11223410</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" style="text-align: center;">Image</label>
                                    <div class="col-md-9" style="padding-top: 8px; padding-left: 20px;">
                                        <img src="" id="itemImage" width="auto" height="150px" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label" style="text-align: center;">Brand</label>
                                    <div class="col-md-9" style="padding-top: 8px; padding-left: 20px;">
                                        <span id="itemBrand">Sana Safinaz</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" style="text-align: center;">Sell</label>
                                    <div class="col-md-9" style="padding-top: 8px; padding-left: 20px;">
                                        <span id="itemSell">20000</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" style="text-align: center;">Expiry</label>
                                    <div class="col-md-9" style="padding-top: 8px; padding-left: 20px;">
                                        <span id="itemExpiry">2017-09-27</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" style="text-align: center;">Quantity</label>
                                    <div class="col-md-9" style="padding-top: 8px; padding-left: 20px;">
                                        <input type="text" id="quantitySold" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" style="text-align: center;">Category</label>
                                    <div class="col-md-9" style="padding-top: 8px; padding-left: 20px;">
                                        <span id="itemCategory">Men</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label class="col-md-2 control-label" style="text-align: center;">Description</label>
                                <div class="col-md-10" style="padding-top: 8px; padding-left: 20px;">
                                    <span id="itemDescription"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="showMultipleItemsTable" style="display: none">
                    <table class="table table-stripped">
                        <thead>
                            <tr>
                                <th>Barcode</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title">Electronic Receipt</h4>
            </div>
            <div class="panel-body confirmSaleBody" style="text-align: center">
                <!-- <strong>Final Receipt will be printed here</strong> -->
                <table class="table table-stripped" style="display: none">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Qty.</th>
                            <th>Each</th>
                            <th>Discount</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: left;">
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
                <div class="row" id="paymentMethodDiv" style="display: none">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label class="col-md-3">Payment Method</label>
                            <div class="col-md-9">
                                <input type="radio" name="payment_method" value="cash" checked> Cash
                                &nbsp;&nbsp;&nbsp;
                                <input type="radio" name="payment_method" value="card"> Card
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row" id="selectEmpDivatSale" style="display: none">
                    <div class="form-group">
                        <label class="col-md-2" style="line-height: 35px">Sold by</label>
                        <div class="col-md-9">
                            <select class="form-control" id="employeeId">
                             <option disabled="disabled" selected="selected" value="none">Select employee</option>
                             <?php 
                             require_once 'database/config.php';
                             $sql = "SELECT employee_id, employee_username from employees_info where franchise_id = (SELECT franchise_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
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
             </div>
             <br>
             <button type="button" class="btn btn-sm btn-success" id="createSaleButton" style="width: 100%; height: 40px; display: none">
                <img src="assets/raw/view-details-loader.gif" class='createSaleSpinner'/>
                <span id="createSaleText">Create Sale</span>
            </button>
        </div>
    </div>
</div>
</div>
<div class="row">
    <div class="col-md-7">
        <div class="panel panel-inverse itemSalePanel" data-sortable-id="form-stuff-1">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title">Sale Details</h4>
            </div>
            <div class="panel-body">
                <input type="text" id="saleTokenFetch" placeholder="Sale Token" class="form-control" style="width: 20%; display: inline;" />
                &nbsp;&nbsp;&nbsp;OR&nbsp;&nbsp;&nbsp;
                <select class="form-control" id="employeeIdFetch" style="width: 60%; display: inline;">
                 <option disabled="disabled" selected="selected" value="none">Select employee</option>
                 <?php 
                 require_once 'database/config.php';
                 $sql = "SELECT employee_id, employee_username from employees_info where franchise_id = (SELECT franchise_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
                 $stmt = $conn->prepare($sql);
                 $stmt->bind_param('s', $_COOKIE["US-K"]);
                 $stmt->execute();
                 $stmt->bind_result($id, $username);
                 while ($stmt->fetch()) {?>
                 <option value="<?php echo $id;?>"><?php echo $username;?></option>
                 <?php }
                 ?>
             </select>
             <button class="btn btn-primary" id="fetchSale">Find Sale</button>
             <div id="saleReceipt" style="display: none">
                 <hr>
                 <table class="table table-stripped">
                     <thead>
                         <tr>
                            <th>Barcode</th>
                            <th>Name</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3">Total</th>
                            <th> <span id="totalPriceSale"></span> </th>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </div>
</div>
</div>
</div>
</div>
<?php require 'viewSale-modal.php';?>
<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>

<?php include 'footer.php';?>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="script/item_sale.js?v=<?php echo time();?>"></script>
<script type="text/javascript" src="script/sidebar-script.js?v=<?php echo time();?>"></script>

<script type="text/javascript">
    $(document).ready(function(){
        App.init();
        Dashboard.init();
        $('.nav li').removeClass('active');
        $('#postSetupLi').addClass('active');
        $('#postSetupLi #itemSale').addClass('active');
    });
</script>