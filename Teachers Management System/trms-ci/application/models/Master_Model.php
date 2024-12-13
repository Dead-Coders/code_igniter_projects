<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_model extends CI_Model{

public function subject()
{
    $this->db->order_by("subjectname", "ASC");
    $query = $this->db->get("mstsubject");
    return $query->result();
}

 
} 

