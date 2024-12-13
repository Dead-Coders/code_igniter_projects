<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bloodgroup extends CI_Controller {

	
	public function Add()
	{
		$this->form_validation->set_rules('name','Blood Group Name','required');
		if($this->form_validation->run())
		{
			//Getting Post Values
			$name=$this->input->post('name');
			$this->load->model('admin/Bloodgroup_Model','viewuser');
			$this->viewuser->Addbloodgroup($name);
	     }
	 else{
		$this->load->view('admin/addbloodgroup');
	 }
	}

	public function Manage()
	{
	    $this->load->model('admin/Bloodgroup_Model','viewuser');
		$userdetails=$this->viewuser->getusedetails();
		$this->load->view('admin/manage',['viewdetails'=>$userdetails]);
	}

	//Delete Record  
	     public function delete($uid){
		$this->load->model('admin/Bloodgroup_Model','viewuser');
		$this->viewuser->delete($uid);
		$this->session->set_flashdata('success','Delete Record deleted');
		redirect('admin/Bloodgroup/Manage');
		 }

	


}
