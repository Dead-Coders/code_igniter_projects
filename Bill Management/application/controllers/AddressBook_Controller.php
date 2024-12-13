<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AddressBook_Controller extends CI_Controller
{
	public function __construct()
    {
            parent::__construct();
            $this->load->model('Addressbook_model');
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
			if($this->Util_model->getRight($this->session->userRowId,'Items')==0)
			{
				$this->load->view('includes/header4all');
				$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);
				$this->load->view('ErrorUnauthenticateUser_view');
				$this->load->view('includes/footer');				
				return;
			}
			$data['records'] = $this->Addressbook_model->getDataLimit();
			$data['errorfound'] = "";
			///// userRights
			
			// $arr = $this->Util_model->getUserRights();
	  //       $msg="";
	  //       foreach ($arr as $key => $value) {
	  //           $msg = $value['menuoption'].",".$msg;
	  //       }
	  //       $data['msg'] = $msg;
	        ///// END - userRights
			$this->load->view('includes/header4all');
			$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);

			$this->load->view('AddressBook_view', $data);
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
		if($this->Addressbook_model->checkDuplicate() == 1)
        {
        	$data = "Duplicate record...";
        	echo json_encode($data);
        }
        else
        {
			$this->Addressbook_model->insert();
			$data['records'] = $this->Addressbook_model->getDataLimit();
			echo json_encode($data);
        }
	}

	public function update()
	{
		if($this->Addressbook_model->checkDuplicateOnUpdate() == 1)
        {
        	$data = "Duplicate record...";
        	echo json_encode($data);
        }
        else
        {
			$this->Addressbook_model->update();
			$data['records'] = $this->Addressbook_model->getDataLimit();
			echo json_encode($data);
        }
	}

	public function delete()
	{
		$this->Addressbook_model->delete();
		$data['records'] = $this->Addressbook_model->getDataLimit();
		echo json_encode($data);
	}

	public function loadAllRecords()
	{
		$data['records'] = $this->Addressbook_model->getDataAll();
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
		$fileName = "excelfiles/L_".date("Y_m_d_").date("H_i_s").".xls";
		copy('excelfiles/Q_blank.xls', $fileName);
		// copy('excelfiles/Q_blank.xls', 'excelfiles/Q.xls');

		// Create new PHPExcel object
		$objPHPExcel = PHPExcel_IOFactory::load('excelfiles/Q.xls');
		$objPHPExcel->setActiveSheetIndex(0);

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:F1');
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Address Book');
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true)->setSize(16)->getColor()->setRGB('0000FF');;


		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:F2');
		// $objPHPExcel->getActiveSheet()->setCellValue('A2', "From " . $this->input->post('dtFrom') . " To " . $this->input->post('dtTo'));

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:F3');
		// $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Party: ' . $this->input->post('party'));

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:F4');

		$objPHPExcel->getActiveSheet()->setCellValue('A5', 'S.N.');
		$objPHPExcel->getActiveSheet()->setCellValue('B5', 'Name');
		$objPHPExcel->getActiveSheet()->setCellValue('C5', 'HNo');
		$objPHPExcel->getActiveSheet()->setCellValue('D5', 'Locality');
		$objPHPExcel->getActiveSheet()->setCellValue('E5', 'Occupation');
		$objPHPExcel->getActiveSheet()->setCellValue('F5', 'Tel');
		$objPHPExcel->getActiveSheet()->setCellValue('G5', 'Mobile');
		$objPHPExcel->getActiveSheet()->setCellValue('H5', 'Remarks');

		$objPHPExcel->getActiveSheet()->getStyle('F5:F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$cellRange1 = "A" . (5) . ":" . "H" . (5);
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
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['name']);
		    $myCol = $myCol + 1;
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['hNo']);
		    $myCol = $myCol + 1;
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['locality']);
		    $myCol = $myCol + 1;
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['occupation']);
		    $myCol = $myCol + 1;
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['telephone']);
		    $myCol = $myCol + 1;
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['mobile']);
		    $myCol = $myCol + 1;
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['remarks']);

		 	$i++;
		}
		// $r=$i-1;
		// $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, 'Total');
		// $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, '=SUM(F8:F'.$r.')');
		// $objPHPExcel->getActiveSheet()->setCellValue('H'.$i, '=SUM(H8:H'.$r.')');
		// $objPHPExcel->getActiveSheet()->setCellValue('J'.$i, '=SUM(J8:J'.$r.')');
		// $objPHPExcel->getActiveSheet()->setCellValue('K'.$i, '=SUM(K8:K'.$r.')');
		// $objPHPExcel->getActiveSheet()->setCellValue('L'.$i, '=SUM(L8:L'.$r.')');

		// $cellRange1 = "A" . ($i-1) . ":" . "H" . ($i-1);
	 // 	$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	 // 	$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	 // 	$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getFont()->setBold(true);

	 	// $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i-1), ' '); ///Remove S.N. in Total 

		$cellRange2 = "A" . (5) . ":" . "L" . ($i);
	 	$objPHPExcel->getActiveSheet()->getStyle($cellRange2)->getFont()->setSize(10);

	 	// $objPHPExcel->getActiveSheet()->setCellValue('D' . ($i+1), 'Cash in hand'); ///Remove S.N. in Total 
	 	// $objPHPExcel->getActiveSheet()->setCellValue('E' . ($i+1), $this->input->post('difference')); 
	 	// $cellRange1 = "A" . ($i+1) . ":" . "H" . ($i+1);
	 	// $objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getFont()->setBold(true);

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(14);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(14);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(14);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(14);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(14);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);	

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
		// $objWriter->save("excelfiles/Q.xls");
		// echo base_url()."excelfiles/Q.xls";
		$objWriter->save($fileName);
		echo base_url().$fileName;

	}

	public function exportDataMobile()
	{
		$this->printToExcelMobile();
	}

	public function printToExcelMobile()
	{


		$this->load->library('Excel');
		//////////// Copying blank file
		$fileName = "excelfiles/L_".date("Y_m_d_").date("H_i_s").".xls";
		copy('excelfiles/Q_blank.xls', $fileName);
		// copy('excelfiles/Q_blank.xls', 'excelfiles/Q.xls');

		// Create new PHPExcel object
		$objPHPExcel = PHPExcel_IOFactory::load('excelfiles/Q.xls');
		$objPHPExcel->setActiveSheetIndex(0);

		// $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:F1');
		// $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Address Book');
		// $objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true)->setSize(16)->getColor()->setRGB('0000FF');;


		// $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:F2');
		// // $objPHPExcel->getActiveSheet()->setCellValue('A2', "From " . $this->input->post('dtFrom') . " To " . $this->input->post('dtTo'));

		// $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:F3');
		// // $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Party: ' . $this->input->post('party'));

		// $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:F4');

		// $objPHPExcel->getActiveSheet()->setCellValue('A5', 'S.N.');
		// $objPHPExcel->getActiveSheet()->setCellValue('B5', 'Name');
		// $objPHPExcel->getActiveSheet()->setCellValue('C5', 'HNo');
		// $objPHPExcel->getActiveSheet()->setCellValue('D5', 'Locality');
		// $objPHPExcel->getActiveSheet()->setCellValue('E5', 'Occupation');
		// $objPHPExcel->getActiveSheet()->setCellValue('F5', 'Tel');
		// $objPHPExcel->getActiveSheet()->setCellValue('G5', 'Mobile');
		// $objPHPExcel->getActiveSheet()->setCellValue('H5', 'Remarks');

		// $objPHPExcel->getActiveSheet()->getStyle('F5:F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		// $cellRange1 = "A" . (5) . ":" . "H" . (5);
	 // 	$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	 // 	$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	 // 	$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getFont()->setBold(true);

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
		// $r=$i-1;
		// $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, 'Total');
		// $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, '=SUM(F8:F'.$r.')');
		// $objPHPExcel->getActiveSheet()->setCellValue('H'.$i, '=SUM(H8:H'.$r.')');
		// $objPHPExcel->getActiveSheet()->setCellValue('J'.$i, '=SUM(J8:J'.$r.')');
		// $objPHPExcel->getActiveSheet()->setCellValue('K'.$i, '=SUM(K8:K'.$r.')');
		// $objPHPExcel->getActiveSheet()->setCellValue('L'.$i, '=SUM(L8:L'.$r.')');

		// $cellRange1 = "A" . ($i-1) . ":" . "H" . ($i-1);
	 // 	$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	 // 	$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	 // 	$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getFont()->setBold(true);

	 	// $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i-1), ' '); ///Remove S.N. in Total 

		$cellRange2 = "A" . (5) . ":" . "L" . ($i);
	 	$objPHPExcel->getActiveSheet()->getStyle($cellRange2)->getFont()->setSize(10);

	 	// $objPHPExcel->getActiveSheet()->setCellValue('D' . ($i+1), 'Cash in hand'); ///Remove S.N. in Total 
	 	// $objPHPExcel->getActiveSheet()->setCellValue('E' . ($i+1), $this->input->post('difference')); 
	 	// $cellRange1 = "A" . ($i+1) . ":" . "H" . ($i+1);
	 	// $objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getFont()->setBold(true);

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(14);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(14);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(14);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(14);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(14);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);	

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
		// $objWriter->save("excelfiles/Q.xls");
		// echo base_url()."excelfiles/Q.xls";
		$objWriter->save($fileName);
		echo base_url().$fileName;

	}

}
