<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Resetpassword_Model extends CI_Model{

// For verfiying email and mobile
public function verifydata($emailid,$mobno){
	$data=array(
'Email'=>$emailid,
'MobileNumber'=>$mobno);

$resetpwd=$this->db->where($data)
                ->get('tbluser')->row();
      if($resetpwd!=NULL){
return $resetpwd->ID;
 } }

 // For updating Password
public function updatepassword($emailid,$mobno,$newpwd)
{
$data=array('Password' =>$newpwd );	
return $this->db->where(['Email'=>$emailid,'MobileNumber'=>$mobno])
                ->update('tbluser',$data);

   }
}