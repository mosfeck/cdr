-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 12, 2023 at 04:46 AM
-- Server version: 8.0.32-0ubuntu0.20.04.2
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `cdr`
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
(1, 'Mosfeck', 'mosfeck@bdcom.com', '', '', '', '$2y$10$hMz5pmrXZ4Aa/MK8NfS2Eu8RlKnG1ZP5twa3IXW0XvGY3o4P.HH3e', 0, '2023-04-12 04:42:09', NULL),
(2, '', 'abir@office.bdcom.com', '', '', '', '$2y$10$vZRuY7ztW3bZn8w3i1kiuew5t4QjhJYZYyOJV7Kx47PPx8Ldx0rKO', 0, '2023-04-12 04:42:09', NULL),
(3, '', 'root', '', '', '', '$2y$10$JNUoCrXUJ2YEEjrTnaXyl.2JEe.Vuio58IV01EbN4pJLqpg7QxQ.C', 0, '2023-04-12 04:42:09', NULL),
(4, '', 'nilufar@bdcom.com', '', '', '', '$2y$10$4Rq1Vt9lJU2REl9shUfk.uSM5UVKmkeseUJfO2kN4cDzGwzQ2ki1K', 0, '2023-04-12 04:42:09', NULL),
(5, '', 'tarek@bdcom.com', '', '', '', '$2y$10$SqFbmjo2OSGKEcFCw4PBe.TNmRx8ef0VH.iUDUozQxnjf0f3nKyd6', 0, '2023-04-12 04:42:09', NULL),
(6, '', 'Sami@bdcom.com', '', '', '', '$2y$10$5ijEQ1oTQtIKQHD0CHTHhuRn.adGVmD6uTc0li62VHqCKSumtMCtK', NULL, '2023-04-12 04:42:09', NULL),
(7, '', 'Jewel@bdcom.com', '', '', '', '$2y$10$y.dEIzCMM7EpHK/u2s3tL.Em.1g9ORS5fTiHhe6GsZTW08mDFJF8G', 0, '2023-04-12 04:42:09', NULL),
(8, '', 'rasel@bdcom.com', '', '', '', '$2y$10$pNMxMT.rU24wisvfk3VUdOsjeKI1xp4ihcKCAaKqIqLPzcIzqy.12', 1, '2023-04-12 04:42:09', NULL),
(9, 'Nahid', 'nahid@bdcom.com', '01732172486', '', '', '$2y$10$RRBRw60voo0sAoqgmeXOzeHSUkd3u1UJ01cPqK6hzaEuf5d2Enq7O', 1, '2023-04-12 04:42:09', NULL),
(10, 'Ridoy', 'ridoy@bdcom.com', '01597536141', '', '', '$2y$10$gJ7n9Ol8UpGDAiHZarxh7eWXo9p.7pqBanarlYgdUVSavewaij.mu', 0, '2023-04-12 04:45:30', NULL);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;
