<?php
define("PBKDF2_HASH_ALGORITHM", "sha256");
define("PBKDF2_ITERATIONS", 1000);
define("PBKDF2_SALT_BYTE_SIZE", 24);
define("PBKDF2_HASH_BYTE_SIZE", 24);

define("HASH_SECTIONS", 4);
define("HASH_ALGORITHM_INDEX", 0);
define("HASH_ITERATION_INDEX", 1);
define("HASH_SALT_INDEX", 2);
define("HASH_PBKDF2_INDEX", 3);


class Changepwdadmin_model extends CI_Model 
{
    public function __construct()
    {
            $this->load->database('');
            $this->load->model('LogHash_model');
            $this->load->model('Login_model');
    }

    public function changepwd($uid, $n_pw)
    {
    	// print_r("<p>Inside if >> ChangePwdAdmin:changepwd: ");
    	// Getting hash for new password
    	$pwd  = $this->LogHash_model->create_hash($n_pw);
		$data = array(
		        // 'uid' => $uid,
		        'pwd' => $pwd
		);

		$this->db->where('rowid', $uid);
		$this->db->update('users', $data);
		return(true);
    }

	public function getData()
	{
		$this->db->select('*');
		$this->db->where('deleted', 'N');
		$this->db->order_by('uid');
		$query = $this->db->get('users');

		$arr = array();
		$arr["-1"] = '--- Select User ---';
		foreach ($query->result_array() as $row)
		{
    		$arr[$row['rowid']]= $row['uid'];
		}

		return $arr;
	}

}



	// <?php
	// $password = "password123456789012";
	// $iterations = 1000;

	// // Generate a random IV using mcrypt_create_iv(),
	// // openssl_random_pseudo_bytes() or another suitable source of randomness
	// // $salt = mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);
	// $salt = 147852369;

	// $hash = hash_pbkdf2("sha256", $password, $salt, $iterations, 47);
	// echo $hash;
	// ?>