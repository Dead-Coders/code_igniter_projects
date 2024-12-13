<?php
class Duplicatecustomers_model extends CI_Model 
{
    public function __construct()
    {
            $this->load->database('');
    }

    public function getDataAll()
	{
		$this->db->select('*');
		$this->db->where('deleted', 'N');
		$this->db->order_by('customerName');
		$query = $this->db->get('customers');

		return($query->result_array());
	}

	public function showQuotaion()
	{
		$this->db->select('quotation.*, customers.customerName');
		$this->db->or_where('quotation.customerRowId', $this->input->post('hatana'));
		$this->db->or_where('quotation.customerRowId', $this->input->post('karna'));
		$this->db->join('customers','customers.customerRowId = quotation.customerRowId');
		$this->db->order_by('quotationRowId');
		$query = $this->db->get('quotation');

		return($query->result_array());
	}

	public function showLedger()
	{
		$this->db->select('ledger.*, customers.customerName');
		$this->db->or_where('ledger.customerRowId', $this->input->post('hatana'));
		$this->db->or_where('ledger.customerRowId', $this->input->post('karna'));
		$this->db->join('customers','customers.customerRowId = ledger.customerRowId');
		$this->db->order_by('ledgerRowId');
		$query = $this->db->get('ledger');

		return($query->result_array());
	}

	public function showPurchase()
	{
		$this->db->select('purchase.*, customers.customerName');
		$this->db->or_where('purchase.customerRowId', $this->input->post('hatana'));
		$this->db->or_where('purchase.customerRowId', $this->input->post('karna'));
		$this->db->join('customers','customers.customerRowId = purchase.customerRowId');
		$this->db->order_by('purchaseRowId');
		$query = $this->db->get('purchase');

		return($query->result_array());
	}
	public function showSale()
	{
		$this->db->select('db.*, customers.customerName');
		$this->db->or_where('db.customerRowId', $this->input->post('hatana'));
		$this->db->or_where('db.customerRowId', $this->input->post('karna'));
		$this->db->join('customers','customers.customerRowId = db.customerRowId');
		$this->db->order_by('dbRowId');
		$query = $this->db->get('db');

		return($query->result_array());
	}

	public function replaceNow()
	{
		set_time_limit(0);

		/////Quotation
		$data = array(
	        'customerRowId' => $this->input->post('karna')
		);
		$this->db->where('customerRowId', $this->input->post('hatana'));
		$this->db->update('quotation', $data);

		/////Ledger
		$data = array(
	        'customerRowId' => $this->input->post('karna')
		);
		$this->db->where('customerRowId', $this->input->post('hatana'));
		$this->db->update('ledger', $data);


		/////purchase
		$data = array(
	        'customerRowId' => $this->input->post('karna')
		);
		$this->db->where('customerRowId', $this->input->post('hatana'));
		$this->db->update('purchase', $data);

		/////db
		$data = array(
	        'customerRowId' => $this->input->post('karna')
		);
		$this->db->where('customerRowId', $this->input->post('hatana'));
		$this->db->update('db', $data);


		///Deleting from Items Table
		$this->db->where('customerRowId', $this->input->post('hatana'));
        $this->db->delete('customers');

	}


}