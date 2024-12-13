<?php
class Items_model extends CI_Model 
{
    public function __construct()
    {
            $this->load->database('');
    }

    public function getDataLimit()
	{
		$this->db->select('*');
		$this->db->where('deleted', 'N');
		$this->db->order_by('itemRowId desc');
		// $this->db->limit(5);
		$query = $this->db->get('items');

		return($query->result_array());
	}

    public function getDataAll()
	{
		$this->db->select('*');
		$this->db->where('deleted', 'N');
		$this->db->order_by('itemRowId');
		$query = $this->db->get('items');

		return($query->result_array());
	}

    

	public function checkDuplicate()
    {
		$this->db->select('itemName');
		$this->db->where('itemName', $this->input->post('itemName'));
		$query = $this->db->get('items');

		if ($query->num_rows() > 0)
		{
			return 1;
		}
    }

	public function insert()
    {
		$this->db->select_max('itemRowId');
		$query = $this->db->get('items');
        $row = $query->row_array();

        $current_row = $row['itemRowId']+1;

		$data = array(
	        'itemRowId' => $current_row
	        , 'itemName' => ucwords($this->input->post('itemName'))
	        , 'sellingPrice' => $this->input->post('sellingPrice')
	        , 'createdBy' => $this->session->userRowId
		);
		$this->db->set('createdStamp', 'NOW()', FALSE);
		$this->db->insert('items', $data);	
	}

	public function checkDuplicateOnUpdate()
    {
    	// echo "chk";
		$this->db->select('itemName');
		$this->db->where('itemName', $this->input->post('itemName'));
		$this->db->where('itemRowId !=', $this->input->post('globalrowid'));
		$query = $this->db->get('items');

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
	        'itemName' => ucwords($this->input->post('itemName'))
	        , 'sellingPrice' => $this->input->post('sellingPrice')
		);
		$this->db->where('itemRowId', $this->input->post('globalrowid'));
		$this->db->update('items', $data);	

		$data = array(
	        'itemName' => ucwords($this->input->post('itemName'))	      
		);
		$this->db->where('itemRowId', $this->input->post('globalrowid'));
		$this->db->update('orderdetail', $data);	


		$data = array(
	        'itemName' => ucwords($this->input->post('itemName'))	      
		);
		$this->db->where('itemRowId', $this->input->post('globalrowid'));
		$this->db->update('purchasedetail', $data);	

		$data = array(
	        'itemName' => ucwords($this->input->post('itemName'))	      
		);
		$this->db->where('itemRowId', $this->input->post('globalrowid'));
		$this->db->update('quotationdetail', $data);	

		$data = array(
	        'itemName' => ucwords($this->input->post('itemName'))	      
		);
		$this->db->where('itemRowId', $this->input->post('globalrowid'));
		$this->db->update('dbdetail', $data);	

		$data = array(
	        'itemName' => ucwords($this->input->post('itemName'))	      
		);
		$this->db->where('itemRowId', $this->input->post('globalrowid'));
		$this->db->update('cashsale', $data);	

		$this->db->trans_complete();		
	}

	public function delete()
	{
		$data = array(
		        'deleted' => 'Y',
		        'deletedBy' => $this->session->userRowId

		);
		$this->db->set('deletedStamp', 'NOW()', FALSE);
		$this->db->where('itemRowId', $this->input->post('rowId'));
		$this->db->update('items', $data);

		// $this->db->where('itemRowId', $this->input->post('rowId'));
		// $this->db->delete('items');
	}

	// public function getPrefixes()
	// {
	// 	$this->db->select('itemRowId, itemName');
	// 	$this->db->where('deleted', 'N');
	// 	$this->db->order_by('itemName');
	// 	$query = $this->db->get('items');

	// 	$arr = array();
	// 	$arr["-1"] = '--- Select ---';
	// 	foreach ($query->result_array() as $row)
	// 	{
 //    		$arr[$row['itemRowId']]= $row['itemName'];
	// 	}

	// 	return $arr;
	// }
}