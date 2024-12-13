<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class BackupData_Controller extends CI_Controller
{
	public $fileName='k';
	public function __construct()
    {
            parent::__construct();
            $this->load->model('Backupdata_model');
            $this->load->helper('url');
            $r =$this->Util_model->getAuth();
	        if( $r==0)
	        {
	        	redirect(base_url());
	        }
    }
	public function index()
	{
		///////Get User IP, Browser & OS Details in Codeigniter
		$this->load->library('user_agent');
		  $data['browser'] = $this->agent->browser();
		  $data['browser_version'] = $this->agent->version();
		  $data['os'] = $this->agent->platform();
		  $data['ip_address'] = $this->input->ip_address();
		  ///////END - Get User IP, Browser & OS Details in Codeigniter
		if ($this->session->isLogin===True && $this->session->session_id != '') /*if logged in*/
		{
			if($this->Util_model->getRight($this->session->userRowId,'Backup Data')==0)
			{
				$this->load->view('includes/header4all');
				$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);
				$this->load->view('ErrorUnauthenticateUser_view');
				$this->load->view('includes/footer');				
				return;
			}
			// $data['records'] = $this->Accounts_model->getData();
			$this->load->view('includes/header4all');
			$MenuRights['mr'] = $this->Util_model->getUserRights();
			$MenuRights['notifications'] = $this->Util_model->getNotifications();
			// $MenuRights['notifications'] = $this->Util_model->getNotifications();
			$this->load->view('includes/menu4admin', $MenuRights);
			$this->load->view('BackupData_view', $data);
			$this->load->view('includes/footer');
		}
		else
		{
            $this->load->view('includes/header');           // with Jumbotron
        	$this->load->model('Organisation_model');
            $data['orgInfo'] = $this->Organisation_model->getOrganisation();

            $this->load->view('login_view', $data);
	        $this->load->view('includes/footer');
		}
	}  
	public function frmExcel()
	{
		$this->BackupData_model->fromExcel();
		echo "done...";
	} 

	function dbbackup()
	{
		// Load the DB utility class
		$this->load->dbutil();

		// Backup your entire database and assign it to a variable
		$backup = $this->dbutil->backup();

		$this->load->helper('download');
		// force_download('mybackup.gz', $backup); 
		$fileName = $this->db->database.'_backup ' . date('Y-m-d @ h-i-s') .'.gz';
		force_download($fileName, $backup); 

		
    } 


     public function createTable()
     {
     	
     }

     



      function doEmail()  
      {
      	//////////// Isko kaam m lene se pahle sender ki email setting me ja kr less secure karna padega
           $this->load->library('email');
			$config['protocol']    = 'smtp';
			$config['smtp_host']    = 'ssl://smtp.gmail.com';
			$config['smtp_port']    = '465';
			$config['smtp_timeout'] = '17';
			$config['smtp_user']    = 'reetlekhyani@gmail.com';
			$config['smtp_pass']    = 'Rauni2009';
			$config['charset']    = 'utf-8';
			$config['newline']    = "\r\n";
			$config['mailtype'] = 'text'; // or html
			$config['validation'] = TRUE; // bool whether to validate email or not      
			$this->email->initialize($config);
			$this->email->from('reetlekhyani@gmail.com', 'Reet');
			$this->email->to('surendralekhyani@gmail.com'); 
			$this->email->subject('KC Backup' . date("Y-m-d h:i:s") );
			$this->email->message('Testing the email class.');  
			$this->email->send();
      }



      function alterDb()  
      {
      	$this->Backupdata_model->alterDb();
      }

      function deleteOldPdfs()  
      {
		$c=0;
      	$path = FCPATH . '/downloads/';
		if ($handle = opendir($path)) 
		{
		    while (false !== ($file = readdir($handle))) 
		    { 
		    	$ext = pathinfo($path . $file, PATHINFO_EXTENSION);
		        $filelastmodified = filemtime($path . $file);
		        //24 hours in a day * 3600 seconds per hour
		        if((time() - $filelastmodified) > 90*24*3600)///before 90 days
		        {
		        	if( $ext == "pdf")
		        	{
		           		unlink($path . $file);
		           		$c++;
		           	}
		        }
		    }
		    closedir($handle); 
		}
		echo $c;
      }

    public function tableToArray()
    {
      	$data['records']=$this->Backupdata_model->tableToArray();
     	echo json_encode($data);
    }

    public function uploadImage()
    {
    	$config['upload_path'] = 'downloads/'; 
	    $config['allowed_types'] = 'gif|jpg|png'; 
	    $config['max_size'] = 5000; 
	    $config['max_width'] = 26000; 
	    $config['max_height'] = 26000; 

	    $this->load->library('upload', $config); 
	    if (!$this->upload->do_upload('link')) { 
	        $reponse['message'] = "error"; 
	    } 
	    else { 
	        $data = array('upload_data' => $this->upload->data()); 
	        $image_name = $data['upload_data']['file_name']; 
	        $reponse['message'] = $image_name; 
	    } 

	    echo json_encode($reponse);
	 //    if($_FILES["file"]["name"] != '')
		// {
		//  $test = explode('.', $_FILES["file"]["name"]);
		//  $ext = end($test);
		//  $name = rand(100, 999) . '.' . $ext;
		//  $location = 'downloads/';  
		//  move_uploaded_file($_FILES["file"]["tmp_name"], $location);
		//  echo '<img src="'.$location.'" height="150" width="225" class="img-thumbnail" />';
		// }
    }

      function copyItems()  
      {
      	$this->Backupdata_model->copyItems();
      }




	public function generateLabels()
	{

		$this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle('barcode');
        // $pdf->SetHeaderMargin(1);
        $pdf->SetPrintHeader(false);
        $pdf->SetTopMargin(0);
        $pdf->SetLeftMargin(0);
        $pdf->setFooterMargin(0);
        $pdf->SetAutoPageBreak(true, 0); //2nd arg is margin from footer
        $pdf->SetAuthor('Suri');
        // $pdf->SetDisplayMode('real', 'default');
        $width = 88;  
		$height = 70; 
		$pageLayout = array($width, $height);
        $pdf->AddPage('L', $pageLayout);
        $pdf->SetFont('helvetica', '', 10, '', true); 
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);	/// otherwise line and page# will appear


		// define barcode style
		$style = array(
			'position' => '',
			'align' => 'C',
			'stretch' => false,
			'fitwidth' => false,
			'cellfitalign' => '1',
			'border' => false,
			'hpadding' => 1,
			'vpadding' => 1,
			'fgcolor' => array(0,0,0),
			'bgcolor' => false, //array(255,0,0), ///
			'text' => true,
			'font' => 'helvetica',
			'fontsize' => 8,
			'stretchtext' => 4
		);

        		//// IMP - neeche 0.4 se pahle Width(40), height(10) de sakte h par alignment bigadta h
				$params = $pdf->serializeTCPDFtagParameters(array($this->input->post('bCode'), 'EAN13', '', '', 0, 0, 0.4, $style, 'N'));
				// $params = $pdf->serializeTCPDFtagParameters(array('8963520145212', 'C128', '', '', 0, 20, 0.4, $style, 'N'));
				// $pdf->write1DBarcode('CODE 128 AUTO', 'C128', '', '', '', 18, 0.4, $style, 'N');
				$x = '<tcpdf method="write1DBarcode" params="'.$params.'" />';
				$html='<table nobr="true" border="0" style="padding: 10px 0;" >
						<tr nobr="true">
							<td align="center" style="width:88mm; height:70mm;"><br><br><br>'.$x.'</td>
						</tr>
				</table>';
				$pdf->writeHTML($html, true, false, true, false, '');
				
		
		///// Saving and exporting pdf
        $dt = date("Y_m_d");
        $tm = date("H_i_s");
        $pdf->Output(FCPATH . '/downloads/barcode_.pdf', 'F');
        echo base_url()."/downloads/barcode_.pdf";
		
	}

	public function generateOuterLabel()
	{

	}
   
}

	
