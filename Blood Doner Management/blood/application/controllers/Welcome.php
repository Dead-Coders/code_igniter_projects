<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
	$sdata=$this->input->post('searchdata');
	$this->load->model('Search_Model');
	$sresult=$this->Search_Model->get($sdata);
	$this->load->view('search',['searchresult'=>$sresult]);
	
	}
}
