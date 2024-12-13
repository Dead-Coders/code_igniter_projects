<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_Model extends CI_Model{
//for getting user details
public function getadmindetails($uid){
	$query=$this->db->select('AdminName,UserName,MobileNumber,Email,AdminRegdate')
	->where('ID',$uid)
	->from('tbladmin')
	->get();
	return $query->row();
}

//For updating user details
public function updateprofile($uid,$fname,$emailid,$mobno){
$data=array(
'AdminName'=>$fname,
'MobileNumber'=>$mobno,
'Email'=>$emailid
);	
$query=$this->db->where('ID',$uid)
                ->update('tbladmin',$data);
}


} 