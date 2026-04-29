<?php
class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // Load semua model
        $this->load->model('M_Kamar');
        $this->load->model('M_Booking');
        $this->load->model('M_Message');
        $this->load->model('M_Payment');
        $this->load->model('M_User');

        // 🔒 PROTEKSI
        if (!$this->session->userdata('login') || $this->session->userdata('role') != 'admin') {
            redirect('auth');
        }
    }

    public function dashboard() {
        $data['total_kamar']   = $this->db->count_all('rooms');
        $data['total_booking'] = $this->db->count_all('bookings');
        $data['total_user']    = $this->db->count_all('users');
        $this->load->view('admin/dashboard', $data);
    }

    public function kamar() {
        $data['kamar'] = $this->M_Kamar->getAll();
        $this->load->view('admin/kamar', $data);
    }

    public function kamar_store()
    {
        $data = [
            'room_number' => $this->input->post('room_number'),
            'price'       => $this->input->post('price')
        ];

        $this->db->insert('rooms', $data);
        $id_room = $this->db->insert_id();

        // upload multi image
        if (!empty($_FILES['images']['name'][0])) {

            $count = count($_FILES['images']['name']);

            for ($i=0; $i<$count; $i++) {

                $_FILES['file']['name']     = $_FILES['images']['name'][$i];
                $_FILES['file']['type']     = $_FILES['images']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['images']['tmp_name'][$i];
                $_FILES['file']['error']    = $_FILES['images']['error'][$i];
                $_FILES['file']['size']     = $_FILES['images']['size'][$i];

                $config['upload_path']   = './assets/uploads/content/';
                $config['allowed_types'] = 'jpg|jpeg|png|webp';
                $config['encrypt_name']  = TRUE;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('file')) {

                    $up = $this->upload->data();

                    $this->db->insert('room_images', [
                        'id_room' => $id_room,
                        'image'   => $up['file_name']
                    ]);
                }
            }
        }

        redirect('admin/kamar');
    }

    public function kamar_detail($id)
    {
        $data['kamar'] = $this->M_Kamar->getById($id);

        if (!$data['kamar']) {
            show_404();
        }

        $this->load->view('admin/kamar_detail', $data);
    }

    public function kamar_update()
    {
        $id = $this->input->post('id_room');

        $data = [
            'room_number' => $this->input->post('room_number'),
            'price'       => $this->input->post('price')
        ];

        $this->db->where('id_room', $id);
        $this->db->update('rooms', $data);

        if (!empty($_FILES['images']['name'][0])) {

            $count = count($_FILES['images']['name']);

            for ($i=0; $i<$count; $i++) {

                $_FILES['file']['name']     = $_FILES['images']['name'][$i];
                $_FILES['file']['type']     = $_FILES['images']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['images']['tmp_name'][$i];
                $_FILES['file']['error']    = $_FILES['images']['error'][$i];
                $_FILES['file']['size']     = $_FILES['images']['size'][$i];

                $config['upload_path']   = './assets/uploads/content/';
                $config['allowed_types'] = 'jpg|jpeg|png|webp';
                $config['encrypt_name']  = TRUE;

                $this->load->library('upload', $config); // FIX
                $this->upload->initialize($config);

                if ($this->upload->do_upload('file')) {

                    $up = $this->upload->data();

                    $this->db->insert('room_images', [
                        'id_room' => $id,
                        'image'   => $up['file_name']
                    ]);
                }
            }
        }

        redirect('admin/kamar');
    }

    public function kamar_delete($id) {
        $this->db->delete('rooms', ['id_room' => $id]);
        redirect('admin/kamar');
    }

    public function booking() {
        $data['booking'] = $this->M_Booking->getAllWithDetail();
        $this->load->view('admin/booking', $data);
    }

    // APPROVE
    public function booking_approve($id) {
        $this->db->where('id_booking', $id);
        $this->db->update('bookings', ['status' => 'approved']);

        redirect('admin/booking');
    }

    // REJECT
    public function booking_reject($id) {
        $this->db->where('id_booking', $id);
        $this->db->update('bookings', ['status' => 'rejected']);

        redirect('admin/booking');
    }

    public function message() {
        $id_admin = $this->session->userdata('id_user');
        $data['rooms'] = $this->M_Message->getRoomsAdmin($id_admin);
        $this->load->view('admin/message', $data);
    }

    public function chat($id_user)
    {
        $id_admin = $this->session->userdata('id_user');

        $room = $this->M_Message->getRoom($id_user, $id_admin);

        if (!$room) {
            show_404();
        }

        $id_chat = $room->id_chat;

        $data['messages'] = $this->M_Message->getMessages($id_chat);
        $data['id_chat']  = $id_chat;
        $data['id_user']  = $id_user;

        // 🔥 TAMBAHAN INI
        $data['user'] = $this->M_User->getById($id_user);

        $this->M_Message->markAsRead($id_chat, $id_admin);

        $this->load->view('admin/chat', $data);
    }

    public function send_message()
    {
        $data = [
            'id_chat'   => $this->input->post('id_chat'),
            'sender_id' => $this->session->userdata('id_user'),
            'message'   => trim($this->input->post('message')),
            'is_read'   => 0,
            'sent_at'   => date('Y-m-d H:i:s')
        ];

        if ($data['message'] == '') {
            echo json_encode(['status'=>false]);
            return;
        }

        $this->M_Message->sendMessage($data);

        header('Content-Type: application/json');
        echo json_encode(['status'=>true]);
    }

    public function load_rooms()
    {
        $id_admin = $this->session->userdata('id_user');

        $rooms = $this->M_Message->getRoomsAdmin($id_admin);

        header('Content-Type: application/json');
        echo json_encode($rooms);
    }
    
    public function load_chat($id_chat)
    {
        $id_admin = $this->session->userdata('id_user');

        // validasi room milik admin
        $room = $this->db
            ->where('id_chat', $id_chat)
            ->where('id_admin', $id_admin)
            ->get('chat_rooms')
            ->row();

        if (!$room) {
            echo json_encode([]);
            return;
        }

        $messages = $this->M_Message->getMessages($id_chat);

        // tandai dibaca
        $this->M_Message->markAsRead($id_chat, $id_admin);

        header('Content-Type: application/json');
        echo json_encode($messages);
    }

    public function payment() {
        $data['payment'] = $this->M_Payment->getAllWithDetail();
        $this->load->view('admin/payment', $data);
    }

    public function payment_detail($id) {
        $data['payment'] = $this->M_Payment->getById($id);

        if (!$data['payment']) {
            show_404();
        }

        $this->load->view('admin/payment_detail', $data);
    }

    // ✅ APPROVE
    public function payment_approve($id) {
        $this->db->where('id_payment', $id);
        $this->db->update('payments', ['payment_status' => 'verified']);

        redirect('admin/payment');
    }

    // ❌ REJECT
    public function payment_reject($id) {
        $this->db->where('id_payment', $id);
        $this->db->update('payments', ['payment_status' => 'rejected']);

        redirect('admin/payment');
    }

    public function user() {
        $data['user'] = $this->M_User->getAll();
        $this->load->view('admin/user', $data);
    }
}