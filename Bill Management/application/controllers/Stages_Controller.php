<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stages_Controller extends CI_Controller
{
	public function __construct()
    {
            parent::__construct();
            $this->load->model('Stages_model');
            $this->load->helper('form');
            $this->load->helper('url');
            $r =$this->Util_model->getAuth();
	        if( $r==0)
	        {
	        	redirect(base_url());
	        }
    }
	public function index()
	{
		if ($this->session->isLogin===True && $this->session->session_id != '') /*if logged in*/
		{
			if($this->Util_model->getRight($this->session->userRowId,'Stages')==0)
			{
				$this->load->view('includes/header4all');
				$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);
				$this->load->view('ErrorUnauthenticateUser_view');
				$this->load->view('includes/footer');				
				return;
			}
			$data['records'] = $this->Stages_model->getDataLimit();
			$data['errorfound'] = "";
			$this->load->view('includes/header4all');
			$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);

			$this->load->view('Stages_view', $data);
			$this->load->view('includes/footer');
		}
		else 	/* if not logged in */	
		{
            $this->load->view('includes/header');           // with Jumbotron
        	$this->load->view('login_view');
	        $this->load->view('includes/footer');
		}
	}  

	public function insert()
	{
		if($this->Stages_model->checkDuplicate() == 1)
        {
        	$data = "Duplicate record...";
        	echo json_encode($data);
        }
        else
        {
			$this->Stages_model->insert();
			$data['records'] = $this->Stages_model->getDataLimit();
			echo json_encode($data);
        }
	}

	public function update()
	{
		if($this->Stages_model->checkDuplicateOnUpdate() == 1)
        {
        	$data = "Duplicate record...";
        	echo json_encode($data);
        }
        else
        {
			$this->Stages_model->update();
			$data['records'] = $this->Stages_model->getDataLimit();
			echo json_encode($data);
        }
	}

	public function delete()
	{
		$this->Stages_model->delete();
		$data['records'] = $this->Stages_model->getDataLimit();
		echo json_encode($data);
	}

	public function loadAllRecords()
	{
		$data['records'] = $this->Stages_model->getDataAll();
		echo json_encode($data);
	}

}
