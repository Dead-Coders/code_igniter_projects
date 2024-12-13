-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2022 at 08:13 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `complaintsci`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `image` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `image`, `password`, `role_id`, `is_active`, `date_created`) VALUES
(27, 'Liam Moore', 'admin@mail.com', 'admin-icn.png', '$2y$10$oPOmdz1Ph/Sob88t5NWcXObo0.EdDa7TY6ZHEYrYG5IHEfMyEtpJ6', 1, 1, 1599504982),
(32, 'Tiffany O. Errico', 'tiffo@mail.com', 'default.jpg', '$2y$10$pZFHhWCS.Ao.eJEsRIx8e.0HH.UdkNI4w/NdlLSZ8dYYigAbvgaAe', 2, 1, 1599577135),
(33, 'Marvin D. Behrens', 'marvind@mail.com', 'default.jpg', '$2y$10$4Qc8UQVBZg8mx1/iKcgiHu.zJ9zs4IoIvDPMSMktj6DEyV3pQX7DS', 2, 1, 1599577186),
(34, 'Nelson L. Perez\n', 'nelsonp@mail.com', 'default.jpg', '$2y$10$NRnnTrxQkRqVK0M/BNXLa.sajWUnF971Hff/Hsyext75qAoDgXWI2', 2, 1, 1599577219),
(35, 'Seth L. Buckner\n', 'sethb@mail.com', 'default.jpg', '$2y$10$kIB2L/O3/7z7pQmV.XYtAOOBYDZl5TbSWSULg1QTws7TNm1qI/XAm', 2, 1, 1599577247),
(36, 'Harold B. Loya\n', 'haroldbl@mail.com', 'default.jpg', '$2y$10$wW9vlmU6rjciESA6i1N.we3TMlE6fWG7ICy7LOkZdRxPK7m6j001W', 2, 1, 1599577284),
(37, 'Christine Moore', 'christine@mail.com', 'default.jpg', '$2y$10$enF4wVVEDEYRSEd.NT7JheUjB6.TBnTWR0q4aJU5JlulO.lHmZb9G', 2, 1, 1651551632),
(38, 'Michael K. Parker', 'michaelp@mail.com', 'default.jpg', '$2y$10$YP4.s3pZe2RzbYv48fEA5.g04TkeDnxOCq7OSSW5zQf77qaqZYGoK', 2, 1, 1651593601);

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(1, 1, 1),
(14, 1, 2),
(15, 1, 7),
(16, 2, 4),
(17, 1, 5),
(20, 1, 3),
(21, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`) VALUES
(1, 'Admin'),
(2, 'Menu'),
(3, 'User'),
(4, 'Report Form'),
(5, 'Report');

-- --------------------------------------------------------

--
-- Table structure for table `user_report`
--

CREATE TABLE `user_report` (
  `id` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `nik` varchar(64) NOT NULL,
  `rt` int(11) NOT NULL,
  `rw` int(11) NOT NULL,
  `village` varchar(64) NOT NULL,
  `title` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `type` text NOT NULL,
  `date_reported` int(11) NOT NULL,
  `file` varchar(64) NOT NULL DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_report`
--

INSERT INTO `user_report` (`id`, `name`, `nik`, `rt`, `rw`, `village`, `title`, `description`, `type`, `date_reported`, `file`) VALUES
('5f57a6d18c382', 'Marvin D. Behrens', '0311192857689401', 1, 4, 'Little Ivywood', 'Flood', 'Several residential areas were affected by the flood', 'Natural Disaster', 1646499899, '5f57a6d18c382.jpeg'),
('5f57a769d43b0', 'Tiffany O. Errico', '3299000709012871', 2, 4, 'Aucteraden', 'Need Education Help', 'Some children are still not getting a decent education.', 'Education', 1648405450, '5f57a769d43b0.jpg'),
('6270af1bdf852', 'Christine Moore', '12121', 2, 2, 'as', 'Demo', 'Demo demo demo', 'Corona Virus', 1651552027, '6270af1bdf852.png');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'Administrator'),
(2, 'Member');

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
(1, 1, 'Dashboard', 'admin', 'fas fa-fw fa-tachometer-alt', 1),
(2, 3, 'My Profile', 'user', 'fas fa-fw fa-user', 1),
(3, 3, 'Update Profile', 'user/edit', 'fas fa-fw fa-user-edit', 1),
(4, 2, 'Menu Management', 'menu', 'fas fa-fw fa-folder', 1),
(5, 2, 'Submenu Management', 'menu/submenu', 'fas fa-fa-fw fa-folder-open', 1),
(6, 1, 'Access Authority', 'admin/role', 'fas fa-fw fa-user-tie', 1),
(7, 3, 'Change Password', 'user/changepassword', 'fas fa-fw fa-key', 1),
(9, 4, 'Report', 'report/addreport', 'fas fa-fw fa-headset', 1),
(10, 5, 'Report Data', 'report', 'fas fa-fw fa-file-alt', 1),
(11, 1, 'User Data', 'admin/datamember', 'fas fa-fw fa-users', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

CREATE TABLE `user_token` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `token` varchar(128) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_token`
--

INSERT INTO `user_token` (`id`, `email`, `token`, `date_created`) VALUES
(8, 'aa@gmail.com', 'Wag8dsxx6ziM9O8n/HisVkGyy9+az5XeumzNuaJMGg4=', 1599579296),
(9, 'christine@mail.com', '0Hrx2++F9JMO4pYOuQRLLlfQwP5DWH/O76x//+Yhs54=', 1651551632);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_report`
--
ALTER TABLE `user_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
