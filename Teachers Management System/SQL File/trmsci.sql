-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2021 at 06:50 PM
-- Server version: 10.3.15-MariaDB
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trmsci`
--

-- --------------------------------------------------------

--
-- Table structure for table `mstsubject`
--

CREATE TABLE `mstsubject` (
  `id` int(11) NOT NULL,
  `subjectname` varchar(45) DEFAULT NULL,
  `postingDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mstsubject`
--

INSERT INTO `mstsubject` (`id`, `subjectname`, `postingDate`) VALUES
(1, 'English', '2021-12-06 19:21:14'),
(2, 'Hindi', '2021-12-06 19:21:14'),
(3, 'Math', '2021-12-06 19:21:14'),
(4, 'Computer', '2021-12-06 19:21:14'),
(5, 'Urdu', '2021-12-06 19:21:14'),
(6, 'PHP', '2021-12-06 19:21:14'),
(7, 'HTML', '2021-12-06 19:21:14');

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `contact` varchar(45) DEFAULT NULL,
  `create_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`id`, `name`, `email`, `password`, `contact`, `create_date`) VALUES
(1, 'admin', 'admin@gmail.com', 'Test@123', '99999999999999', '2021-11-15 11:38:33');

-- --------------------------------------------------------

--
-- Table structure for table `tblregistration`
--

CREATE TABLE `tblregistration` (
  `id` int(11) NOT NULL,
  `firstName` varchar(200) DEFAULT NULL,
  `lastName` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `contactno` varchar(45) DEFAULT NULL,
  `state` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `subject` varchar(45) DEFAULT NULL,
  `profilephoto` varchar(200) DEFAULT NULL,
  `qualification` varchar(45) DEFAULT NULL,
  `Joiningdate` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `create_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblregistration`
--

INSERT INTO `tblregistration` (`id`, `firstName`, `lastName`, `email`, `contactno`, `state`, `city`, `address`, `subject`, `profilephoto`, `qualification`, `Joiningdate`, `password`, `create_date`) VALUES
(1, 'shiv1bvbdsdsd', 'Gupta', 'shiv@gmail.com', '9898967856', 'u.p', 'Ayodhiya', 'new Delhi', '2', '20211117091150-962011.png', 'B.Tech', '2021-11-17', 'Test@123', '2021-11-17 06:42:24'),
(2, 'anuj', 'kumar', 'anuj@gmail.com', '9834534854', 'Delhi', 'New  Delhi', 'NA', '2', '20211206211239-179159.png', 'B.tech', '2021-11-17', 'Anuj@123', '2021-11-17 06:45:42'),
(3, 'Rahul', 'Kumar', 'amit@gmail.com', '1235697400', 'Delhi', 'New Delhi', 'ABC Streert XYZ', '6', '20211208171235-53632.png', 'MCA', '2021-12-01', 'Test@123', '2021-12-08 16:57:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mstsubject`
--
ALTER TABLE `mstsubject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblregistration`
--
ALTER TABLE `tblregistration`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mstsubject`
--
ALTER TABLE `mstsubject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblregistration`
--
ALTER TABLE `tblregistration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
