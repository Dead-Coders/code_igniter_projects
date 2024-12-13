<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Reports extends CI_Controller {
//Validating login
function __construct(){
parent::__construct();
if(!$this->session->userdata('uid'))
redirect('login');
}

//Date Wise Report dateselection
Public function datewiserport(){
//Form Validation
		$this->form_validation->set_rules('fromdate','From Date','required');
		$this->form_validation->set_rules('todate','To Date','required');	
if($this->form_validation->run())
{
$fdate=$this->input->post('fromdate');
$tdate=$this->input->post('todate');
$uid=$this->session->userdata('uid');	
$this->load->model('Reports_Model');
$rdetails=$this->Reports_Model->datewisereport($fdate,$tdate,$uid);
$this->load->view('expense-datewise-reports-detailed',['reportdetails'=>$rdetails,'fromdate'=>$fdate,'todate'=>$tdate]);
}	else{
$this->load->view('expense-datewise-reports');
}
}

//Month Wise Report dateselection
Public function monthwiserport(){
//Form Validation
		$this->form_validation->set_rules('fromdate','From Date','required');
		$this->form_validation->set_rules('todate','To Date','required');	
if($this->form_validation->run())
{
$fdate=$this->input->post('fromdate');
$tdate=$this->input->post('todate');
$uid=$this->session->userdata('uid');	
$this->load->model('Reports_Model');
$rdetails=$this->Reports_Model->monthwisereport($fdate,$tdate,$uid);
$this->load->view('expense-monthwise-reports-detailed',['reportdetails'=>$rdetails,'fromdate'=>$fdate,'todate'=>$tdate]);
}	else{
$this->load->view('expense-monthwise-reports');
}
}

//Year Wise Report dateselection
Public function yearwiserport(){
//Form Validation
		$this->form_validation->set_rules('fromdate','From Date','required');
		$this->form_validation->set_rules('todate','To Date','required');	
if($this->form_validation->run())
{
$fdate=$this->input->post('fromdate');
$tdate=$this->input->post('todate');
$uid=$this->session->userdata('uid');	
$this->load->model('Reports_Model');
$rdetails=$this->Reports_Model->yearwisereport($fdate,$tdate,$uid);
$this->load->view('expense-yearwise-reports-detailed',['reportdetails'=>$rdetails,'fromdate'=>$fdate,'todate'=>$tdate]);
}	else{
$this->load->view('expense-yearwise-reports');
}
}

}