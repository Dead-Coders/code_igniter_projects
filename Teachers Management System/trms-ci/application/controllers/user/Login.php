<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	
	public function index()
	{
      $this->form_validation->set_rules('email', 'Email ID', 'trim|required');
      $this->form_validation->set_rules('password', 'password', 'trim|required');
       if ($this->form_validation->run() == FALSE)
        {
      $this->load->view('user/login');
      }
      else{
            $email=$this->input->post('email');
           $password=$this->input->post('password');
            $this->load->model('Users_Model');
            $uresult = $this->Users_Model->checkLogin($email,$password);
           if($uresult)
           {
               $this->session->set_userdata('id',$uresult->id); 
            $this->session->set_userdata('firstName',$uresult->firstName);
            $this->session->set_userdata('lastName',$uresult->lastName);
            $this->session->set_userdata('email',$uresult->email);
            $this->session->set_userdata('contactno',$uresult->contactno);
          
           
             redirect(base_url().'user/Users/dashboard');
           }
           else
           {
      
             $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Email id And Password is Invalid!</div>');
                redirect('user/login');
           }
      }

	
	}

 


}






