<?php
class Dailycash_model extends CI_Model 
{
    public function __construct()
    {
            $this->load->database('');
    }

    public function getOpeningBal()
    {
     $this->db->select_Sum('out');
     $this->db->select_Sum('in');
     $this->db->from('dailycash');
     $this->db->where('dailycash.dt <', date('Y-m-01'));
     // $this->db->where('dailycash.dt <', date('Y-m-d', strtotime($this->input->post('dtFrom'))));
     $query = $this->db->get();
     return($query->result_array());
    }
    
    public function getPlusDues()
    {
        $q = "Select sum(amt)-sum(recd) as balance, ledger.customerRowId, doobat from ledger, customers where ledger.customerRowId=customers.customerRowId AND ledger.deleted='N' AND doobat='No' AND NOT customers.remarks='dont show in dues' group by customerRowId having balance>0 order by customerName";

        $query = $this->db->query($q);
        return($query->result_array());
    }

    public function getMinusDues()
    {
        $q = "Select sum(amt)-sum(recd) as balance, ledger.customerRowId, doobat from ledger, customers where ledger.customerRowId=customers.customerRowId AND ledger.deleted='N' AND NOT customers.remarks='dont show in dues' group by customerRowId having balance<0 order by customerName";
        $query = $this->db->query($q);
        return($query->result_array());
    }

    public function getPurchaseSum()
    {
     $this->db->select_sum('amt');
     $this->db->from('ledger');
     $this->db->where('ledger.refDt', date('Y-m-d'));
     $this->db->where('ledger.vType', 'PV');
     $this->db->where('ledger.deleted', 'N');
     $query = $this->db->get();
     return($query->result_array());
    }
    public function getPaymentsSum()
    {
     $this->db->select_sum('amt');
     $this->db->from('ledger');
     $this->db->where('ledger.refDt', date('Y-m-d'));
     $this->db->where('ledger.vType', 'P');
     $this->db->where('ledger.deleted', 'N');
     $query = $this->db->get();
     return($query->result_array());
    }
    public function getUpiCollection()
    {
     $this->db->select_sum('amt');
     $this->db->from('ledger');
     $this->db->where('ledger.refDt', date('Y-m-d'));
     $this->db->where('ledger.vType', 'P');
     $this->db->where('ledger.deleted', 'N');
     $this->db->where('ledger.remarks', 'UPI');
     $query = $this->db->get();
     return($query->result_array());
    }


    public function getDataLimit()
    {
     $this->db->select('dailycash.*');
     $this->db->from('dailycash');
     $this->db->where('dailycash.dt >=', date('Y-m-01'));
     // $this->db->where('dailycash.dt <=', date('Y-m-d', strtotime($this->input->post('dtTo'))));
     // $this->db->where('dailycash.dt >=', date('Y-m-d', strtotime($this->input->post('dtFrom'))));
     // $this->db->limit(5);
     $this->db->order_by('dailycash.dt, rowId');
     $query = $this->db->get();
     return($query->result_array());
    }
    public function getDataAll()
    {
     $this->db->select('dailycash.*');
     $this->db->from('dailycash');
     $this->db->order_by('dailycash.dt, rowId');
     $query = $this->db->get();
     return($query->result_array());
    }

    public function insert()
    {
        set_time_limit(0);
        $this->db->trans_start();

        $dt = date('Y-m-d', strtotime($this->input->post('dt')));

        ////Kya is date ki entry pahle se h???
        $this->db->select('*');
        $this->db->where('dt', $dt);
        $query = $this->db->get('dailycash');
        if ($query->num_rows() > 0) ///agar already h ye date ka record, OverWrite
        {
            $row = $query->row_array();
            $rowId = $row['rowId'];
            $rem = $row['remarks'];

            ////// msg in case of modify
                $this->db->select('dailycash.in, dailycash.out');
                $this->db->from('dailycash');
                $this->db->where('rowId', $rowId);
                $queryInner = $this->db->get();
                if ($queryInner->num_rows() > 0) ///agar already h ye date ka record, OverWrite
                {
                    $rowInner = $queryInner->row_array();
                    $inAmt = $rowInner['in']; 
                    $outAmt = $rowInner['out']; 

                    if($this->input->post('inOutMode') == "IN" && $inAmt > 0)
                    {
                        $mobile = "9929598700";
                        $sms = "D-Cash Edit (IN): " . $inAmt . " / " . $this->input->post('amt') ;

                        $this->sendSms($mobile, $sms);
                    }
                    if($this->input->post('inOutMode') == "OUT" && $outAmt > 0)
                    {
                        $mobile = "9929598700";
                        $sms = "D-Cash Edit (OUT): " . $outAmt . " / " . $this->input->post('amt') ;

                        $this->sendSms($mobile, $sms);
                    }
                }
            ////// END - msg in case of modify

            
            if($this->input->post('inOutMode') == "IN")
            {
                $data = array(
                    'in' => $this->input->post('amt')
                    , 'remarks' => $this->input->post('remarks')
                    , 'denominationIn' => $this->input->post('deno')
                );
                $this->db->where('rowId', $rowId);
                $this->db->update('dailycash', $data);  
            }
            else if($this->input->post('inOutMode') == "OUT")
            {
                $data = array(
                    'out' => $this->input->post('amt')
                    , 'remarks' => $rem . ' ' . $this->input->post('remarks')
                    , 'denominationOut' => $this->input->post('deno')
                );
                $this->db->where('rowId', $rowId);
                $this->db->update('dailycash', $data); 
            }
        }
        else
        {
            if($this->input->post('inOutMode') == "IN")
            {
                $this->db->select_max('rowId');
                $query1 = $this->db->get('dailycash');
                $row = $query1->row_array();
                $rowId = $row['rowId']+1;
                $data = array(
                    'rowId' => $rowId
                    , 'dt' => $dt
                    , 'in' => $this->input->post('amt')
                    , 'remarks' => $this->input->post('remarks')
                    , 'denominationIn' => $this->input->post('deno')
                    , 'createdBy' => $this->session->userRowId
                );
                $this->db->set('createdStamp', 'NOW()', FALSE);
                $this->db->insert('dailycash', $data);  
            }
            else if($this->input->post('inOutMode') == "OUT")
            {
                //pahle in wal record insert ho hi chuka hoga is liye yaha kuch nahi
            }
        }
        
        $this->db->trans_complete();    

    }
    
    public function sendSms($mob, $sms)
    {
      $mobileString = $mob;
      $msg = $sms;
      $senderId = "KAMALC";
      $smsQueryStr = "http://sms4power.com/api/swsendSingle.asp?username=t1poojaj&password=101498963&sender=".urlencode($senderId)."&sendto=".urlencode($mobileString)."&message=".urlencode($msg);
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $smsQueryStr);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $response = curl_exec($ch);
      curl_close($ch);
    }

    public function dailyCashInEntry()
    {
        $curDate = date('Y-m-d');
        $this->db->select('*');
        // $this->db->where('in', 0);
        $this->db->where('dt', $curDate);
        $query = $this->db->get('dailycash');

        if ($query->num_rows() > 0)
        {
            return "entered";
        }
        else
        {
            return "notEntered";
        }
    }

  public function thisDateMustBeThare()
  {
    $dt = date('Y-m-d', strtotime($this->input->post('dt')));
    $this->db->select('rowId');
    $this->db->where('dailycash.dt', $dt);
    $query = $this->db->get('dailycash');
    if ($query->num_rows() > 0)
    {
      return 1;
    }
    else
    {
      return 0;
    }
  }


  public function deleteOldData()
  {
    set_time_limit(0);
    $this->db->trans_start();

    $dt = date('Y-m-d', strtotime($this->input->post('dt')));
    //// clos bal is date ka
     $this->db->select_Sum('out');
     $this->db->select_Sum('in');
     $this->db->from('dailycash');
     $this->db->where('dailycash.dt <=', $dt);
     // $this->db->where('dailycash.dt <', date('Y-m-d', strtotime($this->input->post('dtFrom'))));
     $query = $this->db->get();
     // return($query->result_array());
     $clBal = 0;
     if ($query->num_rows() > 0) 
     {
        $row = $query->row_array();
        $clBal = $row['out'] - $row['in'];
     }

    //// is date se pahle k rec del
    $this->db->where('dt<', $dt);
    $this->db->delete('dailycash');

    $data = array(
            'in' => 0,
            'out' => $clBal,
            'remarks' => 'data deleted on ' . date('Y-m-d')
    );
    $this->db->where('dt', $dt);
    $this->db->update('dailycash', $data);

    $this->db->trans_complete();    
  }
}