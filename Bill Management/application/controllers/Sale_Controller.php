<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sale_Controller extends CI_Controller
{
	public function __construct()
    {
            parent::__construct();
            $this->load->model('Sale_model');
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
			if($this->Util_model->getRight($this->session->userRowId,'Sale')==0)
			{
				$this->load->view('includes/header4all');
				$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);
				$this->load->view('ErrorUnauthenticateUser_view');
				$this->load->view('includes/footer');				
				return;
			}
			// $data['customers'] = $this->Sale_model->getCustomers();
			$data['customers'] = $this->Util_model->getCustomerWithBalance();
			
			$data['items'] = $this->Sale_model->getItems();
			$data['records'] = $this->Sale_model->getDataLimit();
			$data['errorfound'] = "";
			$this->load->view('includes/header4all');
			$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);

			$this->load->view('Sale_view', $data);
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
		$this->Sale_model->insert();
		// $this->printToPdf('Save');
		$this->printNow('Save');
	}
	
	public function getLastPurchasePrice()
	{
		$data['lastPurchasePrice'] = $this->Sale_model->getLastPurchasePrice();
		echo json_encode($data);
	}

	public function showDetailOnUpdate()
	{
		$data['records'] = $this->Sale_model->showDetail();
		$data['customerInfo'] = $this->Sale_model->getCustomerInfo();
		echo json_encode($data);
	}

	public function checkForUpdate()
	{
		if($this->Sale_model->checkForUpdate() == 1)
        {
        	$data = "cant";
        	echo json_encode($data);
        }
	}
	
	public function update()
	{
		$this->Sale_model->update();
		// $this->printToPdf('Update');
		$this->printNow('Update');
	}

	public function printNow($arg)
	{
		$data['records'] = $this->Sale_model->getDataLimit();
		$rowId = -10;
		if($arg == "Update")
		{
			$rowId = $this->input->post('globalrowid');
		}
		else if($arg == "Save")
		{
			$rowId = $this->Sale_model->getDbNo();
		}
		else
		{
			$rowId = $this->input->post('globalrowid');
		}

		$data['org'] = $this->Util_model->getOrg();
		$orgName = $data['org'][0]['orgName'];
		$orgAddress1 = $data['org'][0]['add1'];
		$orgAddress2 = $data['org'][0]['add2'];
		$orgAddress3 = $data['org'][0]['add3'];
		$orgAddress4 = $data['org'][0]['add4'];

		$html='<table border="0" id="tblMain"><thead><tr><td>
				    <div class="header-space">&nbsp;</div>
				  </td></tr></thead><tbody><tr><td>';
		
		$html .='<table border="0" id="tblHeader">
					<tr>
						<td id="orgName">'. $orgName .'</td>
					</tr>
					<tr>
						<td class="normal">'. $orgAddress1 .'</td>
					</tr>
					<tr>
						<td class="normal">'. $orgAddress2 .'</td>
					</tr>
					<tr>
						<td class="normal">'. $orgAddress3 .'</td>
					</tr>
			</table>';


		$html .= "<p align='center' id='billOfSupply'>Bill of Supply</p>";
		
		$data['custInfo'] = $this->Sale_model->getCustInfo($rowId);
		$html .= '<table id="tblCustInfo" border=0>
					<tr>
						<td class="tdFirstColOfTblCustInfo" align="left">Name: <span id="custName">'.$data['custInfo'][0]['customerName'].'</span></td>
						<td class="tdSecondColOfTblCustInfo" align="right">Date: '. date('d-M-Y', strtotime($data['custInfo'][0]['dbDt'] )).'</td>
					</tr>
					<tr>
						<td id="tdCustAddress" class="tdFirstColOfTblCustInfo" align="left">Address: '.$data['custInfo'][0]['address'].'</td>
						<td class="tdSecondColOfTblCustInfo" align="right">No.: '. str_pad($rowId, 5, '0', STR_PAD_LEFT) . '</td>
					</tr>
				</table>';

		//////////// Items table
		$data['products'] = $this->Sale_model->getProducts($rowId);
		$sn=1;
		$itemRows ="";
		foreach ($data['products'] as $row) {
			if ( $row['itemRemarks'] != "" )
			{
				$itemName = $row['itemName'] . " [" . ($row['itemRemarks'])  . "]";
			}
			else
			{
				$itemName = $row['itemName'];
			}
			$itemRows .= "<tr>";
				$itemRows .= "<td class='clsProductsSn'>". $sn++ ."</td>";
				$itemRows .= "<td class='clsProductsDescription'>". $itemName . "</td>";
				$itemRows .= "<td class='clsProductsQty'>". number_format((float)$row['qty'], 2) ."</td>";
				$itemRows .= "<td class='clsProductsRate'>". number_format((float)$row['rate'], 2) ."</td>";
				$itemRows .= "<td class='clsProductsAmt'>". number_format((float)$row['netAmt'], 2) ."</td>";
			$itemRows .= "</tr>";
		}

		$html .= '<table id="tblProducts">
					<tr>
						<th id="thSn" class="clsProductsSn">#</th>
						<th id="thDescription" class="clsProductsDescription">Description</th>
						<th id="thQty" class="clsProductsQty">Qty.</th>
						<th id="thRate" class="clsProductsRate">Rate</th>
						<th id="thAmt" class="clsProductsAmt">Amt.</th>
					</tr>'. $itemRows .
			'</table>';

		$html .= '<p>.......</p>';

		// if($sn == 18)
		// {
		// 	$html .= '<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>';
		// }
		// else if($sn == 19 || $sn == 20)
		// {
		// 	$html .= '<p>&nbsp;</p><p>&nbsp;</p>';
		// }

		$col3 = $data['products'][0]['grandTotal'];

		$col1 = '[ '. $this->numberTowords($col3) .' ]'. '<br>';
		$col2 = "Net Amt.:";
		$html .= '<table border="0" id="tblNetAmt">
					<tr>
						<td class="tdTblNetAmtOne">'. $col1 .'</td>
						<td id="tdTblNetAmtTwo" class="normal">'. $col2 .'</td>
						<td id="tdTblNetAmtThree">'. $col3 .'</td>
					</tr>
					<tr>
						<td class="tdTblNetAmtOne">Not eligible to collect tax on supplies (sale under 20 lakhs).</td>
						<td class="normal"></td>
						<td class="normal"></td>
					</tr>
			</table>';

		$col1 = "";
		$col1 .= "Terms & Conditions:" . '<br>';
		$col1 .="<ol id='termsList'><li>The discrepancy if any in the bill should be brought to our notice within a week from the date here of.</li><li>All disputes will have to be settled at Ajmer.</li><li>Goods supplied will not be refunded.</li><li>Service within warranty period will be provided by manufacturer.</li><li>E. & O.E.</li>";
		

		$col2 = "";
		$col2 .= "For: " . $orgName . '<br>' . '<br>' . '<br>' . '<br>';
		$col2 .= "Authorised Signatory";
		$html .= '<table border="0" id="tblTerms">
			<tr>
				<td id="tdTblTermsOne">'. $col1 .'</td>
				<td id="tdTblTermsTwo">'. $col2 .'</td>
			</tr>
		</table>';

		$html .= '<table id="tblBank">
					<tr>
						<td id="tdTblBankOne">Bank Name: Apogee Banks., Tipton, Current Ac.No.: CA100450001010, IFSC: QEFB0016921</td>
					</tr>
			</table>';


		$html .= '</td></tr></tbody>
				  <tfoot><tr><td>
				    <div class="footer-space">&nbsp;</div>
				  </td></tr></tfoot>
				</table>';

		$data['html'] = $html;



		echo json_encode($data);
	}	


	// public function printToPdf($arg)
	// {
	// 	$rowId = -10;
	// 	if($arg == "Update")
	// 	{
	// 		$rowId = $this->input->post('globalrowid');
	// 	}
	// 	else if($arg == "Save")
	// 	{
	// 		$rowId = $this->Sale_model->getDbNo();
	// 	}

	// 	// $data['ci'] = $this->Invoice_model->getCi($rowId);

	// 	$this->load->library('Pdf');
	// 	$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
	// 	$pdf->SetTitle('Invoice');
	// 	// $pdf->SetHeaderMargin(1);
	// 	$pdf->SetPrintHeader(false);
	// 	$pdf->SetTopMargin(15);
	// 	$pdf->setFooterMargin(12);
	// 	$pdf->SetAutoPageBreak(true, 15); //2nd arg is margin from footer
	// 	$pdf->SetAuthor('Suri');
	// 	$pdf->SetDisplayMode('real', 'default');
	// 	$pdf->AddPage();

	// 	$pdf->SetFont('', '', 11, '', true); 
	// 	$data['org'] = $this->Util_model->getOrg();
	// 	$orgName = $data['org'][0]['orgName'];
	// 	$orgAddress1 = $data['org'][0]['add1'];
	// 	$orgAddress2 = $data['org'][0]['add2'];
	// 	$orgAddress3 = $data['org'][0]['add3'];
	// 	$orgAddress4 = $data['org'][0]['add4'];

		
	// 	$customerName= $this->input->post('customerName');
	// 	$customerAddress= $this->input->post('address');
	// 	$html='<table border="0" style="padding: 1px 5px;">
	// 				<tr>
	// 					<td align="left" style="border-top: 1px solid grey;border-left: 1px solid grey;border-right: 1px solid grey; width:190mm;font-size: 24pt; font-weight:bold; font-family: tahoma;padding-top:10px;">'. $orgName .'</td>
	// 				</tr>
	// 				<tr>
	// 					<td align="left" style="border-left: 1px solid grey;border-right: 1px solid grey;width:190mm;font-size: 12pt; font-weight:normal;height:5mm;color:grey;">'. $orgAddress1 .'</td>
	// 				</tr>
	// 				<tr>
	// 					<td align="left" style="border-left: 1px solid grey;border-right: 1px solid grey;width:190mm;font-size: 11pt; font-weight:normal;color:grey;">'. $orgAddress2 .'</td>
	// 				</tr>
	// 				<tr>
	// 					<td height="20px" align="left" style="border-bottom: 1px solid grey;border-left: 1px solid grey;border-right: 1px solid grey;width:190mm;font-size: 11pt; font-weight:normal;padding:10px;color:grey;">'. $orgAddress3 .'</td>
	// 				</tr>
	// 		</table>';
	// 	$pdf->writeHTML($html, true, false, true, false, '');	

	// 	$html='<table border="0" style="padding: 1px 5px;">
	// 			<tr>
	// 				<td colspan="2" align="center" style="font-size: 12pt; font-weight:normal;">Bill of Supply</td>
	// 			</tr>
	// 		</table>';
	// 	$pdf->writeHTML($html, true, false, true, false, '');

	// 	$html='<table border="0" style="padding: 1px 1px;">
	// 				<tr>
	// 					<td align="left" style="font-size: 10pt; font-weight:normal;">Date: '.$this->input->post('dt').'</td>
	// 					<td align="right" style="font-size: 10pt; font-weight:normal;">No.: '. str_pad($rowId, 5, '0', STR_PAD_LEFT) . '</td>
	// 				</tr>
	// 			</table>';
	// 	$pdf->writeHTML($html, true, false, true, false, '');

	// 	$html='<table border="0" style="padding: 1px 5px;">
	// 				<tr>
	// 					<td align="left" style="color:Black;font-size: 12pt; font-weight:normal;width:37mm;">Customer Name:</td>
	// 					<td align="left" style="color:Black;font-size: 12pt; font-weight:normal;width:153mm;">'.$customerName.'</td>
	// 				</tr>
	// 				<tr>
	// 					<td align="left" style="color:grey;font-size: 12pt; font-weight:normal;width:37mm;">Address:</td>
	// 					<td colspan="2" align="left" style="color:grey;font-size: 12pt; font-weight:normal;width:153mm;">'.$customerAddress.'</td>
	// 				</tr>
	// 			</table>';
	// 	$pdf->writeHTML($html, true, false, true, false, '');	

	// 	//////////// Items table
	// 	$myTableData = $this->input->post('TableDataItems');
 //        $myTableData = stripcslashes($myTableData);
 //        $myTableData = json_decode($myTableData,TRUE);
 //        $myTableRows = count($myTableData);
	// 	$r = $myTableRows;
	// 	$itemRows = "";
	// 	$k=0;

	// 	$discountHaiKya = (float)$this->input->post('totalDiscount');
	// 	$igstHaiKya = (float)$this->input->post('totalIgst');
	// 	$cgstHaiKya = (float)$this->input->post('totalCgst');
	// 	$sgstHaiKya = (float)$this->input->post('totalSgst');
	// 	if( $discountHaiKya == 0 && $igstHaiKya == 0 && $cgstHaiKya == 0 && $sgstHaiKya == 0  )
	// 	{
	// 		for($k=0; $k < $r; $k++)
	// 		{
	// 			if ( $myTableData[$k]['itemRemarks'] != "" )
	// 			{
	// 				$itemName = $myTableData[$k]['itemName'] . " [" . ($myTableData[$k]['itemRemarks'])  . "]";
	// 			}
	// 			else
	// 			{
	// 				$itemName = $myTableData[$k]['itemName'];
	// 			}
	// 			if($myTableData[$k]['qty'] >0 )
	// 			{
	// 				$sn=$k+1;
	// 				$itemRows .= "<tr>";
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\">". $sn ."</td>";
	// 					// if ( $myTableData[$k]['itemRemarks'] !=  )
	// 					// {
	// 						$itemRows .= "<td style=\"border: 1px solid grey;\">". $itemName . "</td>";
	// 					// }
	// 					// else
	// 					{
	// 						// $itemRows .= "<td style=\"border: 1px solid grey;\">". $myTableData[$k]['itemName'];
	// 					}
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\" align=\"right\">". number_format((float)$myTableData[$k]['qty'], 2) ."</td>";
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\" align=\"right\">". number_format((float)$myTableData[$k]['rate'], 2) ."</td>";
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\" align=\"right\">". number_format((float)$myTableData[$k]['netAmt'], 2) ."</td>";
	// 				$itemRows .= "</tr>";
	// 			}
	// 		}
	// 		$myTableData = $this->input->post('TableDataServices');
	//         $myTableData = stripcslashes($myTableData);
	//         $myTableData = json_decode($myTableData,TRUE);
	//         // $myTableRows = count($myTableData);
	//         $myTableRows = strlen($myTableData);
	// 		$r = $myTableRows;
	// 		$html='<table border="1" style="padding: 5px 5px;" width="100%">
	// 					<tr>
	// 						<th style="border: 1px solid grey;background-color:lightgrey;width:10mm;">#</th>
	// 						<th style="border: 1px solid grey; background-color:lightgrey;width:105mm;">Description</th>
	// 						<th style="border: 1px solid grey; text-align:right; background-color:lightgrey;width:25mm;">Qty.</th>
	// 						<th style="border: 1px solid grey;text-align:right; background-color:lightgrey;width:25mm;">Rate</th>
	// 						<th style="border: 1px solid grey; text-align:right; background-color:lightgrey;width:25mm;">Amt.</th>
	// 					</tr>'. $itemRows .
	// 			'</table>';
	// 		$pdf->writeHTML($html, true, false, true, false, '');			
	// 	}
	// 	else if( $discountHaiKya > 0 && $igstHaiKya == 0 && $cgstHaiKya == 0 && $sgstHaiKya == 0  )
	// 	{
	// 		for($k=0; $k < $r; $k++)
	// 		{
	// 			if($myTableData[$k]['qty'] >0 )
	// 			{
	// 				$sn=$k+1;
	// 				$itemRows .= "<tr>";
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\">". $sn ."</td>";
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\">". $myTableData[$k]['itemName'] ."</td>";
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\" align=\"right\">". number_format((float)$myTableData[$k]['qty'], 2) ."</td>";
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\" align=\"right\">". number_format((float)$myTableData[$k]['rate'], 2) ."</td>";
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\" align=\"right\">". number_format((float)$myTableData[$k]['discountAmt'], 2) ."</td>";
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\" align=\"right\">". number_format((float)$myTableData[$k]['netAmt'], 2) ."</td>";
	// 				$itemRows .= "</tr>";
	// 			}
	// 		}
	// 		$myTableData = $this->input->post('TableDataServices');
	//         $myTableData = stripcslashes($myTableData);
	//         $myTableData = json_decode($myTableData,TRUE);
	//         $myTableRows = count($myTableData);
	// 		$r = $myTableRows;
	// 		$html='<table border="1" style="padding: 5px 5px;" width="100%">
	// 					<tr>
	// 						<th style="border: 1px solid grey;background-color:lightgrey;width:10mm;">#</th>
	// 						<th style="border: 1px solid grey; background-color:lightgrey;width:80mm;">Description</th>
	// 						<th style="border: 1px solid grey; text-align:right; background-color:lightgrey;width:25mm;">Qty.</th>
	// 						<th style="border: 1px solid grey;text-align:right; background-color:lightgrey;width:25mm;">Rate</th>
	// 						<th style="border: 1px solid grey; text-align:right; background-color:lightgrey;width:25mm;">Dis.</th>
	// 						<th style="border: 1px solid grey; text-align:right; background-color:lightgrey;width:25mm;">Amt.</th>
	// 					</tr>'. $itemRows .
	// 			'</table>';
	// 		$pdf->writeHTML($html, true, false, true, false, '');			
	// 	}
	// 	else if( $discountHaiKya > 0 && $igstHaiKya > 0 && $cgstHaiKya == 0 && $sgstHaiKya == 0  )
	// 	{
	// 		for($k=0; $k < $r; $k++)
	// 		{
	// 			if($myTableData[$k]['qty'] >0 )
	// 			{
	// 				$sn=$k+1;
	// 				$itemRows .= "<tr>";
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\">". $sn ."</td>";
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\">". $myTableData[$k]['itemName'] ."</td>";
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\" align=\"right\">". number_format((float)$myTableData[$k]['qty'], 2) ."</td>";
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\" align=\"right\">". number_format((float)$myTableData[$k]['rate'], 2) ."</td>";
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\" align=\"right\">". number_format((float)$myTableData[$k]['discountAmt'], 2) ."</td>";
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\" align=\"right\">". number_format((float)$myTableData[$k]['igst'], 2) ."</td>";
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\" align=\"right\">". number_format((float)$myTableData[$k]['netAmt'], 2) ."</td>";
	// 				$itemRows .= "</tr>";
	// 			}
	// 		}
	// 		$myTableData = $this->input->post('TableDataServices');
	//         $myTableData = stripcslashes($myTableData);
	//         $myTableData = json_decode($myTableData,TRUE);
	//         $myTableRows = count($myTableData);
	// 		$r = $myTableRows;
	// 		$html='<table border="1" style="padding: 5px 5px;" width="100%">
	// 					<tr>
	// 						<th style="border: 1px solid grey;background-color:lightgrey;width:10mm;">#</th>
	// 						<th style="border: 1px solid grey; background-color:lightgrey;width:80mm;">Description</th>
	// 						<th style="border: 1px solid grey; text-align:right; background-color:lightgrey;width:20mm;">Qty.</th>
	// 						<th style="border: 1px solid grey;text-align:right; background-color:lightgrey;width:20mm;">Rate</th>
	// 						<th style="border: 1px solid grey; text-align:right; background-color:lightgrey;width:20mm;">Dis.</th>
	// 						<th style="border: 1px solid grey; text-align:right; background-color:lightgrey;width:20mm;">IGST</th>
	// 						<th style="border: 1px solid grey; text-align:right; background-color:lightgrey;width:20mm;">Amt.</th>
	// 					</tr>'. $itemRows .
	// 			'</table>';
	// 		$pdf->writeHTML($html, true, false, true, false, '');			
	// 	}
	// 	else if( $discountHaiKya > 0 && $igstHaiKya == 0 && $cgstHaiKya > 0 && $sgstHaiKya > 0  )
	// 	{
	// 		for($k=0; $k < $r; $k++)
	// 		{
	// 			if($myTableData[$k]['qty'] >0 )
	// 			{
	// 				$sn=$k+1;
	// 				$itemRows .= "<tr>";
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\">". $sn ."</td>";
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\">". $myTableData[$k]['itemName'] ."</td>";
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\" align=\"right\">". number_format((float)$myTableData[$k]['qty'], 2) ."</td>";
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\" align=\"right\">". number_format((float)$myTableData[$k]['rate'], 2) ."</td>";
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\" align=\"right\">". number_format((float)$myTableData[$k]['discountAmt'], 2) ."</td>";
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\" align=\"right\">". number_format((float)$myTableData[$k]['cgst'], 2) ."</td>";
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\" align=\"right\">". number_format((float)$myTableData[$k]['sgst'], 2) ."</td>";
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\" align=\"right\">". number_format((float)$myTableData[$k]['netAmt'], 2) ."</td>";
	// 				$itemRows .= "</tr>";
	// 			}
	// 		}
	// 		$myTableData = $this->input->post('TableDataServices');
	//         $myTableData = stripcslashes($myTableData);
	//         $myTableData = json_decode($myTableData,TRUE);
	//         $myTableRows = count($myTableData);
	// 		$r = $myTableRows;
	// 		$html='<table border="1" style="padding: 5px 5px;" width="100%">
	// 					<tr>
	// 						<th style="border: 1px solid grey;background-color:lightgrey;width:10mm;">#</th>
	// 						<th style="border: 1px solid grey; background-color:lightgrey;width:75mm;">Description</th>
	// 						<th style="border: 1px solid grey; text-align:right; background-color:lightgrey;width:15mm;">Qty.</th>
	// 						<th style="border: 1px solid grey;text-align:right; background-color:lightgrey;width:20mm;">Rate</th>
	// 						<th style="border: 1px solid grey; text-align:right; background-color:lightgrey;width:20mm;">Dis.</th>
	// 						<th style="border: 1px solid grey; text-align:right; background-color:lightgrey;width:15mm;">CGST</th>
	// 						<th style="border: 1px solid grey; text-align:right; background-color:lightgrey;width:15mm;">SGST</th>
	// 						<th style="border: 1px solid grey; text-align:right; background-color:lightgrey;width:20mm;">Amt.</th>
	// 					</tr>'. $itemRows .
	// 			'</table>';
	// 		$pdf->writeHTML($html, true, false, true, false, '');			
	// 	}					
	// 	else if( $discountHaiKya == 0 && $igstHaiKya > 0 && $cgstHaiKya == 0 && $sgstHaiKya == 0  )
	// 	{
	// 		for($k=0; $k < $r; $k++)
	// 		{
	// 			if($myTableData[$k]['qty'] >0 )
	// 			{
	// 				$sn=$k+1;
	// 				$itemRows .= "<tr>";
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\">". $sn ."</td>";
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\">". $myTableData[$k]['itemName'] ."</td>";
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\" align=\"right\">". number_format((float)$myTableData[$k]['qty'], 2) ."</td>";
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\" align=\"right\">". number_format((float)$myTableData[$k]['rate'], 2) ."</td>";
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\" align=\"right\">". number_format((float)$myTableData[$k]['igst'], 2) ."</td>";
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\" align=\"right\">". number_format((float)$myTableData[$k]['netAmt'], 2) ."</td>";
	// 				$itemRows .= "</tr>";
	// 			}
	// 		}
	// 		$myTableData = $this->input->post('TableDataServices');
	//         $myTableData = stripcslashes($myTableData);
	//         $myTableData = json_decode($myTableData,TRUE);
	//         $myTableRows = count($myTableData);
	// 		$r = $myTableRows;
	// 		$html='<table border="1" style="padding: 5px 5px;" width="100%">
	// 					<tr>
	// 						<th style="border: 1px solid grey;background-color:lightgrey;width:10mm;">#</th>
	// 						<th style="border: 1px solid grey; background-color:lightgrey;width:100mm;">Description</th>
	// 						<th style="border: 1px solid grey; text-align:right; background-color:lightgrey;width:20mm;">Qty.</th>
	// 						<th style="border: 1px solid grey;text-align:right; background-color:lightgrey;width:20mm;">Rate</th>
	// 						<th style="border: 1px solid grey; text-align:right; background-color:lightgrey;width:20mm;">IGST</th>
	// 						<th style="border: 1px solid grey; text-align:right; background-color:lightgrey;width:20mm;">Amt.</th>
	// 					</tr>'. $itemRows .
	// 			'</table>';
	// 		$pdf->writeHTML($html, true, false, true, false, '');			
	// 	}
	// 	else if( $discountHaiKya == 0 && $igstHaiKya == 0 && $cgstHaiKya > 0 && $sgstHaiKya > 0  )
	// 	{
	// 		for($k=0; $k < $r; $k++)
	// 		{
	// 			if($myTableData[$k]['qty'] >0 )
	// 			{
	// 				$sn=$k+1;
	// 				$itemRows .= "<tr>";
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\">". $sn ."</td>";
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\">". $myTableData[$k]['itemName'] ."</td>";
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\" align=\"right\">". number_format((float)$myTableData[$k]['qty'], 2) ."</td>";
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\" align=\"right\">". number_format((float)$myTableData[$k]['rate'], 2) ."</td>";
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\" align=\"right\">". number_format((float)$myTableData[$k]['cgst'], 2) ."</td>";
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\" align=\"right\">". number_format((float)$myTableData[$k]['sgst'], 2) ."</td>";
	// 					$itemRows .= "<td style=\"border: 1px solid grey;\" align=\"right\">". number_format((float)$myTableData[$k]['netAmt'], 2) ."</td>";
	// 				$itemRows .= "</tr>";
	// 			}
	// 		}
	// 		$myTableData = $this->input->post('TableDataServices');
	//         $myTableData = stripcslashes($myTableData);
	//         $myTableData = json_decode($myTableData,TRUE);
	//         $myTableRows = count($myTableData);
	// 		$r = $myTableRows;
	// 		$html='<table border="1" style="padding: 5px 5px;" width="100%">
	// 					<tr>
	// 						<th style="border: 1px solid grey;background-color:lightgrey;width:10mm;">#</th>
	// 						<th style="border: 1px solid grey; background-color:lightgrey;width:80mm;">Description</th>
	// 						<th style="border: 1px solid grey; text-align:right; background-color:lightgrey;width:20mm;">Qty.</th>
	// 						<th style="border: 1px solid grey;text-align:right; background-color:lightgrey;width:20mm;">Rate</th>
	// 						<th style="border: 1px solid grey; text-align:right; background-color:lightgrey;width:20mm;">CGST</th>
	// 						<th style="border: 1px solid grey; text-align:right; background-color:lightgrey;width:20mm;">SGST</th>
	// 						<th style="border: 1px solid grey; text-align:right; background-color:lightgrey;width:20mm;">Amt.</th>
	// 					</tr>'. $itemRows .
	// 			'</table>';
	// 		$pdf->writeHTML($html, true, false, true, false, '');			
	// 	}		


	// 	$col1="";
	// 	$col2="";
	// 	$col3="";

	// 	$col2 .= 'Net Amt.:';	
	// 	$col3 .= number_format($this->input->post('netAmt'),2) ;	

	// 	// $col1 .= "Terms & Conditions:" . '<br>';
	// 	// $col1 .= "1. Goods once sold will not be back." . '<br>';
	// 	// $col1 .= "2. Subject to Ajmer jurisdiction." . '<br>';
	// 	// $col1 .= "3. E. & O.E." ;
	// 	$col1 .= '[ '. $this->input->post('inWords') .' ]'. '<br>';
	// 	$col1 .= "Not eligible to collect tax on supplies (sale under 20 lakhs).";
	// 	$html='<table border="0" cellpadding="5">
	// 				<tr>
	// 					<td style="width:110mm; color:black; text-align:left;">'. $col1 .'</td>
	// 					<td style="width:60mm; color:black; text-align:right;">'. $col2 .'</td>
	// 					<td style="width:20mm; color:black; text-align:right;">'. $col3 .'</td>
	// 				</tr>
	// 		</table>';
	// 	$pdf->writeHTML($html, true, false, true, false, '');	



	// 	$col1 = "";
	// 	$col1 .= "Terms & Conditions:" . '<br>';
	// 	$col1 .= "1. The discrepancy if any in the bill should be brought to our notice within a week from the date here of." . '<br>';
	// 	$col1 .= "2. All disputes will have to be settled at Ajmer." . '<br>';
	// 	$col1 .= "3. Goods supplied will not be refunded." . '<br>';
	// 	$col1 .= "4. Service within warranty period will be provided by manufacturer." . '<br>';
	// 	$col1 .= "5. E. & O.E." ;

	// 	$col2 = "";
	// 	$col2 .= "For: " . $orgName . '<br>' . '<br>' . '<br>' . '<br>';
	// 	$col2 .= "Authorised Signatory";
	// 	$html='<table border="0" cellpadding="5">
	// 		<tr>
	// 			<td style="width:120mm; color:black; text-align:left;font-size:7pt;">'. $col1 .'</td>
	// 			<td style="width:70mm; color:black; text-align:right;">'. $col2 .'</td>
	// 		</tr>
	// 	</table>';
	// 	$pdf->writeHTML($html, true, false, true, false, '');	
		
	// 	$html='<table border="1" cellpadding="5">
	// 				<tr>
	// 					<td style="width:190mm; color:grey; text-align:center;font-size:9pt;">Bank Name: Ajmer Central Cooperative Bank, Khailand-Ajmer, Current Ac.No.: 11002401110000987, IFSC: RSCB0011002</td>
	// 				</tr>
	// 		</table>';
	// 	$pdf->writeHTML($html, true, false, true, false, '');	

	// 	$dt = date("Y_m_d");
	// 	// date_default_timezone_set("Asia/Kolkata");
	// 	$tm = date("H_i_s");
	// 	$partyName = $customerName; //$data['ci'][0]['name'];
	// 	// $pdf->Output($_SERVER['DOCUMENT_ROOT'] . 'sberp/downloads/Q_'. $dt . ' (' . $tm . ') ' . $partyName .'.pdf', 'F');
	// 	$pdf->Output(FCPATH . '/downloads/INV_'. $dt . ' (' . $tm . ') ' . $partyName .'.pdf', 'F');
	// 	echo base_url()."/downloads/INV_". $dt . " (" . $tm . ") " . $partyName . ".pdf";
	// }

	public function delete()
	{
		if($this->Sale_model->checkPossibility() == 1)
        {
        	$data = "yes";
        	echo json_encode($data);
        }
        else
        {
			$this->Sale_model->delete();
			$data['records'] = $this->Sale_model->getDataLimit();
			echo json_encode($data);
		}
	}

	public function loadAllRecords()
	{
		$data['records'] = $this->Sale_model->getDataAll();
		echo json_encode($data);
	}

	public function searchRecords()
	{
		$data['records'] = $this->Sale_model->searchRecords();
		echo json_encode($data);
	}


	public function getQuotations()
	{
		$this->load->model('Quotation_model');
		$data['records'] = $this->Quotation_model->getDataLimit();
		echo json_encode($data);
	}
	public function getAllQuotations()
	{
		$this->load->model('Quotation_model');
		$data['records'] = $this->Quotation_model->getDataAll();
		echo json_encode($data);
	}
	public function getQuotationProducts()
	{
		$data['records'] = $this->Sale_model->getQuotationProducts();
		echo json_encode($data);
	}
	public function getSaleDetial()
	{
		$data['saleDetail'] = $this->Sale_model->getSaleDetail();
		echo json_encode($data);
	}


	function numberTowords($number)
	{
		$no = round($number);
	    $decimal = round($number - ($no = floor($number)), 2) * 100;    
	    $digits_length = strlen($no);    
	    $i = 0;
	    $str = array();
	    $words = array(
	        0 => '',
	        1 => 'One',
	        2 => 'Two',
	        3 => 'Three',
	        4 => 'Four',
	        5 => 'Five',
	        6 => 'Six',
	        7 => 'Seven',
	        8 => 'Eight',
	        9 => 'Nine',
	        10 => 'Ten',
	        11 => 'Eleven',
	        12 => 'Twelve',
	        13 => 'Thirteen',
	        14 => 'Fourteen',
	        15 => 'Fifteen',
	        16 => 'Sixteen',
	        17 => 'Seventeen',
	        18 => 'Eighteen',
	        19 => 'Nineteen',
	        20 => 'Twenty',
	        30 => 'Thirty',
	        40 => 'Forty',
	        50 => 'Fifty',
	        60 => 'Sixty',
	        70 => 'Seventy',
	        80 => 'Eighty',
	        90 => 'Ninety');
	    $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
	    while ($i < $digits_length) {
	        $divider = ($i == 2) ? 10 : 100;
	        $number = floor($no % $divider);
	        $no = floor($no / $divider);
	        $i += $divider == 10 ? 1 : 2;
	        if ($number) {
	            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;            
	            $str [] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural;
	        } else {
	            $str [] = null;
	        }  
	    }
	    
	    $Rupees = implode(' ', array_reverse($str));
	    $paise = ($decimal) ? "And Paise " . ($words[$decimal - $decimal%10]) ." " .($words[$decimal%10])  : '';
	    return ($Rupees ? 'Rupees ' . $Rupees : '') . $paise . " Only";
	}
}
