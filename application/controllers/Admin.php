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

    public function kamar_store() {
        $data = [
            'room_number' => $this->input->post('room_number'),
            'price' => $this->input->post('price')
        ];

        $this->db->insert('rooms', $data);
        redirect('admin/kamar');
    }

    public function kamar_update() {
        $id = $this->input->post('id_room');

        $data = [
            'room_number' => $this->input->post('room_number'),
            'price' => $this->input->post('price')
        ];

        $this->db->where('id_room', $id);
        $this->db->update('rooms', $data);

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

    public function chat($id_user) {
        $id_admin = $this->session->userdata('id_user');
        $room = $this->M_Message->getRoom($id_user, $id_admin);

        if (!$room) {
            $id_chat = $this->M_Message->createRoom($id_user, $id_admin);
        } else {
            $id_chat = $room->id_chat;
        }

        $data['messages'] = $this->M_Message->getMessages($id_chat);
        $data['id_chat'] = $id_chat;
        $data['id_user'] = $id_user;

        // mark read
        $this->M_Message->markAsRead($id_chat, $id_admin);
        $this->load->view('admin/chat', $data);
    }

    public function send_message() {
        $data = [
            'id_chat'   => $this->input->post('id_chat'),
            'sender_id' => $this->session->userdata('id_user'),
            'message'   => $this->input->post('message'),
            'is_read'   => 0,
            'sent_at'   => date('Y-m-d H:i:s')
        ];

        $this->M_Message->sendMessage($data);
    }


    public function payment() {
        $data['payment'] = $this->M_Payment->getAll();
        $this->load->view('admin/payment', $data);
    }

    public function user() {
        $data['user'] = $this->M_User->getAll();
        $this->load->view('admin/user', $data);
    }
}