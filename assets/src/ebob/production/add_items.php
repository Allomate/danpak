<?php
require 'verify_permission.php';
include 'header.php';?>
<style type="text/css">
.spinnerButton, .uploadBulkSpinner, .downloadCsvSampleSpinner{
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

    <h1 class="page-header">Item Details <small>Add item details from this page</small></h1>

    <div class="row">
        <div class="col-md-7">
            <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Item Details</h4>
                </div>
                <div class="panel-body">
                    <form method="post" class="form-horizontal" enctype="multipart/form-data" id="addItemsForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label" style="text-align: center;">Name:</label>
                                    <div class="col-md-9">
                                        <input type="text" name="itemName" class="form-control" placeholder="Enter item name" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" style="text-align: center;">Purchase</label>
                                    <div class="col-md-9">
                                        <input type="number" name="itemPurchasedPrice" class="form-control" placeholder="Enter item purchase price" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" style="text-align: center;">Color</label>
                                    <div class="col-md-9">
                                        <input type="text" name="itemColor" class="form-control" placeholder="Enter item color" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" style="text-align: center;">Size</label>
                                    <div class="col-md-9">
                                        <input type="text" name="itemSize" class="form-control" placeholder="Enter item size">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" style="text-align: center;">Barcode</label>
                                    <div class="col-md-9">
                                        <input type="text" name="itemBarcode" class="form-control" placeholder="Enter item barcode">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" style="text-align: center;">Image</label>
                                    <div class="col-md-9">
                                        <input type="file" name="itemImage[]" class="filestyle form-control" data-input="false" multiple="multiple" accept=".png,.jpg,.bmp,.jpeg">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label" style="text-align: center;">Brand</label>
                                    <div class="col-md-9">
                                        <input type="text" name="itemBrand" class="form-control" placeholder="Enter item brand">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" style="text-align: center;">Sell</label>
                                    <div class="col-md-9">
                                        <input type="number" name="itemSellingPrice" class="form-control" placeholder="Enter item selling price">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" style="text-align: center;">Quantity</label>
                                    <div class="col-md-9">
                                        <input type="number" name="itemQuantity" class="form-control" placeholder="Enter item quantity" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" style="text-align: center;">Expiry</label>
                                    <div class="col-md-9">
                                        <div class='input-group date' id='itemExpInput'>
                                            <input type='text' name="itemExpiry" class="form-control expiryText" />
                                            <span class="input-group-addon">
                                              <span class="glyphicon glyphicon-calendar">
                                              </span>
                                          </span>
                                      </div>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-md-3 control-label" style="text-align: center;">Warehouse</label>
                                  <div class="col-md-9">
                                    <?php
                                    require_once 'database/config.php';
                                    $stmt = $conn->prepare("SELECT warehouse_id, warehouse_name from warehouse where company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))");
                                    $stmt->bind_param('s', $_COOKIE["US-K"]);
                                    $stmt->execute();
                                    $stmt->bind_result($wId, $wName);?>
                                    <select class="form-control" name="warehouse">
                                        <?php while ($stmt->fetch()) {?>
                                        <option value="<?php echo $wId;?>"><?php echo $wName;?></option>
                                        <?php }
                                        $stmt->close();
                                        ?>
                                    </select>  
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group" style="text-align: center">
                                <label class="control-label" style="text-align: center;">Main Category</label>
                                <div class="col-md-12">
                                    <?php
                                    require_once 'database/config.php';
                                    $sql = "SELECT category_id, category_name from main_categories where company_category_id = ( SELECT company_category_id from company_info where company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))) order by category_name";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param('s', $_COOKIE["US-K"]);
                                    $stmt->execute();
                                    $stmt->bind_result($catId, $catName);?>
                                    <select class="form-control" id="mainCategoryDD">
                                        <?php while ($stmt->fetch()) {?>
                                        <option value="<?php echo $catId;?>"><?php echo $catName;?></option>
                                        <?php }
                                        $stmt->close();
                                        ?>
                                    </select>  
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4" id="subCategoryDiv" style="display: none">
                            <div class="form-group" style="text-align: center;">
                                <label class="control-label" style="text-align: center;">Sub Category</label>
                                <div class="col-md-12">

                                    <select class="form-control" id="subCatDD">
                                    </select>  
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4" id="prodCategoryDiv" style="display: none">
                            <div class="form-group" style="text-align: center">
                                <label class="control-label" style="text-align: center;">Item Category</label>
                                <div class="col-md-12">
                                    <select class="form-control" id="prodCategoryDD" name="prodCategory">
                                    </select>  
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-2 control-label" style="text-align: center;">Description</label>
                            <div class="col-md-10">
                                <textarea class="form-control" name="itemDescription" rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-sm btn-success" id="submitForm" style="width: 100%; height: 40px">
                                <img src="assets/raw/view-details-loader.gif" class='spinnerButton'/>
                                <span id="submitBtnText">Submit</span>
                            </button>
                        </div>
                        <div class="col-md-4">
                        </div>
                    </div>
                </form>
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
                    <strong>Failed!</strong> Following barcodes are not added due to wrong formatting
                    <br>
                    <span id="errorsThrown"></span>
                </div>
                <div id="failedUploadsTable" style="display: none">
                    <table class="table table-stripped">
                        <thead>
                            <tr>
                                <th>Barcode</th>
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
                    <a href="csv-sheet/sample-items.csv"> 
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

<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>

<?php include 'footer.php';?>
<script src="http://malsup.github.com/jquery.form.js"></script> 
<script src="assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="script/sidebar-script.js?v=<?php echo time();?>"></script>
<script type="text/javascript" src="script/add_items.js?v=<?php echo time();?>"></script>

<style type="text/css">
.modals {
    display:    none;
    position:   fixed;
    z-index:    1000;
    top:        0;
    left:       0;
    height:     100%;
    width:      100%;
    background: rgba( 255, 255, 255, .8 ) 
    url('assets/raw/loading.gif?v=<?php echo time();?>') 
    50% 50% 
    no-repeat;
}

body.loading {
    overflow: hidden;   
}

body.loading .modals {
    display: block;
}
</style>

<div class="modals"></div>