<?php
class Rptpurchaseanalysis_model extends CI_Model 
{
    public function __construct()
    {
            $this->load->database('');
    }

    public function getItemGroups()
    {
        $this->db->select('itemgroups.*');
        $this->db->where('deleted', 'N');
        $this->db->order_by('itemGroupName');
        $query = $this->db->get('itemgroups');
        return($query->result_array());
    }

    public function getDataForReport()
    {
        $TableData = $this->input->post('TableData');
        $TableData = stripcslashes($TableData);
        $TableData = json_decode($TableData,TRUE);
        $myTableRows = count($TableData);


        $this->db->distinct();
        // $this->db->select_sum('purchasedetail.qty');            
        $this->db->select('purchasedetail.itemRowId, purchasedetail.itemName');            
        $this->db->where('items.itemGroupRowId', $this->input->post('itemGroupRowId'));
        $this->db->join('items','items.itemRowId = purchasedetail.itemRowId');
        $this->db->join('itemgroups','itemgroups.itemGroupRowId = items.itemGroupRowId');
        // $this->db->join('purchase','purchase.purchaseRowId = purchasedetail.purchaseRowId AND purchase.deleted="N"');
        $this->db->from('purchasedetail');
        // $this->db->group_by('itemRowId');
        $this->db->order_by('itemName');
        // $this->db->limit(15);
        $query = $this->db->get();
        // return($query->result_array());
        $rows = array();
        foreach($query->result_array() as $row)
        {
            for ($i=0; $i < $myTableRows; $i++) 
            {
                $row[$TableData[$i]['r1'] . ' to ' . $TableData[$i]['r2']] = 0;
                $this->db->select_sum('purchasedetail.qty');            
                $this->db->from('purchasedetail');
                $this->db->join('purchase','purchase.purchaseRowId = purchasedetail.purchaseRowId AND purchase.deleted="N"');
                $this->db->where('purchase.purchaseDt >=', date('Y-m-d', strtotime($TableData[$i]['r1'])));
                $this->db->where('purchase.purchaseDt <=', date('Y-m-d', strtotime($TableData[$i]['r2'])));
                $this->db->where('purchasedetail.itemRowId', $row['itemRowId']);
                // $this->db->where('ss_attendance.attendanceTypeRowId', $rowAttendanceTypes['attendanceTypeRowId']);
                $queryInner = $this->db->get();
                if ($queryInner->num_rows() > 0)         
                {
                    $rowInner = $queryInner->row_array();
                    $row[$TableData[$i]['r1'] . ' to ' . $TableData[$i]['r2']] = $rowInner['qty'];
                }
            }

            $rows[] = $row;
        }
        return $rows;
    }
}