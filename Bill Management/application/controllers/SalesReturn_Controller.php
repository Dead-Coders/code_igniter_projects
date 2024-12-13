<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SalesReturn_Controller extends CI_Controller
{
	public function __construct()
    {
            parent::__construct();
            $this->load->model('Salesreturn_model');
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
			if($this->Util_model->getRight($this->session->userRowId,'Sale')==0)
			{
				$this->load->view('includes/header4all');
				$MenuRights['mr'] = $this->Util_model->getUserRights();
				$MenuRights['notifications'] = $this->Util_model->getNotifications();
				$this->load->view('includes/menu4admin', $MenuRights);
				$this->load->view('ErrorUnauthenticateUser_view');
				$this->load->view('includes/footer');				
				return;
			}
			// $data['customers'] = $this->Salesreturn_model->getCustomers();
			// $data['customers'] = $this->Util_model->getCustomerWithBalance();
			
			// $data['items'] = $this->Salesreturn_model->getItems();
			$data['recordsSold'] = $this->Salesreturn_model->getDataLimitSold();
			// $data['records'] = $this->Salesreturn_model->getDataLimit();
			$data['errorfound'] = "";
			$this->load->view('includes/header4all');
			$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);

			$this->load->view('SalesReturn_view', $data);
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
		$this->Salesreturn_model->insert();
		// $this->printToPdf('Save');
	}
	
	// public function getLastPurchasePrice()
	// {
	// 	$data['lastPurchasePrice'] = $this->Salesreturn_model->getLastPurchasePrice();
	// 	echo json_encode($data);
	// }

	// public function showDetailOnUpdate()
	// {
	// 	$data['records'] = $this->Salesreturn_model->showDetail();
	// 	$data['customerInfo'] = $this->Salesreturn_model->getCustomerInfo();
	// 	echo json_encode($data);
	// }

	// public function checkForUpdate()
	// {
	// 	if($this->Salesreturn_model->checkForUpdate() == 1)
 //        {
 //        	$data = "cant";
 //        	echo json_encode($data);
 //        }
	// }
	
	// public function update()
	// {
	// 	$this->Salesreturn_model->update();
	// 	$this->printToPdf('Update');
	// }

	
	// public function delete()
	// {
	// 	if($this->Salesreturn_model->checkPossibility() == 1)
 //        {
 //        	$data = "yes";
 //        	echo json_encode($data);
 //        }
 //        else
 //        {
	// 		$this->Salesreturn_model->delete();
	// 		$data['records'] = $this->Salesreturn_model->getDataLimit();
	// 		echo json_encode($data);
	// 	}
	// }

	// public function loadAllRecords()
	// {
	// 	$data['records'] = $this->Salesreturn_model->getDataAll();
	// 	echo json_encode($data);
	// }

	public function loadAllRecordsSold()
	{
		$data['records'] = $this->Salesreturn_model->getDataAllSold();
		echo json_encode($data);
	}
	// public function searchRecords()
	// {
	// 	$data['records'] = $this->Salesreturn_model->searchRecords();
	// 	echo json_encode($data);
	// }

	public function getSoldDetial()
	{
		$data['soldDetail'] = $this->Salesreturn_model->getSoldDetail();
		$data['srDetail'] = $this->Salesreturn_model->getSrDetail();
		echo json_encode($data);
	}
}
