<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_Controller extends CI_Controller
{
	public function __construct()
    {
            parent::__construct();
            $this->load->model('Purchase_model');
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
			if($this->Util_model->getRight($this->session->userRowId,'Purchase')==0)
			{
				$this->load->view('includes/header4all');
				$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);
				$this->load->view('ErrorUnauthenticateUser_view');
				$this->load->view('includes/footer');				
				return;
			}
			$data['customers'] = $this->Util_model->getCustomerWithBalance();
			// $data['customers'] = $this->Purchase_model->getCustomers();
			$data['items'] = $this->Purchase_model->getItems();
			$data['records'] = $this->Purchase_model->getDataLimit();
			$data['errorfound'] = "";
			$this->load->view('includes/header4all');
			$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);

			$this->load->view('Purchase_view', $data);
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
		$this->Purchase_model->insert();
		$data['records'] = $this->Purchase_model->getDataLimit();
		echo json_encode($data);
	}

	public function showDetailOnUpdate()
	{
		$data['records'] = $this->Purchase_model->showDetail();
		$data['customerInfo'] = $this->Purchase_model->getCustomerInfo();
		echo json_encode($data);
	}

	public function checkForUpdate()
	{
		if($this->Purchase_model->checkForUpdate() == 1)
        {
        	$data = "cant";
        	echo json_encode($data);
        }
	}
	
	public function update()
	{
		$this->Purchase_model->update();
		$data['records'] = $this->Purchase_model->getDataLimit();
		echo json_encode($data);
	}


	public function delete()
	{
		if($this->Purchase_model->checkPossibility() == 1)
        {
        	$data = "yes";
        	echo json_encode($data);
        }
        else
        {
			$this->Purchase_model->delete();
			$data['records'] = $this->Purchase_model->getDataLimit();
			echo json_encode($data);
		}
	}

	public function loadAllRecords()
	{
		$data['records'] = $this->Purchase_model->getDataAll();
		echo json_encode($data);
	}

	public function searchRecords()
	{
		$data['records'] = $this->Purchase_model->searchRecords();
		echo json_encode($data);
	}

	public function getPurchaseDetial()
	{
		$data['purchaseDetail'] = $this->Purchase_model->getPurchaseDetail();
		echo json_encode($data);
	}

	public function getPurchaseLog()
	{
		$data['records'] = $this->Purchase_model->getPurchaseLog();
		echo json_encode($data);
	}


	public function printNow($arg)
	{
		$data['records'] = $this->Purchase_model->getDataLimit();
		$rowId = -10;
		if($arg == "Update")
		{
			$rowId = $this->input->post('globalrowid');
		}
		else if($arg == "Save")
		{
			$rowId = $this->Purchase_model->getDbNo();
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


		$html .= "<p align='center' id='billOfSupply'>Purchase Voucher</p>";
		
		$data['custInfo'] = $this->Purchase_model->getCustInfo2($rowId);
		$html .= '<table id="tblCustInfo" border=0>
					<tr>
						<td class="tdFirstColOfTblCustInfo" align="left">Name: <span id="custName">'.$data['custInfo'][0]['customerName'].'</span></td>
						<td class="tdSecondColOfTblCustInfo" align="right">Date: '. date('d-M-Y', strtotime($data['custInfo'][0]['purchaseDt'] )).'</td>
					</tr>
					<tr>
						<td id="tdCustAddress" class="tdFirstColOfTblCustInfo" align="left">Address: '.$data['custInfo'][0]['address'].'</td>
						<td class="tdSecondColOfTblCustInfo" align="right">No.: '. str_pad($rowId, 5, '0', STR_PAD_LEFT) . '</td>
					</tr>
				</table>';

		//////////// Items table
		$data['products'] = $this->Purchase_model->getProducts($rowId);
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

		$col3 = $data['products'][0]['grandTotal'];
		// $col3 = "";

		// $col1 = '[ '. $this->numberTowords($col3) .' ]'. '<br>';
		$col1 = '[  ]'. '<br>';
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

		


		$html .= '</td></tr></tbody>
				  <tfoot><tr><td>
				    <div class="footer-space">&nbsp;</div>
				  </td></tr></tfoot>
				</table>';

		$data['html'] = $html;



		echo json_encode($data);
	}	
}
