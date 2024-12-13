<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Report extends CI_Controller {
function __construct(){
parent::__construct();
if(! $this->session->userdata('uid'))
redirect('Login');
}

public function index(){
$this->load->view('bwdates-reports');
}
//For Search Result
public function Result(){
$fdate=$this->input->post('fromdate');
$tdate=$this->input->post('todate');
$this->load->model('Report_Model');
$rdata=$this->Report_Model->getreport($fdate,$tdate);
$this->load->view('report-result',['reportdata'=>$rdata]);
}



}