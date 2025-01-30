-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 30, 2025 at 10:15 AM
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
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `registered_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` text,
  `date` datetime DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `max_capacity` int DEFAULT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `created_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `slug`, `description`, `date`, `location`, `max_capacity`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(12, 'Jemima Holland', 'jemima-holland', 'Dolore eius numquam', '2025-01-07 00:00:00', 'Est voluptate asperi', 5, '1', 20, '2025-01-30 08:50:10', '2025-01-30 08:50:10'),
(13, 'Ruby Lancaster', 'ruby-lancaster', 'Asperiores aut dolor', '2025-01-14 00:00:00', 'Deserunt velit sed', 14, '1', 20, '2025-01-30 08:50:20', '2025-01-30 08:50:20'),
(14, 'Ferdinand Brady', 'ferdinand-brady', 'In voluptas consequa', '2025-01-03 00:00:00', 'Est dicta quod ex vo', 31, '1', 20, '2025-01-30 08:52:52', '2025-01-30 08:52:52'),
(15, 'Azalia Grimes', 'azalia-grimes', 'Omnis veniam volupt', '2024-12-31 00:00:00', 'Adipisicing et ea ma', 48, '1', 20, '2025-01-30 08:52:57', '2025-01-30 08:52:57'),
(16, 'Samantha Collier', 'samantha-collier', 'Id et aut blanditiis', '2024-12-17 00:00:00', 'Ut est vel ut tempor', 2, '1', 20, '2025-01-30 08:53:03', '2025-01-30 08:53:03'),
(17, 'Whitney Durham', 'whitney-durham', 'Mollitia sed ut recu', '2024-12-25 00:00:00', 'Nostrud et velit iru', 1, '1', 20, '2025-01-30 08:53:08', '2025-01-30 08:53:08');

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
(18, 'Blaze Rogers', 'redadarume@mailinator.com', '$2y$10$JXgB8IjLeSgr0i10C8wM/.NQ5Img/mG1wubKT/xamoEpHI.3anIqm', '2025-01-30 04:51:01', '2025-01-30 04:51:01'),
(19, 'Dexter Duncan', 'rakecaj@mailinator.com', '$2y$10$CwSZ5m8Vs7RAABYMYAVVIeOE4O.sEhjqwmVvVDrzTtrYozXO8eJTa', '2025-01-30 04:51:21', '2025-01-30 04:51:21'),
(20, 'Channing Holt', 'niboky@mailinator.com', '$2y$10$6nJWoPEcioDaVY3GwKiCAeX9r0F065cGVAZqn3gZqU6RxMppVmZdK', '2025-01-30 07:57:17', '2025-01-30 07:57:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendees`
--
ALTER TABLE `attendees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD KEY `event_id_idx` (`event_id`);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendees`
--
ALTER TABLE `attendees`
  ADD CONSTRAINT `fk_attendees_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
