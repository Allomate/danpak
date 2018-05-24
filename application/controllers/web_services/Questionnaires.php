<?php

header('Content-Type: application/json');

class Questionnaires extends Web_Services_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('WebServices', 'ws');
		global $authentication;
		if (!$this->AuthenticateWebServiceCall($this->input->post("api_secret_key"))) :
            echo $this->ResponseMessage('Failed', 'Failed Api Authentication');
            die;
        elseif (!$this->AuthenticateSession($this->input->post("session"))) :
            echo $this->ResponseMessage('Failed', 'Failed session Authentication');
            die;
        endif;
	}

	public function GetAllQuestionnaires(){
        $response = $this->ws->GetQuestionnare($this->input->post("session"));
        if ($response !== "No Questionnaire found") :
            return $this->ResponseMessage('Success', $response);
        else:
            return $this->ResponseMessage('Failed', $response);
        endif;
    }
        
    public function AnswerQuestionnaire(){
        $questionnaireDetails = $this->input->post();
        if (isset($questionnaireDetails['answer'], $questionnaireDetails['questionnaire_id'], $questionnaireDetails['comments'])) :
            if ($questionnaireDetails['answer'] && $questionnaireDetails['questionnaire_id']) :
                unset($questionnaireDetails["api_secret_key"]);
                $response = $this->ws->AnswerQuestionnaire($questionnaireDetails);
                if ($response) :
                    return $this->ResponseMessage('Success', 'Questionnaire answer have been stored successfully');
                else:
                    return $this->ResponseMessage('Failed', $response);
                endif;
            else:
                return $this->ResponseMessage('Failed', 'Missing values');
            endif;
        else:
            return $this->ResponseMessage('Failed', 'Missing values');
        endif;
    }

}

?>