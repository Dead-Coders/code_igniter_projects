<?php
class Rptcollection_model extends CI_Model 
{
    public function __construct()
    {
            $this->load->database('');
    }


    public function getPurchase()
    {
     $this->db->select_Sum('netAmt');
     $this->db->select('purchaseDt');
     $this->db->from('purchase');
     $this->db->where('purchase.deleted', 'N');
     $this->db->where('purchase.purchaseDt <=', date('Y-m-d', strtotime($this->input->post('dtTo'))));
     $this->db->where('purchase.purchaseDt >=', date('Y-m-d', strtotime($this->input->post('dtFrom'))));
     $this->db->group_by('purchase.purchaseDt');
     $this->db->order_by('purchase.purchaseDt');
     $query = $this->db->get();
     return($query->result_array());
    }

    public function getSale()
    {
     $this->db->select_Sum('netAmt');
     $this->db->select('dbDt');
     $this->db->from('db');
     $this->db->where('db.deleted', 'N');
     $this->db->where('db.dbDt <=', date('Y-m-d', strtotime($this->input->post('dtTo'))));
     $this->db->where('db.dbDt >=', date('Y-m-d', strtotime($this->input->post('dtFrom'))));
     $this->db->group_by('db.dbDt');
     $this->db->order_by('db.dbDt');
     $query = $this->db->get();
     return($query->result_array());
    }

    public function getQuotation()
    {
     $this->db->select_Sum('totalAmount');
     $this->db->select('quotationDt');
     $this->db->from('quotation');
     $this->db->where('quotation.deleted', 'N');
     $this->db->where('quotation.quotationDt <=', date('Y-m-d', strtotime($this->input->post('dtTo'))));
     $this->db->where('quotation.quotationDt >=', date('Y-m-d', strtotime($this->input->post('dtFrom'))));
     $this->db->group_by('quotation.quotationDt');
     $this->db->order_by('quotation.quotationDt');
     $query = $this->db->get();
     return($query->result_array());
    }  

    public function getCashSaleCollection()
    {
     $this->db->select_Sum('amt');
     $this->db->select('dt');
     $this->db->from('cashsale');
     $this->db->where('mode', 'C');
     $this->db->where('cashsale.dt <=', date('Y-m-d', strtotime($this->input->post('dtTo'))));
     $this->db->where('cashsale.dt >=', date('Y-m-d', strtotime($this->input->post('dtFrom'))));
     $this->db->group_by('cashsale.dt');
     $this->db->order_by('cashsale.dt');
     $query = $this->db->get();
     return($query->result_array());
    }  

    public function getCashSaleExp()
    {
     $this->db->select_Sum('amt');
     $this->db->select('dt');
     $this->db->from('cashsale');
     $this->db->where('mode', 'E');
     $this->db->where('cashsale.dt <=', date('Y-m-d', strtotime($this->input->post('dtTo'))));
     $this->db->where('cashsale.dt >=', date('Y-m-d', strtotime($this->input->post('dtFrom'))));
     $this->db->group_by('cashsale.dt');
     $this->db->order_by('cashsale.dt');
     $query = $this->db->get();
     return($query->result_array());
    }  
}