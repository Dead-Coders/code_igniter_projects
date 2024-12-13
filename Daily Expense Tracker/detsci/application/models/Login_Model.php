<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login_Model extends CI_Model{

public function index($email,$encpass){
	$data=array(
'Email'=>$email,
'Password'=>$encpass);
$query=$this->db->where($data);
$login=$this->db->get('tbluser');
 if($login!=NULL){
return $login->row();
 }  
//return null;
//$this->session->set_flashdata('error','Invalid login details.');
//redirect('index');
               

}
}