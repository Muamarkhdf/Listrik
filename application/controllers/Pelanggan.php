<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        
        $this->load->model('User_model');
        $this->load->model('Pelanggan_model');
        $this->load->model('Penggunaan_model');
        $this->load->model('Tagihan_model');
    }
    
    public function index() {
        redirect('pelanggan/dashboard');
    }
    
    public function dashboard() {
        $data['title'] = 'Dashboard Pelanggan - Aplikasi Pembayaran Listrik';
        $data['user'] = $this->session->userdata();
        
        // Get pelanggan data
        $data['pelanggan'] = $this->Pelanggan_model->get_pelanggan_by_user_id($this->session->userdata('user_id'));
        
        if ($data['pelanggan']) {
            // Get recent penggunaan
            $data['penggunaan'] = $this->Penggunaan_model->get_penggunaan_by_pelanggan($data['pelanggan']->pelanggan_id);
            
            // Get recent tagihan
            $data['tagihan'] = $this->Tagihan_model->get_tagihan_by_pelanggan($data['pelanggan']->pelanggan_id);
        }
        
        $this->load->view('pelanggan/header', $data);
        $this->load->view('pelanggan/dashboard', $data);
        $this->load->view('pelanggan/footer');
    }
    
    public function penggunaan() {
        $data['title'] = 'Data Penggunaan Listrik - Aplikasi Pembayaran Listrik';
        $data['user'] = $this->session->userdata();
        $search = $this->input->get('search', TRUE);
        $sort = $this->input->get('sort', TRUE);
        $order = $this->input->get('order', TRUE);
        $data['search'] = $search;
        $data['sort'] = $sort;
        $data['order'] = $order;
        // Get pelanggan data
        $pelanggan = $this->Pelanggan_model->get_pelanggan_by_user_id($this->session->userdata('user_id'));
        if ($pelanggan) {
            $data['penggunaan'] = $this->Penggunaan_model->get_penggunaan_by_pelanggan_search_sort($pelanggan->pelanggan_id, $search, $sort, $order);
        } else {
            $data['penggunaan'] = array();
        }
        $this->load->view('pelanggan/header', $data);
        $this->load->view('pelanggan/penggunaan/index', $data);
        $this->load->view('pelanggan/footer');
    }
    
    public function penggunaan_add() {
        $data['title'] = 'Tambah Penggunaan Listrik - Aplikasi Pembayaran Listrik';
        $data['user'] = $this->session->userdata();
        
        // Get pelanggan data
        $data['pelanggan'] = $this->Pelanggan_model->get_pelanggan_by_user_id($this->session->userdata('user_id'));
        
        if (!$data['pelanggan']) {
            $this->session->set_flashdata('error', 'Data pelanggan tidak ditemukan!');
            redirect('pelanggan/dashboard');
        }
        
        $this->form_validation->set_rules('bulan', 'Bulan', 'required|numeric|greater_than[0]|less_than[13]');
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|numeric|greater_than[2000]');
        $this->form_validation->set_rules('meter_awal', 'Meter Awal', 'required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('meter_akhir', 'Meter Akhir', 'required|numeric|meter_akhir_valid');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('pelanggan/header', $data);
            $this->load->view('pelanggan/penggunaan/add', $data);
            $this->load->view('pelanggan/footer');
        } else {
            $penggunaan_data = array(
                'pelanggan_id' => $data['pelanggan']->pelanggan_id,
                'bulan' => $this->input->post('bulan'),
                'tahun' => $this->input->post('tahun'),
                'meter_awal' => $this->input->post('meter_awal'),
                'meter_akhir' => $this->input->post('meter_akhir')
            );
            
            // Check if penggunaan already exists
            if ($this->Penggunaan_model->penggunaan_exists($penggunaan_data['pelanggan_id'], $penggunaan_data['bulan'], $penggunaan_data['tahun'])) {
                $this->session->set_flashdata('error', 'Data penggunaan untuk bulan dan tahun tersebut sudah ada!');
                redirect('pelanggan/penggunaan_add');
            }
            
            if ($this->Penggunaan_model->create_penggunaan($penggunaan_data)) {
                $this->session->set_flashdata('success', 'Penggunaan berhasil ditambahkan!');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan penggunaan!');
            }
            redirect('pelanggan/penggunaan');
        }
    }
    
    public function penggunaan_edit($id) {
        $data['title'] = 'Edit Penggunaan Listrik - Aplikasi Pembayaran Listrik';
        $data['user'] = $this->session->userdata();
        // Tambahkan baris berikut agar $data['pelanggan'] selalu tersedia di view
        $data['pelanggan'] = $this->Pelanggan_model->get_pelanggan_by_user_id($this->session->userdata('user_id'));
        
        // Get pelanggan data
        $pelanggan = $data['pelanggan'];
        if (!$pelanggan) {
            $this->session->set_flashdata('error', 'Data pelanggan tidak ditemukan!');
            redirect('pelanggan/dashboard');
        }
        $data['penggunaan'] = $this->Penggunaan_model->get_penggunaan_by_id($id);
        
        // Check if penggunaan belongs to this pelanggan
        if (!$data['penggunaan'] || $data['penggunaan']->pelanggan_id != $pelanggan->pelanggan_id) {
            $this->session->set_flashdata('error', 'Data penggunaan tidak ditemukan!');
            redirect('pelanggan/penggunaan');
        }
        
        $this->form_validation->set_rules('bulan', 'Bulan', 'required|numeric|greater_than[0]|less_than[13]');
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|numeric|greater_than[2000]');
        $this->form_validation->set_rules('meter_awal', 'Meter Awal', 'required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('meter_akhir', 'Meter Akhir', 'required|numeric|meter_akhir_valid');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('pelanggan/header', $data);
            $this->load->view('pelanggan/penggunaan/edit', $data);
            $this->load->view('pelanggan/footer');
        } else {
            $penggunaan_data = array(
                'bulan' => $this->input->post('bulan'),
                'tahun' => $this->input->post('tahun'),
                'meter_awal' => $this->input->post('meter_awal'),
                'meter_akhir' => $this->input->post('meter_akhir')
            );
            
            // Check if penggunaan already exists (excluding current record)
            if ($this->Penggunaan_model->penggunaan_exists($pelanggan->pelanggan_id, $penggunaan_data['bulan'], $penggunaan_data['tahun'], $id)) {
                $this->session->set_flashdata('error', 'Data penggunaan untuk bulan dan tahun tersebut sudah ada!');
                redirect('pelanggan/penggunaan_edit/' . $id);
            }
            
            if ($this->Penggunaan_model->update_penggunaan($id, $penggunaan_data)) {
                $this->session->set_flashdata('success', 'Penggunaan berhasil diupdate!');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengupdate penggunaan!');
            }
            redirect('pelanggan/penggunaan');
        }
    }
    
    public function penggunaan_delete($id) {
        // Get pelanggan data
        $pelanggan = $this->Pelanggan_model->get_pelanggan_by_user_id($this->session->userdata('user_id'));
        
        if (!$pelanggan) {
            $this->session->set_flashdata('error', 'Data pelanggan tidak ditemukan!');
            redirect('pelanggan/dashboard');
        }
        
        $penggunaan = $this->Penggunaan_model->get_penggunaan_by_id($id);
        
        // Check if penggunaan belongs to this pelanggan
        if (!$penggunaan || $penggunaan->pelanggan_id != $pelanggan->pelanggan_id) {
            $this->session->set_flashdata('error', 'Data penggunaan tidak ditemukan!');
            redirect('pelanggan/penggunaan');
        }
        
        if ($this->Penggunaan_model->delete_penggunaan($id)) {
            $this->session->set_flashdata('success', 'Penggunaan berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus penggunaan!');
        }
        redirect('pelanggan/penggunaan');
    }
    
    public function tagihan() {
        $data['title'] = 'Data Tagihan Listrik - Aplikasi Pembayaran Listrik';
        $data['user'] = $this->session->userdata();
        $search = $this->input->get('search', TRUE);
        $sort = $this->input->get('sort', TRUE);
        $order = $this->input->get('order', TRUE);
        $data['search'] = $search;
        $data['sort'] = $sort;
        $data['order'] = $order;
        // Get pelanggan data
        $pelanggan = $this->Pelanggan_model->get_pelanggan_by_user_id($this->session->userdata('user_id'));
        if ($pelanggan) {
            $data['tagihan'] = $this->Tagihan_model->get_tagihan_by_pelanggan_search_sort($pelanggan->pelanggan_id, $search, $sort, $order);
        } else {
            $data['tagihan'] = array();
        }
        $this->load->view('pelanggan/header', $data);
        $this->load->view('pelanggan/tagihan/index', $data);
        $this->load->view('pelanggan/footer');
    }
    
    public function profile() {
        $data['title'] = 'Profil Pelanggan - Aplikasi Pembayaran Listrik';
        $data['user'] = $this->session->userdata();
        $data['pelanggan'] = $this->Pelanggan_model->get_pelanggan_by_user_id($this->session->userdata('user_id'));
        
        $this->load->view('pelanggan/header', $data);
        $this->load->view('pelanggan/profile', $data);
        $this->load->view('pelanggan/footer');
    }
} 