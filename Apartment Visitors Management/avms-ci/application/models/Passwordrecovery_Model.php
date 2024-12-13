<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Passwordrecovery_Model extends CI_Model {

//Getting username and password
public function validatedetails($uname,$mnumber){
$query=$this->db->where(['UserName'=>$uname,'MobileNumber'=>$mnumber])
                ->get('tbladmin');
           if($query->num_rows() > 0)
           {
           	return $query->row();
           }
}

// Updating New Password
public function resetpassword($uname,$mno,$newpassword){
$data=array('Password' =>md5($newpassword));
return $this->db->where(['UserName'=>$uname,'MobileNumber'=>$mno])
                ->update('tbladmin',$data);

	}

}
