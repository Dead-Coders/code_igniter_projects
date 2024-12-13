<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quotation_Controller extends CI_Controller
{
	public function __construct()
    {
            parent::__construct();
            $this->load->model('Quotation_model');
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
			if($this->Util_model->getRight($this->session->userRowId,'Quotation')==0)
			{
				$this->load->view('includes/header4all');
				$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);
				$this->load->view('ErrorUnauthenticateUser_view');
				$this->load->view('includes/footer');				
				return;
			}
			$data['customers'] = $this->Quotation_model->getCustomers();
			$data['items'] = $this->Quotation_model->getItems();
			$data['records'] = $this->Quotation_model->getDataLimit();
			$data['errorfound'] = "";
			$this->load->view('includes/header4all');
			$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);

			$this->load->view('Quoatation_view', $data);
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
		$this->Quotation_model->insert();
		$this->printToPdf('Save');
	}


	public function showDetailOnUpdate()
	{
		$data['records'] = $this->Quotation_model->showDetail();
		$data['customerInfo'] = $this->Quotation_model->getCustomerInfo();
		echo json_encode($data);
	}

	public function checkForUpdate()
	{
		if($this->Quotation_model->checkForUpdate() == 1)
        {
        	$data = "cant";
        	echo json_encode($data);
        }
	}
	
	public function update()
	{
		$this->Quotation_model->update();
		$this->printToPdf('Update');
	}

	public function printToPdf($arg)
	{
		$rowId = -10;
		if($arg == "Update")
		{
			$rowId = $this->input->post('globalrowid');
		}
		else if($arg == "Save")
		{
			$rowId = $this->Quotation_model->getDbNo();
		}

		// $data['ci'] = $this->Invoice_model->getCi($rowId);

		$this->load->library('Pdf');
		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetTitle('Estimate');
		// $pdf->SetHeaderMargin(1);
		$pdf->SetPrintHeader(false);
		$pdf->SetTopMargin(15);
		$pdf->setFooterMargin(12);
		$pdf->SetAutoPageBreak(true, 15); //2nd arg is margin from footer
		$pdf->SetAuthor('Suri');
		$pdf->SetDisplayMode('real', 'default');
		$pdf->AddPage();

		$pdf->SetFont('', '', 11, '', true); 
		$data['org'] = $this->Util_model->getOrg();
		$orgName = $data['org'][0]['orgName'];
		$orgAddress1 = $data['org'][0]['add1'];
		$orgAddress2 = $data['org'][0]['add2'];
		$orgAddress3 = $data['org'][0]['add3'];
		$orgAddress4 = $data['org'][0]['add4'];

		
		$customerName= $this->input->post('customerName');
		$customerAddress= $this->input->post('address');
		$html='<table border="0" style="padding: 1px 5px;">
					<tr>
						<td align="left" style="border-top: 1px solid grey;border-left: 1px solid grey;border-right: 1px solid grey; width:190mm;font-size: 24pt; font-weight:bold; font-family: tahoma;padding-top:10px;">'. $orgName .'</td>
					</tr>
					<tr>
						<td align="left" style="border-left: 1px solid grey;border-right: 1px solid grey;width:190mm;font-size: 12pt; font-weight:normal;height:5mm;color:grey;">'. $orgAddress1 .'</td>
					</tr>
					<tr>
						<td align="left" style="border-left: 1px solid grey;border-right: 1px solid grey;width:190mm;font-size: 11pt; font-weight:normal;color:grey;">'. $orgAddress2 .'</td>
					</tr>
					<tr>
						<td height="20px" align="left" style="border-bottom: 1px solid grey;border-left: 1px solid grey;border-right: 1px solid grey;width:190mm;font-size: 11pt; font-weight:normal;padding:10px;color:grey;">'. $orgAddress3 .'</td>
					</tr>
			</table>';
		$pdf->writeHTML($html, true, false, true, false, '');	

		$html='<table border="0" style="padding: 1px 5px;">
				<tr>
					<td colspan="2" align="center" style="font-size: 12pt; font-weight:normal;">Estimate</td>
				</tr>
			</table>';
		$pdf->writeHTML($html, true, false, true, false, '');

		$html='<table border="0" style="padding: 1px 1px;">
					<tr>
						<td align="left" style="font-size: 10pt; font-weight:normal;">Date: '.$this->input->post('dt').'</td>
						<td align="right" style="font-size: 10pt; font-weight:normal;">No.: '. str_pad($rowId, 5, '0', STR_PAD_LEFT) . '</td>
					</tr>
				</table>';
		$pdf->writeHTML($html, true, false, true, false, '');

		$html='<table border="0" style="padding: 1px 5px;">
					<tr>
						<td align="left" style="color:Black;font-size: 12pt; font-weight:normal;width:37mm;">Customer Name:</td>
						<td align="left" style="color:Black;font-size: 12pt; font-weight:normal;width:153mm;">'.$customerName.'</td>
					</tr>
					<tr>
						<td align="left" style="color:grey;font-size: 12pt; font-weight:normal;width:37mm;">Address:</td>
						<td colspan="2" align="left" style="color:grey;font-size: 12pt; font-weight:normal;width:153mm;">'.$customerAddress.'</td>
					</tr>
				</table>';
		$pdf->writeHTML($html, true, false, true, false, '');	

		//////////// Items table
		$myTableData = $this->input->post('TableDataItems');
        $myTableData = stripcslashes($myTableData);
        $myTableData = json_decode($myTableData,TRUE);
        $myTableRows = count($myTableData);
		$r = $myTableRows;
		$itemRows = "";
		$k=0;

			for($k=0; $k < $r; $k++)
			{
				$sn=$k+1;
				$itemRows .= "<tr>";
					$itemRows .= "<td style=\"border: 1px solid grey;\">". $sn ."</td>";
					$itemRows .= "<td style=\"border: 1px solid grey;\">". $myTableData[$k]['itemName'] ."</td>";
					$itemRows .= "<td style=\"border: 1px solid grey;\" align=\"right\">". number_format((float)$myTableData[$k]['qty'], 2) ."</td>";
					$itemRows .= "<td style=\"border: 1px solid grey;\" align=\"right\">". number_format((float)$myTableData[$k]['rate'], 2) ."</td>";
					$itemRows .= "<td style=\"border: 1px solid grey;\" align=\"right\">". number_format((float)$myTableData[$k]['amt'], 2) ."</td>";
				$itemRows .= "</tr>";
			}

			$html='<table border="1" style="padding: 5px 5px;" width="100%">
						<tr>
							<th style="border: 1px solid grey;background-color:lightgrey;width:10mm;">#</th>
							<th style="border: 1px solid grey; background-color:lightgrey;width:105mm;">Description</th>
							<th style="border: 1px solid grey; text-align:right; background-color:lightgrey;width:25mm;">Qty.</th>
							<th style="border: 1px solid grey;text-align:right; background-color:lightgrey;width:25mm;">Rate</th>
							<th style="border: 1px solid grey; text-align:right; background-color:lightgrey;width:25mm;">Amt.</th>
						</tr>'. $itemRows .
				'</table>';
			$pdf->writeHTML($html, true, false, true, false, '');			

		$col1="";
		$col2="";
		$col3="";

		$col2 .= 'Total Amt:';	
		$col3 .= number_format($this->input->post('totalAmt'),2) ;	

		$col1 .= '[ '. $this->input->post('inWords') .' ]'. '<br>';
		$html='<table border="0" cellpadding="5">
					<tr>
						<td style="width:110mm; color:black; text-align:left;">'. $col1 .'</td>
						<td style="width:60mm; color:black; text-align:right;">'. $col2 .'</td>
						<td style="width:20mm; color:black; text-align:right;">'. $col3 .'</td>
					</tr>
			</table>';
		$pdf->writeHTML($html, true, false, true, false, '');	


		$dt = date("Y_m_d");
		// date_default_timezone_set("Asia/Kolkata");
		$tm = date("H_i_s");
		$partyName = $customerName;
		// $pdf->Output($_SERVER['DOCUMENT_ROOT'] . 'sberp/downloads/Q_'. $dt . ' (' . $tm . ') ' . $partyName .'.pdf', 'F');
		$pdf->Output(FCPATH . '/downloads/E_'. $dt . ' (' . $tm . ') ' . $partyName .'.pdf', 'F');
		echo base_url()."/downloads/E_". $dt . " (" . $tm . ") " . $partyName . ".pdf";
	}

	public function delete()
	{
		if($this->Quotation_model->checkPossibility() == 1)
        {
        	$data = "yes";
        	echo json_encode($data);
        }
        else
        {
			$this->Quotation_model->delete();
			$data['records'] = $this->Quotation_model->getDataLimit();
			echo json_encode($data);
		}
	}

	public function loadAllRecords()
	{
		$data['records'] = $this->Quotation_model->getDataAll();
		echo json_encode($data);
	}

}
