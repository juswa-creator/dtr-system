-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2026 at 02:00 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dtr_system`
--
CREATE DATABASE IF NOT EXISTS `dtr_system` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `dtr_system`;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--
-- Creation: Apr 21, 2026 at 04:56 AM
--

DROP TABLE IF EXISTS `attendance`;
CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time_in` time DEFAULT NULL,
  `time_out` time DEFAULT NULL,
  `total_hours` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `user_id`, `date`, `time_in`, `time_out`, `total_hours`) VALUES
(1, 1, '2026-04-21', '07:21:29', '07:21:31', 0.000555556),
(2, 6, '2026-04-21', '11:30:17', '11:30:19', 0.000555556),
(3, 1, '2026-04-22', '03:16:26', '03:18:22', 0.0322222),
(4, 11, '2026-04-22', '04:23:12', '04:23:15', 0.000833333);

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--
-- Creation: Apr 21, 2026 at 04:56 AM
--

DROP TABLE IF EXISTS `leaves`;
CREATE TABLE `leaves` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `leave_date` date DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leaves`
--

INSERT INTO `leaves` (`id`, `user_id`, `leave_date`, `reason`, `status`) VALUES
(1, 6, '2026-04-22', 'hahha', 'rejected'),
(2, 11, '2027-11-07', 'hahaha\r\n', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
-- Creation: Apr 21, 2026 at 04:55 AM
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `role` enum('admin','employee','ojt') DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `role`, `password`) VALUES
(1, 'Adie Dela Cruz', 'adie', 'ojt', '123'),
(2, 'Marian Santos', 'marian', 'ojt', '123'),
(3, 'John Reyes', 'john', 'ojt', '123'),
(4, 'Anne Lopez', 'anne', 'ojt', '123'),
(5, 'Marky Cruz', 'marky', 'ojt', '123'),
(6, 'Liza Wong', 'liza', 'ojt', '123'),
(7, 'Pauline Garcia', 'pauline', 'ojt', '123'),
(8, 'Nina Boyet', 'nina', 'ojt', '123'),
(9, 'Carlo Ray', 'carlo', 'ojt', '123'),
(10, 'Joy Lime', 'joy', 'ojt', '123'),
(11, 'Johny Hoe', 'johny', 'employee', '123'),
(12, 'Hye Asher', 'hye', 'employee', '123'),
(13, 'Michael Tang', 'mike', 'employee', '123'),
(14, 'Josh Wang', 'joash', 'employee', '123'),
(15, 'Christine Wong', 'christine', 'employee', '123'),
(16, 'Anna Bell', 'anna', 'employee', '123'),
(17, 'David Parks', 'david', 'employee', '123'),
(18, 'Ken Yum', 'ken', 'employee', '123'),
(19, 'Grace Hong', 'grace', 'employee', '123'),
(20, 'Leon Cham', 'leo', 'employee', '123'),
(21, NULL, 'admin', 'admin', '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `leaves`
--
ALTER TABLE `leaves`
  ADD CONSTRAINT `leaves_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
