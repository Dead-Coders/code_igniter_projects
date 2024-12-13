-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2021 at 04:00 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `courierci`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_addresses`
--

CREATE TABLE `tbl_addresses` (
  `id` bigint(255) NOT NULL,
  `address` text NOT NULL,
  `telephone` varchar(255) NOT NULL DEFAULT '0',
  `town` varchar(255) NOT NULL DEFAULT '0',
  `country_id` bigint(255) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Addresses';

--
-- Dumping data for table `tbl_addresses`
--

INSERT INTO `tbl_addresses` (`id`, `address`, `telephone`, `town`, `country_id`) VALUES
(1, '', '0726503228', '0', 111),
(2, '', '0726503228', '0', 111),
(3, '', '0726503228', '0', 111),
(4, '', '0726503228', '0', 111),
(5, '', '0726503228', '0', 111),
(6, '', '0726503228', '0', 111),
(7, '', '0726503228', '0', 111),
(8, '', '8972309809823', '0', 111),
(9, '', '8972309809823', '0', 111),
(10, '', '0726503228', '', 1),
(11, '', '0726503228', '', 1),
(12, '', '0726503228', '', 1),
(13, '', '0726503228', '', 1),
(14, '124234', '0728878544', '', 111),
(15, '432423', '0717550203', '', 111),
(16, '', '0723043888', '', 111),
(17, '', '0700189056', '', 111),
(18, '1599-40200', '0723043888', '', 111),
(19, '97897-80100', '0700189056', '', 111),
(20, '22123', '0723043888', '', 111),
(21, '24124', '0722853014', 'MOMBASA', 111),
(22, '', '0723043888', '', 111),
(23, '', '0700189056', 'MOMBASA', 111),
(24, '7145 DEMO ADDRESS', '741025896', '', 1),
(25, '777 DEMO AD2', '741258555', 'ALLACE AVENUE', 1),
(26, 'TEST ADDRESS', '170000220', '', 1),
(27, 'TEST R ADDRESS', '1780002145', 'DEMO CITY', 1),
(28, '4062 COOKS MINE ROAD', '0258965555', '', 1),
(29, '1248 TERRA STREET', '0147896555', 'OLYMPIA', 1),
(30, '1702 WILLISON STREET', '0255555555', '', 1),
(31, '4881 WALNUT DRIVE', '0214558555', 'PRENTICE', 1),
(32, '2949 SPRUCE DRIVE', '0125655555', '', 1),
(33, '173 CEMETERY STREET', '0256999999', 'HOUSTON', 1),
(34, '3483 TEA BERRY LANE', '0125888888', '', 1),
(35, '1798 FAIRWAY DRIVE', '0125444450', 'UKIAH', 1),
(36, '3369 MAYO STREET', '0255555560', '', 1),
(37, '3284 PASSAIC STREET', '0145630000', 'CHANTILLY', 1),
(38, '1559 STOCKERT HOLLOW ROAD', '0124555580', '', 1),
(39, '1177 BLEK ROAD', '0125555554', 'HARRISBURG', 1),
(40, '881 WEST FORK STREET', '0145552120', '', 1),
(41, '3749 BOONE CROCKETT LANE', '0785000000', 'LACEY', 1),
(42, '809 BROOKSIDE DRIVE', '7501114500', '', 1),
(43, '2240 WASHINGTON STREET', '0125658960', 'BEEVILLE', 1),
(44, '1627 DEMO ADDRESS', '7250000014', '', 1),
(45, '1669 DEMO ADDRESS', '7896540000', 'DEMO CITY NAME', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_countries`
--

CREATE TABLE `tbl_countries` (
  `id` bigint(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_countries`
--

INSERT INTO `tbl_countries` (`id`, `code`, `name`) VALUES
(1, 'US', 'United States'),
(2, 'CA', 'Canada'),
(3, 'AF', 'Afghanistan'),
(4, 'AL', 'Albania'),
(5, 'DZ', 'Algeria'),
(6, 'DS', 'American Samoa'),
(7, 'AD', 'Andorra'),
(8, 'AO', 'Angola'),
(9, 'AI', 'Anguilla'),
(10, 'AQ', 'Antarctica'),
(11, 'AG', 'Antigua and/or Barbuda'),
(12, 'AR', 'Argentina'),
(13, 'AM', 'Armenia'),
(14, 'AW', 'Aruba'),
(15, 'AU', 'Australia'),
(16, 'AT', 'Austria'),
(17, 'AZ', 'Azerbaijan'),
(18, 'BS', 'Bahamas'),
(19, 'BH', 'Bahrain'),
(20, 'BD', 'Bangladesh'),
(21, 'BB', 'Barbados'),
(22, 'BY', 'Belarus'),
(23, 'BE', 'Belgium'),
(24, 'BZ', 'Belize'),
(25, 'BJ', 'Benin'),
(26, 'BM', 'Bermuda'),
(27, 'BT', 'Bhutan'),
(28, 'BO', 'Bolivia'),
(29, 'BA', 'Bosnia and Herzegovina'),
(30, 'BW', 'Botswana'),
(31, 'BV', 'Bouvet Island'),
(32, 'BR', 'Brazil'),
(33, 'IO', 'British lndian Ocean Territory'),
(34, 'BN', 'Brunei Darussalam'),
(35, 'BG', 'Bulgaria'),
(36, 'BF', 'Burkina Faso'),
(37, 'BI', 'Burundi'),
(38, 'KH', 'Cambodia'),
(39, 'CM', 'Cameroon'),
(40, 'CV', 'Cape Verde'),
(41, 'KY', 'Cayman Islands'),
(42, 'CF', 'Central African Republic'),
(43, 'TD', 'Chad'),
(44, 'CL', 'Chile'),
(45, 'CN', 'China'),
(46, 'CX', 'Christmas Island'),
(47, 'CC', 'Cocos (Keeling) Islands'),
(48, 'CO', 'Colombia'),
(49, 'KM', 'Comoros'),
(50, 'CG', 'Congo'),
(51, 'CK', 'Cook Islands'),
(52, 'CR', 'Costa Rica'),
(53, 'HR', 'Croatia (Hrvatska)'),
(54, 'CU', 'Cuba'),
(55, 'CY', 'Cyprus'),
(56, 'CZ', 'Czech Republic'),
(57, 'DK', 'Denmark'),
(58, 'DJ', 'Djibouti'),
(59, 'DM', 'Dominica'),
(60, 'DO', 'Dominican Republic'),
(61, 'TP', 'East Timor'),
(62, 'EC', 'Ecudaor'),
(63, 'EG', 'Egypt'),
(64, 'SV', 'El Salvador'),
(65, 'GQ', 'Equatorial Guinea'),
(66, 'ER', 'Eritrea'),
(67, 'EE', 'Estonia'),
(68, 'ET', 'Ethiopia'),
(69, 'FK', 'Falkland Islands (Malvinas)'),
(70, 'FO', 'Faroe Islands'),
(71, 'FJ', 'Fiji'),
(72, 'FI', 'Finland'),
(73, 'FR', 'France'),
(74, 'FX', 'France, Metropolitan'),
(75, 'GF', 'French Guiana'),
(76, 'PF', 'French Polynesia'),
(77, 'TF', 'French Southern Territories'),
(78, 'GA', 'Gabon'),
(79, 'GM', 'Gambia'),
(80, 'GE', 'Georgia'),
(81, 'DE', 'Germany'),
(82, 'GH', 'Ghana'),
(83, 'GI', 'Gibraltar'),
(84, 'GR', 'Greece'),
(85, 'GL', 'Greenland'),
(86, 'GD', 'Grenada'),
(87, 'GP', 'Guadeloupe'),
(88, 'GU', 'Guam'),
(89, 'GT', 'Guatemala'),
(90, 'GN', 'Guinea'),
(91, 'GW', 'Guinea-Bissau'),
(92, 'GY', 'Guyana'),
(93, 'HT', 'Haiti'),
(94, 'HM', 'Heard and Mc Donald Islands'),
(95, 'HN', 'Honduras'),
(96, 'HK', 'Hong Kong'),
(97, 'HU', 'Hungary'),
(98, 'IS', 'Iceland'),
(99, 'IN', 'India'),
(100, 'ID', 'Indonesia'),
(101, 'IR', 'Iran (Islamic Republic of)'),
(102, 'IQ', 'Iraq'),
(103, 'IE', 'Ireland'),
(104, 'IL', 'Israel'),
(105, 'IT', 'Italy'),
(106, 'CI', 'Ivory Coast'),
(107, 'JM', 'Jamaica'),
(108, 'JP', 'Japan'),
(109, 'JO', 'Jordan'),
(110, 'KZ', 'Kazakhstan'),
(111, 'KE', 'Kenya'),
(112, 'KI', 'Kiribati'),
(113, 'KP', 'Korea, Democratic People\'s Republic of'),
(114, 'KR', 'Korea, Republic of'),
(115, 'KW', 'Kuwait'),
(116, 'KG', 'Kyrgyzstan'),
(117, 'LA', 'Lao People\'s Democratic Republic'),
(118, 'LV', 'Latvia'),
(119, 'LB', 'Lebanon'),
(120, 'LS', 'Lesotho'),
(121, 'LR', 'Liberia'),
(122, 'LY', 'Libyan Arab Jamahiriya'),
(123, 'LI', 'Liechtenstein'),
(124, 'LT', 'Lithuania'),
(125, 'LU', 'Luxembourg'),
(126, 'MO', 'Macau'),
(127, 'MK', 'Macedonia'),
(128, 'MG', 'Madagascar'),
(129, 'MW', 'Malawi'),
(130, 'MY', 'Malaysia'),
(131, 'MV', 'Maldives'),
(132, 'ML', 'Mali'),
(133, 'MT', 'Malta'),
(134, 'MH', 'Marshall Islands'),
(135, 'MQ', 'Martinique'),
(136, 'MR', 'Mauritania'),
(137, 'MU', 'Mauritius'),
(138, 'TY', 'Mayotte'),
(139, 'MX', 'Mexico'),
(140, 'FM', 'Micronesia, Federated States of'),
(141, 'MD', 'Moldova, Republic of'),
(142, 'MC', 'Monaco'),
(143, 'MN', 'Mongolia'),
(144, 'MS', 'Montserrat'),
(145, 'MA', 'Morocco'),
(146, 'MZ', 'Mozambique'),
(147, 'MM', 'Myanmar'),
(148, 'NA', 'Namibia'),
(149, 'NR', 'Nauru'),
(150, 'NP', 'Nepal'),
(151, 'NL', 'Netherlands'),
(152, 'AN', 'Netherlands Antilles'),
(153, 'NC', 'New Caledonia'),
(154, 'NZ', 'New Zealand'),
(155, 'NI', 'Nicaragua'),
(156, 'NE', 'Niger'),
(157, 'NG', 'Nigeria'),
(158, 'NU', 'Niue'),
(159, 'NF', 'Norfork Island'),
(160, 'MP', 'Northern Mariana Islands'),
(161, 'NO', 'Norway'),
(162, 'OM', 'Oman'),
(163, 'PK', 'Pakistan'),
(164, 'PW', 'Palau'),
(165, 'PA', 'Panama'),
(166, 'PG', 'Papua New Guinea'),
(167, 'PY', 'Paraguay'),
(168, 'PE', 'Peru'),
(169, 'PH', 'Philippines'),
(170, 'PN', 'Pitcairn'),
(171, 'PL', 'Poland'),
(172, 'PT', 'Portugal'),
(173, 'PR', 'Puerto Rico'),
(174, 'QA', 'Qatar'),
(175, 'RE', 'Reunion'),
(176, 'RO', 'Romania'),
(177, 'RU', 'Russian Federation'),
(178, 'RW', 'Rwanda'),
(179, 'KN', 'Saint Kitts and Nevis'),
(180, 'LC', 'Saint Lucia'),
(181, 'VC', 'Saint Vincent and the Grenadines'),
(182, 'WS', 'Samoa'),
(183, 'SM', 'San Marino'),
(184, 'ST', 'Sao Tome and Principe'),
(185, 'SA', 'Saudi Arabia'),
(186, 'SN', 'Senegal'),
(187, 'SC', 'Seychelles'),
(188, 'SL', 'Sierra Leone'),
(189, 'SG', 'Singapore'),
(190, 'SK', 'Slovakia'),
(191, 'SI', 'Slovenia'),
(192, 'SB', 'Solomon Islands'),
(193, 'SO', 'Somalia'),
(194, 'ZA', 'South Africa'),
(195, 'GS', 'South Georgia South Sandwich Islands'),
(196, 'ES', 'Spain'),
(197, 'LK', 'Sri Lanka'),
(198, 'SH', 'St. Helena'),
(199, 'PM', 'St. Pierre and Miquelon'),
(200, 'SD', 'Sudan'),
(201, 'SR', 'Suriname'),
(202, 'SJ', 'Svalbarn and Jan Mayen Islands'),
(203, 'SZ', 'Swaziland'),
(204, 'SE', 'Sweden'),
(205, 'CH', 'Switzerland'),
(206, 'SY', 'Syrian Arab Republic'),
(207, 'TW', 'Taiwan'),
(208, 'TJ', 'Tajikistan'),
(209, 'TZ', 'Tanzania, United Republic of'),
(210, 'TH', 'Thailand'),
(211, 'TG', 'Togo'),
(212, 'TK', 'Tokelau'),
(213, 'TO', 'Tonga'),
(214, 'TT', 'Trinidad and Tobago'),
(215, 'TN', 'Tunisia'),
(216, 'TR', 'Turkey'),
(217, 'TM', 'Turkmenistan'),
(218, 'TC', 'Turks and Caicos Islands'),
(219, 'TV', 'Tuvalu'),
(220, 'UG', 'Uganda'),
(221, 'UA', 'Ukraine'),
(222, 'AE', 'United Arab Emirates'),
(223, 'GB', 'United Kingdom'),
(224, 'UM', 'United States minor outlying islands'),
(225, 'UY', 'Uruguay'),
(226, 'UZ', 'Uzbekistan'),
(227, 'VU', 'Vanuatu'),
(228, 'VA', 'Vatican City State'),
(229, 'VE', 'Venezuela'),
(230, 'VN', 'Vietnam'),
(231, 'VG', 'Virigan Islands (British)'),
(232, 'VI', 'Virgin Islands (U.S.)'),
(233, 'WF', 'Wallis and Futuna Islands'),
(234, 'EH', 'Western Sahara'),
(235, 'YE', 'Yemen'),
(236, 'YU', 'Yugoslavia'),
(237, 'ZR', 'Zaire'),
(238, 'ZM', 'Zambia'),
(239, 'ZW', 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_destinations`
--

CREATE TABLE `tbl_destinations` (
  `id` bigint(255) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `country_id` bigint(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Courier Destinations';

--
-- Dumping data for table `tbl_destinations`
--

INSERT INTO `tbl_destinations` (`id`, `name`, `description`, `country_id`) VALUES
(1, 'SEATTLE', 'NONE', 1),
(2, 'CHICAGO', 'NONE', 1),
(6, 'NEW YORK', 'NONE', 1),
(7, 'OFF2', 'NONE', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_messages`
--

CREATE TABLE `tbl_messages` (
  `id` bigint(255) NOT NULL,
  `parcel_status_id` bigint(255) NOT NULL,
  `to_sender` text NOT NULL,
  `to_receiver` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_messages`
--

INSERT INTO `tbl_messages` (`id`, `parcel_status_id`, `to_sender`, `to_receiver`) VALUES
(1, 1, 'GOOD DAY <%=NAME=%>. YOUR PARCEL HAS BEEN RECEIVED AND WILL BE SHIPPED. THE CONSIGNMENT NO. IS <%=CONSIGNMENT_NO=%>', 'GOOD DAY <%=NAME=%>. A PARCEL FOR YOU WILL BE SHIPPED. THE CONSIGNMENT NO. IS <%=CONSIGNMENT_NO=%>'),
(2, 2, 'GOOD DAY <%=NAME=%>. YOUR PARCEL TO DESTINATION HAS BEEN DISPATCHED', 'GOOD DAY <%=NAME=%>. YOUR PARCEL FROM SOURCE HAS BEEN DISPATCHED'),
(3, 3, 'GOOD DAY <%=NAME=%>. YOUR PARCEL TO DESTINATION HAS BEEN PLACED ON HOLD ON SECURITY GROUNDS', 'GOOD DAY <%=NAME=%>. YOUR PARCEL FROM SOURCE HAS BEEN PLACED ON HOLD ON SECURITY GROUNDS'),
(4, 4, 'GOOD DAY <%=NAME=%>. YOUR PARCEL TO DESTINATION HAS BEEN DELAYED', 'GOOD DAY <%=NAME=%>. YOUR PARCEL FROM SOURCE HAS BEEN DISPATCHED'),
(5, 5, 'GOOD DAY <%=NAME=%>. YOUR PARCEL TO DESTINATION HAS LANDED', 'GOOD DAY <%=NAME=%>. YOUR PARCEL FROM SOURCE HAS LANDED. PLEASE COLLECT IT ASAP.'),
(6, 6, 'GOOD DAY <%=NAME=%>. YOUR PARCEL TO DESTINATION HAS BEEN DELIVERED', 'GOOD DAY <%=NAME=%>. THANK YOU FOR USING OUR SERVICES.');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_outbox`
--

CREATE TABLE `tbl_outbox` (
  `id` bigint(255) NOT NULL,
  `to` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_outbox`
--

INSERT INTO `tbl_outbox` (`id`, `to`, `message`, `datetime`) VALUES
(1, '+254726503228,', 'AFDFD', '2014-09-03 08:00:16'),
(2, '+254726503228,', 'ADFDFD', '2014-09-03 08:00:18'),
(3, '+254728878544', 'YOUR GOODS HAVE BEEN RECEIVED AND READY FOR DISPATCH-MEX COURIER', '2014-09-03 13:44:43'),
(4, '+254728878544', 'WE HAVE RECEIVED YOUR PARCEL FROM VICTOR WE SHALL NOTIFY WHEN READY TO COLLECT', '2014-09-03 13:44:43'),
(5, '+254728878544', 'THANK YOU VICTOR, YOUR GOODS FOR JAMES ARE ON TRANSIT TO NAIROBI, - MEX COURIER.', '2014-09-03 15:22:42'),
(6, '+254728878544', 'JAMBO JAMES WE YOUR GOODS FROM VICTOR ARE ON TRANSIT WE SHALL NOTIFY WHEN TO COLLECT -MEX COURIER', '2014-09-03 15:22:42'),
(7, '+254723043888', 'HELLO OBED YOUR GOODS FOR GABRIEL ARE READY FOR FOR TRANSIT-MEX COURIER\n', '2014-09-03 15:27:57'),
(8, '+254723043888', 'JAMBO GABRIEL- WE WILL NOTIFY YOU WHEN YOUR GOODS FRM OBED R READY TO COLLECT -MEX COURIER', '2014-09-03 15:27:57'),
(9, '+254723043888', 'TEST ', '2014-09-10 11:46:36'),
(10, '+254723043888', 'TEST 2', '2014-09-10 11:46:36'),
(11, '+254723043888', 'MESSAGE TO SENDER', '2014-09-10 11:58:24'),
(12, '+254700189056', 'MESSAGE TO RECEIVER', '2014-09-10 11:58:25'),
(13, '+254723043888', 'TEST SENDER', '2014-09-10 12:04:06'),
(14, '+254722853014', 'TEST RECEIVER', '2014-09-10 12:04:07'),
(15, '+254723043888', 'GOOD DAY OBED MICHIEKA. YOUR PARCEL TO DESTINATION HAS BEEN DISPATCHED', '2014-09-11 19:52:30'),
(16, '+254700189056', 'GOOD DAY GABRIEL OCHIENG. YOUR PARCEL FROM SOURCE HAS BEEN DISPATCHED', '2014-09-11 19:52:31'),
(17, '+254723043888', 'GOOD DAY OBED MICHIEKA. YOUR PARCEL TO DESTINATION HAS BEEN DELIVERED', '2014-09-11 19:54:12'),
(18, '+254700189056', 'GOOD DAY GABRIEL OCHIENG. THANK YOU FOR USING OUR SERVICES.', '2014-09-11 19:54:13');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_parcels`
--

CREATE TABLE `tbl_parcels` (
  `id` bigint(255) NOT NULL,
  `consignment_no` varchar(255) NOT NULL DEFAULT '0',
  `create_date` datetime NOT NULL,
  `sender_id` bigint(255) NOT NULL DEFAULT '0',
  `receiver_id` bigint(255) NOT NULL DEFAULT '0',
  `parcel_type_id` bigint(255) NOT NULL DEFAULT '0',
  `quantity` int(11) NOT NULL DEFAULT '0',
  `weight` double NOT NULL DEFAULT '0',
  `amount` double NOT NULL DEFAULT '0',
  `payment_type_id` bigint(255) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `origin_id` bigint(255) NOT NULL,
  `destination_id` bigint(255) NOT NULL,
  `transport_mode_id` bigint(255) NOT NULL DEFAULT '0',
  `invoice_no` varchar(255) NOT NULL,
  `departure_date` datetime NOT NULL,
  `parcel_status_id` bigint(255) NOT NULL,
  `batch_no` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Parcels';

--
-- Dumping data for table `tbl_parcels`
--

INSERT INTO `tbl_parcels` (`id`, `consignment_no`, `create_date`, `sender_id`, `receiver_id`, `parcel_type_id`, `quantity`, `weight`, `amount`, `payment_type_id`, `description`, `origin_id`, `destination_id`, `transport_mode_id`, `invoice_no`, `departure_date`, `parcel_status_id`, `batch_no`) VALUES
(2, '6GUMBJI628', '2014-08-21 00:00:00', 3, 3, 1, 1, 10, 0, 1, 'ADFADFASDF', 1, 6, 1, '', '2014-08-21 00:00:00', 6, '2014-08-21'),
(3, '36R8D8OOIM', '2014-08-21 08:29:19', 4, 4, 1, 1, 10, 0, 1, '', 1, 6, 1, '', '2014-08-21 00:00:00', 6, '2014-08-21'),
(6, 'DHI72J53HV', '2014-09-03 13:38:37', 7, 7, 1, 3, 2, 4000, 1, 'YOUR GOODS HAVE BEEN RECEIVED AND ARE READY FOR DISPATCH - MEX COURIER SERVICE', 2, 1, 2, '', '0000-00-00 00:00:00', 6, '03-09-2014'),
(9, 'SSGRQVHGZL', '2014-09-10 12:03:16', 10, 10, 1, 3, 0, 2500, 1, 'TEST', 2, 1, 1, '4', '0000-00-00 00:00:00', 5, '10-09-2014'),
(10, '7SP9X0DXQW', '2014-09-11 19:51:39', 11, 11, 1, 0, 0, 0, 1, '', 2, 2, 1, '', '0000-00-00 00:00:00', 6, '11-09-2014'),
(11, '4SD4WE4F20', '2021-06-25 18:03:03', 12, 12, 4, 2, 2, 355, 1, 'NONE', 2, 6, 1, '1355', '2020-02-02 02:02:02', 6, '25-06-2021'),
(12, '5HZG90WQRS', '2021-10-02 12:26:03', 13, 13, 4, 5, 3, 120, 1, 'NONE', 2, 6, 1, '778520', '0000-00-00 00:00:00', 2, '02-10-2021'),
(13, '8JJ8CCNERM', '2021-10-02 16:01:54', 14, 14, 1, 95, 12, 50, 2, 'NONE', 2, 1, 2, '02365', '2021-10-02 08:50:00', 3, '02-10-2021'),
(14, 'B9L7GGDD1W', '2021-10-02 16:04:36', 15, 15, 1, 20, 5, 25, 2, 'NONE', 2, 6, 1, '55520', '2021-10-02 10:55:00', 2, '02-10-2021'),
(15, '6Q8CHKXUBI', '2021-10-02 18:30:35', 16, 16, 4, 3, 20, 130, 2, 'NONE', 2, 2, 1, '02333', '2021-10-03 11:15:00', 1, '02-10-2021'),
(16, 'YVNIF3NWKM', '2021-10-02 18:32:42', 17, 17, 1, 5, 3, 15, 1, 'NONE', 2, 2, 2, '01255', '2021-10-02 13:20:00', 3, '02-10-2021'),
(17, 'DNEIH3271Z', '2021-10-02 18:35:01', 18, 18, 4, 1, 15, 50, 2, 'NONE', 2, 1, 1, '55556', '2021-10-03 10:19:00', 1, '02-10-2021'),
(18, 'Z54HHABWDN', '2021-10-02 18:37:21', 19, 19, 1, 10, 10, 65, 2, 'NONE', 2, 2, 1, '12350', '2021-10-03 10:21:00', 5, '02-10-2021'),
(19, '7BHARXPH0O', '2021-10-02 18:39:44', 20, 20, 4, 10, 30, 350, 1, 'NONE', 2, 6, 1, '01478', '2021-10-02 10:24:00', 1, '02-10-2021'),
(20, 'UOPLV11R5I', '2021-10-02 18:51:29', 21, 21, 1, 10, 5, 20, 2, 'NONE', 2, 6, 1, '14500', '2021-10-02 22:36:00', 1, '02-10-2021'),
(21, '2MT5GKUAE1', '2021-10-02 19:02:24', 22, 22, 4, 10, 25, 213, 1, 'NONE', 6, 1, 1, '08960', '2021-10-02 11:30:00', 6, '02-10-2021');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_parcel_logs`
--

CREATE TABLE `tbl_parcel_logs` (
  `id` bigint(255) NOT NULL,
  `parcel_id` bigint(255) NOT NULL,
  `status_id` bigint(255) NOT NULL,
  `datetime` datetime NOT NULL,
  `description` text NOT NULL,
  `destination_id` bigint(255) NOT NULL,
  `user_id` bigint(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_parcel_logs`
--

INSERT INTO `tbl_parcel_logs` (`id`, `parcel_id`, `status_id`, `datetime`, `description`, `destination_id`, `user_id`) VALUES
(2, 3, 2, '2014-08-21 12:36:23', ' EDITED', 1, 1),
(33, 2, 1, '2014-08-25 02:44:59', '', 2, 1),
(34, 2, 2, '2014-08-31 19:16:01', 'THIS IS A SAMPLE MESSAGE', 2, 1),
(35, 2, 6, '2014-09-03 06:02:05', 'HJJKHJKH', 6, 1),
(36, 2, 1, '2014-09-03 06:04:33', 'ADFD', 1, 1),
(37, 3, 1, '2014-09-03 06:04:34', 'ADFD', 1, 1),
(38, 2, 6, '2014-09-03 06:04:56', 'DFADF', 6, 1),
(39, 3, 6, '2014-09-03 06:04:58', 'DFADF', 6, 1),
(43, 6, 1, '2014-09-03 13:38:37', 'RECEIVED AND READY FOR TRANSIT', 2, 1),
(44, 6, 2, '2014-09-03 13:44:43', '', 1, 1),
(45, 6, 1, '2014-09-03 15:22:41', '', 1, 1),
(51, 9, 1, '2014-09-10 12:03:16', 'RECEIVED AND READY FOR TRANSIT', 2, 1),
(52, 9, 2, '2014-09-10 12:04:05', '', 1, 1),
(53, 10, 1, '2014-09-11 19:51:39', 'RECEIVED AND READY FOR TRANSIT', 2, 1),
(54, 10, 2, '2014-09-11 19:52:28', 'TEST TEST', 1, 1),
(55, 10, 6, '2014-09-11 19:54:11', '', 2, 1),
(56, 11, 1, '2021-06-25 18:03:03', 'RECEIVED AND READY FOR TRANSIT', 2, 1),
(57, 11, 6, '2021-06-25 18:04:59', 'NONE', 6, 1),
(59, 12, 1, '2021-10-02 12:26:03', 'RECEIVED AND READY FOR TRANSIT', 2, 1),
(60, 12, 2, '2021-10-02 12:26:27', 'ON TRANSIT', 6, 1),
(62, 13, 1, '2021-10-02 16:01:54', 'RECEIVED AND READY FOR TRANSIT', 2, 1),
(63, 14, 1, '2021-10-02 16:04:36', 'RECEIVED AND READY FOR TRANSIT', 2, 1),
(64, 15, 1, '2021-10-02 18:30:35', 'RECEIVED AND READY FOR TRANSIT', 2, 1),
(65, 16, 1, '2021-10-02 18:32:42', 'RECEIVED AND READY FOR TRANSIT', 2, 1),
(66, 17, 1, '2021-10-02 18:35:01', 'RECEIVED AND READY FOR TRANSIT', 2, 1),
(67, 18, 1, '2021-10-02 18:37:21', 'RECEIVED AND READY FOR TRANSIT', 2, 1),
(68, 13, 3, '2021-10-02 18:37:45', 'NONE', 1, 1),
(69, 14, 2, '2021-10-02 18:37:56', 'NONE', 6, 1),
(70, 19, 1, '2021-10-02 18:39:44', 'RECEIVED AND READY FOR TRANSIT', 2, 1),
(71, 6, 6, '2021-10-02 18:42:30', 'DELIVERED!', 1, 1),
(72, 9, 5, '2021-10-02 18:42:44', 'NONE', 1, 1),
(73, 20, 1, '2021-10-02 18:51:29', 'RECEIVED AND READY FOR TRANSIT', 2, 8),
(74, 21, 1, '2021-10-02 19:02:24', 'RECEIVED AND READY FOR TRANSIT', 6, 8),
(75, 16, 3, '2021-10-02 19:03:00', 'NONE', 2, 8),
(76, 18, 4, '2021-10-02 19:03:14', 'DUE TO ****', 2, 8),
(77, 21, 3, '2021-10-02 19:03:45', 'NONE', 1, 8),
(78, 18, 5, '2021-10-02 19:09:22', 'NONE', 2, 8),
(79, 21, 2, '2021-10-02 19:09:43', 'NONE', 1, 8),
(80, 21, 5, '2021-10-02 19:13:06', 'LANDED SAFELY!', 1, 8),
(81, 21, 6, '2021-10-02 19:13:25', 'DELIVERED TO RECEIVER AT ****', 1, 8);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_parcel_statuses`
--

CREATE TABLE `tbl_parcel_statuses` (
  `id` bigint(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sender` tinyint(1) NOT NULL DEFAULT '0',
  `receiver` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_parcel_statuses`
--

INSERT INTO `tbl_parcel_statuses` (`id`, `name`, `sender`, `receiver`) VALUES
(1, 'TRANSIT READY', 1, 1),
(2, 'TRANSIT', 1, 1),
(3, 'ONHOLD', 1, 1),
(4, 'DELAYED', 1, 1),
(5, 'LANDED', 1, 1),
(6, 'DELIVERED', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_parcel_types`
--

CREATE TABLE `tbl_parcel_types` (
  `id` bigint(255) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '0',
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Parcel Types';

--
-- Dumping data for table `tbl_parcel_types`
--

INSERT INTO `tbl_parcel_types` (`id`, `name`, `description`) VALUES
(1, 'DOCUMENTS', 'DOCUMENTS'),
(4, 'PARCEL', 'PARCEL');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment_types`
--

CREATE TABLE `tbl_payment_types` (
  `id` bigint(255) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '0',
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Payment Types';

--
-- Dumping data for table `tbl_payment_types`
--

INSERT INTO `tbl_payment_types` (`id`, `name`, `description`) VALUES
(1, 'CASH', 'CASH'),
(2, 'A/C', 'A/C'),
(3, 'TO COLLECT', 'TO COLLECT');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pricelists`
--

CREATE TABLE `tbl_pricelists` (
  `id` bigint(255) NOT NULL,
  `source_id` bigint(255) NOT NULL,
  `parcel_type_id` bigint(255) NOT NULL,
  `min_weight` double NOT NULL,
  `amount` double NOT NULL,
  `destination_id` bigint(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_pricelists`
--

INSERT INTO `tbl_pricelists` (`id`, `source_id`, `parcel_type_id`, `min_weight`, `amount`, `destination_id`) VALUES
(1, 1, 1, 0, 200, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_receivers`
--

CREATE TABLE `tbl_receivers` (
  `id` bigint(255) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '0',
  `reference` varchar(255) NOT NULL DEFAULT '0',
  `address_id` bigint(255) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Receivers';

--
-- Dumping data for table `tbl_receivers`
--

INSERT INTO `tbl_receivers` (`id`, `name`, `reference`, `address_id`) VALUES
(1, 'TERESIAH GICHUKI', '32008464', 3),
(2, 'TERESIAH GICHUKI', '32008464', 5),
(3, 'TERESIAH GICHUKI', '32008464', 7),
(4, 'TERESIAH GICHUKI', '32008464', 9),
(5, 'TERESIAH GICHUKI', '32008464', 11),
(6, 'TERESIAH GICHUKI', '32008464', 13),
(7, 'NICK', '4234234', 15),
(8, 'GABRIEL OCHIENG', '24252342342', 17),
(9, 'GABRIEL OCHIENG', '43223243242', 19),
(10, 'SALEH', '243252456', 21),
(11, 'GABRIEL OCHIENG', '43223243242', 23),
(12, 'JOHN', '200000', 25),
(13, 'TEST RECEIVER', '00257669', 27),
(14, 'ANNY HENDRIX', '102256985001', 29),
(15, 'FERNANDO W GRIFFIN', '125688888889', 31),
(16, 'MARTIN HARDY', '102589666667', 33),
(17, 'TOM BOWER', '124589632501', 35),
(18, 'ELOISE P GIL', '124545454509', 37),
(19, 'STEPHEN D BARNETT', '885521215002', 39),
(20, 'TIFFANY W RENO', '147856000000', 41),
(21, 'CHAD R HAMILTON', '135666580010', 43),
(22, 'ELIZABETH D MCCURREY', '702560000080', 45);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_senders`
--

CREATE TABLE `tbl_senders` (
  `id` bigint(255) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '0',
  `reference` varchar(255) NOT NULL DEFAULT '0',
  `account_no` varchar(255) NOT NULL DEFAULT '0',
  `address_id` bigint(255) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Cargo Senders';

--
-- Dumping data for table `tbl_senders`
--

INSERT INTO `tbl_senders` (`id`, `name`, `reference`, `account_no`, `address_id`) VALUES
(1, 'BRIAN ITUR', '25246534', '', 2),
(2, 'BRIAN ITUR', '25246534', '', 4),
(3, 'BRIAN ITUR', '25246534', '', 6),
(4, 'TERESIAH GICHUKI', '654564564', '', 8),
(5, 'BRIAN ITUR', '25246534', '', 10),
(6, 'TERESIAH GICHUKI', '25246534', '', 12),
(7, 'VICTOR', '23234254235', '', 14),
(8, 'OBED MICHIEKA', '232342443', '04200434328', 16),
(9, 'OBED MICHIEKA', '2343525', '04200434328', 18),
(10, 'OBED MICHIEKA', '32343243', '142414214', 20),
(11, 'OBED MICHIEKA', '32343243', '04200434328', 22),
(12, 'THOMAS', '100000', '1313131313', 24),
(13, 'TEST SENDER', '10256600', '1478500000', 26),
(14, 'ROY RICHARDSON', '102256985000', '10000058', 28),
(15, 'DOROTHEA ZOLLINGER', '125688888888', '01455555', 30),
(16, 'TIMOTHY MACKIE', '102589666666', '14785214', 32),
(17, 'LINDA HICKS', '124589632500', '00002580', 34),
(18, 'STEVE C BRAZIEL', '124545454500', '02565580', 36),
(19, 'BENNETT S WAITE', '885521215000', '03655570', 38),
(20, 'GEORGINE W RODRIGUEZ', '147856000000', '88745000', 40),
(21, 'JOAN GOVER', '135666580012', '14520000', 42),
(22, 'GARY MONROE', '702560000012', '02585540', 44);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_services`
--

CREATE TABLE `tbl_services` (
  `id` bigint(255) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Courier Services';

-- --------------------------------------------------------

--
-- Table structure for table `tbl_settings`
--

CREATE TABLE `tbl_settings` (
  `id` bigint(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_settings`
--

INSERT INTO `tbl_settings` (`id`, `key`, `value`) VALUES
(1, 'company_name', 'MEX COURIER'),
(2, 'address', 'P.O BOX: 10111- 00100, NEW YORK USA'),
(3, 'telephone', '+1 01 0111100/1/2/3'),
(4, 'email', 'MEX@MEX.COM'),
(5, 'fax', '+1 11 1311369/1/2/3');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transport_modes`
--

CREATE TABLE `tbl_transport_modes` (
  `id` bigint(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_transport_modes`
--

INSERT INTO `tbl_transport_modes` (`id`, `name`, `description`) VALUES
(1, 'AIR', 'AIR'),
(2, 'ROAD', 'ROAD'),
(3, 'TRAIN', 'TRAIN'),
(4, 'SEA', 'SEA');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` bigint(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL DEFAULT '0',
  `password` varchar(255) NOT NULL DEFAULT '0',
  `destination_id` bigint(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `user_role_id` bigint(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Users';

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `name`, `username`, `password`, `destination_id`, `active`, `user_role_id`) VALUES
(1, 'ROBERT', 'robert', '21232f297a57a5a743894a0e4a801fc3', 2, 1, 2),
(7, 'LIAM', 'liam', '182835f609be410927ce21c85967ba1c', 1, 1, 1),
(8, 'WILLIAMS', 'admin', 'D00F5D5217896FB7FD601412CB890830', 6, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_roles`
--

CREATE TABLE `tbl_user_roles` (
  `id` bigint(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user_roles`
--

INSERT INTO `tbl_user_roles` (`id`, `name`, `description`) VALUES
(1, 'System Administrator', ''),
(2, 'Terminal User', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_addresses`
--
ALTER TABLE `tbl_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `country_id` (`country_id`);

--
-- Indexes for table `tbl_countries`
--
ALTER TABLE `tbl_countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `tbl_destinations`
--
ALTER TABLE `tbl_destinations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`,`country_id`),
  ADD KEY `country_id` (`country_id`);

--
-- Indexes for table `tbl_messages`
--
ALTER TABLE `tbl_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parcel_status_id` (`parcel_status_id`);

--
-- Indexes for table `tbl_outbox`
--
ALTER TABLE `tbl_outbox`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_parcels`
--
ALTER TABLE `tbl_parcels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `consignment_no` (`consignment_no`),
  ADD KEY `receiver_id` (`receiver_id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `parcel_type_id` (`parcel_type_id`),
  ADD KEY `payment_type_id` (`payment_type_id`),
  ADD KEY `destination_id` (`destination_id`),
  ADD KEY `origin_id` (`origin_id`),
  ADD KEY `transport_mode_id` (`transport_mode_id`),
  ADD KEY `parcel_status_id` (`parcel_status_id`);

--
-- Indexes for table `tbl_parcel_logs`
--
ALTER TABLE `tbl_parcel_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parcel_id` (`parcel_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `destination_id` (`destination_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_parcel_statuses`
--
ALTER TABLE `tbl_parcel_statuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `tbl_parcel_types`
--
ALTER TABLE `tbl_parcel_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `tbl_payment_types`
--
ALTER TABLE `tbl_payment_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `tbl_pricelists`
--
ALTER TABLE `tbl_pricelists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parcel_type_id` (`parcel_type_id`),
  ADD KEY `destination_id` (`destination_id`),
  ADD KEY `source_id` (`source_id`);

--
-- Indexes for table `tbl_receivers`
--
ALTER TABLE `tbl_receivers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `address_id` (`address_id`);

--
-- Indexes for table `tbl_senders`
--
ALTER TABLE `tbl_senders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `address_id` (`address_id`);

--
-- Indexes for table `tbl_services`
--
ALTER TABLE `tbl_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_transport_modes`
--
ALTER TABLE `tbl_transport_modes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `destination_id` (`destination_id`),
  ADD KEY `user_role_id` (`user_role_id`);

--
-- Indexes for table `tbl_user_roles`
--
ALTER TABLE `tbl_user_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_addresses`
--
ALTER TABLE `tbl_addresses`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `tbl_countries`
--
ALTER TABLE `tbl_countries`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;
--
-- AUTO_INCREMENT for table `tbl_destinations`
--
ALTER TABLE `tbl_destinations`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `tbl_messages`
--
ALTER TABLE `tbl_messages`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tbl_outbox`
--
ALTER TABLE `tbl_outbox`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `tbl_parcels`
--
ALTER TABLE `tbl_parcels`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `tbl_parcel_logs`
--
ALTER TABLE `tbl_parcel_logs`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;
--
-- AUTO_INCREMENT for table `tbl_parcel_statuses`
--
ALTER TABLE `tbl_parcel_statuses`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tbl_parcel_types`
--
ALTER TABLE `tbl_parcel_types`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_payment_types`
--
ALTER TABLE `tbl_payment_types`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_pricelists`
--
ALTER TABLE `tbl_pricelists`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_receivers`
--
ALTER TABLE `tbl_receivers`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `tbl_senders`
--
ALTER TABLE `tbl_senders`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `tbl_services`
--
ALTER TABLE `tbl_services`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tbl_transport_modes`
--
ALTER TABLE `tbl_transport_modes`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tbl_user_roles`
--
ALTER TABLE `tbl_user_roles`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_addresses`
--
ALTER TABLE `tbl_addresses`
  ADD CONSTRAINT `tbl_addresses_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `tbl_countries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_destinations`
--
ALTER TABLE `tbl_destinations`
  ADD CONSTRAINT `tbl_destinations_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `tbl_countries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_messages`
--
ALTER TABLE `tbl_messages`
  ADD CONSTRAINT `tbl_messages_ibfk_1` FOREIGN KEY (`parcel_status_id`) REFERENCES `tbl_parcel_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_parcels`
--
ALTER TABLE `tbl_parcels`
  ADD CONSTRAINT `FK_tbl_parcels_tbl_destinations` FOREIGN KEY (`origin_id`) REFERENCES `tbl_destinations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tbl_parcels_tbl_destinations_2` FOREIGN KEY (`destination_id`) REFERENCES `tbl_destinations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tbl_parcels_tbl_parcel_types` FOREIGN KEY (`parcel_type_id`) REFERENCES `tbl_parcel_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tbl_parcels_tbl_payment_types` FOREIGN KEY (`payment_type_id`) REFERENCES `tbl_payment_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tbl_parcels_tbl_receivers` FOREIGN KEY (`receiver_id`) REFERENCES `tbl_receivers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tbl_parcels_tbl_senders` FOREIGN KEY (`sender_id`) REFERENCES `tbl_senders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_parcels_ibfk_1` FOREIGN KEY (`transport_mode_id`) REFERENCES `tbl_transport_modes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_parcels_ibfk_2` FOREIGN KEY (`parcel_status_id`) REFERENCES `tbl_parcel_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_parcel_logs`
--
ALTER TABLE `tbl_parcel_logs`
  ADD CONSTRAINT `tbl_parcel_logs_ibfk_1` FOREIGN KEY (`parcel_id`) REFERENCES `tbl_parcels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_parcel_logs_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `tbl_parcel_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_parcel_logs_ibfk_3` FOREIGN KEY (`destination_id`) REFERENCES `tbl_destinations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_parcel_logs_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_pricelists`
--
ALTER TABLE `tbl_pricelists`
  ADD CONSTRAINT `tbl_pricelists_ibfk_1` FOREIGN KEY (`parcel_type_id`) REFERENCES `tbl_parcel_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_pricelists_ibfk_2` FOREIGN KEY (`destination_id`) REFERENCES `tbl_destinations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_pricelists_ibfk_3` FOREIGN KEY (`source_id`) REFERENCES `tbl_destinations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_receivers`
--
ALTER TABLE `tbl_receivers`
  ADD CONSTRAINT `FK_tbl_receivers_tbl_addresses` FOREIGN KEY (`address_id`) REFERENCES `tbl_addresses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_senders`
--
ALTER TABLE `tbl_senders`
  ADD CONSTRAINT `FK_tbl_senders_tbl_addresses` FOREIGN KEY (`address_id`) REFERENCES `tbl_addresses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD CONSTRAINT `FK_tbl_users_tbl_destinations` FOREIGN KEY (`destination_id`) REFERENCES `tbl_destinations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_users_ibfk_1` FOREIGN KEY (`user_role_id`) REFERENCES `tbl_user_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
