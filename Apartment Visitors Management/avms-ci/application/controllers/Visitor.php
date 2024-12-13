<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Visitor extends CI_Controller {
function __construct(){
parent::__construct();
if(! $this->session->userdata('uid'))
redirect('Login');
}
//Function for adding new visitor	
public function index(){
//library form validation . you can also load this libray in application/autoload.php
$this->load->library('form_validation');
$this->form_validation->set_rules('visname','Visitor Name','required');
$this->form_validation->set_rules('mobilenumber','Mobile Number','required|numeric|exact_length[10]');
$this->form_validation->set_rules('address','Visitor Address','required');
$this->form_validation->set_rules('apartment','Apartment Number','required');
$this->form_validation->set_rules('floor','Floor/Wing','required');
$this->form_validation->set_rules('whomtomeet','Whom to meet','required');
$this->form_validation->set_rules('reasontomeet','Reason to Meet','required');
 if($this->form_validation->run()){
$vname=$this->input->post('visname');
$vmnumber=$this->input->post('mobilenumber');
$vaddress=$this->input->post('address');
$apartment=$this->input->post('apartment');
$floor=$this->input->post('floor');
$whomtomeet=$this->input->post('whomtomeet');
$reasontomeet=$this->input->post('reasontomeet');
$this->load->model('Visitor_Model');
$this->Visitor_Model->add($vname,$vmnumber,$vaddress,$apartment,$floor,$whomtomeet,$reasontomeet);
 }
 else{
$this->load->view("visitors-form");
 }
}
//View Visitors list
public function List(){
$this->load->model('Visitor_Model');
$vlist=$this->Visitor_Model->list();
$this->load->view('manage-visitors',['clrow'=>$vlist]);
}

//// For particular Visitor Dtails
public function Details($vid)
{
$this->load->model('Visitor_Model');
$vdetail=$this->Visitor_Model->getvisitordetails($vid);
$this->load->view('visitor-detail',['vd'=>$vdetail]);
}

//// For Updating Outing Details
public function Outing()
{
$this->load->library('form_validation');
$this->form_validation->set_rules('remark','Outing Remark','required');
 if($this->form_validation->run()){
$remark=$this->input->post('remark');
$vid=$this->input->post('visitorid');
$this->load->model('Visitor_Model');
$this->Visitor_Model->outing($remark,$vid);
 }
 else{
 	$this->session->set_flashdata('error', 'Somthing went worng. Try again!!');
		redirect('Visitor/List');
 }
}



}