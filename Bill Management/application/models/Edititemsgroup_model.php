<?php
class Edititemsgroup_model extends CI_Model 
{
    public function __construct()
    {
            $this->load->database('');
    }

    public function getItemGroups()
    {
        $this->db->select('itemgroups.*');
        $this->db->where('deleted', 'N');
        $this->db->order_by('itemGroupName');
        $query = $this->db->get('itemgroups');
        return($query->result_array());
    }

    public function getItemGroupsForTable()
    {
        $this->db->select('itemgroups.*');
        $this->db->where('deleted', 'N');
        $this->db->order_by('itemGroupName');
        $query = $this->db->get('itemgroups');
        return($query->result_array());
    }

    public function getDataForReport()
    {
        $this->db->select('items.*, itemGroupName');            
        $this->db->join('itemgroups','itemgroups.itemGroupRowId = items.itemGroupRowId');
        $this->db->from('items');
        if( $this->input->post('itemGroupRowId') == "-1" )
        {

        }
        else
        {
            $this->db->where('items.itemGroupRowId', $this->input->post('itemGroupRowId'));
        }
        $this->db->where('items.deleted', 'N');
        $this->db->order_by('itemName');
        // $this->db->limit(15);
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
                'itemGroupRowId' => $TableData[$i]['itemGroupRowId']
            );
            $this->db->where('itemRowId', $TableData[$i]['itemRowId']);
            $this->db->update('items', $data);
        }
            

        $this->db->trans_complete();
    }

    
    
}