<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Duplicates_Controller extends CI_Controller
{
	public function __construct()
    {
            parent::__construct();
            $this->load->model('Duplicates_model');
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
			if($this->Util_model->getRight($this->session->userRowId,'Duplicates')==0)
			{
				$this->load->view('includes/header4all');
				$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);
				$this->load->view('ErrorUnauthenticateUser_view');
				$this->load->view('includes/footer');				
				return;
			}
			$data['records'] = $this->Duplicates_model->getDataAll();
			$data['errorfound'] = "";
			///// userRights
			$this->load->view('includes/header4all');
			$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);

			$this->load->view('Duplicates_view', $data);
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
		$data['quotationDetail'] = $this->Duplicates_model->showQuotaionDetail();
		$data['cashSale'] = $this->Duplicates_model->showCashSale();
		$data['purchaseDetail'] = $this->Duplicates_model->showPurchaseDetail();
		$data['saleDetail'] = $this->Duplicates_model->showSaleDetail();
		echo json_encode($data);
	}

	public function replaceNow()
	{
		$this->Duplicates_model->replaceNow();
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
			$this->Duplicates_model->delete();
			$data['records'] = $this->Duplicates_model->getDataAll();
			echo json_encode($data);
		}
	}

}
