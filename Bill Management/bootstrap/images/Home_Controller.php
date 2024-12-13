<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
class Home_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Home_model');
        $this->load->helper('url');
        $this->load->helper('captcha');
    }
    public function index()
    {


      // - See more at: https://arjunphp.com/send-gmail-codeigniter-email-library/#sthash.GpfF6A6O.dpuf

        $this->load->view('includes/header');           // with Jumbotron
        // $data['records'] = $this->Search_model->getData();
        $this->load->model('Util_model');
        // $this->load->model('Home_model');
        $this->load->view('includes/menu');           
        $data = $this->myCaptcha();
        $this->load->view('Home_view', $data);
        $this->load->view('includes/footer');
    }    
    public function search()
    {
        

        $data = $this->Home_model->searchAjax();
        echo json_encode($data);
    }
    public function myCaptcha()
    {
        $vals = array(
            'img_path'  => './captcha/',
            'img_url'  => base_url().'/captcha/',
            'img_width' => 115,
            'img_height' => '45',
            'expiration' => 7200,
            'word_length'   => 5,
            'font_size'     => 18,
            'pool'  => '23456789abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ',
            'colors'  => array(
                        'background' => array(255, 255, 255),
                        'border' => array(255, 255, 255),
                        'text' => array(0, 0, 0),
                        'grid' => array(160, 160, 160)
                )
            );

        $cap = create_captcha($vals);
        // print_r($cap['word']);
        $this->session->set_userdata('captchaWord', $cap['word']);
        // echo($this->session->userdata('captchaWord'));
        // echo $cap['image'];
        return($cap);
    }


public function insert()
    {
        // echo "ins";
        if($this->Home_model->checkDuplicate()==1)
        {
            // $data['errMsg'] = "Duplicate Record...";
            // $this->load->view('error_view', $data);
            // $data['errorfound'] = "yes";
            $data = $this->myCaptcha();
            echo 0;
        }
        else
        {
            $this->sendEmail();
            $this->Home_model->insert();  
            // $data['saveMsg'] = "Record Saved...";
            // $this->load->view('save_view', $data);
            // $data['errorfound'] = "no";
            $data = $this->myCaptcha();
            print_r($data['image']);
            
        }

        // $data['records'] = $this->Home_model->getData();
        // $this->load->view('DonorsTable_view', $data);
        // $this->load->view('includes/footer');
    } 


    public function sendEmail()
    {   
  $emailConfig = array(
         'protocol' => 'smtp',
          'smtp_host' => 'ssl://smtp.gmail.com',
          'smtp_port' => '465',
          'smtp_user' => 'chandalekhyani@gmail.com',
          'smtp_pass' => 'jethalaldaya',
          'mailtype'  => 'html',
          'charset'   => 'iso-8859-1'
      );
       
      // Set your email information
      $from = array('email' => 'chandalekhyani@gmail.com', 'name' => 'AjmerBloodDonors');
      $to = array('surendralekhyani@gmail.com');
      $subject = 'New Registration: '.$this->input->post('name').'-'.$this->input->post('mobile1');
       
      $message = 'Details are: <br />'.$this->input->post('name').'<br />'.$this->input->post('fname').'<br />'.$this->input->post('mobile1').'<br />'.$this->input->post('mobile2').'<br />'.$this->input->post('email').'<br />'.$this->input->post('locality').'<br />';
      // Load CodeIgniter Email library
      $this->load->library('email', $emailConfig);
       
      // Sometimes you have to set the new line character for better result
      // $this->email->set_newline("rn");
      $this->email->set_newline("\r\n");
      // Set email preferences
      $this->email->from($from['email'], $from['name']);
      $this->email->to($to);
       
      $this->email->subject($subject);
      $this->email->message($message);
      // Ready to send email and check whether the email was successfully sent
       
      if (!$this->email->send()) {
          // Raise error message
          // show_error($this->email->print_debugger());
      }
      else {
          // Show success notification or other things here
          // echo 'Success to send email';
      }
    }

}
