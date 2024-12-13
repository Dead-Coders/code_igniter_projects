<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Search extends CI_Controller {
function __construct(){
parent::__construct();
if(! $this->session->userdata('uid'))
redirect('Login');
}

public function index(){
$sdata=$this->input->post('searchdata');
$this->load->model('Search_Model');
$sresult=$this->Search_Model->get($sdata);
$this->load->view('search-result',['searchresult'=>$sresult]);
}




}