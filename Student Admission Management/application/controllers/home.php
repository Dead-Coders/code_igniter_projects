<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('user_model');
	}

	public function index()
	{
		$view['students_slider'] = $this->user_model->students_slider();
		$this->load->view('layouts/home_layout', $view);
	}

	public function login()
	{
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|strip_tags[email]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|strip_tags[password]');

		if($this->form_validation->run() == FALSE)
		{
			$view['user_view'] = "admin/login";
			$this->load->view('layouts/user_layout', $view);
		}
		else
		{
			$this->load->model('login_model');

			$email = $this->input->post('email');
			$password = $this->input->post('password');

			$user_data = $this->login_model->login_user($email, $password);

			if($user_data)
			{
				$login_data = array(
					'user_data'	=> $user_data,
					'id'		=> $user_data->id,
					'name'		=>$user_data->admin_name,
					'email' 	=> $email,
					'logged_in'	=> true
				);

				$this->session->set_userdata($login_data);

				if($this->session->userdata('logged_in'))
				{
					$this->session->set_flashdata('login_success', 'Welcome <a href="#">'.$this->session->userdata('name').'</a>, You have logged in successfully.');
					redirect('home');
				}
			}
			else
			{
				$this->session->set_flashdata('login_fail', '<i class="fas fa-exclamation-triangle"></i> Invalid login. The email or password that you have entered is incorrect. ');

				redirect($_SERVER['HTTP_REFERER']); // Redirect at same page.
			}
		}

		
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('home');	
	}
}