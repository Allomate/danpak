<?php
require 'verify_permission.php';
include 'header.php';?>

<link href="assets/plugins/bootstrap-wizard/css/bwizard.min.css" rel="stylesheet" />
<link href="assets/plugins/parsley/src/parsley.css" rel="stylesheet" />
<div id="page-loader" class="fade in"><span class="spinner"></span></div>
<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
   <?php include 'navbar.php';?>
   <?php include 'sidebar.php';?>

   <div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li><a href="javascript:;">Form Stuff</a></li>
        <li class="active">Wizards + Validation</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Loyalty Program <small>Loyalty program setup</small></h1>
    <!-- end page-header -->

    <!-- begin row -->
    <?php

    require_once 'database/config.php';
    $sql = "SELECT `id`, `program_name`, `points_name_singular`, `points_name_plural`, `amount_customer_spent`, `points_amount_spent`, `points_monetary_value`, `company_id`, `created_at`, `eligibility_criteria`, `condition_weeks`, (SELECT tier_1_name from loyalty_tiers where company_id = loyalty_program.company_id) as tier_1_name, (SELECT tier_2_name from loyalty_tiers where company_id = loyalty_program.company_id) as tier_2_name, (SELECT tier_3_name from loyalty_tiers where company_id = loyalty_program.company_id) as tier_3_name, (SELECT tier_1_period from loyalty_tiers where company_id = loyalty_program.company_id) as tier_1_period, (SELECT tier_2_period from loyalty_tiers where company_id = loyalty_program.company_id) as tier_2_period, (SELECT tier_3_period from loyalty_tiers where company_id = loyalty_program.company_id) as tier_3_period, (SELECT tier_level from loyalty_tiers where company_id = loyalty_program.company_id) as tier_level FROM `loyalty_program` WHERE company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $_COOKIE["US-K"]);
    $stmt->execute();
    $stmt->bind_result($id, $program_name, $points_name_singular, $points_name_plural, $amount_customer_spent, $points_amount_spent, $monetory_value, $company_id, $created_at, $eligibility_criteria, $condition, $tier_1_name, $tier_2_name, $tier_3_name, $tier_1_period, $tier_2_period, $tier_3_period, $tier_level);
    if (!$stmt->fetch()) {?>
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-md-12">
            <!-- begin panel -->
            <div class="panel panel-inverse loyaltyFormPanel">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Loyalty</h4>
                </div>
                <div class="panel-body">
                    <form method="POST" id="loyaltyForm" data-parsley-validate="true" name="form-wizard">
                        <div id="wizard">
                            <ol>
                                <li>
                                    Loyalty Program
                                    <small>Name your loyalty program and settings</small>
                                </li>
                                <li>
                                    Tiers
                                    <small>Setup number of Tiers as your requirements, upto 3</small>
                                </li>
                                <li>
                                    Setup
                                    <small>Setup loyalty points and credit</small>
                                </li>
                                <li>
                                    Condition
                                    <small>Set the conditions to be applied for customers</small>
                                </li>
                            </ol>
                            <!-- begin wizard step-1 -->
                            <div class="wizard-step-1">
                                <fieldset>
                                    <legend class="pull-left width-full">Loyalty Program</legend>
                                    <!-- begin row -->
                                    <div class="row">
                                        <!-- begin col-4 -->
                                        <div class="col-md-4">
                                            <div class="form-group block1">
                                                <label>Program Name</label>
                                                <input type="text" name="program_name" class="form-control" data-parsley-group="wizard-step-1" required />
                                            </div>
                                        </div>
                                        <!-- end col-4 -->
                                        <!-- begin col-4 -->
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label style="display: block;">Points Name</label>
                                                <input type="text" name="point_name_singular" placeholder="Point" class="form-control" data-parsley-group="wizard-step-1"  style="display: inline-block; width: 150px" required />
                                                <input type="text" name="point_name_plural" placeholder="Points" class="form-control" data-parsley-group="wizard-step-1"  style="display: inline-block; width: 150px" required />
                                                <br>
                                                <label style="width: 150px; text-align: center; color: grey">Singular</label>
                                                <label style="width: 150px; text-align: center; color: grey">Plural</label>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end row -->
                                </fieldset>
                            </div>
                            <!-- end wizard step-1 -->
                            <!-- begin wizard step-2 -->
                            <div class="wizard-step-2">
                                <fieldset>
                                    <legend class="pull-left width-full">Tiers</legend>
                                    <!-- begin row -->
                                    <div class="row">
                                        <!-- begin col-6 -->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label style="width: 55%">Tier 1</label>
                                                <label style="width: 40%">Validity</label>
                                                <input type="text" id="tier1Name" name="tier_1_name" class="form-control" data-parsley-group="wizard-step-2" style="width: 55%; display: inline" required />
                                                <select class="form-control" style="width: 40%; display: inline" name="tier_1_period">
                                                    <option value="1">1 Month</option>
                                                    <option value="2">2 Month</option>
                                                    <option value="3">3 Month</option>
                                                    <option value="4">4 Month</option>
                                                    <option value="5">5 Month</option>
                                                    <option value="6">6 Month</option>
                                                    <option value="7">7 Month</option>
                                                    <option value="8">8 Month</option>
                                                    <option value="9">9 Month</option>
                                                    <option value="10">10 Month</option>
                                                    <option value="11">11 Month</option>
                                                    <option value="12">12 Month</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label style="width: 55%">Tier 2</label>
                                                <label style="width: 40%">Validity</label>
                                                <input type="text" name="tier_2_name" class="form-control" data-parsley-group="wizard-step-2" style="width: 55%; display: inline" />
                                                <select class="form-control" style="width: 40%; display: inline" name="tier_2_period">
                                                    <option value="1">1 Month</option>
                                                    <option value="2">2 Month</option>
                                                    <option value="3">3 Month</option>
                                                    <option value="4">4 Month</option>
                                                    <option value="5">5 Month</option>
                                                    <option value="6">6 Month</option>
                                                    <option value="7">7 Month</option>
                                                    <option value="8">8 Month</option>
                                                    <option value="9">9 Month</option>
                                                    <option value="10">10 Month</option>
                                                    <option value="11">11 Month</option>
                                                    <option value="12">12 Month</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label style="width: 55%">Tier 3</label>
                                                <label style="width: 40%">Validity</label>
                                                <input type="text" name="tier_3_name" class="form-control" data-parsley-group="wizard-step-2" style="width: 55%; display: inline" />
                                                <select class="form-control" style="width: 40%; display: inline" name="tier_3_period">
                                                    <option value="1">1 Month</option>
                                                    <option value="2">2 Month</option>
                                                    <option value="3">3 Month</option>
                                                    <option value="4">4 Month</option>
                                                    <option value="5">5 Month</option>
                                                    <option value="6">6 Month</option>
                                                    <option value="7">7 Month</option>
                                                    <option value="8">8 Month</option>
                                                    <option value="9">9 Month</option>
                                                    <option value="10">10 Month</option>
                                                    <option value="11">11 Month</option>
                                                    <option value="12">12 Month</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- end col-6 -->
                                    </div>
                                    <div class="row">

                                    </div>
                                    <!-- end row -->
                                </fieldset>
                            </div>
                            <!-- end wizard step-2 -->
                            <!-- begin wizard step-3 -->
                            <div class="wizard-step-3">
                                <fieldset>
                                    <legend class="pull-left width-full">Setup</legend>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Amount that Customer Spend</label>
                                                <div class="controls">
                                                    <input type="number" name="amount_customer_spent" class="form-control" data-parsley-group="wizard-step-3" required />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Point for every amount spent</label>
                                                <div class="controls">
                                                    <input type="number" name="point_every_amount_spent" class="form-control" data-parsley-group="wizard-step-3" required />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Monetary Value of the Points</label>
                                                <div class="controls">
                                                    <input type="number" name="monetory_value" class="form-control" required />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Eligibility Criteria</label>
                                                <div class="controls">
                                                    <input type="number" name="eligibility_criteria" class="form-control" required />
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end col-6 -->
                                    </div>
                                    <!-- end row -->
                                </fieldset>
                            </div>
                            <div class="wizard-step-4">
                                <fieldset>
                                    <legend class="pull-left width-full">Condition</legend>
                                    <!-- begin row -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Condition</label>
                                                <select class="form-control" name="condition_to_redeem_reward_points">
                                                    <option value="0">Immediately</option>
                                                    <option value="1">1 Week</option>
                                                    <option value="2">2 Week</option>
                                                    <option value="3">3 Week</option>
                                                    <option value="4">4 Week</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-7"></div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <input type="button" class="btn btn-success" name="submit" value="Finalize" style="float: right">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end row -->
                                </fieldset>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php }else{?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-inverse loyaltyFormPanel">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Update Program</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="col-md-3">Program Name</label>
                                <span class="col-md-5"><?php echo $program_name;?></span>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="col-md-3">Points Name</label>
                                <span class="col-md-5"><?php echo $points_name_singular;?> <strong> (Singular) </strong> <?php echo $points_name_plural;?> <strong> (Plural) </strong> </span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="col-md-3">Tier Levels</label>
                                <span class="col-md-5">
                                    <?php
                                    if ($tier_level == "1") {
                                        echo "<strong>" . $tier_1_name . "</strong> with validity of <strong>" . $tier_1_period . "</strong> months";
                                    }else if($tier_level == "2"){
                                        echo "<strong>" . $tier_1_name . "</strong> with validity of <strong>" . $tier_1_period . "</strong> months<br>";
                                        echo "<strong>" . $tier_2_name . "</strong> with validity of <strong>" . $tier_2_period . "</strong> months";
                                    }else{
                                        echo "<h4>" . $tier_1_name . "</h4> with validity of <strong>" . $tier_1_period . "</strong> months<br>";
                                        echo "<h4>" . $tier_2_name . "</h4> with validity of <strong>" . $tier_2_period . "</strong> months<br>";
                                        echo "<h4>" . $tier_3_name . "</h4> with validity of <strong>" . $tier_3_period . "</strong> months";
                                    }
                                    ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <label class="col-md-3">Points Setup</label>
                            <span class="col-md-5">
                                <?php
                                echo "<h4>".$amount_customer_spent."</h4> Amount which customer spent <br>";
                                echo "<h4>".$points_amount_spent."</h4> Points on every amount spent <br>";
                                echo "<h4>".$monetory_value."</h4> Points monetary value";
                                ?>                                
                            </span>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-5">
                            <label class="col-md-3">Eligibility Criteria</label>
                            <span class="col-md-5">
                                <?php
                                echo "<h4>".$eligibility_criteria . "</h4> Amount to be spent in single transaction to enrol in the program";
                                ?>
                            </span>
                        </div>
                        <div class="col-md-5">
                            <label class="col-md-3">Eligibility Criteria</label>
                            <span class="col-md-5">
                                <?php
                                if ($condition == "0") {
                                    echo "<h4>Immediately</h4> customer can redeem his/her points";
                                }else{
                                    echo "<h4>".$condition . "</h4> Weeks after customer can redeem his/her points";
                                }
                                ?>
                            </span>
                        </div>
                    </div>
<!--                     <hr>
                    <div class="row">
                        <div class="col-md-7"></div>
                        <div class="col-md-5">
                            <button class="btn btn-warning">Update</button>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <!-- end row -->
</div>
</div>

<?php include 'footer.php';?>
<script src="http://malsup.github.com/jquery.form.js"></script> 
<script src="assets/plugins/parsley/dist/parsley.js"></script>
<script src="assets/plugins/bootstrap-wizard/js/bwizard.js"></script>
<script src="assets/js/form-wizards-validation.demo.min.js"></script>
<script type="text/javascript" src="script/sidebar-script.js?v=<?php echo time();?>"></script>

<script type="text/javascript">
    $(document).ready(function(){
        App.init();
        FormWizardValidation.init();
        $('.nav li').removeClass('active');
        $('#loyaltySetup').addClass('active');

        var target = $('.loyaltyFormPanel');
        $('input[name="submit"]').click(function(){
            showLoader(target);
            $('#loyaltyForm').ajaxSubmit({
                type: "POST",
                url: "ajax_scripts/submitLoyaltyData.php",
                data: $('#csvUploadingForm').serialize(),
                cache: false,
                success: function (response) {
                    if (response == "Success") {
                        swal({
                            title: 'Program Created',
                            type: 'success',
                            text: 'Loyalty program has been created successfully',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                        }).then(function () {
                            setTimeout(function(){
                                location.reload();
                            },250);
                        })
                    }else{
                        document.write(response);
                    }
                    hideLoader(target);
                    return;
                }
            });
        });

    });

    function showLoader(target){
        var targetLoader = target;
        var targetBody = $(targetLoader).find('.panel-body');
        var spinnerHtml = '<div class="panel-loader"><span class="spinner-small"></span></div>';
        $(targetLoader).addClass('panel-loading');
        $(targetBody).prepend(spinnerHtml);
    }

    function hideLoader(target){
        if (target) {
            $(target).removeClass('panel-loading');
            $(target).find('.panel-loader').remove();
        }
    }
</script>