-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2019 at 11:51 AM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dcci`
--

-- --------------------------------------------------------

--
-- Table structure for table `memberdetails`
--

CREATE TABLE `memberdetails` (
  `MemberID` int(11) NOT NULL,
  `MemberName` varchar(50) NOT NULL,
  `CompanyName` varchar(50) NOT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Address` varchar(500) DEFAULT NULL,
  `Business` varchar(50) DEFAULT NULL,
  `Message` varchar(500) DEFAULT NULL,
  `imageData` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `memberdetails`
--

INSERT INTO `memberdetails` (`MemberID`, `MemberName`, `CompanyName`, `Phone`, `Email`, `Address`, `Business`, `Message`, `imageData`) VALUES
(1, 'Mosfeck Uddin', 'BDCOM', '01720007487', 'mosfeckbd@gmail.com', 'Uttara', 'IT', 'IT business', ''),
(13, 'Babu Mahmud', 'BDCOM', '01789654123', 'babu@gmail.com', 'Zigatola', 'Communication', 'Communication business', ''),
(16, 'Suhudul Quader', 'BDCOM', '01670456978', 'foo@gmail.com', 'Sangkar', 'Network', 'Network Business', ''),
(17, 'Sojibur Rahman', 'BDCOM', '01723654789', 'sojib@gmail.com', 'Muhammadpur', 'IT', 'IT business', ''),
(18, 'Gautam Sarkar', 'BDCOM', '01723715351', 'gautam@gmail.com', 'Muhammadpur', 'IT', 'IT business', ''),
(19, 'Gautam Ac', 'BDCOM', '01715789456', 'gautamac@gmail.com', 'Hajaribag', 'Graphic', 'Graphics business', ''),
(20, 'Anisozzaman', 'BDCOM', '01915233914', 'anistalukder200@gmail.com', '85/B, south kazla nayanagar, Donia, Jatrabari', 'Graphic', 'I want to do a graphics business', ''),
(22, 'Abu Zahid', 'BDCOM', '01966633311', 'zahidabu016@gmail.com', 'Zigatola', 'Human resource', 'Human resource', ''),
(23, 'Jahid Hasan', 'Vintage', '01922814740', 'jhmpar@gmail.com', 'Sangkar', 'Network', 'Network Business', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `memberdetails`
--
ALTER TABLE `memberdetails`
  ADD PRIMARY KEY (`MemberID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `memberdetails`
--
ALTER TABLE `memberdetails`
  MODIFY `MemberID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
