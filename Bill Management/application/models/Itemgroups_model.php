<?php
class Itemgroups_model extends CI_Model 
{
    public function __construct()
    {
            $this->load->database('');
    }

    
    public function getDataAll()
	{
		$this->db->select('*');
		$this->db->where('deleted', 'N');
		$this->db->order_by('itemGroupRowId desc');
		$query = $this->db->get('itemgroups');

		return($query->result_array());
	}

    

	public function checkDuplicateEtc()
    {
    	if(strlen(trim($this->input->post('itemGroupName')))==0)
    	{
    		return 1;
    	}
    	if(strlen(trim($this->input->post('itemGroupName')))>20)
    	{
    		return 1;
    	}

		$this->db->select('itemGroupName');
		$this->db->where('itemGroupName', $this->input->post('itemGroupName'));
		$query = $this->db->get('itemgroups');

		if ($query->num_rows() > 0)
		{
			return 1;
		}
    }

	public function insert()
    {
		$this->db->select_max('itemGroupRowId');
		$query = $this->db->get('itemgroups');
        $row = $query->row_array();

        $current_row = $row['itemGroupRowId']+1;

		$data = array(
	        'itemGroupRowId' => $current_row
	        , 'itemGroupName' => ucwords($this->input->post('itemGroupName'))
		);
		$this->db->insert('itemgroups', $data);	
	}

	public function checkDuplicateOnUpdate()
    {
    	// echo "chk";
		$this->db->select('itemGroupName');
		$this->db->where('itemGroupName', $this->input->post('itemGroupName'));
		$this->db->where('itemGroupRowId !=', $this->input->post('globalrowid'));
		$query = $this->db->get('itemgroups');

		if ($query->num_rows() > 0)
		{
			return 1;
		}
    }

	public function update()
    {
    	set_time_limit(0);
        $this->db->trans_start();

		$data = array(
	        'itemGroupName' => ucwords($this->input->post('itemGroupName'))
		);
		$this->db->where('itemGroupRowId', $this->input->post('globalrowid'));
		$this->db->update('itemgroups', $data);	

		$this->db->trans_complete();		
	}

	public function delete()
	{
		$data = array(
		        'deleted' => 'Y',
		);
		$this->db->where('itemGroupRowId', $this->input->post('rowId'));
		$this->db->update('itemgroups', $data);
	}
}