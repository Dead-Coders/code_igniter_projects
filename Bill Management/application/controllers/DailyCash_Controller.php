<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DailyCash_Controller extends CI_Controller
{
	public function __construct()
    {
            parent::__construct();
            $this->load->model('Dailycash_model');
            $this->load->helper('form');
            $this->load->helper('url');
            $r =$this->Util_model->getAuth();
	        if( $r==0)
	        {
	        	redirect(base_url());
	        }
    }
	public function index($argCustomerRowId=-1)
	{
		if ($this->session->isLogin===True && $this->session->session_id != '') /*if logged in*/
		{
			if($this->Util_model->getRight($this->session->userRowId,'Daily Cash')==0)
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
			$data['opBal'] = $this->Dailycash_model->getOpeningBal();
			$data['records'] = $this->Dailycash_model->getDataLimit();
			$data['plusDues'] = $this->Dailycash_model->getPlusDues();
			$data['minusDues'] = $this->Dailycash_model->getMinusDues();
			$data['purchaseSum'] = $this->Dailycash_model->getPurchaseSum();
			$data['paymentsSum'] = $this->Dailycash_model->getPaymentsSum();
			$data['upiCollection'] = $this->Dailycash_model->getUpiCollection();
			$this->load->view('DailyCash_view', $data);
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
		$this->Dailycash_model->insert();
		$data['opBal'] = $this->Dailycash_model->getOpeningBal();
		$data['records'] = $this->Dailycash_model->getDataLimit();
		$data['plusDues'] = $this->Dailycash_model->getPlusDues();
		$data['minusDues'] = $this->Dailycash_model->getMinusDues();
		$data['purchaseSum'] = $this->Dailycash_model->getPurchaseSum();
		$data['paymentsSum'] = $this->Dailycash_model->getPaymentsSum();
		$data['upiCollection'] = $this->Dailycash_model->getUpiCollection();
		echo json_encode($data);
	}

	public function showDataAll()
	{
		$data['opBal'] = '';
		$data['records'] = $this->Dailycash_model->getDataAll();
		echo json_encode($data);
	}

	

	public function exportData()
	{
		$this->printToExcel();
	}

	public function printToExcel()
	{
		$this->load->library('Excel');
		//////////// Copying blank file
		// $fileName = "excelfiles/DailyCash_".date("Y_m_d_").date("H_i_s").".xls";
		// copy('excelfiles/Q_blank.xls', $fileName);
		// copy('excelfiles/Q_blank.xls', 'excelfiles/Q.xls');
		copy('excelfiles/Q_blank.xls', 'excelfiles/tmp.xls');

		// Create new PHPExcel object
		$objPHPExcel = PHPExcel_IOFactory::load('excelfiles/tmp.xls');
		$objPHPExcel->setActiveSheetIndex(0);

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:G1');
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'DAILY CASH');
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true)->setSize(16)->getColor()->setRGB('0000FF');;

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:G4');

		$objPHPExcel->getActiveSheet()->setCellValue('A5', 'S.N.');
		$objPHPExcel->getActiveSheet()->setCellValue('B5', 'Date');
		$objPHPExcel->getActiveSheet()->setCellValue('C5', 'IN');
		$objPHPExcel->getActiveSheet()->setCellValue('D5', 'OUT');
		$objPHPExcel->getActiveSheet()->setCellValue('E5', 'In Hand');
		$objPHPExcel->getActiveSheet()->setCellValue('F5', 'Remarks');
		$objPHPExcel->getActiveSheet()->setCellValue('G5', 'RowId');

		$objPHPExcel->getActiveSheet()->getStyle('E5:G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$cellRange1 = "A" . (5) . ":" . "G" . (5);
	 	$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	 	$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	 	$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getFont()->setBold(true);

		$myTableData = $this->input->post('TableData');
        $myTableData = stripcslashes($myTableData);
        $myTableData = json_decode($myTableData,TRUE);
        $myTableRows = count($myTableData);
		$r = $myTableRows;
		$productRows = "";
		$i = 6;
		for($k=0; $k < $r-1; $k++)
		{
		    $myCol = 0;
		    $sn = $k + 1;

		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $sn);
		    $myCol = $myCol + 1;
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['dt']);
		    $myCol = $myCol + 1;
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['in']);
		    $myCol = $myCol + 1;
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['out']);
		    $myCol = $myCol + 1;
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['inHand']);
		    $myCol = $myCol + 1;
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['remarks']);
		    $myCol = $myCol + 1;
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['rowId']);

		 	$i++;
		}
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(0);	


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

		// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		// // $objWriter->save('php://output');///to download without ajax call like hyperlink
		// // $objWriter->save("excelfiles/$acname$branch.xls");
		// $objWriter->save($fileName);
		// echo base_url().$fileName;

		$dt = date("Y_m_d");
		$tm = date("H_i_s");
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save("excelfiles/DailyCash_" . $dt . ' (' . $tm . ') ' . ".xls");
		echo base_url()."excelfiles/DailyCash_" . $dt . ' (' . $tm . ') ' . ".xls";
		// $objWriter->save("excelfiles/tmp.xls");
		// echo base_url()."excelfiles/tmp.xls";
	}

	public function loadIntervalJobs()
    {
        $data['dailyCashInEntry'] = $this->Dailycash_model->dailyCashInEntry();
        echo json_encode($data);
    }

    public function deleteOldData()
    {
    	if($this->Dailycash_model->thisDateMustBeThare() == 0)
        {
        	$data = "This Date Not Found";
        	echo json_encode($data);
        }
        else
        {
	        $this->Dailycash_model->deleteOldData();
	        echo json_encode("done..");
	    }
    }
}
