<?php
defined('BASEPATH') OR exit('no direct script access allowed');

class Admin extends CI_Controller{
    function __construct(){
        parent::__construct();
        //cek login
        if($this->session->userdata('status') != 'login'){
            redirect(base_url().'welcome?pesan=belumlogin');
        }
    }
    
    //fungsi utk tampilan dashboard admin
    function index(){
        $data['transaksi'] = $this->db->query("select * from transaksi,mobil,kostumer where transaksi_mobil=mobil_id and transaksi_kostumer=kostumer_id order by transaksi_id desc limit 10")->result(); //transaksi terakhir
        $data['kostumer'] = $this->db->query("select * from kostumer order by kostumer_id desc limit 3")->result(); //menampilkan kostumer baru
        $data['mobil'] = $this->db->query("select * from mobil order by mobil_id desc limit 3")->result(); //menampilkan mobil baru
        $this->load->view('admin/header');
        $this->load->view('admin/index',$data);
        $this->load->view('admin/footer');
    }
    
    //fungsi ganti password
    function ganti_password(){
        $this->load->view('admin/header');
        $this->load->view('admin/ganti_password');
        $this->load->view('admin/footer');
    }
    function ganti_password_act(){
        $pass_baru  = $this->input->post('pass_baru');
        $ulang_pass = $this->input->post('ulang_pass');
        
        $this->form_validation->set_rules('pass_baru','Password baru','required|matches[ulang_pass]');
        $this->form_validation->set_rules('ulang_pass','Ulangi password baru','required');
        
        if($this->form_validation->run() != false){
            $data   = array('admin_password' => md5($pass_baru));
            $w      = array('admin_id' => $this->session->userdata('id'));
            $this->m_rental->update_data($w,$data,'admin');
            redirect(base_url().'admin/ganti_password?pesan=berhasil');
        } else {
            $this->load->view('admin/header');
            $this->load->view('admin/ganti_password');
            $this->load->view('admin/footer');
        }
    }
    
    //fungsi logout
    function logout(){
        $this->session->sess_destroy();
        redirect(base_url().'welcome?pesan=logout');
    }
    
    //fungsi CRUD Mobil
    function mobil(){
        $data['mobil'] = $this->m_rental->get_data('mobil')->result();
        $this->load->view('admin/header');
        $this->load->view('admin/mobil',$data);
        $this->load->view('admin/footer');
    }
    function mobil_add(){
        $this->load->view('admin/header');
        $this->load->view('admin/mobil_add');
        $this->load->view('admin/footer');
    }
    function mobil_add_act(){
        $merk   = $this->input->post('merk');
        $plat   = $this->input->post('plat');
        $warna  = $this->input->post('warna');
        $tahun  = $this->input->post('tahun');
        $status = $this->input->post('status');
        $this->form_validation->set_rules('merk','Merk mobil','required');
        $this->form_validation->set_rules('status','Status mobil','required');
        
        if($this->form_validation->run() != false){
            $data = array(
                'mobil_merk'    => $merk,
                'mobil_plat'    => $plat,
                'mobil_warna'   => $warna,
                'mobil_tahun'   => $tahun,
                'mobil_status'  => $status
            );
            
            $this->m_rental->insert_data($data, 'mobil');
            redirect(base_url().'admin/mobil');
        } else {
            $this->load->view('admin/header');
            $this->load->view('admin/mobil_add');
            $this->load->view('admin/footer');
        }
    }

    function mobil_edit($id){
        $where = array('mobil_id' => $id);
        $data['mobil'] = $this->m_rental->edit_data($where,'mobil')->result();
        $this->load->view('admin/header');
        $this->load->view('admin/mobil_edit',$data);
        $this->load->view('admin/footer');
    }
    function mobil_update(){
        $id     = $this->input->post('id');
        $merk   = $this->input->post('merk');
        $plat   = $this->input->post('plat');
        $warna  = $this->input->post('warna');
        $tahun  = $this->input->post('tahun');
        $status = $this->input->post('status');
        $this->form_validation->set_rules('merk','Merk mobil','required');
        $this->form_validation->set_rules('status','Status mobil','required');
        
        if($this->form_validation->run() != false){
            $where = array('mobil_id' => $id);
            $data = array(
                'mobil_merk'    => $merk,
                'mobil_plat'    => $plat,
                'mobil_warna'   => $warna,
                'mobil_tahun'   => $tahun,
                'mobil_status'  => $status
            );
            
            $this->m_rental->update_data($where, $data, 'mobil');
            redirect(base_url().'admin/mobil');
        } else {
            $where = array('mobil_id' => $id);
            $data['mobil'] = $this->m_rental->edit_data($where,'mobil')->result();
            $this->load->view('admin/header');
            $this->load->view('admin/mobil_edit',$data);
            $this->load->view('admin/footer');
        }
    }
    function mobil_hapus($id){
        $where = array('mobil_id' => $id);
        $this->m_rental->delete_data($where, 'mobil');
        redirect(base_url().'admin/mobil');
    }
    
    //fungsi CRUD Kostumer
    function kostumer(){
        $data['kostumer'] = $this->m_rental->get_data('kostumer')->result();
        $this->load->view('admin/header');
        $this->load->view('admin/kostumer',$data);
        $this->load->view('admin/footer');
    }
    function kostumer_add(){
        $this->load->view('admin/header');
        $this->load->view('admin/kostumer_add');
        $this->load->view('admin/footer');
    }
    function kostumer_add_act(){
        $nama   = $this->input->post('nama');
        $alamat = $this->input->post('alamat');
        $jk     = $this->input->post('jk');
        $hp     = $this->input->post('hp');
        $ktp    = $this->input->post('ktp');
        $this->form_validation->set_rules('nama','Name','required');
        $this->form_validation->set_rules('ktp','ID card no.','required');
        
        if($this->form_validation->run() != false){
            $data = array(
                'kostumer_nama' => $nama,
                'kostumer_alamat' => $alamat,
                'kostumer_jk'   => $jk,
                'kostumer_hp'   => $hp,
                'kostumer_ktp'  => $ktp
            );
            
            $this->m_rental->insert_data($data, 'kostumer');
            redirect(base_url().'admin/kostumer');
        } else {
            $this->load->view('admin/header');
            $this->load->view('admin/kostumer_add');
            $this->load->view('admin/footer');
        }
    }
    function kostumer_edit($id){
        $where = array('kostumer_id' => $id);
        $data['kostumer'] = $this->m_rental->edit_data($where,'kostumer')->result();
        $this->load->view('admin/header');
        $this->load->view('admin/kostumer_edit',$data);
        $this->load->view('admin/footer');
    }
    function kostumer_update(){
        $id     = $this->input->post('id');
        $nama   = $this->input->post('nama');
        $alamat = $this->input->post('alamat');
        $jk     = $this->input->post('jk');
        $hp     = $this->input->post('hp');
        $ktp    = $this->input->post('ktp');
        $this->form_validation->set_rules('nama','Nama','required');
        $this->form_validation->set_rules('ktp','Nomor KTP','required');
        
        if($this->form_validation->run() != false){
            $where = array('kostumer_id' => $id);
            $data = array(
                'kostumer_nama' => $nama,
                'kostumer_alamat' => $alamat,
                'kostumer_jk'   => $jk,
                'kostumer_hp'   => $hp,
                'kostumer_ktp'  => $ktp
            );
            
            $this->m_rental->update_data($where, $data, 'kostumer');
            redirect(base_url().'admin/kostumer');
        } else {
            $where = array('kostumer_id' => $id);
            $data['kostumer'] = $this->m_rental->edit_data($where,'kostumer')->result();
            $this->load->view('admin/header');
            $this->load->view('admin/kostumer_edit',$data);
            $this->load->view('admin/footer');
        }
    }
    function kostumer_hapus($id){
        $where = array('kostumer_id' => $id);
        $this->m_rental->delete_data($where, 'kostumer');
        redirect(base_url().'admin/kostumer');
    }
    
    //fungsi-fungsi transaksi
    function transaksi(){
        $data['transaksi'] = $this->db->query("select * from transaksi,mobil,kostumer where transaksi_mobil=mobil_id and transaksi_kostumer=kostumer_id")->result();
        $this->load->view('admin/header');
        $this->load->view('admin/transaksi', $data);
        $this->load->view('admin/footer');
    }
    function transaksi_add(){
        $w = array('mobil_status' => 1);
        $data['mobil'] = $this->m_rental->edit_data($w,'mobil')->result();
        $data['kostumer'] = $this->m_rental->get_data('kostumer')->result();
        $this->load->view('admin/header');
        $this->load->view('admin/transaksi_add', $data);
        $this->load->view('admin/footer');
    }
    function transaksi_add_act(){
        $kostumer   = $this->input->post('kostumer');
        $mobil      = $this->input->post('mobil');
        $tgl_pinjam = $this->input->post('tgl_pinjam');
        $tgl_kembali= $this->input->post('tgl_kembali');
        $harga      = $this->input->post('harga');
        $denda      = $this->input->post('denda');
        
        $this->form_validation->set_rules('kostumer', 'Kostumer', 'required');
        $this->form_validation->set_rules('mobil', 'Mobil', 'required');
        $this->form_validation->set_rules('tgl_pinjam', 'Tanggal Pinjam', 'required');
        $this->form_validation->set_rules('tgl_kembali', 'Tanggal Kembali', 'required');
        $this->form_validation->set_rules('harga', 'Harga', 'required');
        $this->form_validation->set_rules('denda', 'Denda', 'required');
        
        if($this->form_validation->run() != false){
            $data = array(
                'transaksi_karyawan'    => $this->session->userdata('id'),
                'transaksi_kostumer'    => $kostumer,
                'transaksi_mobil'       => $mobil,
                'transaksi_tgl_pinjam'  => $tgl_pinjam,
                'transaksi_tgl_kembali' => $tgl_kembali,
                'transaksi_harga'       => $harga,
                'transaksi_denda'       => $denda,
                'transaksi_tgl'         => date('Y-m-d')
            );
            
            $this->m_rental->insert_data($data, 'transaksi');
            
            //update status mobil yg dipinjam
            $d = array('mobil_status' => 2);
            $w = array('mobil_id' => $mobil);
            $this->m_rental->update_data($w, $d, 'mobil');
            
            redirect(base_url().'admin/transaksi');
        } else {
            $d = array('mobil_status' => 1);
            $data['mobil']      = $this->m_rental->edit_data($w, 'mobil')->result();
            $data['kostumer']   = $this->m_rental->get_data('kostumer')->result();
            $this->load->view('admin/header');
            $this->load->view('admin/transaksi_add', $data);
            $this->load->view('admin/footer');
        }
    }
    function transaksi_hapus($id){
        $w      = array('transaksi_id' => $id);
        $data   = $this->m_rental->edit_data($w,'transaksi')->row();
        
        $w2     = array('mobil_id' => $data->transaksi_mobil);
        $data2  = array('mobil_status' => 1);
        $this->m_rental->update_data($w2,$data2,'mobil');
        $this->m_rental->delete_data($w,'transaksi');
        redirect(base_url().'admin/transaksi');
    }
    function transaksi_selesai($id){
        $data['mobil']      = $this->m_rental->get_data('mobil')->result();
        $data['kostumer']   = $this->m_rental->get_data('kostumer')->result();
        $data['transaksi']  = $this->db->query("select * from transaksi,mobil,kostumer where transaksi_mobil=mobil_id and transaksi_kostumer=kostumer_id and transaksi_id='$id'")->result();
        
        $this->load->view('admin/header');
        $this->load->view('admin/transaksi_selesai',$data);
        $this->load->view('admin/footer');
    }
    function transaksi_selesai_act(){
        $id                 = $this->input->post('id');
        $tgl_dikembalikan   = $this->input->post('tgl_dikembalikan');
        $tgl_kembali        = $this->input->post('tgl_kembali');
        $mobil              = $this->input->post('mobil');
        $denda              = $this->input->post('denda');
        
        $this->form_validation->set_rules('tgl_dikembalikan','Tanggal pengembalian','required');
        
        if($this->form_validation->run() != false){
            //hitung selisih hari
            $batas_kembali  = strtotime($tgl_kembali);
            $dikembalikan   = strtotime($tgl_dikembalikan);
            $selisih        = abs(($batas_kembali - $dikembalikan)/(60*60*24));
            $total_denda    = $denda * $selisih;
            
            //update status transaksi
            $data = array(
                'transaksi_tgldikembalikan' => $tgl_dikembalikan,
                'transaksi_status'          => 1,
                'transaksi_totaldenda'      => $total_denda
            );
            
            $w = array('transaksi_id' => $id);
            $this->m_rental->update_data($w,$data,'transaksi');
            
            //update status mobil
            $data2 = array('mobil_status' => 1);
            $w2 = array('mobil_id' => $mobil);
            $this->m_rental->update_data($w2,$data2,'mobil');
            redirect(base_url().'admin/transaksi');
        } else {
            $data['mobil']      = $this->m_rental->get_data('mobil')->result();
            $data['kostumer']   = $this->m_rental->get_data('kostumer')->result();
            $data['transaksi']  = $this->db->query("select * from transaksi,mobil,kostumer where transaksi_mobil=mobil_id and transaksi_kostumer=kostumer_id and transaksi_id='$id'")->result();
            
            $this->load->view('admin/header');
            $this->load->view('admin/transaksi_selesai',$data);
            $this->load->view('admin/footer');
        }
    }
    
    //fungsi-fungsi pelaporan
    function laporan(){
        $this->load->view('admin/header');
        $this->load->view('admin/laporan');
        $this->load->view('admin/footer');
    }
    
    //fungsi CRUD User
    function user(){
        $this->load->view('admin/header');
        $this->load->view('admin/user');
        $this->load->view('admin/footer');
    }
}
?>