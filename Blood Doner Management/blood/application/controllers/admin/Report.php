<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
	//Validating login
// function __construct(){
// parent::__construct();
// if(!$this->session->userdata('uid'))
// redirect('user/login');
// }

public function index(){
    
//Form Validation
$this->form_validation->set_rules('fromdate','From Date','required');
$this->form_validation->set_rules('todate','To Date','required');	
if($this->form_validation->run())
{
$fdate=$this->input->post('fromdate');
$tdate=$this->input->post('todate');
$uid=$this->session->userdata('uid');
$this->load->model('admin/Report_Model','viewuser');
$rdetails=$this->viewuser->getreport($fdate,$tdate,$uid);

$this->load->view('admin/report',['reportdetails'=>$rdetails,'fromdate'=>$fdate,'todate'=>$tdate]);
}	else{
$this->load->view('admin/report');
}
}

}

