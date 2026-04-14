<?php
class M_Payment extends CI_Model {

    public function getAll() {
        return $this->db->get('payments')->result();
    }
}