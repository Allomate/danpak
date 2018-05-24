<?php
require 'verify_permission.php';
include 'header.php';?>
<div id="page-loader" class="fade in"><span class="spinner"></span></div>
<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
 <?php include 'navbar.php';?>
 <?php include 'sidebar.php';?>

 <div id="content" class="content">
   <ol class="breadcrumb pull-right">
    <li><a href="javascript:;">Home</a></li>
    <li class="active">Locations</li>
</ol>

<h1 class="page-header">Customer Base <small>See your customer base</small></h1>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title">Customer Base</h4>
            </div>
            <div class="panel-body">
                <table class="table table-stripped" id="viewDetailsTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Age</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once 'database/config.php';
                        $sql = "SELECT `user_id`, `user_name`, `user_age`, `user_email`, `user_gender`, `user_phone`, `user_address`, `user_dp`, `user_city`, `user_country`, `user_login_type`, `user_active`, `created_at` FROM `users`";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $stmt->bind_result($user_id, $user_name, $user_age, $user_email, $user_gender, $user_phone, $user_address, $user_dp, $user_city, $user_country, $user_login_type, $user_active, $created_at);
                        while ($stmt->fetch()) {?>

                        <tr id="<?php echo $user_id;?>">
                            <td><?php echo $user_name;?></td>
                            <td><?php echo $user_gender;?></td>
                            <td><?php echo $user_age;?></td>
                            <td><?php echo $user_phone;?></td>
                            <td><?php echo $user_address;?></td>
                            <td><?php echo $user_city;?></td>
                            <td><?php echo $created_at;?></td>
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