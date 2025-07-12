<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    // Login user
    public function login($username, $password) {
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        
        if ($query->num_rows() == 1) {
            $user = $query->row();
            if (password_verify($password, $user->password)) {
                return $user;
            }
        }
        return false;
    }
    
    // Get user by ID
    public function get_user_by_id($user_id) {
        $this->db->where('user_id', $user_id);
        return $this->db->get('users')->row();
    }
    
    // Get all users
    public function get_all_users() {
        return $this->db->get('users')->result();
    }
    
    // Create new user
    public function create_user($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $this->db->insert('users', $data);
    }
    
    // Update user
    public function update_user($user_id, $data) {
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['password']);
        }
        $this->db->where('user_id', $user_id);
        return $this->db->update('users', $data);
    }
    
    // Delete user
    public function delete_user($user_id) {
        $this->db->where('user_id', $user_id);
        return $this->db->delete('users');
    }
    
    // Check if username exists
    public function username_exists($username, $exclude_id = null) {
        $this->db->where('username', $username);
        if ($exclude_id) {
            $this->db->where('user_id !=', $exclude_id);
        }
        return $this->db->get('users')->num_rows() > 0;
    }
} 