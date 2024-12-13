<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PDF extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('pdf_lib');
		$this->load->model('Admin_model');
	}

	public function generate_report()
	{
		$fromm=$this->input->post('fromm');
		$too=$this->input->post('too');

		if($fromm=='' && $too=='')
		{
			$data['reports']=$this->Admin_model->selectReports();

		}
		else
		{
			$data['reports']=$this->Admin_model->selectReport_filter($too,$fromm);
		}

		$this->load->view('pdf_report',$data);
	}
	
}
