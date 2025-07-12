<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    // Get all pelanggan with level info, support search & sort
    public function get_all_pelanggan($search = '', $sort = '', $order = '') {
        $this->db->select('pelanggan.*, level.daya, level.tarif_per_kwh, users.username, users.nama as nama_user');
        $this->db->from('pelanggan');
        $this->db->join('level', 'level.level_id = pelanggan.level_id');
        $this->db->join('users', 'users.user_id = pelanggan.user_id', 'left');
        if ($search) {
            $this->db->group_start();
            $this->db->like('pelanggan.nama', $search);
            $this->db->or_like('pelanggan.alamat', $search);
            $this->db->or_like('users.username', $search);
            $this->db->group_end();
        }
        $allowed_sort = ['nama', 'alamat', 'daya', 'tarif_per_kwh'];
        if (in_array($sort, $allowed_sort)) {
            $order = strtolower($order) === 'desc' ? 'desc' : 'asc';
            $this->db->order_by($sort, $order);
        } else {
            $this->db->order_by('pelanggan.nama', 'asc');
        }
        return $this->db->get()->result();
    }
    
    // Get pelanggan by ID
    public function get_pelanggan_by_id($pelanggan_id) {
        $this->db->select('pelanggan.*, level.daya, level.tarif_per_kwh, users.username, users.nama as nama_user');
        $this->db->from('pelanggan');
        $this->db->join('level', 'level.level_id = pelanggan.level_id');
        $this->db->join('users', 'users.user_id = pelanggan.user_id', 'left');
        $this->db->where('pelanggan.pelanggan_id', $pelanggan_id);
        return $this->db->get()->row();
    }
    
    // Get pelanggan by user ID
    public function get_pelanggan_by_user_id($user_id) {
        $this->db->select('pelanggan.*, level.daya, level.tarif_per_kwh');
        $this->db->from('pelanggan');
        $this->db->join('level', 'level.level_id = pelanggan.level_id');
        $this->db->where('pelanggan.user_id', $user_id);
        return $this->db->get()->row();
    }
    
    // Create new pelanggan
    public function create_pelanggan($data) {
        return $this->db->insert('pelanggan', $data);
    }
    
    // Update pelanggan
    public function update_pelanggan($pelanggan_id, $data) {
        $this->db->where('pelanggan_id', $pelanggan_id);
        return $this->db->update('pelanggan', $data);
    }
    
    // Delete pelanggan
    public function delete_pelanggan($pelanggan_id) {
        $this->db->where('pelanggan_id', $pelanggan_id);
        return $this->db->delete('pelanggan');
    }
    
    // Get all levels
    public function get_all_levels() {
        return $this->db->get('level')->result();
    }
    
    // Get level by ID
    public function get_level_by_id($level_id) {
        $this->db->where('level_id', $level_id);
        return $this->db->get('level')->row();
    }
} 