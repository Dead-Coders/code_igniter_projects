<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {
	//Validating login
function __construct(){
parent::__construct();
if(!$this->session->userdata('uid'))
redirect('login');
}
//Function for logout
public function index(){
$this->session->unset_userdata('uid');
$this->session->sess_destroy();
return redirect('login');

}
}