<?php
class M_User extends CI_Model {

    public function getByEmail($email) {
        return $this->db->get_where('users', ['email' => $email])->row();
    }
}