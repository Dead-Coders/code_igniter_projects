<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Changepwd extends CI_Controller {
	//Validating login
 function __construct(){
 parent::__construct();
 if(!$this->session->userdata('uid'))
 redirect('user/login');
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

		$this->load->model('user/Changepassword_Model','changepwd');	
		$currentpwd=$this->changepwd->getcurrentpassword($uid);

		$dbcurrentpwd=$currentpwd->password;
		if($currentpassword==$dbcurrentpwd){
		$this->load->model('user/Changepassword_Model','changepwddd');
        $this->changepwddd->updatepassword($uid,$newpassword);

	    $this->session->set_flashdata('success','Password changed successfully');
	    redirect('user/Changepwd');
        } else{
		$this->session->set_flashdata('error','Current Password is wrong');
	    redirect('user/Changepwd');
       }
		
      } 
	  
	  else {
     $this->load->view('user/change-password');	
}
}

}

