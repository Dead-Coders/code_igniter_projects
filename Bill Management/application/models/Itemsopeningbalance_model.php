<?php
class Itemsopeningbalance_model extends CI_Model 
{
    public function __construct()
    {
            $this->load->database('');
    }

    public function getDataForReport()
    {
        $this->db->select('items.*');
        $this->db->from('items');
        $this->db->where('items.deleted', 'N');
        $this->db->order_by('itemName');
        $query = $this->db->get();
        return($query->result_array());
    }

    public function insert()
    {
        set_time_limit(0);
        $this->db->trans_start();

        $TableData = $this->input->post('TableData');
        $TableData = stripcslashes($TableData);
        $TableData = json_decode($TableData,TRUE);
        $myTableRows = count($TableData);


        for ($i=0; $i < $myTableRows; $i++) 
        {
            $data = array(
                'itemName' => $TableData[$i]['itemName']
                , 'openingBalance' => (float)$TableData[$i]['openingBalance']
            );
            $this->db->where('itemRowId', $TableData[$i]['itemRowId']);
            $this->db->update('items', $data);
        }

        $this->db->trans_complete();
    }

}