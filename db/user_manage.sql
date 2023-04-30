-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 27, 2023 at 12:57 PM
-- Server version: 8.0.32-0ubuntu0.20.04.2
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kothacdr`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_manage`
--

CREATE TABLE `user_manage` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `designation` varchar(50) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` tinyint DEFAULT '0',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_on` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_manage`
--

INSERT INTO `user_manage` (`id`, `name`, `email`, `phone`, `designation`, `department`, `password`, `status`, `created_on`, `updated_on`) VALUES
(11, 'Ravi', 'ravi@bdcom.com', '01597536141', 'Manager', 'iptsp and Software', '$2y$10$Sr5zLGTZ3gZDj34E8Y82s.8CXJklolEx9tvSH9YQ0.rAcLrlzCt7W', 1, '2023-04-12 08:09:24', '2023-04-26 08:51:42'),
(12, 'Jahid', 'Jahid@bdcom.com', '01597536141', 'Senior Executive', 'iptsp and Software', '$2y$10$0YUtJ0Xzojc62W77WSa5jeqpDMvx2U9SkhYRnonpsOZ5SELBz3yba', 0, '2023-04-13 08:38:39', '2023-04-26 07:06:05'),
(14, 'Jewel Talukdar', 'jewel@bdcom.com', '01597536158', 'Manager', 'Software', '$2y$10$r24c395ZSMMBecaExz58EOyaBelDhEYJit/JUCPlNeN6lUkdM5BFC', 1, '2023-04-13 08:52:59', '2023-04-18 06:12:00'),
(15, 'Akram Khan', 'akram@bdcom.com', '01732172486', 'Manager', 'iptsp and Software', '$2y$10$4Usbahro0C9z69h5X5RqwuIEB97Dm0y0m76.OxcXMUv4cEOFIJ3li', 1, '2023-04-26 06:09:18', '2023-04-26 07:05:17'),
(16, 'Ali Raj', 'ali@bdcom.com', '01597536141', 'Manager', 'iptsp and Software', '$2y$10$6M7YhD/7GoMncPMP3mz2iOkPtkRVv1W/V/vALmS7Fj4ga1KhRKKjS', 1, '2023-04-26 06:56:15', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_manage`
--
ALTER TABLE `user_manage`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_manage`
--
ALTER TABLE `user_manage`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
