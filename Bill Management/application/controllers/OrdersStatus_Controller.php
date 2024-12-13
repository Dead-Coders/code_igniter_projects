<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OrdersStatus_Controller extends CI_Controller
{
	public function __construct()
    {
            parent::__construct();
            $this->load->model('Ordersstatus_model');
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
			if($this->Util_model->getRight($this->session->userRowId,'Order Status')==0)
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
			// $data = "x";
			// $data['customers'] = $this->Ordersstatus_model->getCustomerList();
			$data['records'] = $this->Ordersstatus_model->getUndeliveredOrders();
			$data['recordsOld'] = $this->Ordersstatus_model->getDeliveredOrdersLastFive();
			$this->load->view('OrdersStatus_view', $data);
			$this->load->view('includes/footer');
		}
		else 	/* if not logged in */	
		{
            $this->load->view('includes/header');           // with Jumbotron
        	$this->load->view('login_view');
	        $this->load->view('includes/footer');
		}
	}  

	// public function showData()
	// {
	// 	$data['records'] = $this->Ordersstatus_model->getDataForReport();
	// 	echo json_encode($data);
	// }

	public function showDetail()
	{
		$data['records'] = $this->Ordersstatus_model->showDetail();
		// $data['puraneAdvance'] = $this->Ordersstatus_model->getData();
		echo json_encode($data);
	}
	
	public function saveChanges()
	{
		$this->Ordersstatus_model->saveChanges();
	}

	// public function deleteItem()
	// {
	// 	$this->Ordersstatus_model->deleteItem();
	// }

	public function sendSmsForItemsReady()
	{
		// $this->Ordersstatus_model->UpdateReadyMsg();
		$mobile = $this->input->post('mob');
		$sms = $this->input->post('sms');
		if($this->input->post('smsBhejo') == "YES" )
		{
			$this->Ordersstatus_model->UpdateReadyMsg();
	    	$this->sendSms($mobile, $sms);
	    }
	    // $this->sendSms($mobile, $sms);
	    $data['recordsOld'] = $this->Ordersstatus_model->getDeliveredOrdersLastFive();
	    echo json_encode($data);
	}
	public function sendSmsForDelivery()
	{
		$this->Ordersstatus_model->setDelivered();
		$mobile = $this->input->post('mob');
		$sms = $this->input->post('sms');
		if($this->input->post('smsBhejo') == "YES" )
		{
	    	$this->sendSms($mobile, $sms);
	    }
	    $data['recordsOld'] = $this->Ordersstatus_model->getDeliveredOrdersLastFive();
	    echo json_encode($data);
	}
	public function sendSms($mob, $sms)
    {
      $mobileString = $mob;
      $msg = $sms;
      // $senderId = "KAMALS";
      // $smsQueryStr = "http://nimbusit.co.in/api/swsend.asp?username=t1surendralekhyani&password=9352014111&sender=".urlencode($senderId)."&sendto=".urlencode($mobileString)."&message=".urlencode($msg);
      $senderId = "KAMALC";
      $smsQueryStr = "http://sms4power.com/api/swsendSingle.asp?username=t1poojaj&password=101498963&sender=".urlencode($senderId)."&sendto=".urlencode($mobileString)."&message=".urlencode($msg);
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $smsQueryStr);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $response = curl_exec($ch);
      curl_close($ch);
    }

    public function checkBal()
    {
      // $smsQueryStr = "http://nimbusit.co.in/api/checkbalance.asp?username=t1surendralekhyani&password=9352014111";
    	$smsQueryStr = "http://sms4power.com/api/checkbalance.asp?username=t1poojaj&password=101498963";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $smsQueryStr);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $response = curl_exec($ch);
      curl_close($ch);
      echo $response;
    }

    public function loadAllRecords()
	{
		$data['recordsOld'] = $this->Ordersstatus_model->getDeliveredOrdersAll();
		echo json_encode($data);
	}
}
