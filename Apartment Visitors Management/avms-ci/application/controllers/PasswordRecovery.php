<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class PasswordRecovery extends CI_Controller {

public function index(){
$this->form_validation->set_rules('username','Username','required');	
$this->form_validation->set_rules('mobilenumber','Mobile Number','required|exact_length[10]');
if($this->form_validation->run()){
$uname=$this->input->post('username');
$mnumber=$this->input->post('mobilenumber');
$this->load->model('Passwordrecovery_Model');
$vd=$this->Passwordrecovery_Model->validatedetails($uname,$mnumber);
$dbuname=$vd->UserName;
$dbmno=$vd->MobileNumber;
$this->session->set_userdata('uname',$dbuname);
$this->session->set_userdata('mobno',$dbmno);
if($dbuname==$uname && $dbmno==$dbmno){
$this->load->view('reset-password',['validatedetails'=>$vd]);

} else {
$this->session->set_flashdata('error', 'Error: Invalid Details');
redirect('PasswordRecovery');	
} 
} else {
$this->load->view('password-recovery');
}
}

// for password reset
public function reset(){
$this->form_validation->set_rules('password','Password','required|min_length[6]');
$this->form_validation->set_rules('confirmpassword','Confirm Password','required|min_length[6]|matches[password]');
if($this->form_validation->run()){
$uname=$this->session->userdata('uname');
$mno=$this->session->userdata('mobno');
$newpassword=$this->input->post('password');

$this->load->model('Passwordrecovery_Model');
$cpass=$this->Passwordrecovery_Model->resetpassword($uname,$mno,$newpassword);
$this->session->unset_userdata('uname');
$this->session->unset_userdata('mobno');
$this->session->set_flashdata('success', 'Password changed successfully');
	redirect('Login');
}
 
 else {
$this->load->view('reset-password');
}
}



}