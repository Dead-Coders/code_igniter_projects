<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RptItemsPurchaseAndSold_Controller extends CI_Controller
{
	public function __construct()
    {
            parent::__construct();
            $this->load->model('Rptitemspurchaseandsold_model');
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
			if($this->Util_model->getRight($this->session->userRowId,'Items Purchase And Sold')==0)
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
			// $data['parties'] = $this->Rptitemspurchaseandsold_model->getPartyList();
			$data['tmp'] = "tmp";
			$this->load->view('RptItemsPurchaseAndSold_view', $data);
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

		if( $this->input->post('vType') == "ALL" )
		{
			$data['records'] = $this->Rptitemspurchaseandsold_model->getDataForReportSale();
			$data['recordsPurchase'] = $this->Rptitemspurchaseandsold_model->getDataForReportPurchase();
			$data['recordsQuotation'] = $this->Rptitemspurchaseandsold_model->getDataForReportQuotation();
			$data['recordsCashSale'] = $this->Rptitemspurchaseandsold_model->getDataForReportCashSale();
		}
		else if( $this->input->post('vType') == "Sale" )
		{
			$data['records'] = $this->Rptitemspurchaseandsold_model->getDataForReportSale();
			$data['recordsPurchase'] = "";
			$data['recordsQuotation'] = "";
			$data['recordsCashSale'] = "";
		}
		else if( $this->input->post('vType') == "Purchase" )
		{
			$data['records'] = "";
			$data['recordsPurchase'] = $this->Rptitemspurchaseandsold_model->getDataForReportPurchase();
			$data['recordsQuotation'] = "";
			$data['recordsCashSale'] = "";
		}
		else if( $this->input->post('vType') == "Quotation" )
		{
			$data['records'] = "";
			$data['recordsPurchase'] = "";
			$data['recordsQuotation'] = $this->Rptitemspurchaseandsold_model->getDataForReportQuotation();
			$data['recordsCashSale'] = "";
		}
		else if( $this->input->post('vType') == "Cash Sale" )
		{
			$data['records'] = "";
			$data['recordsPurchase'] = "";
			$data['recordsQuotation'] = "";
			$data['recordsCashSale'] = $this->Rptitemspurchaseandsold_model->getDataForReportCashSale();
		}
		$timeEnd = microtime(TRUE);
		$data['timeTook'] = round( $timeEnd - $timeStart, 3 ) ;
		
		echo json_encode($data);
	}


}
