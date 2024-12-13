<?php
class Dashboard_model extends CI_Model 
{
    public function __construct()
    {
            $this->load->database('');
    }

    public function getDues()
    {
        $q = "Select sum(amt)-sum(recd) as balance, ledger.customerRowId, customers.customerName, customers.mobile1 from ledger, customers where ledger.customerRowId=customers.customerRowId AND ledger.deleted='N' AND NOT customers.remarks='dont show in dues' group by customerRowId having balance>0 order by customerName";
        $query = $this->db->query($q);
        return($query->result_array());
    }

    public function getDuesNegative()
    {
        $q = "Select sum(amt)-sum(recd) as balance, ledger.customerRowId, customers.customerName from ledger, customers where ledger.customerRowId=customers.customerRowId AND ledger.deleted='N' AND NOT customers.remarks='dont show in dues' group by customerRowId having balance<0 order by customerName";
        $query = $this->db->query($q);
        return($query->result_array());
    }

    public function getComplaints()
    {
        $this->db->select('complaints.*, customers.customerName, customers.mobile1,, customers.address');
        $this->db->where('complaints.deleted', 'N');
        $this->db->where('complaints.solved', 'N');
        $this->db->join('customers','customers.customerRowId = complaints.customerRowId');
        $this->db->order_by('complaintRowId');
        $query = $this->db->get('complaints');
        return($query->result_array());
    }

    public function getReplacements()
	{
		$this->db->select('*');
		$this->db->where('deleted', 'N');
		$this->db->where('recd', 'N');
		$this->db->order_by('replacementRowId');
		// $this->db->limit(5);
		$query = $this->db->get('replacement');

		return($query->result_array());
	}

	public function getRequirements()
	{
		$this->db->select('*');
		$this->db->order_by('rowId');
		$query = $this->db->get('requirement');

		return($query->result_array());
	}
}   