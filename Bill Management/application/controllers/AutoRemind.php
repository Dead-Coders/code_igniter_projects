<?php
class AutoRemind extends CI_Controller
{
  public function index()
  {
    echo "Hello, World" . PHP_EOL;
  }
 
  public function greet($name)
  {

      $this->load->model('Rptreminders2_model');
      $data['recordsOnce'] = $this->Rptreminders2_model->getDataForReportOnce();
      $data['recordsWeekly'] = $this->Rptreminders2_model->getDataForReportWeekly();
      $data['recordsMonthly'] = $this->Rptreminders2_model->getDataForReportMonthly();
      $data['recordsYearly'] = $this->Rptreminders2_model->getDataForReportYearly();

      $msg = "";
      $total = 0;
      $cnt = count($data['recordsOnce']);
      $total += $cnt;
      for($i=0; $i<$cnt; $i++) 
      {
        $msg .= $data['recordsOnce'][$i]['remarks'] . ' [' .  substr($data['recordsOnce'][$i]['repeat'],0,1) . "]\r\n";
      }
      
       $cnt = count($data['recordsWeekly']);
       $total += $cnt;
       for($i=0; $i<$cnt; $i++) 
       {
         $msg .= $data['recordsWeekly'][$i]['remarks'] . ' [' . substr($data['recordsWeekly'][$i]['repeat'],0,1) . "]\r\n";
       }
       
       $cnt = count($data['recordsMonthly']);
       $total += $cnt;
       for($i=0; $i<$cnt; $i++) 
       {
         $msg .= $data['recordsMonthly'][$i]['remarks'] . ' [' . substr($data['recordsMonthly'][$i]['repeat'],0,1) . "]\r\n";
       }
       
       $cnt = count($data['recordsYearly']);
       $total += $cnt;
       for($i=0; $i<$cnt; $i++) 
       {
         $msg .= $data['recordsYearly'][$i]['remarks'] . ' [' . substr($data['recordsYearly'][$i]['repeat'],0,1) . "]\r\n";
       }
      
      if ($msg == "")
      {

      }
      else
      {
        $this->load->library('email');
        $this->email->set_newline("\r\n");
        $this->email->to("ajmerblooddonors@gmail.com");
        $this->email->from("surendralekhyani@gmail.com");
        $this->email->subject($total . ' Alarms for '. date('d-m-Y'));
        $this->email->message($msg);
        $this->email->send();

        $mobile="9929598700";
        $sms=$msg;
        $this->sendSms($mobile, $sms);
      }
      

     
  }

  public function sendSms($mob, $sms)
  {
      $mobileString = $mob;
      $msg = $sms;
      // $senderId = 'IMPERL';
      // $smsQueryStr = "http://nimbusit.co.in/api/swsend.asp?username=t1surendralekhyani&password=82976319&sender=".urlencode($senderId)."&sendto=".urlencode($mobileString)."&message=".urlencode($msg);
      $senderId = "KAMALC";
      $smsQueryStr = "http://sms4power.com/api/swsendSingle.asp?username=t1poojaj&password=101498963&sender=".urlencode($senderId)."&sendto=".urlencode($mobileString)."&message=".urlencode($msg);
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $smsQueryStr);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $response = curl_exec($ch);
      curl_close($ch);
  }


  public function myBackup($name)
  {

        $this->load->library('email');
        $this->email->set_newline("\r\n");
        $this->email->to("xxx@gmail.com");
        $this->email->from("xxx@gmail.com");
        $this->email->subject(' Alarms for '. date('d-m-Y'));
        $this->email->message('dd');
        $this->email->send();     
  }
}