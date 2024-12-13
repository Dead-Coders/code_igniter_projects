<?php
class Menu_model extends CI_Model 
{
	public function __construct()
    {
            $this->load->database('');
    }

    public function getRights($uid)
    {
		$username = $uid;
		$this->db->select('menuoption');
		$this->db->where('userrowid', $username);
		$this->db->order_by('');
		$query = $this->db->get('userrights');
		return($query->result_array());
    }

    public function getRights1()
    {
        $this->db->select('menuoption');
        $this->db->where('userrowid', $this->session->userRowId);
        $this->db->order_by('');
        $query = $this->db->get('userrights');
        return($query->result_array());
    }
}