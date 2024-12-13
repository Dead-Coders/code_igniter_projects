<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RptPurchaseLog_Controller extends CI_Controller
{
	public function __construct()
    {
            parent::__construct();
            $this->load->model('Rptpurchaselog_model');
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
			if($this->Util_model->getRight($this->session->userRowId,'Purchase Log')==0)
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
			// $data['parties'] = $this->Rptpurchaselog_model->getPartyList();
			$data['tmp'] = "tmp";
			// $data['customers'] = $this->Util_model->getCustomerWithBalance();
			$data['itemList'] = $this->Rptpurchaselog_model->getItemList();
			
			$this->load->view('RptPurchaseLog_view', $data);
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
		$data['recordsPurchase'] = $this->Rptpurchaselog_model->getDataForReportPurchase();
		echo json_encode($data);
	}


}
