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
  `start_at` date DEFAULT NULL,
  `status` enum('pending','approved','rejected','cancelled','completed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_booking`),
  KEY `id_user` (`id_user`),
  KEY `id_room` (`id_room`),
  CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`id_room`) REFERENCES `rooms` (`id_room`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table kos.bookings: ~0 rows (approximately)
INSERT INTO `bookings` (`id_booking`, `id_user`, `id_room`, `start_at`, `status`, `created_at`) VALUES
	(1, 2, 1, '2026-05-01', 'approved', '2026-04-14 21:23:51');

-- Dumping structure for table kos.chat_messages
CREATE TABLE IF NOT EXISTS `chat_messages` (
  `id_message` int(11) NOT NULL AUTO_INCREMENT,
  `id_chat` int(11) DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` int(11) DEFAULT 0,
  PRIMARY KEY (`id_message`),
  KEY `id_chat` (`id_chat`),
  KEY `sender_id` (`sender_id`),
  CONSTRAINT `chat_messages_ibfk_1` FOREIGN KEY (`id_chat`) REFERENCES `chat_rooms` (`id_chat`),
  CONSTRAINT `chat_messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Dumping data for table kos.chat_messages: ~5 rows (approximately)
INSERT INTO `chat_messages` (`id_message`, `id_chat`, `sender_id`, `message`, `sent_at`, `is_read`) VALUES
	(1, 1, 2, 'test', '2026-04-19 22:58:07', 1),
	(2, 1, 2, 'tes', '2026-04-19 22:58:58', 1),
	(3, 1, 2, 'te', '2026-04-19 22:59:00', 1),
	(4, 1, 2, 't', '2026-04-19 22:59:03', 1),
	(5, 1, 1, 'ysa', '2026-04-21 07:04:38', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table kos.chat_rooms: ~0 rows (approximately)
INSERT INTO `chat_rooms` (`id_chat`, `id_user`, `id_admin`, `created_at`) VALUES
	(1, 2, 1, '2026-04-19 22:58:07');

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
  `payment_status` enum('paid','verified','rejected') DEFAULT 'paid',
  `payment_date` timestamp NULL DEFAULT NULL,
  `proof_of_payment` text DEFAULT NULL,
  PRIMARY KEY (`id_payment`),
  KEY `id_booking` (`id_booking`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`id_booking`) REFERENCES `bookings` (`id_booking`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table kos.payments: ~0 rows (approximately)
INSERT INTO `payments` (`id_payment`, `id_booking`, `amount`, `payment_method`, `payment_status`, `payment_date`, `proof_of_payment`) VALUES
	(1, 1, 350000.00, 'transfer', 'verified', '2026-04-15 02:48:45', 'payment_1776246525.jpg');

-- Dumping structure for table kos.reviews
CREATE TABLE IF NOT EXISTS `reviews` (
  `id_review` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_room` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `review` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_booking` int(11) NOT NULL,
  PRIMARY KEY (`id_review`),
  KEY `id_user` (`id_user`),
  KEY `FK_reviews_rooms` (`id_room`) USING BTREE,
  KEY `FK__bookrev` (`id_booking`),
  CONSTRAINT `FK__bookrev` FOREIGN KEY (`id_booking`) REFERENCES `bookings` (`id_booking`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_reviews_rooms` FOREIGN KEY (`id_room`) REFERENCES `rooms` (`id_room`),
  CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table kos.reviews: ~0 rows (approximately)
INSERT INTO `reviews` (`id_review`, `id_user`, `id_room`, `rating`, `review`, `created_at`, `id_booking`) VALUES
	(1, 2, 1, 5, 'sadasdsadsad', '2026-04-29 01:18:27', 1);

-- Dumping structure for table kos.room_images
CREATE TABLE IF NOT EXISTS `room_images` (
  `id_image` int(11) NOT NULL AUTO_INCREMENT,
  `id_room` int(11) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_image`),
  KEY `id_room` (`id_room`),
  CONSTRAINT `room_images_ibfk_1` FOREIGN KEY (`id_room`) REFERENCES `rooms` (`id_room`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table kos.room_images: ~3 rows (approximately)
INSERT INTO `room_images` (`id_image`, `id_room`, `image`, `uploaded_at`) VALUES
	(1, 4, '49e95b968d5a4046f40b93a74e5c5639.png', '2026-04-23 05:27:47'),
	(2, 1, '6a281af2feaccdc274acd39b40799225.png', '2026-04-23 05:27:47'),
	(3, 4, '3da716dc536ec3c87e5b4b613d3db9cf.jpg', '2026-04-23 06:34:37');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumping data for table kos.rooms: ~3 rows (approximately)
INSERT INTO `rooms` (`id_room`, `id_kos`, `room_number`, `price`, `status`, `description`, `created_at`) VALUES
	(1, 1, '3', 350000.00, 'available', '.........', '2026-04-11 14:24:03'),
	(4, NULL, '4', 350000.00, 'available', NULL, '2026-04-23 05:27:47');

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
