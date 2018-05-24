<?php

class Bulletins extends WebAuth_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('EmployeesModel', 'em');
		$this->load->model('BulletinsModel', 'bm');
	}

	public function ListGroups(){
		$this->load->view('Bulletin/ListGroups', [ 'Groups' => $this->bm->getAllGroups() ]);
	}

	public function AddGroup(){
		$this->load->view('Bulletin/AddGroup', [ 'employees' => $this->em->get_employees_list() ]);
	}

	public function AddGroupOps()
	{
		$this->form_validation->set_rules('group_name', 'Group Name', 'required|max_length[100]');
		if ($this->form_validation->run()) {
			$groupsData = $this->input->post();
			unset($groupsData["DataTables_Table_0_length"]);
			if ($this->bm->add_group($groupsData)) :
				$this->session->set_flashdata("group_added", "Group has been added successfully");
			else:
				$this->session->set_flashdata("group_add_failed", "Failed to add the group");
			endif;
			return redirect('Bulletins/ListGroups');
		}else{
			$this->load->view('Bulletin/AddGroup', [ 'employees' => $this->em->get_employees_list() ]);
		}
	}

	public function UpdateGroup($groupId){
		$this->load->view('Bulletin/UpdateGroup', [ 'employees' => $this->em->get_employees_list(), 'group' => $this->bm->getSingleGroup($groupId) ]);
	}

	public function UpdateGroupOps($groupId)
	{
		$this->form_validation->set_rules('group_name', 'Group Name', 'required|max_length[100]');
		if ($this->form_validation->run()) {
			$groupsData = $this->input->post();
			unset($groupsData["DataTables_Table_0_length"]);
			if ($this->bm->update_group($groupId, $groupsData)) :
				$this->session->set_flashdata("group_updated", "Group has been updated successfully");
			else:
				$this->session->set_flashdata("group_update_failed", "Failed to update the group");
			endif;
			return redirect('Bulletins/ListGroups');
		}else{
			$this->load->view('Bulletin/UpdateGroup', [ 'employees' => $this->em->get_employees_list() ]);
		}
	}

	public function DeleteGroup($groupId)
	{
		if ($this->bm->delete_group($groupId)) :
			$this->session->set_flashdata('group_deleted', 'Group has been deleted successfully');
			return $this->load->view('Bulletin/ListGroups', [ 'Groups' => $this->bm->getAllGroups() ]);
		else:
			$this->session->set_flashdata('group_delete_failed', 'Unable to delete the group');
			return $this->load->view('Bulletin/ListGroups', [ 'Groups' => $this->bm->getAllGroups() ]);

		endif;
	}

	public function ListMessages(){
		$this->load->view('Bulletin/ListMessages', [ 'messages' => $this->bm->getAllMessages() ]);
	}

	public function AddMessage(){
		$this->load->view('Bulletin/AddMessage', [ 'employees' => $this->em->get_employees_list(), 'groups' => $this->bm->getAllGroups() ]);
	}

	public function AddMessageOps()
	{
		$this->form_validation->set_rules('message', 'Message', 'required');
		if ($this->form_validation->run()) {
			$message = $this->input->post();
			if ($this->bm->add_message($message)) :
				$this->session->set_flashdata("message_added", "Message has been sent");
			else:
				$this->session->set_flashdata("message_add_failed", "Failed to send the message");
			endif;
			return redirect('Bulletins/ListMessages');
		}else{
			$this->load->view('Bulletin/AddMessage', [ 'employees' => $this->em->get_employees_list(), 'groups' => $this->bm->getAllGroups() ]);
		}
	}

	public function UpdateMessage($messageId){
		$this->load->view('Bulletin/UpdateMessage', [ 'employees' => $this->em->get_employees_list(), 'groups' => $this->bm->getAllGroups(), 'message' => $this->bm->getSingleMessage($messageId) ]);
	}

	public function UpdateMessageOps($messageId)
	{
		$this->form_validation->set_rules('message', 'Message', 'required');
		if ($this->form_validation->run()) {
			$message = $this->input->post();
			if ($this->bm->update_message($messageId, $message)) :
				$this->session->set_flashdata("message_updated", "Message has been resent");
			else:
				$this->session->set_flashdata("message_update_failed", "Failed to resend the message");
			endif;
			return redirect('Bulletins/ListMessages');
		}else{
			$this->load->view('Bulletin/UpdateMessage', [ 'employees' => $this->em->get_employees_list(), 'groups' => $this->bm->getAllGroups(), 'message' => $this->bm->getSingleMessage($messageId) ]);
		}
	}

	public function DeleteMessage($messageId)
	{
		if ($this->bm->delete_message($messageId)) :
			$this->session->set_flashdata('message_deleted', 'Message has been deleted successfully');
			return redirect('Bulletins/ListMessages');
		else:
			$this->session->set_flashdata('message_delete_failed', 'Unable to delete the Message');
			return $this->load->view('Bulletin/ListMessages', [ 'messages' => $this->bm->getAllMessages() ]);
		endif;
	}

}

?>