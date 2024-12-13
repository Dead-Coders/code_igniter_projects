<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminRights_Controller extends CI_Controller 
{
	public function __construct()
    {
        parent::__construct();
        $this->load->model('Adminrights_model');
        $this->load->helper('url');
        // $this->load->library('session');
        $r =$this->Util_model->getAuth();
          if( $r==0)
          {
            redirect(base_url());
          }
    }

  public function index()
  {
      if ($this->session->isLogin===True && $this->session->session_id != '') /*if logged in*/
      {
          if($this->Util_model->getRight($this->session->userRowId,'Admin Rights')==0)
          {
              $this->load->view('includes/header4all');
              $MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);
              $this->load->view('ErrorUnauthenticateUser_view');
              $this->load->view('includes/footer');       
              return;
          }
          $data['records'] = $this->Adminrights_model->getData();
          $data['errorfound'] = "";
          $this->load->view('includes/header4all');
          $MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
          
			$this->load->view('includes/menu4admin', $MenuRights);

          $this->load->view('AdminRights_view', $data);
          $this->load->view('includes/footer');
      }
      else  /* if not logged in */  
      {
          $this->load->view('includes/header');           // with Jumbotron
          $this->load->model('Organisation_model');
          $data['orgInfo'] = $this->Organisation_model->getOrganisation();

          $this->load->view('login_view', $data);
          $this->load->view('includes/footer');
      }
  }      
	
  public function insert()
  {
      if($this->Adminrights_model->checkDuplicate() == 1)
      {
          $data = "Duplicate record...";
          echo json_encode($data);
      }
      else
      {
          $this->Adminrights_model->insert();
          $data['records'] = $this->Adminrights_model->getData();
          echo json_encode($data);
      }
  }

  

  public function delete()
  {
      $this->Adminrights_model->delete();
      $data['records'] = $this->Adminrights_model->getData();
      echo json_encode($data);
  }

}
