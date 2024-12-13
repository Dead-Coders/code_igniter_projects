<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class View_Model extends CI_Model{
//for getting user details
public function getusedetails(){
	$query=$this->db->select('tblregistration.id,first_name, last_name, gender, blood, email, contact_no, state, city, password, 
	agree, address, create_date,bloodgroup.bloodname as bloodname,bloodgroup.id')
	->join('bloodgroup','tblregistration.blood=bloodgroup.id','left')
	->from('tblregistration')
	->get();
	return $query->result();
}

	// For record Deletion
	public function delete($rid)
	{
	$query=$this->db->where('id',$rid)
	                ->delete('tblregistration');
	                       if($query){
$this->session->set_flashdata('success', 'Record delete successfully');
		redirect('admin/viewuser');
	}
	else{
		$this->session->set_flashdata('error', 'Somthing went worng. Error!!');
		redirect('admin/viewuser');
	}
	}

} 