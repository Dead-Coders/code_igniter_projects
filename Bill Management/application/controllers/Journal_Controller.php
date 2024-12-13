<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Journal_Controller extends CI_Controller
{
	public function __construct()
    {
            parent::__construct();
            $this->load->model('Journal_model');
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
			if($this->Util_model->getRight($this->session->userRowId,'Journal')==0)
			{
				$this->load->view('includes/header4all');
				$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);
				$this->load->view('ErrorUnauthenticateUser_view');
				$this->load->view('includes/footer');				
				return;
			}
			$data['customers'] = $this->Journal_model->getCustomers();
			$this->load->model('Rptledger_model');
			$data['customers4Ledger'] = $this->Rptledger_model->getCustomerList();
			$data['records'] = $this->Journal_model->getDataLimit();
			$data['errorfound'] = "";
			$this->load->view('includes/header4all');
			$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);

			$this->load->view('Journal_view', $data);
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
		// $paidByRowId = $this->input->post('paidByRowId');
  //       if( $paidByRowId == -1 ) ///new customer (Check duplicate)
  //       {
  //       	if($this->Journal_model->checkDuplicateNewPaidByAc() == 1)
	 //        {
	 //        	$data = "Duplicate new paid by account...";
	 //        	echo json_encode($data);
	 //        }
  //       	else if($this->Journal_model->checkDuplicateNewReceivedByAc() == 1)
	 //        {
	 //        	$data = "Duplicate new received by account...";
	 //        	echo json_encode($data);
	 //        }
	 //        else
	  //       {
			// 	$this->Journal_model->insert();
			// 	$data['records'] = $this->Journal_model->getDataLimit();
			// 	echo json_encode($data);
			// }
        // }
        // else
        {
			$this->Journal_model->insert();
			$data['records'] = $this->Journal_model->getDataLimit();
			// $this->load->model('Rptledger_model');
			// $data['opBal'] = $this->Rptledger_model->getOpeningBal();
			// $data['records4Ledger'] = $this->Rptledger_model->getDataForReport();
			echo json_encode($data);
		}
	}


	public function showDetailOnUpdate()
	{
		$data['customerInfo'] = $this->Journal_model->getCustomerInfo();
		echo json_encode($data);
	}

	public function checkForUpdate()
	{
		if($this->Journal_model->checkForUpdate() == 1)
        {
        	$data = "cant";
        	echo json_encode($data);
        }
	}
	
	public function update()
	{
		$this->Journal_model->update();
		$data['records'] = $this->Journal_model->getDataLimit();
		echo json_encode($data);
	}



	public function delete()
	{
        {
			$this->Journal_model->delete();
			$data['records'] = $this->Journal_model->getDataLimit();
			echo json_encode($data);
		}
	}

	public function loadAllRecords()
	{
		$data['records'] = $this->Journal_model->getDataAll();
		echo json_encode($data);
	}

	public function showData()
	{
		$this->load->model('Rptledger_model');
		$data['opBal'] = $this->Rptledger_model->getOpeningBal();
		$data['records'] = $this->Rptledger_model->getDataForReport();
		echo json_encode($data);
	}

}
