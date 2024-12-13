<?php
class Recharge_model extends CI_Model 
{
    public function __construct()
    {
            $this->load->database('');
    }

    public function getPuraneNo()
    {
    	$this->db->distinct();
        $this->db->select('recharge.id');
        $this->db->where('deleted', 'N');
        $this->db->order_by('id');
        $query = $this->db->get('recharge');

        return($query->result_array());
    }   
    public function getTagList()
    {
        $this->db->distinct();
        $this->db->select('recharge.tag, recharge.device, recharge.op, recharge.id');
        $this->db->where('deleted', 'N');
        $this->db->where('tag !=', '-');
        $this->db->where('tag IS NOT NULL');
        $this->db->where('length(tag)>', 0);
        $this->db->order_by('tag');
        $query = $this->db->get('recharge');

        return($query->result_array());
    }   

    public function getDataLimit()
	{
		$this->db->select('*');
		$this->db->where('deleted', 'N');
		$this->db->order_by('rechargeRowId desc');
		$this->db->limit(5);
		$query = $this->db->get('recharge');

		return($query->result_array());
	}

    public function getDataAll()
	{
		$this->db->select('*');
		$this->db->where('deleted', 'N');
		$this->db->order_by('rechargeRowId desc');
		$query = $this->db->get('recharge');

		return($query->result_array());
	}

    
 
    public function getRowId()
    {
		$this->db->select_max('rechargeRowId');
		$query = $this->db->get('recharge');
		if ($query->num_rows() > 0)
		{
			$row = $query->row_array();
		    $current_row = $row['rechargeRowId'];
		    return $current_row;
		}
	}

	public function insert()
    {
		$this->db->select_max('rechargeRowId');
		$query = $this->db->get('recharge');
        $row = $query->row_array();

        $current_row = $row['rechargeRowId']+1;

		$data = array(
	        'rechargeRowId' => $current_row
	        , 'device' => $this->input->post('device')
	        , 'op' => $this->input->post('op')
	        , 'opName' => $this->input->post('opName')
	        , 'id' => $this->input->post('deviceId')
	        , 'amt' => $this->input->post('amt')
	        , 'previousBalance' => (float)$this->input->post('previousBalance')
	        , 'tag' => $this->input->post('tag')
	        , 'createdBy' => $this->session->userRowId
		);
		$this->db->set('createdStamp', 'NOW()', FALSE);
		$this->db->insert('recharge', $data);	
	}



	public function updateStatus($status)
	{
		$data = array(
		        'status' => $status
		);
		$this->db->where('rechargeRowId', $this->input->post('rowId'));
// 		$this->db->where('rechargeRowId', 1);
		$this->db->update('recharge', $data);
	}


	public function getDefinedRechargeValues()
	{
		$this->db->select('organisation.*');
		$this->db->from('organisation');
		$query = $this->db->get();
		return($query->result_array());
	}
}