-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 11, 2023 at 12:54 PM
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
(2, 'Premier Bank Administrator', 'admin@premierbankltd.com', '01911000000', 'Manager', 'IT', '$2y$10$CKC0onmQ85mcV5XLEpq9tuwlVFKhQULzUilriGK/UshjGhcxjLikm', 1, '2023-04-13 08:38:39', '2023-05-11 12:22:44'),
(3, 'Md. Mashuqur Rahman', 'mashuq@premierbankltd.com', '01711000000', 'Software Developer', 'Software', '$2y$10$IskrBrXQiVxfm71sNtL2auFRjjyL7kcWn9lqoa9nUEkRXPLJSr/gy', 1, '2023-05-10 04:54:38', '2023-05-11 12:54:09'),
(4, 'Shamim Ahmed', 'shamim@premierbankltd.com', '01511000000', 'Senior Executive', 'IT', '$2y$10$UEJmT4XYJsyW4bh6w7VQt.VzXC.m2/3volc4dGQLjIsYKtAc/IbmO', 1, '2023-05-10 05:56:51', '2023-05-11 12:53:53');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
