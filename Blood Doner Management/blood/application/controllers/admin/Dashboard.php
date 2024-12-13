<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	
	public function index()
	{   $this->load->model('admin/Dashboard_Model','adminn');
		$totalusercount=$this->adminn->totalusercount();
		$totalbloodgroupcount=$this->adminn->totalbloodgroupcount();
		$this->load->view('admin/dashboard',['totalusercount'=>$totalusercount,'totalbloodgroupcount'=>$totalbloodgroupcount]);

// 		$this->load->model('Dashboard_Model');
// $totalcount=$this->Dashboard_Model->totalcount();
// $yesterdaycount=$this->Dashboard_Model->countyesterday();
// $sevendayscount=$this->Dashboard_Model->countlastsevendays();
// $todayscount=$this->Dashboard_Model->counttodays();
// $this->load->view('dashboard',['tcount'=>$totalcount,'ycount'=>$yesterdaycount,'tsevencount'=>$sevendayscount,'ttodaycount'=>$todayscount]);	

	}
}
