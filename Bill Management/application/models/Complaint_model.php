<?php
class Complaint_model extends CI_Model 
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
        

        $this->db->select_max('complaintRowId');
        $query = $this->db->get('complaints');
        $row = $query->row_array();
        $complaintRowId = $row['complaintRowId']+1;
        // $this->globalDbNo = $complaintRowId;

        $dt = date('Y-m-d', strtotime($this->input->post('dt')));
        $data = array(
            'complaintRowId' => $complaintRowId
            , 'complaintDt' => $dt
            , 'customerRowId' => $customerRowId
            , 'complaint' => $this->input->post('complaint')
            , 'complaintSms' => $this->input->post('sms')
            , 'createdBy' => $this->session->userRowId
        );
        $this->db->set('createdStamp', 'NOW()', FALSE);
        $this->db->insert('complaints', $data);
        
        // $data = array(
        //     'rowId' => $complaintRowId
        //     , 'dt' => $dt
        //     , 'remarks' => $this->input->post('complaint')
        //     , 'repeat' => ucwords($this->input->post('customerName'))
        //     , 'notificationType' => 'Complaint'
        // );
        // $this->db->insert('notifications', $data);

        $this->db->trans_complete();
	}

	public function update()
    {
		set_time_limit(0);
        $this->db->trans_start();

        $customerRowId = $this->input->post('customerRowId');
        $dt = date('Y-m-d', strtotime($this->input->post('dt')));

        $data = array(
            'complaintDt' => $dt
            , 'complaint' => $this->input->post('complaint')
        );
        $this->db->where('complaintRowId', $this->input->post('globalrowid'));
        $this->db->update('complaints', $data);

        $this->db->trans_complete();
	}

    public function insertSolution()
    {
        set_time_limit(0);
        $this->db->trans_start();

        $dt = date('Y-m-d', strtotime($this->input->post('dt')));

        $data = array(
            'solutionDt' => $dt
            , 'solved' => 'Y'
            , 'amt' => $this->input->post('amt')
            , 'solutionRemarks' => $this->input->post('remarks')
            , 'solutionSms' => $this->input->post('sms')
        );
        $this->db->where('complaintRowId', $this->input->post('complaintRowId'));
        $this->db->update('complaints', $data);

        $this->db->trans_complete();
    }

	public function delete()
    {
        $data = array(
                'deleted' => 'Y',
        );
        $this->db->where('complaintRowId', $this->input->post('globalrowid'));
        $this->db->update('complaints', $data);
    }



	public function getDataLimit()
    {
        $this->db->select('complaints.*, customers.customerName, customers.mobile1,, customers.address');
        $this->db->where('complaints.deleted', 'N');
        $this->db->where('complaints.solved', 'N');
        $this->db->join('customers','customers.customerRowId = complaints.customerRowId');
        $this->db->order_by('complaintRowId desc');
        $this->db->limit(5);
        $query = $this->db->get('complaints');

        return($query->result_array());
    }
    public function getDataAll()
    {
        $this->db->select('complaints.*, customers.customerName, customers.mobile1,, customers.address');
        $this->db->where('complaints.deleted', 'N');
        $this->db->where('complaints.solved', 'N');
        $this->db->join('customers','customers.customerRowId = complaints.customerRowId');
        $this->db->order_by('complaintRowId');
        $query = $this->db->get('complaints');

        return($query->result_array());

    }


    public function getDataLimitSolved()
    {
        $this->db->select('complaints.*, customers.customerName, customers.mobile1,, customers.address');
        $this->db->where('complaints.deleted', 'N');
        // $this->db->where('complaints.solved', 'Y');
        $this->db->join('customers','customers.customerRowId = complaints.customerRowId');
        $this->db->order_by('complaintRowId desc');
        $this->db->limit(5);
        $query = $this->db->get('complaints');

        return($query->result_array());
    }
    public function getDataAllSolved()
    {
        $this->db->select('complaints.*, customers.customerName, customers.mobile1,, customers.address');
        $this->db->where('complaints.deleted', 'N');
        // $this->db->where('complaints.solved', 'Y');
        $this->db->join('customers','customers.customerRowId = complaints.customerRowId');
        $this->db->order_by('complaintRowId');
        $query = $this->db->get('complaints');

        return($query->result_array());

    }
    public function getMobileNo()
    {
        $this->db->select('customers.mobile1');
        $this->db->where('customerRowId',  $this->input->post('customerRowId'));
        $query = $this->db->get('customers');
        if ($query->num_rows() > 0)
        {
            $row = $query->row_array();
            $mobileNo = $row['mobile1'];
            return $mobileNo;
        }
        // return($query->result_array());
    }
}