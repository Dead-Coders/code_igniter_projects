<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!Auth::is_loggedin())
			Auth::Bounce($this->uri->uri_string());
	}

	public function index()
	{
		$data['title'] = 'products';
		$data['page'] = 'products/manage';
		$query = $this->db->join(TABLE_CATEGORIES, TABLE_CATEGORIES.'.category_id = '.TABLE_PRODUCTS.'.category_id');
		$query = $this->db->order_by('product_name', 'ASC');
		$data['products'] = $this->db->get(TABLE_PRODUCTS)->result();
		$this->load->view('template', $data);
	}

	/*
		Manages Create and update actions for product
	 */
	public function manage()
	{
		if (!$this->input->post())
			redirect('products');

		$data = $this->input->post();
		if ($this->input->post('product_id')) {
			if ($data['product_name'] != DB::get_cell(TABLE_PRODUCTS, array('product_id'=>$data['product_id']), 'product_name')) {
				$this->form_validation->set_rules('product_name', 'product Name', 'required|alpha_numeric_spaces|is_unique['.TABLE_PRODUCTS.'.product_name]');
			}

			$this->form_validation->set_rules('category_id', 'Category', 'required');
			$this->form_validation->set_rules('product_price', 'Product price', 'required|numeric');
			if($this->form_validation->run() == FALSE) {
				redirect('products');
			}

			$id = $this->input->post('product_id');
			unset($data['id']);
			$where = ['product_id'=>$id];
			if(DB::update(TABLE_PRODUCTS, $where, $data)) {
				$this->session->set_flashdata(SUCCESS, ACTION_SUCCESFUL);
			} else {
				$this->session->set_flashdata(ERROR, ACTION_UNSUCCESFUL);
			}
			$this->index();
		} else {
			$this->form_validation->set_rules('product_name', 'product name', 'required|alpha_numeric_spaces|is_unique['.TABLE_PRODUCTS.'.product_name]');
			$this->form_validation->set_rules('category_id', 'Category', 'required');
			$this->form_validation->set_rules('product_price', 'Product price', 'required|numeric');
			if ($this->form_validation->run() == FALSE) {
				$this->index();
			} else {
				$data = $this->input->post();
				$data['created_at'] = date('Y-m-d H:i:s');
				if ($insert_id = DB::save(TABLE_PRODUCTS, $data)) {
					$this->session->set_flashdata(SUCCESS, ACTION_SUCCESFUL);
				} else {
					$this->session->set_flashdata(ERROR, _l('action_unsuccesful'));
				}
				$this->index();
			}

		}
	}
	
	public function delete($id = 0)
	{
		if(DB::num_rows(TABLE_PRODUCTS, ['category_id'=>$id]) > 0){
			$this->session->set_flashdata(ERROR, 'Category cannot be deleted. it is currently used in the products table.');
		}elseif(DB::delete(TABLE_PRODUCTS, ['product_id'=>$id])){
			$this->session->set_flashdata(SUCCESS, ACTION_SUCCESFUL);
		}else{
			$this->session->set_flashdata(ERROR, ACTION_UNSUCCESFUL);
		}
		$this->index();
	}
}