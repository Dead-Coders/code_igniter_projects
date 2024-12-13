<?php
class Ordersstatus_model extends CI_Model 
{
    public function __construct()
    {
            $this->load->database('');
    }

    // public function getCustomerList()
    // {

    //     $this->db->select('orders.*, customers.customerName');
    //     $this->db->where('orders.deleted', 'N');
    //     $this->db->where('orders.invoiceDone', 'N');
    //     $this->db->join('customers','customers.customerRowId = orders.customerRowId');
    //     $this->db->join('orderdetail','orderdetail.orderRowId = orders.orderRowId AND orderdetail.pendingQty>0');
    //     $this->db->order_by('customerName');
    //     $query = $this->db->get('orders');

    //     $arr = array();
    //     $arr["-1"] = '--- Select ---';
    //     foreach ($query->result_array() as $row)
    //     {
    //         $arr[$row['customerRowId']]= $row['customerName'];
    //     }
    //     return $arr;

    // }

    public function getUndeliveredOrders()
    {
            // $this->db->distinct();
            $this->db->select('order.*, customers.customerName, customers.mobile1');
            $this->db->where('order.deleted', 'N');
            $this->db->where('order.delivered', 'N');
            $this->db->join('customers','customers.customerRowId = order.customerRowId');
            // $this->db->join('orderdetail','orderdetail.orderRowId = orders.orderRowId AND orderdetail.pendingQty>0');
            $this->db->order_by('orderRowId');
            $query = $this->db->get('order');

            return($query->result_array());
    }

    public function getDeliveredOrdersLastFive()
    {
            // $this->db->distinct();
            $this->db->select('order.*, customers.customerName, customers.mobile1');
            $this->db->where("order.delivered = 'Y' OR order.completeOrderReady = 'Y'");
            $this->db->where('order.deleted', 'N');
            // $this->db->where('order.delivered', 'Y');
            $this->db->join('customers','customers.customerRowId = order.customerRowId');
            $this->db->limit(5);
            $this->db->order_by('orderRowId desc');
            $this->db->order_by('orderRowId');
            $query = $this->db->get('order');

            return($query->result_array());
    }

    public function getDeliveredOrdersAll()
    {
            // $this->db->distinct();
            $this->db->select('order.*, customers.customerName, customers.mobile1');
            $this->db->where("order.delivered = 'Y' OR order.completeOrderReady = 'Y'");
            $this->db->where('order.deleted', 'N');
            // $this->db->where('order.delivered', 'Y');
            $this->db->join('customers','customers.customerRowId = order.customerRowId');
            // $this->db->limit(5);
            // $this->db->order_by('orderRowId desc');
            $this->db->order_by('orderRowId');
            $query = $this->db->get('order');

            return($query->result_array());
    }
    public function showDetail()
    {
        $this->db->select('orderdetail.*');
        $this->db->where('orderRowId', $this->input->post('orderRowId'));
        $this->db->order_by('orderRowId');
        $query = $this->db->get('orderdetail');

        return($query->result_array());
    }

    public function saveChanges()
    {
        $TableData = $this->input->post('TableData');
        $TableData = stripcslashes($TableData);
        $TableData = json_decode($TableData,TRUE);
        $myTableRows = count($TableData);
        $mobile="";
        for ($i=0; $i < $myTableRows; $i++) 
        {
            if( $TableData[$i]['isChecked'] == 'Y')
            {
                $data = array(
                    'ready' => 'Y',
                );
            }
            else
            {
                $data = array(
                    'ready' => 'N',
                );                
            }
            $this->db->where('orderDetailRowId', $TableData[$i]['orderDetailRowId']);
            $this->db->update('orderdetail', $data);   
        }             
    }

    public function setDelivered()
    {
            $data = array(
                'delivered' => 'Y'
                , 'deliverSms' => $this->input->post('sms')
            );                
            $this->db->where('orderRowId', $this->input->post('orderRowId'));
            $this->db->set('deliverStamp', 'NOW()', FALSE);
            $this->db->update('order', $data);   
                   
    }    

    public function UpdateReadyMsg()
    {
        set_time_limit(0);
        $this->db->trans_start();

        $data = array(
             'completeOrderReady' => 'Y'
            , 'readySms' => $this->input->post('sms')
        );
        $this->db->where('orderRowId', $this->input->post('orderRowId'));
        $this->db->set('readyStamp', 'NOW()', FALSE);
        $this->db->update('order', $data); 


        $this->db->trans_complete();   
    }

}