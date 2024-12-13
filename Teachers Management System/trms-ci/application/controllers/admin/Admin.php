<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
   function __construct(){
      parent::__construct();
       if(!$this->session->userdata('id'))
      redirect('admin/adminlogout/logout');
   }
   public function dashboard()
    {
        $this->load->view('admin/dashboard');
    }

  

    public function changepassword()
    {
        $this->form_validation->set_rules('currentpassword', 'Current Password', 'required');
        $this->form_validation->set_rules('newpassword', 'New Password', 'required');
        $this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'required|matches[newpassword]');
        if ($this
            ->form_validation->run())
        {
         $currentpassword=$this->input->post('currentpassword');  
         $newpassword=$this->input->post('newpassword');
         $adminid=$this->session->userdata('id');
         $hasedcurrentpassword=($currentpassword);
         $hasednewpassword=($newpassword);
         $this->load->model('admin/Admin_Model','admin');
         $currentpwd=$this->admin->getcurrentpassword($adminid);
         $dbcurrentpwd=$currentpwd->password;
         $this->load->model('admin/Admin_Model', 'admin');
         $currentpwd = $this->admin->getcurrentpassword($adminid);
         $dbcurrentpwd = $currentpwd->password;
            if ($hasedcurrentpassword == $dbcurrentpwd)
            {
             $this->load->model('admin/Admin_Model', 'admin');
             $this->admin->updatepassword($adminid, $hasednewpassword);
             $this->session->set_flashdata('success', 'Password changed successfully');
             redirect('admin/Admin/changepassword');
            }
            else
            {
             $this->session->set_flashdata('error', 'Current Password is wrong');
             redirect('admin/Admin/changepassword');
            }
         }
      else
      {
       $this->load->view('admin/changepassword');
      }
    }

    public function profile()
   {
      $this->load->model('admin/Admin_Model','profile');
      $adminId=$this->session->userdata('id');
      $data['adminresult'] = $this->profile->adminprofile($adminId);
      $this->load->view('admin/profile',$data);
   }


   public function getuserdata()
   {
      $this->load->model('admin/Admin_Model','viewregi');
      $data['uresult'] = $this->viewregi->getusedetails();
      $this->load->view('admin/view-registration',$data);
   }

   public function getdata($id)
   {
      $this->load->model('admin/Admin_Model','viewregi');
      $data['uresult'] = $this->viewregi->alldetails($id);
      $this->load->view('admin/details',$data);
   }
}