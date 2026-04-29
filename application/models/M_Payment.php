<?php
class M_Payment extends CI_Model {

    public function getAll() {
        return $this->db->get('payments')->result();
    }

    public function getAllWithDetail() {
        return $this->db
            ->select('payments.*, rooms.room_number, bookings.id_booking')
            ->from('payments')
            ->join('bookings', 'bookings.id_booking = payments.id_booking')
            ->join('rooms', 'rooms.id_room = bookings.id_room')
            ->order_by('payments.id_payment', 'DESC')
            ->get()
            ->result();
    }

    public function getById($id) {
        return $this->db
            ->select('payments.*, rooms.room_number, bookings.id_booking')
            ->from('payments')
            ->join('bookings', 'bookings.id_booking = payments.id_booking')
            ->join('rooms', 'rooms.id_room = bookings.id_room')
            ->where('payments.id_payment', $id)
            ->get()
            ->row();
    }
}