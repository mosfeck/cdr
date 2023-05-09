-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 09, 2023 at 09:08 AM
-- Server version: 8.0.33-0ubuntu0.20.04.1
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
(1, 'Mosfeck Uddin', 'mosfeck@bdcom.com', '017200047487', 'Software Engineer', 'Software', '$2y$10$cwimwWzS86JAN7CqGjYpb.gR8JdAEexjXarHEMU76sBgRkmDMm4DO', 1, '2023-05-09 08:55:48', NULL),
(2, 'Jahid', 'Jahid@bdcom.com', '01597536141', 'Senior Executive', 'iptsp and Software', '$2y$10$0YUtJ0Xzojc62W77WSa5jeqpDMvx2U9SkhYRnonpsOZ5SELBz3yba', 0, '2023-04-13 08:38:39', '2023-05-09 08:57:12'),
(14, 'Jewel Talukdar', 'jewel@bdcom.com', '01597536158', 'Manager', 'Software', '$2y$10$yPjgBYp85AtUG7Fb30H2Eug6iRtG8dr.vo.O8A1Ex4XrcMliDc3BO', 1, '2023-04-13 08:52:59', '2023-05-08 13:02:50'),
(15, 'Akram Khan', 'akram@bdcom.com', '01732172486', 'Manager', 'iptsp and Software', '$2y$10$4Usbahro0C9z69h5X5RqwuIEB97Dm0y0m76.OxcXMUv4cEOFIJ3li', 1, '2023-04-26 06:09:18', '2023-04-26 07:05:17'),
(17, 'Mozammel', 'mozammel@bdcom.com', '01597536141', 'Senior Developer', 'Software', '$2y$10$z3uSD.Nz2JpSt8UtBWG4aulQt73F3qivQ0z2B6moy1DuNVPl4ne0.', 1, '2023-05-08 06:41:13', '2023-05-08 06:41:48');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
