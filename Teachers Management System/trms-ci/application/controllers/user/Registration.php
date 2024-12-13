<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends CI_Controller {

 
	public function index()
	{    $this->load->model('Master_model');
		$data['sub'] = $this->Master_model->subject();
		$this->form_validation->set_rules('firstName', 'FirstName:', 'required');
		$this->form_validation->set_rules('lastName', 'LastName:', 'required');
		$this->form_validation->set_rules('email', 'Email:', 'required');
		$this->form_validation->set_rules('contactno', 'Contact No:', 'required');
		$this->form_validation->set_rules('state', 'State:', 'required');
		$this->form_validation->set_rules('city', 'City:', 'required');
		$this->form_validation->set_rules('address', 'Address:', 'required');
		$this->form_validation->set_rules('subject', 'Subject:', 'required');
		$this->form_validation->set_rules('qualification', 'Qualification:', 'required');
		$this->form_validation->set_rules('Joiningdate', 'Joiningdate:', 'required');
		$this->form_validation->set_rules('password', 'Password:', 'required');

         if ($this->form_validation->run()) 
        {

            $firstName=$this->input->post('firstName');
            $lastName=$this->input->post('lastName');
            $email=$this->input->post('email');
            $contactno=$this->input->post('contactno');
            $state=$this->input->post('state');
            $city=$this->input->post('city');
            $address=$this->input->post('address');
            $subject=$this->input->post('subject');
            $qualification=$this->input->post('qualification');
            $Joiningdate=$this->input->post('Joiningdate');
            $password=$this->input->post('password');

            //profile photo upload
                if (isset($_FILES['profilephoto']['name'])) {
                $this->load->library('upload');
                $config['upload_path'] = 'uploads/files/';
                $config['allowed_types']        = 'jpg|jpeg|png|pdf|gif';
                $config['file_name']  = date('YmdHms').'-'.rand(1,999999);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('profilephoto')) {

                   $uploaded = $this->upload->data();
                  $profilephoto =$uploaded['file_name'];
                  }
                }

		$this->load->model('Users_Model');
		$this->Users_Model->AddReg($firstName,$lastName,$email,$contactno,$state,$city,$address,$subject,$profilephoto,$qualification,$Joiningdate,$password); 

        }

        else
        {
           $this->load->view('user/registration',$data);
        }

		
	}



  

}






