<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SendSms_Controller extends CI_Controller
{
	public function __construct()
    {
            parent::__construct();
            $this->load->model('Sendsms_model');
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
			if($this->Util_model->getRight($this->session->userRowId,'Send SMS')==0)
			{
				$this->load->view('includes/header4all');
				$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);
				$this->load->view('ErrorUnauthenticateUser_view');
				$this->load->view('includes/footer');				
				return;
			}
			$data['customers'] = $this->Sendsms_model->getCustomers();
			$data['records'] = $this->Sendsms_model->getDataLimit();
			$data['errorfound'] = "";
			$this->load->view('includes/header4all');
			$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);

			$this->load->view('SendSms_view', $data);
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
		$this->Sendsms_model->insert();
		$mobile = $this->input->post('mobile1');
		$sms = $this->input->post('smsData');
	    $this->sendSms($mobile, $sms);
		// $this->printToPdf('Save');
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

    public function sendSms($mob, $sms)
    {
      $mobileString = $mob;
      $msg = $sms;
      $senderId = "poojaa";
      // $senderId = "KAMALS";
      //$smsQueryStr = "http://nimbusit.co.in/api/swsend.asp?username=t1surendralekhyani&password=9352014111&sender=".urlencode($senderId)."&sendto=".urlencode($mobileString)."&message=".urlencode($msg);
      $senderId = "KAMALC";
      $smsQueryStr = "http://sms4power.com/api/swsendSingle.asp?username=t1poojaj&password=101498963&sender=".urlencode($senderId)."&sendto=".urlencode($mobileString)."&message=".urlencode($msg);
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $smsQueryStr);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $response = curl_exec($ch);
      curl_close($ch);
    }


	public function loadAllRecords()
	{
		$data['records'] = $this->Sendsms_model->getDataAll();
		echo json_encode($data);
	}

	public function loadAllMobiles()
	{
		$data['ab'] = $this->Sendsms_model->getDataAddressBook();
		$data['cust'] = $this->Sendsms_model->getDataCust();
		$data['recharge'] = $this->Sendsms_model->getDataRecharge();
		// $data_merged = array_merge($data['ab'], $data['cust']);
		echo json_encode($data);
	}

	public function exportDataMobile()
	{
		$this->printToExcelMobile();
	}

	public function printToExcelMobile()
	{


		$this->load->library('Excel');
		//////////// Copying blank file
		$fileName = "excelfiles/CustM_".date("Y_m_d_").date("H_i_s").".xls";
		copy('excelfiles/Q_blank.xls', $fileName);
		// copy('excelfiles/Q_blank.xls', 'excelfiles/Q.xls');

		// Create new PHPExcel object
		$objPHPExcel = PHPExcel_IOFactory::load('excelfiles/Q.xls');
		$objPHPExcel->setActiveSheetIndex(0);


		$myTableData = $this->input->post('TableData');
        $myTableData = stripcslashes($myTableData);
        $myTableData = json_decode($myTableData,TRUE);
        $myTableRows = count($myTableData);
		$r = $myTableRows;
		$productRows = "";
		$i = 1;
		for($k=0; $k < $r-1; $k++)
		{
		    $myCol = 0;
		    $sn = $k + 1;

		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $sn);
		    $myCol = $myCol + 1;
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['mobile']);

		 	$i++;
		}


		$cellRange2 = "A" . (5) . ":" . "L" . ($i);
	 	$objPHPExcel->getActiveSheet()->getStyle($cellRange2)->getFont()->setSize(10);


		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);	
		
	 	////// Page Setup
		$objPHPExcel->getActiveSheet()
		    ->getPageSetup()
		    ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
		$objPHPExcel->getActiveSheet()
		    ->getPageSetup()
		    ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		
		$objPHPExcel->getActiveSheet()
		    ->getPageMargins()->setTop(0.75);
		$objPHPExcel->getActiveSheet()
		    ->getPageMargins()->setRight(0.5);
		$objPHPExcel->getActiveSheet()
		    ->getPageMargins()->setLeft(0.5);
		$objPHPExcel->getActiveSheet()
		    ->getPageMargins()->setBottom(0.75);
	 	////// Page Setup Ends Here

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

		$objWriter->save($fileName);
		echo base_url().$fileName;

	}
}
