<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
  
    public function index()
    {
        $this->form_validation->set_rules('email', 'Email ID', 'trim|required');
        $this->form_validation->set_rules('password', 'password', 'trim|required');
        if ($this->form_validation->run() == false)
        {
          $this->load->view('admin/login');
        }
        else
        {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $this->load->model('admin/Admin_Model', 'admin');
            $uresult = $this->admin->checkLogin($email, $password);
            if ($uresult)
            {
                $this->session->set_userdata('id', $uresult->id);
                $this->session->set_userdata('name', $uresult->firstName);
                $this->session->set_userdata('email', $uresult->lastName);
                $this->session->set_userdata('contact', $uresult->contactno);

                redirect(base_url() . 'admin/Admin/dashboard');
            }
            else
            {
            $this ->session ->set_flashdata('msg', '<div class="alert alert-danger text-center">Email id And Password is Invalid!</div>');
                redirect('admin/Login');
            }
        }

    }

  

   
}