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
        $data['user'] = $this->db->get_where('users', [
            'id_user' => $this->session->userdata('id_user')
        ])->row();
        
        $id = $this->session->userdata('id_user');
        $data['total_booking'] = $this->db
                ->where('id_user', $id)
                ->count_all_results('bookings');

        // booking aktif (masih sewa)
        $data['booking_active'] = $this->db
            ->where('id_user', $id)
            ->where('status', 'active')
            ->count_all_results('bookings');

        $this->load->view('user/sidebar', $data);
        $this->load->view('user/dashboard', $data);
    }

    public function update_profile()
    {
        $id = $this->session->userdata('id_user');

        $data = [
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
        ];

        // upload foto
        if (!empty($_FILES['foto']['name'])) {

            $config['upload_path'] = './assets/uploads/profile/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['file_name'] = time();

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {
                $data['profil_picture'] = $this->upload->data('file_name');
            }
        }

        $this->db->where('id_user', $id);
        $this->db->update('users', $data);

        redirect('user/dashboard');
    }

    public function kamar() {
        $data['kamar'] = $this->M_Kamar->getAll();
        $this->load->view('user/sidebar', $data);
        $this->load->view('user/kamar', $data);
    }

    public function kamar_detail($id_room)
    {
        $id_user = $this->session->userdata('id_user');

        $data['kamar'] = $this->M_Kamar->getById($id_room);

        $booking = $this->db
            ->where('id_room', $id_room)
            ->where_in('status', ['approved','completed'])
            ->order_by('end_at', 'DESC')
            ->get('bookings')
            ->row();

        $data['booking'] = $booking;

        // default
        $data['can_extend'] = false;
        $data['is_owner']   = false;

        if ($booking) {

            // cek pemilik
            if ($booking->id_user == $id_user) {
                $data['is_owner'] = true;
            }

            $today   = date('Y-m-d');
            $expired = $booking->end_at;

            $h_minus_10 = date('Y-m-d', strtotime($expired . ' -10 days'));

            if (
                $booking->id_user == $id_user &&
                $today >= $h_minus_10 &&
                $today <= $expired
            ) {
                $data['can_extend'] = true;
            }
        }

        // 🔥 ambil nama penyewa
        if ($booking) {
            $data['penyewa'] = $this->M_User->getById($booking->id_user);
        }

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

    public function booking_extend()
    {
        $id_booking = $this->input->post('id_booking');
        $id_user    = $this->session->userdata('id_user');

        $booking = $this->db->get_where('bookings', [
            'id_booking' => $id_booking
        ])->row();

        if (!$booking) show_404();

        // 🔥 VALIDASI: hanya pemilik
        if ($booking->id_user != $id_user) {
            show_error('Bukan booking kamu');
        }

        // 🔥 hitung tanggal baru
        $start = $booking->end_at;
        $end   = date('Y-m-d', strtotime($start . ' +1 month'));

        // 🔥 INSERT booking baru (EXTEND)
        $this->db->insert('bookings', [
            'id_room'   => $booking->id_room,
            'id_user'   => $id_user,
            'start_at'  => $start,
            'end_at'    => $end,
            'status'    => 'pending',
            'type'      => 'extend',
            'parent_booking' => $booking->id_booking,
            'created_at'=> date('Y-m-d H:i:s')
        ]);

        redirect('user/booking');
    }

    public function booking_detail($id_booking) {
        $id_user = $this->session->userdata('id_user');
        
        $data['booking'] = $this->M_Booking->getDetail($id_booking, $id_user);
        $data['payment'] = $this->M_Booking->getDetailPayment($id_booking, $id_user);

        if (!$data['booking']) {
            show_404();
        }

        $data['review'] = $this->M_Booking->getByBooking($id_booking, $id_user);

        $this->load->view('user/booking_detail', $data);
    }

    public function review_store()
    {
        $id_user    = $this->session->userdata('id_user');
        $id_booking = $this->input->post('id_booking');

        $booking = $this->M_Booking->getDetail($id_booking, $id_user);
        $payment = $this->M_Booking->getDetailPayment($id_booking, $id_user);

        if (!$booking) {
            show_404();
        }

        // hanya booking approved + sudah bayar verified
        if ($booking->status != 'approved' || $payment->payment_status != 'verified') {
            redirect('user/booking_detail/'.$id_booking);
        }

        // cek apakah sudah review
        $cek = $this->M_Booking->getByBooking($id_booking, $id_user);

        if (!$cek) {

            $data = [
                'id_booking' => $id_booking,
                'id_user'    => $id_user,
                'id_room'    => $booking->id_room,
                'rating'     => $this->input->post('rating'),
                'review'     => $this->input->post('review'),
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->M_Booking->store($data);
        }

        redirect('user/booking_detail/'.$id_booking);
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