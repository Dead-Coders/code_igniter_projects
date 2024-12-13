<?php
class Quotation_model extends CI_Model 
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

    public function getItems()
	{
		$this->db->select('itemRowId, itemName, sellingPrice as rate');
        $this->db->where('deleted', 'N');
        $this->db->order_by('itemName');
        $query = $this->db->get('items');

        return($query->result_array());

        // $q = 'SELECT items.itemRowId, items.itemName,quotationDetailRowId, rate
        //         FROM items
        //         LEFT Join
        //         (SELECT S.quotationDetailRowId, S.itemRowId, S.rate
        //         FROM quotationdetail AS S
        //         Inner Join
        //         (SELECT Max(S2.quotationDetailRowId) AS MaxOfStatusID, S2.itemRowId
        //         FROM quotationdetail AS S2
        //         GROUP BY S2.itemRowId) As S3
        //         ON S.itemRowId=S3.itemRowId And  S.quotationDetailRowId= S3.MaxOfStatusID) As S4
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
        

        ///Inserting in Quotation table
        $this->db->select_max('quotationRowId');
        $query = $this->db->get('quotation');
        $row = $query->row_array();

        $quotationRowId = $row['quotationRowId']+1;
        $this->globalDbNo = $quotationRowId;

        $dt = date('Y-m-d', strtotime($this->input->post('dt')));

        $data = array(
            'quotationRowId' => $quotationRowId
            , 'quotationDt' => $dt
            , 'customerRowId' => $customerRowId
            , 'totalAmount' => (float)$this->input->post('totalAmt')
            , 'remarks' => $this->input->post('remarks')
            , 'createdBy' => $this->session->userRowId
        );
        $this->db->set('createdStamp', 'NOW()', FALSE);
        $this->db->insert('quotation', $data); 

        /////Saving in DbDetail
        $TableData = $this->input->post('TableDataItems');
        $TableData = stripcslashes($TableData);
        $TableData = json_decode($TableData,TRUE);
        $myTableRows = count($TableData);
        for ($i=0; $i < $myTableRows; $i++) 
        {
            $this->db->select_max('quotationDetailRowId');
            $query = $this->db->get('quotationdetail');
            $row = $query->row_array();
            $quotationDetailRowId = $row['quotationDetailRowId']+1;
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
                    'quotationDetailRowId' => $quotationDetailRowId
                    , 'quotationRowId' => $quotationRowId
                    , 'itemRowId' => $itemRowId
                    , 'itemName' => $TableData[$i]['itemName']
                    , 'qty' => (float) $TableData[$i]['qty']
                    , 'rate' => (float) $TableData[$i]['rate']
                    , 'amt' => $TableData[$i]['amt']
            );
            $this->db->insert('quotationdetail', $data);    
        }
        /////END - in Invoice Detail


        $this->db->trans_complete();	
	}

    public function checkForUpdate()
    {
        $this->db->select('ledger.ledgerRowId');
        $this->db->where('vType', "ADB");
        $this->db->where('quotationRowId', $this->input->post('globalrowid'));
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


        ///Updating in Quotation table
        $dt = date('Y-m-d', strtotime($this->input->post('dt')));
        $data = array(
             'quotationDt' => $dt
            , 'customerRowId' => $customerRowId
            , 'totalAmount' => (float)$this->input->post('totalAmt')
            , 'remarks' => $this->input->post('remarks')
        );
        $this->db->where('quotationRowId', $this->input->post('globalrowid'));
        $this->db->update('quotation', $data); 

        /////Saving in QuotationDetail
        $this->db->where('quotationRowId', $this->input->post('globalrowid'));
        $this->db->delete('quotationdetail');

        $TableData = $this->input->post('TableDataItems');
        $TableData = stripcslashes($TableData);
        $TableData = json_decode($TableData,TRUE);
        $myTableRows = count($TableData);
        for ($i=0; $i < $myTableRows; $i++) 
        {
            $this->db->select_max('quotationDetailRowId');
            $query = $this->db->get('quotationdetail');
            $row = $query->row_array();
            $quotationDetailRowId = $row['quotationDetailRowId']+1;

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
                    'quotationDetailRowId' => $quotationDetailRowId
                    , 'quotationRowId' => $this->input->post('globalrowid')
                    , 'itemRowId' => $itemRowId
                    , 'itemName' => $TableData[$i]['itemName']
                    , 'qty' => (float) $TableData[$i]['qty']
                    , 'rate' => (float) $TableData[$i]['rate']
                    , 'amt' => $TableData[$i]['amt']
            );
            $this->db->insert('quotationdetail', $data);    
        }
        /////END - in Detail

        $this->db->trans_complete();	
	}

	public function checkPossibility()
    {

    } 

	public function delete()
    {
        $data = array(
                'deleted' => 'Y',
        );

        $this->db->where('quotationRowId', $this->input->post('rowId'));
        $this->db->update('quotation', $data);
    }



	public function getDataLimit()
    {
        $this->db->select('quotation.*, customers.customerName');
        // $this->db->where('db.deleted', 'N');
        $this->db->join('customers','customers.customerRowId = quotation.customerRowId');
        $this->db->order_by('quotationRowId desc');
        $this->db->limit(15);
        $query = $this->db->get('quotation');

        return($query->result_array());
    }
    public function getDataAll()
    {
        $this->db->select('quotation.*, customers.customerName');
        // $this->db->where('db.deleted', 'N');
        $this->db->join('customers','customers.customerRowId = quotation.customerRowId');
        $this->db->order_by('quotationRowId');
        // $this->db->limit(5);
        $query = $this->db->get('quotation');

        return($query->result_array());
    }

    public function showDetail()
    {
        $this->db->select('quotationdetail.*');
        $this->db->where('quotationRowId', $this->input->post('globalrowid'));
        $this->db->order_by('quotationDetailRowId');
        $query = $this->db->get('quotationdetail');

        return($query->result_array());
    }
}