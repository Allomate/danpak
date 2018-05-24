<?php
include 'header.php';?>
<div id="page-loader" class="fade in"><span class="spinner"></span></div>
<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
 <?php include 'navbar.php';?>
 <?php include 'sidebar.php';?>

 <style type="text/css">
 ul#repetitiveAndDistinctComplainReports li{
    list-style: none
}
ul#repetitiveAndDistinctComplainReports ul li{
    display: inline
}

ul#repetitiveAndDistinctComplainReports ul{
    display: inline-block;
    border: 1px solid #c4c4e2;
    border-radius: 1em;
    padding: 20px;
    background-color: #f6f9f9;
    margin-left: 20px;
}
</style>

<div id="content" class="content">
   <ol class="breadcrumb pull-right">
    <li><a href="javascript:;">Home</a></li>
    <li class="active">Locations</li>
</ol>

<h1 class="page-header">All Reports</h1>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title">All Reports</h4>
            </div>
            <div class="panel-body">
                <ul id="repetitiveAndDistinctComplainReports">
                    <li>
                        1- 
                        <div class="form-group" style="display: inline-block;">
                            <label>Total Repeative and Distinct Complains</label>
                            <?php
                            require_once 'database/config.php';
                            $sql = "SELECT count(*), (SELECT complain_subhead from complain_subhead where id = complains.subhead_id) as subhead FROM `complains` group by subhead_id";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $stmt->bind_result($totalComplains, $subheads);
                            while ($stmt->fetch()) {?>
                            <ul style="display: inline-block;">
                                <li>
                                    <?php echo $totalComplains;?> complains for 
                                </li>
                                <li>
                                    <strong><?php echo $subheads;?></strong>
                                </li>
                            </ul>
                            <?php }
                            $stmt->close();?>
                        </div>
                    </li>
                    <li>
                        2- 
                        <div class="form-group" style="display: inline-block;">
                            <label>ARPU Wise Complains</label>
                            <ul style="display: inline-block;">
                                <li>
                                    <?php echo "In Progress";?>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        3- 
                        <div class="form-group" style="display: inline-block;">
                            <label>Category wise complains</label>
                            <?php
                            require_once 'database/config.php';
                            $sql = "SELECT (SELECT complain_head from complain_heads where id = com.head_id) as heads, count(head_id) as total from complains com where company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)) group by head_id";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param('s', $_COOKIE["US-K"]);
                            $stmt->execute();
                            $stmt->bind_result($heads, $total);
                            $headsTotals = array();
                            while($stmt->fetch()){?>
                            <ul style="display: inline-block;">
                                <li>
                                    <?php echo $total;?> complains for 
                                </li>
                                <li>
                                    <strong><?php echo $heads;?></strong> (Complain Head)
                                </li>
                            </ul>
                            <?php }
                            $stmt->close();?>
                        </div>
                    </li>
                    <li>
                        4- 
                        <div class="form-group" style="display: inline-block;">
                            <label>Department wise complains</label>
                            <?php
                            require_once 'database/config.php';
                            $sql = "SELECT (SELECT department_name from departments_info where department_id = (SELECT department_id from complain_heads where id = com.head_id)) as departments, count(head_id) as total from complains com where company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)) group by head_id";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param('s', $_COOKIE["US-K"]);
                            $stmt->execute();
                            $stmt->bind_result($departments, $total);
                            $headsTotals = array();
                            while($stmt->fetch()){?>
                            <ul style="display: inline-block;">
                                <li>
                                    <?php echo $total;?> complains for 
                                </li>
                                <li>
                                    <strong><?php echo $departments;?></strong> (Departments)
                                </li>
                            </ul>
                            <?php }
                            $stmt->close();?>
                        </div>
                    </li>
                    <li>
                        5- 
                        <div class="form-group" style="display: inline-block;">
                            <label>Complain Status Wise Report</label>
                            <?php
                            require_once 'database/config.php';
                            $sql = "SELECT count(*), complain_status from complains
                            where company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)) group by complain_status";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param('s', $_COOKIE["US-K"]);
                            $stmt->execute();
                            $stmt->bind_result($total, $complain_status);
                            $headsTotals = array();
                            while($stmt->fetch()){?>
                            <ul style="display: inline-block;">
                                <li>
                                    <?php echo $total;?> complains are 
                                </li>
                                <li>
                                    <strong><?php echo $complain_status;?></strong>
                                </li>
                            </ul>
                            <?php }
                            $stmt->close();?>
                        </div>
                    </li>
                    <li>
                        6- 
                        <div class="form-group" style="display: inline-block;">
                            <label>Location Wise Complains</label>
                            <?php
                            require_once 'database/config.php';
                            $sql = "SELECT (SELECT franchise_name from franchise_info where franchise_id = com.franchise_id) as franchise, count(complain_id) from complains com where company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)) group by franchise_id";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param('s', $_COOKIE["US-K"]);
                            $stmt->execute();
                            $stmt->bind_result($franchise, $totalComplains);
                            $details = array();
                            $complainsAltogether = 0;
                            while($stmt->fetch()){
                                $complainsAltogether += $totalComplains;
                                $details[] = array(
                                    'franchise' => $franchise,
                                    'totalComplains' => $totalComplains
                                );
                            }
                            $stmt->close();
                            for ($i=0; $i < sizeof($details); $i++) { ?>
                            <ul style="display: inline-block;">
                                <li>
                                    <?php echo round(($details[$i]['totalComplains']/$complainsAltogether)*100);?>% complains are from 
                                </li>
                                <li>
                                    <strong><?php echo $details[$i]['franchise'];?></strong>
                                </li>
                            </ul>
                            <?php } 
                            ?>
                        </div>
                    </li>
                    <li>
                        7- 
                        <div class="form-group" style="display: inline-block;">
                            <label>City Wise Report</label>
                            <?php
                            require_once 'database/config.php';
                            $sql = "SELECT franchise_city, (SELECT count(complain_id) from complains where franchise_id = fi.franchise_id) total_complains from franchise_info fi where company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param('s', $_COOKIE["US-K"]);
                            $stmt->execute();
                            $stmt->bind_result($city, $totalComplains);
                            $detailsNew = array();
                            $complainsAltogetherNew = 0;
                            while($stmt->fetch()){
                                $complainsAltogetherNew += $totalComplains;
                                $detailsNew[] = array(
                                    'city' => $city,
                                    'totalComplains' => $totalComplains
                                );
                            }
                            $stmt->close();
                            for ($i=0; $i < sizeof($detailsNew); $i++) { ?>
                            <ul style="display: inline-block;">
                                <li>
                                    <?php echo round(($detailsNew[$i]['totalComplains']/$complainsAltogetherNew)*100);?>% complains are from 
                                </li>
                                <li>
                                    <strong><?php echo $detailsNew[$i]['city'];?></strong>
                                </li>
                            </ul>
                            <?php } 
                            ?>
                        </div>
                    </li>
                    <li>
                        8- 
                        <div class="form-group" style="display: inline-block;">
                            <label>TAT Over Complains</label>
                            <?php
                            require_once 'database/config.php';
                            $sql = "SELECT count(*) from complains WHERE company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)) and TIMESTAMPDIFF(HOUR, tad_time_start, CURRENT_TIMESTAMP) > (SELECT tat_time_hrs from tat_time_management where company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)))";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param('ss', $_COOKIE["US-K"], $_COOKIE["US-K"]);
                            $stmt->execute();
                            $stmt->bind_result($tatOverComplains);
                            while($stmt->fetch()){?>
                            <ul style="display: inline-block;">
                                <li>
                                    <?php echo $total;?> complains are over the TAT time
                                </li>
                            </ul>
                            <?php }
                            $stmt->close();?>
                        </div>
                    </li>
                    <li>
                        8- 
                        <div class="form-group" style="display: inline-block;">
                            <label>Average resolution time</label>
                            <?php
                            require_once 'database/config.php';
                            $sql = "SELECT sum(TIMESTAMPDIFF(HOUR, tad_time_start, tad_time_close))/count(*) hours from complains where company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)) and complain_status = 'resolved'";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param('s', $_COOKIE["US-K"]);
                            $stmt->execute();
                            $stmt->bind_result($avgTimeResolution);
                            while($stmt->fetch()){?>
                            <ul style="display: inline-block;">
                                <li>
                                    <?php echo round($avgTimeResolution);?> hrs is the average resolution time
                                </li>
                            </ul>
                            <?php }
                            $stmt->close();?>
                        </div>
                    </li>
                    <li>
                        9- 
                        <div class="form-group" style="display: inline-block;">
                            <label>Customer satisfaction ratio or Resolution</label>
                            <?php
                            require_once 'database/config.php';
                            $sql = "SELECT sum(user_rating)/count(user_rating) FROM `complains` where company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)) and complain_status = 'resolved' and user_rating is NOT NULL";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param('s', $_COOKIE["US-K"]);
                            $stmt->execute();
                            $stmt->bind_result($satisfactionRation);
                            while($stmt->fetch()){?>
                            <ul style="display: inline-block;">
                                <li>
                                    <?php echo $satisfactionRation;?>/5 is the customer satisfaction ratio
                                </li>
                            </ul>
                            <?php }
                            $stmt->close();?>
                        </div>
                    </li>
                    <li>
                        10- 
                        <div class="form-group" style="display: inline-block;">
                            <label>Crank Customers</label>
                            <?php
                            require_once 'database/config.php';
                            $sql = "SELECT count(*) as totalCranks from crank_customers where company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param('s', $_COOKIE["US-K"]);
                            $stmt->execute();
                            $stmt->bind_result($totalCranks);
                            while($stmt->fetch()){?>
                            <ul style="display: inline-block;">
                                <li>
                                    <?php echo $totalCranks;?> are the total Crank Customers
                                </li>
                            </ul>
                            <?php }
                            $stmt->close();?>
                        </div>
                    </li>
                    <li>
                        11- 
                        <div class="form-group" style="display: inline-block;">
                            <label>Time of complains (Morning, Evening etc)</label>
                            <?php
                            require_once 'database/config.php';
                            $sql = "SELECT CASE WHEN TIME(tad_time_start) BETWEEN '06:00:00' AND '11:00:00' THEN 'morning'
                            WHEN TIME(tad_time_start) BETWEEN '11:01:00' AND '18:00:00' THEN 'afternoon'
                            WHEN TIME(tad_time_start) BETWEEN '18:01:00' AND '22:00:00' THEN 'night'
                            WHEN TIME(tad_time_start) BETWEEN '22:01:00' AND '23:59:00' THEN 'late_night'
                            WHEN TIME(tad_time_start) BETWEEN '00:00:00' AND '10:59:00' THEN 'early_morning'
                            END
                            from complains where company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param('s', $_COOKIE["US-K"]);
                            $stmt->execute();
                            $stmt->bind_result($timing);
                            while($stmt->fetch()){?>
                            <ul style="display: inline-block;">
                                <li>
                                    <?php echo $timing;?>
                                </li>
                            </ul>
                            <?php }
                            $stmt->close();?>
                        </div>
                    </li>
                    <li>
                        10- 
                        <div class="form-group" style="display: inline-block;">
                            <label>Crank Customers</label>
                            <?php
                            require_once 'database/config.php';
                            $sql = "SELECT count(*) as totalCranks from crank_customers where company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param('s', $_COOKIE["US-K"]);
                            $stmt->execute();
                            $stmt->bind_result($totalCranks);
                            while($stmt->fetch()){?>
                            <ul style="display: inline-block;">
                                <li>
                                    <?php echo $totalCranks;?> are the total Crank Customers
                                </li>
                            </ul>
                            <?php }
                            $stmt->close();?>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>

<?php include 'footer.php';?>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="script/sidebar-script.js?v=<?php echo time();?>"></script>

<script type="text/javascript">
    $(document).ready(function(){
        App.init();
        Dashboard.init();
        $('.nav li').removeClass('active');
        $('#reports').addClass('active');

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