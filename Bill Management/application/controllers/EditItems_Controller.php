<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EditItems_Controller extends CI_Controller
{
	public function __construct()
    {
            parent::__construct();
            $this->load->model('Edititems_model');
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
			if($this->Util_model->getRight($this->session->userRowId,'Edit Items')==0)
			{
				$this->load->view('includes/header4all');
				$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);
				$this->load->view('ErrorUnauthenticateUser_view');
				$this->load->view('includes/footer');				
				return;
			}
			$this->load->view('includes/header4all');
			$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);
			$data="d";
			$this->load->view('EditItems_view', $data);
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

	public function showData()
	{
		$data['records'] = $this->Edititems_model->getDataForReport();
		echo json_encode($data);
	}

	public function showDataDeleted()
	{
		$data['records'] = $this->Edititems_model->getDataForReportDeleted();
		echo json_encode($data);
	}

	public function saveData()
	{
		$this->Edititems_model->insert();
		// echo json_encode($data);
		
	}

	public function delete()
	{
		$this->Edititems_model->delete();
		$data['records'] = $this->Edititems_model->getDataForReport();
		echo json_encode($data);
	}

	public function undelete()
	{
		$this->Edititems_model->undelete();
		// $data['records'] = $this->Edititems_model->getDataForReport();
		// echo json_encode($data);
	}

}
