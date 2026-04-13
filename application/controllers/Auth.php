<?php
class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_User');
    }

    // =====================
    // LOGIN PAGE
    // =====================
    public function index() {
        $this->load->view('login');
    }

    // =====================
    // PROSES LOGIN
    // =====================
    public function login() {

        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->M_User->getByEmail($email);

        if ($user) {
            if (password_verify($password, $user->password)) {

                // SET SESSION
                $data_session = [
                    'id_user' => $user->id_user,
                    'name'    => $user->name,
                    'email'   => $user->email,
                    'role'    => $user->role,
                    'login'   => TRUE
                ];

                $this->session->set_userdata($data_session);

                // 🔥 ROLE REDIRECT
                if ($user->role == 'admin') {
                    redirect('admin/dashboard');
                } else {
                    redirect('user/dashboard');
                }

            } else {
                $this->session->set_flashdata('error', 'Password salah');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('error', 'Email tidak ditemukan');
            redirect('auth');
        }
    }

    // =====================
    // LOGOUT
    // =====================
    public function logout() {
        $this->session->sess_destroy();
        redirect('auth');
    }
}