<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Right_Controller extends CI_Controller
{
	public function __construct()
    {
            parent::__construct();
            $this->load->model('Right_model');
            $this->load->model('User_model');
            $this->load->model('Menu_model');
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
			if($this->Util_model->getRight($this->session->userRowId,'User Rights')==0)
			{
				$this->load->view('includes/header4all');
				$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);
				$this->load->view('ErrorUnauthenticateUser_view');
				$this->load->view('includes/footer');				
				return;
			}
			$data['users'] = $this->User_model->getData('rowid','uid');
			$data['users4ab'] = $this->User_model->getUsersForCheckBox();
			$this->load->view('includes/header4all');
			$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);
			// $data['vehicles'] = $this->Right_model->getDataForCheckBox();
			$this->load->view('Rights_view',$data);
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

	public function insertRights()
	{
		$this->Right_model->insertAjax();
		$data['users'] = $this->User_model->getData('rowid','uid');
		$this->load->view('Rights_view',$data);
		$this->load->view('includes/footer');
	}

	function getRights()
	{
    	$arr = $this->Menu_model->getRights();
    	$msg="";
    	foreach ($arr as $key => $value) {
    		$msg = $value['menuoption'].",".$msg;
    	}
    	// echo json_encode($temp);
    	echo $msg;
	}


}
