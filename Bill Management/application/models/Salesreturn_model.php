<?php
class Salesreturn_model extends CI_Model 
{
    public $globalDbNo = 0;
    public function __construct()
    {
            $this->load->database('');
    }

 
 
	public function insert()
    {
		set_time_limit(0);
        $this->db->trans_start();
        $customerRowId = $this->input->post('customerRowId');
        
        /////// Deleting if already done SR
        $this->db->where('vType', 'SR');
        $this->db->where('refRowId', $this->input->post('srRowId'));
        $this->db->delete('ledger');

        $this->db->where('srRowId', $this->input->post('srRowId'));
        $this->db->delete('sr');

        $this->db->where('srRowId', $this->input->post('srRowId'));
        $this->db->delete('srdetail');
        /////// Deleting if already done SR


        ///Inserting in SR table
        $this->db->select_max('srRowId');
        $query = $this->db->get('sr');
        $row = $query->row_array();

        $srRowId = $row['srRowId']+1;
        $this->globalDbNo = $srRowId;

        $dt = date('Y-m-d', strtotime($this->input->post('dt')));
        
        $data = array(
            'srRowId' => $srRowId
            , 'dbRowId' => $this->input->post('dbRowId')
            , 'srDt' => $dt
            , 'customerRowId' => $customerRowId
            , 'totalAmount' => (float)$this->input->post('totalAmt')
            , 'createdBy' => $this->session->userRowId
        );
        $this->db->set('createdStamp', 'NOW()', FALSE);
        $this->db->insert('sr', $data); 

        /////Saving in SrDetail
        $TableData = $this->input->post('TableDataItems');
        $TableData = stripcslashes($TableData);
        $TableData = json_decode($TableData,TRUE);
        $myTableRows = count($TableData);
        for ($i=0; $i < $myTableRows; $i++) 
        {
            $this->db->select_max('srdRowId');
            $query = $this->db->get('srdetail');
            $row = $query->row_array();
            $srdRowId = $row['srdRowId']+1;
            
            $itemRowId = $TableData[$i]['itemRowId'];
            $data = array(
                    'srdRowId' => $srdRowId
                    , 'srRowId' => $srRowId
                    , 'itemRowId' => $itemRowId
                    , 'itemName' => $TableData[$i]['itemName']
                    , 'qty' => (float) $TableData[$i]['qty']
                    , 'rqty' => (float) $TableData[$i]['rqty']
                    , 'rate' => (float) $TableData[$i]['rate']
                    , 'amt' => $TableData[$i]['amt']

            );
            $this->db->insert('srdetail', $data);    
        }
        /////END - in Invoice Detail


        ////////////// LEDGER ENTRY Cr.
        $this->db->select_max('ledgerRowId');
        $query = $this->db->get('ledger');
        $row = $query->row_array();

        $ledgerRowId = $row['ledgerRowId']+1;
        $data = array(
            'ledgerRowId' => $ledgerRowId
            , 'vType' => 'SR'
            , 'refRowId' => $srRowId
            , 'refDt' => $dt
            , 'customerRowId' => $customerRowId
            , 'recd' => $this->input->post('totalAmt')
            , 'orderRowId' => -321
            , 'dbRowId' => $this->input->post('dbRowId')
            , 'remarks' => $this->input->post('remarks')
        );
        $this->db->insert('ledger', $data);
        ////////////// END - LEDGER ENTRY   


        $this->db->trans_complete();	
	}





    public function getDataLimitSold()
    {
        $this->db->select('db.*, customers.customerName');
        $this->db->join('customers','customers.customerRowId = db.customerRowId');
        $this->db->order_by('dbRowId desc');
        $this->db->limit(15);
        $query = $this->db->get('db');

        return($query->result_array());
    }
    
    public function getDataAllSold()
    {
        $this->db->select('db.*, customers.customerName');
        $this->db->join('customers','customers.customerRowId = db.customerRowId');
        $this->db->order_by('dbRowId');
        $query = $this->db->get('db');

        return($query->result_array());
    }

    


    // public function showDetail()
    // {
    //     $this->db->select('srdetail.*');
    //     $this->db->where('srRowId', $this->input->post('globalrowid'));
    //     $this->db->order_by('srdRowId');
    //     $query = $this->db->get('srdetail');

    //     return($query->result_array());
    // }

    public function getSoldDetail()
    {
        $this->db->select('dbdetail.*');
        $this->db->where('dbdetail.dbRowId', $this->input->post('dbRowId'));
        $this->db->from('dbdetail');
        $this->db->order_by('dbdRowId');
        $query = $this->db->get();
        return($query->result_array());
    }

    public function getSrDetail()
    {
        $this->db->select('srdetail.*,sr.dbRowId');
        $this->db->where('sr.dbRowId', $this->input->post('dbRowId'));
        $this->db->join('sr','srdetail.srRowId = sr.srRowId');
        $this->db->from('srdetail');
        $this->db->order_by('srdRowId');
        $query = $this->db->get();
        return($query->result_array());
    }
    
}