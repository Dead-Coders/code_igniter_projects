<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Login extends CI_Controller {


public function index(){
$this->form_validation->set_rules('username','Username','required');
$this->form_validation->set_rules('password','Password','required');
if($this->form_validation->run()){
$username=$this->input->post('username');
$password=$this->input->post('password');	
$this->load->model('Login_Model');
$validate=$this->Login_Model->validatelogin($username,$password);
if($validate)
{
$this->session->set_userdata('uid',$validate);
return redirect('dashboard');
} else{
$this->session->set_flashdata('error', 'Invalid details. Please try again with valid details');
redirect('login');

}

} else {
$this->load->view('index');
}	
}

//function for logout
public function logout(){
$this->session->unset_userdata('adid');
$this->session->sess_destroy();
return redirect('admin/login');
}

}