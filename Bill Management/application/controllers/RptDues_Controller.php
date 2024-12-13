<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RptDues_Controller extends CI_Controller
{
	public function __construct()
    {
            parent::__construct();
            $this->load->model('Rptdues_model');
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
			if($this->Util_model->getRight($this->session->userRowId,'Dues') == 0)
			{
				$this->load->view('includes/header4all');
				$MenuRights['mr'] = $this->Util_model->getUserRights();
				$MenuRights['notifications'] = $this->Util_model->getNotifications();
				$this->load->view('includes/menu4admin', $MenuRights);
				$this->load->view('ErrorUnauthenticateUser_view');
				$this->load->view('includes/footer');
				return;
			}
			/////////Current SMS bal
			  // $smsQueryStr = "http://nimbusit.co.in/api/checkbalance.asp?username=t1surendralekhyani&password=9352014111";
			  $smsQueryStr = "http://sms4power.com/api/checkbalance.asp?username=t1poojaj&password=101498963";
		      $ch = curl_init();
		      curl_setopt($ch, CURLOPT_URL, $smsQueryStr);
		      curl_setopt($ch, CURLOPT_HEADER, 0);
		      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		      $response = curl_exec($ch);
		      curl_close($ch);
		      $data['smsBalance'] = $response;
      		///////// END - Current SMS bal	
			$this->load->view('includes/header4all');
			$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);
			// $data['customers'] = $this->Rptdues_model->getCustomerList();
			// $this->load->view('RptDues_view', $data);
			$this->load->model('Rptledger_model');
			$data['customers4Ledger'] = $this->Rptledger_model->getCustomerList();
			$this->load->view('RptDues_view', $data);
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
		// $data['opBal'] = $this->Rptdues_model->getOpeningBal();
		$data['records'] = $this->Rptdues_model->getDues();
		$data['recordsNegative'] = $this->Rptdues_model->getDuesNegative();
		echo json_encode($data);
	}
	public function showDataNegative()
	{
		// $data['opBal'] = $this->Rptdues_model->getOpeningBal();
		$data['records'] = $this->Rptdues_model->getDuesNegative();
		echo json_encode($data);
	}

	public function showDetail()
	{
		$data['records'] = $this->Rptdues_model->showDetail();
		echo json_encode($data);
	}

	public function saveDateNew()
	{
		$this->Rptdues_model->saveDateNew();
		// $data['records'] = $this->Rptdues_model->showDetail();
		// echo json_encode($data);
	}

	public function showDataLedger()
	{
		$this->load->model('Rptledger_model');
		$data['opBal'] = $this->Rptledger_model->getOpeningBal();
		$data['records'] = $this->Rptledger_model->getDataForReport();
		echo json_encode($data);
	}
	public function getSaleDetail()
	{
		// $this->load->model('Quotation_model');
		$this->load->model('Rptledger_model');
		$data['records'] = $this->Rptledger_model->getSaleDetail();
		$data['recordsSr'] = $this->Rptledger_model->getSaleDetailSr();
		echo json_encode($data);
	}

	public function receiveAmt()
	{
		$this->Rptdues_model->receiveAmt();
		$data['records'] = $this->Rptdues_model->getDues();
		$data['recordsNegative'] = $this->Rptdues_model->getDuesNegative();
		echo json_encode($data);
	}

	public function payAmt()
	{
		$this->Rptdues_model->payAmt();
		$data['records'] = $this->Rptdues_model->getDues();
		$data['recordsNegative'] = $this->Rptdues_model->getDuesNegative();
		echo json_encode($data);
	}


	public function markDoobat()
	{
		$this->Rptdues_model->markDoobat();
		$data['records'] = $this->Rptdues_model->getDues();
		$data['recordsNegative'] = $this->Rptdues_model->getDuesNegative();
		echo json_encode($data);
	}

	public function checkBal()
    {
    	$smsQueryStr = "http://sms4power.com/api/checkbalance.asp?username=t1poojaj&password=101498963";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $smsQueryStr);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $response = curl_exec($ch);
      curl_close($ch);
      echo $response;
    }

    public function sendMsg()
	{
    	$TableData = $this->input->post('TableData');
        $TableData = stripcslashes($TableData);
        $TableData = json_decode($TableData,TRUE);
        $myTableRows = count($TableData);


    		$mobile="";
	        for ($i=0; $i < $myTableRows; $i++) 
	        {
	        	$mobile .=  $TableData[$i]['mobileNo'] . ',';
	        }
	        $mobile = substr($mobile, 0, strlen($mobile)-2);
	        // $mobile = substr($mobile, 0, count($mobile)-2);
	        $sms = $this->input->post('sms');
        	$this->sendSms($mobile, $sms);
        	echo json_encode($sms);
    }
    	public function sendSms($mob, $sms)
	    {
	      $mobileString = $mob;
	      $msg = $sms;
	      $senderId = "KAMALC";
      	  $smsQueryStr = "http://sms4power.com/api/swsend.asp?username=t1poojaj&password=101498963&sender=".urlencode($senderId)."&sendto=".urlencode($mobileString)."&message=".urlencode($msg);
      	  //http://sms4power.com/api/swsend.asp?username=xxxx&password=xxxx&sender=senderId&sendto=919xxxx,919xxxx&message=hello
	      $ch = curl_init();
	      curl_setopt($ch, CURLOPT_URL, $smsQueryStr);
	      curl_setopt($ch, CURLOPT_HEADER, 0);
	      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	      $response = curl_exec($ch);
	      curl_close($ch);
	    }





	function deleteOldRecs()
	{
		if( $this->input->post('p') != "MunnaBhai93520" )
		{
	        echo json_encode("Invalid...");
		}
		else
		{
			$this->Rptdues_model->deleteOldRecs();
		}
		echo json_encode("done...");
	}
}
