<?php
require 'verify_permission.php';
include 'header.php';?>
<link href="assets/plugins/isotope/isotope.css" rel="stylesheet" />
<link href="assets/plugins/lightbox/css/lightbox.css" rel="stylesheet" />
<style type="text/css">
.spinnerButton{
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
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li class="active">Gallery</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Inventory Gallery <small>You can view all of the inventory from this page</small></h1>
    <!-- end page-header -->
    <div id="gallery" class="gallery">
        <?php
        require_once 'database/config.php';
        $sql = "SELECT `item_id`, `item_barcode`, `item_name`, `item_brand`, `item_image`, `item_description`, `discount_available`, `discount_active`, (SELECT product_category_name from product_categories where product_category_id = lbi.category_id) FROM `location_based_inventory` lbi WHERE franchise_id = (SELECT franchise_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $_COOKIE["US-K"]);
        $stmt->execute();
        $stmt->bind_result($itemId, $barcode, $name, $brand, $image, $description, $discountAvailable, $discountActive, $category);
        $galleryGroupCounter = 1;
        while ($stmt->fetch()) {?>
        <div class="image gallery-group-<?php echo $galleryGroupCounter;?>">
            <div class="image-inner">
                <a href="<?php echo $image;?>" data-lightbox="gallery-group-<?php echo $galleryGroupCounter;?>">
                    <?php
                    if (!$image) {?>
                    <img src="<?php echo 'uploads/item_images/no-preview.jpg';?>" alt="" style="min-height: 200px; margin: 0 auto; display: block; width: auto" />
                    <?php }else{?>
                    <img src="<?php echo $image;?>" alt="" style="min-height: 200px;" />
                    <?php }?>
                </a>
                <p class="image-caption">
                    <?php echo $name;?>
                </p>
            </div>
            <div class="image-info">
                <h5 class="title"><?php echo $barcode;?></h5>
                <div class="pull-right">
                    <a style="cursor: pointer; text-decoration: none" id="<?php echo $itemId;?>" class="viewDetailBtn">View Detail</a>
                </div>
                <div class="rating">
                    <span class="star active"></span>
                    <span class="star active"></span>
                    <span class="star active"></span>
                    <span class="star"></span>
                    <span class="star"></span>
                </div>
                <div class="desc">
                    <?php echo $description;?>
                </div>
            </div>
        </div>
        <?php 
        $galleryGroupCounter++; }
        $stmt->close(); ?>
    </div>
</div>
<!-- end #content -->

<?php 
require_once 'viewDetails-warehouseGallery-modal.php';
include 'footer.php';?>
<script src="assets/plugins/isotope/jquery.isotope.min.js"></script>
<script src="assets/plugins/lightbox/js/lightbox.min.js"></script>
<script src="assets/js/gallery.demo.min.js"></script>
<script type="text/javascript" src="script/location_gallery_script.js?v=<?php echo time();?>"></script>
<script type="text/javascript" src="script/sidebar-script.js?v=<?php echo time();?>"></script>

<script type="text/javascript">
    $(document).ready(function(){
        App.init();
        Gallery.init();
        $('.nav li').removeClass('active');
        $('#inventoryLi').addClass('active');
        $('#locationInventGallery').addClass('active');
    });
</script>