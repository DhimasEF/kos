<?php
class M_Message extends CI_Model {

    // ======================
    // GET / CREATE ROOM
    // ======================
    public function getRoom($id_user, $id_admin) {
        return $this->db
            ->where('id_user', $id_user)
            ->where('id_admin', $id_admin)
            ->get('chat_rooms')
            ->row();
    }

    public function createRoom($id_user, $id_admin) {
        $data = [
            'id_user'   => $id_user,
            'id_admin'  => $id_admin,
            'created_at'=> date('Y-m-d H:i:s')
        ];
        $this->db->insert('chat_rooms', $data);
        return $this->db->insert_id();
    }

    // ======================
    // GET CHAT
    // ======================
    public function getMessages($id_chat) {

        return $this->db
            ->order_by('sent_at', 'ASC')
            ->get_where('chat_messages', ['id_chat' => $id_chat])
            ->result();
    }

    // ======================
    // SEND MESSAGE
    // ======================
    public function sendMessage($data) {
        $this->db->insert('chat_messages', $data);
    }

    // ======================
    // MARK AS READ
    // ======================
    public function markAsRead($id_chat, $receiver_id) {
        $this->db->where('id_chat', $id_chat);
        $this->db->where('sender_id !=', $receiver_id);
        $this->db->update('chat_messages', ['is_read' => 1]);
    }

    // ======================
    // ADMIN ROOM LIST
    // ======================
    public function getRoomsAdmin($id_admin) {
        return $this->db
            ->select('
                chat_rooms.*,
                users.name,
                MAX(chat_messages.sent_at) as last_time,
                SUBSTRING_INDEX(
                    GROUP_CONCAT(chat_messages.message ORDER BY chat_messages.sent_at DESC),
                    ",",1
                ) as last_message,
                SUM(CASE 
                    WHEN chat_messages.is_read = 0 
                    AND chat_messages.sender_id != '.$id_admin.' 
                    THEN 1 ELSE 0 END
                ) as unread
            ')
            ->from('chat_rooms')
            ->join('users', 'users.id_user = chat_rooms.id_user')
            ->join('chat_messages', 'chat_messages.id_chat = chat_rooms.id_chat')
            ->where('chat_rooms.id_admin', $id_admin)
            ->group_by('chat_rooms.id_chat')
            ->order_by('last_time', 'DESC') // 🔥 WA STYLE
            ->get()
            ->result();
    }

    // ======================
    // USER ROOM
    // ======================
    public function getRoomByUser($id_user, $id_admin) {
        return $this->getRoom($id_user, $id_admin);
    }
}