<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Dashboard extends CI_Controller {
function __construct(){
parent::__construct();
if(! $this->session->userdata('uid'))
redirect('Login');
}
	
public function index(){
$this->load->model('Dashboard_Model');
$totalcount=$this->Dashboard_Model->totalcount();
$yesterdaycount=$this->Dashboard_Model->countyesterday();
$sevendayscount=$this->Dashboard_Model->countlastsevendays();
$todayscount=$this->Dashboard_Model->counttodays();
$this->load->view('dashboard',['tcount'=>$totalcount,'ycount'=>$yesterdaycount,'tsevencount'=>$sevendayscount,'ttodaycount'=>$todayscount]);	

}

}