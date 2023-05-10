-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 10, 2023 at 09:22 AM
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
(1, 'Administrator', 'software@bdcom.com', '017200047487', 'Software Team', 'Software', '$2y$10$cwimwWzS86JAN7CqGjYpb.gR8JdAEexjXarHEMU76sBgRkmDMm4DO', 1, '2023-05-09 08:55:48', '2023-05-10 04:40:30'),
(2, 'Premier Bank Administrator', 'jahid@bdcom.com', '01597536141', 'Senior Executive', 'IT', '$2y$10$0YUtJ0Xzojc62W77WSa5jeqpDMvx2U9SkhYRnonpsOZ5SELBz3yba', 1, '2023-04-13 08:38:39', '2023-05-10 04:10:36'),
(20, 'Akram Khan', 'akram@bdcom.com', '01732172486', 'Senior Executive', 'iptsp and Software', '$2y$10$87dVFXacLHUdkujlvXLeE.4W60phtW1Exnd5US1p89j3RMxoXtjT2', 1, '2023-05-10 04:12:13', NULL),
(21, 'Asraf', 'asraf@bdcom.com', '01597536141', 'Senior Executive', 'Software', '$2y$10$gi6CsJ3P0EvD1ZhDxMGAZuo/eD2rosE6YOpGWU6wg3IYqw/V8skGa', 0, '2023-05-10 04:20:27', NULL),
(22, 'Ali Raj', 'ali@bdcom.com', '01597536141', '', '', '$2y$10$Lxq6TNU7EbYp4Yfr1Jblq.JRka3NWMocmHao3UEHmmeoXdjiwXMc2', 1, '2023-05-10 04:38:46', NULL),
(23, 'Nahid Reaz', 'nahid@bdcom.com', '01597536125', 'Software Developer', 'Software', '$2y$10$VWXuPSkaxDm7uCaZ.V5UsenuIVdml18V9TBuhqvgp3wVChiNnsCa.', 1, '2023-05-10 04:54:38', '2023-05-10 08:48:08'),
(24, 'Jewel Talukdar', 'talukdar@bdcom.com', '01597536158', 'Software Engineer', 'IT', '$2y$10$KJ0XcaFJK4gRUXw3XUuWKOmH/kVTTy3ho/nPsxZ7eiKjxlGIeixN6', 1, '2023-05-10 05:56:51', '2023-05-10 08:51:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_manage`
--
ALTER TABLE `user_manage`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_manage`
--
ALTER TABLE `user_manage`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
