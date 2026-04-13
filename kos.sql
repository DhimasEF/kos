-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.2.44-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.16.0.7229
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for kos
CREATE DATABASE IF NOT EXISTS `kos` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `kos`;

-- Dumping structure for table kos.bookings
CREATE TABLE IF NOT EXISTS `bookings` (
  `id_booking` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_room` int(11) DEFAULT NULL,
  `check_in` date DEFAULT NULL,
  `check_out` date DEFAULT NULL,
  `total_price` decimal(12,2) DEFAULT NULL,
  `status` enum('pending','confirmed','cancelled','completed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_booking`),
  KEY `id_user` (`id_user`),
  KEY `id_room` (`id_room`),
  CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`id_room`) REFERENCES `rooms` (`id_room`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table kos.bookings: ~0 rows (approximately)

-- Dumping structure for table kos.chat_messages
CREATE TABLE IF NOT EXISTS `chat_messages` (
  `id_message` int(11) NOT NULL AUTO_INCREMENT,
  `id_chat` int(11) DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_message`),
  KEY `id_chat` (`id_chat`),
  KEY `sender_id` (`sender_id`),
  CONSTRAINT `chat_messages_ibfk_1` FOREIGN KEY (`id_chat`) REFERENCES `chat_rooms` (`id_chat`),
  CONSTRAINT `chat_messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table kos.chat_messages: ~0 rows (approximately)

-- Dumping structure for table kos.chat_rooms
CREATE TABLE IF NOT EXISTS `chat_rooms` (
  `id_chat` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_chat`),
  KEY `id_user` (`id_user`),
  KEY `id_admin` (`id_admin`),
  CONSTRAINT `chat_rooms_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  CONSTRAINT `chat_rooms_ibfk_2` FOREIGN KEY (`id_admin`) REFERENCES `users` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table kos.chat_rooms: ~0 rows (approximately)

-- Dumping structure for table kos.kos
CREATE TABLE IF NOT EXISTS `kos` (
  `id_kos` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_kos`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `kos_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table kos.kos: ~0 rows (approximately)
INSERT INTO `kos` (`id_kos`, `name`, `address`, `description`, `created_by`, `created_at`) VALUES
	(1, 'Kos Wisma Sugiyo', 'Jl. Kelud Sel. No.27, Kos Wisma Sugiyo, Kadipiro,Banjarsari,Surakarta', '.....', 1, '2026-04-11 14:23:04');

-- Dumping structure for table kos.payments
CREATE TABLE IF NOT EXISTS `payments` (
  `id_payment` int(11) NOT NULL AUTO_INCREMENT,
  `id_booking` int(11) DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_status` enum('unpaid','paid','failed') DEFAULT 'unpaid',
  `payment_date` timestamp NULL DEFAULT NULL,
  `proof_of_payment` text DEFAULT NULL,
  PRIMARY KEY (`id_payment`),
  KEY `id_booking` (`id_booking`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`id_booking`) REFERENCES `bookings` (`id_booking`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table kos.payments: ~0 rows (approximately)

-- Dumping structure for table kos.reviews
CREATE TABLE IF NOT EXISTS `reviews` (
  `id_review` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_kos` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `review` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_review`),
  KEY `id_user` (`id_user`),
  KEY `id_kos` (`id_kos`),
  CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`id_kos`) REFERENCES `kos` (`id_kos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table kos.reviews: ~0 rows (approximately)

-- Dumping structure for table kos.room_images
CREATE TABLE IF NOT EXISTS `room_images` (
  `id_image` int(11) NOT NULL AUTO_INCREMENT,
  `id_room` int(11) DEFAULT NULL,
  `image_url` text DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_image`),
  KEY `id_room` (`id_room`),
  CONSTRAINT `room_images_ibfk_1` FOREIGN KEY (`id_room`) REFERENCES `rooms` (`id_room`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table kos.room_images: ~0 rows (approximately)

-- Dumping structure for table kos.rooms
CREATE TABLE IF NOT EXISTS `rooms` (
  `id_room` int(11) NOT NULL AUTO_INCREMENT,
  `id_kos` int(11) DEFAULT NULL,
  `room_number` varchar(50) DEFAULT NULL,
  `price` decimal(12,2) DEFAULT NULL,
  `status` enum('available','booked','maintenance') DEFAULT 'available',
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_room`),
  KEY `id_kos` (`id_kos`),
  CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`id_kos`) REFERENCES `kos` (`id_kos`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table kos.rooms: ~0 rows (approximately)
INSERT INTO `rooms` (`id_room`, `id_kos`, `room_number`, `price`, `status`, `description`, `created_at`) VALUES
	(1, 1, '3', 350000.00, 'available', '.........', '2026-04-11 14:24:03');

-- Dumping structure for table kos.users
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table kos.users: ~2 rows (approximately)
INSERT INTO `users` (`id_user`, `name`, `email`, `password`, `role`, `created_at`) VALUES
	(1, 'Admin', 'admin@example.com', '$2y$10$0I5oMdAWkobatoE2jQ5j3ORIP.zmEbiiafW10F8he34oJr.pSo0K6', 'admin', '2026-04-11 14:06:13'),
	(2, 'Riki', 'riki@example.com', '$2y$10$0I5oMdAWkobatoE2jQ5j3ORIP.zmEbiiafW10F8he34oJr.pSo0K6', 'user', '2026-04-11 14:06:51');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
