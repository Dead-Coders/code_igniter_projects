<?php
class Rptledgeritem_model extends CI_Model 
{
    public function __construct()
    {
            $this->load->database('');
    }

    public function getItemList()
    {
        $this->db->select('items.*');
        $this->db->from('items');
        $this->db->where('items.deleted', 'N');
        $this->db->order_by('itemName');
        $query = $this->db->get();
        $arr = array();
        $arr["-1"] = '--- Select ---';
        foreach ($query->result_array() as $row)
        {
            $arr[$row['itemRowId']]= $row['itemName'];
        }

        return $arr;
    }

    public function getOpeningBal()
    {
        $opBal = 0;
     $this->db->select_Sum('openingBalance');
     $this->db->from('items');
     $this->db->where('items.deleted', 'N');
     $this->db->where('items.itemRowId', $this->input->post('itemRowId'));
     // $this->db->order_by('ledger.refDt, ledgerRowId');
     $query = $this->db->get();
     if ($query->num_rows() > 0)
     {
        $row = $query->row_array();
        $opBal = $row['openingBalance'];
     }

     // return $opBal;
     ///Purchase During this periaod
     $purchaseQty = 0;
     $this->db->select_Sum('qty');
     $this->db->from('purchasedetail');
     $this->db->join('purchase','purchase.purchaseRowId = purchasedetail.purchaseRowId');
     $this->db->where('purchase.deleted', 'N');
     $this->db->where('purchasedetail.itemRowId', $this->input->post('itemRowId'));
     $this->db->where('purchase.purchaseDt <', date('Y-m-d', strtotime($this->input->post('dtFrom'))));
     $query = $this->db->get();
     if ($query->num_rows() > 0)
     {
        $row = $query->row_array();
        $purchaseQty = $row['qty'];
     }

     ///Sale During this periaod (Invoice)
     $saleQty = 0;
     $this->db->select_Sum('qty');
     $this->db->from('dbdetail');
     $this->db->join('db','db.dbRowId = dbdetail.dbRowId');
     $this->db->where('db.deleted', 'N');
     $this->db->where('dbdetail.itemRowId', $this->input->post('itemRowId'));
     $this->db->where('db.dbDt <', date('Y-m-d', strtotime($this->input->post('dtFrom'))));
     $query = $this->db->get();
     if ($query->num_rows() > 0)
     {
        $row = $query->row_array();
        $saleQty = $row['qty'];
     }

     ///Cash Sale During this period
     $cashSaleQty = 0;
     $this->db->select_Sum('qty');
     $this->db->from('cashsale');
     // $this->db->join('db','db.dbRowId = dbdetail.dbRowId');
     // $this->db->where('db.deleted', 'N');
     $this->db->where('cashsale.itemRowId', $this->input->post('itemRowId'));
     $this->db->where('cashsale.dt <', date('Y-m-d', strtotime($this->input->post('dtFrom'))));
     $query = $this->db->get();
     if ($query->num_rows() > 0)
     {
        $row = $query->row_array();
        $cashSaleQty = $row['qty'];
     }

     $finalOpeningBalance = $opBal + $purchaseQty - $saleQty - $cashSaleQty;

     return $finalOpeningBalance;

    }

    public function getPurchase()
    {
    $this->db->select('purchasedetail.*, customers.customerName, purchase.purchaseDt');
     $this->db->from('purchasedetail');
     $this->db->join('purchase','purchase.purchaseRowId = purchasedetail.purchaseRowId');
     $this->db->join('customers','customers.customerRowId = purchase.customerRowId');
     $this->db->where('purchase.deleted', 'N');
     $this->db->where('purchasedetail.itemRowId', $this->input->post('itemRowId'));
     $this->db->where('purchase.purchaseDt <=', date('Y-m-d', strtotime($this->input->post('dtTo'))));
     $this->db->where('purchase.purchaseDt >=', date('Y-m-d', strtotime($this->input->post('dtFrom'))));
     $this->db->order_by('purchase.purchaseDt, purchaseRowId');
     $query = $this->db->get();
     return($query->result_array());
    }

    public function getSale()
    {
    $this->db->select('dbdetail.*, customers.customerName, db.dbDt');
     $this->db->from('dbdetail');
     $this->db->join('db','db.dbRowId = dbdetail.dbRowId');
     $this->db->join('customers','customers.customerRowId = db.customerRowId');
     $this->db->where('db.deleted', 'N');
     $this->db->where('dbdetail.itemRowId', $this->input->post('itemRowId'));
     $this->db->where('db.dbDt <=', date('Y-m-d', strtotime($this->input->post('dtTo'))));
     $this->db->where('db.dbDt >=', date('Y-m-d', strtotime($this->input->post('dtFrom'))));
     $this->db->order_by('db.dbDt, dbRowId');
     $query = $this->db->get();
     return($query->result_array());
    }

    public function getCashSale()
    {
     $this->db->select('cashsale.*');
     $this->db->from('cashsale');
     $this->db->where('cashsale.itemRowId', $this->input->post('itemRowId'));
     $this->db->where('cashsale.dt <=', date('Y-m-d', strtotime($this->input->post('dtTo'))));
     $this->db->where('cashsale.dt >=', date('Y-m-d', strtotime($this->input->post('dtFrom'))));
     $this->db->order_by('cashsale.dt, cashSaleRowId');
     $query = $this->db->get();
     return($query->result_array());
    }
}