<?php
class User extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('login') || $this->session->userdata('role') != 'user') {
            redirect('auth');
        }
    }

    public function dashboard() {
        $this->load->view('user/dashboard');
    }
}