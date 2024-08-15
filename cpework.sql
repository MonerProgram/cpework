-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2023 at 12:10 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cpework`
--

-- --------------------------------------------------------

--
-- Table structure for table `record`
--

CREATE TABLE `record` (
  `id` int(11) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `timestart_morning` time NOT NULL,
  `timeend_morning` time NOT NULL,
  `timestart_noon` time NOT NULL,
  `timeend_noon` time NOT NULL,
  `work` varchar(50) NOT NULL,
  `work_detail` varchar(50) NOT NULL,
  `dates` date NOT NULL,
  `Time` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `record`
--

INSERT INTO `record` (`id`, `user_id`, `timestart_morning`, `timeend_morning`, `timestart_noon`, `timeend_noon`, `work`, `work_detail`, `dates`, `Time`) VALUES
(196, 'tang', '08:30:00', '09:30:00', '10:30:00', '12:00:00', 'งานด้านเอกสาร สารบรรณ และธุรการทั่วไป', 'adsda', '2023-06-14', 2.5),
(197, 'tang', '08:00:00', '09:00:00', '11:30:00', '13:30:00', 'งานด้านเอกสาร สารบรรณ และธุรการทั่วไป', 'fssad', '2023-09-01', 3),
(198, '64202040025', '08:00:00', '09:30:00', '11:00:00', '11:00:00', 'งานด้านเอกสาร สารบรรณ และธุรการทั่วไป', 'tang', '2023-06-16', 1.5),
(199, '64202040025', '09:00:00', '11:00:00', '10:30:00', '13:30:00', 'งานด้านเอกสาร สารบรรณ และธุรการทั่วไป', 'adsda', '2023-06-01', 5),
(200, '64202040025', '08:30:00', '10:00:00', '11:30:00', '13:00:00', 'งานในห้องปฏิบัติการและทักษะเฉพาะด้าน', 'asda', '2023-06-08', 3),
(201, '64202040025', '10:30:00', '12:30:00', '15:00:00', '16:00:00', 'งานด้านการออกแบบสื่อประชาสัมพันธ์', 'dsdad', '2023-06-02', 3),
(202, '64202040025', '10:00:00', '11:30:00', '14:30:00', '15:30:00', 'งานด้านการออกแบบสื่อประชาสัมพันธ์', 'asads', '2023-06-22', 2.5),
(203, '64202040025', '08:30:00', '10:30:00', '12:00:00', '13:30:00', 'งานด้านการออกแบบสื่อประชาสัมพันธ์', 'sdad', '2023-07-12', 3.5),
(204, 'Thanaphat', '08:30:00', '10:00:00', '10:00:00', '11:00:00', 'งานด้านเอกสาร สารบรรณ และธุรการทั่วไป', 'asdsa', '2023-06-07', 2.5),
(205, '64202040025', '08:00:00', '10:00:00', '11:00:00', '13:30:00', 'งานด้านการออกแบบสื่อประชาสัมพันธ์', 'adssd', '2025-01-09', 4.5),
(206, 'tang', '08:00:00', '09:00:00', '10:30:00', '12:00:00', 'งานด้านเอกสาร สารบรรณ และธุรการทั่วไป', '', '2023-06-14', 2.5),
(207, 'tang', '09:00:00', '11:30:00', '09:30:00', '13:00:00', 'งานในห้องปฏิบัติการและทักษะเฉพาะด้าน', 'asdad', '2023-06-07', 6),
(208, 'tang', '08:30:00', '11:00:00', '12:30:00', '13:00:00', 'งานด้านเอกสาร สารบรรณ และธุรการทั่วไป', 'asdadsa', '2023-06-07', 3),
(209, 'tang', '08:30:00', '09:30:00', '13:30:00', '14:00:00', 'งานด้านการออกแบบสื่อประชาสัมพันธ์', '', '2023-06-07', 1.5),
(211, '64070501002', '10:30:00', '12:00:00', '00:00:00', '00:00:00', 'งานด้านเอกสาร สารบรรณ และธุรการทั่วไป', '', '2023-06-01', 1.5),
(212, '64070501003', '09:30:00', '12:30:00', '00:00:00', '00:00:00', 'งานด้านเอกสาร สารบรรณ และธุรการทั่วไป', '', '2023-06-01', 3),
(221, 'tang', '08:00:00', '12:00:00', '00:00:00', '00:00:00', 'เลือก...', '', '2023-06-14', 4),
(222, 'tang', '08:00:00', '13:00:00', '00:00:00', '00:00:00', 'เลือก...', '', '2023-06-08', 5);

-- --------------------------------------------------------

--
-- Table structure for table `record1`
--

CREATE TABLE `record1` (
  `id` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Student_id` varchar(50) NOT NULL,
  `Bank_name` varchar(50) NOT NULL,
  `Bank_account` varchar(50) NOT NULL,
  `Telephone` varchar(50) NOT NULL,
  `department` varchar(255) NOT NULL,
  `term` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `record1`
--

INSERT INTO `record1` (`id`, `Name`, `Student_id`, `Bank_name`, `Bank_account`, `Telephone`, `department`, `term`) VALUES
(94, 'นาย ธนัท', 'tang', 'ธนาคารกรุงศรีอยุธยา', 'sddd', '0967207771', 'สาขาวิศวกรรมคอมพิวเตอร์(หลักสูตรปกติ)', 'S'),
(95, 'นาย ธนพัฒน์ บุญรักษ์', '64202040025', 'ธนาคารกสิกรไทย', '1234', 'dsfds', 'สาขาวิศวกรรมคอมพิวเตอร์(หลักสูตรปกติ)', '2');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `user_password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `user_password`) VALUES
(15, 'admin', '9dc9d5ed5031367d42543763423c24ee'),
(24, 'tang', '39bbbb50800591c124a6e9d4cdfc0540'),
(25, '64070501002', '552a9fb21bdc94c87c0eb79c6ddd72e4'),
(26, '64070501003', '4406bd7ecd38db08f82e7a902fc1f10f');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `record`
--
ALTER TABLE `record`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `record1`
--
ALTER TABLE `record1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `record`
--
ALTER TABLE `record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=223;

--
-- AUTO_INCREMENT for table `record1`
--
ALTER TABLE `record1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
