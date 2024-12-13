<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}


	public function index()
	{

		if(Auth::is_loggedin()){
			redirect(site_url('home'));
		}
		$data['title'] = 'Login';
		$data['page'] = 'auth/login';
		if ($this->input->post()) {
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'required');
			if ($this->form_validation->run() == FALSE){
				$this->load->view('template', $data);
			}else {
				/*
					The data could have been like this if it were using a db.
					$data = [
						'email'=>$this->input->post('email'),
						'password'=> hash('sha256', $this->input->post('password'))
					];
				 */
				

				/*
					But i will jst use this. i'm hungry self :)
				 */
					$data = [
					'email'=>$this->input->post('email'),
					'password'=> $this->input->post('password')
					];

				/*
					From the /app/helpers/auth_helper.php file, the login method can be setup to talk to a database.
					NOTE: in production, i should use a model: but as you said : basic stuff!.
					but i'm to busy, i jst wanna create a basic stuff. :)
					I kinda like static methods :)
				 */
					if(Auth::login($data)) {
						if($this->session->userdata('previous_url')) {
							redirect(site_url($this->session->userdata('previous_url')));
						} else {
							redirect(site_url('home'));
						}
					} else {
						$this->session->set_flashdata(ERROR, '<p class="error">Invalid Email/Password</p>');
						redirect(site_url());
					}
				}
			}
			$this->load->view('template', $data);
		}

		public function logout()
		{
			Auth::logout();
		}

	}
