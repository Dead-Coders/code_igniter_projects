<?php
class Dates_model extends CI_Model 
{
    public function __construct()
    {
            $this->load->database('');
    }

    public function getDataLimit()
	{
		$this->db->select('*');
		$this->db->where('deleted', 'N');
		$this->db->order_by('dateRowId desc');
		$this->db->limit(5);
		$query = $this->db->get('dates');

		return($query->result_array());
	}

    public function getDataAll()
	{
		$this->db->select('*');
		$this->db->where('deleted', 'N');
		$this->db->order_by('dateRowId');
		$query = $this->db->get('dates');

		return($query->result_array());
	}

    

	public function checkDuplicate()
    {
		$this->db->select('remarks');
		$this->db->where('remarks', $this->input->post('remarks'));
		$query = $this->db->get('dates');

		if ($query->num_rows() > 0)
		{
			return 1;
		}
    }

	public function insert()
    {
    	$dt = date('Y-m-d', strtotime($this->input->post('dt')));
		$this->db->select_max('dateRowId');
		$query = $this->db->get('dates');
        $row = $query->row_array();

        $current_row = $row['dateRowId']+1;

		$data = array(
	        'dateRowId' => $current_row
	        , 'dt' => $dt
	        , 'remarks' => $this->input->post('remarks')
	        , 'createdBy' => $this->session->userRowId
		);
		$this->db->set('createdStamp', 'NOW()', FALSE);
		$this->db->insert('dates', $data);	
	}

	public function checkDuplicateOnUpdate()
    {
    	// echo "chk";
		$this->db->select('remarks');
		$this->db->where('remarks', $this->input->post('remarks'));
		$this->db->where('dateRowId !=', $this->input->post('globalrowid'));
		$query = $this->db->get('dates');

		if ($query->num_rows() > 0)
		{
			return 1;
		}
    }

	public function update()
    {
    	$dt = date('Y-m-d', strtotime($this->input->post('dt')));
		$data = array(
	        'dt' => $dt
	        , 'remarks' => $this->input->post('remarks')
		);
		$this->db->where('dateRowId', $this->input->post('globalrowid'));
		$this->db->update('dates', $data);			
	}

	public function delete()
	{
		$data = array(
		        'deleted' => 'Y',
		        'deletedBy' => $this->session->userRowId

		);
		$this->db->set('deletedStamp', 'NOW()', FALSE);
		$this->db->where('dateRowId', $this->input->post('rowId'));
		$this->db->update('dates', $data);

	}

}