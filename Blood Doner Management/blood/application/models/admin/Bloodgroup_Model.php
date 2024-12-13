<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bloodgroup_Model extends CI_Model{

	public function Addbloodgroup($first_name){
		$data=array(
		'bloodname'=>$first_name);
		$query=$this->db->insert('bloodgroup',$data);
		if($query){
		$this->session->set_flashdata('success','Blood Group Add successfull, Now you can login.');	
		redirect('admin/Bloodgroup/add');
		} else {
		$this->session->set_flashdata('error','Something went wrong. Please try again.');	
		redirect('admin/Bloodgroup/add');	
		}
		
		}




//for getting user details
public function getusedetails(){
	$query=$this->db->select('id,bloodname')
	->from('bloodgroup')
	->get();
	return $query->result();
}

	// For record Deletion
	public function delete($uid)
	{
	$query=$this->db->where('id',$uid)
	                ->delete('bloodgroup');
	}

} 