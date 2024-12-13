<?php
class Todo_model extends CI_Model 
{
    public function __construct()
    {
            $this->load->database('');
    }

    public function getDataLimit()
	{
		$this->db->select('*');
		// $this->db->where('deleted', 'N');
		$this->db->order_by('toDoRowId desc');
		$this->db->limit(50);
		$query = $this->db->get('todo');

		return($query->result_array());
	}

    public function getDataAll()
	{
		$this->db->select('*');
		// $this->db->where('deleted', 'N');
		$this->db->order_by('toDoRowId desc');
		$query = $this->db->get('todo');

		return($query->result_array());
	}

    

	public function checkDuplicate()
    {
		$this->db->select('toDoName');
		$this->db->where('toDoName', $this->input->post('toDoName'));
		$query = $this->db->get('todo');

		if ($query->num_rows() > 0)
		{
			return 1;
		}
    }

	public function insert()
    {
		$this->db->select_max('toDoRowId');
		$query = $this->db->get('todo');
        $row = $query->row_array();

        $current_row = $row['toDoRowId']+1;

		$data = array(
	        'toDoRowId' => $current_row
	        , 'toDoName' => ucwords($this->input->post('toDoName'))
	        , 'createdBy' => $this->session->userRowId
		);
		$this->db->set('createdStamp', 'NOW()', FALSE);
		$this->db->insert('todo', $data);	
	}

	public function checkDuplicateOnUpdate()
    {
    	// echo "chk";
		$this->db->select('toDoName');
		$this->db->where('toDoName', $this->input->post('toDoName'));
		$this->db->where('toDoRowId !=', $this->input->post('globalrowid'));
		$query = $this->db->get('todo');

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
	        'toDoName' => ucwords($this->input->post('toDoName'))
		);
		$this->db->where('toDoRowId', $this->input->post('globalrowid'));
		$this->db->update('todo', $data);	

		$this->db->trans_complete();		
	}

	public function delete()
	{
		$data = array(
		        'deleted' => 'Y',
		        'deletedBy' => $this->session->userRowId

		);
		$this->db->set('deletedStamp', 'NOW()', FALSE);
		$this->db->where('toDoRowId', $this->input->post('rowId'));
		$this->db->update('todo', $data);

		// $this->db->where('toDoRowId', $this->input->post('rowId'));
		// $this->db->delete('todo');
	}

}