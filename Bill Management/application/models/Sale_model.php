<?php
class Sale_model extends CI_Model 
{
    public $globalDbNo = 0;
    public function __construct()
    {
            $this->load->database('');
    }

    public function getCustInfo($invNo)
    {
        $this->db->select('db.customerRowId, db.dbDt, customers.customerName, customers.address');
        $this->db->from('db');
        $this->db->where('db.dbRowId', $invNo);
        $this->db->join('customers','customers.customerRowId = db.customerRowId');
        $query = $this->db->get();

        return($query->result_array());
    }

    public function getProducts($invNo)
    {
        $this->db->select('dbdetail.*, db.netAmt as grandTotal');
        $this->db->from('dbdetail');
        $this->db->where('dbdetail.dbRowId', $invNo);
        $this->db->join('db','db.dbRowId = dbdetail.dbRowId');
        $this->db->order_by('dbdRowId');
        $query = $this->db->get();

        return($query->result_array());
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

    public function getLastPurchasePrice()
    {
        $this->db->select('purchasedetail.*');
        $this->db->where('itemRowId', $this->input->post('itemRowId'));
        // $this->db->order_by('purchaseRowId');
        $query = $this->db->get('purchasedetail');
        $row = $query->last_row('array');
        // $lastRate = $row['rate'];
        if($row['qty'] == 0)
        {
            $lastRate = 0;
        }
        else
        {
            $lastRate = ($row['netAmt']) /  $row['qty'];
        }
        $lastRate = round($lastRate);
        return $lastRate;
        // $lastRate = $row['purchaseRowId'] . "K" . $lastRate;
        // return $lastRate;
         // return($query->result_array());
    }

    public function getItems()
	{
		$this->db->select('itemRowId, itemName, sellingPrice as rate, pp');
		$this->db->where('deleted', 'N');
		$this->db->order_by('itemName');
		$query = $this->db->get('items');

		return($query->result_array());
        // $q = 'SELECT items.itemRowId, items.itemName,dbdRowId, rate
        //         FROM items
        //         LEFT Join
        //         (SELECT S.dbdRowId, S.itemRowId, S.rate
        //         FROM dbdetail AS S
        //         Inner Join
        //         (SELECT Max(S2.dbdRowId) AS MaxOfStatusID, S2.itemRowId
        //         FROM dbdetail AS S2
        //         GROUP BY S2.itemRowId) As S3
        //         ON S.itemRowId=S3.itemRowId And  S.dbdRowId= S3.MaxOfStatusID) As S4
        //         On items.itemRowId=S4.itemRowId ORDER BY items.itemName';

        // $query = $this->db->query($q);
        // return($query->result_array());
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
        

        ///Inserting in DB table
        $this->db->select_max('dbRowId');
        $query = $this->db->get('db');
        $row = $query->row_array();

        $dbRowId = $row['dbRowId']+1;
        $this->globalDbNo = $dbRowId;

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
            'dbRowId' => $dbRowId
            , 'dbDt' => $dt
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
            , 'np' => (float)$this->input->post('np')
            , 'createdBy' => $this->session->userRowId
        );
        $this->db->set('createdStamp', 'NOW()', FALSE);
        $this->db->insert('db', $data); 

        /////Saving in DbDetail
        $TableData = $this->input->post('TableDataItems');
        $TableData = stripcslashes($TableData);
        $TableData = json_decode($TableData,TRUE);
        $myTableRows = count($TableData);
        for ($i=0; $i < $myTableRows; $i++) 
        {
            $this->db->select_max('dbdRowId');
            $query = $this->db->get('dbdetail');
            $row = $query->row_array();
            $dbdRowId = $row['dbdRowId']+1;
            if ( $TableData[$i]['itemRowId'] == "-1")
            {
                $this->db->select_max('itemRowId');
                $query = $this->db->get('items');
                $row = $query->row_array();

                $itemRowId = $row['itemRowId']+1;
                $data = array(
                    'itemRowId' => $itemRowId
                    , 'itemName' => ucwords($TableData[$i]['itemName'])
                    , 'sellingPrice' => ucwords($TableData[$i]['rate'])
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
                    'dbdRowId' => $dbdRowId
                    , 'dbRowId' => $dbRowId
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
                    , 'pp' => $TableData[$i]['pp']
                    , 'itemRemarks' => $TableData[$i]['itemRemarks']

            );
            $this->db->insert('dbdetail', $data);    
        }
        /////END - in Invoice Detail


    ////////////// LEDGER ENTRY Dr.
        $this->db->select_max('ledgerRowId');
        $query = $this->db->get('ledger');
        $row = $query->row_array();

        $ledgerRowId = $row['ledgerRowId']+1;
        $data = array(
            'ledgerRowId' => $ledgerRowId
            , 'vType' => 'DB'
            , 'refRowId' => $dbRowId
            , 'refDt' => $dt
            , 'customerRowId' => $customerRowId
            , 'amt' => $this->input->post('netAmt')
            , 'bal' => $this->input->post('balance')
            , 'orderRowId' => -111
            , 'reminder' => $dueDate
            , 'dbRowId' => $dbRowId
            , 'remarks' => $this->input->post('remarks')
        );
        $this->db->insert('ledger', $data);
        ////////////// END - LEDGER ENTRY   

        ////////////// LEDGER ENTRY Cr.
        $this->db->select_max('ledgerRowId');
        $query = $this->db->get('ledger');
        $row = $query->row_array();

        $ledgerRowId = $row['ledgerRowId']+1;
        $data = array(
            'ledgerRowId' => $ledgerRowId
            , 'vType' => 'DB'
            , 'refRowId' => $dbRowId
            , 'refDt' => $dt
            , 'customerRowId' => $customerRowId
            , 'recd' => $this->input->post('advancePaid')
            , 'orderRowId' => -111
            , 'dbRowId' => $dbRowId
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
        $this->db->where('dbRowId', $this->input->post('globalrowid'));
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


        ///Updating in DB table
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
             'dbDt' => $dt
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
            , 'np' => (float)$this->input->post('np')
            , 'createdBy' => $this->session->userRowId
        );
        $this->db->where('dbRowId', $this->input->post('globalrowid'));
        $this->db->update('db', $data); 

        /////Saving in DbDetail
        $this->db->where('dbRowId', $this->input->post('globalrowid'));
        $this->db->delete('dbdetail');

        $TableData = $this->input->post('TableDataItems');
        $TableData = stripcslashes($TableData);
        $TableData = json_decode($TableData,TRUE);
        $myTableRows = count($TableData);
        for ($i=0; $i < $myTableRows; $i++) 
        {
            $this->db->select_max('dbdRowId');
            $query = $this->db->get('dbdetail');
            $row = $query->row_array();
            $dbdRowId = $row['dbdRowId']+1;

            if ( $TableData[$i]['itemRowId'] == "-1")
            {
                $this->db->select_max('itemRowId');
                $query = $this->db->get('items');
                $row = $query->row_array();

                $itemRowId = $row['itemRowId']+1;
                $data = array(
                    'itemRowId' => $itemRowId
                    , 'itemName' => ucwords($TableData[$i]['itemName'])
                    , 'sellingPrice' => ucwords($TableData[$i]['rate'])
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
                    'dbdRowId' => $dbdRowId
                    , 'dbRowId' => $this->input->post('globalrowid')
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
                    , 'pp' => $TableData[$i]['pp']
                    , 'itemRemarks' => $TableData[$i]['itemRemarks']
            );
            $this->db->insert('dbdetail', $data);    
        }
        /////END - in Invoice Detail


    ////////////// LEDGER ENTRY Dr.
        $data = array(
             'refDt' => $dt
            , 'amt' => $this->input->post('netAmt')
            , 'bal' => $this->input->post('balance')
            , 'orderRowId' => -111
            , 'reminder' => $dueDate
            , 'remarks' => $this->input->post('remarks')
        );
        $this->db->where('vType', 'DB');
        $this->db->where('refRowId', $this->input->post('globalrowid'));
        $this->db->where('amt >', 0);
        $this->db->update('ledger', $data);
        ////////////// END - LEDGER ENTRY   

        ////////////// LEDGER ENTRY Cr.
        $data = array(
             'refDt' => $dt
            , 'recd' => $this->input->post('advancePaid')
            , 'orderRowId' => -111
            , 'remarks' => $this->input->post('remarks')
        );
        $this->db->where('vType', 'DB');
        $this->db->where('refRowId', $this->input->post('globalrowid'));
        $this->db->where('amt', 0);
        $this->db->update('ledger', $data);
        ////////////// END - LEDGER ENTRY   


        $this->db->trans_complete();	
	}

	public function checkPossibility()
    {
        // ////// Bal in Ledger
        // $this->db->select('*');
        // $this->db->where('refRowId', $this->input->post('rowId'));
        // $this->db->where('vType', 'DB');
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
        $this->db->where('vType', 'DB');
        $this->db->where('refRowId', $this->input->post('rowId'));
        $this->db->update('ledger', $data);

        $this->db->where('dbRowId', $this->input->post('rowId'));
        $this->db->update('db', $data);
    }



	public function getDataLimit()
    {
        $this->db->select('db.*, customers.customerName');
        // $this->db->where('db.deleted', 'N');
        $this->db->join('customers','customers.customerRowId = db.customerRowId');
        $this->db->order_by('dbRowId desc');
        $this->db->limit(15);
        $query = $this->db->get('db');

        return($query->result_array());
    }
    public function getDataAll()
    {
        $this->db->select('db.*, customers.customerName');
        // $this->db->where('db.deleted', 'N');
        $this->db->join('customers','customers.customerRowId = db.customerRowId');
        $this->db->order_by('dbRowId');
        // $this->db->limit(5);
        $query = $this->db->get('db');

        return($query->result_array());
    }

    public function searchRecords()
    {
        $this->db->select('db.*, customers.customerName');
        // $this->db->where('db.deleted', 'N');
        $this->db->join('customers','customers.customerRowId = db.customerRowId');
        $this->db->like('db.remarks', $this->input->post('searchWhat'));
        $this->db->or_like('customers.customerName', $this->input->post('searchWhat'));
        $this->db->order_by('dbRowId');
        // $this->db->limit(5);
        $query = $this->db->get('db');

        return($query->result_array());
    }


    public function showDetail()
    {
        $this->db->select('dbdetail.*');
        $this->db->where('dbRowId', $this->input->post('globalrowid'));
        $this->db->order_by('dbdRowId');
        $query = $this->db->get('dbdetail');

        return($query->result_array());
    }


    public function getQuotationProducts()
    {
        set_time_limit(0);
        $this->db->select('quotationdetail.*');
        $this->db->where('quotationRowId', $this->input->post('quotationRowId'));
        $this->db->order_by('quotationDetailRowId');
        $query = $this->db->get('quotationdetail');

        return($query->result_array());
    }

    public function getSaleDetail()
    {
        $this->db->select('dbdetail.*');
        $this->db->where('dbdetail.dbRowId', $this->input->post('dbRowId'));
        $this->db->from('dbdetail');
        // $this->db->join('productcategories','productcategories.productCategoryRowId = products.productCategoryRowId');
        $this->db->order_by('dbRowId');
        $query = $this->db->get();
        return($query->result_array());
    }
}