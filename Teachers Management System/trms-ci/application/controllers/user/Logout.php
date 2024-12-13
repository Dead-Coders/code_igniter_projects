<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

   public function index()
   {
   $this->session->unset_userdata('id');
   $this->session->sess_destroy();
   return redirect('user/login');
   }

 

}






