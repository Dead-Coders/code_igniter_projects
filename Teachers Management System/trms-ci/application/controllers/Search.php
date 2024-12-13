<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {


  public function index()
    {


         $sname=$this->input->post('searhdata');  
         $this->load->model('Search_Model');
         $data['search']=$this->Search_Model->index($sname);
       $this->load->view('search-result',$data,$sname);
      
    }

}
