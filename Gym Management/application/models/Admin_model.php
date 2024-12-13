<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	//	$this->load->library('encryption');

	
	}

	public function log_generator($op,$type,$remarks)
	{
		$data=array(
			'type'=> $type,
			'remarks' => $remarks,
			'operation' => $op
		);
		$this->db->insert('logs',$data);
	}

	public function chk_email($email)
	{
		$this->db->where('admin_email',$email);
		$run=$this->db->get('accounts');
		if($run->num_rows()>0)
		{
			return true;


		}
		else
		{
			return false;
		}
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////// COUNT QUERIES /////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	public function countMembers($status)
	{
		$this->db->where('status',$status);
		return $this->db->count_all_results('members');
		
	}


	public function countMembersP($status)
	{
		$this->db->where('fee_status',$status);
		return $this->db->count_all_results('members');
		
	}





	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////					SELECT(SHOW) 		//////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function selectMember($id)
	{
		$this->db->where('member_no',$id);
		$run=$this->db->get('members');
		return $run->row();
	}

	public function selectDuration($monthly)
	{
		$this->db->where('price',$monthly);
		$this->db->where('type','Monthly');
		$run=$this->db->get('packages');
		return $run->row('duration');
	}

	public function selectMember_nos($no)
	{
		$this->db->select('member_no');
		$this->db->where('member_no',$no);
		$this->db->from('members');
		$run=$this->db->get();
		$rowcount=$run->num_rows();
		if($rowcount>0)
		{
			return false;
		}
		else
		{
			return true;
		}
		
	}

	public function selectAdmins()
	{
		$this->db->where('admin_email !=',$this->session->userdata('gym_admin'));
		$this->db->from('accounts');

	 return $this->db->get();

	}
	public function selectSingleAdmin($id)
	{
		$this->db->where('admin_id',$id);
		$run=$this->db->get('accounts');
		return $run->row();
	}


	public function selectWorkoutPackages()
	{

		$this->db->where('type','Workout');
		$pkgs=$this->db->get('packages');
		return $pkgs;
	}
	
	public function selectMonthlyPackages()
	{
		$this->db->where('type','Monthly');
		$pkgs=$this->db->get('packages');
		return $pkgs;
	}


	public function selectJuices()
	{
		
		return $this->db->get('bar');
	}

	public function selectOneItem($id)
	{
		
		$this->db->where('id',$id);
		$run=$this->db->get('bar');
		return $run->row();
	}
	
	public function selectDailyPackages()
	{
		$this->db->where('type','Daily');
		$this->db->from('packages');
		$pkgs=$this->db->get();
		return $pkgs;
	}

	public function selectMassagePackages()
	{
		$this->db->where('type','TM');
		$pkgs=$this->db->get('packages');
		return $pkgs;
	}
	public function selectTMPackages()
	{
		$this->db->where('type','TM');
		$pkgs=$this->db->get('packages');
		return $pkgs;
	}
	
	public function selectDailyVisitors()
	{
		$visitors=$this->db->get('daily_members');
		return $visitors;
	}
	
	public function selectVIsitor($id)
	{
		$this->db->select('*');
		$this->db->where('user_id',$id);
		$this->db->from('daily_members');
		$data=$this->db->get();

		$row=$data->row();
		return $row;
	}
	public function selectDailyPkg($id)
	{
		$this->db->select('*');
		$this->db->from('packages');
		$this->db->where('type','Daily');
		$data=$this->db->get();
		$row=$data->row();

		return $row;
	}
	
	public function selectReports()
	{
		return $this->db->get('reports');
	}

	public function selectReport_filter($too,$fromm)
	{

		$sql=$this->db->query('SELECT * FROM `reports` WHERE `fee_date` BETWEEN "'.$fromm.'" AND "'.$too.'" ORDER BY id_r DESC ');

		return $sql;

	}

	public function selectReport($id)
	{
		$this->db->where('id_r',$id);
		$run=$this->db->get('reports');
		return $run->row();
	}

	public function selectOneReport($id)
	{
		$this->db->where('id_r',$id);
		$run=$this->db->get('reports');
		return $run->row();
	}

	public function selectMonthlyPkg($id)
	{
		$this->db->where('id',$id);
		$this->db->from('packages');
		$qry=$this->db->get();
		return $qry->row();
	}
	public function selectTMpkg($id)
	{
		$this->db->where('id',$id);
		$this->db->where('type','TM');
		$qry=$this->db->get('packages');
		return $qry->row();
	}

	public function selectWorkoutPkg($id)
	{
		$this->db->where('id',$id);
		$this->db->where('type','Workout');
		$qry=$this->db->get('packages');
		return $qry->row();
	}

	public function selectProfile($email)
	{
		$this->db->where('admin_email',$email);
		$qry=$this->db->get('accounts');
		return $qry->row();
	}
	public function chkPassword($email,$old_pass)
	{
		$this->db->select('admin_password');
		$this->db->where('admin_email',$email);
		$run=$this->db->get('accounts');

	
		if(password_verify($old_pass,$run->row('admin_password')))
		{
			return true;
		}
		else
		{
			return false;
		}
	}



	public function selectJuice_cart($id)
	{
		$this->db->where('id',$id);
		$this->db->from('bar');
		$run=$this->db->get();
		if($run)
		{
			$result=$run->row_array();
			return $result;
		}

	}

	public function selectAllMembers()
	{
		return $this->db->get('members');
	}

	public function selectActiveMembers()
	{
		
		$this->db->where('status','Active');
		$qry=$this->db->get('members');
		return $qry;


	}



	public function selectInActiveMembers()
	{
		$this->db->where('status','InActive');
		$qry=$this->db->get('members');
		return $qry;	
	}

	public function selectDormantMembers()
	{
		$this->db->where('status','Dormant');
		$qry=$this->db->get('members');
		return $qry;
	}

	public function selectFreezeMembers()
	{
		$this->db->where('status','Freeze');
		$qry=$this->db->get('members');
		return $qry;
	} 

	public function selectUnpaidMembers()
	{
		$this->db->where('fee_status','UnPaid');
		$run=$this->db->get('members');
		return $run;
	}

	public function selectRemainingBalances()
	{
		return 	$this->db->query(' SELECT * FROM `reports` where `balance` > 0 ');

	}

	public function selectLogs()
	{
		return $this->db->get('logs');	
	}

	public function selectBin()
	{
		return $this->db->get('bin');
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////					INSERT(ADD) 		//////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	public function insertReport($membership_no,$name,$member_type,$packages,$amount,$cashier,$fee_date)
	{

		$data=array(
			'membership_no' => $membership_no,
			'member_name' => $name,
			'member_type' => $member_type,
			'packages' => $packages,
			'total_amount' => $amount,
			'cashier' => $cashier,
			'fee_date' => $fee_date
		);
		$run=$this->db->insert('reports',$data);
		if($run==true)
		{
			return true;
		}
		else
		{
			return false;
		}

	}
		
	public function insertAdmin($fname,$lname,$email,$pass,$level,$shift)
	{
		$data=array(

			'first_name' => $fname,
			'last_name' => $lname,
			'admin_email' => $email,
			'admin_password' => $pass,
			'shift' => $shift,
			'access_level' => $level

		);
		if($this->db->insert('accounts',$data))
		{
			return true;
		}
		else
		{
			return false;
		}


	}


	public function insertMember($no,$name,$father,$dob,$cnic,$gender,$res,$address,$telephone,$email,$time,$o_disease,$payment,$remaining,$date,$HP,$AS,$HD,$BP,$DB,$endDate)
	{
		$data=array(
			'member_no' => $no,
			'member_name' => $name,
			'member_father_name' => $father,
			'member_dob' => $dob,
			'member_nic' => $cnic,
			'member_gender'=>$gender,
			'member_bloodpressure' => $BP,
			'member_heart_disease' => $HD,
			'member_diabetes' => $DB,
			'member_asthma' => $AS,
			'member_others' => $o_disease,
			'balance_status' => $payment,
			'member_resident' => $res,
			'member_address' => $address,
			'member_telephone' => $telephone,
			'member_email' => $email,
			'member_gym_time' => $time,
			'status' => 'Active',
			'monthlyfee_date' => $date,
			'fee_status' => 'Paid',
			'end_date' => $endDate


		);
		$run=$this->db->insert('members',$data);
		if($run==true)
		{
			return true;
		}
		else 
		{
			return false;
		}

	}

	public function insertMember_in_Report($mno,$name,$pkgs,$date,$remaining,$payment_type,$discount,$payment,$endDate,$tax,$fee)
	{
		$data=array(
			'membership_no' => $mno,
			'member_name' => $name,
			'member_type' => 'Monthly',
			'packages' => $pkgs,
			'total_amount' => $payment,
			'cashier' => $this->session->userdata('gym_admin'),
			'fee_date' => $date,
			'balance' => $remaining,
			'fee' => $fee,
			'discount' => $discount,
			'payment_type' => $payment_type,
			'end_date' => $endDate,
			'tax' => $tax

		);
		$run=$this->db->insert('reports',$data);
		if($run==true)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function insertDailyVisitor($name,$cnic,$tel,$add,$balance)
	{

		$data=array(
			'user_name' => $name,
			'user_address' => $add,
			'user_cellnumber' => $tel,
			'user_nic' => $cnic,
			'balance_status' => $balance

		);
		$run=$this->db->insert('daily_members',$data);
		if($run==true)
		{
			return true;
		}
		else
		{
			return false;
		}

	}
	public function insertReportDaily($name,$member_type,$fee,$pkgs,$cashier,$balance,$payment_type,$amount_paid,$tax)
	{
		$date=date("Y-m-d");

		$data=array(
			'member_name' => $name,
			'member_type' => $member_type,
			'packages' => $pkgs,
			'total_amount' => $amount_paid,
			'cashier' => $cashier,
			'balance' => $balance,
			'payment_type' => $payment_type,
			'discount' => '0',
			'tax' => $tax,
			'fee_date' => $date,
			'fee' => $fee

		);
	$run=$this->db->insert('reports',$data);
	if($run==true)
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}
	public function insertMonthlyPackage($duration,$price)
	{
		$data=array(
			'duration' => $duration,
			'price' => $price
		);
		$run=$this->db->insert('monthly_pkgs',$data);
		if($run==true)
		{
			return true;
		}
		else
		{
			return false;
		}
	}	

	public function insertPackages($name,$price,$type,$duration)
	{
		$data=array(
			'duration' => $duration,
			'price' => $price,
			'type' => $type,
			'name' => $name
		);
		$run=$this->db->insert('packages',$data);
		if($run==true)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function insertJuiceBar($name,$price)
	{
		$data=array(
			'name' => $name,
			'price' => $price

		);
		$run=$this->db->insert('bar',$data);
		if($run==true)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function insertJuice($name,$price,$image_path)
	{
		$data=array(
			'name' => $name,
			'price' => $price,
			'type' => 'juice',
			'image' => $image_path
		);
		$run=$this->db->insert('packages',$data);
		if($run==true)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function insertBar($total,$items,$cashier)
	{
		$data=array(
			'member_name' => 'Juice Bar',
			'packages' => $items,
			'total_amount' => $total,
			'cashier' => $cashier,
			'tax' => 0,
			'member_type' => 'Items/Juice/Bar',
			'payment_type' => 'Cash',
			'amount_paid' => $total,
			'fee' => 0,
			'discount' => 0


		);
		$run=$this->db->insert('reports',$data);
		if($run==true)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function insertBin($id,$name,$type,$pkgs,$paid_amount,$cashier,$balance,$ptype,$fee_date,$end_date,$reason,$mem_no)
	{
		$data=array(
			'member_name'=> $name,
			'member_type' => $type,
			'packages' => $pkgs,
			'total_amount' => $paid_amount,
			'cashier' => $cashier,
			'fee_date' => $fee_date,
			'end_date' => $end_date,
			'balance' => $balance,
			'report_id' =>$id,
			'remarks' => $reason,
			'payment_type' => $ptype,
			'membership_no' => $mem_no

		);
		$run=$this->db->insert('bin',$data);
		if($run==true)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////					DELETE(REMOVE) 		//////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function deleteDailyVisitor($id)
	{
		
		$this->db->where('user_id',$id);
		$this->db->delete('daily_members');
		if($this->db->affected_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function deleteMonthlyPackage($id)
	{
		$this->db->where('id',$id);
		$this->db->where('type','Monthly');
		$this->db->delete('packages');
		if($this->db->affected_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}

	}
	public function deleteDailyPackage($id)
	{
		$this->db->where('id',$id);
		$this->db->where('type','Daily');
		$this->db->delete('packages');
		if($this->db->affected_rows()>0)
		{
			return true;
		}
		else
			return false;
	}
	public function deleteTMPackage($id)
	{
		$this->db->where('id',$id);
		$this->db->where('type','TM');
		$this->db->delete('packages');
		if($this->db->affected_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function deleteWorkoutPackage($id)
	{
		$this->db->where('id',$id);
		$this->db->where('type','Workout');
		$this->db->delete('packages');
		if($this->db->affected_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function deleteReport($id)
	{
		$this->db->where('id_r',$id);
		$this->db->delete('reports');
		if($this->db->affected_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function deleteItem($id)
	{
		$this->db->where('id',$id);
		$this->db->delete('bar');
		if($this->db->affected_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function deleteAdmin($id)
	{
		$this->db->where('admin_id',$id);
		$this->db->delete('accounts');
		if($this->db->affected_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function deleteMember($id)
	{
		$this->db->where('id',$id);
		$this->db->delete('members');
		if($this->db->affected_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}



	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////					UPDATE(EDIT) 		//////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	public function updateAdmin($id,$fname,$lname,$email,$level,$shift)
	{
		$this->db->set('first_name',$fname);
		$this->db->set('last_name',$lname);
		$this->db->set('admin_email',$email);
		$this->db->set('access_level',$level);
		$this->db->set('shift',$shift);
		$this->db->where('admin_id',$id);
		$this->db->update('accounts');
		if($this->db->affected_rows()>0)
		{
			return true;
		}	
		else 
		{
			return false;
		}
	}

	public function updateDailyVisitor($name,$tel,$cnic,$add,$id)
	{
		$this->db->set('user_name',$name);
		$this->db->set('user_address',$add);
		$this->db->set('user_cellnumber',$tel);
		$this->db->set('user_nic',$cnic);
		$this->db->where('user_id',$id);
		$this->db->update('daily_members');
		if($this->db->affected_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}

	}

	public function updateMember($mem_no,$name,$cnic,$email,$tel,$add,$res,$status,$feestatus)
	{
		$this->db->set('member_name',$name);
		$this->db->set('member_nic',$cnic);
		$this->db->set('member_email',$email);
		$this->db->set('member_telephone',$tel);
		$this->db->set('member_address',$add);
		$this->db->set('member_resident',$res);
		$this->db->set('status',$status);
		$this->db->set('fee_status',$feestatus);
		$this->db->where('member_no',$mem_no);
		$this->db->update('members');
		if($this->db->affected_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function updateMonthlyPackage($id,$price,$duration)
	{
		$this->db->set('duration',$duration);
		$this->db->set('price',$price);
		$this->db->where('id',$id);
		$this->db->where('type','Monthly');
		$this->db->update('packages');
		if($this->db->affected_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function updateDailyPackage($id,$name,$price)
	{
		$this->db->set('name',$name);
		$this->db->set('price',$price);
		$this->db->where('id',$id);
		$this->db->where('type','Daily');
		$this->db->update('packages');
		if($this->db->affected_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function updateTmPackage($id,$name,$price)
	{
		$this->db->set('name',$name);
		$this->db->set('price',$price);
		$this->db->where('id',$id);
		$this->db->where('type','TM');
		$this->db->update('packages');
		if($this->db->affected_rows()>0)
		{
			return true;
		}
		else
			return false;
	}

	public function updateWorkoutPackage($id,$name,$price)
	{
		$this->db->set('name',$name);
		$this->db->set('price',$price);
		$this->db->where('id',$id);
		$this->db->where('type','Workout');
		$this->db->update('packages');
		if($this->db->affected_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function updateItem($id,$name,$price)
	{
		$this->db->set('name',$name);
		$this->db->set('price',$price);
		$this->db->where('id',$id);
		$this->db->update('bar');
		if($this->db->affected_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function updateProfile($email,$fname,$lname,$prev_email)
	{
		$this->db->set('first_name',$fname);
		$this->db->set('last_name',$lname);
		$this->db->set('admin_email',$email);
		$this->db->where('admin_email',$prev_email);
		$this->db->update('accounts');
		if($this->db->affected_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function updatePassword($email,$new_pass)
	{
		
		$pass=password_hash($new_pass, PASSWORD_BCRYPT);
		$this->db->set('admin_password',$pass);

		$this->db->where('admin_email',$email);
		$try=$this->db->update('accounts');
		if($this->db->affected_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}


	}

	public function updateMemberFeeStatus($id,$status)
	{
		$this->db->set('fee_status',$status);
		$this->db->where('id',$id);
		$this->db->update('members');
		if($this->db->affected_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function updateMemberStatus($id,$status)
	{
		$this->db->where('id',$id);
		$this->db->set('status',$status);
		$this->db->update('members');
		if($this->db->affected_rows()>0)
		{
			return true;
		}
		else
			return false;
	}

	public function updateAdminPassword($id,$pass)
	{
		$this->db->where('admin_id',$id);
		$this->db->set('admin_password',$pass);
		$this->db->update('accounts');
		if($this->db->affected_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function updateBalanceReport($id)
	{
		$zero=0;
		$this->db->set('balance',$zero);
		$this->db->where('id_r',$id);
		$this->db->update('reports');

		if($this->db->affected_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}



	
	
}
