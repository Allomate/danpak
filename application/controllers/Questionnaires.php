<?php

class Questionnaires extends WebAuth_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('QuestionnairesModel', 'qm');
		$this->load->model('EmployeesModel', 'em');
		$this->load->model('BulletinsModel', 'bm');
	}

	public function ListQuestionnaires(){
		return $this->load->view('Questionnaires/ListQuestionnaires', [ 'questionnaires' => $this->qm->getAllQuestionnaires() ]);
	}

	public function CreateQuestionnaire(){
		return $this->load->view('Questionnaires/CreateQuestionnaire', [ 'employees' => $this->em->get_employees_list(), 'groups' => $this->bm->getAllGroups() ]);
	}

	public function CreateQuestionnaireOps()
	{
		$questionnaireData = $this->input->post();
		$questionnaireData["multiple_choices"] = $questionnaireData["result_data"];
		unset($questionnaireData["result_data"]);

		if ($this->qm->create_questionnaire($questionnaireData)) :
			$this->session->set_flashdata("questionnaire_created", "Questionnaire has been created successfully");
		else:
			$this->session->set_flashdata("questionnaire_creation_failed", "Failed to create the questionnaire");
		endif;
		return redirect('Questionnaires/ListQuestionnaires');
	}

	public function UpdateQuestionnaire($questionnaireId){
		return $this->load->view('Questionnaires/UpdateQuestionnaire', [ 'employees' => $this->em->get_employees_list(), 'groups' => $this->bm->getAllGroups(), 'questionnaire' => $this->qm->getThisQuestionnaire($questionnaireId) ]);
	}

	public function UpdateQuestionnaireOps($questionnaireId)
	{
		$questionnaireData = $this->input->post();

		if ($this->qm->update_questionnaire($questionnaireData, $questionnaireId)) :
			$this->session->set_flashdata("questionnaire_updated", "Questionnaire has been updated successfully");
		else:
			$this->session->set_flashdata("questionnaire_update_failed", "Failed to update the questionnaire");
		endif;
		return redirect('Questionnaires/ListQuestionnaires');
	}

	public function GetQuestionnareChoicesForAjax()
	{
		echo json_encode($this->qm->getChoices($this->input->post("questionnaireId")));
	}

	public function GetQuestRespUrlAjax()
	{
		echo json_encode($this->qm->getResponses($this->input->post("questionnaireId")));
	}

	public function DeleteQuestionnaire($questionnaireId)
	{
		if ($this->qm->delete_questionnaire($questionnaireId)) :
			$this->session->set_flashdata('questionnaire_deleted', 'Questionnaire has been deleted successfully');
		else:
			$this->session->set_flashdata('questionnaire_delete_failed', 'Unable to delete the questionnaire');
		endif;
		return redirect('Questionnaires/ListQuestionnaires');
	}

}

?>