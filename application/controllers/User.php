<?php
class User extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // Load semua model
        $this->load->model('M_Kamar')   ;
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

        // CONFIG UPLOAD (sementara)
        $config['upload_path']   = './assets/uploads/payment/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 2048;
        $config['file_name']     = 'temp_' . time();

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('proof')) {
            echo $this->upload->display_errors();
            return;
        }

        $upload_data = $this->upload->data();
        $temp_name   = $upload_data['file_name'];

        // INSERT TANPA FILE DULU
        $data = [
            'id_booking'      => $this->input->post('id_booking'),
            'amount'          => $this->input->post('amount'),
            'payment_method'  => $this->input->post('payment_method'),
            'payment_status'  => 'paid',
            'payment_date'    => date('Y-m-d H:i:s'),
        ];

        $this->db->insert('payments', $data);
        $id_payment = $this->db->insert_id();

        // RENAME FILE
        $ext = pathinfo($temp_name, PATHINFO_EXTENSION);
        $new_name = 'payment_'.$id_payment.'_'.date('Ymd').'.'.$ext;

        rename(
            './assets/uploads/payment/'.$temp_name,
            './assets/uploads/payment/'.$new_name
        );

        // UPDATE DB DENGAN NAMA FINAL
        $this->db->where('id_payment', $id_payment);
        $this->db->update('payments', [
            'proof_of_payment' => $new_name
        ]);

        redirect('user/booking_detail/'.$this->input->post('id_booking'));
    }

    public function payment_detail($id_booking) {
        $id_user = $this->session->userdata('id_user');

        $data['payment'] = $this->M_Booking->getDetailPayment($id_booking, $id_user);

        $this->load->view('user/payment_detail', $data);
    }

    public function payment_update() {

        $id = $this->input->post('id_payment');

        // ambil data lama
        $old = $this->db->get_where('payments', ['id_payment' => $id])->row();

        $data = [
            'payment_method' => $this->input->post('payment_method'),
        ];

        // kalau upload baru
        if (!empty($_FILES['proof']['name'])) {

            $config['upload_path']   = './assets/uploads/payment/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['file_name']     = 'temp_' . time();

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('proof')) {

                $upload = $this->upload->data();
                $temp_name = $upload['file_name'];

                // HAPUS FILE LAMA
                if ($old && $old->proof_of_payment) {
                    $old_path = './assets/uploads/payment/'.$old->proof_of_payment;
                    if (file_exists($old_path)) {
                        unlink($old_path);
                    }
                }

                // RENAME FILE BARU
                $ext = pathinfo($temp_name, PATHINFO_EXTENSION);
                $new_name = 'payment_'.$id.'_'.date('Ymd').'.'.$ext;

                rename(
                    './assets/uploads/payment/'.$temp_name,
                    './assets/uploads/payment/'.$new_name
                );

                $data['proof_of_payment'] = $new_name;
            }
        }

        $this->db->where('id_payment', $id);
        $this->db->update('payments', $data);

        redirect('user/payment');
    }

    public function message() {
        $id_user  = $this->session->userdata('id_user');
        $id_admin = 1;

        $room = $this->M_Message->getRoom($id_user, $id_admin);

        $data['room'] = $room;

        if ($room) {
            $data['messages'] = $this->M_Message->getMessages($room->id_chat);
            $data['id_chat']  = $room->id_chat;

            $this->M_Message->markAsRead($room->id_chat, $id_user);
        } else {
            $data['messages'] = [];
            $data['id_chat'] = 0;
        }

        $this->load->view('user/message', $data);
    }

    public function send_message()
    {
        $id_user  = $this->session->userdata('id_user');
        $id_admin = 1;

        $message = trim($this->input->post('message'));

        if ($message == '') {
            echo json_encode(['status' => false]);
            return;
        }

        $room = $this->M_Message->getRoom($id_user, $id_admin);

        if (!$room) {
            $id_chat = $this->M_Message->createRoom($id_user, $id_admin);
        } else {
            $id_chat = $room->id_chat;
        }

        $data = [
            'id_chat'   => $id_chat,
            'sender_id' => $id_user,
            'message'   => $message,
            'is_read'   => 0,
            'sent_at'   => date('Y-m-d H:i:s')
        ];

        $this->M_Message->sendMessage($data);

        echo json_encode([
            'status' => true,
            'id_chat' => $id_chat
        ]);
    }

    public function load_chat()
    {
        $id_user  = $this->session->userdata('id_user');
        $id_admin = 1;

        $room = $this->M_Message->getRoom($id_user, $id_admin);

        if (!$room) {
            echo json_encode([]);
            return;
        }

        $messages = $this->M_Message->getMessages($room->id_chat);

        // tandai pesan admin sudah dibaca
        $this->M_Message->markAsRead($room->id_chat, $id_user);

        header('Content-Type: application/json');
        echo json_encode($messages);
    }
    
}