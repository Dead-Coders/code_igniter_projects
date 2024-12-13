<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_Model extends CI_Model{
//for getting user details
public function getusedetails($uid){
	$query=$this->db->select('tblregistration.id,first_name, last_name, gender, blood, email, contact_no, state, city, password, 
	agree, address, create_date,bloodgroup.bloodname as bloodname,bloodgroup.id')
	->join('bloodgroup','tblregistration.blood=bloodgroup.id','left')
     ->where('tblregistration.id',$uid)
	->from('tblregistration')
	->get();
	return $query->row();
}

//For updating user details
public function updateuserprofile($uid,$first_name,$last_name,$gender,$blood,$contact_no,$state,$city){
$data=array(
'first_name'=>$first_name,
'last_name'=>$last_name,
'gender'=>$gender,
'blood'=>$blood,
'contact_no'=>$contact_no,
'state'=>$state,
'city'=>$city
);	
$query=$this->db->where('id',$uid)
                ->update('tblregistration',$data);
}


} 