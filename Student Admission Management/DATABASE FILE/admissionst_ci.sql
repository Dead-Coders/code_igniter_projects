-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2021 at 08:11 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `admissionst_ci`
--

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `s_name` varchar(100) NOT NULL,
  `g_name` varchar(100) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `email` varchar(500) NOT NULL,
  `address` text NOT NULL,
  `year` varchar(50) NOT NULL,
  `division` int(10) NOT NULL,
  `b_group` varchar(5) NOT NULL,
  `shift` int(10) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `profile_image` varchar(500) NOT NULL,
  `dateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `s_name`, `g_name`, `contact`, `email`, `address`, `year`, `division`, `b_group`, `shift`, `gender`, `profile_image`, `dateTime`) VALUES
(1, 'Paul Hill\n', 'Maria G Hill', '6014526960', 'paullh@gmail.com', '3953  Chenoweth Drive', '2', 8, 'A+', 1, 'M', 'http://localhost/ci-student/uploads/image/pauptr.jpg', '2019-05-05 06:48:35'),
(2, 'Robert Anderson', 'Clara Anderson', '3578520000', 'robertsn@gmail.com', '159  Rose Street', '3', 4, 'AB+', 1, 'M', 'http://localhost/ci-student/uploads/image/dportrait.jpg', '2019-05-05 08:36:31'),
(3, 'Valerie Hanson', 'Joeffry K Hanson', '3547854440', 'valson@gmail.com', '3572  Gordon Street', '2', 5, 'B+', 2, 'F', 'http://localhost/ci-student/uploads/image/fportwm.jpg', '2019-05-05 08:46:11'),
(4, 'Howard McClinton', 'Megan Mcclinton', '7954220000', 'howardmc@gmail.com', '1402  Bassel Street', '2', 9, 'A+', 2, 'M', 'http://localhost/ci-student/uploads/image/7002489_preview.jpg', '2019-05-05 08:48:52'),
(10, 'Sharon J Nichols', 'Sam Nichols Yrk', '7410000025', 'sharcnn7@gmail.com', '1467  Briarhill Lane', '2', 1, 'A-', 1, 'F', 'http://localhost/ci-student/uploads/image/prtwm.jpg', '2019-05-05 16:20:17'),
(11, 'Alan McMakin', 'George McMakin', '7540002450', 'alan7855@gmail.com', '3958  Burnside Court', '3', 2, 'A+', 1, 'M', 'http://localhost/ci-student/uploads/image/portrait-allen.jpg', '2019-05-05 20:28:20'),
(13, 'James Pugh', 'Natt Pugh', '8540002140', 'jamespp@gmail.com', '588  Morgan Street', '2', 7, 'O+', 2, 'M', 'http://localhost/ci-student/uploads/image/BCS_SKL_300-300.jpg', '2019-05-05 20:54:46'),
(14, 'Christine Moore', 'Bradley Moore', '1576501254', 'christin@gmail.com', '258 Ralph Street', '3', 4, 'B-', 1, 'F', 'http://localhost/ci-student/uploads/image/christen-freeimg.jpg', '2021-05-09 14:24:46'),
(16, 'James Smith', 'Irvine Smith', '7601450002', 'smithjms@gmail.com', '1650  University Street', '2', 7, 'B-', 1, 'M', 'http://localhost/ci-student/uploads/image/skport.jpg', '2021-05-09 17:47:57'),
(17, 'Natalie Hayyes', 'Dorothy Hayyes', '8520303029', 'nates78@gmail.com', '3848 Hill Road', '2', 4, 'B+', 1, 'F', 'http://localhost/ci-student/uploads/image/dportraitw.jpg', '2021-05-09 18:05:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `admin_name` varchar(200) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `password` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `admin_name`, `email`, `contact`, `password`) VALUES
(2, 'Will Williams', 'williams@gmail.com', '7126586969', '$2y$12$l2tmJS3yDkSAueke8WElbedC0a931qn7xYTCBLpmrpv1nYlX0AF0.'),
(6, 'Sam Wilson', 'wilson@gmail.com', '2458000025', '$2y$12$mj0VLSyQCnuq0kkFUFEom.dsEbs5J1ndXu3.X7UzkzQIas.SuuRPe'),
(7, 'Demo Admin', 'admindemo@gmail.com', '5547902140', '$2y$12$sJTisX8PEN6JL4kVSZOYEunvabZU3kcvc5doE7zDtvgkBeSNKUEym');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `students`
--
ALTER TABLE `students`
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
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
