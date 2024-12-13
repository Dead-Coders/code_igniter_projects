<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_model extends CI_Model{

public function subject()
{
    $this->db->order_by("bloodname", "ASC");
    $query = $this->db->get("bloodgroup");
    return $query->result();
}


public function get($sdata){
    $data1 = array('blood'=> $sdata);
    $data2 = array('state'=> $sdata);
    $this->db->select('id, first_name, last_name, gender, blood, email, contact_no, state, city, password, agree, address, create_date');
    $this->db->from('tblregistration');
    $this->db->like($data1);
    $this->db->or_like($data2);
    $query=$this->db->get();
                     
    return $query->result();  
    }
 
} 

