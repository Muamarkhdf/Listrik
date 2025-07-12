<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tagihan_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    // Get all tagihan with usage and customer info
    public function get_all_tagihan() {
        $this->db->select('tagihan.*, penggunaan.bulan, penggunaan.tahun, penggunaan.meter_awal, penggunaan.meter_akhir, pelanggan.nama as nama_pelanggan, pelanggan.alamat');
        $this->db->from('tagihan');
        $this->db->join('penggunaan', 'penggunaan.penggunaan_id = tagihan.penggunaan_id');
        $this->db->join('pelanggan', 'pelanggan.pelanggan_id = penggunaan.pelanggan_id');
        $this->db->order_by('tagihan.created_at DESC');
        return $this->db->get()->result();
    }
    
    // Get tagihan by ID
    public function get_tagihan_by_id($tagihan_id) {
        $this->db->select('tagihan.*, penggunaan.bulan, penggunaan.tahun, penggunaan.meter_awal, penggunaan.meter_akhir, pelanggan.nama as nama_pelanggan, pelanggan.alamat');
        $this->db->from('tagihan');
        $this->db->join('penggunaan', 'penggunaan.penggunaan_id = tagihan.penggunaan_id');
        $this->db->join('pelanggan', 'pelanggan.pelanggan_id = penggunaan.pelanggan_id');
        $this->db->where('tagihan.tagihan_id', $tagihan_id);
        return $this->db->get()->row();
    }
    
    // Get tagihan by pelanggan ID
    public function get_tagihan_by_pelanggan($pelanggan_id) {
        $this->db->select('tagihan.*, penggunaan.bulan, penggunaan.tahun, penggunaan.meter_awal, penggunaan.meter_akhir');
        $this->db->from('tagihan');
        $this->db->join('penggunaan', 'penggunaan.penggunaan_id = tagihan.penggunaan_id');
        $this->db->where('penggunaan.pelanggan_id', $pelanggan_id);
        $this->db->order_by('tagihan.created_at DESC');
        return $this->db->get()->result();
    }
    
    // Create new tagihan
    public function create_tagihan($data) {
        return $this->db->insert('tagihan', $data);
    }
    
    // Update tagihan
    public function update_tagihan($tagihan_id, $data) {
        $this->db->where('tagihan_id', $tagihan_id);
        return $this->db->update('tagihan', $data);
    }
    
    // Delete tagihan
    public function delete_tagihan($tagihan_id) {
        $this->db->where('tagihan_id', $tagihan_id);
        return $this->db->delete('tagihan');
    }
    
    // Generate tagihan from penggunaan
    public function generate_tagihan($penggunaan_id) {
        // Get penggunaan data with pelanggan and level info
        $this->db->select('penggunaan.*, pelanggan.level_id, level.tarif_per_kwh');
        $this->db->from('penggunaan');
        $this->db->join('pelanggan', 'pelanggan.pelanggan_id = penggunaan.pelanggan_id');
        $this->db->join('level', 'level.level_id = pelanggan.level_id');
        $this->db->where('penggunaan.penggunaan_id', $penggunaan_id);
        $penggunaan = $this->db->get()->row();
        
        if ($penggunaan) {
            $total_kwh = $penggunaan->meter_akhir - $penggunaan->meter_awal;
            $total_tagihan = $total_kwh * $penggunaan->tarif_per_kwh;
            
            $tagihan_data = array(
                'penggunaan_id' => $penggunaan_id,
                'total_kwh' => $total_kwh,
                'total_tagihan' => $total_tagihan,
                'status' => 'Belum Lunas'
            );
            
            return $this->create_tagihan($tagihan_data);
        }
        return false;
    }
    
    // Update tagihan status
    public function update_status($tagihan_id, $status) {
        $this->db->where('tagihan_id', $tagihan_id);
        return $this->db->update('tagihan', array('status' => $status));
    }
    
    // Check if tagihan exists for penggunaan
    public function tagihan_exists($penggunaan_id) {
        $this->db->where('penggunaan_id', $penggunaan_id);
        return $this->db->get('tagihan')->num_rows() > 0;
    }
    
    // Get tagihan by penggunaan ID
    public function get_tagihan_by_penggunaan($penggunaan_id) {
        $this->db->where('penggunaan_id', $penggunaan_id);
        return $this->db->get('tagihan')->row();
    }
    
    // Get tagihan statistics
    public function get_tagihan_stats() {
        $this->db->select('COUNT(*) as total_tagihan, SUM(CASE WHEN status = "Lunas" THEN 1 ELSE 0 END) as lunas, SUM(CASE WHEN status = "Belum Lunas" THEN 1 ELSE 0 END) as belum_lunas, SUM(total_tagihan) as total_pendapatan');
        return $this->db->get('tagihan')->row();
    }

    // Hapus tagihan berdasarkan penggunaan_id
    public function delete_tagihan_by_penggunaan($penggunaan_id) {
        $this->db->where('penggunaan_id', $penggunaan_id);
        return $this->db->delete('tagihan');
    }

    // Ambil data penggunaan lengkap untuk tagihan
    public function get_penggunaan_for_tagihan($penggunaan_id) {
        $this->db->select('penggunaan.*, pelanggan.level_id, level.tarif_per_kwh');
        $this->db->from('penggunaan');
        $this->db->join('pelanggan', 'pelanggan.pelanggan_id = penggunaan.pelanggan_id');
        $this->db->join('level', 'level.level_id = pelanggan.level_id');
        $this->db->where('penggunaan.penggunaan_id', $penggunaan_id);
        return $this->db->get()->row();
    }
} 