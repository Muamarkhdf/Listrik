<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        // Check if user is logged in and is admin
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('auth/login');
        }
        
        $this->load->model('User_model');
        $this->load->model('Pelanggan_model');
        $this->load->model('Penggunaan_model');
        $this->load->model('Tagihan_model');
    }
    
    public function index() {
        redirect('admin/dashboard');
    }
    
    public function dashboard() {
        $data['title'] = 'Dashboard Admin - Aplikasi Pembayaran Listrik';
        $data['user'] = $this->session->userdata();
        
        // Get statistics
        $data['total_pelanggan'] = $this->db->count_all('pelanggan');
        $data['total_penggunaan'] = $this->db->count_all('penggunaan');
        $data['total_tagihan'] = $this->db->count_all('tagihan');
        $data['tagihan_stats'] = $this->Tagihan_model->get_tagihan_stats();
        // Pastikan pendapatan benar-benar 0 jika tidak ada tagihan
        $total_pendapatan = 0;
        if (
            $data['tagihan_stats'] &&
            !empty($data['tagihan_stats']->total_tagihan) &&
            is_numeric($data['tagihan_stats']->total_pendapatan) &&
            $data['tagihan_stats']->total_pendapatan > 0
        ) {
            $total_pendapatan = $data['tagihan_stats']->total_pendapatan;
        }
        $data['total_pendapatan'] = $total_pendapatan;
        
        $this->load->view('admin/header', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('admin/footer');
    }
    
    // Pelanggan Management
    public function pelanggan() {
        $data['title'] = 'Manajemen Pelanggan - Aplikasi Pembayaran Listrik';
        $data['user'] = $this->session->userdata();
        $search = $this->input->get('search', TRUE);
        $sort = $this->input->get('sort', TRUE);
        $order = $this->input->get('order', TRUE);
        $data['search'] = $search;
        $data['sort'] = $sort;
        $data['order'] = $order;
        $data['pelanggan'] = $this->Pelanggan_model->get_all_pelanggan($search, $sort, $order);
        
        $this->load->view('admin/header', $data);
        $this->load->view('admin/pelanggan/index', $data);
        $this->load->view('admin/footer');
    }
    
    public function pelanggan_add() {
        $data['title'] = 'Tambah Pelanggan - Aplikasi Pembayaran Listrik';
        $data['user'] = $this->session->userdata();
        $data['levels'] = $this->Pelanggan_model->get_all_levels();
        $data['users'] = $this->User_model->get_all_users();
        
        $this->form_validation->set_rules('nama', 'Nama Pelanggan', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('level_id', 'Level', 'required|numeric');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/header', $data);
            $this->load->view('admin/pelanggan/add', $data);
            $this->load->view('admin/footer');
        } else {
            $pelanggan_data = array(
                'nama' => $this->input->post('nama'),
                'alamat' => $this->input->post('alamat'),
                'level_id' => $this->input->post('level_id'),
                'user_id' => $this->input->post('user_id') ?: null
            );
            
            if ($this->Pelanggan_model->create_pelanggan($pelanggan_data)) {
                $this->session->set_flashdata('success', 'Pelanggan berhasil ditambahkan!');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan pelanggan!');
            }
            redirect('admin/pelanggan');
        }
    }
    
    public function pelanggan_edit($id) {
        $data['title'] = 'Edit Pelanggan - Aplikasi Pembayaran Listrik';
        $data['user'] = $this->session->userdata();
        $data['pelanggan'] = $this->Pelanggan_model->get_pelanggan_by_id($id);
        $data['levels'] = $this->Pelanggan_model->get_all_levels();
        $data['users'] = $this->User_model->get_all_users();
        
        if (!$data['pelanggan']) {
            redirect('admin/pelanggan');
        }
        
        $this->form_validation->set_rules('nama', 'Nama Pelanggan', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('level_id', 'Level', 'required|numeric');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/header', $data);
            $this->load->view('admin/pelanggan/edit', $data);
            $this->load->view('admin/footer');
        } else {
            $pelanggan_data = array(
                'nama' => $this->input->post('nama'),
                'alamat' => $this->input->post('alamat'),
                'level_id' => $this->input->post('level_id'),
                'user_id' => $this->input->post('user_id') ?: null
            );
            
            if ($this->Pelanggan_model->update_pelanggan($id, $pelanggan_data)) {
                $this->session->set_flashdata('success', 'Pelanggan berhasil diupdate!');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengupdate pelanggan!');
            }
            redirect('admin/pelanggan');
        }
    }
    
    public function pelanggan_delete($id) {
        if ($this->Pelanggan_model->delete_pelanggan($id)) {
            $this->session->set_flashdata('success', 'Pelanggan berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus pelanggan!');
        }
        redirect('admin/pelanggan');
    }
    
    // Penggunaan Management
    public function penggunaan() {
        $data['title'] = 'Manajemen Penggunaan - Aplikasi Pembayaran Listrik';
        $data['user'] = $this->session->userdata();
        $search = $this->input->get('search', TRUE);
        $sort = $this->input->get('sort', TRUE);
        $order = $this->input->get('order', TRUE);
        $data['search'] = $search;
        $data['sort'] = $sort;
        $data['order'] = $order;
        $data['penggunaan'] = $this->Penggunaan_model->get_all_penggunaan($search, $sort, $order);
        
        $this->load->view('admin/header', $data);
        $this->load->view('admin/penggunaan/index', $data);
        $this->load->view('admin/footer');
    }
    
    public function penggunaan_add() {
        $data['title'] = 'Tambah Penggunaan - Aplikasi Pembayaran Listrik';
        $data['user'] = $this->session->userdata();
        $data['pelanggan'] = $this->Pelanggan_model->get_all_pelanggan();
        
        $this->form_validation->set_rules('pelanggan_id', 'Pelanggan', 'required|numeric');
        $this->form_validation->set_rules('bulan', 'Bulan', 'required|numeric|greater_than[0]|less_than[13]');
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|numeric|greater_than[2000]');
        $this->form_validation->set_rules('meter_awal', 'Meter Awal', 'required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('meter_akhir', 'Meter Akhir', 'required|numeric|meter_akhir_valid');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/header', $data);
            $this->load->view('admin/penggunaan/add', $data);
            $this->load->view('admin/footer');
        } else {
            $penggunaan_data = array(
                'pelanggan_id' => $this->input->post('pelanggan_id'),
                'bulan' => $this->input->post('bulan'),
                'tahun' => $this->input->post('tahun'),
                'meter_awal' => $this->input->post('meter_awal'),
                'meter_akhir' => $this->input->post('meter_akhir')
            );
            
            // Check if penggunaan already exists
            if ($this->Penggunaan_model->penggunaan_exists($penggunaan_data['pelanggan_id'], $penggunaan_data['bulan'], $penggunaan_data['tahun'])) {
                $this->session->set_flashdata('error', 'Data penggunaan untuk pelanggan, bulan, dan tahun tersebut sudah ada!');
                redirect('admin/penggunaan_add');
            }
            
            if ($this->Penggunaan_model->create_penggunaan($penggunaan_data)) {
                $this->session->set_flashdata('success', 'Penggunaan berhasil ditambahkan!');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan penggunaan!');
            }
            redirect('admin/penggunaan');
        }
    }
    
    public function penggunaan_edit($id) {
        $data['title'] = 'Edit Penggunaan - Aplikasi Pembayaran Listrik';
        $data['user'] = $this->session->userdata();
        $data['penggunaan'] = $this->Penggunaan_model->get_penggunaan_by_id($id);
        $data['pelanggan'] = $this->Pelanggan_model->get_all_pelanggan();
        
        if (!$data['penggunaan']) {
            redirect('admin/penggunaan');
        }
        
        $this->form_validation->set_rules('pelanggan_id', 'Pelanggan', 'required|numeric');
        $this->form_validation->set_rules('bulan', 'Bulan', 'required|numeric|greater_than[0]|less_than[13]');
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|numeric|greater_than[2000]');
        $this->form_validation->set_rules('meter_awal', 'Meter Awal', 'required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('meter_akhir', 'Meter Akhir', 'required|numeric|meter_akhir_valid');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/header', $data);
            $this->load->view('admin/penggunaan/edit', $data);
            $this->load->view('admin/footer');
        } else {
            $penggunaan_data = array(
                'pelanggan_id' => $this->input->post('pelanggan_id'),
                'bulan' => $this->input->post('bulan'),
                'tahun' => $this->input->post('tahun'),
                'meter_awal' => $this->input->post('meter_awal'),
                'meter_akhir' => $this->input->post('meter_akhir')
            );
            
            // Check if penggunaan already exists (excluding current record)
            if ($this->Penggunaan_model->penggunaan_exists($penggunaan_data['pelanggan_id'], $penggunaan_data['bulan'], $penggunaan_data['tahun'], $id)) {
                $this->session->set_flashdata('error', 'Data penggunaan untuk pelanggan, bulan, dan tahun tersebut sudah ada!');
                redirect('admin/penggunaan_edit/' . $id);
            }
            
            if ($this->Penggunaan_model->update_penggunaan($id, $penggunaan_data)) {
                // Hapus tagihan terkait agar sinkron
                $this->Tagihan_model->delete_tagihan_by_penggunaan($id);
                $this->session->set_flashdata('success', 'Penggunaan berhasil diupdate! Tagihan terkait dihapus, silakan generate ulang tagihan.');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengupdate penggunaan!');
            }
            redirect('admin/penggunaan');
        }
    }
    
    public function penggunaan_delete($id) {
        if ($this->Penggunaan_model->delete_penggunaan($id)) {
            $this->session->set_flashdata('success', 'Penggunaan berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus penggunaan!');
        }
        redirect('admin/penggunaan');
    }
    
    // Tagihan Management
    public function tagihan() {
        $data['title'] = 'Manajemen Tagihan - Aplikasi Pembayaran Listrik';
        $data['user'] = $this->session->userdata();
        $search = $this->input->get('search', TRUE);
        $sort = $this->input->get('sort', TRUE);
        $order = $this->input->get('order', TRUE);
        $data['search'] = $search;
        $data['sort'] = $sort;
        $data['order'] = $order;
        $data['tagihan'] = $this->Tagihan_model->get_all_tagihan($search, $sort, $order);
        
        $this->load->view('admin/header', $data);
        $this->load->view('admin/tagihan/index', $data);
        $this->load->view('admin/footer');
    }
    
    public function generate_tagihan($penggunaan_id) {
        if ($this->Tagihan_model->generate_tagihan($penggunaan_id)) {
            $this->session->set_flashdata('success', 'Tagihan berhasil dibuat!');
        } else {
            $this->session->set_flashdata('error', 'Gagal membuat tagihan!');
        }
        redirect('admin/penggunaan');
    }
    
    public function tagihan_status($tagihan_id, $status) {
        if ($this->Tagihan_model->update_status($tagihan_id, $status)) {
            $this->session->set_flashdata('success', 'Status tagihan berhasil diupdate!');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengupdate status tagihan!');
        }
        redirect('admin/tagihan');
    }
    
    public function tagihan_delete($tagihan_id) {
        if ($this->Tagihan_model->delete_tagihan($tagihan_id)) {
            $this->session->set_flashdata('success', 'Tagihan berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus tagihan!');
        }
        redirect('admin/tagihan');
    }
} 