<?php
class Sendsms_model extends CI_Model 
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
        $this->db->select_max('smsRowId');
        $query = $this->db->get('sendsms');
        $row = $query->row_array();

        $smsRowId = $row['smsRowId']+1;
        $this->globalDbNo = $smsRowId;


        $data = array(
            'smsRowId' => $smsRowId
            , 'customerRowId' => $customerRowId
            , 'smsData' => $this->input->post('smsData')
            , 'createdBy' => $this->session->userRowId
        );
        $this->db->set('createdStamp', 'NOW()', FALSE);
        $this->db->insert('sendsms', $data); 



        $this->db->trans_complete();	
	}


	public function getDataLimit()
    {
        $this->db->select('sendsms.*, customers.customerName');
        // $this->db->where('db.deleted', 'N');
        $this->db->join('customers','customers.customerRowId = sendsms.customerRowId');
        $this->db->order_by('smsRowId desc');
        $this->db->limit(5);
        $query = $this->db->get('sendsms');

        return($query->result_array());
    }
    public function getDataAll()
    {
        $this->db->select('sendsms.*, customers.customerName');
        // $this->db->where('db.deleted', 'N');
        $this->db->join('customers','customers.customerRowId = sendsms.customerRowId');
        $this->db->order_by('smsRowId');
        // $this->db->limit(5);
        $query = $this->db->get('sendsms');

        return($query->result_array());
    }

    public function getDataAddressBook()
    {
        $this->db->distinct();
        $this->db->select('addressbook.mobile');
        $this->db->where('LENGTH(addressbook.mobile)', 10);
        $this->db->order_by('mobile');
        // $this->db->limit(5);
        $query = $this->db->get('addressbook');

        return($query->result_array());
    }
    public function getDataCust()
    {
        $this->db->distinct();
        $this->db->select('customers.mobile1');
        $this->db->where('LENGTH(customers.mobile1)', 10);
        $this->db->order_by('mobile1');
        // $this->db->limit(5);
        $query = $this->db->get('customers');

        return($query->result_array());
    }
    public function getDataRecharge()
    {
        $this->db->distinct();
        $this->db->select('recharge.id');
        $this->db->where('LENGTH(recharge.id)', 10);
        $this->db->where('device', 'Mobile');
        $this->db->order_by('id');
        // $this->db->limit(5);
        $query = $this->db->get('recharge');

        return($query->result_array());
    }
    
}