<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Changepassword_Model extends CI_Model{

// For getting current password
public function getcurrentpassword($uid){
$query=$this->db->where('ID',$uid)
                ->get('tbluser');
       if($query->num_rows()>0)
       {
       	return $query->row();
       } }
// For updating Password
public function updatepassword($uid,$newpassword)
{
$data=array('Password' =>$newpassword );	
return $this->db->where(['ID'=>$uid])
                ->update('tbluser',$data);
}       


}