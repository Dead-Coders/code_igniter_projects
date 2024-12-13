<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Changepassword_Model extends CI_Model {

//Getting Current Password
public function getcurrentpassword($adminid){
$query=$this->db->where(['ID'=>$adminid])
                ->get('tbladmin');
           if($query->num_rows() > 0)
           {
           	return $query->row();
           }
}

// Updating New Password
public function updatepassword($adminid,$newpassword){
$data=array('Password' =>md5($newpassword));
return $this->db->where(['ID'=>$adminid])
                ->update('tbladmin',$data);

	}

}
