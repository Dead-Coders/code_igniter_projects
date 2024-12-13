<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller{

public function index(){
//Validation for login form

$this->form_validation->set_rules('email','Email id','required|valid_email');
$this->form_validation->set_rules('password','Password','required');
if($this->form_validation->run()){
    $email=$this->input->post('email');
	$password=$this->input->post('password');
    $encpass=md5($password);
	$this->load->model('user/Login_Model', 'Login');
    $validate=$this->Login->index($email,$encpass);

if($validate){
$this->session->set_userdata('uid',$validate->id);	
$this->session->set_userdata('fname',$validate->first_name);	
redirect('user/dashboard');
} else {
$this->session->set_flashdata('error','Invalid login details.Please try again.');
redirect('user/login');

}

} else{
$this->load->view('user/login');	
}
}


}