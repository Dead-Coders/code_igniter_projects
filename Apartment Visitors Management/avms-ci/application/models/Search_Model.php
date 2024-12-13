<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Search_Model extends CI_Model {

function __construct(){
parent::__construct();
if(! $this->session->userdata('uid'))
redirect('Login');
}

public function get($sdata){
$data1 = array('VisitorName'=> $sdata);
$data2 = array('MobileNumber'=> $sdata);
$this->db->select('VisitorName,Apartment,Floor,WhomtoMeet,EnterDate,ID,outtime');
$this->db->from('tblvisitor');
$this->db->like($data1);
$this->db->or_like($data2);
$query=$this->db->get();
                 
return $query->result();  
}


}
