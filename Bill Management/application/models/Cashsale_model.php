<?php
class Cashsale_model extends CI_Model 
{
    public $globalDbNo = 0;
    public function __construct()
    {
            $this->load->database('');
    }

    public function getItems()
	{
        $this->db->select('itemRowId, itemName, sellingPrice as rate');
        $this->db->where('deleted', 'N');
        $this->db->order_by('itemName');
        $query = $this->db->get('items');
        return($query->result_array());
        
        // $q = 'SELECT items.itemRowId, items.itemName,cashSaleRowId, rate
        //         FROM items 
        //         LEFT Join
        //         (SELECT S.cashSaleRowId, S.itemRowId, S.rate, dt
        //         FROM cashsale AS S
        //         Inner Join
        //         (SELECT S2.itemRowId,  Max(S2.dt) AS maxDt
        //         FROM cashsale AS S2
        //         GROUP BY S2.itemRowId) As S3
        //         ON S.itemRowId=S3.itemRowId AND S.dt= S3.maxDt) As S4
        //         On items.itemRowId=S4.itemRowId where items.deleted="N" ORDER BY items.itemName, cashSaleRowId desc';

        // $query = $this->db->query($q);
        // return($query->result_array());
	}	

 
	public function insert()
    {
		set_time_limit(0);
        $this->db->trans_start();
        $this->db->query('LOCK TABLE cashsale WRITE, items WRITE');

        $dt = date('Y-m-d', strtotime($this->input->post('dt')));
        $TableData = $this->input->post('TableDataItems');
        $TableData = stripcslashes($TableData);
        $TableData = json_decode($TableData,TRUE);
        $myTableRows = count($TableData);
        for ($i=0; $i < $myTableRows; $i++) 
        {
            $this->db->select('cashsale.dt');
            $this->db->where('cashSaleRowId', $TableData[$i]['cashSaleRowId']);
            $this->db->where('dt', $dt);
            $this->db->from('cashsale');
            $queryQ = $this->db->get();
            if ($queryQ->num_rows() > 0) //found that RowId on that update
            {
                if( $TableData[$i]['mode'] == "C" ) ///Collection
                {
                    $data = array(
                            'mode' => 'C'
                            , 'qty' => (float) $TableData[$i]['qty']
                            , 'rate' => (float) $TableData[$i]['rate']
                            , 'amt' => $TableData[$i]['amt']
                            , 'remarks' => $TableData[$i]['remarks']
                    );
                }
                else  ///Expenditure
                {
                    $data = array(
                            'mode' => 'E'
                            , 'qty' => (float) $TableData[$i]['qty']
                            , 'rate' => (float) $TableData[$i]['rate']
                            , 'amt' => $TableData[$i]['amt']
                            , 'remarks' => $TableData[$i]['remarks']
                    );                    
                }
                $this->db->where('cashSaleRowId', $TableData[$i]['cashSaleRowId']);
                $this->db->where('dt', $dt);
                $this->db->update('cashsale', $data); 
            }
            else /// Naya Record Dala h.
            {
                $this->db->select_max('cashSaleRowId');
                $this->db->where('dt', $dt);
                $query = $this->db->get('cashsale');
                $row = $query->row_array();
                $cashSaleRowId = $row['cashSaleRowId']+1;

                if ( $TableData[$i]['itemRowId'] == "-1")
                {
                    $this->db->select_max('itemRowId');
                    $query = $this->db->get('items');
                    $row = $query->row_array();

                    $itemRowId = $row['itemRowId']+1;
                    $data = array(
                        'itemRowId' => $itemRowId
                        , 'itemName' => ucwords($TableData[$i]['itemName'])
                        , 'createdBy' => $this->session->userRowId
                    );
                    $this->db->set('createdStamp', 'NOW()', FALSE);
                    $this->db->insert('items', $data);  
                }
                else
                {
                    $itemRowId = $TableData[$i]['itemRowId'];
                }
                if( $TableData[$i]['mode'] == "C" ) ///Collection
                {
                    $data = array(
                            'cashSaleRowId' => $cashSaleRowId
                            , 'mode' => 'C'
                            , 'dt' => $dt
                            , 'itemRowId' => $itemRowId
                            , 'itemName' => $TableData[$i]['itemName']
                            , 'qty' => (float) $TableData[$i]['qty']
                            , 'rate' => (float) $TableData[$i]['rate']
                            , 'amt' => $TableData[$i]['amt']
                            , 'remarks' => $TableData[$i]['remarks']
                    );
                }
                else  /// Expenditure
                {
                    $data = array(
                            'cashSaleRowId' => $cashSaleRowId
                            , 'mode' => 'E'
                            , 'dt' => $dt
                            , 'itemRowId' => $itemRowId
                            , 'itemName' => $TableData[$i]['itemName']
                            , 'qty' => (float) $TableData[$i]['qty']
                            , 'rate' => (float) $TableData[$i]['rate']
                            , 'amt' => $TableData[$i]['amt']
                            , 'remarks' => $TableData[$i]['remarks']
                    );                    
                }
                $this->db->insert('cashsale', $data);   
            }
        }

        $this->db->query('UNLOCK TABLES');

        $this->db->trans_complete();	
	}


    public function loadDataOfThisDate()
    {
        $dt = date('Y-m-d', strtotime($this->input->post('dt')));
        $this->db->select('cashsale.*');
        // $this->db->where('quotation.remarks', 'Cash Sale');
        $this->db->where('cashsale.dt', $dt);
        // $this->db->join('quotation','quotation.quotationRowId = cashsale.quotationRowId');
        $this->db->order_by('cashSaleRowId');
        $query = $this->db->get('cashsale');

        return($query->result_array());
    }
    
}