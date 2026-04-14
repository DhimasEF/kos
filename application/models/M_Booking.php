<?php
class M_Booking extends CI_Model {

    public function getAll() {
        return $this->db->get('bookings')->result();
    }
}