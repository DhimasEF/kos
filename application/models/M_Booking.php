<?php
class M_Booking extends CI_Model {

    public function getAll() {
        return $this->db->get('bookings')->result();
    }

    public function getAllWithDetail() {
        return $this->db
            ->select('bookings.*, users.name, rooms.room_number')
            ->from('bookings')
            ->join('users', 'users.id_user = bookings.id_user')
            ->join('rooms', 'rooms.id_room = bookings.id_room')
            ->order_by('bookings.created_at', 'DESC')
            ->get()
            ->result();
    }

    public function insert($data) {
        return $this->db->insert('bookings', $data);
    }

    // optional (buat next fitur)
    public function getByUser($id_user) {
        return $this->db
            ->join('rooms', 'rooms.id_room = bookings.id_room')
            ->where('bookings.id_user', $id_user)
            ->get('bookings')
            ->result();
    }

    public function getByUserAndRoom($id_user, $id_room) {
        return $this->db
            ->where('id_user', $id_user)
            ->where('id_room', $id_room)
            ->get('bookings')
            ->row();
    }

    public function getDetail($id_booking, $id_user) {
        return $this->db
            ->select('bookings.*, rooms.room_number, rooms.price')
            ->from('bookings')
            ->join('rooms', 'rooms.id_room = bookings.id_room')
            ->where('bookings.id_booking', $id_booking)
            ->where('bookings.id_user', $id_user)
            ->get()
            ->row();
    }

    public function getDetailPayment($id_booking, $id_user) {
        return $this->db
            ->select('payments.*, rooms.room_number, bookings.start_at')
            ->from('payments')
            ->join('bookings', 'bookings.id_booking = payments.id_booking')
            ->join('rooms', 'rooms.id_room = bookings.id_room')
            ->where('payments.id_booking', $id_booking)
            ->where('bookings.id_user', $id_user)
            ->get()
            ->row();
    }

    public function getPaymentByUser($id_user) {
        return $this->db
            ->select('payments.*, rooms.room_number, bookings.start_at')
            ->from('payments')
            ->join('bookings', 'bookings.id_booking = payments.id_booking')
            ->join('rooms', 'rooms.id_room = bookings.id_room')
            ->where('bookings.id_user', $id_user)
            ->get()
            ->result();
    }
}