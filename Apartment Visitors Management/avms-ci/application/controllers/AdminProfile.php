<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AdminProfile extends CI_Controller {
//Validating login
function __construct(){
parent::__construct();
if(!$this->session->userdata('uid'))
redirect('Login');
}
//For fetching user data
public function index(){
			$uid=$this->session->userdata('uid');
			$this->load->model('Profile_Model');
			$profiledetails=$this->Profile_Model->getadmindetails($uid);
		
			$this->load->view('admin-profile',['profile'=>$profiledetails]);
	
}



//For Updating Profile
public function Update(){
	//Form Validation
		$this->form_validation->set_rules('fullname','Full Name','required');
		$this->form_validation->set_rules('emailid','Email Id','required|valid_email');
		$this->form_validation->set_rules('mobilenumber','Mobile Number','required|exact_length[10]');
		if($this->form_validation->run())
		{
			//Getting Post Values
			$fname=$this->input->post('fullname');
			$emailid=$this->input->post('emailid');
			$mobno=$this->input->post('mobilenumber');
			$uid=$this->session->userdata('uid');
			$this->load->model('Profile_Model');
			$profiledetails=$this->Profile_Model->updateprofile($uid,$fname,$emailid,$mobno);
$this->session->set_flashdata('success','Profile updated successfull');
redirect('AdminProfile');
			
		} else {
$this->session->set_flashdata('error','Something went wrong. Please try again.');
redirect('AdminProfile');
}

}
}
