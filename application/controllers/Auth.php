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
    // PROSES REGISTER
    // =====================
    public function register() {

        $name     = $this->input->post('name');
        $email    = $this->input->post('email');
        $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);

        // cek email sudah ada
        $cek = $this->M_User->getByEmail($email);

        if ($cek) {
            $this->session->set_flashdata('error', 'Email sudah terdaftar');
            redirect('auth');
        }

        // insert user
        $data = [
            'name'     => $name,
            'email'    => $email,
            'password' => $password,
            'role'     => 'user'
        ];

        $this->M_User->insert($data);

        $this->session->set_flashdata('success', 'Register berhasil, silakan login');
        redirect('auth');
    }

    // =====================
    // LOGOUT
    // =====================
    public function logout() {
        $this->session->sess_destroy();
        redirect('auth');
    }
}