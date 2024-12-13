<?php
class Requirement_model extends CI_Model 
{
    public function __construct()
    {
            $this->load->database('');
    }

    public function getItemList()
    {
        $this->db->select('items.*');
        $this->db->where('deleted', 'N');
        $this->db->order_by('itemName');
        $query = $this->db->get('items');

        return($query->result_array());
    }   

    public function getDataLimit()
	{
		$this->db->select('*');
		// $this->db->where('deleted', 'N');
		$this->db->order_by('rowId');
		$query = $this->db->get('requirement');

		return($query->result_array());
	}


	public function insert()
    {
        //// Last min purchase rate
    	$this->db->select('purchasedetail.*');
    	$this->db->where('itemRowId', $this->input->post('itemRowId'));
    	$this->db->order_by('purchaseRowId');
		$query = $this->db->get('purchasedetail');
        $row = $query->last_row('array');
        // $lastRate = $row['rate'];
        $lastRate=0;
        $purchaseDt="01-01-1111";
        $purchaseFrom="NA";
        if ($query->num_rows() > 0)
        {
            if($row['qty'] == 0)
            {
            	$lastRate = 0;
            }
            else
            {
            	// $lastRate = ($row['amt'] + $row['igstAmt'] + $row['cgstAmt'] + $row['sgstAmt']) /  $row['qty'];
                $lastRate = ($row['netAmt']) /  $row['qty'];
            }
            $purchaseRowId = $row['purchaseRowId'];
            //// END - Last min purchase rate

            ///////Purchase Dt n Supp. name
        	$this->db->select('purchaseDt, customerName');
        	$this->db->where('purchaseRowId', $purchaseRowId);
        	$this->db->join('customers','customers.customerRowId = purchase.customerRowId');
    		$query = $this->db->get('purchase');
            $row = $query->row_array();
            $purchaseDt = $row['purchaseDt'];
            $purchaseFrom = $row['customerName'];
            /////// END - Purchase Dt n Supp. name
        }

		$this->db->select_max('rowId');
		$query = $this->db->get('requirement');
        $row = $query->row_array();

        $current_row = $row['rowId']+1;

		$data = array(
	        'rowId' => $current_row
	        , 'itemRowId' => $this->input->post('itemRowId')
            , 'itemName' => ucwords($this->input->post('itemName'))
            , 'qty' => ($this->input->post('qty'))
	        , 'remarks' => ($this->input->post('remarks'))
	        , 'lastPurchasePrice' => (float)$lastRate
	        , 'lastPurchaseDate' => $purchaseDt
	        , 'lastPurchaseFrom' => $purchaseFrom
	        , 'createdBy' => $this->session->userRowId
		);
		$this->db->set('createdStamp', 'NOW()', FALSE);
		$this->db->insert('requirement', $data);	
	}


	public function delete()
	{
		$this->db->where('rowId', $this->input->post('rowId'));
		$this->db->delete('requirement');
	}

    public function deleteChecked()
    {
        $TableData = $this->input->post('TableData');
        $TableData = stripcslashes($TableData);
        $TableData = json_decode($TableData,TRUE);
        $myTableRows = count($TableData);

        for ($i=0; $i < $myTableRows; $i++) 
        {
            $this->db->where('rowId', $TableData[$i]['rowId']);
            $this->db->delete('requirement');
        }
    }

    public function getPurchaseLog()
    {
     $this->db->select('purchasedetail.*, customers.customerName, purchase.purchaseDt');
     $this->db->from('purchasedetail');
     $this->db->join('purchase','purchase.purchaseRowId = purchasedetail.purchaseRowId');
     $this->db->join('customers','customers.customerRowId = purchase.customerRowId');
     $this->db->where('purchase.deleted', 'N');
     $this->db->where('purchasedetail.itemRowId', $this->input->post('itemRowId'));
     $this->db->order_by('purchase.purchaseDt, purchaseRowId');
     $query = $this->db->get();
     return($query->result_array());
    }
}