<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Viewuser extends CI_Controller {

	
	public function index()
	{
		$this->load->model('admin/View_Model','viewuser');
		$userdetails=$this->viewuser->getusedetails();
		$this->load->view('admin/viewuser',['viewdetails'=>$userdetails]);
	}

	//Delete Record  
	public function delete($rid){
	$this->load->model('admin/View_Model','deletem');
	$this->deletem->delete($rid);
	// $this->session->set_flashdata('success','Delete Record deleted');
	// redirect('admin/viewuser');
}

}
