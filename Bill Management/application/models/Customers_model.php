<?php
class Customers_model extends CI_Model 
{
    public function __construct()
    {
            $this->load->database('');
    }

    

    public function getDataLimit()
	{
		$this->db->select('customers.*');
		$this->db->from('customers');
		$this->db->where('customers.deleted', 'N');
		$this->db->order_by('customers.customerRowId desc');
		// $this->db->limit(5);
		$query = $this->db->get();

		return($query->result_array());
	}

    public function getDataAll()
	{
		$this->db->select('customers.*');
		$this->db->from('customers');
		$this->db->where('customers.deleted', 'N');
		$this->db->order_by('customers.customerRowId');
		$query = $this->db->get();

		return($query->result_array());
	}

    

	public function checkDuplicate()
    {
		$this->db->select('customerRowId');
		$this->db->where('customerName', $this->input->post('customerName'));
		$query = $this->db->get('customers');

		if ($query->num_rows() > 0)
		{
			return 1;
		}
    }

	public function insert()
    {
		$this->db->select_max('customerRowId');
		$query = $this->db->get('customers');
        $row = $query->row_array();

        $current_row = $row['customerRowId']+1;
		$data = array(
	        'customerRowId' => $current_row
	        , 'customerName' => ucwords($this->input->post('customerName'))
	        , 'address' => $this->input->post('address')
	        , 'mobile1' => $this->input->post('mobile1')
	        , 'mobile2' => $this->input->post('mobile2')
	        , 'remarks' => $this->input->post('remarks')
	        , 'remarks2' => $this->input->post('remarks2')
	        , 'createdBy' => $this->session->userRowId
		);
		$this->db->set('createdStamp', 'NOW()', FALSE);
		$this->db->insert('customers', $data);	
	}

	public function checkDuplicateOnUpdate()
    {
    	// echo "chk";
		$this->db->select('customerRowId');
		$this->db->where('customerName', $this->input->post('customerName'));
		$this->db->where('customerRowId !=', $this->input->post('globalrowid'));
		$query = $this->db->get('customers');

		if ($query->num_rows() > 0)
		{
			return 1;
		}
    }

	public function update()
    {
		$data = array(
	        'customerName' => ucwords($this->input->post('customerName'))
	        , 'address' => $this->input->post('address')
	        , 'mobile1' => $this->input->post('mobile1')
	        , 'mobile2' => $this->input->post('mobile2')
	        , 'remarks' => $this->input->post('remarks')
	        , 'remarks2' => $this->input->post('remarks2')
		);
		$this->db->where('customerRowId', $this->input->post('globalrowid'));
		$this->db->update('customers', $data);			
	}

	public function delete()
	{
		$data = array(
		        'deleted' => 'Y',
		        'deletedBy' => $this->session->userRowId

		);
		$this->db->set('deletedStamp', 'NOW()', FALSE);
		$this->db->where('customerRowId', $this->input->post('rowId'));
		$this->db->update('customers', $data);

		// $this->db->where('townRowId', $this->input->post('rowId'));
		// $this->db->delete('towns');
	}

	// public function getTownList()
	// {
	// 	$this->db->select('towns.*, districts.districtName, states.stateName, countries.countryName');
	// 	$this->db->from('towns');
	// 	$this->db->join('districts','districts.districtRowId = towns.districtRowId');
	// 	$this->db->join('states','states.stateRowId = districts.stateRowId');
	// 	$this->db->join('countries','countries.countryRowId = states.countryRowId');
	// 	$this->db->where('towns.deleted', 'N');
	// 	$this->db->order_by('towns.townName');
	// 	$query = $this->db->get();

	// 	return($query->result_array());
	// }

	// public function getTownListRefresh()
	// {
	// 	$this->db->select('towns.*, districts.districtName, states.stateName, countries.countryName');
	// 	$this->db->from('towns');
	// 	$this->db->join('districts','districts.districtRowId = towns.districtRowId');
	// 	$this->db->join('states','states.stateRowId = districts.stateRowId');
	// 	$this->db->join('countries','countries.countryRowId = states.countryRowId');
	// 	$this->db->where('towns.deleted', 'N');
	// 	$this->db->order_by('towns.townName');
	// 	$query = $this->db->get();

	// 	return($query->result_array());
	// }
}