<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subject_Model extends CI_Model{

// For adding Subject
public function add($sname){
$data=array(
'subjectname'=> $sname
);
$query=$this->db->insert('mstsubject',$data);
if($query){
$this->session->set_flashdata('success','Subject added successfully.');	
redirect('admin/Subject/Add');
} else {
$this->session->set_flashdata('error','Something went wrong. Please try again.');	
redirect('admin/Subject/Add');	
}
}

//View Subject
public function view()
{
	$query=$this->db->select('id,subjectname,postingDate')
	     ->get('mstsubject');
	     return $query->result();
}

// For Subject Deletion
public function delete($uid){
$query=$this->db->where('id',$uid)
                ->delete('mstsubject');
}

}