<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!Auth::is_loggedin())
			Auth::Bounce($this->uri->uri_string());
	}

	public function index()
	{
		$data['title'] = 'orders';
		$data['page'] = 'orders/manage';
		$data['orders'] = DB::get(TABLE_ORDERS, 'order_id', 'desc');
		$this->load->view('template', $data);
	}

	/*
		Returns an html string to add a new row in the orders/form page.
	 */
	public function get_row()
	{
		$products = DB::get(TABLE_PRODUCTS);
		$product_select = "<select name='products[]' class='form-control' required>";
		foreach($products as $row){
			$name = ucfirst($row->product_name);
			$price = number_format($row->product_price, 2);
			$product_select.="<option value='{$row->product_id}'>{$row->product_name} - {$price}</option>";
		}
		$product_select.="</select>";

		$tr = "<tr>";
		$tr.= "<td>{$product_select}</td>";
		$tr.= "<td><input type='number' name='qty[]' class='form-control inputqty' required value='1'></td>";
		$tr.="<td><button type='button' class='btn btn-danger btn-sm' onclick='remove_tr()' id='b'>Delete</button></td>";
		$tr.="<tr>";

		return $tr;

	}

	/*
		manages new order action
		I dont really like too much comments.
		if it was hard to write, it should be hard to read :)
		however i like expressive syntax: No wonder i love laravel :)
	 */
	public function create()
	{
		if($this->input->post())
		{
			$data = $this->input->post();
			$total = 0;
			for($i = 0; $i<count($data['products']); $i++)
			{
				$save[$i]['product_id'] = $data['products'][$i];
				$save[$i]['product_price'] = DB::get_cell(TABLE_PRODUCTS, ['product_id'=>$data['products'][$i]], 'product_price');
				$save[$i]['qty'] = $data['qty'][$i];
				$total+=($save[$i]['product_price']*$save[$i]['qty']);
			}
			$data['order_details'] = json_encode($save);
			$data['order_total'] = $total;
			$this->load->helper('string');
			$data['order_number'] = 'CA_'.random_string('numeric', 5);
			$data['created_at'] = date('Y-m-d H:i:s');
			unset($data['products']); unset($data['qty']);
			if(DB::save(TABLE_ORDERS, $data)){
				$this->session->set_flashdata(SUCCESS, ACTION_SUCCESFUL);
			}else{
				$this->session->set_flashdata(ERROR, ACTION_UNSUCCESFUL);
			}
			redirect('orders');
		}else{
			$data['title'] = 'orders - form';
			$data['page'] = 'orders/form';
			$data['tr'] = $this->get_row();
			$this->load->view('template', $data);	
		}
		
	}

	
	public function delete($id = 0)
	{
		if(DB::delete(TABLE_ORDERS, ['order_id'=>$id])){
			$this->session->set_flashdata(SUCCESS, ACTION_SUCCESFUL);
		}else{
			$this->session->set_flashdata(ERROR, ACTION_UNSUCCESFUL);
		}
		$this->index();
	}

	public function print_order($order_id = 0)
	{
		$data['title'] 	= 'orders - form';
		$data['page'] 	= 'orders/print';
		$data['order'] 	= DB::get_row(TABLE_ORDERS, ['order_id'=>$order_id]);
		$this->load->view('template', $data);
	}
}