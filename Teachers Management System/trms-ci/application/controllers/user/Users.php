<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

   function __construct(){
      parent::__construct();
       if(!$this->session->userdata('id'))
      redirect('user/logout');
   }

   public function dashboard()
   {
   $this->load->view('user/dashboard');
   }

	


   public function changepassword()
   {
      $this->form_validation->set_rules('currentpassword','Current Password','required');
      $this->form_validation->set_rules('newpassword','New Password','required');
      $this->form_validation->set_rules('confirmpassword','Confirm Password','required|matches[newpassword]');
      if($this->form_validation->run())
      {
         $currentpassword=$this->input->post('currentpassword');  
         $newpassword=$this->input->post('newpassword');
         $userid=$this->session->userdata('id');
         $hasedcurrentpassword=($currentpassword);
         $hasednewpassword=($newpassword);
         $this->load->model('Users_Model');
         $currentpwd=$this->Users_Model->getcurrentpassword($userid);
         $dbcurrentpwd=$currentpwd->password;
        if($hasedcurrentpassword==$dbcurrentpwd)
        {
         $this->Users_Model->updatepassword($userid,$hasednewpassword);

   $this->session->set_flashdata('success','Password changed successfully');
   redirect('user/Users/changepassword');
} else{
      $this->session->set_flashdata('error','Current Password is wrong');
   redirect('user/Users/changepassword');
}

} else {
$this->load->view('user/changepassword');
}
   }

   public function profile()
   {
        $this->load->model('Master_model');
      $data['sub'] = $this->Master_model->subject();
      $this->load->model('Users_Model');
      $userId=$this->session->userdata('id');
      $data['uresult'] = $this->Users_Model->getusedetails($userId);
      $this->load->view('user/userprofile',$data);
   }

   public function update()
   {
      $this->form_validation->set_rules('firstName','First Name','required');
      $this->form_validation->set_rules('lastName','Full Name','required');
       $this->form_validation->set_rules('email','Email Id','required|valid_email');
      $this->form_validation->set_rules('contactno','Mobile Number','required|exact_length[10]');
     /* $this->form_validation->set_rules('state','Full Name','required');
      $this->form_validation->set_rules('city','Full Name','required');
      $this->form_validation->set_rules('subject','Full Name','required');
      $this->form_validation->set_rules('qualification','Full Name','required');
      $this->form_validation->set_rules('Joiningdate','Full Name','required');
      $this->form_validation->set_rules('address','Full Name','required');*/
          
   if($this->form_validation->run())
      {
      //Getting Post Values
      $userid=$this->session->userdata('id');
      $firstName=$this->input->post('firstName');
      $lastName=$this->input->post('lastName');
      $email=$this->input->post('email');
      $contactno=$this->input->post('contactno');
      $state=$this->input->post('state');
      $city=$this->input->post('city');
      $subject=$this->input->post('subject');
      $pphoto=$this->input->post('profilephoto');
      $qualification=$this->input->post('qualification');
      $Joiningdate=$this->input->post('Joiningdate');
      $address=$this->input->post('address');
      /*$updateDate = date('d-m-y h:i:s');*/
   
    //profile photo upload
    
       if($pphoto=='')
       {
        $profilephoto=$this->input->post('photo');
       }
     else
       {
          $profilephoto=$this->input->post('profilephoto');
       }

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
      $profiledetails=$this->Users_Model->updateuserprofile($userid,$firstName,$lastName,$email,$contactno,$state,$city, $address,$subject,$profilephoto,$qualification,$Joiningdate);

   

      $this->session->set_flashdata('success','<div class="alert alert-success alert-dismissible fade show" role="alert">Profile updated successfull.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>'); 
      redirect('user/Users/profile');

      } else {
      $this->session->set_flashdata('error','<div class="alert alert-danger alert-dismissible fade show" role="alert">Something went wrong. Please try again.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>.');
      redirect('user/Users/profile');
      }
      }

}






