<?php
class Rptdues_model extends CI_Model 
{
    public function __construct()
    {
            $this->load->database('');
    }

    public function getDues()
    {
        $q = "Select sum(amt)-sum(recd) as balance, ledger.customerRowId, customers.customerName, customers.mobile1, doobat from ledger, customers where ledger.customerRowId=customers.customerRowId AND ledger.deleted='N' AND NOT customers.remarks='dont show in dues' group by customerRowId having balance>0 order by customerName";
        $query = $this->db->query($q);
        return($query->result_array());
    }

    public function getDuesNegative()
    {
        $q = "Select sum(amt)-sum(recd) as balance, ledger.customerRowId, customers.customerName from ledger, customers where ledger.customerRowId=customers.customerRowId AND ledger.deleted='N' AND NOT customers.remarks='dont show in dues' group by customerRowId having balance<0 order by customerName";
        $query = $this->db->query($q);
        return($query->result_array());
    }

    public function saveDateNew()
    {
        if($this->input->post('dtNew') == '')
        {
            $dtNew = null;
        }
        else
        {
            $dtNew = date('Y-m-d', strtotime($this->input->post('dtNew')));
        }
        $data = array(
            'reminder' => $dtNew
        );
        $this->db->where('ledgerRowId', $this->input->post('gLedgerRowId'));
        $this->db->update('ledger', $data);  
    }


    public function showDetail()
    {
     $this->db->select('ledger.*');
     $this->db->from('ledger');
     $this->db->where('ledger.deleted', 'N');
     $this->db->where('ledger.customerRowId', $this->input->post('customerRowId'));
     $this->db->where('ledger.bal >', 0);
     $this->db->order_by('ledger.refDt, ledgerRowId');
     $query = $this->db->get();
     return($query->result_array());
    }

    public function receiveAmt()
    {
        set_time_limit(0);
        $this->db->trans_start();
        $customerRowId = $this->input->post('customerRowId');
         
        
        $this->db->select_max('refRowId');
        $this->db->where('ledger.vType', 'R');
        $query = $this->db->get('ledger');
        $row = $query->row_array();
        $refRowId = $row['refRowId']+1;

        $this->db->select_max('ledgerRowId');
        $query = $this->db->get('ledger');
        $row = $query->row_array();
        $ledgerRowId = $row['ledgerRowId']+1;

        $dt = date('Y-m-d');
        $data = array(
            'ledgerRowId' => $ledgerRowId
            , 'vType' => 'R'
            , 'refRowId' => $refRowId
            , 'refDt' => $dt
            , 'customerRowId' => $customerRowId
            , 'recd' => $this->input->post('rAmt')
            , 'orderRowId' => -333
            , 'remarks' => 'rid-'.$this->input->post('remarks')
        );
        $this->db->insert('ledger', $data);

        $this->db->trans_complete();
    }


    public function payAmt()
    {
        set_time_limit(0);
        $this->db->trans_start();
        $customerRowId = $this->input->post('customerRowId');
         
        
        $this->db->select_max('refRowId');
        $this->db->where('ledger.vType', 'P');
        $query = $this->db->get('ledger');
        $row = $query->row_array();
        $refRowId = $row['refRowId']+1;

        $this->db->select_max('ledgerRowId');
        $query = $this->db->get('ledger');
        $row = $query->row_array();
        $ledgerRowId = $row['ledgerRowId']+1;

        $dt = date('Y-m-d');
        $data = array(
            'ledgerRowId' => $ledgerRowId
            , 'vType' => 'P'
            , 'refRowId' => $refRowId
            , 'refDt' => $dt
            , 'customerRowId' => $customerRowId
            , 'amt' => $this->input->post('rAmt')
            , 'bal' => $this->input->post('rAmt')
            , 'orderRowId' => -444
            , 'remarks' => 'pid-'.$this->input->post('remarks')
        );
        $this->db->insert('ledger', $data);

        $this->db->trans_complete();
    }

    public function markDoobat()
    {
        set_time_limit(0);
        $this->db->trans_start();
        $customerRowId = $this->input->post('customerRowId');
         
        if($this->input->post('abhiDoobatHaiKya') == "Yes")
        {
            $data = array(
                'doobat' => "No"
            );
        }
        else
        {
            $data = array(
                'doobat' => "Yes"
            );
        }
        $this->db->where('customerRowId', $this->input->post('customerRowId'));
        $this->db->update('customers', $data);  

        $this->db->trans_complete();
    }

    public function deleteOldRecs()
    {
        set_time_limit(0);
        $dt = date('Y-m-d', strtotime($this->input->post('dt')));

        ///////// Sab Parties k balance Fwd (clBal -> opBal) kr rahe h
            $this->db->select('sum(amt) - sum(recd) as bal, ledger.customerRowId');
            $this->db->from('ledger');
            $this->db->where('ledger.deleted', 'N');
            $this->db->where('refDt<', $dt);
            $this->db->group_by('ledger.customerRowId');
            $this->db->order_by('ledger.customerRowId');
            $query = $this->db->get();
            foreach ($query->result_array() as $row)
            {
                if( $row['bal'] > 0 ) //// amt
                {
                    $amt = abs($row['bal']);
                    $recd = 0;
                }
                else  //// recd
                {
                    $amt = 0;
                    $recd = abs($row['bal']);
                }
                ////// insert in ledgerA
                $this->db->select_max('ledgerRowId');
                $queryInner = $this->db->get('ledger');
                $rowInner = $queryInner->row_array();
                $rowId = $rowInner['ledgerRowId']+1;

                $data = array(
                    'ledgerRowId' => $rowId
                    , 'vType' => 'OB'
                    , 'customerRowId' => $row['customerRowId']
                    , 'refRowId' => 1
                    , 'refDt' => date('Y-m-d', strtotime($this->input->post('dt')))
                    , 'amt' => floatval( $amt )  /// floatVal se agar null hoga to 0 ho jayega
                    , 'recd' => floatval( $recd )
                    , 'bal' => floatval( $amt )
                    , 'remarks' => ''
                );
                $this->db->insert('ledger', $data);                
            }/// loop end
        ///////// END - Sab Parties k balance Fwd (clBal -> opBal) kr rahe h

        ///// del ledger
            $this->db->where('refDt<', $dt);
            $this->db->delete('ledger');
        ///// END -del ledger

        ///// END - Op. Bal Ac. RowId
     // ///// del 0 bal from ledger
     //    $this->db->select('customerRowId');
     //    $this->db->select('sum(amt)-sum(recd) as bal');
     //    // $this->db->where('sum(amt)-sum(recd)', 0);
     //    $this->db->group_by('customerRowId');
     //    $this->db->having('sum(amt)-sum(recd)', 0);
     //    $query = $this->db->get('ledger');

     //    foreach ($query->result_array() as $row)
     //    {
     //        $this->db->where('customerRowId', $row['customerRowId']);
     //        $this->db->delete('ledger');
     //    }


     ///// del BKP table all
        $this->db->where('rowId>', 0);
        $this->db->delete('bkp');

     ///// del Complaints
        $this->db->where('solved', 'Y');
        $this->db->delete('complaints');

     ///// del Notifications
        $this->db->where('deleted', 'Y');
        $this->db->delete('notifications');

     ///// del reminders
        $this->db->where('deleted', 'Y');
        $this->db->delete('reminders');

     ///// del replacement
        $this->db->where('sent', 'Y');
        $this->db->where('recd', 'Y');
        $this->db->delete('replacement');
    
    ///// del SendSms table all
        $this->db->where('smsRowId>', 0);
        $this->db->delete('sendsms');        

     ///// del Sale before defined dt
        $this->db->where('dbDt<', $dt);
        $this->db->delete('db');
        $this->db->query('DELETE FROM dbdetail WHERE dbRowId NOT IN (Select dbRowId from db)'); 

     ///// del Purchase before defined dt
        $this->db->where('purchaseDt<', $dt);
        $this->db->delete('purchase');
        $this->db->query('DELETE FROM purchasedetail WHERE purchaseRowId NOT IN (Select purchaseRowId from purchase)');  
    }
}