<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_Controller extends CI_Controller
{
	public function __construct()
    {
            parent::__construct();
            $this->load->model('Menu_model');
            $this->load->helper('url');
            $r =$this->Util_model->getAuth();
            if( $r==0)
            {
                redirect(base_url());
            }
    }

    public function getRights()
    {
    	$arr = $this->Menu_model->getRights($this->input->post('uid'));
    	$msg="";
    	foreach ($arr as $key => $value) {
    		$msg = $value['menuoption'].",".$msg;
    	}
    	// echo json_encode($temp);
    	echo $msg;
    }
    public function getRights1()
    {
        $arr = $this->Menu_model->getRights1();
        $msg="";
        foreach ($arr as $key => $value) {
            $msg = $value['menuoption'].",".$msg;
        }
        echo $msg;
    }
}