<?php
class M_Message extends CI_Model {

    // ======================
    // GET / CREATE ROOM
    // ======================
    public function getRoom($id_user,$id_admin)
    {
        return $this->db
            ->where('id_user',$id_user)
            ->where('id_admin',$id_admin)
            ->get('chat_rooms')
            ->row();
    }

    public function getMessages($id_chat)
    {
        return $this->db
            ->order_by('sent_at','ASC')
            ->get_where('chat_messages',['id_chat'=>$id_chat])
            ->result();
    }

    public function sendMessage($data)
    {
        $this->db->insert('chat_messages',$data);
    }

    public function markAsRead($id_chat,$receiver_id)
    {
        $this->db->where('id_chat',$id_chat);
        $this->db->where('sender_id !=',$receiver_id);
        $this->db->update('chat_messages',['is_read'=>1]);
    }

    public function getRoomsAdmin($id_admin)
    {
        $id_admin = $this->db->escape($id_admin);

        return $this->db->query("
            SELECT 
                cr.id_chat,
                cr.id_user,
                cr.id_admin,
                cr.created_at,
                u.name,

                (
                    SELECT cm.message
                    FROM chat_messages cm
                    WHERE cm.id_chat = cr.id_chat
                    ORDER BY cm.sent_at DESC, cm.id_message DESC
                    LIMIT 1
                ) AS last_message,

                (
                    SELECT cm.sent_at
                    FROM chat_messages cm
                    WHERE cm.id_chat = cr.id_chat
                    ORDER BY cm.sent_at DESC, cm.id_message DESC
                    LIMIT 1
                ) AS last_time,

                (
                    SELECT COUNT(*)
                    FROM chat_messages cm
                    WHERE cm.id_chat = cr.id_chat
                    AND cm.is_read = 0
                    AND cm.sender_id != $id_admin
                ) AS unread

            FROM chat_rooms cr
            JOIN users u ON u.id_user = cr.id_user
            WHERE cr.id_admin = $id_admin

            ORDER BY 
                last_time DESC,
                cr.id_chat DESC
        ")->result();
    }

    public function createRoom($id_user, $id_admin)
    {
        // cek dulu biar tidak double room
        $cek = $this->getRoom($id_user, $id_admin);

        if ($cek) {
            return $cek->id_chat;
        }

        $data = [
            'id_user'     => $id_user,
            'id_admin'    => $id_admin,
            'created_at'  => date('Y-m-d H:i:s')
        ];

        $this->db->insert('chat_rooms', $data);

        return $this->db->insert_id();
    }

    public function getRoomByUser($id_user, $id_admin) {
        return $this->getRoom($id_user, $id_admin);
    }
}