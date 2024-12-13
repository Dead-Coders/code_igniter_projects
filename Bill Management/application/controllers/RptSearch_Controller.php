<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RptSearch_Controller extends CI_Controller
{
	public function __construct()
    {
            parent::__construct();
            $this->load->model('Rptsearch_model');
            $this->load->helper('form');
            $this->load->helper('url');
            $r =$this->Util_model->getAuth();
	        if( $r==0)
	        {
	        	redirect(base_url());
	        }
    }
	public function index($argCustomerRowId=-1)
	{
		if ($this->session->isLogin===True && $this->session->session_id != '') /*if logged in*/
		{
			if($this->Util_model->getRight($this->session->userRowId,'Search')==0)
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
			// $data['argCustomerRowId'] = $argCustomerRowId;
			// $data['customers'] = $this->Rptsearch_model->getCustomerList();
			$data='';
			$this->load->view('RptSearch_view', $data);
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
		$data['ledgerData'] = $this->Rptsearch_model->getLedgerData();
		$data['reminderData'] = $this->Rptsearch_model->getReminderData();
		$data['datesData'] = $this->Rptsearch_model->getDatesData();
		$data['cashSaleData'] = $this->Rptsearch_model->getCashSaleData();
		echo json_encode($data);
	}
}
