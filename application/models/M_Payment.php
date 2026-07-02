<?php
class M_Payment extends CI_Model {

    public function getAll() {
        return $this->db->get('payments')->result();
    }

    public function getAllWithDetail($keyword = null, $status = null)
    {
        $this->db
            ->select('
                payments.*,
                rooms.room_number,
                bookings.id_booking,
                users.name
            ')
            ->from('payments')
            ->join('bookings', 'bookings.id_booking = payments.id_booking')
            ->join('rooms', 'rooms.id_room = bookings.id_room')
            ->join('users', 'users.id_user = bookings.id_user');

        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('users.name', $keyword);
            $this->db->or_like('rooms.room_number', $keyword);
            $this->db->or_like('bookings.id_booking', $keyword);
            $this->db->or_like('payments.id_payment', $keyword);
            $this->db->or_like('payments.payment_method', $keyword);
            $this->db->group_end();
        }

        if (!empty($status)) {
            $this->db->where('payments.payment_status', $status);
        }

        return $this->db
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