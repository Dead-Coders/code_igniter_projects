<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Profile extends CI_Controller {
//Validating login
function __construct(){
parent::__construct();
if(!$this->session->userdata('uid'))
redirect('user/login');
}
//For fetching user data
public function index(){
			$this->load->model('user/Master_model','blood');
			$data['sub'] = $this->blood->subject();
			$uid=$this->session->userdata('uid');
			$this->load->model('user/Profile_Model','profile');
			$data['profile'] = $this->profile->getusedetails($uid);
		    $this->load->view('user/profile',$data);
	
}
//For Updating Profile
public function updateprofile(){
	//Form Validation
	$this->form_validation->set_rules('first_name','First Name','required|alpha');
	$this->form_validation->set_rules('last_name','Last Name','required|alpha');
	 $this->form_validation->set_rules('gender','Gender Name','required');
	$this->form_validation->set_rules('blood','Blood Name','required');
	$this->form_validation->set_rules('contact_no','Mobile Number','required|exact_length[10]');
	$this->form_validation->set_rules('state','State Name','required');
$this->form_validation->set_rules('city','City Name','required');
		if($this->form_validation->run())
		{
			//Getting Post Values
			$first_name=$this->input->post('first_name');
			$last_name=$this->input->post('last_name');
			$gender=$this->input->post('gender');
			$blood=$this->input->post('blood');
			$contact_no=$this->input->post('contact_no');
			$state=$this->input->post('state');
			$city=$this->input->post('city');

			$uid=$this->session->userdata('uid');
			$this->load->model('user/Profile_Model','profilees');
			$profiledetails=$this->profilees->updateuserprofile($uid,$first_name,$last_name,$gender,$blood,$contact_no,$state,$city);

			$this->session->set_flashdata('success','Profile updated successfull');
			redirect('user/Profile');
		  }
		 else {
			//$this->session->set_flashdata('error','Something went wrong. Please try again.');
			redirect('user/Profile');
			}

        }
    }
