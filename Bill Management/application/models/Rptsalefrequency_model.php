<?php
class Rptsalefrequency_model extends CI_Model 
{
    public function __construct()
    {
            $this->load->database('');
    }


    public function getDataForReport()
    {
        $dtTo = date('Y-m-d', strtotime($this->input->post('dtTo')));
        $dtFrom = date('Y-m-d', strtotime($this->input->post('dtFrom')));
        $q = "Select sum(dbdetail.qty) as qty,dbdetail.itemRowId, dbdetail.itemName from dbdetail, db where db.dbRowId = dbdetail.dbRowId AND db.dbDt <='". $dtTo ."' AND db.dbDt >='". $dtFrom ."' AND db.deleted='N' GROUP BY dbdetail.itemRowId, dbdetail.itemName 
        UNION 
            Select sum(cashsale.qty) as qty,cashsale.itemRowId, cashsale.itemName from cashsale where cashsale.dt <='". $dtTo ."' AND cashsale.dt >='". $dtFrom ."' GROUP BY cashsale.itemRowId, cashsale.itemName order by itemName";

        $query = $this->db->query($q);
        return($query->result_array());

        // $this->db->select_sum('dbdetail.qty');
        //  $this->db->select('dbdetail.itemRowId, dbdetail.itemName');
        //  $this->db->from('dbdetail');
        //  $this->db->join('db','db.dbRowId = dbdetail.dbRowId');
        //  $this->db->where('db.dbDt <=', date('Y-m-d', strtotime($this->input->post('dtTo'))));
        //  $this->db->where('db.dbDt >=', date('Y-m-d', strtotime($this->input->post('dtFrom'))));
        //  $this->db->where('db.deleted', 'N');
        //  $this->db->group_by('dbdetail.itemRowId, dbdetail.itemName');
        //  $this->db->order_by('dbdetail.itemName');
        //  $query = $this->db->get();
        //  return($query->result_array());
    }

    // public function getDataForReportCashSale()
    // {
    //      $this->db->select('cashsale.*');
    //      $this->db->from('cashsale');
    //      $this->db->where('cashsale.dt <=', date('Y-m-d', strtotime($this->input->post('dtTo'))));
    //      $this->db->where('cashsale.dt >=', date('Y-m-d', strtotime($this->input->post('dtFrom'))));
    //      $this->db->order_by('cashsale.cashSaleRowId');
    //      $query = $this->db->get();
    //      return($query->result_array());
    // }

}