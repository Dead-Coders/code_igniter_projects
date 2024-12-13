<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // load model
        $this->load->model('Report_model');
    }

    // index view report
    public function index()
    {
        $data['title'] = 'Report Data';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['reports'] = $this->db->order_by('date_reported', 'DESC');
        $data['reports'] = $this->Report_model->getAll();
            
        $this->load->view('templates/admin_header', $data);
        $this->load->view('templates/admin_sidebar');
        $this->load->view('templates/admin_topbar', $data);
        $this->load->view('report/index', $data);
        $this->load->view('templates/admin_footer');
    }

    // add report
    public function addreport()
    {
        $report = $this->Report_model;
        
        $this->form_validation->set_rules('nik', 'NIK', 'required', [
            'required' => 'ID is required!'
        ]);
        $this->form_validation->set_rules('rt', 'RT', 'required|numeric', [
            'required' => 'RT is required!'
        ]);
        $this->form_validation->set_rules('rw', 'RW', 'required|numeric', [
            'required' => 'RW is required!'
        ]);
        $this->form_validation->set_rules('village', 'Village', 'required', [
            'required' => 'Village is required!'
        ]);
        $this->form_validation->set_rules('title', 'Report Title', 'required', [
            'required' => 'Report title is required!'
        ]);
        $this->form_validation->set_rules('description', 'Report Description', 'required', [
            'required' => 'Report description is required!'
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Report';
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            
            $this->load->view('templates/admin_header', $data);
            $this->load->view('templates/admin_sidebar');
            $this->load->view('templates/admin_topbar', $data);
            $this->load->view('report/add_report');
            $this->load->view('templates/admin_footer');
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Failed to report!</div>');
        } else {
            $report->save();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Reported successfully!</div>');
            redirect('user');
        }
    }

    // view detail report
    public function detail($id)
    {
        $data['title'] = 'Report Detail Information';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['report'] = $this->Report_model->getById($id);
            
        $this->load->view('templates/admin_header', $data);
        $this->load->view('templates/admin_sidebar');
        $this->load->view('templates/admin_topbar', $data);
        $this->load->view('report/detail', $data);
        $this->load->view('templates/admin_footer');
    }

    // delete report
    public function deletereport($id = null)
    {
        if (!isset($id)) show_404();

        $report = $this->Report_model;
        if ($report->delete($id)) {
            redirect('report');
        }
    }

}