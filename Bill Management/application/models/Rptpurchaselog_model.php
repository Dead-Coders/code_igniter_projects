<?php
class Rptpurchaselog_model extends CI_Model 
{
    public function __construct()
    {
            $this->load->database('');
    }

    public function getItemList()
    {
        $this->db->select('items.*');
        $this->db->where('deleted', 'N');
        $this->db->order_by('itemName');
        $query = $this->db->get('items');

        return($query->result_array());
    }   

    public function getDataForReportPurchase()
    {
         $this->db->select('purchasedetail.*, customers.customerName, purchase.purchaseDt');
         $this->db->from('purchasedetail');
         $this->db->join('purchase','purchase.purchaseRowId = purchasedetail.purchaseRowId');
         $this->db->join('customers','customers.customerRowId = purchase.customerRowId');
         $this->db->where('purchase.purchaseDt <=', date('Y-m-d', strtotime($this->input->post('dtTo'))));
         $this->db->where('purchase.purchaseDt >=', date('Y-m-d', strtotime($this->input->post('dtFrom'))));
         $this->db->where('purchase.deleted', 'N');
         $arr = explode(",", $this->input->post('arr'));
         $this->db->where_in('purchasedetail.itemRowId', $arr );

         // $this->db->group_start();
         //     $this->db->like('purchasedetail.itemName', $this->input->post('searchWhat'));
         //     $this->db->or_like('customers.customerName', $this->input->post('searchWhat'));
         // $this->db->group_end();
         $this->db->order_by('purchasedetail.itemName, purchasedetail.purchaseRowId, purchasedetail.purchaseDetailRowId');
         $query = $this->db->get();
         return($query->result_array());
    }


}