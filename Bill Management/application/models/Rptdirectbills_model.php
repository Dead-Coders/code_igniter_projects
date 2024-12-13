<?php
class Rptdirectbills_model extends CI_Model 
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
        $arr = array();
        $arr["-1"] = '--- ALL ---';
        foreach ($query->result_array() as $row)
        {
            $arr[$row['customerRowId']]= $row['customerName'];
        }
        return $arr;
    }

    public function getDataForReport()
    {
        if( $this->input->post('customerRowId') == "-1")
        {
            $this->db->select('db.*, customers.customerName');
            $this->db->where('db.deleted', 'N');
            $this->db->where('db.dbDt <=', date('Y-m-d', strtotime($this->input->post('dtTo'))));
            $this->db->where('db.dbDt >=', date('Y-m-d', strtotime($this->input->post('dtFrom'))));
            // $this->db->where('orders.deleted', 'N');
            $this->db->join('customers','customers.customerRowId = db.customerRowId');
            $this->db->order_by('dbRowId');
            $query = $this->db->get('db');

            return($query->result_array());
        }
        else
        {
            $this->db->select('db.*, customers.customerName');
            $this->db->where('db.deleted', 'N');
            $this->db->where('db.dbDt <=', date('Y-m-d', strtotime($this->input->post('dtTo'))));
            $this->db->where('db.dbDt >=', date('Y-m-d', strtotime($this->input->post('dtFrom'))));
            $this->db->where('db.customerRowId', $this->input->post('customerRowId'));
            $this->db->join('customers','customers.customerRowId = db.customerRowId');
            $this->db->order_by('db.dbRowId');
            $query = $this->db->get('db');

            return($query->result_array());
            
        }
    }

    public function showDetail()
    {
        $this->db->select('dbdetail.*');
        $this->db->where('dbRowId', $this->input->post('dbRowId'));
        $this->db->order_by('dbdRowId');
        $query = $this->db->get('dbdetail');

        return($query->result_array());
    }
}