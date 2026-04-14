<?php
class M_Message extends CI_Model {

    public function getAll() {
        return $this->db->get('chat_rooms')->result();
    }
}