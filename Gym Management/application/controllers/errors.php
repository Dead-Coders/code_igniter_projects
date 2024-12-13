<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class errors extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
       
    }

    public function index()
    {

        
        $data['title']="404 Page not found";
        $this->load->view('pages/404');
        
    }
    
    
    
    
}
