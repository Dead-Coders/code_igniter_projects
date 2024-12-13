<?php
class Conclusions_model extends CI_Model 
{
    public function __construct()
    {
            $this->load->database('');
    }

    public function getDataLimit()
	{
		$this->db->select('*');
		$this->db->where('deleted', 'N');
		$this->db->order_by('conclusionRowId desc');
		$this->db->limit(50);
		$query = $this->db->get('conclusions');

		return($query->result_array());
	}

    public function getDataAll()
	{
		$this->db->select('*');
		$this->db->where('deleted', 'N');
		$this->db->order_by('conclusionRowId desc');
		$query = $this->db->get('conclusions');

		return($query->result_array());
	}

    

	public function checkDuplicate()
    {
		$this->db->select('conclusion');
		$this->db->where('conclusion', $this->input->post('conclusion'));
		$query = $this->db->get('conclusions');

		if ($query->num_rows() > 0)
		{
			return 1;
		}
    }

	public function insert()
    {
		$this->db->select_max('conclusionRowId');
		$query = $this->db->get('conclusions');
        $row = $query->row_array();

        $current_row = $row['conclusionRowId']+1;

		$data = array(
	        'conclusionRowId' => $current_row
	        , 'context' => ucwords($this->input->post('context'))
	        , 'conclusion' => $this->input->post('conclusion')
	        , 'createdBy' => $this->session->userRowId
		);
		$this->db->set('createdStamp', 'NOW()', FALSE);
		$this->db->insert('conclusions', $data);	
	}

	public function checkDuplicateOnUpdate()
    {
    	// echo "chk";
		$this->db->select('conclusion');
		$this->db->where('conclusion', $this->input->post('conclusion'));
		$this->db->where('conclusionRowId !=', $this->input->post('globalrowid'));
		$query = $this->db->get('conclusions');

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
			'context' => ucwords($this->input->post('context'))
	        , 'conclusion' => ($this->input->post('conclusion'))
		);
		$this->db->where('conclusionRowId', $this->input->post('globalrowid'));
		$this->db->update('conclusions', $data);	

		$this->db->trans_complete();		
	}

	public function delete()
	{
		$data = array(
		        'deleted' => 'Y',
		        'deletedBy' => $this->session->userRowId

		);
		$this->db->set('deletedStamp', 'NOW()', FALSE);
		$this->db->where('conclusionRowId', $this->input->post('rowId'));
		$this->db->update('conclusions', $data);

		// $this->db->where('conclusionRowId', $this->input->post('rowId'));
		// $this->db->delete('conclusions');
	}

}