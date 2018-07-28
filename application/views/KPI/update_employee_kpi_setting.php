<?php require_once APPPATH . '/views/includes/header.php';?>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once APPPATH . '/views/includes/navbar&sidebar.php';?>
	<div class="page-wrapper">
		<div class="container">
			<?php if (isset($error)): ?>
			<div class="row" style="margin-top: 20px;">
				<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
					<strong>Failed</strong>
					<?= "Unable to update KPI for this employee due to some reason. Please try again"; ?>
				</div>
			</div>
			<?php endif;?>
			<div class="row heading-bg">
				<div class="col-lg-6 col-md-6">
					<h2 class="m-heading">Employee Management</h2>
				</div>
				<!-- Breadcrumb -->
				<div class="col-lg-6 col-md-6">
					<ol class="breadcrumb">
						<li>
							<a href="#">
								<span>Organization</span>
							</a>
						</li>
						<li>
							<span>Employee Management</span>
						</li>
						<li>
							<span>Add KPI</span>
						</li>
					</ol>
				</div>
				<!-- /Breadcrumb -->
			</div>
			<!-- /Title -->
			<div class="row">
				<div class="col-md-12">
					<div class="box-white p-20">
						<div style="border-bottom: solid 2px #d9dde1;">
							<h2 class="m-b-0" style="display: inline-block; border: 0px !important">Employee Info</h2>
							<div class="checkbox checkbox-primary checkbox-circle m-b-20" style="display: inline-block; float: right">
								<?php if($kpi[0]->evaluation_from_employees) :?>
								<input type="checkbox" id="evaluateUsingEmployees" value="Reports" checked>
								<?php else :?>
								<input type="checkbox" id="evaluateUsingEmployees" value="Reports">
								<?php endif; ?>
								<label for="evaluateUsingEmployees" class="lab-medium" style="font-weight: bolder">Evaluate using reporting employees</label>
							</div>
						</div>
						<div class="bg-gl clearfix m-b-30">
							<div class="col-md-4">
								<div class="form-group">
									<label class="control-label mb-10">
										<strong>Name:</strong>
										<?=$Employee->employee_name;?>
									</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="control-label mb-10">
										<strong>Designation:</strong>
										<?=$Employee->employee_designation;?>
									</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="control-label mb-10">
										<strong>Mobile No:</strong>
										<?=$Employee->employee_phone;?>
									</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="control-label mb-10">
										<strong>Territory:</strong>
										<?=$Employee->territory;?>
									</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="control-label mb-10">
										<strong>Area:</strong>
										<?=$Employee->area;?>
									</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="control-label mb-10">
										<strong>Region:</strong>
										<?=$Employee->region;?>
									</label>
								</div>
							</div>
						</div>
						<h2 class="m-b-15">Selected the KPI Evaluation Period</h2>
						<div class="radio radio-info m-b-15">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<input type="radio" name="radio" class="radioSelector" id="radio1" value="monthly" checked="checked">
										<label for="radio1" class="rad-large">Monthly</label>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<input type="radio" name="radio" class="radioSelector" id="radio2" value="quarterly">
										<label for="radio2" class="rad-large">Quarterly</label>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<select class="form-control" name="monthDD" data-style="form-control btn-default btn-outline">
										<option value="january">January</option>
										<option value="february">February</option>
										<option value="march">March</option>
										<option value="april">April</option>
										<option value="may">May</option>
										<option value="june">June</option>
										<option value="july">July</option>
										<option value="august">August</option>
										<option value="september">September</option>
										<option value="october">October</option>
										<option value="november">November</option>
										<option value="december">December</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<select class="form-control" name="quarterDD" data-style="form-control btn-default btn-outline" disabled="disabled">
										<option value="q1">Q1</option>
										<option value="q2">Q2</option>
										<option value="q3">Q3</option>
										<option value="q4">Q4</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row m-t-10">
							<div class="col-md-6">
								<button type="button" class="btn add-kpi btn-save m-t-10" data-target="#MainCategory">
									<i class="fa fa-plus"> </i> Add KPI</button>
							</div>
						</div>
					</div>
					<div class="modal fade bs-example-modal-lg" id="MainCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
									<h5 class="modal-title" id="exampleModalLabel1">Select KPI Type</h5>
									<br>
								</div>
								<div class="modal-body">
									<div class="col-md-12  m-b-30">
										<div class="radio radio-info m-b-15">
											<input type="radio" name="kpi_type" class="kpiTypeSelector" id="pwSales" value="product" checked="checked">
											<label for="pwSales" class="rad-large">Product Wise Sales</label>
										</div>
										<div class="radio radio-info m-b-15">
											<input type="radio" name="kpi_type" class="kpiTypeSelector" id="qwSales" value="quantity">
											<label for="qwSales" class="rad-large">Quantity Wise Sales</label>
										</div>
										<div class="radio radio-info m-b-15">
											<input type="radio" name="kpi_type" class="kpiTypeSelector" id="rwSales" value="revenue">
											<label for="rwSales" class="rad-large">Revenue Wise Sales</label>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									<button type="button" id="createKpiForThisCriteria" class="btn btn-primary">Save</button>
								</div>
							</div>
						</div>
					</div>
					<?php $attributes = array('id' => 'updateKpiForm');
echo form_open('Kpi/UpdateKpi/' . $this->uri->segment(3), $attributes);
echo form_hidden('evaluation_from_employees', '');
echo form_hidden('totalKpis', sizeOf($kpi))?>
					<div id="kpiDynamicDiv" class="box-white p-20 m-t-30">
						<h2 class="m-b-15">Add KPI </h2>
						<?php $counter = 0; foreach($kpi as $kp) : ?>
						<?php if($kp->kpi_type == "product") : ?>
						<h5>Product Wise (
							<?= $kp->criteria_parameter; ?>)</h5>
						<br>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label mb-10">Product</label>
									<select class="form-control productDD" name="productDD_<?= $counter; ?>" data-style="form-control btn-default btn-outline">
										<option value="0">Select product</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label mb-10">Unit</label>
									<select class="form-control unitDD" name="unitDD_<?= $counter; ?>" data-style="form-control btn-default btn-outline">
										<option value="0">Select unit</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label mb-10">Target</label>
									<input type="text" name="target_<?= $counter;?>" value="<?= $kp->target ?>" class="form-control empTargets" placeholder="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label mb-10">Eligibility</label>
									<input type="text" name="eligibility_<?= $counter;?>" value="<?= $kp->eligibility ?>" class="form-control empEligibility"
									placeholder="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label mb-10">Weightage</label>
									<input type="text" name="weightage_<?= $counter;?>" value="<?= $kp->weightage ?>" class="form-control weightage" placeholder="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label mb-10">Incentive</label>
									<input type="text" name="incentive_<?= $counter;?>" value="<?= $kp->incentive ?>" class="form-control empIncentives" placeholder="">
								</div>
							</div>

							<input type="text" name="selected_product_<?= $counter; ?>" value="<?= $kp->item_id; ?>" hidden="">
							<input type="text" name="selected_unit_<?= $counter; ?>" value="<?= $kp->pref_id; ?>" hidden="">

							<input type="text" name="for_month_or_criteria_<?= $counter;?>" value="<?= $kp->criteria_parameter ?>" hidden="">
							<input type="text" name="criteria_<?= $counter;?>" value="<?= $kp->criteria ?>" hidden="">
							<input type="text" name="for_kpi_type_<?= $counter;?>" value="<?= $kp->kpi_type ?>" hidden="">
						</div>
						<?php elseif($kp->kpi_type == "quantity") :?>
						<h5>Quantity Wise (
							<?= $kp->criteria_parameter; ?>)</h5>
						<br>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label mb-10">Unit</label>
									<select class="form-control unitDD" name="unitDD_<?= $counter; ?>" data-style="form-control btn-default btn-outline">
										<option value="0">Select unit</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label mb-10">Target</label>
									<input type="text" name="target_<?= $counter;?>" value="<?= $kp->target ?>" class="form-control empTargets" placeholder="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label mb-10">Eligibility</label>
									<input type="text" name="eligibility_<?= $counter;?>" value="<?= $kp->eligibility ?>" class="form-control empEligibility"
									placeholder="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label mb-10">Weightage</label>
									<input type="text" name="weightage_<?= $counter;?>" value="<?= $kp->weightage ?>" class="form-control weightage" placeholder="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label mb-10">Incentive</label>
									<input type="text" name="incentive_<?= $counter;?>" value="<?= $kp->incentive ?>" class="form-control empIncentives" placeholder="">
								</div>
							</div>

							<input type="text" name="selected_unit_<?= $counter; ?>" value="<?= $kp->unit_id; ?>" hidden="">

							<input type="text" name="for_month_or_criteria_<?= $counter;?>" value="<?= $kp->criteria_parameter ?>" hidden="">
							<input type="text" name="criteria_<?= $counter;?>" value="<?= $kp->criteria ?>" hidden="">
							<input type="text" name="for_kpi_type_<?= $counter;?>" value="<?= $kp->kpi_type ?>" hidden="">
						</div>
						<?php elseif($kp->kpi_type == "revenue") :?>
						<h5>Revenue Wise (
							<?= $kp->criteria_parameter; ?>)</h5>
						<br>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label mb-10">Target</label>
									<input type="text" name="target_<?= $counter;?>" value="<?= $kp->target ?>" class="form-control empTargets" placeholder="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label mb-10">Eligibility</label>
									<input type="text" name="eligibility_<?= $counter;?>" value="<?= $kp->eligibility ?>" class="form-control empEligibility"
									placeholder="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label mb-10">Weightage</label>
									<input type="text" name="weightage_<?= $counter;?>" value="<?= $kp->weightage ?>" class="form-control weightage" placeholder="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label mb-10">Incentive</label>
									<input type="text" name="incentive_<?= $counter;?>" value="<?= $kp->incentive ?>" class="form-control empIncentives" placeholder="">
								</div>
							</div>
							<input type="text" name="for_month_or_criteria_<?= $counter;?>" value="<?= $kp->criteria_parameter ?>" hidden="">
							<input type="text" name="criteria_<?= $counter;?>" value="<?= $kp->criteria ?>" hidden="">
							<input type="text" name="for_kpi_type_<?= $counter;?>" value="<?= $kp->kpi_type ?>" hidden="">
						</div>
						<?php endif;?>
						<?php $counter++; endforeach; ?>
					</div>
					</form>
					<div class="row" id="progressBar" style="display: none">
						<div class="col-md-12">
							<div class="progress progress-lg m-t-30">
								<div class="progress-bar progress-bar-danger" style="width: 2%;" role="progressbar">0%</div>
							</div>
						</div>
					</div>
					<div class="form-bottom">
						<div class="button-section align-right">
							<a href="<?=base_url('Kpi/EmpKpi');?>" class="btn btn-cancel">Cancel</a>
							<a id="submitKpi" class="btn btn-save">Save</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php require_once APPPATH . '/views/includes/footer.php';?>
<script type="text/javascript" src="<?=base_url('assets/js/Update_KPI.js') . '?v=' . time();?>"></script>
