<?php
class Util_model extends CI_Model 
{
    public function __construct()
    {
       $this->load->database('');
       $this->db->query("SET time_zone='+5:30'");
    }

    public function getNotifications()
    {
        set_time_limit(0);
        $this->db->trans_start();

     /////////////////////////////////Loading Reminders
     $this->db->select('*');
     $this->db->from('reminders');
     $this->db->where('reminders.deleted', 'N');
     $this->db->where('reminders.repeat', 'Once');
     $this->db->where('reminders.dt', date('Y-m-d'));
     $this->db->order_by('reminders.reminderRowId');
     $query = $this->db->get();
     foreach ($query->result() as $row)
     {
         $this->db->select('*');
         $this->db->from('notifications');
         // $this->db->where('notifications.deleted', 'N');
         $this->db->where('notifications.rowId', $row->reminderRowId);
         $this->db->where('notifications.dt', $row->dt);
         $this->db->where('notifications.remarks', $row->remarks);
         $this->db->where('notifications.repeat', $row->repeat);
         $this->db->where('notifications.notificationType', 'Reminder');
         $queryNotifications = $this->db->get();
        if($queryNotifications->num_rows() > 0)
        {
            ///do nothing
        }
        else
        {
            $data = array(
                'rowId' => $row->reminderRowId
                , 'dt' => $row->dt
                , 'remarks' => $row->remarks
                , 'repeat' => $row->repeat
                , 'notificationType' => 'Reminder'
            );
            $this->db->insert('notifications', $data);
        }
     }

///////Weekly
     $this->db->select('reminders.*');
     // $this->db->select('DayName(reminders.dt) as dayName');
     $this->db->from('reminders');
     $this->db->where('reminders.deleted', 'N');
     $this->db->where('DayName(reminders.dt)', date('l'));
     $this->db->where('reminders.repeat', 'Weekly');
     $this->db->order_by('reminders.reminderRowId');
     $query = $this->db->get();
     foreach ($query->result() as $row)
     {
         $this->db->select('*');
         $this->db->from('notifications');
         // $this->db->where('notifications.deleted', 'N');
         $this->db->where('notifications.rowId', $row->reminderRowId);
         $this->db->where('notifications.dt', $row->dt);
         $this->db->where('notifications.remarks', $row->remarks);
         $this->db->where('notifications.repeat', $row->repeat);
         $this->db->where('notifications.notificationType', 'Reminder');
         $queryNotifications = $this->db->get();
        if($queryNotifications->num_rows() > 0)
        {
            ///do nothing
        }
        else
        {
            $data = array(
                'rowId' => $row->reminderRowId
                , 'dt' => $row->dt
                , 'remarks' => $row->remarks
                , 'repeat' => $row->repeat
                , 'notificationType' => 'Reminder'
            );
            $this->db->insert('notifications', $data);
        }
     }     
     
///////Monthly
     $this->db->select('reminders.*');
     // $this->db->select('DayName(reminders.dt) as dayName');
     $this->db->from('reminders');
     $this->db->where('reminders.deleted', 'N');
     $this->db->where('Day(reminders.dt)', date('d'));
     $this->db->where('reminders.repeat', 'Monthly');
     $this->db->order_by('reminders.reminderRowId');
     $query = $this->db->get();
     foreach ($query->result() as $row)
     {
         $this->db->select('*');
         $this->db->from('notifications');
         // $this->db->where('notifications.deleted', 'N');
         $this->db->where('notifications.rowId', $row->reminderRowId);
         $this->db->where('notifications.dt', $row->dt);
         $this->db->where('notifications.remarks', $row->remarks);
         $this->db->where('notifications.repeat', $row->repeat);
         $this->db->where('notifications.notificationType', 'Reminder');
         $queryNotifications = $this->db->get();
        if($queryNotifications->num_rows() > 0)
        {
            ///do nothing
        }
        else
        {
            $data = array(
                'rowId' => $row->reminderRowId
                , 'dt' => $row->dt
                , 'remarks' => $row->remarks
                , 'repeat' => $row->repeat
                , 'notificationType' => 'Reminder'
            );
            $this->db->insert('notifications', $data);
        }
     }     

     
///////Yearly
     $this->db->select('reminders.*');
     // $this->db->select('DayName(reminders.dt) as dayName');
     $this->db->from('reminders');
     $this->db->where('reminders.deleted', 'N');
     $this->db->where('Day(reminders.dt)', date('d'));
     $this->db->where('Month(reminders.dt)', date('m'));
     $this->db->where('reminders.repeat', 'Yearly');
     $this->db->order_by('reminders.reminderRowId');
     $query = $this->db->get();
     foreach ($query->result() as $row)
     {
         $this->db->select('*');
         $this->db->from('notifications');
         // $this->db->where('notifications.deleted', 'N');
         $this->db->where('notifications.rowId', $row->reminderRowId);
         $this->db->where('notifications.dt', $row->dt);
         $this->db->where('notifications.remarks', $row->remarks);
         $this->db->where('notifications.repeat', $row->repeat);
         $this->db->where('notifications.notificationType', 'Reminder');
         $queryNotifications = $this->db->get();
        if($queryNotifications->num_rows() > 0)
        {
            ///do nothing
        }
        else
        {
            $data = array(
                'rowId' => $row->reminderRowId
                , 'dt' => $row->dt
                , 'remarks' => $row->remarks
                , 'repeat' => $row->repeat
                , 'notificationType' => 'Reminder'
            );
            $this->db->insert('notifications', $data);
        }
     }            
     /////////////////////////////////END - Loading Reminders



     ////Returning All Notifications
     $this->db->select('notifications.*');
     $this->db->from('notifications');
     $this->db->where('notifications.deleted', 'N');
     $query = $this->db->get();
     

     $this->db->trans_complete();

        return($query->result_array());
    }

    

    public function getCustomerWithBalance()
    {
        $q = "Select sum(amt)-sum(recd) as balance, customers.customerRowId, customers.customerName,customers.mobile1, customers.address,customers.remarks from customers LEFT JOIN ledger  ON ledger.customerRowId=customers.customerRowId AND ledger.deleted='N' WHERE customers.deleted='N' group by customers.customerRowId, customers.customerName,customers.mobile1, customers.address,customers.remarks order by customerName";
        $query = $this->db->query($q);
        return($query->result_array());
    }

    public function isSessionExpired()
    {
        $orgRowId = $this->session->orgRowId;
        $userRowId = $this->session->userRowId;

        // return $orgRowId;
        if ($orgRowId <= 0 || $userRowId <= 0)
        {
            return 1;
        }
    }

    public function getRight($uid,$right)
    {
        $query = $this->db->query("SELECT count(*) AS `rowcount` FROM userrights WHERE userrowid=".$uid." AND menuoption='".$right."'");

        return $query->row()->rowcount;
    }
	
    public function isDependent($tableName, $fieldName, $val)
    {
        $this->db->select($fieldName);
        $this->db->where($fieldName, $val);
        $query = $this->db->get($tableName);
        if ($query->num_rows() > 0)
        {
            return 1;
        }
    } 
      
    public function getVisitor()
    {
        $no=0;
        $this->db->select_max('cnt');
        $query = $this->db->get('visitors');
        if ($query->num_rows() > 0)
        {
            $row = $query->row(); 
            $no = $row->cnt+1;
        }
        $data = array(
                'cnt' => $no
        );
        $this->db->update('visitors', $data);               
        return $no;
    } 


    public function getOrg()
    {
        $this->db->select('organisation.*');
        $this->db->from('organisation');
        // $this->db->where('organisation.orgRowId', $this->session->orgRowId);
        // $this->db->order_by('qpo.qpoRowId');
        // $this->db->limit(5);
        $query = $this->db->get();

        return($query->result_array());
    }

    


    public function getUserRights()
    {
        $this->db->select('menuoption');
        $this->db->where('userrowid', $this->session->userRowId);
        $this->db->order_by('');
        $query = $this->db->get('userrights');
        return($query->result_array());
    }


    public function getAuth($r="sdsa2dsda")
    {
        if ($this->session->isLogin===True && $this->session->session_id != '' && $this->session->apnaAadmi == 'haanHai' ) /*if logged in*/
        {
          return 1;
        }
        else
        {
          return 0;
        }
    }
}