<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recharge_Controller extends CI_Controller
{
	public function __construct()
    {
            parent::__construct();
            $this->load->model('Recharge_model');
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
			if($this->Util_model->getRight($this->session->userRowId,'Recharge')==0)
			{
				$this->load->view('includes/header4all');
				$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);
				$this->load->view('ErrorUnauthenticateUser_view');
				$this->load->view('includes/footer');				
				return;
			}
			$data['records'] = $this->Recharge_model->getDataLimit();
      $data['puraneNo'] = $this->Recharge_model->getPuraneNo();
      $data['tagList'] = $this->Recharge_model->getTagList();
			$data['errorfound'] = "";
			///// userRights
			
			$this->load->view('includes/header4all');
			$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);

            ////////Balance
              // $smsQueryStr = "https://www.parth.solutions/apiservice.asmx/GetBalance?apiToken=19a8dc33318d47ea8eb02f7577e49132";
              $smsQueryStr = "http://payem.co.in/RechargeApi/Balance.aspx?Username=9929598700&Password=9330";
              $ch = curl_init();
              curl_setopt($ch, CURLOPT_URL, $smsQueryStr);
              curl_setopt($ch, CURLOPT_HEADER, 0);
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
              $response = curl_exec($ch);
              curl_close($ch);
              //   $xml = simplexml_load_string($response);
              //   $json = json_encode($xml);
              //   $array = json_decode($json,TRUE);
                //$this->Recharge_model->updateStatus($array['status']);
                // $data['balance'] = $array[0];
                $data['balance'] = $response;
            ///////////

			$this->load->view('Recharge_view', $data);
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
		$this->Recharge_model->insert();
		$device = $this->input->post('device');
		$mn = $this->input->post('deviceId');
		$op = $this->input->post('op');
		$amt = $this->input->post('amt');
		$rowId = $this->Recharge_model->getRowId(); 
        $rowId = sprintf("%08d", $rowId);
		$reqId = $rowId;

        $smsQueryStr = "http://payem.co.in/RechargeApi/Recharge.aspx?Username=9929598700&Password=9330&Amount=". $amt ."&OperatorCode=".$op."&Number=".$mn."&ClientId=".$rowId."&CircleCode=18";
        
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $smsQueryStr);
          curl_setopt($ch, CURLOPT_HEADER, 0);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          $response = curl_exec($ch);
          curl_close($ch);
		
      ////////Balance
              $smsQueryStr = "http://payem.co.in/RechargeApi/Balance.aspx?Username=9929598700&Password=9330";
              $ch = curl_init();
              curl_setopt($ch, CURLOPT_URL, $smsQueryStr);
              curl_setopt($ch, CURLOPT_HEADER, 0);
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
              $response = curl_exec($ch);
              curl_close($ch);
              $data['balance'] = $response;
            ///////////

		$data['records'] = $this->Recharge_model->getDataLimit();
		echo json_encode($data);
	}


	public function loadAllRecords()
	{
		$data['records'] = $this->Recharge_model->getDataAll();
		echo json_encode($data);
	}

	public function checkBal()
    {
      // $smsQueryStr = "http://sms4power.com/api/checkbalance.asp?username=t1poojaj&password=101498963";
      // $smsQueryStr = "https://www.parth.solutions/apiservice.asmx/GetBalance?apiToken=3c935c7f862f49c69fb56bee07b5df4a";
      $smsQueryStr = "http://payem.co.in/RechargeApi/Balance.aspx?Username=9929598700&Password=9330";
      
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $smsQueryStr);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $response = curl_exec($ch);
      curl_close($ch);
      echo $response;
    }

    public function getStatus()
    {
        $rowId = $this->input->post('rowId');
        $rowId = sprintf("%08d", $rowId);
		$reqId = $rowId;
      
      // $smsQueryStr = "https://www.parth.solutions/apiservice.asmx/GetRechargeStatus?apiToken=19a8dc33318d47ea8eb02f7577e49132&reqid=".urlencode($reqId);
      
      $smsQueryStr = "http://payem.co.in/RechargeApi/RechargeStatus.aspx?Username=9929598700&Password=9330&ClientId=".urlencode($reqId);

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $smsQueryStr);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $response = curl_exec($ch);
      curl_close($ch);
    //   echo json_encode($response);
        // $xml = simplexml_load_string($response);
        // $json = json_encode($xml);
        // $array = json_decode($json,TRUE);
        // $this->Recharge_model->updateStatus($array['status']);
        $this->Recharge_model->updateStatus($response);
        // echo json_encode($xml);
        $data['records'] = $this->Recharge_model->getDataLimit();
		    echo json_encode($data);
    }
    
    

    // public function viewBill()
    // {
      
    //   $smsQueryStr = "https://www.parth.solutions/ws/viewBill?apiToken=19a8dc33318d47ea8eb02f7577e49132";
      
    //   $ch = curl_init();
    //   curl_setopt($ch, CURLOPT_URL, $smsQueryStr);
    //   curl_setopt($ch, CURLOPT_HEADER, 0);
    //   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //   $response = curl_exec($ch);
    //   curl_close($ch);
    //   echo $response;
    // }

}
