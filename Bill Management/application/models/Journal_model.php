<?php
class Journal_model extends CI_Model 
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

    public function checkDuplicateNewPaidByAc()
    {
        $this->db->select('customers.customerRowId');
        $this->db->where('customerName', $this->input->post('paidByName'));
        $query = $this->db->get('customers');

        if ($query->num_rows() > 0)
        {
            return 1;
        }
    }

    public function checkDuplicateNewReceivedByAc()
    {
        $this->db->select('customers.customerRowId');
        $this->db->where('customerName', $this->input->post('receivedByName'));
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
        $paidByRowId = $this->input->post('paidByRowId');
        if( $paidByRowId == -1 ) ///new paid by
        {
            $this->db->select_max('customerRowId');
            $query = $this->db->get('customers');
            $row = $query->row_array();

            $customerRowId = $row['customerRowId']+1;
            $paidByRowId = $customerRowId;
            $data = array(
                'customerRowId' => $customerRowId
                , 'customerName' => ucwords($this->input->post('paidByName'))
                , 'createdBy' => $this->session->userRowId
            );
            $this->db->set('createdStamp', 'NOW()', FALSE);
            $this->db->insert('customers', $data);  
        }

        $receivedByRowId = $this->input->post('receivedByRowId');
        if( $receivedByRowId == -1 ) ///new received By
        {
            $this->db->select_max('customerRowId');
            $query = $this->db->get('customers');
            $row = $query->row_array();

            $customerRowId = $row['customerRowId']+1;
            $receivedByRowId = $customerRowId;
            $data = array(
                'customerRowId' => $customerRowId
                , 'customerName' => ucwords($this->input->post('receivedByName'))
                , 'createdBy' => $this->session->userRowId
            );
            $this->db->set('createdStamp', 'NOW()', FALSE);
            $this->db->insert('customers', $data);  
        }

        //////Paid by entry in ledger
        $this->db->select_max('refRowId');
        $this->db->where('ledger.vType', 'J');
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
            , 'vType' => 'J'
            , 'refRowId' => $refRowId
            , 'refDt' => $dt
            , 'customerRowId' => $paidByRowId
            , 'recd' => $this->input->post('amt')
            , 'orderRowId' => -222
            , 'remarks' => $this->input->post('remarks')
        );
        $this->db->insert('ledger', $data);

        //////Received by entry in ledger
        $this->db->select_max('ledgerRowId');
        $query = $this->db->get('ledger');
        $row = $query->row_array();

        $ledgerRowId = $row['ledgerRowId']+1;
        $dt = date('Y-m-d', strtotime($this->input->post('dt')));
        $data = array(
            'ledgerRowId' => $ledgerRowId
            , 'vType' => 'J'
            , 'refRowId' => $refRowId
            , 'refDt' => $dt
            , 'customerRowId' => $receivedByRowId
            , 'amt' => $this->input->post('amt')
            , 'orderRowId' => -222
            , 'remarks' => $this->input->post('remarks')
        );
        $this->db->insert('ledger', $data);
          


        $this->db->trans_complete();
	}



	public function delete()
    {
        $data = array(
                'deleted' => 'Y',
        );
        $this->db->where('vType', 'J');
        $this->db->where('refRowId', $this->input->post('globalrowid'));
        $this->db->update('ledger', $data);
    }



	public function getDataLimit()
    {
        $this->db->select('ledger.*, customers.customerName');
        $this->db->where('ledger.deleted', 'N');
        $this->db->group_start();
            $this->db->or_where('ledger.vType', 'J');
            $this->db->or_where('ledger.vType', 'J');
        $this->db->group_end();
        $this->db->join('customers','customers.customerRowId = ledger.customerRowId');
        $this->db->order_by('ledgerRowId desc');
        $this->db->limit(5);
        $query = $this->db->get('ledger');

        return($query->result_array());
    }
    public function getDataAll()
    {
        $this->db->select('ledger.*, customers.customerName');
        $this->db->where('ledger.deleted', 'N');
        $this->db->group_start();
            $this->db->or_where('ledger.vType', 'J');
            $this->db->or_where('ledger.vType', 'J');
        $this->db->group_end();
        $this->db->join('customers','customers.customerRowId = ledger.customerRowId');
        $this->db->order_by('ledgerRowId');
        // $this->db->limit(5);
        $query = $this->db->get('ledger');

        return($query->result_array());

    }

}