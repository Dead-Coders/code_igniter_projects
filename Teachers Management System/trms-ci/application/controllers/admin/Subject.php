<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Subject extends CI_Controller
{
   function __construct(){
      parent::__construct();
       if(!$this->session->userdata('id'))
      redirect('admin/Logout');
   }

//Add Subject
  public function Add()
    {
        $this->form_validation->set_rules('subjectname', 'Subject Name', 'required');
        if ($this->form_validation->run())
        {
         $sname=$this->input->post('subjectname');  
         $this->load->model('admin/Subject_Model', 'subject');
         $this->subject->add( $sname);
         } else {
       $this->load->view('admin/subjects');
      }
    }
// View Subject
public function view(){
$this->load->model('admin/Subject_Model','subjectv');
$sdetails=$this->subjectv->view();   
$this->load->view('admin/subject-listed',['sresult'=>$sdetails]);
}

//Delete Subject
public function delete($uid){
$this->load->model('admin/Subject_Model','subjectd');
$this->subjectd->delete($uid);
$this->session->set_flashdata('success','Subject deleted');
redirect('admin/Subject/view');

}

    
}