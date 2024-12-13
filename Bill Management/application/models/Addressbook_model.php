<?php
class Addressbook_model extends CI_Model 
{
    public function __construct()
    {
            $this->load->database('');
    }

    public function getDataLimit()
	{
		$this->db->select('*');
		$this->db->where('deleted', 'N');
		$this->db->order_by('rowId desc');
		$this->db->limit(10);
		$query = $this->db->get('addressbook');

		return($query->result_array());
	}

    public function getDataAll()
	{
		$this->db->select('*');
		$this->db->where('deleted', 'N');
		$this->db->order_by('rowId');
		$query = $this->db->get('addressbook');

		return($query->result_array());
	}

    

	public function checkDuplicate()
    {
		$this->db->select('name');
		// $this->db->where('name', $this->input->post('name'));
		$this->db->where('mobile', $this->input->post('mobile'));
		$query = $this->db->get('addressbook');

		if ($query->num_rows() > 0)
		{
			return 1;
		}
    }

	public function insert()
    {
    	// echo "user model >> insertAjax";
		$this->db->select_max('rowId');
		$query = $this->db->get('addressbook');
        $row = $query->row_array();
        $current_row = $row['rowId'] + 1;
		$data = array(
	        'rowId' => $current_row
	        , 'name' => $this->input->post('name')
	        , 'hNo' => $this->input->post('hNo')
	        , 'locality' => $this->input->post('locality')
	        , 'occupation' => $this->input->post('occupation')
	        , 'telephone' => $this->input->post('telephone')
	        , 'mobile' => $this->input->post('mobile')
	        , 'remarks' => $this->input->post('remarks')
	        , 'createdBy' => $this->session->userRowId
		);
		$this->db->set('createdStamp', 'NOW()', FALSE);
		$this->db->insert('addressbook', $data);	
	}

	public function checkDuplicateOnUpdate()
    {
		$this->db->select('name');
		// $this->db->where('name', $this->input->post('name'));
		$this->db->where('mobile', $this->input->post('mobile'));
		$this->db->where('rowId !=', $this->input->post('globalrowid'));
		$query = $this->db->get('addressbook');

		if ($query->num_rows() > 0)
		{
			return 1;
		}
    }

	public function update()
    {

		$data = array(
	        'name' => $this->input->post('name')
	        , 'hNo' => $this->input->post('hNo')
	        , 'locality' => $this->input->post('locality')
	        , 'occupation' => $this->input->post('occupation')
	        , 'telephone' => $this->input->post('telephone')
	        , 'mobile' => $this->input->post('mobile')
	        , 'remarks' => $this->input->post('remarks')
	        // , 'showInDirectorySearch' => $this->input->post('showInDirectorySearch')
		);
		$this->db->where('rowId', $this->input->post('globalrowid'));
		$this->db->update('addressbook', $data);	
	}

	public function delete()
	{
		$data = array(
		        'deleted' => 'Y',
		        'deletedBy' => $this->session->userRowId

		);
		$this->db->set('deletedStamp', 'NOW()', FALSE);
		$this->db->where('rowId', $this->input->post('rowId'));
		$this->db->update('addressbook', $data);

		// $this->db->where('rowId', $this->input->post('rowId'));
		// $this->db->delete('addressbook');
	}

	// public function getPrefixes()
	// {
	// 	$this->db->select('rowId, itemName');
	// 	$this->db->where('deleted', 'N');
	// 	$this->db->order_by('itemName');
	// 	$query = $this->db->get('addressbook');

	// 	$arr = array();
	// 	$arr["-1"] = '--- Select ---';
	// 	foreach ($query->result_array() as $row)
	// 	{
 //    		$arr[$row['rowId']]= $row['itemName'];
	// 	}

	// 	return $arr;
	// }
}