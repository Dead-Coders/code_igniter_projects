<?php
class Edititems_model extends CI_Model 
{
    public function __construct()
    {
            $this->load->database('');
    }

    public function getDataForReport()
    {
        if($this->input->post('searchValue') == "" || strtoupper($this->input->post('searchValue')) == "ALL")
        {
            $this->db->select('items.*');            
        }
        else
        {
            $this->db->select('items.*'); 
            $this->db->like('items.itemName', $this->input->post('searchValue'));           
        }
        $this->db->from('items');
        $this->db->where('items.deleted', 'N');
        $this->db->order_by('itemName');
        $query = $this->db->get();
        return($query->result_array());
    }

    public function getDataForReportDeleted()
    {
        $this->db->select('items.*');
        $this->db->from('items');
        $this->db->where('items.deleted', 'Y');
        $this->db->order_by('itemName');
        $query = $this->db->get();
        return($query->result_array());
    }

    public function insert()
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
                'itemName' => $TableData[$i]['itemName']
                , 'sellingPrice' => (float)$TableData[$i]['sellingPrice']
                , 'pp' => (float)$TableData[$i]['pp']
            );
            $this->db->where('itemRowId', $TableData[$i]['itemRowId']);
            $this->db->update('items', $data);

            $data = array(
            'itemName' => $TableData[$i]['itemName']         
            );
            $this->db->where('itemRowId', $TableData[$i]['itemRowId']);
            $this->db->update('orderdetail', $data);    


            $data = array(
                'itemName' => $TableData[$i]['itemName']         
            );
            $this->db->where('itemRowId', $TableData[$i]['itemRowId']);
            $this->db->update('purchasedetail', $data); 

            $data = array(
                'itemName' => $TableData[$i]['itemName']         
            );
            $this->db->where('itemRowId', $TableData[$i]['itemRowId']);
            $this->db->update('quotationdetail', $data);    

            $data = array(
                'itemName' => $TableData[$i]['itemName']         
            );
            $this->db->where('itemRowId', $TableData[$i]['itemRowId']);
            $this->db->update('dbdetail', $data);   

            $data = array(
                'itemName' => $TableData[$i]['itemName']        
            );
            $this->db->where('itemRowId', $TableData[$i]['itemRowId']);
            $this->db->update('cashsale', $data);
            }

        $this->db->trans_complete();
    }

    public function delete()
    {
        $TableData = $this->input->post('TableData');
        $TableData = stripcslashes($TableData);
        $TableData = json_decode($TableData,TRUE);
        $myTableRows = count($TableData);
        for ($i=0; $i < $myTableRows; $i++) 
        {
            $data = array(
                    'deleted' => 'Y',
                    'deletedBy' => $this->session->userRowId

            );
            $this->db->set('deletedStamp', 'NOW()', FALSE);
            $this->db->where('itemRowId', $TableData[$i]['itemRowId']);
            $this->db->update('items', $data);
        }

        // $this->db->where('itemRowId', $this->input->post('rowId'));
        // $this->db->delete('items');
    }
    public function undelete()
    {
        $TableData = $this->input->post('TableData');
        $TableData = stripcslashes($TableData);
        $TableData = json_decode($TableData,TRUE);
        $myTableRows = count($TableData);
        for ($i=0; $i < $myTableRows; $i++) 
        {
            $data = array(
                    'deleted' => 'N',
                    'deletedBy' => $this->session->userRowId

            );
            // $this->db->set('deletedStamp', 'NOW()', FALSE);
            $this->db->where('itemRowId', $TableData[$i]['itemRowId']);
            $this->db->update('items', $data);
        }
    }
}