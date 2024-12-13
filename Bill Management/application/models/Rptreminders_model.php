<?php
class Rptreminders_model extends CI_Model 
{
    public function __construct()
    {
            $this->load->database('');
    }


    public function getDataForReport()
    {
     $this->db->select('ledger.*, customers.customerName, customers.mobile1');
     $this->db->from('ledger');
     // $this->db->join('creditentry','creditentry.customerRowId = ledger.customerRowId AND ledger.refRowId = creditentry.ceRowId');
     $this->db->join('customers','customers.customerRowId = ledger.customerRowId');
     $this->db->where('ledger.deleted', 'N');
     $this->db->where('ledger.reminder >=', date('Y-m-d', strtotime($this->input->post('dtFrom'))));
     $this->db->where('ledger.reminder <=', date('Y-m-d', strtotime($this->input->post('dtTo'))));
     // $this->db->where('ledger.customerRowId', $this->input->post('customerRowId'));
     $this->db->where('ledger.bal >', 0);
     $this->db->order_by('ledger.refDt, ledgerRowId');
     $query = $this->db->get();
     return($query->result_array());
    }

    public function saveDateNew()
    {
        if($this->input->post('dtNew') == '')
        {
            $dtNew = null;
        }
        else
        {
            $dtNew = date('Y-m-d', strtotime($this->input->post('dtNew')));
        }
        $data = array(
            'reminder' => $dtNew
        );
        $this->db->where('ledgerRowId', $this->input->post('gLedgerRowId'));
        $this->db->update('ledger', $data);  
    }
}