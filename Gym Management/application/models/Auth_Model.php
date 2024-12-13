<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_Model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
	//	$this->load->library('encryption');

	
	}

	public function AuthCheck($user,$pass)
	{

		$this->db->select('*');
		$this->db->from('accounts');
		$this->db->where('admin_email',$user);
	
		$run=$this->db->get();
		$row=$run->row('access_level');
		$passwd=$run->row('admin_password');
		$this->session->set_userdata('access_level',$row);
		if($run->num_rows()>0)
		{	
			if(password_verify($pass, $passwd))
			{
				return true;
			}
			else
				return false;

		}
		else
			return false;

		
	}
	
	
	
	
}
