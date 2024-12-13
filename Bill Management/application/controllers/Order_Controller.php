<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_Controller extends CI_Controller
{
	public function __construct()
    {
            parent::__construct();
            $this->load->model('Order_model');
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
			if($this->Util_model->getRight($this->session->userRowId,'Order')==0)
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

			$data['customers'] = $this->Order_model->getCustomers();
			$data['items'] = $this->Order_model->getItems();
			$data['records'] = $this->Order_model->getDataLimit();
			$data['errorfound'] = "";
			$this->load->view('includes/header4all');
			$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);

			$this->load->view('Order_view', $data);
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
		$this->Order_model->insert();
		$this->doSms();
		$data['records'] = $this->Order_model->getDataLimit();
		echo json_encode($data);
		// $this->printToPdf('Save');
	}

	public function doSms()
	{
		$mobile = $this->input->post('mobile1');
		$sms = $this->input->post('sms');
		// $sms .= "Dear ".$this->input->post('customerName');
		// $sms .= ", Your order for ".$this->input->post('firstItem');
		// $sms .= " has been successfully placed.";
		// $sms .= "\nOrder No.: ".$this->Order_model->getDbNo();
		// $sms .= ", Delivery Dt.: ".$this->input->post('deliveryDt');
		// $sms .= ", Total Amt.: ".$this->input->post('totalAmt');
		// $sms .= ", Adv. Paid: ".$this->input->post('advance');
		// $sms .= ", Bal.: ".$this->input->post('due');
		// $sms .= "\n-Regards,\nSEACO TECH 7896544444";
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

	public function showDetailOnUpdate()
	{
		$data['records'] = $this->Order_model->showDetail();
		$data['customerInfo'] = $this->Order_model->getCustomerInfo();
		echo json_encode($data);
	}

	public function checkForUpdate()
	{
		if($this->Order_model->checkForUpdate() == 1)
        {
        	$data = "cant";
        	echo json_encode($data);
        }
	}
	
	public function update()
	{
		$this->Order_model->update();
		$data['records'] = $this->Order_model->getDataLimit();
		echo json_encode($data);
		// $this->printToPdf('Update');
	}



	public function delete()
	{
		if($this->Order_model->checkPossibility() == 1)
        {
        	$data = "yes";
        	echo json_encode($data);
        }
        else
        {
			$this->Order_model->delete();
			$data['records'] = $this->Order_model->getDataLimit();
			echo json_encode($data);
		}
	}

	public function loadAllRecords()
	{
		$data['records'] = $this->Order_model->getDataAll();
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
}
