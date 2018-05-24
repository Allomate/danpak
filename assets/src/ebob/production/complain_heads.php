<?php 
require 'verify_permission.php';
include 'header.php';?>
<div id="page-loader" class="fade in"><span class="spinner"></span></div>
<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
  <div id="header" class="header navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
      <div class="navbar-header">
        <a href="index.html" class="navbar-brand"><span class="navbar-logo"></span> Color Admin</a>
        <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>
      <ul class="nav navbar-nav navbar-right">
        <li>
          <form class="navbar-form full-width">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Enter keyword" />
              <button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
            </div>
          </form>
        </li>
        <li class="dropdown">
          <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle f-s-14">
            <i class="fa fa-bell-o"></i>
            <span class="label">5</span>
          </a>
          <ul class="dropdown-menu media-list pull-right animated fadeInDown">
            <li class="dropdown-header">Notifications (5)</li>
            <li class="media">
              <a href="javascript:;">
                <div class="media-left"><i class="fa fa-bug media-object bg-red"></i></div>
                <div class="media-body">
                  <h6 class="media-heading">Server Error Reports</h6>
                  <div class="text-muted f-s-11">3 minutes ago</div>
                </div>
              </a>
            </li>
            <li class="media">
              <a href="javascript:;">
                <div class="media-left"><img src="assets/img/user-1.jpg" class="media-object" alt="" /></div>
                <div class="media-body">
                  <h6 class="media-heading">John Smith</h6>
                  <p>Quisque pulvinar tellus sit amet sem scelerisque tincidunt.</p>
                  <div class="text-muted f-s-11">25 minutes ago</div>
                </div>
              </a>
            </li>
            <li class="media">
              <a href="javascript:;">
                <div class="media-left"><img src="assets/img/user-2.jpg" class="media-object" alt="" /></div>
                <div class="media-body">
                  <h6 class="media-heading">Olivia</h6>
                  <p>Quisque pulvinar tellus sit amet sem scelerisque tincidunt.</p>
                  <div class="text-muted f-s-11">35 minutes ago</div>
                </div>
              </a>
            </li>
            <li class="media">
              <a href="javascript:;">
                <div class="media-left"><i class="fa fa-plus media-object bg-green"></i></div>
                <div class="media-body">
                  <h6 class="media-heading"> New User Registered</h6>
                  <div class="text-muted f-s-11">1 hour ago</div>
                </div>
              </a>
            </li>
            <li class="media">
              <a href="javascript:;">
                <div class="media-left"><i class="fa fa-envelope media-object bg-blue"></i></div>
                <div class="media-body">
                  <h6 class="media-heading"> New Email From John</h6>
                  <div class="text-muted f-s-11">2 hour ago</div>
                </div>
              </a>
            </li>
            <li class="dropdown-footer text-center">
              <a href="javascript:;">View more</a>
            </li>
          </ul>
        </li>
        <li class="dropdown navbar-user">
          <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
            <img src="assets/img/user-13.jpg" alt="" /> 
            <span class="hidden-xs">Adam Schwartz</span> <b class="caret"></b>
          </a>
          <ul class="dropdown-menu animated fadeInLeft">
            <li class="arrow"></li>
            <li><a href="javascript:;">Edit Profile</a></li>
            <li><a href="javascript:;"><span class="badge badge-danger pull-right">2</span> Inbox</a></li>
            <li><a href="javascript:;">Calendar</a></li>
            <li><a href="javascript:;">Setting</a></li>
            <li class="divider"></li>
            <li><a href="javascript:;">Log Out</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>

  <?php include 'sidebar.php';?>
  <div id="content" class="content">
   <ol class="breadcrumb pull-right">
    <li><a href="javascript:;">Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
  <h1 class="page-header">Complain Heads Details <small>Add complain heads and subheads from this page</small></h1>
  <div class="row">
    <!-- begin col-6 -->
    <div class="col-md-4">
      <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
        <div class="panel-heading">
          <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
          </div>
          <h4 class="panel-title">Adding Complain Heads</h4>
        </div>
        <div class="panel-body">
          <form action="server_scripts/add_complain_head.php" method="post">
            <div class="form-group">
              <label>Complain Head Name:</label>
              <input type="text" class="form-control" name="complainHeadName" placeholder="Complain Head Name">
            </div>
            <div class="form-group">
              <label>Complain Head Department:</label>
              <select name="departments" class="form-control">
                <?php
                require_once 'database/config.php';
                $sql = "select department_id, department_name from departments_info";
                $stmt=$conn->prepare($sql);
                $stmt->execute();
                $stmt->bind_result($departmentId, $departmentName);
                while($stmt->fetch()){?>
                <option value="<?php echo $departmentId?>"><?php echo $departmentName;?></option>
                <?php }?>
              </select>

            </div>
            <input type="submit" class="btn btn-info" style="float: right">
          </form>
        </div>
      </div>
      <!-- end panel -->
    </div>
    <div class="col-md-8">
      <!-- begin panel -->
      <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
        <div class="panel-heading">
          <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
          </div>
          <h4 class="panel-title">Adding Complain Subheads</h4>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-md-3">
              <label>Sub-Head Levels</label>
              <select id="subHeadLevels" class="form-control">
                <option value="1">Level 1</option>
                <option value="2">Level 2</option>
                <option value="3">Level 3</option>
              </select>
            </div>
          </div>
          <hr>
          <form action="server_scripts/add_complain_subhead.php" method="post">
            <div class="form-group">
              <label>Select Complain Head:</label>
              <select name="complainHead" class="form-control" id="complainHead">
                <?php
                require_once 'database/config.php';
                $sql = "select id, complain_head from complain_heads";
                $stmt=$conn->prepare($sql);
                $stmt->execute();
                $stmt->bind_result($id, $complain_head);
                while($stmt->fetch()){?>
                <option value="<?php echo $id?>"><?php echo $complain_head;?></option>
                <?php }?>
              </select>
            </div>
            <div class="form-group">
              <label>Complain Sub-Head Level 1:</label>
              <div id="subHeadLevel1">
                <input type="text" class="form-control" name="complainSubHeadLevel1" placeholder="Complain Sub-Head Level 1 Name">
              </div>
            </div>
            <div class="form-group" id="subHeadLevel2Div">
              <label>Complain Sub-Head Level 2:</label>
              <div id="subHeadLevel2">
                <input type="text" class="form-control" name="complainSubHeadLevel2" placeholder="Complain Sub-Head Level 2 Name">
              </div>
            </div>
            <div class="form-group" id="subHeadLevel3Div">
              <label>Complain Sub-Head Level 3:</label>
              <div id="subHeadLevel3">
                <input type="text" class="form-control" name="complainSubHeadLevel3" placeholder="Complain Sub-Head Level 3 Name">
              </div>
            </div>
            <input type="text" name="level" id="level" hidden>
            <input type="submit" class="btn btn-info" style="float: right">
          </form>
        </div>
      </div>
      <!-- end panel -->
    </div>
    <div class="col-md-6">
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
          <h4 class="panel-title">Company TAT deadline</h4>
        </div>
        <div class="panel-body">
          <form action="server_scripts/assign_tat_deadline.php" method="post">
            <div class="form-group">
              <label>Assign Time (Hrs):</label>
              <input type="number" class="form-control" name="tatDeadline" placeholder="24">
            </div>
            <input type="submit" class="btn btn-info" style="float: right">
          </form>
        </div>
      </div>
      <!-- end panel -->
    </div>
  </div>
</div>
<!-- end #content -->

<!-- begin scroll to top btn -->
<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>

<?php include 'footer.php';?>
<script type="text/javascript" src="script/sidebar-script.js?v=<?php echo time();?>"></script>
<script type="text/javascript" src="script/add_complain_subhead.js?v=<?php echo time();?>"></script>

<script type="text/javascript">
  $(document).ready(function(){
    App.init();
    Dashboard.init();
    $('#complaintMgmtLi').addClass('active');
    $('#subheadsLi').addClass('active');
  });
</script>