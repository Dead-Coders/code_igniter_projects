<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Expenses extends CI_Controller {
//Validating login
function __construct(){
parent::__construct();
if(!$this->session->userdata('uid'))
redirect('login');
}

//Function for adding expenses
public function add(){
//form validation
$this->form_validation->set_rules('expensedate','Expense date','required');
$this->form_validation->set_rules('item','Item','required');
$this->form_validation->set_rules('costitem','Item Cost','required|numeric');
if($this->form_validation->run())
{
$edate=$this->input->post('expensedate');
$item=$this->input->post('item');
$icost=$this->input->post('costitem');
$uid=$this->session->userdata('uid');	
$this->load->model('Expenses_Model');
$this->Expenses_Model->add($uid,$edate,$item,$icost);
} else{
$this->load->view('add-expense');
}
}
// Manage Expenses
public function manage(){
$uid=$this->session->userdata('uid');
$this->load->model('Expenses_Model');
$expdetails=$this->Expenses_Model->manage($uid);	
$this->load->view('manage-expense',['expensedetails'=>$expdetails]);
}
//Delete Expenses
public function delete($uid){
$this->load->model('Expenses_Model');
$this->Expenses_Model->delete($uid);
$this->session->set_flashdata('success','Expense Record deleted');
redirect('Expenses/manage');

}

}