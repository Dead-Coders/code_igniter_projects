<?php
class Rptsale_model extends CI_Model 
{
    public function __construct()
    {
            $this->load->database('');
    }

   
    
    public function getDataForReport()
    {
         $this->db->select('db.*, customers.customerName');
         $this->db->from('db');
         $this->db->join('customers','customers.customerRowId = db.customerRowId');
         $this->db->where('db.dbDt <=', date('Y-m-d', strtotime($this->input->post('dtTo'))));
         $this->db->where('db.dbDt >=', date('Y-m-d', strtotime($this->input->post('dtFrom'))));
         $this->db->where('db.deleted', 'N');
         $this->db->order_by('db.dbRowId');
         $query = $this->db->get();
         return($query->result_array());
    }



    public function getProducts()
    {
        $this->db->select('dbdetail.*');
        $this->db->where('dbdetail.dbRowId', $this->input->post('rowid'));
        $this->db->from('dbdetail');
        $this->db->order_by('dbdRowId');
        $query = $this->db->get();
        return($query->result_array());

    }
}