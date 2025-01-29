-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 29, 2025 at 04:23 PM
-- Server version: 8.0.40-0ubuntu0.24.04.1
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `events_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendees`
--

CREATE TABLE `attendees` (
  `id` int NOT NULL,
  `event_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `registered_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `date` datetime DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `max_capacity` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(5, 'sagor', 'sagor@gmail.com', '$2y$10$oyE3qh.G42bOMMXseCvQsexWkWX18INxLLtvKoPLr8vf5KjFi9RWa', '2025-01-29 09:26:28', '2025-01-29 09:26:28'),
(6, 'Ezra Nash', 'bipade@mailinator.com', '$2y$10$6kgqluJuVLHIVNSGfzz5vOjW0xZkEhIjggJbz.kGuTEdZwxHd38ci', '2025-01-29 15:28:47', '2025-01-29 15:28:47'),
(7, 'Madeline Bates', 'vytameryx@mailinator.com', '$2y$10$5G5qURi9PCSHUaI1euVUMugbfUIe.MGeR/ORMOen1SfQYIlWA2A5u', '2025-01-29 15:32:26', '2025-01-29 15:32:26'),
(8, 'Pascale Walls', 'reqir@mailinator.com', '$2y$10$jYUDHTrpNlewr9nul9isMubx4j01zvKqH9LQwfNZovHUXsvRx1SY6', '2025-01-29 15:34:47', '2025-01-29 15:34:47'),
(9, 'Quinn Diaz', 'pohytaqem@mailinator.com', '$2y$10$ZvBUlEs21AJZg8Z9kLDmguudcm8M01eBZ2kN14aNJXHEEVp.kN6TO', '2025-01-29 15:39:35', '2025-01-29 15:39:35'),
(10, 'Kibo Munoz', 'favuwuc@mailinator.com', '$2y$10$TscKFf73wonkDzHcZcEOS.79qiFLGCjMLb42vTVP/8BjZnJaEJ9lK', '2025-01-29 15:40:50', '2025-01-29 15:40:50'),
(11, 'Iliana Gilliam', 'kehydaza@mailinator.com', '$2y$10$kYaxfU.PMwMNcf1W/i5GeeSueBoAJfmTNEGZ.1VU2ALUUMPqWgOZy', '2025-01-29 15:45:31', '2025-01-29 15:45:31'),
(12, 'Michael Bell', 'xiqu@mailinator.com', '$2y$10$uA.1P6pXtLaGcP0s/OVMTevQWozVzavSR/Shwn.nUQOnwzZ3am5uS', '2025-01-29 15:45:59', '2025-01-29 15:45:59'),
(13, 'Lucy Dunn', 'futox@mailinator.com', '$2y$10$FWVtFrkGBwGMH5kOjD5hiufgA79NsjbAV4aYjBihF2w/qhPGwgsbK', '2025-01-29 15:48:58', '2025-01-29 15:48:58'),
(14, 'Clare Osborn', 'coqitobu@mailinator.com', '$2y$10$UYRvwwPdNq5veLYIdL2DKOOZ.Y7I2gajeodUY09UrGQnohkbJzyqC', '2025-01-29 15:55:35', '2025-01-29 15:55:35'),
(15, 'Constance Hinton', 'nacoqum@mailinator.com', '$2y$10$268UDDvTXgCPorEFoLVq6uLTQCrb2A.yV.UZ4cKyX7zaIG9wKYxF2', '2025-01-29 15:56:37', '2025-01-29 15:56:37'),
(16, 'Quentin Oneil', 'sulisiqi@mailinator.com', '$2y$10$uXGdO75Ytht8l3iqNJdLd.Oe2t6utPVuNacABfZkbM3dtnlS71pwG', '2025-01-29 16:04:27', '2025-01-29 16:04:27'),
(17, 'Finn Thornton', 'jysexiqyfe@mailinator.com', '$2y$10$1alaH8/RmRwmIv.BRxfI4euBbPU/lLbX9zIkerwc4ThZyiZQjM7NS', '2025-01-29 16:21:24', '2025-01-29 16:21:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendees`
--
ALTER TABLE `attendees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendees`
--
ALTER TABLE `attendees`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendees`
--
ALTER TABLE `attendees`
  ADD CONSTRAINT `attendees_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendees_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
