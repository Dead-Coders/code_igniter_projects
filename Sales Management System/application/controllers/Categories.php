<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!Auth::is_loggedin())
			Auth::Bounce($this->uri->uri_string());
	}

	public function index()
	{
		$data['title'] = 'categories';
		$data['page'] = 'categories/manage';
		$data['categories'] = DB::get(TABLE_CATEGORIES, 'category_name', 'ASC');
		$this->load->view('template', $data);
	}
	/*
		Manages Craete and Edit Actions

	 */
	public function manage()
	{
		if (!$this->input->post())
			redirect('categories');

		$data = $this->input->post();
		if (!empty($this->input->post('category_id'))) {
			if ($data['category_name'] != DB::get_cell(TABLE_CATEGORIES, array('category_id'=>$data['category_id']), 'category_name')) {
				$this->form_validation->set_rules('category_name', 'Category Name', 'required|alpha_numeric_spaces|is_unique['.TABLE_CATEGORIES.'.category_name]');
			}

			if($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata(ERROR, validation_errors());
				redirect('categories');
			}

			$id = $this->input->post('category_id');
			unset($data['category_id']);
			$where = ['category_id'=>$id];
			if(DB::update(TABLE_CATEGORIES, $where, $data)) {
				$this->session->set_flashdata(SUCCESS, ACTION_SUCCESFUL);
			} else {
				$this->session->set_flashdata(ERROR, ACTION_UNSUCCESFUL);
			}
			$this->index();
		} else {
			$this->form_validation->set_rules('category_name', 'Category Name', 'required|alpha_numeric_spaces|is_unique['.TABLE_CATEGORIES.'.category_name]');
			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata(ERROR, validation_errors());
				$this->index();
			} else {
				$data = $this->input->post();
				$data['created_at'] = date('Y-m-d H:i:s');
				if ($insert_id = DB::save(TABLE_CATEGORIES, $data)) {
					$this->session->set_flashdata(SUCCESS, ACTION_SUCCESFUL);
				} else {
					$this->session->set_flashdata(ERROR, ACTION_UNSUCCESFUL);
				}
				$this->index();
			}

		}
	}

	

	public function delete($id = 0)
	{
		if(DB::num_rows(TABLE_PRODUCTS, ['category_id'=>$id]) > 0){
			$this->session->set_flashdata(ERROR, 'Category cannot be deleted. it is currently used in the products table.');
		}elseif(DB::delete(TABLE_CATEGORIES, ['category_id'=>$id])){
			$this->session->set_flashdata(SUCCESS, ACTION_SUCCESFUL);
		}else{
			$this->session->set_flashdata(ERROR, ACTION_UNSUCCESFUL);
		}
		$this->index();
	}
}