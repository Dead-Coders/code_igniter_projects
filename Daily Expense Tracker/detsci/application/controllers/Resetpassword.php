<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resetpassword extends CI_Controller {

public function index(){
$this->form_validation->set_rules('email','Email Id','required|valid_email');
		$this->form_validation->set_rules('MobileNumber','Mobile Number','required|exact_length[10]');
	$this->form_validation->set_rules('newpassword','New Password','required|min_length[6]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','required|min_length[6]|matches[newpassword]');

	if($this->form_validation->run())
		{
			//Getting Post Values
			$emailid=$this->input->post('email');
			$mobno=$this->input->post('MobileNumber');
			$newpwd=md5($this->input->post('newpassword'));
$this->load->model('Resetpassword_Model');	
	$validate_details=$this->Resetpassword_Model->verifydata($emailid,$mobno);
if($validate_details){
$this->Resetpassword_Model->updatepassword($emailid,$mobno,$newpwd);
$this->session->set_flashdata('success','Password chnaged successfully.');
redirect('Resetpassword');
} else{
$this->session->set_flashdata('error','Invalid  details.Please try again.');
redirect('Resetpassword');	
}

		} else {
$this->load->view('reset-password.php');

		}
}

}