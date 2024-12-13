<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Visitor_Model extends CI_Model{

//Adding Visitors
public function add($vname,$vmnumber,$vaddress,$apartment,$floor,$whomtomeet,$reasontomeet){
$data=array(
			'VisitorName'=>$vname,
			'MobileNumber'=>$vmnumber,
			'Address'=>$vaddress,
			'Apartment'=>$apartment,
			'Floor'=>$floor,
			'WhomtoMeet'=>$whomtomeet,
			'ReasontoMeet'=>$reasontomeet,
		);
$sql_query=$this->db->insert('tblvisitor',$data);
if($sql_query){
$this->session->set_flashdata('success', 'Visitor added successfull');
		redirect('Visitor');
	}
	else{
		$this->session->set_flashdata('error', 'Somthing went worng. Error!!');
		redirect('Visitor');
	}

	}
// Visitors List
public function list(){
$query=$this->db->select('VisitorName,Apartment,Floor,WhomtoMeet,EnterDate,ID,outtime')
		        ->order_by("ID", "desc")
		        ->get('tblvisitor');
		        return $query->result();      
	}

//Getting particular user deatials on the basis of id	
public function getvisitordetails($vid){
 $ret=$this->db->select('VisitorName,MobileNumber,WhomtoMeet,EnterDate,ID,Address,Apartment,Floor,ReasontoMeet,remark,outtime')
 	             ->where('ID',$vid)
 	              ->get('tblvisitor');
 	                return $ret->row();
 }

// For Updating Outing Remark
public function outing($remark,$vid){
$data=array(
			'remark'=>$remark
		);
$sql_query=$this->db->where('ID', $vid)
                ->update('tblvisitor', $data);
if($sql_query){
$this->session->set_flashdata('success', 'Record updated successful');
		redirect('Visitor/List');
	}
	else{
		$this->session->set_flashdata('error', 'Somthing went worng. Error!!');
		redirect('Visitor/List');
	}

}

}