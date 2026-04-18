<?php
class M_User extends CI_Model {

    public function getByEmail($email) {
        return $this->db->get_where('users', ['email' => $email])->row();
    }

    public function getAll() {
        return $this->db->get('users')->result();
    }

    public function insert($data) {
        return $this->db->insert('users', $data);
    }

    public function getById($id_user)
    {
        return $this->db
            ->where('id_user', $id_user)
            ->get('users')
            ->row();
    }

}