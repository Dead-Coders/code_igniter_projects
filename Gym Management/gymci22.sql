-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2022 at 09:27 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gymci22`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `admin_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `admin_email` varchar(50) NOT NULL,
  `admin_password` varchar(100) NOT NULL,
  `shift` varchar(10) NOT NULL,
  `access_level` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`admin_id`, `first_name`, `last_name`, `admin_email`, `admin_password`, `shift`, `access_level`) VALUES
(25, 'Liam', 'Moore', 'admin@mail.com', '$2y$10$7rLSvRVyTQORapkDOqmkhetjF6H9lJHngr4hJMSM2lHObJbW5EQh6', 'Morning', 1),
(27, 'Olga', 'Daileyy', 'olga@mail.com', '$2y$10$93RGZgljJMWkIispsgVwo.3UW27cZFSu1RQn2F1QBhZuFEgBZ193u', 'Morning', 1),
(28, 'Jamie', 'James', 'jamie@mail.com', '$2y$10$XkHlTuf3wgCr/BQC/Iob2.IOYCEPkE3pbSR7kv5KjTuQvNLD70.ye', 'Morning', 1),
(29, 'Jenifer', 'McFee', 'mcfee@mail.com', '$2y$10$RGOXP2JCy/Swbcm39Vak8.gFq.g09NIVijLGwgcLz7vfdgV/ioqiG', 'Evening', 1),
(31, 'Peter', 'Quill', 'quillp@mail.com', '$2y$10$sxLP3zomQx/V7wS/9b7Sk.mYUXm6MrE4yXXM4shiaYiLmha5AbKQ.', 'Morning', 1),
(39, 'Test', 'Test T', 'test@mail.com', '$2y$10$xTNbk4DQ.pqnLq4KvlTyWuzqlGeRI4iqJOT4bY56n7Up3XHwh6/pG', 'Morning', 2);

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `admin_email` varchar(50) NOT NULL,
  `admin_password` varchar(100) NOT NULL,
  `shift` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `first_name`, `last_name`, `admin_email`, `admin_password`, `shift`) VALUES
(1, 'Will', 'Williams', 'williams@mail.com', '$2y$10$VV4sWAgqpS4putVP.aku1.WjtF4tkAvfy3ji.g4emLyL1ebpmPYTW', 'Morning'),
(3, 'Liam', 'Moore', 'admin@mail.com', '$2y$10$7rLSvRVyTQORapkDOqmkhetjF6H9lJHngr4hJMSM2lHObJbW5EQh6', 'Morning');

-- --------------------------------------------------------

--
-- Table structure for table `bar`
--

CREATE TABLE `bar` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bar`
--

INSERT INTO `bar` (`id`, `name`, `price`) VALUES
(1, 'Orange Juice', '3'),
(4, 'Grape Fruit Juice Large', '5'),
(5, 'Knee Support', '9'),
(6, 'Water', '1'),
(7, 'Fruit Smoothie', '4'),
(8, 'Milk Pack Small', '1'),
(9, 'Green Tea', '2'),
(10, 'Tea', '2'),
(12, 'Banana', '2'),
(13, 'Pineapple Juice', '3'),
(14, 'Mix Fresh Juice', '5'),
(15, 'Greek Yogurt Smoothie', '6'),
(18, 'Apple Juice Large', '4'),
(25, 'Black Coffee', '2'),
(26, 'Milk Coffee', '3'),
(28, 'Chocolate Milk', '4'),
(32, 'Wrist Band', '8'),
(35, 'Elbow Support', '8'),
(58, 'Test Item', '10'),
(63, 'Supplement and Banana', '10'),
(64, 'Protein Shake', '8'),
(65, 'Carrot Juice ', '5'),
(68, 'Supplement and Apple', '10');

-- --------------------------------------------------------

--
-- Table structure for table `bin`
--

CREATE TABLE `bin` (
  `id` int(11) NOT NULL,
  `report_id` int(11) DEFAULT NULL,
  `membership_no` varchar(11) DEFAULT NULL,
  `member_name` varchar(20) DEFAULT NULL,
  `member_type` varchar(10) DEFAULT NULL,
  `packages` varchar(50) DEFAULT NULL,
  `total_amount` varchar(15) DEFAULT NULL,
  `cashier` varchar(20) DEFAULT NULL,
  `fee_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `balance` varchar(11) DEFAULT NULL,
  `payment_type` varchar(15) DEFAULT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `discount` varchar(15) DEFAULT NULL,
  `remarks` text NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bin`
--

INSERT INTO `bin` (`id`, `report_id`, `membership_no`, `member_name`, `member_type`, `packages`, `total_amount`, `cashier`, `fee_date`, `end_date`, `balance`, `payment_type`, `time_stamp`, `discount`, `remarks`, `type`) VALUES
(12, 2, NULL, 'Juice Bar', 'Items/Juic', ',Orange Juice s,Knee Support', '400', 'Liam', NULL, NULL, '', 'Cash', '2022-04-21 16:59:47', NULL, 'Test', ''),
(13, 1, NULL, 'Juice Bar', 'Items/Juic', ',Orange Juice s,Grape Fruit Juice Large,Knee Suppo', '850', 'hanzala', NULL, NULL, '', 'Cash', '2022-04-21 17:01:51', NULL, 'none', ''),
(14, 12, NULL, 'Juice Bar', 'Items/Juic', ',Knee Support', '18', 'admin@mail.com', NULL, NULL, '', 'Cash', '2022-04-21 17:33:03', NULL, 'Demo Test', '');

-- --------------------------------------------------------

--
-- Table structure for table `daily_members`
--

CREATE TABLE `daily_members` (
  `user_id` int(20) NOT NULL,
  `user_name` text,
  `user_address` varchar(50) DEFAULT NULL,
  `user_cellnumber` varchar(20) DEFAULT NULL,
  `user_nic` varchar(20) DEFAULT NULL,
  `balance_status` varchar(6) DEFAULT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `daily_members`
--

INSERT INTO `daily_members` (`user_id`, `user_name`, `user_address`, `user_cellnumber`, `user_nic`, `balance_status`, `time_stamp`) VALUES
(23, 'Test Visitor', 'Test Address', '7774444545', '1245785457854', '46', '2022-04-21 16:17:42');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `type` varchar(30) NOT NULL,
  `remarks` text NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `operation` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `type`, `remarks`, `time_stamp`, `operation`) VALUES
(45, 'Member', 'New Member (No:787 Name: Christine) was added by Admin: Liam', '2022-04-18 18:13:20', 'Insert'),
(46, 'Workout', 'New Package/Item (Name: Test Gym, Type:Workout, Price: 500 Rs) Added by Admin: Liam', '2022-04-18 18:17:10', 'Add'),
(47, 'Member', 'Record of  Member (Name: M. Ijaz, ID: 4) Was Deleted by Admin: Liam', '2022-04-19 05:30:32', 'Delete'),
(48, 'Member', 'Record of  Member (Name: Hanzala, ID: 3) Was Deleted by Admin: Liam', '2022-04-19 05:31:13', 'Delete'),
(49, 'Workout Package', 'Record of Workout Package (Name: Aerobatics/Yoga, ID: 15) was updated by Admin Liam', '2022-04-19 05:34:53', 'Update'),
(50, 'Workout Package', 'Record of Workout Package (Name: Personal Training, ID: 36) was updated by Admin Liam', '2022-04-19 05:36:20', 'Update'),
(51, 'Workout Package', 'Record of Workout Package (Name: Personal Trainer, ID: 36) was updated by Admin Liam', '2022-04-19 05:36:33', 'Update'),
(52, 'Workout Package', 'Record of Workout Package (Name: Zumba, ID: 35) was updated by Admin Liam', '2022-04-19 05:36:54', 'Update'),
(53, 'Workout Package', 'Record of Workout Package (Name: Gynasium, ID: 34) was updated by Admin Liam', '2022-04-19 05:37:19', 'Update'),
(54, 'Workout Package', 'Record of Workout Package (Name: Test Gym, ID: 37) was updated by Admin Liam', '2022-04-19 05:37:29', 'Update'),
(55, 'Daily Package', ' Record of Daily Package(Name: Suana/Steam) Updated by Admin: Liam', '2022-04-19 05:38:30', 'Update'),
(56, 'Monthly Package', 'Record of Monthly Package(Duration: 6) Updated By Admin: Liam', '2022-04-19 05:39:35', 'Update'),
(57, 'Monthly Package', 'Record of Monthly Package(Duration: 1) Updated By Admin: Liam', '2022-04-19 05:39:42', 'Update'),
(58, 'Member', 'Member :Christine,787 Status was updated from Active to Dormant By Liam', '2022-04-19 05:40:18', 'Update'),
(59, 'Member', 'Member :Christine,787 Status was updated from Dormant to Freeze By Liam', '2022-04-19 05:40:27', 'Update'),
(60, 'Member', 'Member :Christine,787 Status was updated from Freeze to Active By Liam', '2022-04-19 05:40:34', 'Update'),
(61, 'T/M Package', 'Record of Therapy/Massage Packages (Name: Deep Tissue Back Massage 20 Minutes) was updated by Admin: Liam', '2022-04-19 05:41:18', 'Update'),
(62, 'T/M Package', 'Record of Therapy/Massage Packages (Name: Full Body Massage) was updated by Admin: Liam', '2022-04-19 05:41:29', 'Update'),
(63, 'T/M Package', 'Record of Therapy/Massage Packages (Name: Head And Shoulde Massage 30 Minutes) was updated by Admin: Liam', '2022-04-19 05:41:39', 'Update'),
(64, 'T/M Package', 'Record of Therapy/Massage Packages (Name: Swedish Massage) was updated by Admin: Liam', '2022-04-19 05:41:58', 'Update'),
(65, 'T/M Package', 'Record of Therapy/Massage Package(Name: Test package) Deleted by Admin: Liam', '2022-04-19 05:43:35', 'Delete'),
(66, 'T/M Package', 'Record of Therapy/Massage Packages (Name: Ventosa Cuppping Therapy 90 Minutes) was updated by Admin: Liam', '2022-04-19 05:44:26', 'Update'),
(67, 'T/M Package', 'Record of Therapy/Massage Packages (Name: Ventosa Cupping Therapy 90 Minutes) was updated by Admin: Liam', '2022-04-19 05:44:30', 'Update'),
(68, 'Daily Visitor', 'Record of Daily visitor (Name: Hamza Ali , ID : 22) was updated by Admin : Liam', '2022-04-19 18:14:03', 'Update'),
(69, 'Workout', 'New Package/Item (Name: Cardio, Type:Workout, Price: 19 Rs) Added by Admin: Liam', '2022-04-20 17:55:36', 'Add'),
(70, 'Member', 'New Member (No:101 Name: Rodney K. Jackson) was added by Admin: Liam', '2022-04-20 18:10:06', 'Insert'),
(119, 'Member', 'New Member (No:188 Name: Margaret H. Stradford) was added by Admin: Liam', '2022-04-21 15:45:08', 'Insert'),
(120, 'Daily Visitor', 'New Daily Visitor : Test Visitor was added by Liam', '2022-04-21 16:17:43', 'Insert'),
(121, 'Member', 'New Member (No:200 Name: Melanie R. Haynes) was added by Admin: Liam', '2022-04-21 16:26:44', 'Insert'),
(122, 'Monthly', 'New Package/Item (Name: 12 Months, Type:Monthly, Price: 595 Rs) Added by Admin: Liam', '2022-04-21 16:35:17', 'Add'),
(123, 'Member', 'New Member (No:302 Name: Antonio M. Hayes) was added by Admin: Liam', '2022-04-21 16:37:07', 'Insert'),
(124, 'Juice/Item', 'Item (Name: Apple Juice Large) Deleted by Admin : admin@mail.com', '2022-04-21 17:05:28', 'Delete'),
(125, 'Juice/Item', 'Item (Name: Apple Juice Large) Deleted by Admin : admin@mail.com', '2022-04-21 17:05:40', 'Delete');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `member_no` int(11) DEFAULT NULL,
  `member_name` varchar(25) NOT NULL,
  `member_father_name` varchar(25) NOT NULL,
  `member_dob` varchar(20) NOT NULL,
  `member_nic` varchar(20) NOT NULL,
  `member_gender` varchar(10) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `member_bloodpressure` varchar(20) DEFAULT NULL,
  `member_heart_disease` varchar(20) DEFAULT NULL,
  `member_diabetes` varchar(20) DEFAULT NULL,
  `member_hepatitis` varchar(20) DEFAULT NULL,
  `member_asthma` varchar(15) DEFAULT NULL,
  `member_arthritis` varchar(20) DEFAULT NULL,
  `member_others` varchar(25) DEFAULT NULL,
  `member_resident` varchar(50) NOT NULL,
  `member_address` varchar(50) NOT NULL,
  `member_telephone` varchar(20) NOT NULL,
  `member_fax_no` varchar(20) DEFAULT NULL,
  `member_email` varchar(20) NOT NULL,
  `member_emergency_no` varchar(20) DEFAULT NULL,
  `member_aerobics` varchar(20) DEFAULT NULL,
  `member_gymnasium` varchar(20) DEFAULT NULL,
  `member_zumba` varchar(20) DEFAULT NULL,
  `member_personal_training` varchar(20) DEFAULT NULL,
  `member_gym_time` varchar(15) NOT NULL,
  `status` varchar(15) NOT NULL,
  `freeze_by` varchar(15) DEFAULT NULL,
  `freeze_date` date DEFAULT NULL,
  `activate_date` date DEFAULT NULL,
  `monthlyfee_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `fee_status` varchar(6) DEFAULT NULL,
  `balance_status` varchar(6) DEFAULT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updateby` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `member_no`, `member_name`, `member_father_name`, `member_dob`, `member_nic`, `member_gender`, `image`, `member_bloodpressure`, `member_heart_disease`, `member_diabetes`, `member_hepatitis`, `member_asthma`, `member_arthritis`, `member_others`, `member_resident`, `member_address`, `member_telephone`, `member_fax_no`, `member_email`, `member_emergency_no`, `member_aerobics`, `member_gymnasium`, `member_zumba`, `member_personal_training`, `member_gym_time`, `status`, `freeze_by`, `freeze_date`, `activate_date`, `monthlyfee_date`, `end_date`, `fee_status`, `balance_status`, `time_stamp`, `updateby`) VALUES
(5, 787, 'Christine', 'Zeuus', '02/12/1990', '1111111111110', 'Female', NULL, 'bloodpressure', '', '', NULL, '', NULL, '', 'Test', 'Testaddress', '7777777774', NULL, 'christine@mail.com', NULL, NULL, NULL, NULL, NULL, 'Morning', 'Active', NULL, NULL, NULL, '2022-04-18', '2022-10-15', 'Paid', '990', '2022-04-21 16:28:18', NULL),
(6, 101, 'Rodney K. Jackson', 'Tobey Jackson', '06/11/1985', '1111002100140', 'Male', NULL, '', '', '', NULL, '', NULL, 'none', '0145896570', '84 Bloomfield Way', '0145896570', NULL, 'rodneyk@mail.com', NULL, NULL, NULL, NULL, NULL, 'Morning', 'Active', NULL, NULL, NULL, '2022-04-20', '2022-10-17', 'Paid', '990', '2022-04-21 16:28:13', NULL),
(7, 110, 'Charles E. King', 'Ben E. King', '12/10/1989', '1111111100101', 'Male', NULL, '', '', '', NULL, '', NULL, 'none', '0125698740', '63 Koontz Lane', '0125698740', NULL, 'charlek@mail.com', NULL, NULL, NULL, NULL, NULL, 'Evening', 'InActive', NULL, NULL, NULL, '2022-04-20', '2022-05-20', 'Paid', '190', '2022-04-21 16:27:50', NULL),
(8, 188, 'Margaret H. Stradford', 'Luis Stradford', '02/12/1990', '111144447741', 'Female', NULL, '', '', '', NULL, 'asthama', NULL, '', '1114447854', '51 Catherine Drive', '1114447854', NULL, 'margas@mail.com', NULL, NULL, NULL, NULL, NULL, 'Morning', 'Active', NULL, NULL, NULL, '2022-04-21', '2022-10-18', 'UnPaid', '882', '2022-04-21 16:28:05', NULL),
(9, 200, 'Melanie R. Haynes', 'none', '12/01/1996', '1478547850000', 'Female', NULL, '', '', '', NULL, '', NULL, 'none', 'Sulphur', '51 Bridge Avenue', '0147856985', NULL, 'hayn@mail.com', NULL, NULL, NULL, NULL, NULL, 'Evening', 'Active', NULL, NULL, NULL, '2022-04-21', '2022-05-21', 'Paid', '151', '2022-04-21 16:26:44', NULL),
(10, 302, 'Antonio M. Hayes', 'none', '12/08/1990', '3322114455100', 'Male', NULL, '', '', '', NULL, '', NULL, 'none', '0125698570', '88 Gordon Street', '0125698570', NULL, 'hayanto@mail.com', NULL, NULL, NULL, NULL, NULL, 'Morning', 'Dormant', NULL, NULL, NULL, '2022-04-21', '2023-04-16', 'UnPaid', '743', '2022-04-21 17:28:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `type` varchar(11) NOT NULL,
  `duration` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `name`, `price`, `type`, `duration`) VALUES
(3, 'Full Body Massage', 98, 'TM', '90'),
(9, '', 303, 'Monthly', '6'),
(10, 'Swedish Massage', 55, 'TM', ''),
(12, 'Head And Shoulde Massage 30 Minutes', 46, 'TM', ''),
(13, 'Ventosa Cupping Therapy 90 Minutes', 99, 'TM', ''),
(15, 'Aerobatics/Yoga', 26, 'Workout', ''),
(20, 'Suana/Steam', 8, 'Daily', ''),
(22, 'Deep Tissue Back Massage 20 Minutes', 36, 'TM', ''),
(24, 'Apple Juice', 9009, 'juice', NULL),
(25, 'Mango Juice', 100, 'juice', NULL),
(26, 'Orange Juice', 200, 'juice', NULL),
(28, 'test by develoepr', 666, 'Juice', ''),
(31, '', 52, 'Monthly', '1'),
(33, 'Test Juice', 199, 'Juice', ''),
(34, 'Gynasium', 90, 'Workout', ''),
(35, 'Zumba', 35, 'Workout', ''),
(36, 'Personal Trainer', 4650, 'Workout', ''),
(37, 'Test Gym', 75, 'Workout', ''),
(38, 'Cardio', 19, 'Workout', ''),
(39, '12 Months', 595, 'Monthly', '12');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id_r` int(11) NOT NULL,
  `membership_no` varchar(15) DEFAULT NULL,
  `member_name` varchar(20) NOT NULL,
  `member_type` varchar(10) NOT NULL,
  `packages` varchar(50) NOT NULL,
  `total_amount` varchar(15) NOT NULL,
  `cashier` varchar(20) NOT NULL,
  `fee_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `balance` varchar(11) NOT NULL,
  `payment_type` varchar(15) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `discount` varchar(15) NOT NULL,
  `fee` int(11) NOT NULL,
  `tax` int(11) NOT NULL,
  `amount_paid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id_r`, `membership_no`, `member_name`, `member_type`, `packages`, `total_amount`, `cashier`, `fee_date`, `end_date`, `balance`, `payment_type`, `time_stamp`, `discount`, `fee`, `tax`, `amount_paid`) VALUES
(3, '787', 'Christine', 'Monthly', '6 Months Zumba\n', '36500', 'Liam', '2022-04-18', '2022-10-15', '11292', 'Cash', '2022-04-21 17:31:28', '0', 41200, 6592, NULL),
(4, NULL, 'Juice Bar', 'Items/Juic', ',Grape Fruit Juice Large', '250', 'Liam', NULL, NULL, '', 'Cash', '2022-04-21 17:31:32', '0', 0, 0, 250),
(5, '101', 'Rodney K. Jackson', 'Monthly', '6 Months Cardio\n', '412.88', 'Liam', '2022-04-20', '2022-10-17', '0', 'Cash', '2022-04-21 17:31:34', '0', 397, 16, NULL),
(6, '110', 'Charles E. King', 'Monthly', '1 Months Aerobatics/Yoga\n', '0', 'Liam', '2022-04-20', '2022-05-20', '159', 'Cash', '2022-04-21 17:31:35', '0', 153, 6, NULL),
(7, '188', 'Margaret H. Stradfor', 'Monthly', '6 Months Aerobatics/Yoga\nZumba\n', '456', 'admin@mail.com', '2022-04-21', '2022-10-18', '0', 'Card', '2022-04-21 17:31:46', '0', 439, 18, NULL),
(8, NULL, 'Test Visitor', 'Daily', 'Suana/Steam\n', '0', 'admin@mail.com', '2022-04-21', NULL, '46', 'Card', '2022-04-21 17:31:44', '0', 44, 3, NULL),
(9, '200', 'Melanie R. Haynes', 'Monthly', '1 Months Cardio\n', '151', 'admin@mail.com', '2022-04-21', '2022-05-21', '0', 'Cash', '2022-04-21 17:31:43', '0', 146, 6, NULL),
(10, '302', 'Antonio M. Hayes', 'Monthly', '12 Months Aerobatics/Yoga\nCardio\n', '743', 'admin@mail.com', '2022-04-21', '2023-04-16', '0', 'Cheque', '2022-04-21 17:31:42', '0', 715, 29, NULL),
(11, NULL, 'Juice Bar', 'Items/Juic', ',Fruit Smoothie,Chocolate Milk', '8', 'admin@mail.com', NULL, NULL, '', 'Cash', '2022-04-21 17:30:25', '0', 0, 0, 8);

-- --------------------------------------------------------

--
-- Table structure for table `therapy_pkgs`
--

CREATE TABLE `therapy_pkgs` (
  `id` int(11) NOT NULL,
  `pkg_name` varchar(50) NOT NULL,
  `pkg_price` int(11) NOT NULL,
  `pkg_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `therapy_pkgs`
--

INSERT INTO `therapy_pkgs` (`id`, `pkg_name`, `pkg_price`, `pkg_time`) VALUES
(1, 'Full Body Massage', 6000, 90),
(2, 'Swedish Massage', 4000, 60),
(3, 'Deep Tissue Back Massage', 3000, 30),
(4, 'Head And Shoulde Massage', 2000, 30),
(5, 'Ventosa Cuppping Therapy', 6000, 90),
(6, 'Deep Tissue Therapy', 2000, 30);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `bar`
--
ALTER TABLE `bar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bin`
--
ALTER TABLE `bin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daily_members`
--
ALTER TABLE `daily_members`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id_r`);

--
-- Indexes for table `therapy_pkgs`
--
ALTER TABLE `therapy_pkgs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `bar`
--
ALTER TABLE `bar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
--
-- AUTO_INCREMENT for table `bin`
--
ALTER TABLE `bin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `daily_members`
--
ALTER TABLE `daily_members`
  MODIFY `user_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;
--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id_r` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `therapy_pkgs`
--
ALTER TABLE `therapy_pkgs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
