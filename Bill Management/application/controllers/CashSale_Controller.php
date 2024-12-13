<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CashSale_Controller extends CI_Controller
{
	public function __construct()
    {
            parent::__construct();
            $this->load->model('Cashsale_model');
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
			if($this->Util_model->getRight($this->session->userRowId,'Cash Sale')==0)
			{
				$this->load->view('includes/header4all');
				$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);
				$this->load->view('ErrorUnauthenticateUser_view');
				$this->load->view('includes/footer');				
				return;
			}
			// $data['customers'] = $this->Cashsale_model->getCustomers();
			$data['items'] = $this->Cashsale_model->getItems();
			// $data['records'] = $this->Cashsale_model->getDataLimit();
			$data['errorfound'] = "";
			$this->load->view('includes/header4all');
			$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);

			$this->load->view('CashSale_view', $data);
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
		$this->Cashsale_model->insert();
		$data['records'] = $this->Cashsale_model->loadDataOfThisDate();
		echo json_encode($data);
		// $this->printToPdf('Save');
	}

	
	public function loadDataOfThisDate()
	{
		$data['records'] = $this->Cashsale_model->loadDataOfThisDate();
		// $data['customerInfo'] = $this->Cashsale_model->getCustomerInfo();
		echo json_encode($data);
	}

	

}
