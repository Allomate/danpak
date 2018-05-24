<?php

class QuestionnairesModel extends CI_Model{
    
  public function getAllQuestionnaires(){
    $response = $this->db->select('`id`, `question`, `multiple_choices`, COALESCE((SELECT employee_username from employees_info where employee_id = qt.individual_id), (SELECT group_name from bulletin_groups where id = qt.group_id)) as assigned_to, (SELECT count(id) from questionnaire_results where questionnaire_id = qt.id) as responses')->get('questionnaires qt')->result();
    $counter = 0;
    foreach($response as $value){
      $choices = explode("<$>", $value->multiple_choices);
      $values["choices"] = sizeOf($choices);
      $response[$counter]->choices = sizeOf($choices);
      $counter++;
    }
    return $response;
  }

  public function create_questionnaire($questionnaireData){
		return $this->db->insert('questionnaires', $questionnaireData);
  }

  public function getChoices($questId){
    return $this->db->select('multiple_choices')->where('id', $questId)->get('questionnaires')->row();
  }

  public function getResponses($questId){
    return $this->db->select('(SELECT employee_username from employees_info where employee_id = qtr.employee_id) as employee, answer, comments, (SELECT question from questionnaires where id = qtr.questionnaire_id) as question, (SELECT multiple_choices from questionnaires where id = qtr.questionnaire_id) as multiple_choices')->where('questionnaire_id', $questId)->get('questionnaire_results qtr')->result();
  }

  public function update_questionnaire($questionnaireData, $questionnaireId){
		return $this->db->where('id',$questionnaireId)->update('questionnaires', $questionnaireData);
  }

  public function getThisQuestionnaire($questionnaireId){
    return $this->db->where('id', $questionnaireId)->get('questionnaires')->row();
  }

  public function delete_questionnaire($questId){
		return $this->db->delete('questionnaires', array('id' => $questId)); 
  }

}

?>