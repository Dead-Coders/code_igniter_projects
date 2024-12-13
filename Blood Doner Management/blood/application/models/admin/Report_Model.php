<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_Model extends CI_Model{
//for getting user details
public function getreport($fdate,$tdate){
	$this->db->select('tblregistration.id,first_name, last_name, gender, blood, email, contact_no, state, city, password, 
	agree, address, create_date,bloodgroup.bloodname as bloodname,bloodgroup.id');
    $this->db->from('tblregistration');
	$this->db->join('bloodgroup','tblregistration.blood=bloodgroup.id','left');
	$this->db->where("date(create_date) between '$fdate' and '$tdate'");
	$query=$this->db->get();
					 
	return $query->result();  
} 

}


