<?php
class Duplicates_model extends CI_Model 
{
    public function __construct()
    {
            $this->load->database('');
    }

 //    public function getDataLimit()
	// {
	// 	$this->db->select('*');
	// 	$this->db->where('deleted', 'N');
	// 	$this->db->order_by('itemRowId desc');
	// 	$this->db->limit(5);
	// 	$query = $this->db->get('items');

	// 	return($query->result_array());
	// }

    public function getDataAll()
	{
		$this->db->select('*');
		$this->db->where('deleted', 'N');
		$this->db->order_by('itemName');
		$query = $this->db->get('items');

		return($query->result_array());
	}

	public function showQuotaionDetail()
	{
		$this->db->select('*');
		$this->db->or_where('itemRowId', $this->input->post('hatana'));
		$this->db->or_where('itemRowId', $this->input->post('karna'));
		$this->db->order_by('quotationDetailRowId');
		$query = $this->db->get('quotationdetail');

		return($query->result_array());
	}
	public function showCashSale()
	{
		$this->db->select('*');
		$this->db->or_where('itemRowId', $this->input->post('hatana'));
		$this->db->or_where('itemRowId', $this->input->post('karna'));
		$this->db->order_by('dt,cashSaleRowId');
		$query = $this->db->get('cashsale');

		return($query->result_array());
	}
	public function showPurchaseDetail()
	{
		$this->db->select('*');
		$this->db->or_where('itemRowId', $this->input->post('hatana'));
		$this->db->or_where('itemRowId', $this->input->post('karna'));
		$this->db->order_by('purchaseDetailRowId');
		$query = $this->db->get('purchasedetail');

		return($query->result_array());
	}
	public function showSaleDetail()
	{
		$this->db->select('*');
		$this->db->or_where('itemRowId', $this->input->post('hatana'));
		$this->db->or_where('itemRowId', $this->input->post('karna'));
		$this->db->order_by('dbdRowId');
		$query = $this->db->get('dbdetail');

		return($query->result_array());
	}

	public function replaceNow()
	{
		set_time_limit(0);
		///fetching item name
		$this->db->select('itemName');
		$this->db->where('itemRowId', $this->input->post('karna'));
		$query = $this->db->get('items');
		$itemName = "";
		if ($query->num_rows() > 0)
		{
			$row = $query->row_array();
			$itemName = $row['itemName'];
		}

		/////QuotationDetail
		$data = array(
	        'itemRowId' => $this->input->post('karna')
	        , 'itemName' => $itemName
		);
		$this->db->where('itemRowId', $this->input->post('hatana'));
		$this->db->update('quotationdetail', $data);

		/////Cash Sale
		$data = array(
	        'itemRowId' => $this->input->post('karna')
	        , 'itemName' => $itemName
		);
		$this->db->where('itemRowId', $this->input->post('hatana'));
		$this->db->update('cashsale', $data);


		/////purchaseDetail
		$data = array(
	        'itemRowId' => $this->input->post('karna')
	        , 'itemName' => $itemName
		);
		$this->db->where('itemRowId', $this->input->post('hatana'));
		$this->db->update('purchasedetail', $data);

		/////dbDetail
		$data = array(
	        'itemRowId' => $this->input->post('karna')
	        , 'itemName' => $itemName
		);
		$this->db->where('itemRowId', $this->input->post('hatana'));
		$this->db->update('dbdetail', $data);


		///Deleting from Items Table
		$this->db->where('itemRowId', $this->input->post('hatana'));
        $this->db->delete('items');

	}

	public function delete()
	{
		$data = array(
		        'deleted' => 'Y',
		        'deletedBy' => $this->session->userRowId

		);
		$this->db->set('deletedStamp', 'NOW()', FALSE);
		$this->db->where('itemRowId', $this->input->post('rowId'));
		$this->db->update('items', $data);

		// $this->db->where('itemRowId', $this->input->post('rowId'));
		// $this->db->delete('items');
	}

}