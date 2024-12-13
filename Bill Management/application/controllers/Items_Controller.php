<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Items_Controller extends CI_Controller
{
	public function __construct()
    {
            parent::__construct();
            $this->load->model('Items_model');
            $this->load->helper('form');
            $this->load->helper('url');
        // $this->load->library('session');
            $r =$this->Util_model->getAuth();
	        if( $r==0)
	        {
	        	redirect(base_url());
	        }
    }
	public function index()
	{
		$myfile = fopen("bootstrap/tmpi.txt", "w") or die("Unable to open file!");
		$txt = $this->session->isLogin;
		$txt .= " - " . $this->session->session_id;
		$txt .= " - " . $this->session->userid;
		fwrite($myfile, $txt);
		fclose($myfile);
		if ($this->session->isLogin===True && $this->session->session_id != '') /*if logged in*/
		{
			if($this->Util_model->getRight($this->session->userRowId,'Items')==0)
			{
				$this->load->view('includes/header4all');
				$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);
				$this->load->view('ErrorUnauthenticateUser_view');
				$this->load->view('includes/footer');				
				return;
			}
			$data['records'] = $this->Items_model->getDataLimit();
			$data['errorfound'] = "";
			///// userRights
			
			// $arr = $this->Util_model->getUserRights();
	  //       $msg="";
	  //       foreach ($arr as $key => $value) {
	  //           $msg = $value['menuoption'].",".$msg;
	  //       }
	  //       $data['msg'] = $msg;
	        ///// END - userRights
			$this->load->view('includes/header4all');
			$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);

			$this->load->view('Items_view', $data);
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
		if($this->Items_model->checkDuplicate() == 1)
        {
        	$data = "Duplicate record...";
        	echo json_encode($data);
        }
        else
        {
			$this->Items_model->insert();
			$data['records'] = $this->Items_model->getDataLimit();
			echo json_encode($data);
        }
	}

	public function update()
	{
		if($this->Items_model->checkDuplicateOnUpdate() == 1)
        {
        	$data = "Duplicate record...";
        	echo json_encode($data);
        }
        else
        {
			$this->Items_model->update();
			$data['records'] = $this->Items_model->getDataLimit();
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
			$this->Items_model->delete();
			$data['records'] = $this->Items_model->getDataLimit();
			echo json_encode($data);
		}
	}

	public function loadAllRecords()
	{
		$data['records'] = $this->Items_model->getDataAll();
		echo json_encode($data);
	}

}
