<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Search_Model extends CI_Model {


public function get($sdata){
$data1 = array('state'=> $sdata);
$data2 = array('bloodname'=> $sdata);
$this->db->select('tblregistration.id,first_name, last_name, gender, blood, email, contact_no, state, city, password, 
agree, address, create_date,bloodgroup.bloodname as bloodname,bloodgroup.id');
$this->db->join('bloodgroup','tblregistration.blood=bloodgroup.id','left');
$this->db->from('tblregistration');
$this->db->like($data1);
$this->db->or_like($data2);
$query=$this->db->get();
                 
return $query->result();  
}


}
