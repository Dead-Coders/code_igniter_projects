<?php 

/**
 * 
 */
class Login_model extends CI_Model
{

	public function login_user($email, $password)
	{
		$this->db->where('email', $email);
		$result = $this->db->get('users');

		$db_password = $result->row('password');

		if(password_verify($password, $db_password))
		{
			return $result->row();
		}
		else
		{
			return false;
		}
	} 
}