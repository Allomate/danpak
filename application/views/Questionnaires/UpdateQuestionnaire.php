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
						<h2>Update Questionnaire</h2>
						<?php $attributes = array('id' => 'updateQuestionnaireForm');
						echo form_open('Questionnaires/UpdateQuestionnaireOps/'.$questionnaire->id, $attributes); ?>
                        <input type="text" name="multiple_choices" value="<?= $questionnaire->multiple_choices; ?>" hidden>
						<div class="form-wrap">
							<div class="form-body">
								<div class="row"> 
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Select Group</label>
                                            <?php
                                            $options["0"] = "No Groups";
                                            foreach ($groups as $group) : 
                                                $options[$group->id] = $group->group_name;
                                            endforeach; 
                                            $atts = array( 'class' => 'selectpicker', "data-style" => "form-control btn-default btn-outline" );
                                            echo form_dropdown('group_id', $options, $questionnaire->group_id, $atts); ?>
										</div>
									</div> 
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label mb-10">Select Individual</label>
                                            <?php
                                            $optionsNew["0"] = "No individual participants";
                                            foreach ($employees as $employee) : 
                                                $optionsNew[$employee->employee_id] = $employee->employee_username;
                                            endforeach; 
                                            $atts = array( 'class' => 'selectpicker', "data-style" => "form-control btn-default btn-outline" );
                                            echo form_dropdown('individual_id', $optionsNew, $questionnaire->individual_id, $atts); ?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label mb-10">Question*</label>
											<input type="text" name="question" class="form-control" placeholder="Write question" value="<?= $questionnaire->question; ?>" />
											<?= form_error('question', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label mb-10">Multiple Choices</label>
											<div id="dynamic_adding_choices">
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
			<a type="button" id="updateQuestionnaireButton" class="btn btn-save">Save</a>						
		</div>
	</div>
</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script type="text/javascript" src="<?= base_url('assets/js/Questionnaires.js').'?v='.time(); ?>"></script>