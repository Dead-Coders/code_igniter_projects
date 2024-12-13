<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// require_once("vendor/autoload.php"); 

		/* Start to develop here. Best regards https://php-download.com/ */
		use PhpOffice\PhpSpreadsheet\Spreadsheet;
		use PhpOffice\PhpSpreadsheet\IOFactory;

class RptLedger_Controller extends CI_Controller
{
	public function __construct()
    {
            parent::__construct();
            $this->load->model('Rptledger_model');
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
			if($this->Util_model->getRight($this->session->userRowId,'Ledger')==0)
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
			$data['argCustomerRowId'] = $argCustomerRowId;
			$data['customers'] = $this->Util_model->getCustomerWithBalance();
			// $data['customers'] = $this->Rptledger_model->getCustomerList();
			$this->load->view('RptLedger_view', $data);
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
		$data['opBal'] = $this->Rptledger_model->getOpeningBal();
		$data['records'] = $this->Rptledger_model->getDataForReport();
		echo json_encode($data);
	}

	public function exportData()
	{
		$this->printToExcel();
	}
	public function printToExcel()
	{
		

		// $spreadsheet = new Spreadsheet();

		// //Specify the properties for this document
		// $spreadsheet->getProperties()
		//     ->setTitle('PHP Download Example')
		//     ->setSubject('A PHPExcel example')
		//     ->setDescription('A simple example for PhpSpreadsheet. This class replaces the PHPExcel class')
		//     ->setCreator('php-download.com')
		//     ->setLastModifiedBy('php-download.com');

		// //Adding data to the excel sheet
		// $spreadsheet->setActiveSheetIndex(0)
		//     ->setCellValue('A1', 'This')
		//     ->setCellValue('A2', 'is')
		//     ->setCellValue('A3', 'only')
		//     ->setCellValue('A4', 'an')
		//     ->setCellValue('A5', 'example');

		// $spreadsheet->getActiveSheet()
		//     ->setCellValue('B1', "You")
		//     ->setCellValue('B2', "can")
		//     ->setCellValue('B3', "download")
		//     ->setCellValue('B4', "this")
		//     ->setCellValue('B5', "library")
		//     ->setCellValue('B6', "on")
		//     ->setCellValue('B7', "https://php-download.com/package/phpoffice/phpspreadsheet");


		// $spreadsheet->getActiveSheet()
		//     ->setCellValue('C1', 1)
		//     ->setCellValue('C2', 0.5)
		//     ->setCellValue('C3', 0.25)
		//     ->setCellValue('C4', 0.125)
		//     ->setCellValue('C5', 0.0625);

		// $spreadsheet->getActiveSheet()
		//     ->setCellValue('C6', '=SUM(C1:C5)');
		// $spreadsheet->getActiveSheet()
		//     ->getStyle("C6")->getFont()
		//     ->setBold(true);

		    $objPHPExcel = IOFactory::load('excelfiles/Q.xls');
			$objPHPExcel->setActiveSheetIndex(0);

			$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:G1');
			$objPHPExcel->getActiveSheet()->setCellValue('A1', 'LEDGER');
			$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true)->setSize(16)->getColor()->setRGB('0000FF');;


			$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:G2');
			$objPHPExcel->getActiveSheet()->setCellValue('A2', "From " . $this->input->post('dtFrom') . " To " . $this->input->post('dtTo'));

			$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:G3');
			$objPHPExcel->getActiveSheet()->setCellValue('A3', 'Party: ' . $this->input->post('party'));

			$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:G4');

			$objPHPExcel->getActiveSheet()->setCellValue('A5', 'S.N.');
			$objPHPExcel->getActiveSheet()->setCellValue('B5', 'V.No');
			$objPHPExcel->getActiveSheet()->setCellValue('C5', 'Remarks');
			$objPHPExcel->getActiveSheet()->setCellValue('D5', 'Date');
			$objPHPExcel->getActiveSheet()->setCellValue('E5', 'Paid');
			$objPHPExcel->getActiveSheet()->setCellValue('F5', 'Recd.');
			$objPHPExcel->getActiveSheet()->setCellValue('G5', 'Bal.');

			$objPHPExcel->getActiveSheet()->getStyle('E5:G5')->getAlignment()->setHorizontal('center');
			// $objPHPExcel->getActiveSheet()->getStyle('E5:G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$cellRange1 = "A" . (5) . ":" . "G" . (5);
			$styleArray = [
			    'borders' => [
			        'outline' => [
			            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
			            'color' => ['argb' => 'FF000000'],
			        ],
			    ],
			];
			//Apply border style to the cells
			$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->applyFromArray($styleArray);
		 	// $objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN);
		 	// $objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
		 	// $objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getFont()->setBold(true);

			$myTableData = $this->input->post('TableData');
	        $myTableData = stripcslashes($myTableData);
	        $myTableData = json_decode($myTableData,TRUE);
	        $myTableRows = count($myTableData);
	        // $myTableRows = strlen($myTableData);
			$r = $myTableRows;
			$productRows = "";
			$i = 6;
			for($k=0; $k < $r-1; $k++)
			{
			    $myCol = 0;
			    $sn = $k + 1;

			 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $sn);
			    $myCol = $myCol + 1;
			 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['vType']);
			    $myCol = $myCol + 1;
			 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['Rem']);
			    $myCol = $myCol + 1;
			 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['dt']);
			    $myCol = $myCol + 1;
			 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['Dr']);
			    $myCol = $myCol + 1;
			 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['Cr']);
			    $myCol = $myCol + 1;
			 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['Bal']);

			 	$i++;
			}
			// $r=$i-1;
			// $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, 'Total');
			// $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, '=SUM(F8:F'.$r.')');
			// $objPHPExcel->getActiveSheet()->setCellValue('H'.$i, '=SUM(H8:H'.$r.')');
			// $objPHPExcel->getActiveSheet()->setCellValue('J'.$i, '=SUM(J8:J'.$r.')');
			// $objPHPExcel->getActiveSheet()->setCellValue('K'.$i, '=SUM(K8:K'.$r.')');
			// $objPHPExcel->getActiveSheet()->setCellValue('L'.$i, '=SUM(L8:L'.$r.')');

			$cellRange1 = "A" . ($i-1) . ":" . "G" . ($i-1);
			$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->applyFromArray($styleArray);
		 	// $objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		 	// $objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		 	$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getFont()->setBold(true);

		 	$objPHPExcel->getActiveSheet()->setCellValue('A' . ($i-1), ' '); ///Remove S.N. in Total 

			$cellRange2 = "A" . (5) . ":" . "L" . ($i);
		 	$objPHPExcel->getActiveSheet()->getStyle($cellRange2)->getFont()->setSize(10);

		 	$objPHPExcel->getActiveSheet()->setCellValue('D' . ($i+1), 'Difference'); ///Remove S.N. in Total 
		 	$objPHPExcel->getActiveSheet()->setCellValue('E' . ($i+1), $this->input->post('difference')); 
		 	$cellRange1 = "A" . ($i+1) . ":" . "G" . ($i+1);
		 	$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getFont()->setBold(true);

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);	
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(7);	
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);	
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);	
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);	
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);	

			/// page setup
			$objPHPExcel->getActiveSheet()->getPageSetup()
			    ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
			$objPHPExcel->getActiveSheet()->getPageSetup()
			    ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
			$objPHPExcel->getActiveSheet()
			    ->getPageMargins()->setTop(0.2);
			$objPHPExcel->getActiveSheet()
			    ->getPageMargins()->setRight(0.2);
			$objPHPExcel->getActiveSheet()
			    ->getPageMargins()->setLeft(0.2);
			$objPHPExcel->getActiveSheet()
			    ->getPageMargins()->setBottom(0.2);

		 // 	////// Page Setup
			// $objPHPExcel->getActiveSheet()
			//     ->getPageSetup()
			//     ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
			// $objPHPExcel->getActiveSheet()
			//     ->getPageSetup()
			//     ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
			
			// $objPHPExcel->getActiveSheet()
			//     ->getPageMargins()->setTop(0.75);
			// $objPHPExcel->getActiveSheet()
			//     ->getPageMargins()->setRight(0.5);
			// $objPHPExcel->getActiveSheet()
			//     ->getPageMargins()->setLeft(0.5);
			// $objPHPExcel->getActiveSheet()
			//     ->getPageMargins()->setBottom(0.75);
		 // 	////// Page Setup Ends Here

		    $fileName = "excelfiles/L_".date("Y_m_d_").date("H_i_s").".xlsx";
			copy('excelfiles/Q_blank.xls', $fileName);
			$objWriter = IOFactory::createWriter($objPHPExcel, 'Xlsx');
			// $objWriter->save('php://output');///to download without ajax call like hyperlink
			// $objWriter->save("excelfiles/$acname$branch.xls");
			$objWriter->save($fileName);
			echo base_url().$fileName;

		// $writer = IOFactory::createWriter($spreadsheet, "Xlsx"); //Xls is also possible
		// $writer->save("my_excel_file.xlsx");



	}

	public function printToExcelForPhp73()
	{
		$this->load->library('Excel');
		//////////// Copying blank file
		$fileName = "excelfiles/L_".date("Y_m_d_").date("H_i_s").".xls";
		copy('excelfiles/Q_blank.xls', $fileName);
		// copy('excelfiles/Q_blank.xls', 'excelfiles/Q.xls');

		// Create new PHPExcel object
		$objPHPExcel = PHPExcel_IOFactory::load('excelfiles/Q.xls');
		$objPHPExcel->setActiveSheetIndex(0);

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:G1');
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'LEDGER');
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true)->setSize(16)->getColor()->setRGB('0000FF');;


		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:G2');
		$objPHPExcel->getActiveSheet()->setCellValue('A2', "From " . $this->input->post('dtFrom') . " To " . $this->input->post('dtTo'));

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:G3');
		$objPHPExcel->getActiveSheet()->setCellValue('A3', 'Party: ' . $this->input->post('party'));

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:G4');

		$objPHPExcel->getActiveSheet()->setCellValue('A5', 'S.N.');
		$objPHPExcel->getActiveSheet()->setCellValue('B5', 'V.No');
		$objPHPExcel->getActiveSheet()->setCellValue('C5', 'Remarks');
		$objPHPExcel->getActiveSheet()->setCellValue('D5', 'Date');
		$objPHPExcel->getActiveSheet()->setCellValue('E5', 'Paid');
		$objPHPExcel->getActiveSheet()->setCellValue('F5', 'Recd.');
		$objPHPExcel->getActiveSheet()->setCellValue('G5', 'Bal.');

		$objPHPExcel->getActiveSheet()->getStyle('E5:G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$cellRange1 = "A" . (5) . ":" . "G" . (5);
	 	$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	 	$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	 	$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getFont()->setBold(true);

		$myTableData = $this->input->post('TableData');
        $myTableData = stripcslashes($myTableData);
        $myTableData = json_decode($myTableData,TRUE);
        $myTableRows = count($myTableData);
        // $myTableRows = strlen($myTableData);
		$r = $myTableRows;
		$productRows = "";
		$i = 6;
		for($k=0; $k < $r-1; $k++)
		{
		    $myCol = 0;
		    $sn = $k + 1;

		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $sn);
		    $myCol = $myCol + 1;
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['vType']);
		    $myCol = $myCol + 1;
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['Rem']);
		    $myCol = $myCol + 1;
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['dt']);
		    $myCol = $myCol + 1;
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['Dr']);
		    $myCol = $myCol + 1;
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['Cr']);
		    $myCol = $myCol + 1;
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($myCol, $i, $myTableData[$k]['Bal']);

		 	$i++;
		}
		// $r=$i-1;
		// $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, 'Total');
		// $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, '=SUM(F8:F'.$r.')');
		// $objPHPExcel->getActiveSheet()->setCellValue('H'.$i, '=SUM(H8:H'.$r.')');
		// $objPHPExcel->getActiveSheet()->setCellValue('J'.$i, '=SUM(J8:J'.$r.')');
		// $objPHPExcel->getActiveSheet()->setCellValue('K'.$i, '=SUM(K8:K'.$r.')');
		// $objPHPExcel->getActiveSheet()->setCellValue('L'.$i, '=SUM(L8:L'.$r.')');

		$cellRange1 = "A" . ($i-1) . ":" . "G" . ($i-1);
	 	$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	 	$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	 	$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getFont()->setBold(true);

	 	$objPHPExcel->getActiveSheet()->setCellValue('A' . ($i-1), ' '); ///Remove S.N. in Total 

		$cellRange2 = "A" . (5) . ":" . "L" . ($i);
	 	$objPHPExcel->getActiveSheet()->getStyle($cellRange2)->getFont()->setSize(10);

	 	$objPHPExcel->getActiveSheet()->setCellValue('D' . ($i+1), 'Difference'); ///Remove S.N. in Total 
	 	$objPHPExcel->getActiveSheet()->setCellValue('E' . ($i+1), $this->input->post('difference')); 
	 	$cellRange1 = "A" . ($i+1) . ":" . "G" . ($i+1);
	 	$objPHPExcel->getActiveSheet()->getStyle($cellRange1)->getFont()->setBold(true);

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(7);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);	
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
		// $objWriter->save('php://output');///to download without ajax call like hyperlink
		// $objWriter->save("excelfiles/$acname$branch.xls");
		$objWriter->save($fileName);
		echo base_url().$fileName;

	}


	public function getSaleDetail()
	{
		// $this->load->model('Quotation_model');
		$data['records'] = $this->Rptledger_model->getSaleDetail();
		$data['recordsSr'] = $this->Rptledger_model->getSaleDetailSr();
		echo json_encode($data);
	}

	public function getPurchaseDetail()
	{
		$data['records'] = $this->Rptledger_model->getPurchaseDetail();
		echo json_encode($data);
	}
}
