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
            <div class="col-md-4">
                <div class="form-group">
                    <label>Company</label>
                    <select class="form-control" id="companyId">
                        <?php 
                        require_once 'database/config.php';
                        $sql = "SELECT company_id, company_name from company_info where company_id in (SELECT company_id from franchise_info)";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $stmt->bind_result($id, $company);
                        while ($stmt->fetch()) {?>
                        <option value="<?php echo $id;?>"><?php echo $company;?></option>
                        <?php }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title">Company Details</h4>
                    </div>
                    <div class="panel-body">
                        <form action="server_scripts/update_company.php" method="POST" id="updateCompanyForm">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        <label>Company Name</label>
                                    </div>
                                    <div class="col-md-8">
                                        <span id="companyName"></span>
                                        <input type="text" class="form-control" name="companyName" id="companyNameInput" style="display: none">
                                        <input type="text" class="form-control" name="companyId" id="companyIdInput" style="display: none">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <br>
                        <div>
                            <button type="button" id="updateCompany" class="btn btn-sm btn-success" style="width: 100%; height: 40px">Update</button>
                            <button type="button" id="cancelButton" class="btn btn-sm btn-default" style="width: 29%; height: 40px; display: none">Cancel</button>
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
<script type="text/javascript" src="script/update_company_script.js?v=<?php echo time();?>"></script>
<script type="text/javascript" src="script/sidebar-script.js?v=<?php echo time();?>"></script>

<script type="text/javascript">
    $(document).ready(function(){
        App.init();
        Dashboard.init();
        $('.nav li').removeClass('active');
        $('#companyDetailsLi').addClass('active');
        $('#companyDetailsLi #updateCompany').addClass('active');
    });
</script>