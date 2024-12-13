<?php
class Purchase_model extends CI_Model 
{
    public $globalDbNo = 0;
    public function __construct()
    {
            $this->load->database('');
    }

    public function getCustomers()
    {
        $this->db->select('customers.*');
        $this->db->where('deleted', 'N');
        $this->db->order_by('customerName');
        $query = $this->db->get('customers');

        return($query->result_array());
    }   
    public function getCustomerInfo()
    {
        $this->db->select('customers.*');
        $this->db->where('customerRowId', $this->input->post('customerRowId'));
        $query = $this->db->get('customers');

        return($query->result_array());
    } 

    public function getCustInfo2($invNo)
    {
        $this->db->select('purchase.customerRowId, purchase.purchaseDt, customers.customerName, customers.address');
        $this->db->from('purchase');
        $this->db->where('purchase.purchaseRowId', $invNo);
        $this->db->join('customers','customers.customerRowId = purchase.customerRowId');
        $query = $this->db->get();

        return($query->result_array());
    }  

    public function getItems()
	{
		// $this->db->select('itemRowId, itemName');
		// $this->db->where('deleted', 'N');
		// $this->db->order_by('itemName');
		// $query = $this->db->get('items');

		// return($query->result_array());

        $q = 'SELECT items.itemRowId, items.itemName,purchaseDetailRowId, rate,igst,cgst,sgst,sellingPricePer,sp,discountPer
                FROM items
                LEFT Join
                (SELECT S.purchaseDetailRowId, S.itemRowId, S.rate,S.igst,S.cgst,S.sgst,sellingPricePer,sp,discountPer
                FROM purchasedetail AS S
                Inner Join
                (SELECT Max(S2.purchaseDetailRowId) AS MaxOfStatusID, S2.itemRowId
                FROM purchasedetail AS S2
                GROUP BY S2.itemRowId) As S3
                ON S.itemRowId=S3.itemRowId And  S.purchaseDetailRowId= S3.MaxOfStatusID) As S4
                On items.itemRowId=S4.itemRowId  WHERE items.deleted="N" ORDER BY items.itemName';

        // $q = "Select items.itemRowId, items.itemName,purchaseDetailRowId, rate, max(purchasedetail.purchaseDetailRowId) as dt  from items LEFT JOIN purchasedetail ON items.itemRowId=purchasedetail.itemRowId where items.deleted='N' GROUP BY items.itemRowId, items.itemName order by itemName";


        $query = $this->db->query($q);
        return($query->result_array());
	}	

    public function getDbNo()
    {
        return $this->globalDbNo;
    }
 
	public function insert()
    {
		set_time_limit(0);
        $this->db->trans_start();
        $customerRowId = $this->input->post('customerRowId');
        if( $customerRowId == -1 ) ///new customer
        {
			$this->db->select_max('customerRowId');
			$query = $this->db->get('customers');
	        $row = $query->row_array();

	        $customerRowId = $row['customerRowId']+1;
			$data = array(
		        'customerRowId' => $customerRowId
		        , 'customerName' => ucwords($this->input->post('customerName'))
		        , 'address' => $this->input->post('address')
		        , 'mobile1' => $this->input->post('mobile1')
		        , 'remarks' => $this->input->post('customerRemarks')
		        , 'createdBy' => $this->session->userRowId
			);
			$this->db->set('createdStamp', 'NOW()', FALSE);
			$this->db->insert('customers', $data);	
        }
        

        ///Inserting in PV table
        $this->db->select_max('purchaseRowId');
        $query = $this->db->get('purchase');
        $row = $query->row_array();

        $purchaseRowId = $row['purchaseRowId']+1;
        $this->globalDbNo = $purchaseRowId;

        $dt = date('Y-m-d', strtotime($this->input->post('dt')));
        if($this->input->post('dueDate') == '')
        {
            $dueDate = null;
        }
        else
        {
            $dueDate = date('Y-m-d', strtotime($this->input->post('dueDate')));
        }
        $data = array(
            'purchaseRowId' => $purchaseRowId
            , 'purchaseDt' => $dt
            , 'customerRowId' => $customerRowId
            , 'totalAmount' => (float)$this->input->post('totalAmt')
            , 'totalDiscount' => (float)$this->input->post('totalDiscount')
            , 'pretaxAmt' => (float)$this->input->post('totalPretaxAmt')
            , 'totalIgst' => (float)$this->input->post('totalIgst')
            , 'totalCgst' => (float)$this->input->post('totalCgst')
            , 'totalSgst' => (float)$this->input->post('totalSgst')
            , 'netAmt' => (float)$this->input->post('netAmt')
            , 'advancePaid' => (float)$this->input->post('advancePaid')
            , 'balance' => (float)$this->input->post('balance')
            , 'dueDate' => $dueDate
            , 'remarks' => $this->input->post('remarks')
            , 'freightTotal' => (float)$this->input->post('totalFreight')
            , 'totalQty' => (float)$this->input->post('totalQty')
            , 'createdBy' => $this->session->userRowId
        );
        $this->db->set('createdStamp', 'NOW()', FALSE);
        $this->db->insert('purchase', $data); 

        /////Saving in purchasedetail
        $TableData = $this->input->post('TableDataItems');
        $TableData = stripcslashes($TableData);
        $TableData = json_decode($TableData,TRUE);
        $myTableRows = count($TableData);
        for ($i=0; $i < $myTableRows; $i++) 
        {
            $this->db->select_max('purchaseDetailRowId');
            $query = $this->db->get('purchasedetail');
            $row = $query->row_array();
            $itemRowId = -2;
            $purchaseDetailRowId = $row['purchaseDetailRowId']+1;
            if ( $TableData[$i]['itemRowId'] == "-1")
            {
                $this->db->select_max('itemRowId');
                $query = $this->db->get('items');
                $row = $query->row_array();

                $itemRowId = $row['itemRowId']+1;
                $data = array(
                    'itemRowId' => $itemRowId
                    , 'itemName' => ucwords($TableData[$i]['itemName'])
                    , 'createdBy' => $this->session->userRowId
                );
                $this->db->set('createdStamp', 'NOW()', FALSE);
                $this->db->insert('items', $data);  
            }
            else
            {
                $itemRowId = $TableData[$i]['itemRowId'];
            }
            $data = array(
                    'purchaseDetailRowId' => $purchaseDetailRowId
                    , 'purchaseRowId' => $purchaseRowId
                    , 'itemRowId' => $itemRowId
                    , 'itemName' => $TableData[$i]['itemName']
                    , 'qty' => (float) $TableData[$i]['qty']
                    , 'rate' => (float) $TableData[$i]['rate']
                    , 'amt' => $TableData[$i]['amt']
                    , 'discountPer' => $TableData[$i]['discountPer']
                    , 'discountAmt' => $TableData[$i]['discountAmt']
                    , 'pretaxAmt' => $TableData[$i]['pretaxAmt']
                    , 'igst' => $TableData[$i]['igst']
                    , 'igstAmt' => $TableData[$i]['igstAmt']
                    , 'cgst' => $TableData[$i]['cgst']
                    , 'cgstAmt' => $TableData[$i]['cgstAmt']
                    , 'sgst' => $TableData[$i]['sgst']
                    , 'sgstAmt' => $TableData[$i]['sgstAmt']
                    , 'netAmt' => $TableData[$i]['netAmt']
                    , 'sellingPricePer' => $TableData[$i]['sellingPricePer']
                    , 'sp' => $TableData[$i]['sellingPrice']
                    , 'freight' => $TableData[$i]['freightPerItem']
                    , 'itemRemarks' => $TableData[$i]['itemRemarks']
            );
            $this->db->insert('purchasedetail', $data);    

            ///// Updating rate in Item Master
            $data = array(
                    'sellingPrice' => $TableData[$i]['sellingPrice']
                    , 'pp' => ($TableData[$i]['netAmt'] / $TableData[$i]['qty']) + $TableData[$i]['freightPerItem']

            );
            $this->db->where('itemRowId', $itemRowId);
            $this->db->update('items', $data);  
            ///// END - Updating rate in Item Master  
        }
        /////END - in Invoice Detail


    ////////////// LEDGER ENTRY .
        $this->db->select_max('ledgerRowId');
        $query = $this->db->get('ledger');
        $row = $query->row_array();

        $ledgerRowId = $row['ledgerRowId']+1;
        $data = array(
            'ledgerRowId' => $ledgerRowId
            , 'vType' => 'PV'
            , 'refRowId' => $purchaseRowId
            , 'refDt' => $dt
            , 'customerRowId' => $customerRowId
            , 'amt' => $this->input->post('advancePaid')
            // , 'bal' => $this->input->post('balance')
            , 'orderRowId' => -111
            , 'reminder' => $dueDate
            , 'dbRowId' => $purchaseRowId
            , 'remarks' => $this->input->post('remarks')
        );
        $this->db->insert('ledger', $data);
        ////////////// END - LEDGER ENTRY   

        ////////////// LEDGER ENTRY .
        $this->db->select_max('ledgerRowId');
        $query = $this->db->get('ledger');
        $row = $query->row_array();

        $ledgerRowId = $row['ledgerRowId']+1;
        $data = array(
            'ledgerRowId' => $ledgerRowId
            , 'vType' => 'PV'
            , 'refRowId' => $purchaseRowId
            , 'refDt' => $dt
            , 'customerRowId' => $customerRowId
            , 'recd' => $this->input->post('netAmt')
            , 'orderRowId' => -111
            , 'dbRowId' => $purchaseRowId
            , 'remarks' => $this->input->post('remarks')
        );
        $this->db->insert('ledger', $data);
        ////////////// END - LEDGER ENTRY   


        $this->db->trans_complete();	
	}

    public function checkForUpdate()
    {
        $this->db->select('ledger.ledgerRowId');
        $this->db->where('vType', "ADB");
        $this->db->where('purchaseRowId', $this->input->post('globalrowid'));
        $query = $this->db->get('ledger');

        if ($query->num_rows() > 0)
        {
            return 1;
        }
    }

	public function update()
    {
		set_time_limit(0);
        $this->db->trans_start();
        $customerRowId = $this->input->post('customerRowId');


        ///Updating in PV table
        $dt = date('Y-m-d', strtotime($this->input->post('dt')));
        if($this->input->post('dueDate') == '')
        {
            $dueDate = null;
        }
        else
        {
            $dueDate = date('Y-m-d', strtotime($this->input->post('dueDate')));
        }
        $data = array(
             'purchaseDt' => $dt
            , 'customerRowId' => $customerRowId
            , 'totalAmount' => (float)$this->input->post('totalAmt')
            , 'totalDiscount' => (float)$this->input->post('totalDiscount')
            , 'pretaxAmt' => (float)$this->input->post('totalPretaxAmt')
            , 'totalIgst' => (float)$this->input->post('totalIgst')
            , 'totalCgst' => (float)$this->input->post('totalCgst')
            , 'totalSgst' => (float)$this->input->post('totalSgst')
            , 'netAmt' => (float)$this->input->post('netAmt')
            , 'advancePaid' => (float)$this->input->post('advancePaid')
            , 'balance' => (float)$this->input->post('balance')
            , 'dueDate' => $dueDate
            , 'remarks' => $this->input->post('remarks')
            , 'freightTotal' => (float)$this->input->post('totalFreight')
            , 'totalQty' => (float)$this->input->post('totalQty')
            , 'createdBy' => $this->session->userRowId
        );
        $this->db->where('purchaseRowId', $this->input->post('globalrowid'));
        $this->db->update('purchase', $data); 

        /////Saving in DbDetail
        $this->db->where('purchaseRowId', $this->input->post('globalrowid'));
        $this->db->delete('purchasedetail');

        $TableData = $this->input->post('TableDataItems');
        $TableData = stripcslashes($TableData);
        $TableData = json_decode($TableData,TRUE);
        $myTableRows = count($TableData);
        for ($i=0; $i < $myTableRows; $i++) 
        {
            $this->db->select_max('purchaseDetailRowId');
            $query = $this->db->get('purchasedetail');
            $row = $query->row_array();
            $purchaseDetailRowId = $row['purchaseDetailRowId']+1;

            if ( $TableData[$i]['itemRowId'] == "-1")
            {
                $this->db->select_max('itemRowId');
                $query = $this->db->get('items');
                $row = $query->row_array();

                $itemRowId = $row['itemRowId']+1;
                $data = array(
                    'itemRowId' => $itemRowId
                    , 'itemName' => ucwords($TableData[$i]['itemName'])
                    , 'createdBy' => $this->session->userRowId
                );
                $this->db->set('createdStamp', 'NOW()', FALSE);
                $this->db->insert('items', $data);  
            }
            else
            {
                $itemRowId = $TableData[$i]['itemRowId'];
            }
            $data = array(
                    'purchaseDetailRowId' => $purchaseDetailRowId
                    , 'purchaseRowId' => $this->input->post('globalrowid')
                    , 'itemRowId' => $itemRowId
                    , 'itemName' => $TableData[$i]['itemName']
                    , 'qty' => (float) $TableData[$i]['qty']
                    , 'rate' => (float) $TableData[$i]['rate']
                    , 'amt' => $TableData[$i]['amt']
                    , 'discountPer' => $TableData[$i]['discountPer']
                    , 'discountAmt' => $TableData[$i]['discountAmt']
                    , 'pretaxAmt' => $TableData[$i]['pretaxAmt']
                    , 'igst' => $TableData[$i]['igst']
                    , 'igstAmt' => $TableData[$i]['igstAmt']
                    , 'cgst' => $TableData[$i]['cgst']
                    , 'cgstAmt' => $TableData[$i]['cgstAmt']
                    , 'sgst' => $TableData[$i]['sgst']
                    , 'sgstAmt' => $TableData[$i]['sgstAmt']
                    , 'netAmt' => $TableData[$i]['netAmt']
                    , 'sellingPricePer' => $TableData[$i]['sellingPricePer']
                    , 'sp' => $TableData[$i]['sellingPrice']
                    , 'freight' => $TableData[$i]['freightPerItem']
                    , 'itemRemarks' => $TableData[$i]['itemRemarks']
            );
            $this->db->insert('purchasedetail', $data);    

            ///// Updating rate in Item Master
            $data = array(
                'sellingPrice' => $TableData[$i]['sellingPrice']
                , 'pp' => ($TableData[$i]['netAmt'] / $TableData[$i]['qty']) + $TableData[$i]['freightPerItem']
            );
            $this->db->where('itemRowId', $itemRowId);
            $this->db->update('items', $data);  
            ///// END - Updating rate in Item Master  
        }
        /////END - in Invoice Detail


    ////////////// LEDGER ENTRY Dr.
        $data = array(
             'refDt' => $dt
            , 'amt' => $this->input->post('advancePaid')
            // , 'bal' => $this->input->post('balance')
            , 'orderRowId' => -111
            , 'reminder' => $dueDate
            , 'remarks' => $this->input->post('remarks')
        );
        $this->db->where('vType', 'PV');
        $this->db->where('refRowId', $this->input->post('globalrowid'));
        $this->db->where('recd', 0);
        // $this->db->where('amt >', 0);
        // $this->db->where('reminder IS NOT NULL', null, false);
        $this->db->update('ledger', $data);
        ////////////// END - LEDGER ENTRY   

        ////////////// LEDGER ENTRY Cr.
        $data = array(
             'refDt' => $dt
            , 'recd' => $this->input->post('netAmt')
            , 'orderRowId' => -111
            , 'remarks' => $this->input->post('remarks')
        );
        $this->db->where('vType', 'PV');
        $this->db->where('refRowId', $this->input->post('globalrowid'));
        $this->db->where('amt', 0);
        $this->db->where('reminder IS NULL', null, false);
        $this->db->update('ledger', $data);
        ////////////// END - LEDGER ENTRY   


        $this->db->trans_complete();	
	}

	public function checkPossibility()
    {
        // ////// Bal in Ledger
        // $this->db->select('*');
        // $this->db->where('refRowId', $this->input->post('rowId'));
        // $this->db->where('vType', 'PV');
        // $this->db->order_by('ledgerRowId');
        // $query = $this->db->get('ledger');
        // $flag = 0;
        // $bal = 0;
        // $balNow = 0;
        // if ($query->num_rows() > 0)
        // {
        //     $row = $query->row_array();
        //     $bal = $row['bal'];
        // }
        // ////// BalanceNow in invoice table
        // $this->db->select('*');
        // $this->db->where('invoiceRowId', $this->input->post('rowId'));
        // $query = $this->db->get('invoice');
        // if ($query->num_rows() > 0)
        // {
        //     $row = $query->row_array();
        //     $balNow = $row['balanceNow'];
        // }
        // if($bal != $balNow)
        // {
        //     $flag=1;
        // }
        // return $flag;
    } 

	public function delete()
    {
        $data = array(
                'deleted' => 'Y',
        );
        $this->db->where('vType', 'PV');
        $this->db->where('refRowId', $this->input->post('rowId'));
        $this->db->update('ledger', $data);

        $this->db->where('purchaseRowId', $this->input->post('rowId'));
        $this->db->update('purchase', $data);
    }



	public function getDataLimit()
    {
        $this->db->select('purchase.*, customers.customerName');
        // $this->db->where('purchase.deleted', 'N');
        $this->db->join('customers','customers.customerRowId = purchase.customerRowId');
        $this->db->order_by('purchaseRowId desc');
        $this->db->limit(15);
        $query = $this->db->get('purchase');

        return($query->result_array());
    }
    public function getDataAll()
    {
        $this->db->select('purchase.*, customers.customerName');
        // $this->db->where('purchase.deleted', 'N');
        $this->db->join('customers','customers.customerRowId = purchase.customerRowId');
        $this->db->order_by('purchaseRowId');
        // $this->db->limit(5);
        $query = $this->db->get('purchase');

        return($query->result_array());
    }

    public function showDetail()
    {
        $this->db->select('purchasedetail.*');
        $this->db->where('purchaseRowId', $this->input->post('globalrowid'));
        $this->db->order_by('purchaseDetailRowId');
        $query = $this->db->get('purchasedetail');

        return($query->result_array());
    }

    public function searchRecords()
    {
        $this->db->select('purchase.*, customers.customerName');
        // $this->db->where('db.deleted', 'N');
        $this->db->join('customers','customers.customerRowId = purchase.customerRowId');
        $this->db->like('purchase.remarks', $this->input->post('searchWhat'));
        $this->db->or_like('customers.customerName', $this->input->post('searchWhat'));
        $this->db->order_by('purchaseRowId');
        // $this->db->limit(5);
        $query = $this->db->get('purchase');

        return($query->result_array());
    }

    public function getPurchaseDetail()
    {
        $this->db->select('purchasedetail.*');
        $this->db->where('purchasedetail.purchaseRowId', $this->input->post('purchaseRowId'));
        $this->db->from('purchasedetail');
        // $this->db->join('productcategories','productcategories.productCategoryRowId = products.productCategoryRowId');
        $this->db->order_by('purchaseDetailRowId');
        $query = $this->db->get();
        return($query->result_array());
    }

    public function getPurchaseLog()
    {
     $this->db->select('purchasedetail.*, customers.customerName, purchase.purchaseDt');
     $this->db->from('purchasedetail');
     $this->db->join('purchase','purchase.purchaseRowId = purchasedetail.purchaseRowId');
     $this->db->join('customers','customers.customerRowId = purchase.customerRowId');
     $this->db->where('purchase.deleted', 'N');
     $this->db->where('purchasedetail.itemRowId', $this->input->post('itemRowId'));
     $this->db->order_by('purchase.purchaseDt, purchaseRowId');
     $query = $this->db->get();
     return($query->result_array());
    }

    // public function getProducts($r)
    // {
    //     $this->db->select('purchasedetail.*');
    //     $this->db->where('purchasedetail.purchaseRowId', $this->input->post('globalrowid'));
    //     $this->db->from('purchasedetail');
    //     $this->db->order_by('purchaseRowId');
    //     $query = $this->db->get();
    //     return($query->result_array());

    // }
    public function getProducts($invNo)
    {
        $this->db->select('purchasedetail.*, purchase.netAmt as grandTotal');
        $this->db->from('purchasedetail');
        $this->db->where('purchasedetail.purchaseRowId', $invNo);
        $this->db->join('purchase','purchase.purchaseRowId = purchasedetail.purchaseRowId');
        $this->db->order_by('purchaseDetailRowId');
        $query = $this->db->get();

        return($query->result_array());
    }
}