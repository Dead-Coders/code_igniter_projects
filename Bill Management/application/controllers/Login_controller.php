<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_controller extends CI_Controller 
{
    // $orgName;
	public function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->helper('url');
        // $this->load->library('session');
    }
	public function index()
	{
        set_time_limit(0);
        // $isLoggedIn = $this->Login_model->is_logged_in();
        // if($isLoggedIn == 1)
        // {
        //     $this->load->model('Organisation_model');
        //     $data['orgInfo'] = $this->Organisation_model->getOrganisation();
        //     if( count($data['orgInfo']) > 0)
        //       {
        //         // $this->orgName = $data['orgInfo'][0]['orgName'];
        //         $this->session->set_userdata('orgName', $data['orgInfo'][0]['orgName']);
        //       }
        //     $this->load->view('includes/header4all');       
        //     $MenuRights['mr'] = $this->Util_model->getUserRights();
        //     $MenuRights['notifications'] = $this->Util_model->getNotifications();
        //     $this->load->view('includes/menu4admin', $MenuRights);     
        //     $this->load->view('success_view', $data);
        //     $this->load->view('includes/footer');
        // }
        // else
        {
    		$this->load->helper('url');
    		$this->load->view('includes/header');
            $this->load->model('Organisation_model');
            $data['orgInfo'] = $this->Organisation_model->getOrganisation();

            $this->load->view('login_view', $data);
    		$this->load->view('includes/footer');
        }
	}

	public function checkLogin()
	{
        $this->load->library('form_validation');
        $this->form_validation->set_rules('txtUID', 'User name', 'trim|required');
        $this->form_validation->set_rules('txtPassword', 'Password', 'trim|required');
 
        if($this->form_validation->run() == FALSE)
        {
            $this->load->view('includes/header');           // with Jumbotron
            $this->load->model('Organisation_model');
            $data['orgInfo'] = $this->Organisation_model->getOrganisation();

            $this->load->view('login_view', $data);
            $this->load->view('includes/footer');
            return;
        }

        if(isset($_POST['txtUID'])==False)
        {
            $this->load->view('includes/header');           // with Jumbotron
            $this->load->model('Organisation_model');
            $data['orgInfo'] = $this->Organisation_model->getOrganisation();

            $this->load->view('login_view', $data);
            $this->load->view('includes/footer');
            return;
        }

        $userRec = $this->Login_model->checkuser($_POST['txtUID'], $_POST['txtPassword']);
        // $cnt=count($userRec);
        // echo $cnt;
        if($userRec && count($userRec)>0)
        {
            $this->session->set_userdata('userid', $_POST['txtUID']);
            $this->session->set_userdata('userRowId', $userRec['rowid']);
            $this->session->set_userdata('apnaAadmi', 'haanHai');
            $this->session->set_userdata('session_id', rand());
            $this->session->set_userdata('isLogin', True);
            // $this->Login_model->insert_session($_POST['txtUID']);
            $this->load->model('Organisation_model');
            $data['orgInfo'] = $this->Organisation_model->getOrganisation();
            if( count($data['orgInfo']) > 0)
              {
                // $this->orgName = $data['orgInfo'][0]['orgName'];
                $this->session->set_userdata('orgName', $data['orgInfo'][0]['orgName']);
              }
            $this->load->view('includes/header4all');       
           
            $MenuRights['mr'] = $this->Util_model->getUserRights();
			// $MenuRights['notifications'] = $this->Util_model->getNotifications();
            // //// Deleting old BKP files
            //     $this->deleteOldFiles();
            // // /////BACKUP
            // $kitneDinHoGaye = $this->Login_model->getLastBackupDt();
            // if ( $kitneDinHoGaye == null || $kitneDinHoGaye > 0)
            // {
            //   $this->load->dbutil(); 
            //   $prefs = array( 'format' => 'zip', // gzip, zip, txt 
            //                    'filename' => $this->db->database.'_backup_'.date('d_m_Y_H_i_s').'.sql', 
            //                                           // File name - NEEDED ONLY WITH ZIP FILES 
            //                     'add_drop' => TRUE,
            //                                          // Whether to add DROP TABLE statements to backup file
            //                    'add_insert'=> TRUE,
            //                                         // Whether to add INSERT data to backup file 
            //                    'newline' => "\n"
            //                                        // Newline character used in backup file 
            //                   ); 
            //      // Backup your entire database and assign it to a variable 
            //      $backup = $this->dbutil->backup($prefs); 
            //      // Load the file helper and write the file to your server 
            //      $this->load->helper('file');
            //      $f='excelfiles/dbbackup_'.date('d_m_Y_H_i_s').'.zip'; 
            //      write_file($f, $backup); 

            //      $this->load->library('email');
            //     $config['protocol']    = 'smtp';
            //     $config['smtp_host']    = 'ssl://smtp.gmail.com';
            //     $config['smtp_port']    = '465';
            //     $config['smtp_timeout'] = '17';
            //     $config['smtp_user']    = 'reetlekhyani@gmail.com';
            //     $config['smtp_pass']    = 'Rauni2009';
            //     $config['charset']    = 'utf-8';
            //     $config['newline']    = "\r\n";
            //     $config['mailtype'] = 'text'; // or html
            //     $config['validation'] = TRUE; // bool whether to validate email or not      
            //     $this->email->initialize($config);
            //     $this->email->from('reetlekhyani@gmail.com', 'Reet');
            //     $this->email->to('kamalpanchsheel@gmail.com'); 
            //     $this->email->subject('Database Backup' . date("Y-m-d h:i:s") );
            //     $this->email->message($_SERVER['SERVER_NAME'] . date("Y-m-d h:i:s") );  
            //     $this->email->attach($f);
            //     // $this->email->send(); /// abhi off kiya h... excelFiles Folder m dekho milega backup
                
            //     $this->Login_model->setBackupDt();
            // }
            $MenuRights['notifications'] = $this->Util_model->getNotifications();
            $this->load->view('includes/menu4admin', $MenuRights);     
            $this->load->view('success_view', $data);
            // $this->load->library('../controllers/DashBoard_Controller');
        }
        else
        {
            $this->load->view('includes/header');           // with Jumbotron
            $data['errMsg'] = "Invalid Username or Password...";
            $this->load->view('error_view', $data);
            // $data['org'] = $this->Login_model->getOrgList();
            // $data = "a";
            $this->load->model('Organisation_model');
            $data['orgInfo'] = $this->Organisation_model->getOrganisation();

            $this->load->view('login_view', $data);
        }
        $this->load->view('includes/footer');
	}

    function deleteOldFiles()  
    {
        $c=0;
        $path = FCPATH . '/excelfiles/';
        if ($handle = opendir($path)) 
        {
            while (false !== ($file = readdir($handle))) 
            { 
                $ext = pathinfo($path . $file, PATHINFO_EXTENSION);
                $primaryName = pathinfo($path . $file, PATHINFO_FILENAME);
                // $filelastmodified = filemtime($path . $file);
                //24 hours in a day * 3600 seconds per hour
                // if((time() - $filelastmodified) > 90*24*3600)///before 90 days
                if( substr($primaryName, 0, 4) == "dbba" )///before 90 days
                {
                    if( $ext == "zip")
                    {
                        unlink($path . $file);
                        $c++;
                    }
                }
            }
            closedir($handle); 
        }
        // echo $c;
    }
    public function logout()
    {

        // $this->Login_model->logout_session($this->session->session_id);
        $this->session->unset_userdata('userid');
        $this->session->unset_userdata('isLogin');
        $this->session->unset_userdata('session_id');
        $this->session->unset_userdata('userRowId');
        $this->session->unset_userdata('orgName');
        $this->session->sess_destroy();
        // echo "<br>" . $this->session->userdata('session_id'). "bye...";
        $this->load->view('includes/header');           // with Jumbotron
        // $data = "a";
        $this->load->model('Organisation_model');
        $data['orgInfo'] = $this->Organisation_model->getOrganisation();

        $this->load->view('login_view', $data);
        $this->load->view('includes/footer');
    }

    public function notificationPadhLiya()
    {
        $this->Login_model->markPadhLiya();
        $data['notifications'] = $this->Util_model->getNotifications();
        echo json_encode($data);
        // echo $data;
    }

    
}
