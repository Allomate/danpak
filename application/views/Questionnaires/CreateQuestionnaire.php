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
					<h2 class="m-heading">Questionnaires Management</h2>
				</div>
				<div class="col-lg-6 col-md-6">
					<ol class="breadcrumb">
						<li><a href="#"><span>Organization</span></a></li>
						<li><span>Questionnaires Management</span></li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="box-white m-b-30">
						<h2>Create Questionnaire</h2>
						<?php $attributes = array('id' => 'addQuestionnaireForm');
						echo form_open('Questionnaires/CreateQuestionnaireOps', $attributes);
						echo form_hidden('result_data', ''); ?>
						<div class="form-wrap">
							<div class="form-body">
								<div class="row"> 
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Select Group</label>
											<select class="selectpicker" name="group_id" data-style="form-control btn-default btn-outline">
												<option value="0">No Groups</option>
												<?php foreach( $groups as $group ) : ?>
													<option value="<?= $group->id; ?>"><?= $group->group_name; ?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</div> 
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Select Individual</label>
											<select class="selectpicker" name="individual_id" data-style="form-control btn-default btn-outline">
												<option selected="selected" value="0">No individual participants</option>
												<?php foreach( $employees as $employee ) : ?>
													<option value="<?= $employee->employee_id; ?>"><?= $employee->employee_username; ?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label mb-10">Question*</label>
											<input type="text" name="question" class="form-control" placeholder="Write question" value="<?= set_value('question'); ?>">
											<?= form_error('question', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label mb-10">Multiple Choices</label>
											<div id="dynamic_adding_choices">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <div class="form-group">
                                                            <input type="text" name="multiple_choices_0" class="form-control" placeholder="Multiple choice answers" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="row">
                                                            <div class="col-md-6" style="padding: 2px">
                                                                <div class="form-group">
                                                                    <button class="btn btn-primary addMore" type="button" style="width: 100%">Add More</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
			<a type="button" href="<?= base_url('Questionnaires/ListQuestionnaires'); ?>" id="backFromCreateQuestionnaireMessage" class="btn btn-cancel">Cancel</a>
			<a type="button" id="createQuestionnaireButton" class="btn btn-save">Save</a>						
		</div>
	</div>
</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script type="text/javascript" src="<?= base_url('assets/js/Questionnaires.js').'?v='.time(); ?>"></script>