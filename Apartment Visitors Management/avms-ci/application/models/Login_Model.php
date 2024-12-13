<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Login_Model extends CI_Model {


public function validatelogin($username,$password){

$query=$this->db->where(['UserName'=>$username,'Password'=>md5($password)]);
	$account=$this->db->get('tbladmin')->row();
	if($account!=NULL){

return $account->ID;
}
return NULL;
}
}

