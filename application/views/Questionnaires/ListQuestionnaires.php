<?php require_once(APPPATH.'/views/includes/header.php'); ?>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once(APPPATH.'/views/includes/navbar&sidebar.php'); ?>
	<div class="page-wrapper">
		<div class="container-fluid">
			<?php if ($feedback = $this->session->flashdata('questionnaire_created')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Added</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('questionnaire_creation_failed')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Failed</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('questionnaire_updated')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Updated</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('questionnaire_update_failed')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Failed</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('questionnaire_deleted')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Deleted</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($feedback = $this->session->flashdata('questionnaire_delete_failed')) : ?>
				<div class="row" style="margin-top: 20px;">
					<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
						<strong>Failed</strong> <?= $feedback; ?>
					</div>
				</div>
			<?php endif; ?>
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
					<div class="box-white p-20"><a href="<?= base_url('Questionnaires/CreateQuestionnaire');?>" class="btn add-emp"><i class="fa fa-plus"> </i> Create Questionnaire </a>
						<h2 class="m-b-0">Questionnaires </h2>
						<div class="table-wrap">
							<div class="table-responsive">
								<table  class="table table-hover display  pb-30" >
									<thead>
										<tr>
											<th>S.No</th>
											<th>Question</th>
											<th>Multiple Choices</th>
											<th>Assigned To</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>S.No</th>
											<th>Question</th>
											<th>Multiple Choices</th>
											<th>Assigned To</th>
											<th>Actions</th>
										</tr>
									</tfoot>
									<tbody>
										<?php $sno = 1; foreach ($questionnaires as $quest) : ?>
										<tr>
											<td><?= $sno++; ?></td>
											<td><?= $quest->question; ?></td>
											<td><?= $quest->choices; ?> <small class="viewChoices" id="<?= $quest->id; ?>" style="cursor: pointer">(VIEW)</small></td>
											<td><?= $quest->assigned_to; ?></td>
											<td>
												<a href="<?= base_url('Questionnaires/UpdateQuestionnaire/'.$quest->id); ?>"><i class="fa fa-pencil"></i></a>
												&nbsp;
												<a class="deleteConfirmation" href="<?= base_url('Questionnaires/DeleteQuestionnaire/'.$quest->id); ?>"><i class="fa fa-close"></i></a>
												&nbsp;
												<?php if($quest->responses) : ?>
													<a style="cursor: pointer" class="view-report viewResponses" id="<?= $quest->id; ?>">View Reponses</a>
												<?php else: ?>
													<span class="view-report">No responses</span>
												<?php endif; ?>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
    <input type="text" id="getChoicesUrlAjax" value="<?= base_url('Questionnaires/GetQuestionnareChoicesForAjax'); ?>" hidden>
    <input type="text" id="getQuestResponseUrlAjax" value="<?= base_url('Questionnaires/GetQuestRespUrlAjax'); ?>" hidden>
</div>
</div>

<div class="row">
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Questionnaire Choices</h4>
				</div>
				<div class="modal-body">
					<table class="table choicesTable">
                        <thead>
                            <tr>
                                <th style="width: 100px">S.No</th>
                                <th>Choice</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="width: 100px">S.No</th>
                                <th>Choice</th>
                            </tr>
                        </tfoot>
                    </table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div id="responsesModal" class="modal fade" role="dialog">
		<div class="modal-dialog" style="width: 800px">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Questionnaire Responses</h4>
				</div>
				<div class="modal-body responseModalBody">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script type="text/javascript" src="<?= base_url('assets/js/Questionnaires.js').'?v='.time(); ?>"></script>