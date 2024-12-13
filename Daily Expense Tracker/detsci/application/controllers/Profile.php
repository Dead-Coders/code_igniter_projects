<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Profile extends CI_Controller {
//Validating login
function __construct(){
parent::__construct();
if(!$this->session->userdata('uid'))
redirect('login');
}
//For fetching user data
public function index(){
			$uid=$this->session->userdata('uid');
			$this->load->model('Profile_Model');
			$profiledetails=$this->Profile_Model->getusedetails($uid);
		
			$this->load->view('profile',['profile'=>$profiledetails]);
	
}



//For Updating Profile
public function updateprofile(){
	//Form Validation
		$this->form_validation->set_rules('fullname','Full Name','required|alpha');
		$this->form_validation->set_rules('MobileNumber','Mobile Number','required|exact_length[10]');
		if($this->form_validation->run())
		{
			//Getting Post Values
			$fname=$this->input->post('fullname');
			$mobno=$this->input->post('MobileNumber');
			$uid=$this->session->userdata('uid');
			$this->load->model('Profile_Model');
			$profiledetails=$this->Profile_Model->updateprofile($uid,$fname,$mobno);
$this->session->set_flashdata('success','Profile updated successfull');
redirect('Profile');
			
		} else {
$this->session->set_flashdata('error','Something went wrong. Please try again.');
redirect('Profile');
}

}
}
