<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dates_Controller extends CI_Controller
{
	public function __construct()
    {
            parent::__construct();
            $this->load->model('Dates_model');
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
			if($this->Util_model->getRight($this->session->userRowId,'Dates')==0)
			{
				$this->load->view('includes/header4all');
				$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);
				$this->load->view('ErrorUnauthenticateUser_view');
				$this->load->view('includes/footer');				
				return;
			}
			$data['records'] = $this->Dates_model->getDataLimit();
			$data['errorfound'] = "";
			$this->load->view('includes/header4all');
			$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);

			$this->load->view('Dates_view', $data);
			$this->load->view('includes/footer');
		}
		else 	/* if not logged in */	
		{
            $this->load->view('includes/header');           // with Jumbotron
        	$this->load->model('Organisation_model');
            $data['orgInfo'] = $this->Organisation_model->getOrganisation();

            $this->load->view('login_view', $data);
	        $this->load->view('includes/footer');
		}
	}  

	public function insert()
	{
		if($this->Dates_model->checkDuplicate() == 1)
        {
        	$data = "Duplicate record...";
        	echo json_encode($data);
        }
        else
        {
			$this->Dates_model->insert();
			$data['records'] = $this->Dates_model->getDataLimit();
			echo json_encode($data);
        }
	}

	public function update()
	{
		if($this->Dates_model->checkDuplicateOnUpdate() == 1)
        {
        	$data = "Duplicate record...";
        	echo json_encode($data);
        }
        else
        {
			$this->Dates_model->update();
			$data['records'] = $this->Dates_model->getDataLimit();
			echo json_encode($data);
        }
	}

	public function delete()
	{
		// if($this->Util_model->isDependent('addressbook', 'prefixTypeRowId', $this->input->post('rowId')) == 1)
  //       {
  //       	$data['dependent'] = "yes";
  //       	echo json_encode($data);
  //       }
  //       else
        {
			$this->Dates_model->delete();
			$data['records'] = $this->Dates_model->getDataLimit();
			echo json_encode($data);
		}
	}

	public function loadAllRecords()
	{
		$data['records'] = $this->Dates_model->getDataAll();
		echo json_encode($data);
	}

}
