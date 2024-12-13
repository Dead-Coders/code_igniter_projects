<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Changepassword extends CI_Controller {
	//Validating login
function __construct(){
parent::__construct();
if(!$this->session->userdata('uid'))
redirect('login');
}

public function index(){
    
    $this->form_validation->set_rules('currentpassword','Current Password','required|min_length[6]');
	$this->form_validation->set_rules('newpassword','New Password','required|min_length[6]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','required|min_length[6]|matches[newpassword]');
		if($this->form_validation->run())
		{
		$currentpassword=md5($this->input->post('currentpassword'));	
		$newpassword=md5($this->input->post('newpassword'));
			$uid=$this->session->userdata('uid');
		$this->load->model('Changepassword_Model');	
		$currentpwd=$this->Changepassword_Model->getcurrentpassword($uid);
		$dbcurrentpwd=$currentpwd->Password;
		if($currentpassword==$dbcurrentpwd){
$this->Changepassword_Model->updatepassword($uid,$newpassword);
	$this->session->set_flashdata('success','Password changed successfully');
	redirect('Changepassword');
} else{
		$this->session->set_flashdata('error','Current Password is wrong');
	redirect('Changepassword');
}

} else {
$this->load->view('Change-password');	
}

}

}

