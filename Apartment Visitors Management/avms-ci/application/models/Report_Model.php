<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Report_Model extends CI_Model {

function __construct(){
parent::__construct();
if(! $this->session->userdata('uid'))
redirect('Login');
}

public function getreport($fdate,$tdate){
$this->db->select('VisitorName,Apartment,Floor,WhomtoMeet,EnterDate,ID,outtime');
$this->db->from('tblvisitor');
$this->db->where("date(EnterDate) between '$fdate' and '$tdate'");
$query=$this->db->get();
                 
return $query->result();  
}


}
