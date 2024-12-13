<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends CI_Controller {

	
	public function index()
	{   $this->load->model('user/Master_model','blood');
		$data['sub'] = $this->blood->subject();
		$this->load->view('user/registration',$data);
	}

	public function create()
	{   
		$this->load->model('user/Master_model','blood');
		$data['sub'] = $this->blood->subject();
	
		//Form Validation
		$this->form_validation->set_rules('first_name','First Name','required|alpha');
		$this->form_validation->set_rules('last_name','Last Name','required|alpha');
		$this->form_validation->set_rules('gender','Gender Name','required');
		$this->form_validation->set_rules('blood','Blood Name','required');
		$this->form_validation->set_rules('email','Email Id','required|valid_email|is_unique[tblregistration.Email]');
		$this->form_validation->set_rules('contact_no','Mobile Number','required|exact_length[10]');
		$this->form_validation->set_rules('state','State Name','required|alpha');
		$this->form_validation->set_rules('city','City Name','required|alpha');
		$this->form_validation->set_rules('password','Password','required|min_length[6]');
		$this->form_validation->set_rules('cpassword','Confirm Password','required|min_length[6]|matches[password]');
		$this->form_validation->set_rules('agree','agree the terms and policy','required');
		if($this->form_validation->run())
		{
			//Getting Post Values
			$first_name=$this->input->post('first_name');
			$last_name=$this->input->post('last_name');
			$gender=$this->input->post('gender');
			$blood=$this->input->post('blood');
			$email=$this->input->post('email');
			$contact_no=$this->input->post('contact_no');
			$state=$this->input->post('state');
			$city=$this->input->post('city');
			$agree=$this->input->post('agree');
			$password=md5($this->input->post('password'));
		
			$this->load->model('user/Registration_Model','Registratssssion');
			$this->Registratssssion->index($first_name,$last_name,$gender,$blood,$email,$contact_no,$state,$city,$agree,$password);
		}
		else
		{
			$this->load->view('user/registration',$data);
		}
		
	}
}
