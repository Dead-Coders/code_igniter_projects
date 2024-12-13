<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller {
//Validating login
function __construct(){
parent::__construct();
if(!$this->session->userdata('uid'))
redirect('login');
}
public function index(){
$uid=$this->session->userdata('uid');	
$this->load->model('Dashboard_Model');
$todayexp=$this->Dashboard_Model->todaysexpenses($uid);
$yestrdayexp=$this->Dashboard_Model->yesterdayxpenses($uid);
$last7daysexp=$this->Dashboard_Model->last7daysexpenses($uid);
$last30daysexp=$this->Dashboard_Model->last30daysexpenses($uid);
$cyearexp=$this->Dashboard_Model->currentyearsexpenses($uid);
$totlexp=$this->Dashboard_Model->totalsexpenses($uid);
$this->load->view('dashboard',['texp'=>$todayexp,'yesterdayexpense'=>$yestrdayexp,'last7daysexpenses'=>$last7daysexp,'last30daysexpenses'=>$last30daysexp,'currentyearexpenses'=>$cyearexp,'totalexpanses'=>$totlexp]);
}

}
