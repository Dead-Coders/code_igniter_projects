<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StageItems_Controller extends CI_Controller
{
	public function __construct()
    {
            parent::__construct();
            $this->load->model('Stageitems_model');
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
			if($this->Util_model->getRight($this->session->userRowId,'Stage Items')==0)
			{
				$this->load->view('includes/header4all');
				$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);
				$this->load->view('ErrorUnauthenticateUser_view');
				$this->load->view('includes/footer');				
				return;
			}
			$data['records'] = $this->Stageitems_model->getDataLimit();
			$data['errorfound'] = "";
			$this->load->view('includes/header4all');
			$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);
			$data['stages'] = $this->Stageitems_model->getStages();
			$this->load->view('StageItems_view', $data);
			$this->load->view('includes/footer');
		}
		else 	/* if not logged in */	
		{
            $this->load->view('includes/header');           // with Jumbotron
        	$this->load->view('login_view');
	        $this->load->view('includes/footer');
		}
	}  

	public function insert()
	{
		if($this->Stageitems_model->checkDuplicate() == 1)
        {
        	$data = "Duplicate record...";
        	echo json_encode($data);
        }
        else
        {
			$this->Stageitems_model->insert();
			$data['records'] = $this->Stageitems_model->getDataLimit();
			echo json_encode($data);
        }
	}

	public function update()
	{
		if($this->Stageitems_model->checkDuplicateOnUpdate() == 1)
        {
        	$data = "Duplicate record...";
        	echo json_encode($data);
        }
        else
        {
			$this->Stageitems_model->update();
			$data['records'] = $this->Stageitems_model->getDataLimit();
			echo json_encode($data);
        }
	}

	public function delete()
	{
		$this->Stageitems_model->delete();
		$data['records'] = $this->Stageitems_model->getDataLimit();
		echo json_encode($data);
	}

	public function loadAllRecords()
	{
		$data['records'] = $this->Stageitems_model->getDataAll();
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
		$fileName = "excelfiles/SI_".date("Y_m_d_").date("H_i_s").".xls";
		copy('excelfiles/Q_blank.xls', $fileName);
		// copy('excelfiles/Q_blank.xls', 'excelfiles/Q.xls');

		// Create new PHPExcel object
		$objPHPExcel = PHPExcel_IOFactory::load('excelfiles/Q.xls');
		$objPHPExcel->setActiveSheetIndex(0);

		$data['org'] = $this->Util_model->getOrg();
		$orgName = $data['org'][0]['orgName'];
		$orgAddress1 = $data['org'][0]['add1'];
		$orgAddress2 = $data['org'][0]['add2'];
		$orgAddress3 = $data['org'][0]['add3'];
		$orgAddress4 = $data['org'][0]['add4'];
		///
		$myTableData = $this->input->post('TableData');
        $myTableData = stripcslashes($myTableData);
        $myTableData = json_decode($myTableData,TRUE);
        $myTableRows = count($myTableData);


		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:F1');
		$objPHPExcel->getActiveSheet()->setCellValue('A1', $orgName);
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true)->setSize(14)->getColor()->setRGB('000000');;

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:F2');
		$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Panchsheel, Ajmer. 9461070900');
		$objPHPExcel->getActiveSheet()->getStyle("A2")->getFont()->setBold(false)->setSize(12)->getColor()->setRGB('000000');;

		$stageName = $myTableData[0]['stageName'];
		if($stageName == "")
		{
			$stageName = "ALL";
		}

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:F3');
		$objPHPExcel->getActiveSheet()->setCellValue('A3', 'Stage Items: '.$stageName);
		$objPHPExcel->getActiveSheet()->getStyle("A3")->getFont()->setBold(false)->setSize(14)->getColor()->setRGB('0000FF');
		$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1); 


		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:F4');

		$objPHPExcel->getActiveSheet()->setCellValue('A5', 'S.N.');
		$objPHPExcel->getActiveSheet()->setCellValue('B5', 'Stage Name');
		$objPHPExcel->getActiveSheet()->setCellValue('C5', 'Item Name');
		$objPHPExcel->getActiveSheet()->setCellValue('D5', 'Qty');
		$objPHPExcel->getActiveSheet()->setCellValue('E5', 'Rate');
		$objPHPExcel->getActiveSheet()->setCellValue('F5', 'Amt');

		$objPHPExcel->getActiveSheet()->getStyle('F5:F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$cellRange1 = "A" . (5) . ":" . "F" . (5);
	 	$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	 	$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	 	$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getFont()->setBold(true);

		$r = $myTableRows;
		$productRows = "";
		$i = 6;
		$sno=0;
		for($k=0; $k < $r; $k++)
		{
			if($myTableData[$k]['stageName'] != "")
			{
			    $myCol = 0;
			    $sn = ++$sno;

			    // $objPHPExcel->getActiveSheet()->getStyle('A'.$i.'')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
       
			 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $sn);
			    $myCol = $myCol + 1;
			 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['stageName']);
			    $myCol = $myCol + 1;
			 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['stageItemName']);
				///Row Height Auto
		 		$objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(-1); 

				$i++;
		 	}
		}
		$cellRange1 = "A6:"  . "F" . ($i-1);
		$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getFont()->setBold(false)->setSize(14)->getColor()->setRGB('000000');

		$cellRange1 = "A5:"  . "F" . ($i-1);
		$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

		// $cellRange1 = "A" . ($i-1) . ":" . "F" . ($i-1);
	 // 	$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	 // 	$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	 // 	$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getFont()->setBold(true);


		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(0);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);	

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
		// $objWriter->save('php://output');	///to download without ajax call like hyperlink
		// $objWriter->save("excelfiles/$acname$branch.xls");
		$objWriter->save($fileName);
		echo base_url().$fileName;
		// $objWriter->save("excelfiles/Q.xls");
		// echo base_url()."excelfiles/Q.xls";

	}
}
