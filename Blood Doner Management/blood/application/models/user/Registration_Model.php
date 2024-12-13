<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registration_Model extends CI_Model{
public function index($first_name,$last_name,$gender,$blood,$email,$contact_no,$state,$city,$agree,$password){
$data=array(
'first_name'=>$first_name,
'last_name'=>$last_name,
'gender'=>$gender,
'blood'=>$blood,
'email'=>$email,
'contact_no'=>$contact_no,
'state'=>$state,
'city'=>$city,
'agree'=>$agree,
'Password'=>$password);
$query=$this->db->insert('tblregistration',$data);
if($query){
$this->session->set_flashdata('success','Registration successfull, Now you can login.');	
redirect('user/Registration');
} else {
$this->session->set_flashdata('error','Something went wrong. Please try again.');	
redirect('user/Registration');	
}

}

}
