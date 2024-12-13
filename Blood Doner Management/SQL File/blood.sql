-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 11, 2022 at 06:08 PM
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
-- Database: `blood`
--

-- --------------------------------------------------------

--
-- Table structure for table `bloodgroup`
--

CREATE TABLE `bloodgroup` (
  `id` int(11) NOT NULL,
  `bloodname` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bloodgroup`
--

INSERT INTO `bloodgroup` (`id`, `bloodname`) VALUES
(1, 'B+'),
(2, 'B'),
(3, 'O'),
(4, 'O+');

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `create_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`id`, `name`, `email`, `password`, `create_date`) VALUES
(1, 'Anuj Kumar', 'admin@gmail.com', 'Test@123', '2021-12-30 16:04:00');

-- --------------------------------------------------------

--
-- Table structure for table `tblregistration`
--

CREATE TABLE `tblregistration` (
  `id` int(11) NOT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `gender` varchar(45) DEFAULT NULL,
  `blood` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `contact_no` varchar(45) DEFAULT NULL,
  `state` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `agree` varchar(45) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `create_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblregistration`
--

INSERT INTO `tblregistration` (`id`, `first_name`, `last_name`, `gender`, `blood`, `email`, `contact_no`, `state`, `city`, `password`, `agree`, `address`, `create_date`) VALUES
(2, 'Test', 'Test', 'Male', '2', 'test@gmail.com', '9999999999', 'up', 'Lucknow', 'f925916e2754e5e03f75dd58a5733251', 'on', NULL, '2022-01-01 12:11:06'),
(4, 'amit', 'kumar', 'Male', '4', 'amin@gmail.com', '7777777777', 'dddddd', 'ggggggg', 'e10adc3949ba59abbe56e057f20f883e', 'on', NULL, '2022-01-03 12:16:09'),
(5, 'badal', 'singh', 'Male', '2', 'badal@gmail.com', '9721843561', 'UP', 'NewAshok', '25d55ad283aa400af464c76d713c07ad', 'on', NULL, '2022-01-02 15:30:28'),
(6, 'dd', 'kumarfgfg', 'Male', '3', 'anuj@gmail.com', '7777777766', 'cggg', 'jjjjjjjj', '25f9e794323b453885f5181f1b624d0b', 'on', NULL, '2022-01-03 16:12:15'),
(7, 'Amit', 'Kumar', 'Male', '1', 'amitkumar@gmail.com', '1234567890', 'Delhi', 'New Delhi', 'f925916e2754e5e03f75dd58a5733251', 'on', NULL, '2022-01-11 15:04:26'),
(8, 'Amit', 'Kumar', 'Male', '1', 'amitkumar12@gmail.com', '1234567890', 'Uttar Pradesh', 'Noida', 'f925916e2754e5e03f75dd58a5733251', 'on', NULL, '2022-01-11 15:04:51'),
(9, 'John', 'Doe', 'Male', '3', 'johndoe@gmail.com', '1234567895', 'Haryana', 'Gurugram', 'f925916e2754e5e03f75dd58a5733251', 'on', NULL, '2022-01-11 15:21:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bloodgroup`
--
ALTER TABLE `bloodgroup`
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
-- AUTO_INCREMENT for table `bloodgroup`
--
ALTER TABLE `bloodgroup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblregistration`
--
ALTER TABLE `tblregistration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
