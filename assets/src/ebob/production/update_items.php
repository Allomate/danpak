<?php
require 'verify_permission.php';
include 'header.php';?>
<style type="text/css">
    .viewDetailsLoader, .updateDetailsLoader, .deleteItemLoader{
        right: 5px; 
        top: 6px; 
        width: 40px; 
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

<h1 class="page-header">Item Details <small>Add item details from this page</small></h1>
<div class="row">
    <div class="col-md-12">
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
                <table class="table table-stripped" id="viewDetailsTable">
                    <thead>
                        <tr>
                            <th>Barcode</th>
                            <th>Name</th>
                            <th>Size</th>
                            <th>Color</th>
                            <th>Quantity</th>
                            <th>Category</th>
                            <th style="width: 205px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once 'database/config.php';
                        $sql = "SELECT item_id, item_barcode, item_name, item_size, item_color, item_quantity, (SELECT product_category_name from product_categories where product_category_id = warehouse_inventory.category_id) as category, (SELECT category_name from main_categories where category_id = (SELECT main_category_id from sub_categories where sub_category_id = (SELECT sub_category_id from product_categories where product_category_id = warehouse_inventory.category_id))) as main_category from warehouse_inventory where company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param('s', $_COOKIE["US-K"]);
                        $stmt->execute();
                        $stmt->bind_result($id, $barcode, $name, $size, $color, $quantity, $category, $main_category);
                        while ($stmt->fetch()) {?>

                        <tr id="<?php echo $id;?>">
                            <td><?php echo $barcode;?></td>
                            <td><?php echo $name;?></td>
                            <td><?php echo $size;?></td>
                            <td><?php echo $color;?></td>
                            <td><?php echo $quantity;?></td>
                            <td><?php echo "<strong>".$main_category."</strong> - " . $category;?></td>
                            <td class="buttonTd">
                                <button class="btn btn-info viewItemDetails" id="<?php echo $id;?>" style="font-size: 12px;">
                                    <img src="assets/raw/view-details-loader.gif" class="viewDetailsLoader">
                                    <span id="viewDetailsText">View Details</span>
                                </button>
                                <!-- <button class="btn btn-warning deleteItem" id="<?php echo $id;?>" style="font-size: 12px;">
                                    <img src="assets/raw/view-details-loader.gif" class="deleteItemLoader">
                                    <span id="deleteItemText">Delete</span>
                                </button> -->
                            </td>
                        </tr>
                        <?php }
                        $stmt->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php require 'viewDetails-items-modal.php';?>
</div>

<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>

<?php include 'footer.php';?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
<script src="http://malsup.github.com/jquery.form.js"></script>
<script type="text/javascript" src="script/update-items.js?v=<?php echo time();?>"></script>
<script type="text/javascript" src="script/sidebar-script.js?v=<?php echo time();?>"></script>

<script type="text/javascript">
    $(document).ready(function(){
        App.init();
        Dashboard.init();
        $('.nav li').removeClass('active');
        $('#warehouseLi').addClass('active');
        $('#itemsLi').addClass('active');
        $('#updateItems').addClass('active');
        
        $('#submitForm').click(function(e){
            e.preventDefault();
            $('#submitBtnText').hide();
            $('.spinnerButton').fadeIn();
            $('#addItemsForm').submit();
        });
        
        $('#itemExpInput').datepicker({
            format: 'yyyy-mm-dd'
        });
    });
</script>