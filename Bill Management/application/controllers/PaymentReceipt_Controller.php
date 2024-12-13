<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PaymentReceipt_Controller extends CI_Controller
{
	public function __construct()
    {
            parent::__construct();
            $this->load->model('Paymentreceipt_model');
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
			if($this->Util_model->getRight($this->session->userRowId,'Payment/Receipt')==0)
			{
				$this->load->view('includes/header4all');
				$MenuRights['mr'] = $this->Util_model->getUserRights();
				$MenuRights['notifications'] = $this->Util_model->getNotifications();
				$this->load->view('includes/menu4admin', $MenuRights);
				$this->load->view('ErrorUnauthenticateUser_view');
				$this->load->view('includes/footer');				
				return;
			}
			// $data['customers'] = $this->Paymentreceipt_model->getCustomers();
			$data['customers'] = $this->Util_model->getCustomerWithBalance();

			$this->load->model('Rptledger_model');
			$data['customers4Ledger'] = $this->Rptledger_model->getCustomerList();
			$data['records'] = $this->Paymentreceipt_model->getDataLimit();
			$data['errorfound'] = "";
			$this->load->view('includes/header4all');
			$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);

			$this->load->view('PaymentReceipt_view', $data);
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
		$customerRowId = $this->input->post('customerRowId');
        if( $customerRowId == -1 ) ///new customer (Check duplicate)
        {
        	if($this->Paymentreceipt_model->checkDuplicateNewCustomer() == 1)
	        {
	        	$data = "Duplicate new customer...";
	        	echo json_encode($data);
	        }
	        else
	        {
				$this->Paymentreceipt_model->insert();
				$data['records'] = $this->Paymentreceipt_model->getDataLimit();
				echo json_encode($data);
			}
        }
        else
        {
			$this->Paymentreceipt_model->insert();
			$data['newBalance'] = $this->Paymentreceipt_model->getCustomerNewBalance();
			$data['records'] = $this->Paymentreceipt_model->getDataLimit();
			$this->load->model('Rptledger_model');
			$data['opBal'] = $this->Rptledger_model->getOpeningBal();
			$data['records4Ledger'] = $this->Rptledger_model->getDataForReport();
			echo json_encode($data);
		}
	}


	public function showDetailOnUpdate()
	{
		// $data['customerInfo'] = $this->Paymentreceipt_model->getCustomerInfo();
		// echo json_encode($data);
	}

	public function checkForUpdate()
	{
		// if($this->Paymentreceipt_model->checkForUpdate() == 1)
  //       {
  //       	$data = "cant";
  //       	echo json_encode($data);
  //       }
	}
	
	public function update()
	{
		// if($this->input->post('customerRowId') == 98)
  //       {
		// 	$data['oldRecord'] = $this->Paymentreceipt_model->getOldRecord();
		// 	//////
		// 	$mobile = "9929598700";
		// 	$sms = "Voucher Edit: " . $data['oldRecord'][0]['vType'] . $data['oldRecord'][0]['refRowId'] . ", ". $data['oldRecord'][0]['amt']  . "/". $data['oldRecord'][0]['recd'] . ", ". $this->input->post('amt');

		//     $this->sendSms($mobile, $sms);
		// }
		// /////
		// $this->Paymentreceipt_model->update();
		// $data['records'] = $this->Paymentreceipt_model->getDataLimit();
		// echo json_encode($data);
	}

	public function sendSms($mob, $sms)
    {
      // $mobileString = $mob;
      // $msg = $sms;
      // $senderId = "KAMALC";
      // $smsQueryStr = "http://sms4power.com/api/swsendSingle.asp?username=t1poojaj&password=101498963&sender=".urlencode($senderId)."&sendto=".urlencode($mobileString)."&message=".urlencode($msg);
      // $ch = curl_init();
      // curl_setopt($ch, CURLOPT_URL, $smsQueryStr);
      // curl_setopt($ch, CURLOPT_HEADER, 0);
      // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      // $response = curl_exec($ch);
      // curl_close($ch);
    }

	public function delete()
	{
        {
			$this->Paymentreceipt_model->delete();
			$data['records'] = $this->Paymentreceipt_model->getDataLimit();
			echo json_encode($data);
		}
	}

	public function loadAllRecords()
	{
		$data['records'] = $this->Paymentreceipt_model->getDataAll();
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
