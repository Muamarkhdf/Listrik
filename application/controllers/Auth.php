<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }
    
    public function index() {
        // Redirect to login if not logged in
        if ($this->session->userdata('logged_in')) {
            if ($this->session->userdata('role') == 'admin') {
                redirect('admin/dashboard');
            } else {
                redirect('pelanggan/dashboard');
            }
        }
        redirect('auth/login');
    }
    
    public function login() {
        // Check if already logged in
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }
        
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Login - Aplikasi Pembayaran Listrik';
            $this->load->view('auth/login', $data);
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            
            $user = $this->User_model->login($username, $password);
            
            if ($user) {
                $session_data = array(
                    'user_id' => $user->user_id,
                    'username' => $user->username,
                    'nama' => $user->nama,
                    'role' => $user->role,
                    'logged_in' => TRUE
                );
                
                $this->session->set_userdata($session_data);
                
                // Redirect based on role
                if ($user->role == 'admin') {
                    redirect('admin/dashboard');
                } else {
                    redirect('pelanggan/dashboard');
                }
            } else {
                $this->session->set_flashdata('error', 'Username atau password salah!');
                redirect('auth/login');
            }
        }
    }
    
    public function logout() {
        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('nama');
        $this->session->unset_userdata('role');
        $this->session->sess_destroy();
        
        $this->session->set_flashdata('success', 'Anda berhasil logout!');
        redirect('auth/login');
    }
} 