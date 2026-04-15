<?php
class M_Kamar extends CI_Model {

    public function getAll() {
        return $this->db->get('rooms')->result();
    }

    public function getById($id){
        return $this->db->get_where('rooms', ['id_room' => $id])->row();
    }
}