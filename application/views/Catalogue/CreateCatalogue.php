<?php require_once(APPPATH.'/views/includes/header.php'); ?>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css">
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once(APPPATH.'/views/includes/navbar&sidebar.php'); ?>
	<div class="page-wrapper">
		<div class="container-fluid">
			<div class="row heading-bg">
				<div class="col-lg-6 col-md-6">
					<h2 class="m-heading">Create Catalogue</h2>
				</div>
				<div class="col-lg-6 col-md-6">
					<ol class="breadcrumb">

						<li>
							<a href="#">
								<span>Catalogue</span>
							</a>
						</li>
						<li>
							<span>Create Catalogue</span>
						</li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="box-white m-b-30">
						<div id="example-basic">
							<h3>
								<span class="head-font capitalize-font wz-pt">Create Catalogue</span>
							</h3>
							<section>
								<div class="form-body">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label mb-10">Enter Catalogue Name</label>
												<input type="text" id="catalogue_name" class="form-control" placeholder="">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label mb-10">Active from</label>
												<div class='input-group date' id='datePicker1'>
													<input type='text' id="active_from" class="form-control r-l-0" />
													<span class="input-group-addon r-l-6">
														<span class="fa fa-calendar"></span>
													</span>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label mb-10">Active till</label>
												<div class='input-group date' id="datePicker2">
													<input type='text' id="active_till" class="form-control r-l-0" />
													<span class="input-group-addon r-l-6">
														<span class="fa fa-calendar"></span>
													</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</section>
							<h3>
								<span class="head-font capitalize-font wz-pt">Select Product</span>
							</h3>
							<section>
								<div class="col-md-12" id="productsDiv">
									<h3 class="m-b-15">Select Products for Catalogue</h3>
									<select multiple="multiple" name="inventory_items" id="inventory_items">
										<?php foreach($inventoryList as $inventory) : ?>
										<option value="<?= $inventory->pref_id; ?>">
											<?= $inventory->item_name; ?>
										</option>
										<?php endforeach; ?>
									</select>
								</div>
							</section>
							<h3>
								<span class="head-font capitalize-font wz-pt">Set List Priority</span>
							</h3>
							<section>
								<div class="col-md-12">
									<h3 class="m-b-15">Set Products List Priority</h3>
									<div class="dd" id="nestable2">
										<ol class="dd-list priorityListings">
										</ol>
									</div>
								</div>
							</section>
							<h3>
								<span class="head-font capitalize-font wz-pt">Assign Catalogue</span>
							</h3>
							<section>
								<div class="row">
									<div class="col-md-6">
										<div class="checkbox checkbox-primary checkbox-circle">
											<input id="region" type="checkbox" value="">
											<label for="region" class="lab-large"> Assign catalogue by Region </label>
										</div>
										<div id="checkbox-circle001">
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label class="control-label mb-10">Region</label>
														<select class="selectpicker" name="region_id" data-style="form-control btn-default btn-outline">
															<?php foreach ($Regions as $region) : ?>
															<option value="<?= $region->id; ?>">
																<?= $region->region_name; ?>
															</option>
															<?php endforeach; ?>
														</select>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="checkbox checkbox-primary checkbox-circle">
											<input id="area" type="checkbox" value="">
											<label for="area" class="lab-large"> Assign catalogue by Area </label>
										</div>
										<div id="checkbox-circle001">
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label class="control-label mb-10">Areas</label>
														<select class="selectpicker" name="area_id" data-style="form-control btn-default btn-outline">
															<?php foreach ($Areas as $area) : ?>
															<option value="<?= $area->id; ?>">
																<?= $area->area_name; ?>
															</option>
															<?php endforeach; ?>
														</select>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="checkbox checkbox-primary checkbox-circle">
											<input id="territory" type="checkbox" value="">
											<label for="territory" class="lab-large"> Assign catalogue by Territory </label>
										</div>
										<div id="checkbox-circle001">
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label class="control-label mb-10">Territory</label>
														<select class="selectpicker" name="territory_id" data-style="form-control btn-default btn-outline">
															<?php foreach ($Territories as $territory) : ?>
															<option value="<?= $territory->id; ?>">
																<?= $territory->territory_name; ?>
															</option>
															<?php endforeach; ?>
														</select>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row" id="employeesListDiv">
									<div class="col-md-12">
										<div class="checkbox checkbox-primary checkbox-circle">
											<input id="employee" type="checkbox" checked="checked" value="">
											<label for="employee" class="lab-large"> Assign catalogue by Employee </label>
										</div>
										<div id="checkbox-circle001">
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label class="control-label mb-10">Employees</label>
														<select multiple="multiple" name="employees_list" disabled="disabled" id="employees_list">
															<?php foreach ($Employees as $employee) : ?>
															<option value="<?= $employee->employee_id ?>">
																<?= $employee->employee_username; ?>
															</option>
															<?php endforeach; ?>
														</select>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</section>
							<?php $attributes = array('id' => 'createCatalogueForm');
							echo form_open('Catalogue/CreateCatalogueOps', $attributes);
							echo form_hidden('catalogue_data', '');
							echo form_hidden('assignment_data', ''); ?>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script type="text/javascript" src="<?= base_url('assets/js/RegionAndArea.js').'?v='.time(); ?>"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
	$(document).ready(function () {
		$('#datePicker1').datepicker({
			format: 'yyyy-mm-dd',
			startDate: '+0d'
		});
		$('#datePicker2').datepicker({
			format: 'yyyy-mm-dd',
			startDate: '+0d'
		});
	});

</script>
