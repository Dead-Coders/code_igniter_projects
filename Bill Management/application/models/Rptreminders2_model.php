<?php
class Rptreminders2_model extends CI_Model 
{
    public function __construct()
    {
            $this->load->database('');
    }


    public function getDataForReportOnce()
    {
     $this->db->select('*');
     $this->db->from('reminders');
     $this->db->where('reminders.deleted', 'N');
     $this->db->where('reminders.repeat', 'Once');
     $this->db->where('reminders.dt', date('Y-m-d'));
     $this->db->order_by('reminders.reminderRowId');
     $query = $this->db->get();
     return($query->result_array());
    }

    public function getDataForReportWeekly()
    {
     $this->db->select('reminders.*');
     // $this->db->select('DayName(reminders.dt) as dayName');
     $this->db->from('reminders');
     $this->db->where('reminders.deleted', 'N');
     $this->db->where('DayName(reminders.dt)', date('l'));
     $this->db->where('reminders.repeat', 'Weekly');
     $this->db->order_by('reminders.reminderRowId');
     $query = $this->db->get();
     return($query->result_array());
    }

    public function getDataForReportMonthly()
    {
     $this->db->select('reminders.*');
     // $this->db->select('DayName(reminders.dt) as dayName');
     $this->db->from('reminders');
     $this->db->where('reminders.deleted', 'N');
     $this->db->where('Day(reminders.dt)', date('d'));
     $this->db->where('reminders.repeat', 'Monthly');
     $this->db->order_by('reminders.reminderRowId');
     $query = $this->db->get();
     return($query->result_array());
    }

    public function getDataForReportYearly()
    {
     $this->db->select('reminders.*');
     // $this->db->select('DayName(reminders.dt) as dayName');
     $this->db->from('reminders');
     $this->db->where('reminders.deleted', 'N');
     $this->db->where('Day(reminders.dt)', date('d'));
     $this->db->where('Month(reminders.dt)', date('m'));
     $this->db->where('reminders.repeat', 'Yearly');
     $this->db->order_by('reminders.reminderRowId');
     $query = $this->db->get();
     return($query->result_array());
    }


}