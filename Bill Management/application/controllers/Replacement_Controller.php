<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Replacement_Controller extends CI_Controller
{
	public function __construct()
    {
            parent::__construct();
            $this->load->model('Replacement_model');
            $this->load->helper('form');
            $this->load->helper('url');
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
			if($this->Util_model->getRight($this->session->userRowId,'Replacement')==0)
			{
				$this->load->view('includes/header4all');
				$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);
				$this->load->view('ErrorUnauthenticateUser_view');
				$this->load->view('includes/footer');				
				return;
			}
      $data['customers'] = $this->Replacement_model->getCustomers();
      
      $data['items'] = $this->Replacement_model->getItems();
      $data['records'] = $this->Replacement_model->getDataLimit();
			$data['recordsOld'] = $this->Replacement_model->getDataLimitOld();
			$data['errorfound'] = "";
			///// userRights
			
			$this->load->view('includes/header4all');
			$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);

			$this->load->view('Replacement_view', $data);
			$this->load->view('includes/footer');
		}
		else 	/* if not logged in */	
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
		$this->Replacement_model->insert();
		
      
		$data['records'] = $this->Replacement_model->getDataLimit();
		echo json_encode($data);

	}

	

  public function update()
  {
    
      $this->Replacement_model->update();
      $data['records'] = $this->Replacement_model->getDataLimit();
      echo json_encode($data);
  }
	public function delete()
	{
		
			$this->Replacement_model->delete();
			$data['records'] = $this->Replacement_model->getDataLimit();
			echo json_encode($data);
		
	}

  public function setSent()
  {
    $this->Replacement_model->setSent();
    $data['records'] = $this->Replacement_model->getDataLimit();
    echo json_encode($data);
  }

  public function setRecd()
  {
    $this->Replacement_model->setRecd();
    $data['records'] = $this->Replacement_model->getDataLimit();
    echo json_encode($data);
  }

	public function loadAllRecords()
	{
		$data['records'] = $this->Replacement_model->getDataAllOld();
		echo json_encode($data);
	}

}
