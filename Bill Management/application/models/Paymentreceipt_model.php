<?php
class Paymentreceipt_model extends CI_Model 
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

    public function checkDuplicateNewCustomer()
    {
        $this->db->select('customers.customerRowId');
        $this->db->where('customerName', $this->input->post('customerName'));
        $query = $this->db->get('customers');

        if ($query->num_rows() > 0)
        {
            return 1;
        }
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
        
        if( $this->input->post('transactionMode') == "Payment" || $this->input->post('transactionMode') == "UPI" )
        {
            $this->db->select_max('refRowId');
            $this->db->where('ledger.vType', 'P');
            $query = $this->db->get('ledger');
            $row = $query->row_array();
            $refRowId = $row['refRowId']+1;
            $this->globalDbNo = $refRowId;

            $this->db->select_max('ledgerRowId');
            $query = $this->db->get('ledger');
            $row = $query->row_array();

            $ledgerRowId = $row['ledgerRowId']+1;
            $dt = date('Y-m-d', strtotime($this->input->post('dt')));
            $data = array(
                'ledgerRowId' => $ledgerRowId
                , 'vType' => 'P'
                , 'refRowId' => $refRowId
                , 'refDt' => $dt
                , 'customerRowId' => $customerRowId
                , 'amt' => $this->input->post('amt')
                , 'bal' => $this->input->post('amt')
                , 'orderRowId' => -222
                , 'remarks' => $this->input->post('remarks')
            );
            $this->db->insert('ledger', $data);
        }   
        else if( $this->input->post('transactionMode') == "Received" )
        {
            $this->db->select_max('refRowId');
            $this->db->where('ledger.vType', 'R');
            $query = $this->db->get('ledger');
            $row = $query->row_array();
            $refRowId = $row['refRowId']+1;
            $this->globalDbNo = $refRowId;

            $this->db->select_max('ledgerRowId');
            $query = $this->db->get('ledger');
            $row = $query->row_array();

            $ledgerRowId = $row['ledgerRowId']+1;
            $dt = date('Y-m-d', strtotime($this->input->post('dt')));
            $data = array(
                'ledgerRowId' => $ledgerRowId
                , 'vType' => 'R'
                , 'refRowId' => $refRowId
                , 'refDt' => $dt
                , 'customerRowId' => $customerRowId
                , 'recd' => $this->input->post('amt')
                , 'orderRowId' => -222
                , 'remarks' => $this->input->post('remarks')
            );
            $this->db->insert('ledger', $data);
        }   


        $this->db->trans_complete();
	}

    public function getCustomerNewBalance()
    {
        set_time_limit(0);
        $this->db->select('sum(amt)-sum(recd) as balance');
        $this->db->where('customerRowId', $this->input->post('customerRowId'));
        $this->db->where('deleted', 'N');
        $query = $this->db->get('ledger');

        // $q = "Select sum(amt)-sum(recd) as balance, customers.customerRowId, customers.customerName,customers.mobile1, customers.address,customers.remarks from customers JOIN ledger  ON ledger.customerRowId=customers.customerRowId AND ledger.deleted='N' WHERE customers.customerRowId=". $this->input->post('customerName') ." AND customers.deleted='N' group by customers.customerRowId, customers.customerName,customers.mobile1, customers.address,customers.remarks order by customerName";
        // $query = $this->db->query($q);
        return($query->result_array());
    }
    public function getOldRecord()
    {
        $this->db->select('ledger.*');
        $this->db->where('customerRowId', $this->input->post('customerRowId'));
        $this->db->where('refRowId', $this->input->post('globalrowid'));
        $query = $this->db->get('ledger');

        return($query->result_array());
    }

	public function update()
    {
		// set_time_limit(0);
  //       $this->db->trans_start();

  //       $customerRowId = $this->input->post('customerRowId');
  //       $dt = date('Y-m-d', strtotime($this->input->post('dt')));

  //       if( $this->input->post('transactionMode') == "Payment" )
  //       {
  //           $data = array(
  //                'refDt' => $dt
  //               , 'amt' => $this->input->post('amt')
  //               , 'bal' => $this->input->post('amt')
  //               , 'remarks' => $this->input->post('remarks')
  //           );
  //           $this->db->where('vType', 'P');
  //           $this->db->where('refRowId', $this->input->post('globalrowid'));
  //           $this->db->where('recd', 0);
  //           $this->db->update('ledger', $data);
  //       }
  //       else if( $this->input->post('transactionMode') == "Received" )
  //       {
  //           $data = array(
  //                'refDt' => $dt
  //               , 'recd' => $this->input->post('amt')
  //               , 'remarks' => $this->input->post('remarks')
  //           );
  //           $this->db->where('vType', 'R');
  //           $this->db->where('refRowId', $this->input->post('globalrowid'));
  //           $this->db->where('amt', 0);
  //           $this->db->update('ledger', $data);
  //       }


  //       $this->db->trans_complete();
	}


	public function delete()
    {
        $data = array(
                'deleted' => 'Y',
        );
        $this->db->where('vType', $this->input->post('globalVtype'));
        $this->db->where('refRowId', $this->input->post('globalrowid'));
        $this->db->update('ledger', $data);
    }



	public function getDataLimit()
    {
        $this->db->select('ledger.*, customers.customerName');
        // $this->db->where('ledger.deleted', 'N');
        $this->db->group_start();
            $this->db->or_where('ledger.vType', 'P');
            $this->db->or_where('ledger.vType', 'R');
        $this->db->group_end();
        $this->db->join('customers','customers.customerRowId = ledger.customerRowId');
        $this->db->order_by('ledgerRowId desc');
        $this->db->limit(15);
        $query = $this->db->get('ledger');

        return($query->result_array());
    }
    public function getDataAll()
    {
        $this->db->select('ledger.*, customers.customerName');
        // $this->db->where('ledger.deleted', 'N');
        $this->db->group_start();
            $this->db->or_where('ledger.vType', 'P');
            $this->db->or_where('ledger.vType', 'R');
        $this->db->group_end();
        $this->db->join('customers','customers.customerRowId = ledger.customerRowId');
        $this->db->order_by('ledgerRowId');
        // $this->db->limit(5);
        $query = $this->db->get('ledger');

        return($query->result_array());

    }

}