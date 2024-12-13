<?php
class Rptitemspurchaseandsold_model extends CI_Model 
{
    public function __construct()
    {
            $this->load->database('');
    }


    public function getDataForReportSale()
    {
         $this->db->select('dbdetail.*, customers.customerName, db.dbDt');
         $this->db->from('dbdetail');
         $this->db->join('db','db.dbRowId = dbdetail.dbRowId');
         $this->db->join('customers','customers.customerRowId = db.customerRowId');
         $this->db->where('db.dbDt <=', date('Y-m-d', strtotime($this->input->post('dtTo'))));
         $this->db->where('db.dbDt >=', date('Y-m-d', strtotime($this->input->post('dtFrom'))));
         $this->db->where('db.deleted', 'N');

         $this->db->group_start();
             $this->db->like('dbdetail.itemName', $this->input->post('searchWhat'));
             $this->db->or_like('customers.customerName', $this->input->post('searchWhat'));
         $this->db->group_end();         
         $this->db->order_by('dbdetail.dbRowId, dbdetail.dbdRowId');
         $query = $this->db->get();
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

         $this->db->group_start();
             $this->db->like('purchasedetail.itemName', $this->input->post('searchWhat'));
             $this->db->or_like('customers.customerName', $this->input->post('searchWhat'));
         $this->db->group_end();
         $this->db->order_by('purchasedetail.purchaseRowId, purchasedetail.purchaseDetailRowId');
         $query = $this->db->get();
         return($query->result_array());
    }


    public function getDataForReportQuotation()
    {
         $this->db->select('quotationdetail.*, customers.customerName, quotation.quotationDt');
         $this->db->from('quotationdetail');
         $this->db->join('quotation','quotation.quotationRowId = quotationdetail.quotationRowId');
         $this->db->join('customers','customers.customerRowId = quotation.customerRowId');
         $this->db->where('quotation.quotationDt <=', date('Y-m-d', strtotime($this->input->post('dtTo'))));
         $this->db->where('quotation.quotationDt >=', date('Y-m-d', strtotime($this->input->post('dtFrom'))));
         $this->db->where('quotation.deleted', 'N');

         $this->db->group_start();
             $this->db->like('quotationdetail.itemName', $this->input->post('searchWhat'));
             $this->db->or_like('customers.customerName', $this->input->post('searchWhat'));
         $this->db->group_end();         
         $this->db->order_by('quotationdetail.quotationRowId, quotationdetail.quotationDetailRowId');
         $query = $this->db->get();
         return($query->result_array());
    }


    public function getDataForReportCashSale()
    {
         $this->db->select('cashsale.*');
         $this->db->from('cashsale');
         $this->db->where('cashsale.dt <=', date('Y-m-d', strtotime($this->input->post('dtTo'))));
         $this->db->where('cashsale.dt >=', date('Y-m-d', strtotime($this->input->post('dtFrom'))));

         $this->db->group_start();
             $this->db->like('cashsale.itemName', $this->input->post('searchWhat'));
             // $this->db->or_like('customers.customerName', $this->input->post('searchWhat'));
         $this->db->group_end();         
         $this->db->order_by('cashsale.cashSaleRowId');
         $query = $this->db->get();
         return($query->result_array());
    }

    // public function getProducts()
    // {
    //     $this->db->select('dbdetail.*');
    //     $this->db->where('dbdetail.dbRowId', $this->input->post('rowid'));
    //     $this->db->from('dbdetail');
    //     $this->db->order_by('dbdRowId');
    //     $query = $this->db->get();
    //     return($query->result_array());

    // }
}