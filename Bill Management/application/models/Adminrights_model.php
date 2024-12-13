<?php
class Adminrights_model extends CI_Model 
{

    public function __construct()
    {
            $this->load->database('');
    }
        
    public function getData()
	{
		$this->db->select('*');
		$this->db->where('userrowid', 1);
		$this->db->order_by('menuoption');
		$query = $this->db->get('userrights');

		return($query->result_array());
	}

	public function checkDuplicate()
    {
		$this->db->select('menuoption');
		$this->db->where('menuoption', $this->input->post('menuOption'));
		$query = $this->db->get('userrights');

		if ($query->num_rows() > 0)
		{
			return 1;
		}
    }



	public function insert()
    {
		$this->db->select_max('rightrowid');
		$query = $this->db->get('userrights');
        $row = $query->row_array();

        $current_row = $row['rightrowid']+1;

		$data = array(
	        'rightrowid' 	=> $current_row
	        , 'userrowid' => 1
	        , 'menuoption' => $this->input->post('menuOption')
	        , 'createdby' 	=> $this->session->userRowId
		);
		$this->db->set('createdstamp', 'NOW()', FALSE);
		$this->db->insert('userrights', $data);				
	}


	public function delete()
	{
		$this->db->where('rightrowid', $this->input->post('rowId'));
		$this->db->delete('userrights');
	}
}