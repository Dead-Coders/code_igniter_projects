<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Requirement_Controller extends CI_Controller
{
	public function __construct()
    {
            parent::__construct();
            $this->load->model('Requirement_model');
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
			if($this->Util_model->getRight($this->session->userRowId,'Requirement')==0)
			{
				$this->load->view('includes/header4all');
				$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);
				$this->load->view('ErrorUnauthenticateUser_view');
				$this->load->view('includes/footer');				
				return;
			}
			$data['itemList'] = $this->Requirement_model->getItemList();
			$data['records'] = $this->Requirement_model->getDataLimit();
			$data['errorfound'] = "";
			$this->load->view('includes/header4all');
			$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);

			$this->load->view('Requirement_view', $data);
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
		$this->Requirement_model->insert();
		$data['records'] = $this->Requirement_model->getDataLimit();
		echo json_encode($data);
	}

	// public function update()
	// {
	// 	if($this->Requirement_model->checkDuplicateOnUpdate() == 1)
 //        {
 //        	$data = "Duplicate record...";
 //        	echo json_encode($data);
 //        }
 //        else
 //        {
	// 		$this->Requirement_model->update();
	// 		$data['records'] = $this->Requirement_model->getDataLimit();
	// 		echo json_encode($data);
 //        }
	// }

	public function delete()
	{
		// if($this->Util_model->isDependent('addressbook', 'prefixTypeRowId', $this->input->post('rowId')) == 1)
  //       {
  //       	$data['dependent'] = "yes";
  //       	echo json_encode($data);
  //       }
  //       else
        // {
			$this->Requirement_model->delete();
			$data['records'] = $this->Requirement_model->getDataLimit();
			echo json_encode($data);
		// }
	}

	public function loadAllRecords()
	{
		$data['records'] = $this->Requirement_model->getDataAll();
		echo json_encode($data);
	}

	public function exportData()
	{
		$this->printToPdf('tmp');
	}

	public function printToPdf($arg)
	{


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
					<td colspan="2" align="center" style="font-size: 12pt; font-weight:normal;">Requirement List</td>
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
				$itemRows .= "<td style=\"border: 1px solid grey;font-size:10pt;\">". $sn ."</td>";
				$itemRows .= "<td style=\"border: 1px solid grey;font-size:10pt;\">". $myTableData[$k]['itemName'] ."</td>";
				$itemRows .= "<td style=\"border: 1px solid grey;font-size:10pt;\" align=\"right\">". number_format((float)$myTableData[$k]['lastRate'], 2) ."</td>";
				$itemRows .= "<td style=\"border: 1px solid grey;color:grey;font-size:8pt;\" align=\"left\">". $myTableData[$k]['purchasedFrom'] ."</td>";
				$itemRows .= "<td style=\"border: 1px solid grey;color:grey;font-size:8pt;\" align=\"left\">". $myTableData[$k]['purchaseDate'] ."</td>";
			$itemRows .= "</tr>";
		}

		$html='<table border="1" style="padding: 5px 5px;" width="100%">
					<tr>
						<th style="border: 1px solid grey;background-color:lightgrey;width:10mm;font-size:10pt;">#</th>
						<th style="border: 1px solid grey; background-color:lightgrey;width:75mm;font-size:10pt;">Item</th>
						<th style="border: 1px solid grey; text-align:right; background-color:lightgrey;width:20mm;font-size:10pt;">Last Rate</th>
						<th style="border: 1px solid grey;text-align:left; background-color:lightgrey;width:60mm;font-size:10pt;">From</th>
						<th style="border: 1px solid grey; text-align:left; background-color:lightgrey;width:25mm;font-size:10pt;">Last Dt.</th>
					</tr>'. $itemRows .
			'</table>';
		$pdf->writeHTML($html, true, false, true, false, '');			

		$html='<table border="0" cellpadding="1">
		</table>';
		$pdf->writeHTML($html, true, false, true, false, '');	

		$dt = date("Y_m_d");
		// date_default_timezone_set("Asia/Kolkata");
		$tm = date("H_i_s");
		$partyName = "tmp";///$data['ci'][0]['name'];
		// $pdf->Output($_SERVER['DOCUMENT_ROOT'] . 'sberp/downloads/Q_'. $dt . ' (' . $tm . ') ' . $partyName .'.pdf', 'F');
		$pdf->Output(FCPATH . '/downloads/C_'. $dt . ' (' . $tm . ') ' . $partyName .'.pdf', 'F');
		echo base_url()."/downloads/C_". $dt . " (" . $tm . ") " . $partyName . ".pdf";
	}

	public function getPurchaseLog()
	{
		$data['records'] = $this->Requirement_model->getPurchaseLog();
		echo json_encode($data);
	}


	public function deleteChecked()
	{
		$this->Requirement_model->deleteChecked();
		$data['records'] = $this->Requirement_model->getDataLimit();
		echo json_encode($data);
    }

}
