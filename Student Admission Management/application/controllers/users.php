<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		if(!$this->session->userdata('logged_in'))
		{
			$this->session->set_flashdata('no_access', 'You are not allowed or logged in.');
			redirect('home/login');
		}
	}

	public function index()
	{
		$view['user_view'] = "admin/404_page";
		$this->load->view('layouts/user_layout', $view);
	}

	public function admission()
	{

		/*==== Image Upload validation*/
		$config = [
			'upload_path'=>'./uploads/image/',
			'allowed_types'=>'jpg|png',
			'max_size' => '400',
			'overwrite' => FALSE
			];

		$this->load->library('upload', $config);

		$this->form_validation->set_rules('s_name', 'Student Name', 'trim|required|strip_tags[s_name]');
		$this->form_validation->set_rules('g_name', 'Gurdian Name', 'trim|required|strip_tags[g_name]');
		$this->form_validation->set_rules('contact', 'Mobile Number', 'trim|required|numeric|strip_tags[contact]');
		$this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email|strip_tags[email]');
		$this->form_validation->set_rules('address', 'Address', 'trim|required|strip_tags[address]');
		$this->form_validation->set_rules('year', 'Year', 'trim|required|numeric|strip_tags[year]');
		$this->form_validation->set_rules('division', 'Division', 'trim|required|strip_tags[division]');
		$this->form_validation->set_rules('b_group', 'Blood Group', 'trim|required|strip_tags[b_group]');
		$this->form_validation->set_rules('shift', 'Shift', 'trim|required|strip_tags[shift]');
		$this->form_validation->set_rules('gender', 'gender', 'trim|required|strip_tags[gender]');

		if (empty($_FILES['userfile']['name'])) 
		{
		 	$this->form_validation->set_rules('userfile', 'Profile picture', 'required|strip_tags[userfile]'); 
		}

		$view = array();
		if($this->form_validation->run() == TRUE)
		{
		    if(!$this->upload->do_upload('userfile'))
		    {
		        $view['upload_errors'] = $this->upload->display_errors();
		    }
		}
		else
		{
		    $view['form_error'] = validation_errors();
		}

		if(array_key_exists('upload_errors', $view) || array_key_exists('form_error', $view))
		{
		    $view['user_view'] = "admin/admission";
			$this->load->view('layouts/user_layout', $view);
		}
		else
		{
		    $this->load->model('user_model');

			if($this->user_model->add_student())
			{
				$this->session->set_flashdata('success', 'Student added successfully');
				redirect('users/all_students');
			}
			else
			{
				print $this->db->error();
			}
		}

	}

	public function all_students()
	{
		$this->load->model('user_model');
		$view['students'] = $this->user_model->get_students();

		$view['user_view'] = "admin/all_students";
		$this->load->view('layouts/user_layout', $view);
	}

	public function student_details($id)
	{
		$this->load->model('user_model');
		$view['student_details'] = $this->user_model->get_student_details($id);

		if($this->user_model->get_student_details($id))
		{
			$view['user_view'] = "admin/student_details";
			$this->load->view('layouts/user_layout', $view);
		}
		else
		{
			$view['user_view'] = "admin/404_page";
			$this->load->view('layouts/user_layout', $view);
		}
	}

	public function student_edit($id)
	{
		/* For geting the existing info...*/
		$this->load->model('user_model');
		$view['student_details'] = $this->user_model->get_student_details($id);

		/*==== Image Upload validation*/
		$config = [
			'upload_path'=>'./uploads/image/',
			'allowed_types'=>'jpg|png',
			'max_size' => '400',
			'overwrite' => TRUE
			];

		$this->load->library('upload', $config);

		$this->form_validation->set_rules('s_name', 'Student Name', 'trim|required|strip_tags[s_name]');
		$this->form_validation->set_rules('g_name', 'Gurdian Name', 'trim|required|strip_tags[g_name]');
		$this->form_validation->set_rules('contact', 'Mobile Number', 'trim|required|numeric|strip_tags[contact]');
		$this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email|strip_tags[email]');
		$this->form_validation->set_rules('address', 'Address', 'trim|required|strip_tags[address]');
		$this->form_validation->set_rules('year', 'Year', 'trim|required|numeric|strip_tags[year]');
		$this->form_validation->set_rules('division', 'Division', 'trim|required|strip_tags[division]');
		$this->form_validation->set_rules('b_group', 'Blood Group', 'trim|required|strip_tags[b_group]');
		$this->form_validation->set_rules('shift', 'Shift', 'trim|required|strip_tags[shift]');
		$this->form_validation->set_rules('gender', 'gender', 'trim|required|strip_tags[gender]');
		if (empty($_FILES['userfile']['name'])) 
		{
		 	$this->form_validation->set_rules('userfile', 'Profile picture', 'required|strip_tags[userfile]'); 
		}


		$view = array();
		if($this->form_validation->run() == TRUE)
		{
		    if(!$this->upload->do_upload('userfile'))
		    {
		        $view['upload_errors'] = $this->upload->display_errors();
		    }
		}
		else
		{
		    $view['form_error'] = validation_errors();
		}

		if(array_key_exists('upload_errors', $view) || array_key_exists('form_error', $view))
		{
			$view['student_details'] = $this->user_model->get_student_details($id);
		    if($this->user_model->get_student_details($id))
			{
				$view['user_view'] = "admin/student_edit";
				$this->load->view('layouts/user_layout', $view);
			}
			else
			{
				$view['user_view'] = "admin/404_page";
				$this->load->view('layouts/user_layout', $view);
			}
		}
		else
		{
		    $this->load->model('user_model');
		    $data = "";
			if($this->user_model->edit_student($id, $data))
			{
				$this->session->set_flashdata('success', 'Student\'s info updated successfully');
				redirect('users/student_details/'.$this->uri->segment(3).'');
			}
			else
			{
				print $this->db->error();
			}
		}
	}

	public function student_delete($id)
	{
		$this->load->model('user_model');
		$this->user_model->delete_student($id);

		$this->session->set_flashdata('success', '<i class= "fas fa-trash text-danger"></i> Student deleted successfully');
		redirect('users/all_students');
	}

	/*=== Register New Admin ===*/
	public function add_admin()
	{
		$this->form_validation->set_rules('admin_name', 'Name', 'trim|required|strip_tags[admin_name]');
		$this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email|is_unique[users.email]|strip_tags[email]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|strip_tags[password]');
		$this->form_validation->set_rules('cpassword', 'Confirm Password',
		'trim|required|matches[password]|strip_tags[cpassword]');

		if($this->form_validation->run() == FALSE)
		{
			$view['user_view'] = "admin/add_admin";
			$this->load->view('layouts/user_layout', $view);
		}
		else
		{
			$this->load->model('user_model');

			if($this->user_model->register_admin())
			{
				$this->session->set_flashdata('reg_success', 'Your Registration is successfull.');
				redirect($_SERVER['HTTP_REFERER']);
			}
			else
			{
				print $this->db->error();
			}

		}
	}
}