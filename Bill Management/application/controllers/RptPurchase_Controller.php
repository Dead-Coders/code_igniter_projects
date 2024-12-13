<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RptPurchase_Controller extends CI_Controller
{
	public function __construct()
    {
            parent::__construct();
            $this->load->model('Rptpurchase_model');
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
			if($this->Util_model->getRight($this->session->userRowId,'Purchase Report')==0)
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
			// $data['parties'] = $this->Rptpurchase_model->getPartyList();
			$data['tmp'] = "tmp";
			$this->load->view('RptPurchase_view', $data);
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
		$data['records'] = $this->Rptpurchase_model->getDataForReport();
		echo json_encode($data);
	}

	public function getProducts()
	{
		$data['products'] = $this->Rptpurchase_model->getProducts();
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
		copy('excelfiles/Q_blank.xls', 'excelfiles/tmp.xls');

		// Create new PHPExcel object
		$objPHPExcel = PHPExcel_IOFactory::load('excelfiles/tmp.xls');
		$objPHPExcel->setActiveSheetIndex(0);

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:O1');
		$objPHPExcel->getActiveSheet()->setCellValue('A1', "Purchase Report");
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true)->setSize(16)->getColor()->setRGB('0000FF');;

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:O2');
		$objPHPExcel->getActiveSheet()->setCellValue('A2', "From " . $this->input->post('dtFrom') . " To " . $this->input->post('dtTo'));

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:O3');

		$objPHPExcel->getActiveSheet()->setCellValue('A5', 'S.N.');
		$objPHPExcel->getActiveSheet()->setCellValue('B5', 'V.No');
		$objPHPExcel->getActiveSheet()->setCellValue('C5', 'Date');
		$objPHPExcel->getActiveSheet()->setCellValue('D5', 'Party');
		$objPHPExcel->getActiveSheet()->setCellValue('E5', 'Total Amt.');
		$objPHPExcel->getActiveSheet()->setCellValue('F5', 'Discount');
		$objPHPExcel->getActiveSheet()->setCellValue('G5', 'Pretax Amt');
		$objPHPExcel->getActiveSheet()->setCellValue('H5', 'IGST');
		$objPHPExcel->getActiveSheet()->setCellValue('I5', 'CGST');
		$objPHPExcel->getActiveSheet()->setCellValue('J5', 'SGST');
		$objPHPExcel->getActiveSheet()->setCellValue('K5', 'Net Amt');
		$objPHPExcel->getActiveSheet()->setCellValue('L5', 'Paid');
		$objPHPExcel->getActiveSheet()->setCellValue('M5', 'Balance');
		$objPHPExcel->getActiveSheet()->setCellValue('N5', 'Due Date');
		$objPHPExcel->getActiveSheet()->setCellValue('O5', 'Remarks');


		$cellRange1 = "A" . (5) . ":" . "O" . (5);
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
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['dbRowId']);
		    $myCol = $myCol + 1;
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['dt']);
		    $myCol = $myCol + 1;
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['customerName']);
		    $myCol = $myCol + 1;
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['totalAmt']);
		    $myCol = $myCol + 1;
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['totalDiscount']);
		    $myCol = $myCol + 1;
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['pretaxAmt']);
		    $myCol = $myCol + 1;
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['totalIgst']);
		    $myCol = $myCol + 1;
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['totalCgst']);
		    $myCol = $myCol + 1;
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['totalSgst']);
		    $myCol = $myCol + 1;
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['netAmt']);
		    $myCol = $myCol + 1;
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['paid']);
		    $myCol = $myCol + 1;
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['balance']);
		    $myCol = $myCol + 1;
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['dueDate']);
		    $myCol = $myCol + 1;
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['remarks']);
		 	$i++;
		}
		$r=$i-1;

		// $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, 'Total');
		// $objPHPExcel->getActiveSheet()->setCellValue('K'.$i, '=SUM(K6:K'.$r.')');

		$cellRange1 = "A" . ($i) . ":" . "O" . ($i);
	 	$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	 	$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	 	$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getFont()->setBold(true);

		$cellRange2 = "D" . (6) . ":" . "D" . ($i);
	 	$objPHPExcel->getActiveSheet()->getStyle($cellRange2)->getFont()->setSize(11);
	 	$objPHPExcel->getActiveSheet()->getStyle($cellRange2)->getAlignment()->setWrapText(true);

		

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(7);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(11);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(11);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(11);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(11);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(25);	

		$cellRange2 = "O" . (6) . ":" . "O" . ($i);
	 	$objPHPExcel->getActiveSheet()->getStyle($cellRange2)->getFont()->setSize(11);
	 	$objPHPExcel->getActiveSheet()->getStyle($cellRange2)->getAlignment()->setWrapText(true);

	 	////// Page Setup
		$objPHPExcel->getActiveSheet()
		    ->getPageSetup()
		    ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
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
		// $objWriter->save('php://output');	///to download without ajax call like hyperlink
		// $objWriter->save("excelfiles/$acname$branch.xls");
		$objWriter->save("excelfiles/tmp.xls");
		echo base_url()."excelfiles/tmp.xls";

	}

}
