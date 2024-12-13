<?php
class User_model extends CI_Model {

    public function __construct()
    {
    	$this->load->library('encryption');
        $this->load->database('');
        $this->load->model('Loghash_model');
    }
    public function checkDuplicate()
    {
    	// echo "chk";
			$this->db->select('uid');
			$this->db->where('uid', $this->input->post('uid'));
			$query = $this->db->get('users');

			if ($query->num_rows() > 0)
			{
				return 1;
			}

		// $this->db->select('rowid');
		// $this->db->where('uid', $this->input->post('uid'));
		// $query = $this->db->get('users');

		// if ($query->num_rows() > 0)
		// {
		// 	$row = $query->row();
		// 	return $row->rowid;
		// }
		// return -1;
    }
    public function insertAjax()
    {
    	// echo "user model >> insertAjax";
		$this->db->select_max('rowid');
		$query = $this->db->get('users');
        $row = $query->row_array();

        $current_row = $row['rowid']+1;
				
		// $this->load->helper('date');
		// $datetime = unix_to_human(now('asia/kolkata'));
    	$uid  = $this->input->post('uid');
    	$pwd  = $this->input->post('password');

    	$pwd  = $this->Loghash_model->create_hash($pwd);

		$data = array(
	        'rowid' => $current_row,
	        'uid' => $uid,
	        // 'mobile' => $this->input->post('mobile'),
	        'pwd' => $pwd,
	        // 'abAccess' => $this->input->post('abAccess'),
	        'createdbyrowid' => $this->session->userRowId
		);
		$this->db->set('createdstamp', 'NOW()', FALSE);
		$this->db->insert('users', $data);				
	}	

	public function checkDuplicateOnUpdate()
    {
    	// echo "chk";
		$this->db->select('uid');
		$this->db->where('uid', $this->input->post('uid'));
		$this->db->where('rowid !=', $this->input->post('rowid'));
		$query = $this->db->get('users');

		if ($query->num_rows() > 0)
		{
			return 1;
		}
    }
	public function updateAjax()
	{
		// $data = array(
		//         'uid' => $this->input->post('uid'),
		//         'pwd' => $this->input->post('pwd')
		// );

		$pwd  = $this->input->post('pwd');
    	$pwd  = $this->Loghash_model->create_hash($pwd);
		$data = array(
		        'uid' => $this->input->post('uid'),
		        // 'abAccess' => $this->input->post('abAccess'),
		        // 'mobile' => $this->input->post('mobile')
		        
		);

		$this->db->where('rowid', $this->input->post('rowid'));
		$this->db->update('users', $data);
	}

	public function delRow()
	{
		$data = array(
		        'deleted' => 'Y',
		        'deletedbyrowid' => $this->session->userRowId

		);
		$this->db->set('deletedstamp', 'NOW()', FALSE);
		$this->db->where('rowid', $this->input->post('rowid'));
		$this->db->update('users', $data);
	}

	public function getData()
	{
		// $data="";
		// $arguments = func_get_args();
		// if(func_num_args()==0)
		// {
		// 	$data='*';
		// }
		// else
		// {
		// 	for ($i=0; $i < func_num_args(); $i++) 
		// 	{
		// 		$data[$i] = $arguments[$i];
		// 	}
		// 	$data = implode(",", $data);
		// }
		// $this->db->select($data);
		$this->db->select('*');
		$this->db->where('deleted', 'N');
		$this->db->where('uid!=', 'admin');
		$this->db->order_by('uid');
		$query = $this->db->get('users');
		return($query->result_array());
	}

	public function getUsersForCheckBox()
	{
		$this->db->select('rowid, uid');
		$this->db->where('deleted', 'N');
		$this->db->order_by('uid');
		$query = $this->db->get('users');
		$arr = array();
		foreach ($query->result_array() as $row)
		{
    		$arr[$row['rowid']]= $row['uid'];
		}

		return $arr;
	}
}