<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Profile extends CI_Controller {
//Validating login
function __construct(){
parent::__construct();
if(!$this->session->userdata('uid'))
redirect('admin/login');
}
//For fetching user data
public function index(){
			$this->load->model('admin/Master_model','blood');
			$data['sub'] = $this->blood->subject();
			$uid=$this->session->userdata('uid');
			$this->load->model('admin/Profile_Model','profile');
			$data['profile'] = $this->profile->getusedetails($uid);
		    $this->load->view('admin/profile',$data);
	
}
//For Updating Profile
public function updateprofile(){
	//Form Validation
	$this->form_validation->set_rules('name','Name','required');
    $this->form_validation->set_rules('email','Email Id','required|valid_email');

		if($this->form_validation->run())
		{
			//Getting Post Values
			$name=$this->input->post('name');
		    $email=$this->input->post('email');
		    $uid=$this->session->userdata('uid');
			$this->load->model('admin/Profile_Model','profilees');
			$profiledetails=$this->profilees->updateuserprofile($uid,$name,$email);
			$this->session->set_flashdata('success','Profile updated successfull');
			redirect('admin/Profile');
		  }
		 else {
			$this->session->set_flashdata('error','Something went wrong. Please try again.');
			redirect('admin/Profile');
			}

        }
    }
