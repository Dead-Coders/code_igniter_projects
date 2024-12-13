<?php
class Replacement_model extends CI_Model 
{
    public function __construct()
    {
            $this->load->database('');
    }

    public function getCustomers()
    {
        $this->db->select('customers.*');
        $this->db->where('deleted', 'N');
        $this->db->order_by('customerName');
        $query = $this->db->get('customers');

        return($query->result_array());
    }   

    public function getItems()
	{
		$this->db->select('itemRowId, itemName');
		$this->db->where('deleted', 'N');
		$this->db->order_by('itemName');
		$query = $this->db->get('items');

		return($query->result_array());
	}	


    public function getDataLimit()
	{
		$this->db->select('*');
		$this->db->where('deleted', 'N');
		$this->db->where('recd', 'N');
		$this->db->order_by('replacementRowId');
		// $this->db->limit(5);
		$query = $this->db->get('replacement');

		return($query->result_array());
	}

	public function getDataLimitOld()
	{
		$this->db->select('*');
		$this->db->where('deleted', 'N');
		$this->db->where('recd', 'Y');
		$this->db->order_by('replacementRowId desc');
		$this->db->limit(15);
		$query = $this->db->get('replacement');

		return($query->result_array());
	}

    public function getDataAllOld()
	{
		$this->db->select('*');
		$this->db->where('deleted', 'N');
		$this->db->where('recd', 'Y');
		$this->db->order_by('replacementRowId desc');
		$query = $this->db->get('replacement');

		return($query->result_array());
	}

    
	public function insert()
    {
    	set_time_limit(0);
        $this->db->trans_start();

		$this->db->select_max('replacementRowId');
		$query = $this->db->get('replacement');
        $row = $query->row_array();

        $current_row = $row['replacementRowId']+1;

        $dt = date('Y-m-d', strtotime($this->input->post('dt')));
        
		$data = array(
	        'replacementRowId' => $current_row
	        , 'dt' => $dt
	        , 'itemRowId' => $this->input->post('itemRowId')
	        , 'itemName' => $this->input->post('itemName')
	        , 'partyRowId' => $this->input->post('partyRowId')
	        , 'partyName' => $this->input->post('partyName')
	        , 'qty' => $this->input->post('qty')
	        , 'remarks' => $this->input->post('remarks')
	        , 'createdBy' => $this->session->userRowId
		);
		$this->db->set('createdStamp', 'NOW()', FALSE);
		$this->db->insert('replacement', $data);	
		
		$this->db->trans_complete();		
	}

	public function update()
    {
    	set_time_limit(0);
        $this->db->trans_start();

        $dt = date('Y-m-d', strtotime($this->input->post('dt')));

		$data = array(
	        'dt' => $dt
	        , 'itemRowId' => $this->input->post('itemRowId')
	        , 'itemName' => $this->input->post('itemName')
	        , 'partyRowId' => $this->input->post('partyRowId')
	        , 'partyName' => $this->input->post('partyName')
	        , 'qty' => $this->input->post('qty')
	        , 'remarks' => $this->input->post('remarks')
		);
		$this->db->where('replacementRowId', $this->input->post('globalrowid'));
		$this->db->update('replacement', $data);	

		

		$this->db->trans_complete();		
	}

	public function delete()
	{
		$this->db->where('replacementRowId', $this->input->post('rowId'));
		$this->db->delete('replacement');
	}

	public function setSent()
    {
    	set_time_limit(0);
        $this->db->trans_start();

        $TableData = $this->input->post('TableData');
        $TableData = stripcslashes($TableData);
        $TableData = json_decode($TableData,TRUE);
        $myTableRows = count($TableData);
        for ($i=0; $i < $myTableRows; $i++) 
        {
        	$data = array(
		        'sent' => 'Y'
		        , 'sentDt' => date('Y-m-d')
			);
			$this->db->where('replacementRowId', $TableData[$i]['rowId']);
			$this->db->update('replacement', $data);
        }

		$this->db->trans_complete();		
	}
	public function setRecd()
    {
    	set_time_limit(0);
        $this->db->trans_start();

        $TableData = $this->input->post('TableData');
        $TableData = stripcslashes($TableData);
        $TableData = json_decode($TableData,TRUE);
        $myTableRows = count($TableData);
        for ($i=0; $i < $myTableRows; $i++) 
        {
        	$data = array(
		        'recd' => 'Y'
		        , 'recdDt' => date('Y-m-d')
			);
			$this->db->where('replacementRowId', $TableData[$i]['rowId']);
			$this->db->update('replacement', $data);
        }


		// $data = array(
	 //        'recd' => 'Y'
	 //        , 'recdDt' => date('Y-m-d')
		// );
		// $this->db->where('replacementRowId', $this->input->post('rowId'));
		// $this->db->update('replacement', $data);	

		$this->db->trans_complete();		
	}
}