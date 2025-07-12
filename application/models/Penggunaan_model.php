<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penggunaan_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    // Get all penggunaan with pelanggan info, support search & sort
    public function get_all_penggunaan($search = '', $sort = '', $order = '') {
        $this->db->select('penggunaan.*, pelanggan.nama as nama_pelanggan, pelanggan.alamat');
        $this->db->from('penggunaan');
        $this->db->join('pelanggan', 'pelanggan.pelanggan_id = penggunaan.pelanggan_id');
        if ($search) {
            $this->db->group_start();
            $this->db->like('pelanggan.nama', $search);
            $this->db->or_like('pelanggan.alamat', $search);
            $this->db->or_like('penggunaan.bulan', $search);
            $this->db->or_like('penggunaan.tahun', $search);
            $this->db->group_end();
        }
        $allowed_sort = ['nama_pelanggan', 'bulan', 'tahun', 'meter_awal', 'meter_akhir'];
        if (in_array($sort, $allowed_sort)) {
            $order = strtolower($order) === 'desc' ? 'desc' : 'asc';
            $this->db->order_by($sort, $order);
        } else {
            $this->db->order_by('penggunaan.tahun DESC, penggunaan.bulan DESC');
        }
        return $this->db->get()->result();
    }
    
    // Get penggunaan by ID
    public function get_penggunaan_by_id($penggunaan_id) {
        $this->db->select('penggunaan.*, pelanggan.nama as nama_pelanggan, pelanggan.alamat');
        $this->db->from('penggunaan');
        $this->db->join('pelanggan', 'pelanggan.pelanggan_id = penggunaan.pelanggan_id');
        $this->db->where('penggunaan.penggunaan_id', $penggunaan_id);
        return $this->db->get()->row();
    }
    
    // Get penggunaan by pelanggan ID
    public function get_penggunaan_by_pelanggan($pelanggan_id) {
        $this->db->where('pelanggan_id', $pelanggan_id);
        $this->db->order_by('tahun DESC, bulan DESC');
        return $this->db->get('penggunaan')->result();
    }
    
    // Get penggunaan by pelanggan ID, support search & sort
    public function get_penggunaan_by_pelanggan_search_sort($pelanggan_id, $search = '', $sort = '', $order = '') {
        $this->db->where('pelanggan_id', $pelanggan_id);
        if ($search) {
            $this->db->group_start();
            $this->db->like('bulan', $search);
            $this->db->or_like('tahun', $search);
            $this->db->or_like('meter_awal', $search);
            $this->db->or_like('meter_akhir', $search);
            $this->db->group_end();
        }
        $allowed_sort = ['bulan', 'tahun', 'meter_awal', 'meter_akhir'];
        if (in_array($sort, $allowed_sort)) {
            $order = strtolower($order) === 'desc' ? 'desc' : 'asc';
            $this->db->order_by($sort, $order);
        } else {
            $this->db->order_by('tahun DESC, bulan DESC');
        }
        return $this->db->get('penggunaan')->result();
    }
    
    // Create new penggunaan
    public function create_penggunaan($data) {
        return $this->db->insert('penggunaan', $data);
    }
    
    // Update penggunaan
    public function update_penggunaan($penggunaan_id, $data) {
        $this->db->where('penggunaan_id', $penggunaan_id);
        return $this->db->update('penggunaan', $data);
    }
    
    // Delete penggunaan
    public function delete_penggunaan($penggunaan_id) {
        $this->db->where('penggunaan_id', $penggunaan_id);
        return $this->db->delete('penggunaan');
    }
    
    // Check if penggunaan exists for pelanggan, bulan, tahun
    public function penggunaan_exists($pelanggan_id, $bulan, $tahun, $exclude_id = null) {
        $this->db->where('pelanggan_id', $pelanggan_id);
        $this->db->where('bulan', $bulan);
        $this->db->where('tahun', $tahun);
        if ($exclude_id) {
            $this->db->where('penggunaan_id !=', $exclude_id);
        }
        return $this->db->get('penggunaan')->num_rows() > 0;
    }
    
    // Get penggunaan with tagihan info
    public function get_penggunaan_with_tagihan($pelanggan_id = null) {
        $this->db->select('penggunaan.*, pelanggan.nama as nama_pelanggan, tagihan.total_kwh, tagihan.total_tagihan, tagihan.status');
        $this->db->from('penggunaan');
        $this->db->join('pelanggan', 'pelanggan.pelanggan_id = penggunaan.pelanggan_id');
        $this->db->join('tagihan', 'tagihan.penggunaan_id = penggunaan.penggunaan_id', 'left');
        if ($pelanggan_id) {
            $this->db->where('penggunaan.pelanggan_id', $pelanggan_id);
        }
        $this->db->order_by('penggunaan.tahun DESC, penggunaan.bulan DESC');
        return $this->db->get()->result();
    }
} 