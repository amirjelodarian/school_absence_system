-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 17, 2021 at 09:32 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ahrar_school`
--

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(9) NOT NULL,
  `first_name` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `student_tell` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `father_name` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `mother_name` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `father_tell` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `mother_tell` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `home_tell` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `address` text COLLATE utf8_persian_ci DEFAULT NULL,
  `group_name` text COLLATE utf8_persian_ci NOT NULL,
  `absence` int(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `first_name`, `last_name`, `student_tell`, `father_name`, `mother_name`, `father_tell`, `mother_tell`, `home_tell`, `address`, `group_name`, `absence`) VALUES
(1, 'امیر', 'جلوداریان', '09378691469', '', '', '09378691469', '', '55826455', 'نعمت آباد', '12 کامپیوتر B', 7),
(7, 'مراد', 'کریمی', '', '', '', '', '', '', '', '12 کامپیوتر B', 0),
(8, 'شروین', 'کرمی', '', '', '', '', '', '', '', '12 کامپیوتر B', 0),
(9, 'سلیم', 'امیری', '', '', '', '', '', '', '', '12 کامپیوتر B', 0),
(10, 'علی', 'رضوی', '', '', '', '', '', '', '', '12 کامپیوتر B', 0),
(11, 'امیر', 'سلیمانی', '', '', '', '', '', '', '', '12 کامپیوتر B', 0),
(12, 'اکبر', 'اکبری', '', '', '', '', '', '', '', '12 کامپیوتر B', 0),
(13, 'ممد', 'سلیمی', '', '', '', '', '', '', '', '12 کامپیوتر B', 0),
(14, 'سپهر', 'ملایی', '', '', '', '', '', '', '', '12 کامپیوتر B', 0),
(15, 'مجید', 'مجیدی', '', '', '', '', '', '', '', '12 کامپیوتر B', 0),
(16, 'کرم', 'کریمی', '', '', '', '', '', '', '', '12 کامپیوتر B', 0),
(17, 'سلیم', 'سلیمی', '', '', '', '', '', '', '', '12 کامپیوتر B', 0),
(18, 'سعید', 'سعیدی', '', '', '', '', '', '', '', '12 کامپیوتر B', 0),
(19, 'کریم', 'اکبری', '', '', '', '', '', '', '', '12 کامپیوتر B', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
