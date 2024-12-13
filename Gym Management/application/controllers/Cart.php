<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {

	public function __construct()
	{
		parent:: __construct();

		
		$this->load->model('Admin_model');
		$this->load->library('cart');
	}
	

	public function index()
	{	

	redirect('Admin');
	
	}

	public function getTotal()
	{
		echo 'Total: $'.$this->cart->total().' ';
	}

	public function getCart()
	{
		$output='';
		$data=$this->cart->contents();
		foreach($data as $citem)
		{
			$r="'".$citem['rowid']."'";
			$output .= '<tr>
							<td>'.$citem['name'].'</td>
							<td>'.$citem['qty'].'</td>
							<td>$ '.$citem['price'].' </td>
							<td>$ '.$citem['subtotal'].'</td>
							<td>
							<form>
					
							<button type="button" onclick="inc_qty('.$r.','.$citem['qty'].')" class="btn btn-link btn-warning btn-just-icon"><i class="material-icons" title="Increase Quantity">add</i>
                          <div class="ripple-container"></div></button>
                          <button type="button" onclick="dec_qty('.$r.','.$citem['qty'].')" class="btn btn-link btn-warning btn-just-icon"><i class="material-icons" title="Decrease Quantity">remove</i>
                          <div class="ripple-container"></div></button>
							<button type="button" onclick="remove_item('.$r.')" class="btn btn-link btn-warning btn-just-icon remove"><i class="material-icons" title="remove">close</i>
                          <div class="ripple-container"></div></button>
                          </form>
                          </td>

						</tr>';
		}
		echo $output;
	}

	public function add()
	{
		if($this->session->userdata('gym_admin'))
		{
			$id=$this->input->post('id');
			$qty=$this->input->post('qty');

			$juices = $this->Admin_model->selectJuice_cart($id);
			$filter=preg_replace('/\(|\)/', '', $juices['name']);

			$data=array(
				'id'=> $juices['id'],
				'qty' => $qty,
				'price' => $juices['price'],
				'name' => $filter
			);

			if($this->cart->insert($data))
				{
					echo 'true';

				}
			else
				{
					echo 'false';
				}
		

		}
		else
		{
			redirect('Admin');
		}
		
			
	}

	public function updateCartInc()
	{

		if($this->session->userdata('gym_admin'))
		{
				$rowid=$this->input->post('rowid');
				$qty=$this->input->post('qty');
			$qty++;

			$data=array(
			'rowid' => $rowid,
			'qty' => $qty

			);
			if($this->cart->update($data))
			{
				echo 'true';
			}
			else
			{
				echo 'false';
			}

		}
		else
		{
			redirect('Admin');
		}
	
	}
	public function updateCartDec()
	{
		
		if($this->session->userdata('gym_admin'))
		{
	
			$rowid=$this->input->post('rowid');
			$qty=$this->input->post('qty');
			$qty--;

			$data=array(
			'rowid' => $rowid,
			'qty' => $qty

			);
			if($this->cart->update($data))
			{
				echo 'true';
			}
			else
			{
				echo 'false';
			}
	
			
		}
		else
		{
			redirect('Admin');
		}

	}

	public function removeItem()
	{
		if($this->session->userdata('gym_admin'))
		{
			$row_id=$this->input->post('rowid');
			if($this->cart->remove($row_id))
			{
				echo 'true';
			}
			else
			{
				echo 'false';
			}
		}
		else
		{
			redirect('Admin');
		}
	}

	public function checkout()
	{

		if($this->session->userdata('gym_admin'))
		{

			if($this->cart->total_items()>0)
				{
			
					$items='';
					$data=$this->cart->contents();
					foreach($data as $dat)
					{
						$items .= ','.$dat['name'];
					}
				$try=$this->Admin_model->insertBar($this->cart->total(),$items,$this->session->userdata('gym_admin'));
				if($try==true)
				{
					$this->cart->destroy();
					echo 'true';
				}
				else
				{
					echo 'false';
				}
		
			}

		}
		else
		{
			redirect('Admin');
		}
		
	
	}

}
