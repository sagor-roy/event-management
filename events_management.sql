-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 31, 2025 at 12:50 PM
-- Server version: 8.0.41-0ubuntu0.24.04.1
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

--
-- Dumping data for table `attendees`
--

INSERT INTO `attendees` (`id`, `event_id`, `name`, `email`, `phone`, `registered_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'sagor', 'sagossdfer@gmail.com', '01785400454', '2025-01-31 11:42:43', '2025-01-31 11:42:43', '2025-01-31 11:42:43'),
(2, 2, 'sagor', 'sagossdfer@gmail.com', '01785400454', '2025-01-31 11:42:58', '2025-01-31 11:42:58', '2025-01-31 11:42:58'),
(3, 2, 'sagor', 'sagossdfer@gmail.com', '01785400450', '2025-01-31 11:49:05', '2025-01-31 11:49:05', '2025-01-31 11:49:05'),
(4, 2, 'saf', 'sagossdfe@gmail.com', '01785400459', '2025-01-31 12:10:09', '2025-01-31 12:10:09', '2025-01-31 12:10:09');

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
(1, 'TechCrunch Disrupt', 'techcrunch-disrupt', 'A leading startup and technology conference featuring emerging tech innovations, startup pitches, and discussions with industry experts.', '2025-01-30 00:00:00', 'San Francisco, USA', 100, '1', 30, '2025-01-31 07:48:49', '2025-01-31 07:48:49'),
(2, 'Google I/O', 'google-i-o', 'Google’s annual developer conference focusing on AI, Android, and cloud computing, with hands-on workshops and major product announcements.', '2025-02-15 00:00:00', 'Mountain View, California, USA (Shoreline Amphitheatre)', 50, '1', 30, '2025-01-31 07:49:24', '2025-01-31 07:49:24'),
(3, 'Apple WWDC (Worldwide Developers Conference)', 'apple-wwdc-worldwide-developers-conference', 'Apple\'s annual event for developers, introducing new software updates for iOS, macOS, and other Apple platforms.', '2025-02-15 00:00:00', 'Cupertino, California, USA (Apple Park & Online)', 100, '1', 30, '2025-01-31 07:49:54', '2025-01-31 07:49:54'),
(4, 'Microsoft Build', 'microsoft-build', 'A developer-focused event where Microsoft unveils advancements in AI, Azure, and Windows technologies.', '2025-02-15 00:00:00', 'Seattle, Washington, USA', 50, '1', 30, '2025-01-31 07:50:23', '2025-01-31 07:50:23'),
(5, 'AWS re:Invent', 'aws-re-invent', 'Amazon Web Services’ global cloud computing conference featuring workshops, certifications, and deep dives into AWS services.', '2025-02-15 00:00:00', 'Las Vegas, Nevada, USA', 100, '1', 30, '2025-01-31 07:50:49', '2025-01-31 07:50:49'),
(6, 'CES (Consumer Electronics Show)', 'ces-consumer-electronics-show', 'One of the largest consumer technology expos showcasing innovations in AI, IoT, smart devices, and next-gen electronics.', '2025-02-15 00:00:00', 'Las Vegas, Nevada, USA', 200, '1', 30, '2025-01-31 07:51:16', '2025-01-31 07:51:16'),
(7, 'DEF CON', 'def-con', 'A renowned cybersecurity and hacking conference where ethical hackers, security experts, and government officials explore cyber threats and security trends.', '2025-02-10 00:00:00', 'Las Vegas, Nevada, USA', 150, '1', 30, '2025-01-31 07:51:44', '2025-01-31 07:51:44'),
(8, 'Web Summit', 'web-summit', 'One of the biggest global tech conferences, covering AI, blockchain, startups, and digital transformation with top industry leaders.', '2025-02-20 00:00:00', 'Lisbon, Portugal', 50, '1', 30, '2025-01-31 07:52:17', '2025-01-31 07:52:17'),
(9, 'GITEX Global', 'gitex-global', 'A major technology exhibition showcasing advancements in AI, cloud computing, cybersecurity, and emerging tech solutions.', '2025-02-25 00:00:00', 'Dubai, UAE', 200, '1', 30, '2025-01-31 07:52:42', '2025-01-31 07:52:42'),
(10, 'DjangoCon', 'djangocon', 'A conference dedicated to Django developers, featuring workshops, talks, and networking opportunities for web developers and open-source contributors.', '2025-02-01 23:00:00', 'Varies (Held in different cities worldwide)', 100, '1', 30, '2025-01-31 07:53:23', '2025-01-31 07:53:23');

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
(30, 'Admin', 'admin@gmail.com', '$2y$10$tXY9Sqj42GFgjoPBxEA3YuDVcKLG37pHqId0i/60n6p9VSYnqSY.e', '2025-01-31 06:58:56', '2025-01-31 06:58:56'),
(31, 'Kamal Meadows', 'bydige@mailinator.com', '$2y$10$nTRQkPga5Gax9vjI.bREMeJeMAj3ymS23aiJh8X6.lcQcxzWvDTyK', '2025-01-31 09:23:33', '2025-01-31 09:23:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendees`
--
ALTER TABLE `attendees`
  ADD PRIMARY KEY (`id`),
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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

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
