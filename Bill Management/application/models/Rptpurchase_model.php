<?php
class Rptpurchase_model extends CI_Model 
{
    public function __construct()
    {
            $this->load->database('');
    }


    public function getDataForReport()
    {
         $this->db->select('purchase.*, customers.customerName');
         $this->db->from('purchase');
         $this->db->join('customers','customers.customerRowId = purchase.customerRowId');
         $this->db->where('purchase.purchaseDt <=', date('Y-m-d', strtotime($this->input->post('dtTo'))));
         $this->db->where('purchase.purchaseDt >=', date('Y-m-d', strtotime($this->input->post('dtFrom'))));
         $this->db->where('purchase.deleted', 'N');
         $this->db->order_by('purchase.purchaseRowId');
         $query = $this->db->get();
         return($query->result_array());
    }



    public function getProducts()
    {
        $this->db->select('purchasedetail.*');
        $this->db->where('purchasedetail.purchaseRowId', $this->input->post('rowid'));
        $this->db->from('purchasedetail');
        $this->db->order_by('purchaseDetailRowId');
        $query = $this->db->get();
        return($query->result_array());

    }
}