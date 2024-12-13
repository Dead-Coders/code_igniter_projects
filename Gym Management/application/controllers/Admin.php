<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('cart');
		$this->load->model('Admin_model');
	}


	public function date()
	{
		$current=strtotime(date('Y-m-d'));
		$end=strtotime('2019-08-23');
		$dif=$current-$end;
		$abc=round($dif/86400);
		if($abc>-4 && $abc<=0)
		{
			echo 'You are about to dormant';
		}
		else if($abc>=2)
		{
			echo "You are Unpaid";
		}
		else
		{
			echo "Clear";
		}

		echo $abc;

		
	}


	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////					TABLES/DISPLAY		//////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function index()
	{
		if($this->session->userdata('gym_admin'))
		{
			redirect('Admin/dashboard');
			
		}
		else
		{
			$this->load->view('login');
		}
	}
		


	public function dashboard()
	{


		$members=$this->Admin_model->selectAllMembers();

		$curDate=strtotime(date('Y-m-d'));

		foreach($members->result() as $member)
		{
			$endDate=strtotime($member->end_date);	
			$dif=$curDate-$endDate;
			$dif=round($dif/86400);
			if($dif>=-4 && $dif<=0)
			{
				$this->Admin_model->updateMemberFeeStatus($member->id,'Unpaid');
			}
			else if($dif>=240)
			{
				$this->Admin_model->updateMemberStatus($member->id,'Dormant');
			}
		}


		if($this->session->userdata('gym_admin')){

			$data['active']=$this->Admin_model->countMembers('Active');
			$data['inactive']=$this->Admin_model->countMembers('InActive');
			$data['unpaid']=$this->Admin_model->countMembersP('UnPaid');
			$data['dormant']=$this->Admin_model->countMembers('Dormant');
			$data['freeze']=$this->Admin_model->countMembers('Freeze');
			

		$this->load->view('partials/header');
		$this->load->view('partials/sidebar');
		$this->load->view('partials/navbar');
		$this->load->view('dashboard_partials/icons',$data);
		$this->load->view('partials/footer');
		}
		else
		{
			redirect('Admin');
		}
	}

	public function showLogs()
	{
		if($this->session->userdata('gym_admin'))
		{
			$data['logs']=$this->Admin_model->selectLogs();

			$this->load->view('partials/header');
			$this->load->view('partials/navbar');
			$this->load->view('partials/sidebar');
			$this->load->view('logs',$data);
			$this->load->view('partials/footer');
			$this->load->view('partials/data_tables');
		}
		else
		{
			redirect('Admin');
		}
	}


	public function showBin()
	{
		if($this->session->userdata('gym_admin'))
		{
			$data['bins']=$this->Admin_model->selectBin();

			$this->load->view('partials/header');
			$this->load->view('partials/navbar');
			$this->load->view('partials/sidebar');
			$this->load->view('bins',$data);
			$this->load->view('partials/footer');
			$this->load->view('partials/data_tables');
		}
		else
		{

		}
	}

	public function MemberDetails()
	{
		if($this->session->userdata('gym_admin'))
		{
			$id=$this->uri->segment(3);
			$data['details']=$this->Admin_model->selectMember($id);

			$this->load->view('partials/header');
			$this->load->view('partials/navbar');
			$this->load->view('logs',$data);
			$this->load->view('partials/footer');

		}
		else
		{
			redirect('Admin');
		}
	}

	public function showDailyVisitors()
	{
		if($this->session->userdata('gym_admin'))
		{
			$data['daily_vis']=$this->Admin_model->selectDailyVisitors();

			$this->load->view('partials/header');
			$this->load->view('partials/sidebar');
			$this->load->view('partials/navbar');
			$this->load->view('daily_visitors',$data);
			$this->load->view('partials/footer');
			$this->load->view('partials/data_tables');

		}
		else
		{
			redirect('Admin');
		}
	}

	public function showReports()
	{
		if($this->session->userdata('gym_admin'))
		{

			$data['reports']=$this->Admin_model->selectReports();
			

			$this->load->view('partials/header');
			$this->load->view('partials/sidebar');
			$this->load->view('partials/navbar');
			$this->load->view('partials/reason_modal');
			$this->load->view('reports',$data);
			$this->load->view('partials/footer');
			$this->load->view('partials/data_tables');
		}
		else
		{
			redirect('Admin');
		}
	}

	public function showMonthlyPackages()
	{
		if($this->session->userdata('gym_admin'))
		{
			$data['m_pkgs']=$this->Admin_model->selectMonthlyPackages();
			$this->load->view('partials/header');
			$this->load->view('partials/sidebar');
			$this->load->view('partials/navbar');
			$this->load->view('monthly_pkgs',$data);
			$this->load->view('partials/footer');
			$this->load->view('partials/data_tables');

		}
		else
		{
			redirect('Admin');
		}

	}

	public function showDailyPackages()
	{
		if($this->session->userdata('gym_admin'))
		{
			$data['dpkgs']=$this->Admin_model->selectDailyPackages();

			$this->load->view('partials/header');
			$this->load->view('partials/sidebar');
			$this->load->view('partials/navbar');
			$this->load->view('daily_pkgs',$data);
			$this->load->view('partials/footer');
			$this->load->view('partials/data_tables');
		}
		else
		{
			redirect('Admin');
		}
	}

	public function showTMPackages()
	{
		if($this->session->userdata('gym_admin'))
		{
			$data['tm_pkgs']=$this->Admin_model->selectTMPackages();

			$this->load->view('partials/header');
			$this->load->view('partials/sidebar');
			$this->load->view('partials/navbar');
			$this->load->view('tm_pkgs',$data);
			$this->load->view('partials/footer');
			$this->load->view('partials/data_tables');
		}

		else
		{
			redirect('Admin');
		}
	}

	public function showItems()
	{
		if($this->session->userdata('gym_admin'))
		{
			$data['items']=$this->Admin_model->selectJuices();

			$this->load->view('partials/header');
			$this->load->view('partials/sidebar');
			$this->load->view('partials/navbar');
			$this->load->view('items',$data);
			$this->load->view('partials/footer');
			$this->load->view('partials/data_tables');

		}
		else
		{
			redirect('Admin');
		}
	}

	public function showWorkoutPackages()
	{
		if($this->session->userdata('gym_admin'))
		{
			$data['w_pkgs']=$this->Admin_model->selectWorkoutPackages();
			$this->load->view('partials/header');
			$this->load->view('partials/sidebar');
			$this->load->view('partials/navbar');
			$this->load->view('workout_pkgs',$data);
			$this->load->view('partials/footer');
			$this->load->view('partials/data_tables');
		}
		else
		{
			redirect('Admin');
		}
	}

	public function showAllMembers()
	{
		if($this->session->userdata('gym_admin'))
		{
			$data['members']=$this->Admin_model->selectAllMembers();
			$this->load->view('partials/header');
			$this->load->view('partials/sidebar');
			$this->load->view('partials/navbar');

			$this->load->view('allmembers',$data);
			$this->load->view('partials/footer');
			$this->load->view('partials/data_tables');
		}
	}

	public function showActiveMembers()
	{
		if($this->session->userdata('gym_admin'))
		{
			$data['members']=$this->Admin_model->selectActiveMembers();

			$this->load->view('partials/header');
			
			$this->load->view('partials/navbar');
			$this->load->view('partials/sidebar');
			$this->load->view('members',$data);
			$this->load->view('partials/footer');
			$this->load->view('partials/data_tables');
		}
		else
		{
			redirect('Admin');
		}
	}

	public function showInActiveMemers()
	{

		if($this->session->userdata('gym_admin'))
		{
			$data['members']=$this->Admin_model->selectInActiveMembers();

			$this->load->view('partials/header');
			
			$this->load->view('partials/navbar');
			$this->load->view('partials/sidebar');
			$this->load->view('inmembers',$data);
			$this->load->view('partials/footer');
			$this->load->view('partials/data_tables');
		}
		else
		{
			redirect('Admin');
		}

	}

	public function showDormantMembers()
	{
		if($this->session->userdata('gym_admin'))
		{
			$data['members']=$this->Admin_model->selectDormantMembers();

			$this->load->view('partials/header');
			
			$this->load->view('partials/navbar');
			$this->load->view('partials/sidebar');
			$this->load->view('dormant_members',$data);
			$this->load->view('partials/footer');
			$this->load->view('partials/data_tables');
		}
		else
		{
			redirect('Admin');
		}
	}

	public function showAdmins()
	{
		if($this->session->userdata('gym_admin'))
		{
			if($this->session->userdata('access_level')==1)
			{

				$data['admins']=$this->Admin_model->selectAdmins();

				$this->load->view('partials/header');
				$this->load->view('partials/navbar');
				$this->load->view('partials/sidebar');
				$this->load->view('admins',$data);
				$this->load->view('partials/footer');
				$this->load->view('partials/data_tables');

			}

		}


	}

	public function showFreezeMembers()
	{
		if($this->session->userdata('gym_admin'))
		{
			$data['members']=$this->Admin_model->selectFreezeMembers();

			$this->load->view('partials/header');
			$this->load->view('partials/navbar');
			$this->load->view('partials/sidebar');
			$this->load->view('freeze_members',$data);
			$this->load->view('partials/footer');
			$this->load->view('partials/data_tables');
		}
		else
		{
			redirect('Admin');
		}
	}

	public function showUnpaidMembers()
	{
		if($this->session->userdata('gym_admin'))
		{
			$data['members']=$this->Admin_model->selectUnpaidMembers();
			$this->load->view('partials/header');
			$this->load->view('partials/navbar');
			$this->load->view('partials/sidebar');
			$this->load->view('unpaid_members',$data);
			$this->load->view('partials/footer');
			$this->load->view('partials/data_tables');

		}
		else
		{
			redirect('Admin');
		}
	}

	public function showBalance()
	{
		if($this->session->userdata('gym_admin'))
		{
			$data['reps']=$this->Admin_model->selectRemainingBalances();

			$this->load->view('partials/header');
			$this->load->view('partials/navbar');
			$this->load->view('partials/sidebar');
			$this->load->view('showBalance',$data);
			$this->load->view('partials/footer');
			$this->load->view('partials/data_tables');

		}
		else
		{
			redirect('Admin');
		}
	}



	public function Bar()
	{
		if($this->session->userdata('gym_admin'))
		{
			$data['juices']=$this->Admin_model->selectJuices();

			$this->load->view('partials/header');
			$this->load->view('partials/sidebar');
			$this->load->view('partials/navbar');
			$this->load->view('juice_bar',$data);
			$this->load->view('partials/footer');

		}
		else
		{
			redirect('Admin');
		}
	}

	public function Reports_filter()
	{
		if($this->session->userdata('gym_admin'))
		{
			$too=$this->input->post('too');
			$fromm=$this->input->post('fromm');

			$data=$this->Admin_model->selectReport_filter($too,$fromm);
			if($data->num_rows()>0)
			{

			$row="";

					foreach($data->result() as $dat)
					{
						$row .= '<tr>
						<td></td>
						<td>'.$dat->member_name.'</td>
						<td>'.$dat->member_type.'</td>
						<td>'.$dat->packages.'</td>
						<td>'.$dat->tax.'</td>
						<td>'.$dat->fee+$dat->tax.'</td>
						<td>'.$dat->total_amount.'</td>
						<td>'.$dat->balance.'</td>
						<td>

							  <button type="button" onclick="#" class="btn btn-link btn-warning btn-just-icon remove"><i class="material-icons">edit</i>
                          <div class="ripple-container"></div></button>
                         
                           <button type="button" onclick="del_report('.$dat->id_r.')" class="btn btn-link btn-warning btn-just-icon remove"><i class="material-icons">close</i>

                          </form>



						</td>

						</tr>';
				}
				echo $row;

			}

		}
		else
		{
			redirect('Admin');
		}
	}



	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////					ADD FORMS   		//////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function addAdmin_Form()
	{
		if($this->session->userdata('gym_admin'))
		{
			if($this->session->userdata('access_level')==1)
			{
				$this->load->view('partials/header');
				$this->load->view('partials/navbar');
				$this->load->view('partials/sidebar');
				$this->load->view('forms/add/add_admin');
				$this->load->view('partials/footer');
			}
			else
			{
				redirect('Admin/dashboard');
			}
		}
		else
		{
			redirect('Admin');
		}

	}

	public function addMemberForm()
	{
		if($this->session->userdata('gym_admin'))
		{
			if($this->session->userdata('access_level')==1)
			{

			$data['pkgs']=$this->Admin_model->selectWorkoutPackages();
			$data['m_pkgs']=$this->Admin_model->selectMonthlyPackages();
			
			$this->load->view('partials/header');
			
			$this->load->view('partials/sidebar');
			$this->load->view('partials/navbar');
			$this->load->view('forms/add/add_member',$data);
			$this->load->view('partials/footer.php');


			}
		}
		else
		{
			redirect('Admin');
		}
	}

	public function addVisitorForm()
	{
		if($this->session->userdata('gym_admin'))
		{
			if($this->session->userdata('access_level')==1)
			{

						$data['daily_pkgs']=$this->Admin_model->selectDailyPackages();
						$data['therapy_pkgs']=$this->Admin_model->selectMassagePackages();

				$this->load->view('partials/header');
				$this->load->view('partials/sidebar');
					$this->load->view('partials/navbar');
					$this->load->view('forms/add/add_visitor',$data);
					$this->load->view('partials/footer');

			}

		}
		else{
			redirect('Admin');
		}
	}
	

	public  function addPackage_Form()
	{
		if($this->session->userdata('gym_admin'))
		{
			if($this->session->userdata('access_level')==1)
			{

			$this->load->view('partials/header');
			$this->load->view('partials/sidebar');
			$this->load->view('partials/navbar');
			$this->load->view('forms/add/add_pkgs.php');
			$this->load->view('partials/footer');

			}
		}
		else
		{
			redirect('Admin');
		}
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////					EDIT FORMS   		//////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	public function editAdmin_Form()
	{
		if($this->session->userdata('gym_admin'))
		{
			if($this->session->userdata('access_level')==1)
			{
				$id=$this->uri->segment(3);
				$data['admin']=$this->Admin_model->selectSingleAdmin($id);

				$this->load->view('partials/header');
				$this->load->view('partials/sidebar');
				$this->load->view('partials/navbar');
				$this->load->view('forms/edit/edit_admin',$data);
				$this->load->view('partials/footer');
			}
			else
			{
				redirect('Admin/dashboard');
			}
		}
		else
		{
			redirect('Admin');
		}
	}

	public function editDailyVisitorForm()
	{
		if($this->session->userdata('gym_admin'))
		{
			if($this->session->userdata('access_level')==1)
			{

				$id=$this->uri->segment(3);
			$data['visitor']=$this->Admin_model->selectVIsitor($id);
		

			$this->load->view('partials/header');
			$this->load->view('partials/navbar');
			$this->load->view('partials/sidebar');
			$this->load->view('forms/edit/edit_visitor',$data);
			$this->load->view('partials/footer');
				
			}
			
		}
	}

	public function editMemberForm()
	{
		if($this->session->userdata('gym_admin'))
		{
			if($this->session->userdata('access_level')==1)
			{
					$id=$this->uri->segment(3);

					$data['member']=$this->Admin_model->selectMember($id);

					$this->load->view('partials/header');
					$this->load->view('partials/navbar');
					$this->load->view('partials/sidebar');
					$this->load->view('forms/edit/edit_member',$data);
					$this->load->view('partials/footer');

			}
			else
			{
				redirect('Admin/dashboard');
			}
		}
		else
		{
			redirect('Admin');
		}
	}

	public function editMonthlyPackageForm()
	{
		if($this->session->userdata('gym_admin'))
		{
			if($this->session->userdata('access_level')==1)
				{
					$id=$this->uri->segment(3);
					$data['mpkgs']=$this->Admin_model->selectMonthlyPkg($id);


					$this->load->view('partials/header');
					$this->load->view('partials/navbar');
					$this->load->view('partials/sidebar');
					$this->load->view('forms/edit/edit_monthly_pkg',$data);
					$this->load->view('partials/footer');
				}
		
		}
	}

	public function editDailyPackageForm()
	{
		if($this->session->userdata('gym_admin'))
		{

			if($this->session->userdata('access_level')==1)
			{


			$id=$this->uri->segment(3);
			$data['dpkgs']=$this->Admin_model->selectDailyPkg($id);

			$this->load->view('partials/header');
			$this->load->view('partials/navbar');
			$this->load->view('partials/sidebar');
			$this->load->view('forms/edit/edit_daily_pkg',$data);
			$this->load->view('partials/footer');
				
			}
			else
			{
				redirect('Admin/dashboard');
			}
		}
		else
		{
			redirect('Admin');
		}
	}

	public function editTMPackageForm()
	{
		if($this->session->userdata('gym_admin'))
		{
			if($this->session->userdata('access_level')==1)
			{

			$id=$this->uri->segment(3);

			$data['tm_pkg']=$this->Admin_model->selectTMpkg($id);

			$this->load->view('partials/header');
			$this->load->view('partials/sidebar');
			$this->load->view('partials/navbar');
			$this->load->view('forms/edit/edit_tm_pkg',$data);
			$this->load->view('partials/footer');
			}
			else
			{
				redirect('Admin/dashboard');
			}
		
		}
		else
		{
			redirect('Admin');
		}
	}

	public function editItemForm()
	{
		if($this->session->userdata('gym_admin'))
		{
			if($this->session->userdata('access_level')==1)
			{
				$id=$this->uri->segment(3);
				$data['item']=$this->Admin_model->selectOneItem($id);

			$this->load->view('partials/header');
			$this->load->view('partials/sidebar');
			$this->load->view('partials/navbar');
			$this->load->view('forms/edit/edit_item',$data);
			$this->load->view('partials/footer');
			}
			else
			{
				redirect('Admin/dashboard');
			}
		}
		else
		{
			redirect('Admin');
		}
	}

	public function editWorkoutPackageForm()
	{
		if($this->session->userdata('gym_admin'))
		{
			if($this->session->userdata('access_level')==1)
			{	

					$id=$this->uri->segment(3);
					$data['wpkg']=$this->Admin_model->selectWorkoutPkg($id);
					$this->load->view('partials/header');
					$this->load->view('partials/sidebar');
					$this->load->view('partials/navbar');
					$this->load->view('forms/edit/edit_w_pkg',$data);
					$this->load->view('partials/footer');
			}
			else
			{
				redirect('Admin/dashboard');
			}
		}
		else
		{
			redirect('Admin');
		}
	}

	public function Profile()
	{
		if($this->session->userdata('gym_admin'))
		{
			$data['admin']=$this->Admin_model->selectProfile($this->session->userdata('gym_admin'));

			$this->load->view('partials/header');
			$this->load->view('partials/sidebar');
			$this->load->view('partials/navbar');
			$this->load->view('forms/edit/edit_profile',$data);
			$this->load->view('partials/footer');
		}
		else
		{
			redirect('Admin');
		}	
	}
	




	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////           CRUD	CONTROLLERS          /////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function addAdmin_Controller()
	{
		if($this->session->userdata('gym_admin'))
		{
			if($this->session->userdata('access_level')==1)
			{
				$fname=$this->input->post('fname');
				$lname=$this->input->post('lname');
				$email=$this->input->post('email');
				$pass=$this->input->post('pass');
				$pass=password_hash($pass, PASSWORD_BCRYPT);
				$level=$this->input->post('level');
				$shift=$this->input->post('shift');

				$test=$this->Admin_model->chk_email($email);

				if($test!=True)
				{

						$run=$this->Admin_model->insertAdmin($fname,$lname,$email,$pass,$level,$shift);
						if($run==true)
						{
							echo 'true';
						}
						else
						{
							echo 'false';
						}

				}
				else
				{
					echo 'email';
				}


			}	
			else
			{
				redirect('Admin/dashboard');
			}
		}
		else
		{
			redirect('Admin');
		}

	}



	public function addMember_Controller()
	{
		if($this->session->userdata('gym_admin'))
		{
			$mno=$this->input->post('no');
			$chk_no=$this->Admin_model->selectMember_nos($mno);
			if($chk_no==true)
			{
				$name=$this->input->post('name');
				$father=$this->input->post('father');
				$dob=$this->input->post('dob');
				$cnic=$this->input->post('cnic');
				$gender=$this->input->post('gender');
				$res=$this->input->post('res');
				$address=$this->input->post('address');
				$telephone=$this->input->post('telephone');
				$email=$this->input->post('email');
				$fee=$this->input->post('fee');
				$time=$this->input->post('time');
				$o_disease=$this->input->post('other_disease');
				$grand=$this->input->post('grand');
				$payment=$this->input->post('payment');
				$remaining=$this->input->post('remaining');
				$date=$this->input->post('date');
				$payment_type=$this->input->post('ptype');
				$discount=$this->input->post('disc');
				$pkgs=$this->input->post('pkgs');
				$tax=$this->input->post('tax');

				$monthly=$this->input->post('monthly');

				$month_dur=$this->Admin_model->selectDuration($monthly);
				

				$total_days=$month_dur*30;
				$today=date_create(date("Y-m-d"));

				
				date_add($today,date_interval_create_from_date_string($total_days." days"));

				$endDate=date_format($today,"Y-m-d");


				$HP=$this->input->post('HP');
				$AS=$this->input->post('AS');
				$HD=$this->input->post('HD');
				$BP=$this->input->post('BP');
				$DB=$this->input->post('DB');

				$remarks="New Member (No:".$mno." Name: ".$name.") was added by Admin: ".$this->session->userdata('gym_admin');


			$run=$this->Admin_model->insertMember($mno,$name,$father,$dob,$cnic,$gender,$res,$address,$telephone,$email,$time,$o_disease,$payment,$remaining,$date,$HP,$AS,$HD,$BP,$DB,$endDate);

			$testt=$this->Admin_model->insertMember_in_Report($mno,$name,$month_dur.' Months '.$pkgs,$date,$remaining,$payment_type,$discount,$payment,$endDate,$tax,$fee);

				if($run==true)
					{
						$this->Admin_model->log_generator('Insert','Member',$remarks);
						echo 'true';
					}
				else
					{
						echo 'false';
					}

				if($testt==false)
					{
						echo $test;
					}


			}
			else if($chk_no==false)
			{
				echo 'mno';
			}

			




		}
		else
		{
			redirect('Admin');
		}



	}

	

	public function addDailyVisitorController()
	{
		if($this->session->userdata('gym_admin'))
		{

		$cashier=$this->session->userdata('gym_admin');
		$name=$this->input->post('name');
		$cnic=$this->input->post('cnic');
		$tel=$this->input->post('tel');
		$add=$this->input->post('address');
		$balance=$this->input->post('balance');
		$payment=$this->input->post('ppayment');
		$fee=$this->input->post('fee');
		$tax=$this->input->post('ttax');
		$payment_type=$this->input->post('payment_type');
		$pkgs=$this->input->post('pkgs');

		$run=$this->Admin_model->insertDailyVisitor($name,$cnic,$tel,$add,$balance);

		$remarks="New Daily Visitor : ".$name." was added by ".$cashier;

		
											
		$un=$this->Admin_model->insertReportDaily($name,'Daily',$fee,$pkgs,$cashier,$balance,$payment_type,$payment,$tax);


		if($run==true)
			{
				$this->Admin_model->log_generator('Insert','Daily Visitor',$remarks);
				echo 'true';
			}
			else
			{
				echo 'false';
			}
	}
		else
		{
			redirect('Admin');
		}
	}



	public function addPackages_controller()
	{
		if($this->session->userdata('gym_admin'))
		{
			$duration=$this->input->post('duration');
			$price=$this->input->post('price');
			$type=$this->input->post('type');
			$name=$this->input->post('name');

			$remarks="New Package/Item (Name: ".$name.", Type:".$type.", Price: ".$price." Rs) Added by Admin: ".$this->session->userdata('gym_admin');

			$this->Admin_model->log_generator('Add',$type,$remarks);

			if($type=='Juice')
			{
				$run=$this->Admin_model->insertJuiceBar($name,$price);

			}
			else
			{
				$run=$this->Admin_model->insertPackages($name,$price,$type,$duration);
			}

			
			if($run==true)
			{
				echo 'true';
			}
			else
			{
				echo 'false';
			}
		}
		else
		{
			redirect('Admin');
		}
	}

	public function addJuiceItem()
	{
		if($this->session->userdata('gym_admin'))
		{

			$config=[
				'upload_path' => 'uploads/images/juice',
				'allowed_types' => 'jpg|jpeg|png|bmp|JPG|JPEG|PNG',

			];
				$this->load->library('upload',$config);

			$name=$this->input->post('name');
			$price=$this->input->post('price');
			// $file=$this->input->file('file_image');
			if($this->upload->do_upload('file_image'))
			{
			 $file=$this->upload->data();
			 $image_path=$file['raw_name'].$file['file_ext'];
			 $run=$this->Admin_model->insertJuice($name,$price,$image_path);
			 if($run==true)
			 {
			 	echo 'true';
			 }
			 else
			 {
			 	echo 'false';
			 }

			}
			else
			{
				echo 'FileError';
			}
			


		}
		else
		{
			redirect('Admin');
		}
	}


	public function addBin_Controller()
	{
		if($this->session->userdata('gym_admin'))
		{
			$reason=$this->input->post('reason');
			$id=$this->input->post('id');

			$data_report=$this->Admin_model->selectOneReport($id);

			$name=$data_report->member_name;
			$type=$data_report->member_type;
			$pkgs=$data_report->packages;
			$paid_amount=$data_report->total_amount;
			$cashier=$data_report->cashier;
			$balance=$data_report->balance;
			$ptype=$data_report->payment_type;
			$fee_date=$data_report->fee_date;
			$end_date=$data_report->end_date;
			$mem_no=$data_report->membership_no;


			$add_bin=$this->Admin_model->insertBin($id,$name,$type,$pkgs,$paid_amount,$cashier,$balance,$ptype,$fee_date,$end_date,$reason,$mem_no);

			$del_report=$this->Admin_model->deleteReport($id);


			if($add_bin==true && $del_report==true)
			{
				echo 'true';
			}
			else
			{
				echo 'false';
			}
		}
		else
		{
			redirect('Admin');
		}
	}


	public function editDailyVisitorController()
	{
		if($this->session->userdata('gym_admin'))
		{
			$cashier=$this->session->userdata('gym_admin');
			$name=$this->input->post('name');
			$cnic=$this->input->post('cnic');	
			$tel=$this->input->post('tel');
			$add=$this->input->post('address');
			$id=$this->input->post('id');

			$remarks="Record of Daily visitor (Name: ".$name." , ID : ".$id.") was updated by Admin : ".$cashier;

			$this->Admin_model->log_generator('Update','Daily Visitor',$remarks);


		$run=$this->Admin_model->updateDailyVisitor($name,$tel,$cnic,$add,$id);
			if($run==true)
			{
				echo 'true';
			}
			else
			{
				echo 'false';
			}
	
		}
	}

	public function editMemberController()
	{
		if($this->session->userdata('gym_admin'))
		{
			if($this->session->userdata('access_level')==1)
			{
				$mem_no=$this->input->post('id');
				$name=$this->input->post('name');
				$cnic=$this->input->post('cnic');
				$email=$this->input->post('email');
				$tel=$this->input->post('tel');
				$add=$this->input->post('add');
				$res=$this->input->post('res');
				$status=$this->input->post('status');
				$feestatus=$this->input->post('feestatus');

				$run=$this->Admin_model->updateMember($mem_no,$name,$cnic,$email,$tel,$add,$res,$status,$feestatus);

				if($run==true)
				{
					echo 'true';
				}
				else
				{
					echo 'false';
				}
			}
		}
		else
		{
			redirect('Admin');
		}
	}

	public function editMonthlyPackage_Controller()
	{
		if($this->session->userdata('gym_admin'))
		{
			$id=$this->input->post('id');
			$duration=$this->input->post('duration');
			$price=$this->input->post('price');


			$remarks="Record of Monthly Package(Duration: ".$duration.") Updated By Admin: ".$this->session->userdata('gym_admin');

			$this->Admin_model->log_generator('Update','Monthly Package',$remarks);

			$run=$this->Admin_model->updateMonthlyPackage($id,$price,$duration);
			if($run==true)
			{
				echo 'true';
			}
			else
			{
				echo 'false';
			}
		}
		else
		{
			redirect('Admin');
		}
	}

	public function editDailyPackage_Controller()
	{
		if($this->session->userdata('gym_admin'))
		{
			$id=$this->input->post('id');
			$price=$this->input->post('price');
			$name=$this->input->post('name');

			$remarks=" Record of Daily Package(Name: ".$name.") Updated by Admin: ".$this->session->userdata('gym_admin');

			$this->Admin_model->log_generator('Update','Daily Package',$remarks);

			$run=$this->Admin_model->updateDailyPackage($id,$name,$price);
			if($run==true)
			{
				echo 'true';
			}
			else
			{
				echo 'false';
			}
		}
		else
		{
			redirect('Admin');
		}
	}

	public function editTMPackage_Controller()
	{
		if($this->session->userdata('gym_admin'))
		{
			$name=$this->input->post('name');
			$price=$this->input->post('price');
			$id=$this->input->post('id');
			$run=$this->Admin_model->updateTmPackage($id,$name,$price);

			$remarks="Record of Therapy/Massage Packages (Name: ".$name.") was updated by Admin: ".$this->session->userdata('gym_admin');
			$this->Admin_model->log_generator('Update','T/M Package',$remarks);

			if($run==true)
			{
				echo 'true';
			}
			else
			{
				echo 'false';
			}
		}
		else
		{
			redirect('Admin');
		}
	}

	public function editWorkoutPackage_Controller()
	{
		if($this->session->userdata('gym_admin'))
		{
			if($this->session->userdata('access_level')==1)
			{
				$name=$this->input->post('name');
				$price=$this->input->post('price');
				$id=$this->input->post('id');

				$remarks="Record of Workout Package (Name: ".$name.", ID: ".$id.") was updated by Admin ".$this->session->userdata('gym_admin');
				$run=$this->Admin_model->updateWorkoutPackage($id,$name,$price);

				if($run==true)
				{
						$this->Admin_model->log_generator('Update','Workout Package',$remarks);
						echo 'true';

				}
				else
				{
					echo 'false';
				}
			}
			else
			{
				redirect('Admin/dashboard');
			}

		}
		else
		{
			redirect('Admin');
		}
	}

	public function editProfile_Controller()
	{
		if($this->session->userdata('gym_admin'))
		{

			$f_name=$this->input->post('fname');
			$l_name=$this->input->post('lname');
			$email=$this->input->post('email');
			$run=$this->Admin_model->updateProfile($email,$f_name,$l_name,$this->session->userdata('gym_admin'));
			if($run==true)
			{
				
				$this->session->set_userdata('gym_admin',$email);
				echo 'true';
			}
			else
			{

				echo 'false';

			}

		}
		else
		{
			redirect('Admin');
		}
	}

	public function editAdminPass_Controller()
	{
		if($this->session->userdata('gym_admin'))
		{
			if($this->session->userdata('access_level')==1)
			{
				$id=$this->input->post('id');
				$pass=$this->input->post('pass');
				$pass=password_hash($pass, PASSWORD_BCRYPT);
				$run=$this->Admin_model->updateAdminPassword($id,$pass);
				if($run==true)
				{
					echo 'true';
				}
				else
				{
					echo 'false';
				}

			}
			else
			{
				redirect('Admin/dashboard');
			}

		}
		else
		{
			redirect('Admin');
		}
	}

	public function editBalance_Controller()
	{
		if($this->session->userdata('gym_admin'))
		{
			$id=$this->input->post('id');

			$report=$this->Admin_model->selectReport($id);

			$run=$this->Admin_model->updateBalanceReport($id);

			if($run==true)
			{
				
			
				if($report->member_type=='Daily')
				{
					
					$test=$this->Admin_model->insertReportDaily($report->member_name,$report->member_type,$report->fee,$report->packages,$this->session->userdata('gym_admin'),0,$report->payment_type,$report->balance,$report->tax);

					if($test==true)
					{
						echo 'true';
					}
					else
					{
						echo 'false';
					}
					
				}
				else if($report->member_type=='Monthly')
				{
					$date=date('Y-m-d');
						$test=$this->Admin_model->insertMember_in_Report($report->membership_no,$report->member_name,$report->packages,$date,'0',$report->payment_type,$report->discount,$report->balance,$report->end_date,$report->tax,$report->fee);
						if($test==true)
						{
							echo 'true';
						}
						else
						{
							echo 'true';
						}
				}
				
			}
			else
			{
				echo 'no';
			}



		}
		else
		{
			redirect('Admin');
		}
	}

	public function editPassword_Controller()
	{
		if($this->session->userdata('gym_admin'))
		{
			$old_pass=$this->input->post('old_pass');

			$new_pass=$this->input->post('new_pass');
			
			$run=$this->Admin_model->chkPassword($this->session->userdata('gym_admin'),$old_pass);
			if($run==true)
			{
				$qry=$this->Admin_model->updatePassword($this->session->userdata('gym_admin'),$new_pass);
				if($qry==true)
				{
					echo 'true';
				}
				else
				{
					echo 'false';
				}
			}
			else
			{
				echo 'NotMatch';
			}
		}
		else
		{
			redirect('Admin');
		}
	}

	public function editItem_Controller()
	{
		if($this->session->userdata('gym_admin'))
		{
			if($this->session->userdata('access_level')==1)
			{
				$id=$this->input->post('id');
				$name=$this->input->post('name');
				$price=$this->input->post('price');

				$run=$this->Admin_model->updateItem($id,$name,$price);
				if($run==true)
				{
					echo 'true';
				}
				else
				{
					echo 'false';
				}
			}
			else
			{
				redirect('Admin/dashboard');
			}
		}
		else
		{
			redirect('Admin');
		}
	}


	public function editMember_Status_Controller()
	{
		if($this->session->userdata('gym_admin'))
		{
			$id=$this->input->post('id');
			$status=$this->input->post('status');
			$name=$this->input->post('name');
			$mem_no=$this->input->post('no');
			$prev_status=$this->input->post('prev_status');

			$type="Member";
			$remarks="Member :".$name.",".$mem_no." Status was updated from ".$prev_status." to ".$status." By ".$this->session->userdata('gym_admin');
			$this->Admin_model->log_generator('Update',$type,$remarks);

			$run=$this->Admin_model->updateMemberStatus($id,$status);
			if($run==true)
			{
				echo 'true';
			}
			else
			{
				echo 'false';
			}
		}
		else
		{
			redirect('Admin');
		}
	}

	public function editAdmin_Controller()
	{
		if($this->session->userdata('gym_admin'))
		{
			if($this->session->userdata('access_level')==1)
			{
				$id=$this->input->post('id');
				$fname=$this->input->post('fname');
				$lname=$this->input->post('lname');
				$email=$this->input->post('email');
				// $pass=$this->input->post('pass');
				// $pass=password_hash($pass, PASSWORD_BCRYPT);
				$level=$this->input->post('level');
				$shift=$this->input->post('shift');
				$run=$this->Admin_model->updateAdmin($id,$fname,$lname,$email,$level,$shift);
				if($run==true)
				{
					$remarks="Record of Admin (Name: ".$fname.", ID: ".$id.") updated by Admin: ".$this->session->userdata('gym_admin');
					$this->Admin_model->log_generator('Update','Admin',$remarks);
					echo 'true';
				}
				else
				{
					echo 'false';
				}

			}
			else
			{
				redirect('Admin/dashboard');
			}
		}

		else
		{
			redirect('Admin');
		}
	}

	public function delDailyVisitorController()
	{
		if($this->session->userdata('gym_admin'))
		{
			$id=$this->input->post('delid');
			$name=$this->input->post('name');

			$remarks="Record of Daily Visitor( Name: ".$name.", ID: ".$id.") was Deleted by ".$this->session->userdata('gym_admin');

			$run=$this->Admin_model->deleteDailyVisitor($id);
			$this->Admin_model->log_generator('Delete','Daily Visitor',$remarks);
			if($run==true)
			{
				echo 'true';
			}
			else
			{
				echo 'false';
			}
		}
		else
			{
				redirect('Admin');
		}
	}

	public function delMonthlyPackage_Controller()
	{

		if($this->session->userdata('gym_admin'))
		{

			$id=$this->input->post('delid');
			$duration=$this->input->post('duration');

			$run=$this->Admin_model->deleteMonthlyPackage($id);
			$remarks="Record of Monthly Package(Duration: ".$duration."Month/s) was Deleted by Admin: ".$this->session->userdata('gym_admin');
			$this->Admin_model->log_generator('Delete','Monthly Package',$remarks);

			if($run==true)
			{
				echo 'true';
			}
			else
			{
				echo 'false';
			}

		}
		else
		{
			redirect('Admin');
		}
	}

	public function delDailyPackage_Controller()
	{
		if($this->session->userdata('gym_admin'))
		{
			$id=$this->input->post('delid');
			$name=$this->input->post('name');

			$remarks="Record of Daily package(Name: ".$name.") Deleted By Admin: ".$this->session->userdata('gym_admin');

			$this->Admin_model->log_generator('Delete','Daily Package',$remarks);

			$run=$this->Admin_model->deleteDailyPackage($id);
			if($run==true)
			{
				echo 'true';
			}
			else
			{
				echo 'false';
			}
			
		}
		else
		{
			redirect('Admin');
		}
	
	}

	public function delTMPackage_Controller()
	{
		if($this->session->userdata('gym_admin'))
		{
			$id=$this->input->post('delid');
			$name=$this->input->post('name');

			$remarks="Record of Therapy/Massage Package(Name: ".$name.") Deleted by Admin: ".$this->session->userdata('gym_admin');


			$run=$this->Admin_model->deleteTMPackage($id);

			if($run==true)
			{
				$this->Admin_model->log_generator('Delete','T/M Package',$remarks);
				echo 'true';
			}
			else
			{
				echo 'false';
			}
		}
		else
		{
			redirect('Admin');
		}

	}

	public function delWorkoutPackage_Controller()
	{
		if($this->session->userdata('gym_admin'))
		{
			if($this->session->userdata('access_level')==1)
			{


			$id=$this->input->post('delid');
			$run=$this->Admin_model->deleteWorkoutPackage($id);
			if($run==true)
			{
				echo 'true';
			}
			else
			{
				echo 'false';
			}


			}

		}
		else
		{
			redirect("Admin");
		}
	}

	public function delJuicePackage_Controller()
	{
		if($this->session->userdata('gym_admin'))
		{
			if($this->session->userdata('access_level')==1)
			{
				$id=$this->input->post('delid');
				$name=$this->input->post('name');

				$remarks="Item (Name: ".$name.") Deleted by Admin : ".$this->session->userdata('gym_admin');

				$run=$this->Admin_model->deleteItem($id);
				if($run==true)
				{
					$this->Admin_model->log_generator('Delete','Juice/Item',$remarks);
					echo 'true';
				}
				else
				{
					echo 'false';
				}
			}
			else
			{
				redirect('Admin/dashboard');
			}

		}
		else
		{
			redirect('Admin');
		}
	}

	public function delReport_Controller()
	{
		if($this->session->userdata('gym_admin'))
		{
			if($this->session->userdata('access_level')==1)
			{
				$id=$this->input->post('delid');
				$run=$this->Admin_model->deleteReport($id);

				$remarks="Sales Report (ID: ".$id.") was deleted by Admin: ".$this->session->userdata('gym_admin');


				if($run==true)
					{
						$this->Admin_model->log_generator('Delete','Sales Report',$remarks);
						echo 'true';
					}
				else
					{
						echo 'false';
					}
				
			}
			
		}
		else
		{
			redirect('Admin');
		}
	}

	public function delMember_Controller()
	{

		if($this->session->userdata('gym_admin'))
		{
			if($this->session->userdata('access_level')==1)
			{

				$id=$this->input->post('delid');
				$run=$this->Admin_model->deleteMember($id);
				$name=$this->input->post('name');

				$remarks="Record of  Member (Name: ".$name.", ID: ".$id.") Was Deleted by Admin: ".$this->session->userdata('gym_admin');
				if($run==true)
				{
					$this->Admin_model->log_generator('Delete','Member',$remarks);
					echo 'true';
				}
				else
				{
					echo 'false';
				}

			}
			else
			{
				redirect('dashboard');
			}
		}
		else
		{
			redirect('Admin');
		}
	}

	public function delAdmin_Controller()
	{
		if($this->session->userdata('gym_admin'))
		{
			if($this->session->userdata('access_level')==1)
			{
				$id=$this->input->post('delid');
				$name=$this->input->post('name');

				$run=$this->Admin_model->deleteAdmin($id);
				if($run==true)
				{
					$remarks="Record of Admin(Name:".$name.",ID: ".$id." deleted by Admin: ".$this->session->userdata('gym_admin');
					$this->Admin_model->log_generator('Delete','Admin',$remarks);
					echo 'true';
				}
				else
				{
					echo 'false';
				}
			}
			else
			{
				redirect('Admin/dashboard');
			}
		}
		else
		{
			redirect('Admin');
		}
	}


	
}
