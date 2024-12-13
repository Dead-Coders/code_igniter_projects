<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Changepwdadmin_Controller extends CI_Controller 
{
	public function __construct()
    {
        parent::__construct();
        $this->load->model('Changepwdadmin_model');
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
		if ($this->session->isLogin===True && $this->session->session_id != '') /*if logged in*/
		{
			if($this->Util_model->getRight($this->session->userRowId,'Reset Password')==0) /* if without rights */
			{
				$this->load->view('includes/header4all');
				$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);
				$this->load->view('ErrorUnauthenticateUser_view');
				$this->load->view('includes/footer');				
				return;
			}
			// If authenticated then ...
			$this->load->view('includes/header4all');
			$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);
			$data['users'] = $this->Changepwdadmin_model->getData();
			$this->load->view('ChangePwdAdmin_view', $data);
			$this->load->view('includes/footer');
		}
		else /* if not logged in */
		{
            $this->load->view('includes/header');           // with Jumbotron
        	$this->load->model('Organisation_model');
            $data['orgInfo'] = $this->Organisation_model->getOrganisation();

            $this->load->view('login_view', $data);
	        $this->load->view('includes/footer');
		}

	}
	public function checkLogin()
	{
        $this->load->library('form_validation');
        $this->form_validation->set_rules('txtUID', 'User ID', 'trim|required');
        $this->form_validation->set_rules('txtPassword', 'New Password', 'trim|required|min_length[8]|max_length[20]');
        $this->form_validation->set_rules('txtRepeatPassword', 'Repeat Password', 'trim|required|min_length[8]|max_length[20]|matches[txtPassword]');

		// $this->form_validation->set_message('min_length', '{field} must have at least {param} characters.');
		// $this->form_validation->set_message('matches', 'Mismatch in old and new Password');
		$this->form_validation->set_message('matches', 'Please type correct {field}');
		$this->form_validation->set_message('min_length', 'Length must be between 8 and 20.');

        if($this->form_validation->run() == FALSE)
        {
			$this->load->view('includes/header4all');
			$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);
			$data['users'] = $this->Changepwdadmin_model->getData();
			$this->load->view('ChangePwdAdmin_view', $data);
            $this->load->view('includes/footer');
            return;
        }

        $uid = $this->input->post('txtUID');
        $n_pw = $this->input->post('txtPassword');

        $result = $this->Changepwdadmin_model->changepwd($uid, $n_pw);
        // print_r("<p>controller:result: ".$result);
        if($result==true)	// Successfully changed password
        {
			$this->load->view('includes/header4all');
			$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);
            // $data['errMsg'] = "Password successfully changed :)";
            $data['errMsg'] = "Done, Password Successfully Changed.";
            $this->load->view('error_view', $data);
			$data['users'] = $this->Changepwdadmin_model->getData();
			$this->load->view('ChangePwdAdmin_view', $data);
        }
        else
        {
			$this->load->view('includes/header4all');
			$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);
            $data['errMsg'] = "Invalid Old Password...";
            $this->load->view('error_view', $data);
			$data['users'] = $this->Changepwdadmin_model->getData();
			$this->load->view('ChangePwdAdmin_view', $data);
        }
        $this->load->view('includes/footer');
	}
}
