<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DuplicateCustomers_Controller extends CI_Controller
{
	public function __construct()
    {
            parent::__construct();
            $this->load->model('Duplicatecustomers_model');
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
			if($this->Util_model->getRight($this->session->userRowId,'Duplicate Customers')==0)
			{
				$this->load->view('includes/header4all');
				$MenuRights['mr'] = $this->Util_model->getUserRights();
				$MenuRights['notifications'] = $this->Util_model->getNotifications();
				$this->load->view('includes/menu4admin', $MenuRights);
				$this->load->view('ErrorUnauthenticateUser_view');
				$this->load->view('includes/footer');				
				return;
			}
			$data['records'] = $this->Duplicatecustomers_model->getDataAll();
			$data['errorfound'] = "";
			///// userRights
			$this->load->view('includes/header4all');
			$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);

			$this->load->view('DuplicateCustomers_view', $data);
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
		$data['quotation'] = $this->Duplicatecustomers_model->showQuotaion();
		$data['ledger'] = $this->Duplicatecustomers_model->showLedger();
		$data['purchase'] = $this->Duplicatecustomers_model->showPurchase();
		$data['sale'] = $this->Duplicatecustomers_model->showSale();
		echo json_encode($data);
	}

	public function replaceNow()
	{
		$this->Duplicatecustomers_model->replaceNow();
		$data['records'] = "ddd";
		echo json_encode($data);
	}

	public function delete()
	{
		// if($this->Util_model->isDependent('addressbook', 'prefixTypeRowId', $this->input->post('rowId')) == 1)
  //       {
  //       	$data['dependent'] = "yes";
  //       	echo json_encode($data);
  //       }
  //       else
        {
			$this->Duplicatecustomers_model->delete();
			$data['records'] = $this->Duplicatecustomers_model->getDataAll();
			echo json_encode($data);
		}
	}

}
