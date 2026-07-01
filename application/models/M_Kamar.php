<?php
class M_Kamar extends CI_Model {

    public function getAll()
    {
        return $this->db
            ->select('
                rooms.*,

                /* ambil 1 gambar utama */
                (
                    SELECT ri.image
                    FROM room_images ri
                    WHERE ri.id_room = rooms.id_room
                    ORDER BY ri.id_image ASC
                    LIMIT 1
                ) as image,

                /* jumlah review */
                (   
                    SELECT COUNT(rv.id_review)
                    FROM reviews rv
                    WHERE rv.id_room = rooms.id_room
                ) as total_review,

                /* rata-rata rating */
                (
                    SELECT IFNULL(AVG(rv.rating),0)
                    FROM reviews rv
                    WHERE rv.id_room = rooms.id_room
                ) as avg_rating
            ')
            ->from('rooms')
            ->order_by('rooms.id_room', 'DESC')
            ->get()
            ->result();
    }

    public function getById($id)
    {
        $room = $this->db
            ->select('
                rooms.*,

                (
                    SELECT COUNT(rv.id_review)
                    FROM reviews rv
                    WHERE rv.id_room = rooms.id_room
                ) as total_review,

                (
                    SELECT IFNULL(AVG(rv.rating), 0)
                    FROM reviews rv
                    WHERE rv.id_room = rooms.id_room
                ) as avg_rating
            ')
            ->from('rooms')
            ->where('rooms.id_room', $id)
            ->get()
            ->row();

        if ($room) {
            $room->images = $this->db
                ->where('id_room', $id)
                ->get('room_images')
                ->result();

            $room->reviews = $this->db
                ->select('reviews.*, users.name')
                ->from('reviews')
                ->join('users', 'users.id_user = reviews.id_user', 'left')
                ->where('reviews.id_room', $id)
                ->order_by('reviews.id_review', 'DESC')
                ->get()
                ->result();
        }

        return $room;
    }

    public function getActiveBookingByRoom($id_room)
    {
        $today = date('Y-m-d');

        return $this->db
            ->select('bookings.*, users.name as penyewa_name')
            ->from('bookings')
            ->join('users', 'users.id_user = bookings.id_user', 'left')
            ->where('bookings.id_room', $id_room)
            ->where('bookings.status', 'completed')
            ->where('bookings.end_at >=', $today)
            ->order_by('bookings.end_at', 'DESC')
            ->get()
            ->row();
    }
}