<?php
class Rptdaybook_model extends CI_Model 
{
    public function __construct()
    {
            $this->load->database('');
    }

    public function getCustomerList()
    {
        $this->db->select('customers.*');
        $this->db->where('deleted', 'N');
        $this->db->order_by('customerName');
        $query = $this->db->get('customers');
        // return($query->result_array());
        $arr = array();
        $arr["-1"] = '--- Select ---';
        foreach ($query->result_array() as $row)
        {
            $arr[$row['customerRowId']]= $row['customerName'];
        }

        return $arr;
    }

    public function getOpeningBal()
    {
     $this->db->select_Sum('amt');
     $this->db->select_Sum('recd');
     $this->db->from('ledger');
     // $this->db->join('creditentry','creditentry.customerRowId = ledger.customerRowId AND ledger.refRowId = creditentry.ceRowId');
     // $this->db->join('addressbook','addressbook.abRowId = parties.abRowId');
     $this->db->where('ledger.deleted', 'N');
     // $this->db->where('ledger.customerRowId', $this->input->post('customerRowId'));
     $this->db->where('ledger.refDt <', date('Y-m-d', strtotime($this->input->post('dtFrom'))));
     // $this->db->order_by('ledger.refDt, ledgerRowId');
     $query = $this->db->get();
     return($query->result_array());
    }

    public function getDataForReport()
    {
     $this->db->select('ledger.*, customers.customerName');
     $this->db->from('ledger');
     // $this->db->join('creditentry','creditentry.customerRowId = ledger.customerRowId AND ledger.refRowId = creditentry.ceRowId','left');
     $this->db->where('ledger.deleted', 'N');
     $this->db->group_start(); //this will start grouping
        $this->db->where('ledger.amt>', 0);
        $this->db->or_where('ledger.recd>', 0);
     $this->db->group_end(); //this will end grouping
     // $this->db->where('ledger.customerRowId', $this->input->post('customerRowId'));
     $this->db->where('ledger.refDt <=', date('Y-m-d', strtotime($this->input->post('dtTo'))));
     $this->db->where('ledger.refDt >=', date('Y-m-d', strtotime($this->input->post('dtFrom'))));
     $this->db->join('customers','customers.customerRowId = ledger.customerRowId');
     $this->db->order_by('ledger.refDt, ledgerRowId');
     $query = $this->db->get();
     return($query->result_array());
    }

    public function getSaleDetail()
    {
        $this->db->select('dbdetail.*');
        $this->db->where('dbdetail.dbRowId', $this->input->post('rowid'));
        //$this->db->where('dbdetail.dbRowId', 75);
        $this->db->from('dbdetail');
        $this->db->order_by('dbdRowId');
        $query = $this->db->get();
        return($query->result_array());

    }
}