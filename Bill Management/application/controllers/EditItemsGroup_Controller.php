<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EditItemsGroup_Controller extends CI_Controller
{
	public function __construct()
    {
            parent::__construct();
            $this->load->model('Edititemsgroup_model');
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
			if($this->Util_model->getRight($this->session->userRowId,'Edit Items (Group)')==0)
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
			// $data="d";
			$data['itemGroups'] = $this->Edititemsgroup_model->getItemGroups();
			$data['itemGroupsForTable'] = $this->Edititemsgroup_model->getItemGroupsForTable();
			$this->load->view('EditItemsGroup_view', $data);
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
		$timeStart = microtime(TRUE);

		$data['records'] = $this->Edititemsgroup_model->getDataForReport();

		$timeEnd = microtime(TRUE);
		$data['timeTook'] = round( $timeEnd - $timeStart, 3 ) ;
		echo json_encode($data);
	}


	public function saveData()
	{
		$this->Edititemsgroup_model->insert();
		// echo json_encode($data);
		
	}


}
