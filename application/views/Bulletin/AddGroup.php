<?php require_once(APPPATH.'/views/includes/header.php'); ?>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once(APPPATH.'/views/includes/navbar&sidebar.php'); ?>
	<div class="page-wrapper">
		<div class="container-fluid">
			<div class="row heading-bg">
				<div class="col-lg-6 col-md-6">
					<h2 class="m-heading">Bulletins Management</h2>
				</div>
				<div class="col-lg-6 col-md-6">
					<ol class="breadcrumb">
						<li><a href="#"><span>Organization</span></a></li>
						<li><span>Bulletin Groups Management</span></li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="box-white m-b-30">
						<h2>Add Group</h2>
						<?php $attributes = array('id' => 'addGroupForm');
						echo form_open('Bulletins/AddGroupOps', $attributes);
						echo form_hidden('employee_id'); ?>
						<div class="form-wrap">
							<div class="form-body">
								<div class="row"> 
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Group Name*</label>
											<input type="text" name="group_name" class="form-control" value="<?= set_value('group_name'); ?>">
											<?= form_error('group_name', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
								</div>
								<div class="row" id="employeesListDiv">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label mb-10">Employees</label>
											<select multiple="multiple" name="employees_list" disabled="disabled" id="employees_list">
												<?php foreach ($employees as $employee) : ?>
													<option value="<?= $employee->employee_id ?>"><?= $employee->employee_username; ?></option>
												<?php endforeach; ?>
											</select>	
										</div>							 
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="row button-section">
			<a type="button" href="<?= base_url('Bulletins/ListGroups'); ?>" id="backFromAddGroups" class="btn btn-cancel">Cancel</a>
			<a type="button" id="addGroupButton" class="btn btn-save">Save</a>						
		</div>
	</div>
</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script type="text/javascript" src="<?= base_url('assets/js/Bulletin.js').'?v='.time(); ?>"></script>