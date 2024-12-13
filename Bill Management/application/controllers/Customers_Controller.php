<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/* Start to develop here. Best regards https://php-download.com/ */
		use PhpOffice\PhpSpreadsheet\Spreadsheet;
		use PhpOffice\PhpSpreadsheet\IOFactory;


class Customers_Controller extends CI_Controller
{
	public function __construct()
    {
            parent::__construct();
            $this->load->model('Customers_model');
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
			if($this->Util_model->getRight($this->session->userRowId,'Customers')==0)
			{
				$this->load->view('includes/header4all');
				$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);
				$this->load->view('ErrorUnauthenticateUser_view');
				$this->load->view('includes/footer');				
				return;
			}
			$data['records'] = $this->Customers_model->getDataLimit();
			
			// $data['designations'] = $this->Customers_model->getDesignationList();
			
			$this->load->view('includes/header4all');
			$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);

			$this->load->view('Customers_view', $data);
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
		if($this->Customers_model->checkDuplicate() == 1)
        {
        	$data = "Duplicate record...";
        	echo json_encode($data);
        }
        else
        {
			$this->Customers_model->insert();
			$data['records'] = $this->Customers_model->getDataLimit();
			echo json_encode($data);
        }
	}

	public function update()
	{
		if($this->Customers_model->checkDuplicateOnUpdate() == 1)
        {
        	$data = "Duplicate record...";
        	echo json_encode($data);
        }
        else
        {
			$this->Customers_model->update();
			$data['records'] = $this->Customers_model->getDataLimit();
			echo json_encode($data);
        }
	}

	public function delete()
	{
		if($this->Util_model->isDependent('ledger', 'customerRowId', $this->input->post('rowId')) == 1)
        {
        	$data['dependent'] = "yes";
        	echo json_encode($data);
        }
        else
        {
			$this->Customers_model->delete();
			$data['records'] = $this->Customers_model->getDataLimit();
			echo json_encode($data);
		}
	}

	public function loadAllRecords()
	{
		$data['records'] = $this->Customers_model->getDataAll();
		echo json_encode($data);
	}





	public function exportData()
	{
		$this->printToExcel();
	}

	public function printToExcel()
	{


		// $this->load->library('Excel');
		//////////// Copying blank file
		$fileName = "excelfiles/Cust_".date("Y_m_d_").date("H_i_s").".xlsx";
		copy('excelfiles/Q_blank.xls', $fileName);
		// copy('excelfiles/Q_blank.xls', 'excelfiles/Q.xls');

		// Create new PHPExcel object
		$objPHPExcel = IOFactory::load('excelfiles/Q.xls');
		$objPHPExcel->setActiveSheetIndex(0);

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:F1');
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Party List');
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true)->setSize(16)->getColor()->setRGB('0000FF');;


		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:F2');
		// $objPHPExcel->getActiveSheet()->setCellValue('A2', "From " . $this->input->post('dtFrom') . " To " . $this->input->post('dtTo'));

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:F3');
		// $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Party: ' . $this->input->post('party'));

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:F4');

		$objPHPExcel->getActiveSheet()->setCellValue('A5', 'S.N.');
		$objPHPExcel->getActiveSheet()->setCellValue('B5', 'Name');
		$objPHPExcel->getActiveSheet()->setCellValue('C5', 'Address');
		$objPHPExcel->getActiveSheet()->setCellValue('D5', 'Mobile 1');
		$objPHPExcel->getActiveSheet()->setCellValue('E5', 'Mobile 2');
		$objPHPExcel->getActiveSheet()->setCellValue('F5', 'Remarks');

		$objPHPExcel->getActiveSheet()->getStyle('E5:G5')->getAlignment()->setHorizontal('center');
		// $objPHPExcel->getActiveSheet()->getStyle('F5:F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$cellRange1 = "A" . (5) . ":" . "F" . (5);
		$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
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
		    $myCol = 1;
		    $sn = $k + 1;

		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $sn);
		    $myCol = $myCol + 1;
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['name']);
		    $myCol = $myCol + 1;
		 	// $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['address']);
		    $myCol = $myCol + 1;
		 	// $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['mobile1']);
		 	$objPHPExcel->getActiveSheet()->setCellValueExplicit(
    'D'.$i,
    $myTableData[$k]['mobile1'],
    \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING
);
		    $myCol = $myCol + 1;
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['mobile2']);
		    $myCol = $myCol + 1;
		 	// $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['remarks']);

		 	$i++;
		}

		

		$cellRange2 = "A" . (5) . ":" . "F" . ($i);
	 	$objPHPExcel->getActiveSheet()->getStyle($cellRange2)->getFont()->setSize(10);


		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(14);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(14);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(14);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(14);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(14);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);	

	 	////// Page Setup
		$objPHPExcel->getActiveSheet()->getPageSetup()
			    ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
			$objPHPExcel->getActiveSheet()->getPageSetup()
			    ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
		
		$objPHPExcel->getActiveSheet()
		    ->getPageMargins()->setTop(0.75);
		$objPHPExcel->getActiveSheet()
		    ->getPageMargins()->setRight(0.5);
		$objPHPExcel->getActiveSheet()
		    ->getPageMargins()->setLeft(0.5);
		$objPHPExcel->getActiveSheet()
		    ->getPageMargins()->setBottom(0.75);
	 	////// Page Setup Ends Here

		$objWriter = IOFactory::createWriter($objPHPExcel, 'Xlsx');
		$objWriter->save($fileName);
		echo base_url().$fileName;

	}

	// public function printToExcelPhp73()
	// {


	// 	$this->load->library('Excel');
	// 	//////////// Copying blank file
	// 	$fileName = "excelfiles/Cust_".date("Y_m_d_").date("H_i_s").".xls";
	// 	copy('excelfiles/Q_blank.xls', $fileName);
	// 	// copy('excelfiles/Q_blank.xls', 'excelfiles/Q.xls');

	// 	// Create new PHPExcel object
	// 	$objPHPExcel = PHPExcel_IOFactory::load('excelfiles/Q.xls');
	// 	$objPHPExcel->setActiveSheetIndex(0);

	// 	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:F1');
	// 	$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Party List');
	// 	$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true)->setSize(16)->getColor()->setRGB('0000FF');;


	// 	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:F2');
	// 	// $objPHPExcel->getActiveSheet()->setCellValue('A2', "From " . $this->input->post('dtFrom') . " To " . $this->input->post('dtTo'));

	// 	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:F3');
	// 	// $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Party: ' . $this->input->post('party'));

	// 	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:F4');

	// 	$objPHPExcel->getActiveSheet()->setCellValue('A5', 'S.N.');
	// 	$objPHPExcel->getActiveSheet()->setCellValue('B5', 'Name');
	// 	$objPHPExcel->getActiveSheet()->setCellValue('C5', 'Address');
	// 	$objPHPExcel->getActiveSheet()->setCellValue('D5', 'Mobile 1');
	// 	$objPHPExcel->getActiveSheet()->setCellValue('E5', 'Mobile 2');
	// 	$objPHPExcel->getActiveSheet()->setCellValue('F5', 'Remarks');

	// 	$objPHPExcel->getActiveSheet()->getStyle('F5:F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	// 	$cellRange1 = "A" . (5) . ":" . "F" . (5);
	//  	$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	//  	$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	//  	$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getFont()->setBold(true);

	// 	$myTableData = $this->input->post('TableData');
 //        $myTableData = stripcslashes($myTableData);
 //        $myTableData = json_decode($myTableData,TRUE);
 //        $myTableRows = count($myTableData);
	// 	$r = $myTableRows;
	// 	$productRows = "";
	// 	$i = 6;
	// 	for($k=0; $k < $r-1; $k++)
	// 	{
	// 	    $myCol = 0;
	// 	    $sn = $k + 1;

	// 	 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $sn);
	// 	    $myCol = $myCol + 1;
	// 	 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['name']);
	// 	    $myCol = $myCol + 1;
	// 	 	// $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['address']);
	// 	    $myCol = $myCol + 1;
	// 	 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['mobile1']);
	// 	    $myCol = $myCol + 1;
	// 	 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['mobile2']);
	// 	    $myCol = $myCol + 1;
	// 	 	// $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['remarks']);

	// 	 	$i++;
	// 	}


	// 	$cellRange2 = "A" . (5) . ":" . "F" . ($i);
	//  	$objPHPExcel->getActiveSheet()->getStyle($cellRange2)->getFont()->setSize(10);


	// 	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);	
	// 	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);	
	// 	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(14);	
	// 	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(14);	
	// 	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(14);	
	// 	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(14);	
	// 	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(14);	
	// 	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);	

	//  	////// Page Setup
	// 	$objPHPExcel->getActiveSheet()
	// 	    ->getPageSetup()
	// 	    ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
	// 	$objPHPExcel->getActiveSheet()
	// 	    ->getPageSetup()
	// 	    ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		
	// 	$objPHPExcel->getActiveSheet()
	// 	    ->getPageMargins()->setTop(0.75);
	// 	$objPHPExcel->getActiveSheet()
	// 	    ->getPageMargins()->setRight(0.5);
	// 	$objPHPExcel->getActiveSheet()
	// 	    ->getPageMargins()->setLeft(0.5);
	// 	$objPHPExcel->getActiveSheet()
	// 	    ->getPageMargins()->setBottom(0.75);
	//  	////// Page Setup Ends Here

	// 	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	// 	$objWriter->save($fileName);
	// 	echo base_url().$fileName;

	// }
	public function exportDataMobile()
	{
		$this->printToExcelMobile();
	}


	public function printToExcelMobile()
	{
		// $this->load->library('Excel');
		//////////// Copying blank file
		$fileName = "excelfiles/CustM_".date("Y_m_d_").date("H_i_s").".xlsx";
		copy('excelfiles/Q_blank.xls', $fileName);
		// copy('excelfiles/Q_blank.xls', 'excelfiles/Q.xls');

		// Create new PHPExcel object
		$objPHPExcel = IOFactory::load('excelfiles/Q.xls');
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
		    $myCol = 1;
		    $sn = $k + 1;

		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $sn);
		    $myCol = $myCol + 1;
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['mobile']);

		 	$i++;
		}


		$cellRange2 = "A" . (5) . ":" . "L" . ($i);
	 	$objPHPExcel->getActiveSheet()->getStyle($cellRange2)->getFont()->setSize(10);


		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);	
		

	 	////// Page Setup
		$objPHPExcel->getActiveSheet()->getPageSetup()
			    ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
			$objPHPExcel->getActiveSheet()->getPageSetup()
			    ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
		
		$objPHPExcel->getActiveSheet()
		    ->getPageMargins()->setTop(0.75);
		$objPHPExcel->getActiveSheet()
		    ->getPageMargins()->setRight(0.5);
		$objPHPExcel->getActiveSheet()
		    ->getPageMargins()->setLeft(0.5);
		$objPHPExcel->getActiveSheet()
		    ->getPageMargins()->setBottom(0.75);
	 	////// Page Setup Ends Here

		$objWriter = IOFactory::createWriter($objPHPExcel, 'Xlsx');

		$objWriter->save($fileName);
		echo base_url().$fileName;

	}


	// public function printToExcelMobilePhp73()
	// {


	// 	$this->load->library('Excel');
	// 	//////////// Copying blank file
	// 	$fileName = "excelfiles/CustM_".date("Y_m_d_").date("H_i_s").".xls";
	// 	copy('excelfiles/Q_blank.xls', $fileName);
	// 	// copy('excelfiles/Q_blank.xls', 'excelfiles/Q.xls');

	// 	// Create new PHPExcel object
	// 	$objPHPExcel = PHPExcel_IOFactory::load('excelfiles/Q.xls');
	// 	$objPHPExcel->setActiveSheetIndex(0);


	// 	$myTableData = $this->input->post('TableData');
 //        $myTableData = stripcslashes($myTableData);
 //        $myTableData = json_decode($myTableData,TRUE);
 //        $myTableRows = count($myTableData);
	// 	$r = $myTableRows;
	// 	$productRows = "";
	// 	$i = 1;
	// 	for($k=0; $k < $r-1; $k++)
	// 	{
	// 	    $myCol = 0;
	// 	    $sn = $k + 1;

	// 	 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $sn);
	// 	    $myCol = $myCol + 1;
	// 	 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['mobile']);

	// 	 	$i++;
	// 	}


	// 	$cellRange2 = "A" . (5) . ":" . "L" . ($i);
	//  	$objPHPExcel->getActiveSheet()->getStyle($cellRange2)->getFont()->setSize(10);


	// 	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);	
	// 	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);	
	// 	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(14);	
	// 	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(14);	
	// 	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(14);	
	// 	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(14);	
	// 	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(14);	
	// 	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);	

	//  	////// Page Setup
	// 	$objPHPExcel->getActiveSheet()
	// 	    ->getPageSetup()
	// 	    ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
	// 	$objPHPExcel->getActiveSheet()
	// 	    ->getPageSetup()
	// 	    ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		
	// 	$objPHPExcel->getActiveSheet()
	// 	    ->getPageMargins()->setTop(0.75);
	// 	$objPHPExcel->getActiveSheet()
	// 	    ->getPageMargins()->setRight(0.5);
	// 	$objPHPExcel->getActiveSheet()
	// 	    ->getPageMargins()->setLeft(0.5);
	// 	$objPHPExcel->getActiveSheet()
	// 	    ->getPageMargins()->setBottom(0.75);
	//  	////// Page Setup Ends Here

	// 	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

	// 	$objWriter->save($fileName);
	// 	echo base_url().$fileName;

	// }
}
