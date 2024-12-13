<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_Model extends CI_Model{
//for getting user details
public function getusedetails($uid){
	$query=$this->db->select('FullName,Email,MobileNumber,RegDate')
	->where('ID',$uid)
	->from('tbluser')
	->get();
	return $query->row();
}

//For updating user details
public function updateprofile($uid,$fname,$mobno){
$data=array(
'FullName'=>$fname,
'MobileNumber'=>$mobno
);	
$query=$this->db->where('ID',$uid)
                ->update('tbluser',$data);
}


} 