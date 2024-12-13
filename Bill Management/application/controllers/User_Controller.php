<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Controller extends CI_Controller
{
	public function __construct()
    {
            parent::__construct();
    		$this->load->library('encryption');
            $this->load->model('User_model');
            $this->load->helper('url');
            $r =$this->Util_model->getAuth();
	        if( $r==0)
	        {
	        	redirect(base_url());
	        }
    }
	public function index()
	{
		if ($this->session->isLogin===True && $this->session->session_id != '')
		{
			// echo $this->session->userRowId;
			// echo $this->Util_model->getRight($this->session->userRowId,'Create Users');
			if($this->Util_model->getRight($this->session->userRowId,'Create Users')==0)
			{
				$this->load->view('includes/header4all');
				$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);
				$this->load->view('ErrorUnauthenticateUser_view');
				$this->load->view('includes/footer');				
				return;
			}
			$data['records'] = $this->User_model->getData('rowid','uid','pwd');
			$data['errorfound'] = "";
			$this->load->view('includes/header4all');
			$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);
			$this->load->view('User_view');
			$this->load->view('UserTable_view', $data);
			$this->load->view('includes/footer');
		}
		else
		{
            $this->load->view('includes/header');
        	$this->load->model('Organisation_model');
            $data['orgInfo'] = $this->Organisation_model->getOrganisation();

            $this->load->view('login_view', $data);
	        $this->load->view('includes/footer');
		}
	}    

	public function insertUser()
	{
		if($this->input->post('uid')=='' || $this->input->post('password')=='')
		{
        	$data['errMsg'] = "Can not store blank...";
        	$this->load->view('error_view', $data);
		}

		else if($this->User_model->checkDuplicate() == 1)
        {
        	$data['errMsg'] = "Duplicate/Deleted Record...";
        	$this->load->view('error_view', $data);
        	$data['errorfound'] = "yes";
        }
        else
        {
			$this->User_model->insertAjax();
			$data['saveMsg'] = "Record Saved...";
        	$this->load->view('save_view', $data);
			$data['errorfound'] = "no";
        }

		$data['records'] = $this->User_model->getData();
		$this->load->view('UserTable_view', $data);
		$this->load->view('includes/footer');
	}


	public function updateUser()
	{
		$updaterow = $this->User_model->checkDuplicate();
		// if($this->input->post('uid')=='' || $this->input->post('pwd')=='')
		// {
  //       	$data['errMsg'] = "Can not store blank...";
  //       	$this->load->view('error_view', $data);
		// }
		if($this->User_model->checkDuplicateOnUpdate()==1)
        {
        	$data['errMsg'] = "Duplicate/Deleted Record...";
        	$this->load->view('error_view', $data);
        	$data['errorfound'] = "yes";
        }
    	else
    	{
			$this->User_model->updateAjax();
			$data['saveMsg'] = "Record Updated...";
        	$this->load->view('save_view', $data);
        	$data['errorfound'] = "no";
    	}

		$data['records'] = $this->User_model->getData();
		$this->load->view('UserTable_view', $data);
		$this->load->view('includes/footer');
	}

	public function deleteUser()
	{
		$this->User_model->delRow();
		$data['records'] = $this->User_model->getData();
		$data['errorfound'] = "no";
		
    	$data['saveMsg'] = "Record Deleted...";
    	$this->load->view('save_view', $data);
		$this->load->view('UserTable_view', $data);
		$this->load->view('includes/footer');
	}
}