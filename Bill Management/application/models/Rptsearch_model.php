<?php
class Rptsearch_model extends CI_Model 
{
    public function __construct()
    {
            $this->load->database('');
    }

    public function getLedgerData()
    {
     $this->db->select('ledger.refDt, ledger.remarks, ledger.vType, ledger.refRowId, ledger.amt, ledger.recd, customers.customerName');
     $this->db->from('ledger');
     $this->db->join('customers','customers.customerRowId = ledger.customerRowId');
     $this->db->where('ledger.deleted', 'N');
     $this->db->like('ledger.remarks', $this->input->post('searchWhat'));
     $this->db->or_like('customers.customerName', $this->input->post('searchWhat')); 

     $this->db->order_by('ledger.refDt, ledgerRowId');
     $query = $this->db->get();
     return($query->result_array());
    }

    public function getReminderData()
    {
     $this->db->select('reminders.dt, reminders.remarks, reminders.repeat');
     $this->db->from('reminders');
     $this->db->where('reminders.deleted', 'N');
     $this->db->like('reminders.remarks', $this->input->post('searchWhat'));
     $this->db->or_like('reminders.repeat', $this->input->post('searchWhat')); 

     $this->db->order_by('reminders.dt, reminderRowId');
     $query = $this->db->get();
     return($query->result_array());
    }

    public function getDatesData()
    {
     $this->db->select('dates.dt, dates.remarks');
     $this->db->from('dates');
     $this->db->where('dates.deleted', 'N');
     $this->db->like('dates.remarks', $this->input->post('searchWhat'));

     $this->db->order_by('dates.dt, dateRowId');
     $query = $this->db->get();
     return($query->result_array());
    }

    public function getCashSaleData()
    {
     $this->db->select('cashsale.*');
     $this->db->from('cashsale');
     // $this->db->where('cashsale.deleted', 'N');
     $this->db->like('cashsale.remarks', $this->input->post('searchWhat'));
     $this->db->or_like('cashsale.itemName', $this->input->post('searchWhat')); 

     $this->db->order_by('cashsale.dt, cashSaleRowId');
     $query = $this->db->get();
     return($query->result_array());
    }    
}