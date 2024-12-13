<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Dashboard_Model extends CI_Model {

public function totalusercount(){
$query=$this->db->select('id')   
                 ->get('tblregistration');
return  $query->num_rows();
}

public function totalbloodgroupcount(){
    $query=$this->db->select('id')   
                     ->get('bloodgroup');
    return  $query->num_rows();
    }


}
