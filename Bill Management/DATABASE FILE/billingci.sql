-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2022 at 03:39 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `billingci`
--

-- --------------------------------------------------------

--
-- Table structure for table `addressbook`
--

CREATE TABLE `addressbook` (
  `rowId` int(11) NOT NULL,
  `name` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `hNo` varchar(20) DEFAULT NULL,
  `locality` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `occupation` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `telephone` varchar(25) DEFAULT NULL,
  `mobile` varchar(25) DEFAULT NULL,
  `remarks` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `showInDirectorySearch` char(1) NOT NULL DEFAULT 'Y',
  `deleted` char(1) NOT NULL DEFAULT 'N',
  `createdBy` tinyint(4) DEFAULT NULL,
  `createdStamp` datetime DEFAULT NULL,
  `deletedBy` tinyint(4) DEFAULT NULL,
  `deletedStamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `addressbook`
--

INSERT INTO `addressbook` (`rowId`, `name`, `hNo`, `locality`, `occupation`, `telephone`, `mobile`, `remarks`, `showInDirectorySearch`, `deleted`, `createdBy`, `createdStamp`, `deletedBy`, `deletedStamp`) VALUES
(1, 'Test Name', '44550', '445 Test Locality', 'T Occupation', '014500002', '7458960000', 'none', 'Y', 'N', 1, '2022-01-24 17:09:19', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bkp`
--

CREATE TABLE `bkp` (
  `rowId` int(11) NOT NULL DEFAULT '0',
  `dt` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cashsale`
--

CREATE TABLE `cashsale` (
  `dt` date DEFAULT NULL,
  `mode` char(1) DEFAULT 'C',
  `cashSaleRowId` int(11) DEFAULT NULL,
  `itemRowId` int(11) DEFAULT NULL,
  `itemName` varchar(50) DEFAULT NULL,
  `qty` decimal(10,2) DEFAULT NULL,
  `rate` decimal(10,2) DEFAULT NULL,
  `amt` decimal(10,2) DEFAULT NULL,
  `remarks` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `complaintRowId` int(11) NOT NULL DEFAULT '0',
  `complaintDt` date DEFAULT NULL,
  `customerRowId` int(11) DEFAULT NULL,
  `amt` decimal(10,0) DEFAULT NULL,
  `complaint` varchar(250) DEFAULT NULL,
  `complaintSms` varchar(320) DEFAULT NULL,
  `solved` char(1) DEFAULT 'N',
  `solutionDt` date DEFAULT NULL,
  `solutionRemarks` varchar(250) DEFAULT NULL,
  `solutionSms` varchar(320) DEFAULT NULL,
  `deleted` char(1) DEFAULT 'N',
  `createdBy` int(11) DEFAULT NULL,
  `createdStamp` datetime DEFAULT NULL,
  `deletedBy` int(11) DEFAULT NULL,
  `deletedStamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`complaintRowId`, `complaintDt`, `customerRowId`, `amt`, `complaint`, `complaintSms`, `solved`, `solutionDt`, `solutionRemarks`, `solutionSms`, `deleted`, `createdBy`, `createdStamp`, `deletedBy`, `deletedStamp`) VALUES
(1, '2022-01-24', 2, NULL, 'This is a demo complaint for test', '', 'N', NULL, NULL, NULL, 'N', 1, '2022-01-24 17:43:08', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `conclusions`
--

CREATE TABLE `conclusions` (
  `conclusionRowId` int(11) NOT NULL,
  `context` varchar(20) DEFAULT NULL,
  `conclusion` varchar(2000) DEFAULT NULL,
  `deleted` char(1) NOT NULL DEFAULT 'N',
  `createdBy` int(11) DEFAULT NULL,
  `createdStamp` datetime DEFAULT NULL,
  `deletedBy` tinyint(4) DEFAULT NULL,
  `deletedStamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customerRowId` int(11) NOT NULL,
  `customerName` varchar(150) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `mobile1` varchar(10) DEFAULT NULL,
  `mobile2` varchar(10) DEFAULT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  `remarks2` varchar(100) DEFAULT NULL,
  `doobat` varchar(5) DEFAULT 'No',
  `deleted` char(1) DEFAULT 'N',
  `createdBy` int(11) DEFAULT NULL,
  `createdStamp` datetime DEFAULT NULL,
  `deletedBy` int(11) DEFAULT NULL,
  `deletedStamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customerRowId`, `customerName`, `address`, `mobile1`, `mobile2`, `remarks`, `remarks2`, `doobat`, `deleted`, `createdBy`, `createdStamp`, `deletedBy`, `deletedStamp`) VALUES
(1, 'Liam Moore', '7412 Ralph Street', '7410001452', '7410001458', 'none', 'none', 'No', 'N', 1, '2021-06-02 22:26:29', NULL, NULL),
(2, 'Demo Name', 'Demo Address', '7410001010', '7458960000', 'none', 'none', 'No', 'N', 1, '2021-07-16 22:56:55', NULL, NULL),
(3, 'John Smith', '778 Rose St', '7458965855', '4578554500', 'none', 'none', 'No', 'N', 1, '2022-01-22 17:55:52', NULL, NULL),
(4, 'Rosie J. Guerrero', '43 Langtown Road', '8547774444', '4125630000', 'none', 'none', 'No', 'N', 1, '2022-01-22 21:18:17', NULL, NULL),
(5, 'Richard Pierce', '115 Rowes Lane', '4580000001', '1450002500', 'none', 'none', 'No', 'N', 1, '2022-01-22 21:18:46', NULL, NULL),
(6, 'Minh Hamilton', '12 Joy Lane', '4520001010', '4501250010', 'none', 'none', 'No', 'N', 1, '2022-01-23 21:19:50', NULL, NULL),
(7, 'John Watson', '46 Patton Lane', '8547777740', '4125655580', 'none', 'none', 'No', 'N', 1, '2022-01-23 21:20:20', NULL, NULL),
(8, 'Rebecca J. Harris', '31 Henry Ford Avenue', '7854785470', '4785002580', 'none', 'none', 'No', 'N', 1, '2022-01-23 21:20:48', NULL, NULL),
(9, 'Beverly Kneeland', '16 Chestnut Street', '8547770000', '4547778500', 'none', 'none', 'No', 'N', 1, '2022-01-23 21:21:11', NULL, NULL),
(10, 'Vandervort Supplier', '1003 Elk Avenue', '4545454500', '4501450140', 'Supplier i4', 'Supplier i5', 'No', 'N', 1, '2022-01-23 21:22:16', NULL, NULL),
(11, 'Ralph Browns', '699 Dane Street', '7458965874', '4589657444', 'none', 'none', 'No', 'N', 1, '2022-01-23 21:29:31', NULL, NULL),
(12, 'Henry Olsen', '44 Honeysuckle Lane', '7450001458', '7458001450', 'none', 'none', 'No', 'N', 1, '2022-01-24 17:57:17', NULL, NULL),
(13, 'Robert W. Moore', '47 Loving Acres Road', '4780001010', '4501201200', 'Supplier i6', 'Supplier i7', 'No', 'N', 1, '2022-01-24 17:57:50', NULL, NULL),
(14, 'Francis', '441 test Address', '7774445500', '4780001100', 'none', 'none', 'No', 'N', 1, '2022-01-24 18:10:14', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dailycash`
--

CREATE TABLE `dailycash` (
  `rowId` int(11) NOT NULL,
  `dt` date DEFAULT NULL,
  `in` int(11) DEFAULT '0',
  `out` int(11) DEFAULT '0',
  `remarks` varchar(200) DEFAULT NULL,
  `denominationIn` varchar(150) DEFAULT NULL,
  `denominationOut` varchar(150) DEFAULT NULL,
  `deleted` char(1) NOT NULL DEFAULT 'N',
  `createdBy` int(11) DEFAULT NULL,
  `createdStamp` datetime DEFAULT NULL,
  `deletedBy` tinyint(4) DEFAULT NULL,
  `deletedStamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dailycash`
--

INSERT INTO `dailycash` (`rowId`, `dt`, `in`, `out`, `remarks`, `denominationIn`, `denominationOut`, `deleted`, `createdBy`, `createdStamp`, `deletedBy`, `deletedStamp`) VALUES
(1, '2022-01-24', 880, 0, 'none', '', NULL, 'N', 1, '2022-01-24 18:31:27', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dates`
--

CREATE TABLE `dates` (
  `dateRowId` int(11) NOT NULL,
  `dt` date DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `deleted` char(1) NOT NULL DEFAULT 'N',
  `createdBy` int(11) DEFAULT NULL,
  `createdStamp` datetime DEFAULT NULL,
  `deletedBy` tinyint(4) DEFAULT NULL,
  `deletedStamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `db`
--

CREATE TABLE `db` (
  `dbRowId` int(11) NOT NULL DEFAULT '0',
  `dbDt` date DEFAULT NULL,
  `customerRowId` int(11) DEFAULT NULL,
  `totalAmount` decimal(10,2) DEFAULT '0.00',
  `totalDiscount` decimal(10,2) DEFAULT '0.00',
  `pretaxAmt` decimal(10,2) DEFAULT '0.00',
  `totalIgst` decimal(10,2) DEFAULT '0.00',
  `totalCgst` decimal(10,2) DEFAULT '0.00',
  `totalSgst` decimal(10,2) DEFAULT '0.00',
  `netAmt` decimal(10,2) DEFAULT '0.00',
  `advancePaid` decimal(10,2) DEFAULT '0.00',
  `balance` decimal(10,2) DEFAULT '0.00',
  `dueDate` date DEFAULT NULL,
  `remarks` varchar(250) DEFAULT NULL,
  `np` decimal(10,2) DEFAULT '0.00',
  `deleted` char(1) DEFAULT 'N',
  `createdBy` int(11) DEFAULT NULL,
  `createdStamp` datetime DEFAULT NULL,
  `deletedBy` int(11) DEFAULT NULL,
  `deletedStamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `db`
--

INSERT INTO `db` (`dbRowId`, `dbDt`, `customerRowId`, `totalAmount`, `totalDiscount`, `pretaxAmt`, `totalIgst`, `totalCgst`, `totalSgst`, `netAmt`, `advancePaid`, `balance`, `dueDate`, `remarks`, `np`, `deleted`, `createdBy`, `createdStamp`, `deletedBy`, `deletedStamp`) VALUES
(1, '2021-06-02', 1, '50.00', '0.00', '50.00', '0.00', '0.00', '0.00', '50.00', '50.00', '0.00', '2021-06-02', 'paid', '50.00', 'N', 1, '2021-06-02 22:43:19', NULL, NULL),
(2, '2021-06-02', 1, '50.00', '0.00', '50.00', '0.00', '0.00', '0.00', '50.00', '50.00', '0.00', '2021-06-02', 'paid', '50.00', 'Y', 1, '2021-06-02 22:45:26', NULL, NULL),
(3, '2021-06-02', 1, '50.00', '0.00', '50.00', '0.00', '0.00', '0.00', '50.00', '49.00', '1.00', '2021-06-02', 'paid', '50.00', 'Y', 1, '2021-06-02 22:45:42', NULL, NULL),
(4, '2021-06-02', 1, '125.00', '0.00', '125.00', '0.00', '0.00', '0.00', '125.00', '125.00', '0.00', '2021-06-03', 'paid', '125.00', 'Y', 1, '2021-06-02 22:46:22', NULL, NULL),
(5, '2021-06-02', 1, '125.00', '0.00', '0.00', '0.00', '0.00', '0.00', '125.00', '125.00', '0.00', '2021-06-03', 'paid', '0.00', 'Y', 1, '2021-06-02 22:46:50', NULL, NULL),
(6, '2022-01-22', 3, '588.06', '0.00', '588.06', '0.00', '0.00', '0.00', '588.00', '310.00', '278.00', '2022-01-24', 'Payment due remaining', '-7.00', 'N', 1, '2022-01-22 17:59:53', NULL, NULL),
(7, '2022-01-22', 5, '1225.00', '0.00', '1225.00', '0.00', '0.00', '0.00', '1225.00', '700.00', '525.00', '2022-01-25', 'Dues Remain', '236.00', 'N', 1, '2022-01-22 21:21:41', NULL, NULL),
(8, '2022-01-23', 7, '900.00', '0.00', '900.00', '0.00', '0.00', '0.00', '900.00', '610.00', '290.00', '2022-01-25', 'Dues Remaining', '147.00', 'N', 1, '2022-01-23 21:24:56', NULL, NULL),
(9, '2022-01-24', 14, '895.00', '0.00', '895.00', '0.00', '0.00', '0.00', '895.00', '565.00', '330.00', '2022-01-26', 'Dues Remaining', '290.00', 'N', 1, '2022-01-24 18:23:30', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dbdetail`
--

CREATE TABLE `dbdetail` (
  `dbdRowId` int(11) NOT NULL,
  `dbRowId` int(11) DEFAULT NULL,
  `itemRowId` int(11) DEFAULT NULL,
  `itemName` varchar(200) DEFAULT NULL,
  `qty` decimal(10,2) DEFAULT NULL,
  `rate` decimal(10,2) DEFAULT NULL,
  `amt` decimal(10,2) DEFAULT NULL,
  `discountPer` decimal(6,2) DEFAULT '0.00',
  `discountAmt` decimal(10,2) DEFAULT '0.00',
  `pretaxAmt` decimal(10,2) DEFAULT '0.00',
  `igst` decimal(6,2) DEFAULT '0.00',
  `igstAmt` decimal(10,2) DEFAULT '0.00',
  `cgst` decimal(6,2) DEFAULT '0.00',
  `cgstAmt` decimal(10,2) DEFAULT '0.00',
  `sgst` decimal(6,2) DEFAULT '0.00',
  `sgstAmt` decimal(10,2) DEFAULT '0.00',
  `netAmt` decimal(10,2) DEFAULT '0.00',
  `pp` decimal(10,2) DEFAULT '0.00',
  `itemRemarks` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dbdetail`
--

INSERT INTO `dbdetail` (`dbdRowId`, `dbRowId`, `itemRowId`, `itemName`, `qty`, `rate`, `amt`, `discountPer`, `discountAmt`, `pretaxAmt`, `igst`, `igstAmt`, `cgst`, `cgstAmt`, `sgst`, `sgstAmt`, `netAmt`, `pp`, `itemRemarks`) VALUES
(1, 1, 1, 'Demo Item', '2.00', '25.00', '50.00', '0.00', '0.00', '50.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '50.00', '50.00', 'none'),
(2, 2, 1, 'Demo Item', '2.00', '25.00', '50.00', '0.00', '0.00', '50.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '50.00', '50.00', 'none'),
(3, 3, 1, 'Demo Item', '2.00', '25.00', '50.00', '0.00', '0.00', '50.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '50.00', '50.00', 'none'),
(4, 4, 1, 'Demo Item', '5.00', '25.00', '125.00', '0.00', '0.00', '125.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '125.00', '125.00', 'none'),
(5, 5, 1, 'Demo Item', '5.00', '25.00', '125.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '125.00', '125.00', ''),
(6, 6, 1, 'Demo Item', '11.00', '53.46', '588.06', '0.00', '0.00', '588.06', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '588.06', '588.06', 'none'),
(7, 7, 3, 'Item Two', '49.00', '25.00', '1225.00', '0.00', '0.00', '1225.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '1225.00', '1225.00', 'none'),
(8, 8, 5, 'Item Four', '18.00', '50.00', '900.00', '0.00', '0.00', '900.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '900.00', '900.00', 'none'),
(9, 9, 9, 'Item Eigh', '16.00', '25.00', '400.00', '0.00', '0.00', '400.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '400.00', '400.00', 'none'),
(10, 9, 10, 'Item Nine', '55.00', '9.00', '495.00', '0.00', '0.00', '495.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '495.00', '0.00', 'none');

-- --------------------------------------------------------

--
-- Table structure for table `itemgroups`
--

CREATE TABLE `itemgroups` (
  `itemGroupRowId` int(11) NOT NULL DEFAULT '1',
  `itemGroupName` varchar(20) DEFAULT NULL,
  `deleted` char(1) DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `itemgroups`
--

INSERT INTO `itemgroups` (`itemGroupRowId`, `itemGroupName`, `deleted`) VALUES
(1, 'Demo Group', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `itemRowId` int(11) NOT NULL,
  `itemGroupRowId` int(11) DEFAULT '1',
  `itemName` varchar(200) DEFAULT NULL,
  `sellingPrice` decimal(10,2) DEFAULT '0.00',
  `pp` decimal(10,2) DEFAULT '0.00',
  `openingBalance` decimal(10,2) DEFAULT '0.00',
  `deleted` char(1) NOT NULL DEFAULT 'N',
  `createdBy` int(11) DEFAULT NULL,
  `createdStamp` datetime DEFAULT NULL,
  `deletedBy` tinyint(4) DEFAULT NULL,
  `deletedStamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`itemRowId`, `itemGroupRowId`, `itemName`, `sellingPrice`, `pp`, `openingBalance`, `deleted`, `createdBy`, `createdStamp`, `deletedBy`, `deletedStamp`) VALUES
(1, 1, 'Demo Item', '53.46', '54.11', '50.00', 'N', 1, '2021-06-02 22:27:39', NULL, NULL),
(2, 1, 'Item One', '12.00', '0.00', '0.00', 'N', 1, '2022-01-22 18:03:15', NULL, NULL),
(3, 1, 'Item Two', '25.00', '20.18', '0.00', 'N', 1, '2022-01-22 18:03:21', NULL, NULL),
(4, 1, 'Item Three', '24.00', '0.00', '0.00', 'N', 1, '2022-01-22 18:03:27', NULL, NULL),
(5, 1, 'Item Four', '50.00', '41.85', '0.00', 'N', 1, '2022-01-23 21:07:00', NULL, NULL),
(6, 1, 'Item Five', '10.00', '0.00', '0.00', 'N', 1, '2022-01-23 21:07:07', NULL, NULL),
(7, 1, 'Item Six', '15.00', '0.00', '0.00', 'N', 1, '2022-01-23 21:07:12', NULL, NULL),
(8, 1, 'Item Seven', '39.00', '0.00', '0.00', 'N', 1, '2022-01-23 21:07:20', NULL, NULL),
(9, 1, 'Item Eigh', '25.00', '19.96', '0.00', 'N', 1, '2022-01-23 21:07:26', NULL, NULL),
(10, 1, 'Item Nine', '9.00', '5.20', '111.00', 'N', 1, '2022-01-24 18:10:48', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ledger`
--

CREATE TABLE `ledger` (
  `ledgerRowId` int(11) NOT NULL,
  `vType` varchar(3) DEFAULT NULL,
  `refRowId` int(11) NOT NULL,
  `refDt` date DEFAULT NULL,
  `customerRowId` int(11) DEFAULT NULL,
  `amt` int(11) DEFAULT '0',
  `bal` int(11) DEFAULT '0',
  `recd` int(11) DEFAULT '0',
  `deleted` char(1) DEFAULT 'N',
  `remarks` varchar(250) DEFAULT NULL,
  `orderRowId` int(11) DEFAULT NULL,
  `reminder` date DEFAULT NULL,
  `dbRowId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ledger`
--

INSERT INTO `ledger` (`ledgerRowId`, `vType`, `refRowId`, `refDt`, `customerRowId`, `amt`, `bal`, `recd`, `deleted`, `remarks`, `orderRowId`, `reminder`, `dbRowId`) VALUES
(1, 'DB', 1, '2021-06-02', 1, 50, 0, 0, 'N', 'paid', -111, '2021-06-02', 1),
(2, 'DB', 1, '2021-06-02', 1, 0, 0, 50, 'N', 'paid', -111, NULL, 1),
(3, 'DB', 2, '2021-06-02', 1, 50, 0, 0, 'Y', 'paid', -111, '2021-06-02', 2),
(4, 'DB', 2, '2021-06-02', 1, 0, 0, 50, 'Y', 'paid', -111, NULL, 2),
(5, 'DB', 3, '2021-06-02', 1, 50, 1, 0, 'Y', 'paid', -111, '2021-06-02', 3),
(6, 'DB', 3, '2021-06-02', 1, 0, 0, 49, 'Y', 'paid', -111, NULL, 3),
(7, 'DB', 4, '2021-06-02', 1, 125, 0, 0, 'Y', 'paid', -111, '2021-06-03', 4),
(8, 'DB', 4, '2021-06-02', 1, 0, 0, 125, 'Y', 'paid', -111, NULL, 4),
(9, 'DB', 5, '2021-06-02', 1, 125, 0, 0, 'Y', 'paid', -111, '2021-06-03', 5),
(10, 'DB', 5, '2021-06-02', 1, 0, 0, 125, 'Y', 'paid', -111, NULL, 5),
(11, 'PV', 1, '2022-01-22', 3, 3407, 0, 0, 'N', 'cleared', -111, '2022-01-23', 1),
(12, 'PV', 1, '2022-01-22', 3, 0, 0, 3407, 'N', 'cleared', -111, NULL, 1),
(13, 'DB', 6, '2022-01-22', 3, 588, 278, 0, 'N', 'Payment due remaining', -111, '2022-01-24', 6),
(14, 'DB', 6, '2022-01-22', 3, 0, 0, 310, 'N', 'Payment due remaining', -111, NULL, 6),
(15, 'P', 1, '2022-01-22', 3, 278, 278, 0, 'N', 'dues remain', -222, NULL, NULL),
(16, 'SR', 1, '2022-01-22', 1, 0, 0, 75, 'N', NULL, -321, NULL, 5),
(17, 'PV', 2, '2022-01-22', 4, 4842, 0, 0, 'N', 'cleared', -111, '2022-01-22', 2),
(18, 'PV', 2, '2022-01-22', 4, 0, 0, 4842, 'N', 'cleared', -111, NULL, 2),
(19, 'DB', 7, '2022-01-22', 5, 1225, 525, 0, 'N', 'Dues Remain', -111, '2022-01-25', 7),
(20, 'DB', 7, '2022-01-22', 5, 0, 0, 700, 'N', 'Dues Remain', -111, NULL, 7),
(21, 'P', 2, '2022-01-23', 1, 75, 75, 0, 'N', 'pid-none', -444, NULL, NULL),
(22, 'PV', 3, '2022-01-23', 10, 0, 0, 0, 'N', 'none', -111, '2022-01-24', 3),
(23, 'PV', 3, '2022-01-23', 10, 0, 0, 6178, 'N', 'none', -111, NULL, 3),
(24, 'P', 3, '2022-01-23', 10, 6178, 6178, 0, 'N', 'pid-Purchase Cleared', -444, NULL, NULL),
(25, 'DB', 8, '2022-01-23', 7, 900, 290, 0, 'N', 'Dues Remaining', -111, '2022-01-25', 8),
(26, 'DB', 8, '2022-01-23', 7, 0, 0, 610, 'N', 'Dues Remaining', -111, NULL, 8),
(27, 'PV', 4, '2022-01-24', 8, 2726, 0, 0, 'N', 'Cleared up', -111, '2022-01-25', 4),
(28, 'PV', 4, '2022-01-24', 8, 0, 0, 2726, 'N', 'Cleared up', -111, NULL, 4),
(29, 'DB', 9, '2022-01-24', 14, 895, 330, 0, 'N', 'Dues Remaining', -111, '2022-01-26', 9),
(30, 'DB', 9, '2022-01-24', 14, 0, 0, 565, 'N', 'Dues Remaining', -111, NULL, 9),
(31, 'P', 4, '2022-01-24', 14, 550, 550, 0, 'N', 'Adv Payment', -222, NULL, NULL),
(32, 'R', 1, '2022-01-24', 14, 0, 0, 880, 'N', 'rid-Dues Cleared', -333, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `rowId` int(11) NOT NULL,
  `dt` date DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `repeat` varchar(100) DEFAULT NULL,
  `deleted` char(1) NOT NULL DEFAULT 'N',
  `notificationType` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`rowId`, `dt`, `remarks`, `repeat`, `deleted`, `notificationType`) VALUES
(1, '2022-01-22', 'demo reminder', 'Weekly', 'Y', 'Reminder'),
(2, '2022-01-22', 'test', 'Once', 'Y', 'Reminder'),
(3, '2022-01-24', 'Francis Dues 330', 'Once', 'Y', 'Reminder');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `orderRowId` int(11) NOT NULL DEFAULT '0',
  `orderDt` date DEFAULT NULL,
  `customerRowId` int(11) DEFAULT NULL,
  `totalAmount` decimal(10,2) DEFAULT NULL,
  `advance` decimal(10,2) DEFAULT NULL,
  `due` decimal(10,2) DEFAULT NULL,
  `deliveryDt` date DEFAULT NULL,
  `remarks` varchar(250) DEFAULT NULL,
  `completeOrderReady` char(1) DEFAULT 'N',
  `delivered` char(1) DEFAULT 'N',
  `readySms` varchar(320) DEFAULT NULL,
  `readyStamp` datetime DEFAULT NULL,
  `deliverSms` varchar(320) DEFAULT NULL,
  `deliverStamp` datetime DEFAULT NULL,
  `deleted` char(1) DEFAULT 'N',
  `createdBy` int(11) DEFAULT NULL,
  `createdStamp` datetime DEFAULT NULL,
  `deletedBy` int(11) DEFAULT NULL,
  `deletedStamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orderdetail`
--

CREATE TABLE `orderdetail` (
  `orderDetailRowId` int(11) NOT NULL,
  `orderRowId` int(11) DEFAULT NULL,
  `itemRowId` int(11) DEFAULT NULL,
  `itemName` varchar(50) DEFAULT NULL,
  `qty` decimal(10,2) DEFAULT NULL,
  `rate` decimal(10,2) DEFAULT NULL,
  `amt` decimal(10,2) DEFAULT NULL,
  `itemRemarks` varchar(100) DEFAULT NULL,
  `ready` char(1) DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `organisation`
--

CREATE TABLE `organisation` (
  `orgName` varchar(50) NOT NULL DEFAULT '',
  `add1` varchar(50) DEFAULT NULL,
  `add2` varchar(50) DEFAULT NULL,
  `add3` varchar(50) DEFAULT NULL,
  `add4` varchar(50) DEFAULT NULL,
  `electricianNo` varchar(10) DEFAULT NULL,
  `rechargeLimit` int(11) DEFAULT '0',
  `rechargeMobile` varchar(50) DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `createdStamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `organisation`
--

INSERT INTO `organisation` (`orgName`, `add1`, `add2`, `add3`, `add4`, `electricianNo`, `rechargeLimit`, `rechargeMobile`, `createdBy`, `createdStamp`) VALUES
('Seaco Org', '469 Fraggle Drive', '645 Musgrave Street', '569 Hewes Avenue', '924 Honeysuckle Lane', '7400001010', 500, '7458965000', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `purchaseRowId` int(11) NOT NULL DEFAULT '0',
  `purchaseDt` date DEFAULT NULL,
  `customerRowId` int(11) DEFAULT NULL,
  `totalAmount` decimal(10,0) DEFAULT NULL,
  `totalDiscount` decimal(10,2) DEFAULT '0.00',
  `pretaxAmt` decimal(10,2) DEFAULT '0.00',
  `totalIgst` decimal(10,2) DEFAULT '0.00',
  `totalCgst` decimal(10,2) DEFAULT '0.00',
  `totalSgst` decimal(10,2) DEFAULT '0.00',
  `netAmt` decimal(10,2) DEFAULT '0.00',
  `advancePaid` decimal(10,2) DEFAULT '0.00',
  `balance` decimal(10,2) DEFAULT '0.00',
  `dueDate` date DEFAULT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  `freightTotal` decimal(10,2) DEFAULT '0.00',
  `totalQty` decimal(8,2) DEFAULT '0.00',
  `deleted` char(1) DEFAULT 'N',
  `createdBy` int(11) DEFAULT NULL,
  `createdStamp` datetime DEFAULT NULL,
  `deletedBy` int(11) DEFAULT NULL,
  `deletedStamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`purchaseRowId`, `purchaseDt`, `customerRowId`, `totalAmount`, `totalDiscount`, `pretaxAmt`, `totalIgst`, `totalCgst`, `totalSgst`, `netAmt`, `advancePaid`, `balance`, `dueDate`, `remarks`, `freightTotal`, `totalQty`, `deleted`, `createdBy`, `createdStamp`, `deletedBy`, `deletedStamp`) VALUES
(1, '2022-01-22', 3, '3380', '135.20', '3244.80', '0.00', '97.34', '64.90', '3407.00', '3407.00', '0.00', '2022-01-23', 'cleared', '110.00', '65.00', 'N', 1, '2022-01-22 17:57:50', NULL, NULL),
(2, '2022-01-22', 4, '4800', '144.00', '4656.00', '0.00', '93.12', '93.12', '4842.00', '4842.00', '0.00', '2022-01-22', 'cleared', '0.00', '240.00', 'N', 1, '2022-01-22 21:20:21', NULL, NULL),
(3, '2022-01-23', 10, '6000', '60.00', '5940.00', '0.00', '118.80', '118.80', '6178.00', '0.00', '6178.00', '2022-01-24', 'none', '100.00', '150.00', 'N', 1, '2022-01-23 21:23:20', NULL, NULL),
(4, '2022-01-24', 8, '2638', '26.38', '2611.62', '0.00', '52.23', '62.01', '2726.00', '2726.00', '0.00', '2022-01-25', 'Cleared up', '40.00', '382.00', 'N', 1, '2022-01-24 18:21:52', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchasedetail`
--

CREATE TABLE `purchasedetail` (
  `purchaseDetailRowId` int(11) NOT NULL,
  `purchaseRowId` int(11) DEFAULT NULL,
  `itemRowId` int(11) DEFAULT NULL,
  `itemName` varchar(50) DEFAULT NULL,
  `qty` decimal(10,2) DEFAULT NULL,
  `rate` decimal(10,3) DEFAULT NULL,
  `amt` decimal(10,2) DEFAULT NULL,
  `discountPer` decimal(6,2) DEFAULT '0.00',
  `discountAmt` decimal(10,2) DEFAULT '0.00',
  `pretaxAmt` decimal(10,2) DEFAULT '0.00',
  `igst` decimal(6,2) DEFAULT '0.00',
  `igstAmt` decimal(10,2) DEFAULT '0.00',
  `cgst` decimal(6,2) DEFAULT '0.00',
  `cgstAmt` decimal(10,2) DEFAULT '0.00',
  `sgst` decimal(6,2) DEFAULT '0.00',
  `sgstAmt` decimal(10,2) DEFAULT '0.00',
  `netAmt` decimal(10,2) DEFAULT '0.00',
  `sellingPricePer` decimal(8,2) DEFAULT '0.00',
  `sp` decimal(10,2) DEFAULT '0.00',
  `freight` decimal(10,2) DEFAULT '0.00',
  `itemRemarks` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchasedetail`
--

INSERT INTO `purchasedetail` (`purchaseDetailRowId`, `purchaseRowId`, `itemRowId`, `itemName`, `qty`, `rate`, `amt`, `discountPer`, `discountAmt`, `pretaxAmt`, `igst`, `igstAmt`, `cgst`, `cgstAmt`, `sgst`, `sgstAmt`, `netAmt`, `sellingPricePer`, `sp`, `freight`, `itemRemarks`) VALUES
(1, 1, 1, 'Demo Item', '65.00', '52.000', '3380.00', '4.00', '135.20', '3244.80', '0.00', '0.00', '3.00', '97.34', '2.00', '64.90', '3407.04', '2.00', '53.46', '1.69', 'none'),
(2, 2, 3, 'Item Two', '240.00', '20.000', '4800.00', '3.00', '144.00', '4656.00', '0.00', '0.00', '2.00', '93.12', '2.00', '93.12', '4842.24', '23.91', '25.00', '0.00', 'none'),
(3, 3, 5, 'Item Four', '150.00', '40.000', '6000.00', '1.00', '60.00', '5940.00', '0.00', '0.00', '2.00', '118.80', '2.00', '118.80', '6177.60', '21.41', '50.00', '0.67', 'none'),
(4, 4, 10, 'Item Nine', '330.00', '5.000', '1650.00', '1.00', '16.50', '1633.50', '0.00', '0.00', '2.00', '32.67', '2.00', '32.67', '1698.84', '74.83', '9.00', '0.05', 'none'),
(5, 4, 9, 'Item Eigh', '52.00', '19.000', '988.00', '1.00', '9.88', '978.12', '0.00', '0.00', '2.00', '19.56', '3.00', '29.34', '1027.02', '27.87', '25.00', '0.21', 'none');

-- --------------------------------------------------------

--
-- Table structure for table `quotation`
--

CREATE TABLE `quotation` (
  `quotationRowId` int(11) NOT NULL DEFAULT '0',
  `quotationDt` date DEFAULT NULL,
  `customerRowId` int(11) DEFAULT NULL,
  `totalAmount` decimal(10,2) DEFAULT NULL,
  `remarks` varchar(250) DEFAULT NULL,
  `deleted` char(1) DEFAULT 'N',
  `createdBy` int(11) DEFAULT NULL,
  `createdStamp` datetime DEFAULT NULL,
  `deletedBy` int(11) DEFAULT NULL,
  `deletedStamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quotation`
--

INSERT INTO `quotation` (`quotationRowId`, `quotationDt`, `customerRowId`, `totalAmount`, `remarks`, `deleted`, `createdBy`, `createdStamp`, `deletedBy`, `deletedStamp`) VALUES
(1, '2021-06-02', 1, '125.00', 'none', 'N', 1, '2021-06-02 22:28:18', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `quotationdetail`
--

CREATE TABLE `quotationdetail` (
  `quotationDetailRowId` int(11) NOT NULL,
  `quotationRowId` int(11) DEFAULT NULL,
  `itemRowId` int(11) DEFAULT NULL,
  `itemName` varchar(50) DEFAULT NULL,
  `qty` decimal(10,2) DEFAULT NULL,
  `rate` decimal(10,2) DEFAULT NULL,
  `amt` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quotationdetail`
--

INSERT INTO `quotationdetail` (`quotationDetailRowId`, `quotationRowId`, `itemRowId`, `itemName`, `qty`, `rate`, `amt`) VALUES
(1, 1, 1, 'Demo Item', '5.00', '25.00', '125.00');

-- --------------------------------------------------------

--
-- Table structure for table `recharge`
--

CREATE TABLE `recharge` (
  `rechargeRowId` int(11) NOT NULL,
  `device` varchar(50) DEFAULT NULL,
  `op` varchar(10) DEFAULT NULL,
  `opName` varchar(20) DEFAULT NULL,
  `id` varchar(20) DEFAULT NULL,
  `amt` decimal(10,2) DEFAULT '0.00',
  `status` varchar(40) DEFAULT 'Pending',
  `tag` varchar(100) DEFAULT NULL,
  `deleted` char(1) NOT NULL DEFAULT 'N',
  `createdBy` int(11) DEFAULT NULL,
  `createdStamp` datetime DEFAULT NULL,
  `deletedBy` tinyint(4) DEFAULT NULL,
  `deletedStamp` datetime DEFAULT NULL,
  `previousBalance` decimal(10,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reminders`
--

CREATE TABLE `reminders` (
  `reminderRowId` int(11) NOT NULL,
  `dt` date DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `repeat` varchar(20) DEFAULT NULL,
  `deleted` char(1) NOT NULL DEFAULT 'N',
  `createdBy` int(11) DEFAULT NULL,
  `createdStamp` datetime DEFAULT NULL,
  `deletedBy` tinyint(4) DEFAULT NULL,
  `deletedStamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reminders`
--

INSERT INTO `reminders` (`reminderRowId`, `dt`, `remarks`, `repeat`, `deleted`, `createdBy`, `createdStamp`, `deletedBy`, `deletedStamp`) VALUES
(1, '2022-01-22', 'demo reminder', 'Weekly', 'N', 1, '2022-01-22 18:06:15', NULL, NULL),
(2, '2022-01-22', 'test', 'Once', 'N', 1, '2022-01-22 18:29:39', NULL, NULL),
(3, '2022-01-24', 'Francis Dues 330', 'Once', 'N', 1, '2022-01-24 18:24:37', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `replacement`
--

CREATE TABLE `replacement` (
  `replacementRowId` int(11) NOT NULL,
  `dt` date DEFAULT NULL,
  `itemRowId` int(11) DEFAULT NULL,
  `itemName` varchar(100) DEFAULT NULL,
  `partyRowId` int(11) DEFAULT NULL,
  `partyName` varchar(100) DEFAULT NULL,
  `qty` decimal(10,3) DEFAULT NULL,
  `remarks` varchar(250) DEFAULT NULL,
  `sent` char(1) DEFAULT 'N',
  `sentDt` date DEFAULT NULL,
  `recd` char(1) DEFAULT 'N',
  `recdDt` date DEFAULT NULL,
  `deleted` char(1) NOT NULL DEFAULT 'N',
  `createdBy` int(11) DEFAULT NULL,
  `createdStamp` datetime DEFAULT NULL,
  `deletedBy` tinyint(4) DEFAULT NULL,
  `deletedStamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `replacement`
--

INSERT INTO `replacement` (`replacementRowId`, `dt`, `itemRowId`, `itemName`, `partyRowId`, `partyName`, `qty`, `remarks`, `sent`, `sentDt`, `recd`, `recdDt`, `deleted`, `createdBy`, `createdStamp`, `deletedBy`, `deletedStamp`) VALUES
(1, '2022-01-23', 1, 'Demo Item', 2, 'Demo Name', '2.000', 'none', 'N', NULL, 'N', NULL, 'N', 1, '2022-01-23 21:07:52', NULL, NULL),
(2, '2022-01-24', 2, 'Item One', 1, 'Liam Moore', '21.000', 'none', 'N', NULL, 'N', NULL, 'N', 1, '2022-01-24 18:05:15', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `requirement`
--

CREATE TABLE `requirement` (
  `rowId` bigint(20) NOT NULL DEFAULT '0',
  `dt` date DEFAULT NULL,
  `itemRowId` int(11) DEFAULT NULL,
  `itemName` varchar(200) NOT NULL,
  `lastPurchasePrice` decimal(10,2) DEFAULT '0.00',
  `deleted` char(1) DEFAULT 'N',
  `createdBy` int(11) DEFAULT NULL,
  `createdStamp` datetime DEFAULT NULL,
  `deletedBy` tinyint(4) DEFAULT NULL,
  `deletedStamp` datetime DEFAULT NULL,
  `lastPurchaseFrom` varchar(200) DEFAULT NULL,
  `lastPurchaseDate` varchar(15) DEFAULT NULL,
  `qty` decimal(8,2) DEFAULT '0.00',
  `remarks` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `requirement`
--

INSERT INTO `requirement` (`rowId`, `dt`, `itemRowId`, `itemName`, `lastPurchasePrice`, `deleted`, `createdBy`, `createdStamp`, `deletedBy`, `deletedStamp`, `lastPurchaseFrom`, `lastPurchaseDate`, `qty`, `remarks`) VALUES
(2, NULL, 1, 'Demo Item', '52.42', 'N', 1, '2022-01-24 17:50:01', NULL, NULL, 'John Smith', '2022-01-22', '55.00', 'none'),
(3, NULL, 9, 'Item Eigh', '19.75', 'N', 1, '2022-01-24 18:26:31', NULL, NULL, 'Rebecca J. Harris', '2022-01-24', '18.00', 'none');

-- --------------------------------------------------------

--
-- Table structure for table `sendsms`
--

CREATE TABLE `sendsms` (
  `smsRowId` int(11) NOT NULL,
  `customerRowId` int(11) DEFAULT NULL,
  `smsData` varchar(320) DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `createdStamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sessionlog`
--

CREATE TABLE `sessionlog` (
  `rowid` int(11) NOT NULL,
  `userrowid` int(11) DEFAULT NULL,
  `orgrowid` int(11) DEFAULT NULL,
  `sessionid` varchar(128) DEFAULT NULL,
  `loginstamp` datetime DEFAULT NULL,
  `logoutstamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sr`
--

CREATE TABLE `sr` (
  `dbRowId` int(11) DEFAULT NULL,
  `srRowId` int(11) NOT NULL DEFAULT '0',
  `srDt` date DEFAULT NULL,
  `customerRowId` int(11) DEFAULT NULL,
  `totalAmount` decimal(10,2) DEFAULT '0.00',
  `totalDiscount` decimal(10,2) DEFAULT '0.00',
  `pretaxAmt` decimal(10,2) DEFAULT '0.00',
  `totalIgst` decimal(10,2) DEFAULT '0.00',
  `totalCgst` decimal(10,2) DEFAULT '0.00',
  `totalSgst` decimal(10,2) DEFAULT '0.00',
  `netAmt` decimal(10,2) DEFAULT '0.00',
  `advancePaid` decimal(10,2) DEFAULT '0.00',
  `balance` decimal(10,2) DEFAULT '0.00',
  `dueDate` date DEFAULT NULL,
  `remarks` varchar(250) DEFAULT NULL,
  `np` decimal(10,2) DEFAULT '0.00',
  `deleted` char(1) DEFAULT 'N',
  `createdBy` int(11) DEFAULT NULL,
  `createdStamp` datetime DEFAULT NULL,
  `deletedBy` int(11) DEFAULT NULL,
  `deletedStamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sr`
--

INSERT INTO `sr` (`dbRowId`, `srRowId`, `srDt`, `customerRowId`, `totalAmount`, `totalDiscount`, `pretaxAmt`, `totalIgst`, `totalCgst`, `totalSgst`, `netAmt`, `advancePaid`, `balance`, `dueDate`, `remarks`, `np`, `deleted`, `createdBy`, `createdStamp`, `deletedBy`, `deletedStamp`) VALUES
(5, 1, '2022-01-22', 1, '75.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', NULL, NULL, '0.00', 'N', 1, '2022-01-22 18:02:49', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `srdetail`
--

CREATE TABLE `srdetail` (
  `srdRowId` int(11) NOT NULL,
  `srRowId` int(11) DEFAULT NULL,
  `itemRowId` int(11) DEFAULT NULL,
  `itemName` varchar(200) DEFAULT NULL,
  `qty` decimal(10,2) DEFAULT NULL,
  `rqty` decimal(10,2) DEFAULT '0.00',
  `rate` decimal(10,2) DEFAULT NULL,
  `amt` decimal(10,2) DEFAULT NULL,
  `discountPer` decimal(6,2) DEFAULT '0.00',
  `discountAmt` decimal(10,2) DEFAULT '0.00',
  `pretaxAmt` decimal(10,2) DEFAULT '0.00',
  `igst` decimal(6,2) DEFAULT '0.00',
  `igstAmt` decimal(10,2) DEFAULT '0.00',
  `cgst` decimal(6,2) DEFAULT '0.00',
  `cgstAmt` decimal(10,2) DEFAULT '0.00',
  `sgst` decimal(6,2) DEFAULT '0.00',
  `sgstAmt` decimal(10,2) DEFAULT '0.00',
  `netAmt` decimal(10,2) DEFAULT '0.00',
  `pp` decimal(10,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `srdetail`
--

INSERT INTO `srdetail` (`srdRowId`, `srRowId`, `itemRowId`, `itemName`, `qty`, `rqty`, `rate`, `amt`, `discountPer`, `discountAmt`, `pretaxAmt`, `igst`, `igstAmt`, `cgst`, `cgstAmt`, `sgst`, `sgstAmt`, `netAmt`, `pp`) VALUES
(1, 1, 1, 'Demo Item', '5.00', '3.00', '25.00', '75.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `stageitems`
--

CREATE TABLE `stageitems` (
  `stageItemRowId` int(11) NOT NULL DEFAULT '0',
  `stageRowId` int(11) NOT NULL,
  `stageItemName` varchar(200) DEFAULT NULL,
  `deleted` char(1) NOT NULL DEFAULT 'N',
  `createdBy` int(11) DEFAULT NULL,
  `createdStamp` datetime DEFAULT NULL,
  `deletedBy` tinyint(4) DEFAULT NULL,
  `deletedStamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stages`
--

CREATE TABLE `stages` (
  `stageRowId` int(11) NOT NULL,
  `stageName` varchar(50) DEFAULT NULL,
  `deleted` char(1) NOT NULL DEFAULT 'N',
  `createdBy` int(11) DEFAULT NULL,
  `createdStamp` datetime DEFAULT NULL,
  `deletedBy` tinyint(4) DEFAULT NULL,
  `deletedStamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `todo`
--

CREATE TABLE `todo` (
  `toDoRowId` int(11) NOT NULL,
  `toDoName` varchar(200) DEFAULT NULL,
  `deleted` char(1) NOT NULL DEFAULT 'N',
  `createdBy` int(11) DEFAULT NULL,
  `createdStamp` datetime DEFAULT NULL,
  `deletedBy` tinyint(4) DEFAULT NULL,
  `deletedStamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `userrights`
--

CREATE TABLE `userrights` (
  `rightrowid` int(11) NOT NULL,
  `userrowid` int(11) DEFAULT NULL,
  `menuoption` varchar(50) DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `createdstamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userrights`
--

INSERT INTO `userrights` (`rightrowid`, `userrowid`, `menuoption`, `createdby`, `createdstamp`) VALUES
(1, 1, 'Masters', 1, '2015-08-06 15:32:54'),
(3, 1, 'Reports', 1, '2015-08-06 15:32:56'),
(4, 1, 'Tools', 1, '2015-08-06 15:32:56'),
(7, 1, 'Change Password', 1, '0000-00-00 00:00:00'),
(8, 1, 'Reset Password', 1, '0000-00-00 00:00:00'),
(14, 1, 'Transactions', 1, '0000-00-00 00:00:00'),
(18, 1, 'Session Log', 1, '0000-00-00 00:00:00'),
(19, 1, 'Backup Data', 1, '0000-00-00 00:00:00'),
(60, 1, 'Admin Rights', 1, '0000-00-00 00:00:00'),
(508, 1, 'Organisation', 1, '2017-03-12 11:57:23'),
(509, 1, 'Customers', 1, '2017-03-12 16:15:27'),
(512, 1, 'Ledger', 1, '2017-03-15 10:09:09'),
(513, 1, 'Dues', 1, '2017-03-16 10:27:51'),
(565, 1, 'Items', 1, '2017-03-28 11:45:25'),
(581, 1, 'Sale', 1, '2017-09-03 03:23:10'),
(583, 1, 'Purchase', 1, '2017-09-04 04:02:19'),
(584, 1, 'Payment/Receipt', 1, '2017-09-08 09:47:17'),
(585, 1, 'Sale Report', 1, '2017-09-21 03:33:32'),
(586, 1, 'Purchase Report', 1, '2017-09-22 04:09:53'),
(587, 1, 'Edit Items', 1, '2017-10-11 01:12:58'),
(588, 1, 'Items Purchase And Sold', 1, '2017-10-12 23:22:27'),
(589, 1, 'Search', 1, '2017-10-12 23:25:41'),
(590, 1, 'Requirement', 1, '2017-10-22 02:21:26'),
(593, 1, 'Quotation', 1, '2017-12-27 06:17:16'),
(594, 1, 'Send SMS', 1, '2018-01-15 02:59:33'),
(597, 1, 'Duplicates', 1, '2018-02-21 17:03:10'),
(599, 1, 'Collection Report', 1, '2018-02-22 11:41:15'),
(600, 1, 'Duplicate Customers', 1, '2018-02-23 12:05:39'),
(601, 1, 'Sale Frequency', 1, '2018-02-24 16:51:36'),
(604, 1, 'Items Opening Balance', 1, '2018-02-27 18:10:40'),
(605, 1, 'Item Ledger', 1, '2018-02-27 18:10:50'),
(606, 3, 'Masters', 1, '2018-03-01 12:35:55'),
(607, 3, 'Customers', 1, '2018-03-01 12:35:55'),
(608, 3, 'Reports', 1, '2018-03-01 12:35:55'),
(609, 3, 'Ledger', 1, '2018-03-01 12:35:55'),
(610, 1, 'Address Book', 1, '2018-03-12 17:57:18'),
(611, 1, 'Day Book', 1, '2018-05-03 16:09:54'),
(613, 1, 'To Do List', 1, '2018-07-30 13:16:30'),
(614, 1, 'Conclusions', 1, '2018-07-31 16:42:28'),
(616, 1, 'Replacement', 1, '2018-10-05 20:05:42'),
(617, 1, 'Sales Return', 1, '2019-01-23 12:13:01'),
(618, 1, 'DashBoard', 1, '2019-01-23 17:33:31'),
(619, 1, 'Purchase Log', 1, '2019-03-07 16:30:30'),
(620, 1, 'Daily Cash', 1, '2019-04-10 17:09:58'),
(621, 1, 'Item Groups', 1, '2019-08-31 15:23:27'),
(622, 1, 'Edit Items (Group)', 1, '2019-08-31 15:23:57'),
(623, 1, 'Purchase Analysis', 1, '2019-08-31 19:05:07'),
(624, 1, 'Reminders', 1, '2020-10-10 15:33:37'),
(625, 1, 'Complaints', 1, '2022-01-23 21:34:50');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `rowid` int(11) NOT NULL,
  `uid` varchar(20) NOT NULL,
  `mobile` varchar(10) DEFAULT NULL,
  `pwd` varchar(255) NOT NULL,
  `abAccess` char(1) DEFAULT 'X',
  `abAccessIn` varchar(100) DEFAULT NULL,
  `deleted` char(1) NOT NULL DEFAULT 'N',
  `createdbyrowid` int(11) DEFAULT NULL,
  `createdstamp` datetime DEFAULT NULL,
  `deletedbyrowid` int(11) NOT NULL DEFAULT '-1',
  `deletedstamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`rowid`, `uid`, `mobile`, `pwd`, `abAccess`, `abAccessIn`, `deleted`, `createdbyrowid`, `createdstamp`, `deletedbyrowid`, `deletedstamp`) VALUES
(1, 'admin', '4444440000', 'sha256:1000:GrwENYxzzDf4Nk1HWvXCa5NRBWrr19oQ:W/zvAzUTQRxK8SjpAzYzavx7WxB//eEo', 'C', 'cc', 'N', 1, '2015-09-20 10:13:35', -1, '0000-00-00 00:00:00'),
(2, 'user1', '4141410000', 'sha256:1000:GrwENYxzzDf4Nk1HWvXCa5NRBWrr19oQ:W/zvAzUTQRxK8SjpAzYzavx7WxB//eEo', 'X', '', 'N', 1, '2017-03-18 10:06:07', 1, '2017-08-16 04:17:22'),
(3, 'user2', '4102560000', 'sha256:1000:GrwENYxzzDf4Nk1HWvXCa5NRBWrr19oQ:W/zvAzUTQRxK8SjpAzYzavx7WxB//eEo', 'X', '', 'N', 1, '2018-03-01 12:35:05', -1, NULL),
(4, 'user3', '4580001100', 'sha256:1000:GrwENYxzzDf4Nk1HWvXCa5NRBWrr19oQ:W/zvAzUTQRxK8SjpAzYzavx7WxB//eEo', 'X', NULL, 'N', 1, '2019-09-19 15:37:31', -1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addressbook`
--
ALTER TABLE `addressbook`
  ADD PRIMARY KEY (`rowId`);

--
-- Indexes for table `bkp`
--
ALTER TABLE `bkp`
  ADD PRIMARY KEY (`rowId`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`complaintRowId`);

--
-- Indexes for table `conclusions`
--
ALTER TABLE `conclusions`
  ADD PRIMARY KEY (`conclusionRowId`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customerRowId`);

--
-- Indexes for table `dailycash`
--
ALTER TABLE `dailycash`
  ADD PRIMARY KEY (`rowId`);

--
-- Indexes for table `dates`
--
ALTER TABLE `dates`
  ADD PRIMARY KEY (`dateRowId`);

--
-- Indexes for table `db`
--
ALTER TABLE `db`
  ADD PRIMARY KEY (`dbRowId`),
  ADD KEY `customerRowId` (`customerRowId`);

--
-- Indexes for table `dbdetail`
--
ALTER TABLE `dbdetail`
  ADD PRIMARY KEY (`dbdRowId`),
  ADD KEY `itemRowId` (`itemRowId`);

--
-- Indexes for table `itemgroups`
--
ALTER TABLE `itemgroups`
  ADD PRIMARY KEY (`itemGroupRowId`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`itemRowId`);

--
-- Indexes for table `ledger`
--
ALTER TABLE `ledger`
  ADD PRIMARY KEY (`ledgerRowId`),
  ADD KEY `customerRowId` (`customerRowId`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`orderRowId`);

--
-- Indexes for table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD PRIMARY KEY (`orderDetailRowId`);

--
-- Indexes for table `organisation`
--
ALTER TABLE `organisation`
  ADD PRIMARY KEY (`orgName`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`purchaseRowId`),
  ADD KEY `customerRowId` (`customerRowId`),
  ADD KEY `purchaseDt` (`purchaseDt`);

--
-- Indexes for table `purchasedetail`
--
ALTER TABLE `purchasedetail`
  ADD PRIMARY KEY (`purchaseDetailRowId`),
  ADD KEY `itemRowId` (`itemRowId`);

--
-- Indexes for table `quotation`
--
ALTER TABLE `quotation`
  ADD PRIMARY KEY (`quotationRowId`);

--
-- Indexes for table `quotationdetail`
--
ALTER TABLE `quotationdetail`
  ADD PRIMARY KEY (`quotationDetailRowId`);

--
-- Indexes for table `recharge`
--
ALTER TABLE `recharge`
  ADD PRIMARY KEY (`rechargeRowId`);

--
-- Indexes for table `reminders`
--
ALTER TABLE `reminders`
  ADD PRIMARY KEY (`reminderRowId`);

--
-- Indexes for table `replacement`
--
ALTER TABLE `replacement`
  ADD PRIMARY KEY (`replacementRowId`);

--
-- Indexes for table `requirement`
--
ALTER TABLE `requirement`
  ADD PRIMARY KEY (`rowId`);

--
-- Indexes for table `sendsms`
--
ALTER TABLE `sendsms`
  ADD PRIMARY KEY (`smsRowId`);

--
-- Indexes for table `sessionlog`
--
ALTER TABLE `sessionlog`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `sr`
--
ALTER TABLE `sr`
  ADD PRIMARY KEY (`srRowId`);

--
-- Indexes for table `srdetail`
--
ALTER TABLE `srdetail`
  ADD PRIMARY KEY (`srdRowId`);

--
-- Indexes for table `stageitems`
--
ALTER TABLE `stageitems`
  ADD PRIMARY KEY (`stageItemRowId`);

--
-- Indexes for table `stages`
--
ALTER TABLE `stages`
  ADD PRIMARY KEY (`stageRowId`);

--
-- Indexes for table `todo`
--
ALTER TABLE `todo`
  ADD PRIMARY KEY (`toDoRowId`);

--
-- Indexes for table `userrights`
--
ALTER TABLE `userrights`
  ADD PRIMARY KEY (`rightrowid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uid` (`uid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
