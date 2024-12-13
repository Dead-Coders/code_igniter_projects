<?php
class Login_model extends CI_Model {

        public function __construct()
        {
                $this->load->database('');
                $this->load->model('Loghash_model');
        }

        public function is_logged_in()
		{  
			if (isset($this->session->isLogin)===True) /*if logged in*/
			{
				return 1;
			}
	 	// 	if(isset($this->session->userdata['Admin']['logged_in']) == 'TRUE' ){
			// 	redirect(base_url('v3/dashboard'));
			// } 
	  	}

		public function checkuser($uid, $pwd)
		{
			$this->db->select('*');
			$this->db->from('users');
			$this->db->where('uid', $uid);
			$query = $this->db->get();
			if($query->num_rows() > 0)
			{
	        	$row = $query->row(); 
			    $dbPwd = $row->pwd;
	        	$res = $this->Loghash_model->validate_password($pwd, $dbPwd);
	        	if($res==1)	// authenticates successfully
	        	{
	        		return $query->row_array();
	        	}
			}
			// $farzi = array();
	  //       $query = $this->db->get_where('users', array('uid' => $uid));
	  //       // if(count($query)==1)
	  //       {
	  //       	if ($query->num_rows()>0)
	  //       	{
		 //        	$row = $query->row(); 
  	// 		        $dbPwd = $row->pwd;
		 //        	// passing password typed by user ($pwd) and db password. 
		 //        	// $res = $this->Loghash_model->validate_password($pwd, $query->row_array()['pwd']);
		 //        	$res = $this->Loghash_model->validate_password($pwd, $dbPwd);
		 //        	if($res==1)	// authenticates successfully
		 //        	{
		 //        		return $query->row_array();
		 //        	}
		 //        	// else
		 //        	// {
		 //        	// 	return $farzi;
		 //        	// }
	  //       	}
	  //       }
		}
		public function insert_session($uid)
		{
			$query = $this->db->query('SELECT max(rowid) as rowid FROM sessionlog ORDER BY rowid');
			if ($query->num_rows() > 0)
			{
			        $row = $query->row_array();

			        $current_row = $row['rowid']+1;		// getting next rowid

					// Getting rowid of logged in user
					$query = $this->db->query("SELECT rowid  FROM users WHERE uid='".$uid."'");
					$user_row = $query->row_array();
					// END - Getting rowid of logged in user
					

					$session_id = $this->session->session_id;


					$data = array(
					        'rowid' => $current_row,
					        'userrowid' => $user_row['rowid'],
					        'sessionid' => $session_id
					);
					$this->db->set('loginstamp', 'NOW()', FALSE);
					$this->db->insert('sessionlog', $data);				

			}
		}

		public function logout_session($sid)
		{
			$sqlStr = "update sessionlog set logoutstamp=NOW() where sessionid='".$sid."'";
			$this->db->query($sqlStr);
			// unset($_SESSION['userid']);			
		}

		public function getReminders()
	    {
	    	$dt = date("Y-m-d");
	     $this->db->select('ledger.*, customers.customerName');
	     $this->db->from('ledger');
	     $this->db->join('customers','customers.customerRowId = ledger.customerRowId');
	     $this->db->where('ledger.deleted', 'N');
	     $this->db->where('ledger.reminder >=', $dt);
	     $this->db->where('ledger.reminder <=', $dt);
	     $this->db->where('ledger.bal >', 0);
	     $this->db->order_by('ledger.refDt, ledgerRowId');
	     $query = $this->db->get();
	     return($query->result_array());
	    }


	    public function getLastBackupDt()
	    {
	    	//SELECT CURRENT_DATE - max(dt) from bkp
	    	$sqlStr = "SELECT DATEDIFF(CURDATE(), max(dt)) AS kitneDinHoGaye FROM bkp";
			$query = $this->db->query($sqlStr);
			$kitneDinHoGaye;
		    if ($query->num_rows() > 0)
			{
				$row = $query->row_array();
			    $kitneDinHoGaye = $row['kitneDinHoGaye'];	
			    return $kitneDinHoGaye;
			}
	    }
	    public function setBackupDt()
	    {
	    	$dt = date("Y-m-d");
	    	$this->db->select_max('rowId');
			$query = $this->db->get('bkp');
	        $row = $query->row_array();
	        $current_row = $row['rowId']+1;
			$data = array(
		        'rowId' => $current_row
		        , 'dt' => $dt
			);
			$this->db->insert('bkp', $data);

			///// purane record delete
	     	$this->db->where('dt <', $dt);
			$this->db->delete('bkp');

	    }


	public function markPadhLiya()
	{
		$data = array(
	        'deleted' => 'Y'
		);
		$this->db->where('rowId', $this->input->post('notificationRowId'));
		$this->db->where('notificationType', $this->input->post('notificationType'));
		$this->db->update('notifications', $data);		
	}

	

}