<?php
class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // 🔒 PROTEKSI
        if (!$this->session->userdata('login') || $this->session->userdata('role') != 'admin') {
            redirect('auth');
        }
    }

    public function dashboard() {
        $this->load->view('admin/dashboard');
    }
}