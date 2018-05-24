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
    <li class="active">Dashboard</li>
  </ol>
  <h1 class="page-header">Company Details <small>Add company and its locations from this page</small></h1>
  <div class="row">
    <!-- begin col-6 -->
    <div class="col-md-6">
      <!-- begin panel -->
      <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
        <div class="panel-heading">
          <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
          </div>
          <h4 class="panel-title">Company</h4>
        </div>
        <div class="panel-body">
          <form action="server_scripts/add_company.php" method="post" class="form-horizontal">
            <div class="form-group">
              <label class="col-md-3 control-label">Company Name</label>
              <div class="col-md-9">
                <input type="text" name="companyName" class="form-control" placeholder="Company Name" />
              </div>
            </div>
            <div class="row">
              <div class="form-group">
                <div class="col-md-9">
                  <button type="submit" class="btn btn-sm btn-success" style="float: right">Submit</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <!-- end panel -->
    </div>
    <!-- end col-6 -->
    <!-- begin col-6 -->
    <div class="col-md-6">
    </div>
    <!-- end col-6 -->
  </div>
</div>
<!-- end #content -->

<!-- begin scroll to top btn -->
<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>

<?php include 'footer.php';?>
<script type="text/javascript" src="script/sidebar-script.js?v=<?php echo time();?>"></script>

<script type="text/javascript">
  $(document).ready(function(){
    App.init();
    Dashboard.init();
    $('.nav li').removeClass('active');
    $('#companyDetailsLi').addClass('active');
    $('#companyDetailsLi #addCompany').addClass('active');
  });
</script>