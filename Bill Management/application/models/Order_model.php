<?php
class Order_model extends CI_Model 
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
		$this->db->select('itemRowId, itemName');
		$this->db->where('deleted', 'N');
		$this->db->order_by('itemName');
		$query = $this->db->get('items');

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
        

        ///Inserting in Quotation table
        $this->db->select_max('orderRowId');
        $query = $this->db->get('order');
        $row = $query->row_array();

        $orderRowId = $row['orderRowId']+1;
        $this->globalDbNo = $orderRowId;

        $dt = date('Y-m-d', strtotime($this->input->post('dt')));
        $deliveryDt = date('Y-m-d', strtotime($this->input->post('deliveryDt')));

        $data = array(
            'orderRowId' => $orderRowId
            , 'orderDt' => $dt
            , 'customerRowId' => $customerRowId
            , 'totalAmount' => $this->input->post('totalAmt')
            , 'advance' => $this->input->post('advance')
            , 'due' => $this->input->post('due')
            , 'deliveryDt' => $deliveryDt
            , 'remarks' => $this->input->post('remarks')
            , 'createdBy' => $this->session->userRowId
        );
        $this->db->set('createdStamp', 'NOW()', FALSE);
        $this->db->insert('order', $data); 

        /////Saving in DbDetail
        $TableData = $this->input->post('TableDataItems');
        $TableData = stripcslashes($TableData);
        $TableData = json_decode($TableData,TRUE);
        $myTableRows = count($TableData);
        for ($i=0; $i < $myTableRows; $i++) 
        {
            $this->db->select_max('orderDetailRowId');
            $query = $this->db->get('orderdetail');
            $row = $query->row_array();
            $orderDetailRowId = $row['orderDetailRowId']+1;
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
                    'orderDetailRowId' => $orderDetailRowId
                    , 'orderRowId' => $orderRowId
                    , 'itemRowId' => $itemRowId
                    , 'itemName' => $TableData[$i]['itemName']
                    , 'qty' => (float) $TableData[$i]['qty']
                    , 'rate' => (float) $TableData[$i]['rate']
                    , 'amt' => $TableData[$i]['amt']
                    , 'itemRemarks' => $TableData[$i]['itemRemarks']
            );
            $this->db->insert('orderdetail', $data);    
        }
        /////END - in Invoice Detail


        $this->db->trans_complete();	
	}

    // public function checkForUpdate()
    // {
    //     $this->db->select('ledger.ledgerRowId');
    //     $this->db->where('vType', "ADB");
    //     $this->db->where('orderRowId', $this->input->post('globalrowid'));
    //     $query = $this->db->get('ledger');

    //     if ($query->num_rows() > 0)
    //     {
    //         return 1;
    //     }
    // }

	public function update()
    {
		set_time_limit(0);
        $this->db->trans_start();
        $customerRowId = $this->input->post('customerRowId');


        ///Updating in Quotation table
        $dt = date('Y-m-d', strtotime($this->input->post('dt')));
        $deliveryDt = date('Y-m-d', strtotime($this->input->post('deliveryDt')));
        $data = array(
             'orderDt' => $dt
            , 'customerRowId' => $customerRowId
            , 'totalAmount' => (float)$this->input->post('totalAmt')
            , 'advance' => $this->input->post('advance')
            , 'due' => $this->input->post('due')
            , 'deliveryDt' => $deliveryDt
            , 'remarks' => $this->input->post('remarks')
        );
        $this->db->where('orderRowId', $this->input->post('globalrowid'));
        $this->db->update('order', $data); 

        /////Saving in QuotationDetail
        $this->db->where('orderRowId', $this->input->post('globalrowid'));
        $this->db->delete('orderdetail');

        $TableData = $this->input->post('TableDataItems');
        $TableData = stripcslashes($TableData);
        $TableData = json_decode($TableData,TRUE);
        $myTableRows = count($TableData);
        for ($i=0; $i < $myTableRows; $i++) 
        {
            $this->db->select_max('orderDetailRowId');
            $query = $this->db->get('orderdetail');
            $row = $query->row_array();
            $orderDetailRowId = $row['orderDetailRowId']+1;

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
                    'orderDetailRowId' => $orderDetailRowId
                    , 'orderRowId' => $this->input->post('globalrowid')
                    , 'itemRowId' => $itemRowId
                    , 'itemName' => $TableData[$i]['itemName']
                    , 'qty' => (float) $TableData[$i]['qty']
                    , 'rate' => (float) $TableData[$i]['rate']
                    , 'amt' => $TableData[$i]['amt']
                    , 'itemRemarks' => $TableData[$i]['itemRemarks']
            );
            $this->db->insert('orderdetail', $data);    
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

        $this->db->where('orderRowId', $this->input->post('rowId'));
        $this->db->update('order', $data);
    }



	public function getDataLimit()
    {
        $this->db->select('order.*, customers.customerName');
        // $this->db->where('db.deleted', 'N');
        $this->db->join('customers','customers.customerRowId = order.customerRowId');
        $this->db->order_by('orderRowId desc');
        $this->db->limit(5);
        $query = $this->db->get('order');

        return($query->result_array());
    }
    public function getDataAll()
    {
        $this->db->select('order.*, customers.customerName');
        // $this->db->where('db.deleted', 'N');
        $this->db->join('customers','customers.customerRowId = order.customerRowId');
        $this->db->order_by('orderRowId');
        // $this->db->limit(5);
        $query = $this->db->get('order');

        return($query->result_array());
    }

    public function showDetail()
    {
        $this->db->select('orderdetail.*');
        $this->db->where('orderRowId', $this->input->post('globalrowid'));
        $this->db->order_by('orderDetailRowId');
        $query = $this->db->get('orderdetail');

        return($query->result_array());
    }
}