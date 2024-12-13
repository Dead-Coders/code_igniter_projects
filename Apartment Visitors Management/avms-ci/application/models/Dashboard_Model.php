<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Dashboard_Model extends CI_Model {

function __construct(){
parent::__construct();
if(! $this->session->userdata('uid'))
redirect('Login');
}

public function totalcount(){
$query=$this->db->select('ID')   
                 ->get('tblvisitor');
return  $query->num_rows();
}

public function countyesterday(){
$query1=$this->db->select('ID')   
                 ->where('EnterDate >=  DATE(NOW()) - INTERVAL 1 DAY')
                 ->get('tblvisitor');
return  $query1->num_rows();
}

public function countlastsevendays(){
$query2=$this->db->select('ID')   
                 ->where('EnterDate >=  DATE(NOW()) - INTERVAL 7 DAY')
                 ->get('tblvisitor');
return  $query2->num_rows();
}

public function counttodays(){
$query3=$this->db->select('ID')   
                 ->where('date(EnterDate)=CURDATE()')
                 ->get('tblvisitor');
return  $query3->num_rows();
}
}
