<?php
class M_Kamar extends CI_Model {

    public function getAll() {
        return $this->db->get('rooms')->result();
    }
}