<?php
class Stageitems_model extends CI_Model 
{
    public function __construct()
    {
            $this->load->database('');
    }

    public function getDataLimit()
	{
		$this->db->select('stageitems.*, stages.stageName');
		$this->db->where('stageitems.deleted', 'N');
		$this->db->join('stages', 'stages.stageRowId=stageitems.stageRowId');
		$this->db->order_by('stageitems.stageItemRowId');
		// $this->db->limit(5);
		$query = $this->db->get('stageitems');

		return($query->result_array());
	}

 //    public function getDataAll()
	// {
	// 	$this->db->select('stageitems.*, stages.stageName');
	// 	$this->db->where('stageitems.deleted', 'N');
	// 	$this->db->order_by('stageitems.stageItemRowId');
	// 	$query = $this->db->get('stageitems');

	// 	return($query->result_array());
	// }

	public function getStages()
    {
        $this->db->select('stages.*');
        $this->db->where('deleted', 'N');
        $this->db->order_by('stageName');
        $query = $this->db->get('stages');
        // return($query->result_array());
        $arr = array();
        $arr["-1"] = '--- Select ---';
        foreach ($query->result_array() as $row)
        {
            $arr[$row['stageRowId']]= $row['stageName'];
        }

        return $arr;
    }
    

	public function checkDuplicate()
    {
		$this->db->select('stageItemName');
		$this->db->where('stageItemName', $this->input->post('stageItemName'));
		$query = $this->db->get('stageitems');

		if ($query->num_rows() > 0)
		{
			return 1;
		}
    }

	public function insert()
    {
		$this->db->select_max('stageItemRowId');
		$query = $this->db->get('stageitems');
        $row = $query->row_array();

        $current_row = $row['stageItemRowId']+1;

		$data = array(
	        'stageItemRowId' => $current_row
	        , 'stageRowId' => $this->input->post('stageRowId')
	        , 'stageItemName' => ucwords($this->input->post('stageItemName'))
	        , 'createdBy' => $this->session->userRowId
		);
		$this->db->set('createdStamp', 'NOW()', FALSE);
		$this->db->insert('stageitems', $data);	
	}

	public function checkDuplicateOnUpdate()
    {
    	// echo "chk";
		$this->db->select('stageItemName');
		$this->db->where('stageItemName', $this->input->post('stageItemName'));
		$this->db->where('stageItemRowId !=', $this->input->post('globalrowid'));
		$query = $this->db->get('stageitems');

		if ($query->num_rows() > 0)
		{
			return 1;
		}
    }

	public function update()
    {
		$data = array(
			 'stageRowId' => $this->input->post('stageRowId')
	        ,'stageItemName' => ucwords($this->input->post('stageItemName'))
		);
		$this->db->where('stageItemRowId', $this->input->post('globalrowid'));
		$this->db->update('stageitems', $data);			
	}

	public function delete()
	{
		$data = array(
		        'deleted' => 'Y',
		        'deletedBy' => $this->session->userRowId

		);
		$this->db->set('deletedStamp', 'NOW()', FALSE);
		$this->db->where('stageItemRowId', $this->input->post('rowId'));
		$this->db->update('stageitems', $data);

	}

	// public function getPrefixes()
	// {
	// 	$this->db->select('stageItemRowId, stageItemName');
	// 	$this->db->where('deleted', 'N');
	// 	$this->db->order_by('stageItemName');
	// 	$query = $this->db->get('stageitems');

	// 	$arr = array();
	// 	$arr["-1"] = '--- Select ---';
	// 	foreach ($query->result_array() as $row)
	// 	{
 //    		$arr[$row['stageItemRowId']]= $row['stageItemName'];
	// 	}

	// 	return $arr;
	// }
}