<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search_Model extends CI_Model{

	public function index($searchdata){
		$this->db->select('*');
$this->db->from('tblregistration');
$this->db->join('mstsubject', 'mstsubject.id = tblregistration.subject');
$this->db->like('subjectname', $searchdata);
return $this->db->get()->result_array();
	}

}