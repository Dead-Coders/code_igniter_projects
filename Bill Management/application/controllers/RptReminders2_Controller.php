<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RptReminders2_Controller extends CI_Controller
{
	public function __construct()
    {
            parent::__construct();
            $this->load->model('Rptreminders2_model');
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
			if($this->Util_model->getRight($this->session->userRowId,'Reminders (Alarms)')==0)
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
			$this->load->model('Login_model');
			// $data['reminders'] = $this->Login_model->getReminders(); ///cust dues
			$data['recordsOnce'] = $this->Rptreminders2_model->getDataForReportOnce();
			$data['recordsWeekly'] = $this->Rptreminders2_model->getDataForReportWeekly();
			$data['recordsMonthly'] = $this->Rptreminders2_model->getDataForReportMonthly();
			$data['recordsYearly'] = $this->Rptreminders2_model->getDataForReportYearly();
			// $MenuRights['cnt'] = count($data['recordsOnce']) + count($data['recordsWeekly']) + count($data['recordsMonthly']) + count($data['recordsYearly']);
			// $MenuRights['cnt'] = count($data['recordsOnce']) + count($data['recordsWeekly']) + count($data['recordsMonthly']) + count($data['recordsYearly'])  + count($data['reminders']);
   //          $MenuRights['recordsOnce'] = $data['recordsOnce'];
   //          $MenuRights['recordsWeekly'] = $data['recordsWeekly'];
   //          $MenuRights['recordsMonthly'] = $data['recordsMonthly'];
   //          $MenuRights['recordsYearly'] = $data['recordsYearly'];
   //          $MenuRights['reminders'] = $data['reminders'];
            $MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('RptReminders2_view', $data);
            $this->load->view('includes/menu4admin', $MenuRights);  
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
		// $data['opBal'] = $this->Rptreminders2_model->getOpeningBal();
		$data['records'] = $this->Rptreminders2_model->getDataForReport();
		echo json_encode($data);
	}



	public function doSms()
	{
		$TableData = $this->input->post('TableData');
        $TableData = stripcslashes($TableData);
        $TableData = json_decode($TableData,TRUE);
        $myTableRows = count($TableData);


        if( $this->input->post('chkDear') == "Y" )
        {
	        for ($i=0; $i < $myTableRows; $i++) 
	        {
	        	$name =  $TableData[$i]['name'];
	        	$mobile =  $TableData[$i]['mobile'];
	        	$sms = $this->input->post('sms');
	        	$sms = "Dear ".$name.",\n".$sms;
	        	$this->sendSms($mobile, $sms);
	        }
    	}
    	else
    	{
    		$mobile="";
	        for ($i=0; $i < $myTableRows; $i++) 
	        {
	        	$mobile .=  '91' . $TableData[$i]['mobile'] . ',';

	        	if( $i%90 == 0 )
	        	{
	        		$mobile = substr($mobile, 0, count($mobile)-2);
			        $sms = $this->input->post('sms');
		        	$this->sendSms($mobile, $sms);
		        	$mobile="";
	        	}
	        }
	        $mobile = substr($mobile, 0, count($mobile)-2);
	        $sms = $this->input->post('sms');
        	$this->sendSms($mobile, $sms);
    	}
		// $this->Groupsms_model->insert();
	}

	public function sendSms($mob, $sms)
    {
      $mobileString = $mob;
      $msg = $sms;
      $senderId = $this->input->post('senderId');
      $smsQueryStr = "http://sms4power.com/api/swsendSingle.asp?username=t1poojaj&password=101498963&sender=".urlencode($senderId)."&sendto=".urlencode($mobileString)."&message=".urlencode($msg);
      // $smsQueryStr = "http://nimbusit.co.in/api/swsend.asp?username=t1surendralekhyani&password=82976319&sender=".urlencode($senderId)."&sendto=".urlencode($mobileString)."&message=".urlencode($msg);
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $smsQueryStr);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $response = curl_exec($ch);
      curl_close($ch);
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
}
