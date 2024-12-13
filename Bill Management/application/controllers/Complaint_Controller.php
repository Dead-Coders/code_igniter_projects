<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Complaint_Controller extends CI_Controller
{
	public function __construct()
    {
            parent::__construct();
            $this->load->model('Complaint_model');
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
			// if($this->Util_model->getRight($this->session->userRowId,'Complaint')==0)
			// {
			// 	$this->load->view('includes/header4all');
			// 	$MenuRights['mr'] = $this->Util_model->getUserRights();
			// $MenuRights['notifications'] = $this->Util_model->getNotifications();
			// $this->load->view('includes/menu4admin', $MenuRights);
			// 	$this->load->view('ErrorUnauthenticateUser_view');
			// 	$this->load->view('includes/footer');				
			// 	return;
			// }
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
			$data['customers'] = $this->Complaint_model->getCustomers();
			$data['records'] = $this->Complaint_model->getDataLimit();
			$data['recordsSolved'] = $this->Complaint_model->getDataLimitSolved();
			$data['errorfound'] = "";
			$this->load->view('includes/header4all');
			$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);

			$this->load->view('Complaint_view', $data);
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
        	if($this->Complaint_model->checkDuplicateNewCustomer() == 1)
	        {
	        	$data = "Duplicate new customer...";
	        	echo json_encode($data);
	        }
	        else
	        {
				$this->Complaint_model->insert();
				$this->doSms();
				$data['records'] = $this->Complaint_model->getDataLimit();
				echo json_encode($data);
			}
        }
        else
        {
			$this->Complaint_model->insert();
			$this->doSms();
			$data['records'] = $this->Complaint_model->getDataLimit();
			echo json_encode($data);
		}
	}


	// public function showDetailOnUpdate()
	// {
	// 	$data['customerInfo'] = $this->Complaint_model->getCustomerInfo();
	// 	echo json_encode($data);
	// }

	public function update()
	{
		$this->Complaint_model->update();
		$data['records'] = $this->Complaint_model->getDataLimit();
		echo json_encode($data);
	}



	public function delete()
	{
        {
			$this->Complaint_model->delete();
			$data['records'] = $this->Complaint_model->getDataLimit();
			echo json_encode($data);
		}
	}

	public function insertSolution()
	{
		$this->Complaint_model->insertSolution();
		$this->doSmsSolution();
		$data['records'] = $this->Complaint_model->getDataLimit();
		$data['recordsSolved'] = $this->Complaint_model->getDataLimitSolved();
		echo json_encode($data);
	}
	public function loadAllRecords()
	{
		$data['records'] = $this->Complaint_model->getDataAll();
		echo json_encode($data);
	}
	public function loadAllOldRecords()
	{
		$data['records'] = $this->Complaint_model->getDataAllSolved();
		echo json_encode($data);
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


	public function doSms()
	{
		$mobile = $this->input->post('mobile1');
		$sms = $this->input->post('sms');

		if($this->input->post('smsBhejo') == "YES" )
		{
	    	$this->sendSms($mobile, $sms);
	    }

	    ///////Sending name, address, phone number to Sonu Electrician
	    $sms = $this->input->post('customerName');
	    $sms .= "\n".$this->input->post('address');
	    $sms .= "\n".$this->input->post('mobile1');
	    $sms .= "\n".$this->input->post('complaint');
	    if($this->input->post('smsBhejo') == "YES" )
		{
			$this->load->model('Organisation_model');
            $data['orgInfo'] = $this->Organisation_model->getOrganisation();
            $electricianNo = $data['orgInfo'][0]['electricianNo'];
	    	$this->sendSms($electricianNo, $sms);
	    }
	}

	public function doSmsSolution()
	{
		$mobile = $this->Complaint_model->getMobileNo();
		$sms = $this->input->post('sms');

		if($this->input->post('smsBhejo') == "YES" )
		{
	    	$this->sendSms($mobile, $sms);
	    }

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
}
