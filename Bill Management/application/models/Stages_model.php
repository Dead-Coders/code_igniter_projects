<?php
class Stages_model extends CI_Model 
{
    public function __construct()
    {
            $this->load->database('');
    }

    public function getDataLimit()
	{
		$this->db->select('*');
		$this->db->where('deleted', 'N');
		$this->db->order_by('stageRowId desc');
		$this->db->limit(5);
		$query = $this->db->get('stages');

		return($query->result_array());
	}

    public function getDataAll()
	{
		$this->db->select('*');
		$this->db->where('deleted', 'N');
		$this->db->order_by('stageRowId');
		$query = $this->db->get('stages');

		return($query->result_array());
	}

    

	public function checkDuplicate()
    {
		$this->db->select('stageName');
		$this->db->where('stageName', $this->input->post('stageName'));
		$query = $this->db->get('stages');

		if ($query->num_rows() > 0)
		{
			return 1;
		}
    }

	public function insert()
    {
		$this->db->select_max('stageRowId');
		$query = $this->db->get('stages');
        $row = $query->row_array();

        $current_row = $row['stageRowId']+1;

		$data = array(
	        'stageRowId' => $current_row
	        , 'stageName' => ucwords($this->input->post('stageName'))
	        , 'createdBy' => $this->session->userRowId
		);
		$this->db->set('createdStamp', 'NOW()', FALSE);
		$this->db->insert('stages', $data);	
	}

	public function checkDuplicateOnUpdate()
    {
    	// echo "chk";
		$this->db->select('stageName');
		$this->db->where('stageName', $this->input->post('stageName'));
		$this->db->where('stageRowId !=', $this->input->post('globalrowid'));
		$query = $this->db->get('stages');

		if ($query->num_rows() > 0)
		{
			return 1;
		}
    }

	public function update()
    {
		$data = array(
	        'stageName' => ucwords($this->input->post('stageName'))
		);
		$this->db->where('stageRowId', $this->input->post('globalrowid'));
		$this->db->update('stages', $data);			
	}

	public function delete()
	{
		$data = array(
		        'deleted' => 'Y',
		        'deletedBy' => $this->session->userRowId

		);
		$this->db->set('deletedStamp', 'NOW()', FALSE);
		$this->db->where('stageRowId', $this->input->post('rowId'));
		$this->db->update('stages', $data);

	}

	// public function getPrefixes()
	// {
	// 	$this->db->select('stageRowId, stageName');
	// 	$this->db->where('deleted', 'N');
	// 	$this->db->order_by('stageName');
	// 	$query = $this->db->get('stages');

	// 	$arr = array();
	// 	$arr["-1"] = '--- Select ---';
	// 	foreach ($query->result_array() as $row)
	// 	{
 //    		$arr[$row['stageRowId']]= $row['stageName'];
	// 	}

	// 	return $arr;
	// }
}