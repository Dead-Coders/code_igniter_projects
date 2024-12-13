<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
		//Validating login
		function __construct(){
			parent::__construct();
			if(!$this->session->userdata('uid'))
			redirect('user/login');
			}

	
	public function index()
	{
		$this->load->view('user/dashboard');
	}
}
