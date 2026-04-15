<?php
class User extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // Load semua model
        $this->load->model('M_Kamar');
        $this->load->model('M_Booking');
        $this->load->model('M_Message');
        $this->load->model('M_Payment');
        $this->load->model('M_User');

        // 🔒 PROTEKSI
        if (!$this->session->userdata('login') || $this->session->userdata('role') != 'user') {
            redirect('auth');
        }
    }

    public function dashboard() {
        $data['total_kamar']   = $this->db->count_all('rooms');
        $data['total_booking'] = $this->db->count_all('bookings');
        $data['total_user']    = $this->db->count_all('users');
        $this->load->view('user/dashboard', $data);
    }

    public function kamar() {
        $data['kamar'] = $this->M_Kamar->getAll();
        $this->load->view('user/kamar', $data);
    }

    public function kamar_detail($id) {
        $id_user = $this->session->userdata('id_user');

        $data['kamar'] = $this->M_Kamar->getById($id);

        // cek booking user untuk kamar ini
        $data['booking'] = $this->M_Booking->getByUserAndRoom($id_user, $id);
        $this->load->view('user/kamar_detail', $data);
    }

    // =====================
    // BOOKING
    // =====================
    public function booking_store() {

        $data = [
            'id_user'    => $this->session->userdata('id_user'),
            'id_room'    => $this->input->post('id_room'),
            'start_at'   => $this->input->post('start_at'),
            'status'     => 'pending',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->M_Booking->insert($data);

        redirect('user/kamar');
    }

    public function booking() {
        $id_user = $this->session->userdata('id_user');

        $data['kamar'] = $this->M_Booking->getByUser($id_user);
        $this->load->view('user/booking', $data);
    }

    public function booking_detail($id_booking) {
        $id_user = $this->session->userdata('id_user');
        
        $data['booking'] = $this->M_Booking->getDetail($id_booking, $id_user);

        if (!$data['booking']) {
            show_404();
        }

        $this->load->view('user/booking_detail', $data);
    }


    // =====================
    // PAYMENT
    // =====================
    public function payment() {
        $id_user = $this->session->userdata('id_user');

        $data['payment'] = $this->M_Booking->getPaymentByUser($id_user);

        $this->load->view('user/payment', $data);
    }

    public function payment_store() {

        // CONFIG UPLOAD
        $config['upload_path']   = './assets/uploads/payment/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 2048;
        $config['file_name']     = 'payment_' . time();

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('proof')) {

            // kalau gagal upload
            echo $this->upload->display_errors();
            return;

        } else {

            $upload_data = $this->upload->data();
            $file_name   = $upload_data['file_name'];

            $data = [
                'id_booking'      => $this->input->post('id_booking'),
                'amount'          => $this->input->post('amount'),
                'payment_method'  => $this->input->post('payment_method'),
                'payment_status'  => 'paid',
                'payment_date'    => date('Y-m-d H:i:s'),
                'proof_of_payment'=> $file_name
            ];

            $this->db->insert('payments', $data);

            redirect('user/booking_detail/'.$this->input->post('id_booking'));
        }
    }

    public function payment_detail($id_booking) {
        $id_user = $this->session->userdata('id_user');

        $data['payment'] = $this->M_Booking->getDetailPayment($id_booking, $id_user);

        $this->load->view('user/payment_detail', $data);
    }

    public function payment_update() {

        $id = $this->input->post('id_payment');

        $data = [
            'payment_method' => $this->input->post('payment_method'),
        ];

        // kalau upload baru
        if ($_FILES['proof']['name']) {

            $config['upload_path']   = './uploads/payment/';
            $config['allowed_types'] = 'jpg|png|jpeg';

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('proof')) {
                $upload = $this->upload->data();
                $data['proof_of_payment'] = $upload['file_name'];
            }
        }

        $this->db->where('id_payment', $id);
        $this->db->update('payments', $data);

        redirect('user/payment');
    }
}