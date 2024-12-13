-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2021 at 10:43 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vsmsatp`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `c_id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `cf_name` varchar(100) NOT NULL,
  `cl_name` varchar(100) NOT NULL,
  `c_email` varchar(100) NOT NULL,
  `c_mobile` varchar(100) NOT NULL,
  `nid` varchar(100) DEFAULT NULL,
  `w_start` date NOT NULL,
  `w_end` date NOT NULL,
  `payment_type` varchar(100) NOT NULL,
  `invoice_id` varchar(100) DEFAULT NULL,
  `c_address` varchar(400) DEFAULT NULL,
  `c_pass` varchar(30) NOT NULL,
  `extra` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`c_id`, `vehicle_id`, `cf_name`, `cl_name`, `c_email`, `c_mobile`, `nid`, `w_start`, `w_end`, `payment_type`, `invoice_id`, `c_address`, `c_pass`, `extra`) VALUES
(1, 25, 'John', 'Picard', 'picardjohn@gmail.com', '7800012695', NULL, '2021-05-04', '2023-05-04', 'Cash', NULL, NULL, '1234', NULL),
(2, 20, 'Will', 'Williams', 'williams58@gmail.com', '7014562222', NULL, '2021-05-04', '2023-05-04', 'Cheque', NULL, NULL, '1234', NULL),
(4, 22, 'Gareth', 'Brown', 'gareth85@gmail.com', '6580112650', NULL, '2021-05-04', '2023-05-09', 'Wire Transfer', NULL, NULL, '1234', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `manufacturers`
--

CREATE TABLE `manufacturers` (
  `id` int(11) NOT NULL,
  `manufacturer_name` varchar(255) NOT NULL,
  `manufacturer_logo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `manufacturers`
--

INSERT INTO `manufacturers` (`id`, `manufacturer_name`, `manufacturer_logo`) VALUES
(16, 'Volkswagen AG', ''),
(18, 'BMW Group', ''),
(19, 'Mercedes-Benz', ''),
(20, 'Ford', ''),
(22, 'Audi', ''),
(23, 'Chevrolet', ''),
(24, 'Toyota', ''),
(25, 'MG Motors', ''),
(26, 'Tesla', '');

-- --------------------------------------------------------

--
-- Table structure for table `models`
--

CREATE TABLE `models` (
  `id` int(11) NOT NULL,
  `manufacturer_id` int(11) NOT NULL,
  `model_name` varchar(255) NOT NULL,
  `model_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `models`
--

INSERT INTO `models` (`id`, `manufacturer_id`, `model_name`, `model_description`) VALUES
(14, 23, 'Impala LT', 'The Chevrolet Impala is a full-size car built by Chevrolet for model years 1958 to 1985, 1994 to 1996, and 2000 until 2020. The Impala was Chevrolet\'s popular flagship passenger car and was among the better selling American-made automobiles in the United States.'),
(15, 19, 'Mercedes-AMG C63', 'The number of high-performance SUVs is growing every year, but if you’re on the market for a compact car that can blow away almost everything else on the road look no further than the 2021 Mercedes-AMG C63. It’s based on the Mercedes-Benz C-class, but has a twin-turbocharged V-8 engine making 469 horsepower in the C63 and 503 hp in the C63 S.'),
(16, 16, 'Golf GTI', 'When it comes to looks and performance, the Golf GTI is as sporty as it is distinctive. Delivering turbocharged acceleration wrapped in unmistakable style, it\'s flash—with a whole lot of substance.'),
(17, 18, 'X3', 'The BMW X3 is a compact luxury crossover SUV manufactured by German automaker BMW since 2003. Based on the BMW 3 Series or BMW CLAR platform, and now in its third generation, BMW markets the crossover as a Sports Activity Vehicle, the company\'s proprietary descriptor for its X-line of vehicles.'),
(18, 20, 'F-150 Raptor', 'When the road diverges, a true off-roader goes right down the middle. The 2021 F-150 Raptor is equipped to take on punishing terrain that would be off-limits to a conventional 4-wheeler. * Next Generation FOX™ shocks with Live Valve technology are the largest ever shocks on Raptor. The internal bypass technology features an electronic solenoid valve that provides active damping. Plus, the Raptor is available with massive 37\" BFGoodrich® All Terrain T/A® KO2 tires.'),
(19, 22, 'A6', 'The Audi A6 is an executive car made by the German automaker Audi. ... All generations of the A6 have offered either front-wheel-drive or Torsen-based four-wheel-drive, marketed by Audi as their quattro system. The A6 has also been used as the basis for the company\'s Allroad models since 1999.'),
(20, 25, 'MG 6', 'The MG 6 is a compact car which has been produced by the British automotive manufacturer MG Motor since 2010. It is slotted slightly above the compact sedan MG GT, and the compact hatchback MG 5.'),
(21, 18, 'BMW 4 Series', 'The BMW 4 Series is a range of compact executive cars manufactured by BMW since 2013. ... As per the equivalent 3 Series generations, the 4 Series\' drivetrain layout is rear-wheel drive or all-wheel drive (\"xDrive\"). The BMW M4 is the high-performance version of the 4 Series.'),
(22, 20, 'Mustang Mach 1 Premium', 'Hear the roar of a Mustang as the ground starts to tremble and your legs start to shake. As always, Mustang calls upon its performance roots with features for enhanced handling, high-powered engine options and classic Mustang design. New for 2021, the soul-stirring Mustang Mach 1 and Mach 1 Premium stand at the pinnacle of 5.0L performance. The completely customizable Mach 1 continues its legacy, engineered specifically for quick turns and spirited drives.'),
(23, 26, 'Model S', 'With the longest range and quickest acceleration of any electric vehicle in production, Model S Plaid is the highest performing sedan ever built.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `su` int(11) DEFAULT '0',
  `type` varchar(15) NOT NULL,
  `position` varchar(30) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(40) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `birthday` date NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `su`, `type`, `position`, `email`, `password`, `first_name`, `last_name`, `gender`, `birthday`, `mobile`, `address`) VALUES
(6, 1, 'admin', 'Super Admin', 'admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'John', 'Walker', 'male', '1985-10-15', '75400012250', '1632  George Street'),
(7, 1, 'employee', 'Finance', 'employee@gmail.com', 'fa5473530e4d1a5a1e1eb53d2fedb10c', 'Theressa', 'Jones', 'female', '1988-04-01', '6800003240', '1372  Diane Street, Los Angles'),
(8, 0, 'employee', 'Sales Manager', 'dannyjackson@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'Danny', 'Jackson', 'male', '1991-10-18', '6410223500', '557  Oakmound Drive, Chicago'),
(9, 0, 'employee', 'Customer Service Representativ', 'liammoore@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'Liam', 'Moore', 'male', '1992-02-14', '8520001240', '163  Williams Avenue, Backersfield'),
(10, 0, 'employee', 'HR Consultant', 'kathleenjdn@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'Kathleen', 'Jordan', 'female', '1989-12-02', '7560001269', '4783 Dale Avenue, Puyallup');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `vehicle_id` int(11) NOT NULL,
  `manufacturer_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `category` varchar(30) NOT NULL,
  `buying_price` double NOT NULL,
  `selling_price` double DEFAULT NULL,
  `mileage` int(11) NOT NULL,
  `color` varchar(15) NOT NULL,
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sold_date` datetime DEFAULT NULL,
  `status` varchar(40) NOT NULL DEFAULT 'available',
  `registration_year` int(4) NOT NULL,
  `insurance_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `gear` varchar(15) NOT NULL,
  `doors` int(11) NOT NULL,
  `seats` int(11) NOT NULL,
  `tank` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `engine_no` int(11) NOT NULL,
  `chesis_no` int(11) NOT NULL,
  `featured` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`vehicle_id`, `manufacturer_id`, `model_id`, `category`, `buying_price`, `selling_price`, `mileage`, `color`, `add_date`, `sold_date`, `status`, `registration_year`, `insurance_id`, `user_id`, `gear`, `doors`, `seats`, `tank`, `image`, `engine_no`, `chesis_no`, `featured`) VALUES
(16, 23, 14, 'Sedan', 5139600, NULL, 17, 'Black', '2021-05-02 18:15:00', NULL, 'available', 2020, 20369001, 6, 'auto', 4, 4, 70, 'chevroletimpala.JPG', 0, 2147483647, 1),
(17, 19, 15, 'Coupe', 8635580, NULL, 15, 'Pearl White', '2021-05-02 18:15:00', NULL, 'available', 2020, 45600010, 6, 'auto', 2, 2, 65, 'AMG-C-COUPE-MP-047.jpg', 0, 2147483647, 1),
(18, 16, 16, 'Compact', 4799575, NULL, 16, 'Dark Iron Metal', '2021-05-02 18:15:00', NULL, 'available', 2019, 30124500, 6, 'auto', 4, 4, 59, 'volkswagengolfgti.jpg', 0, 2147483647, 1),
(19, 18, 17, 'SUV', 9998000, NULL, 14, 'Metallic Gray', '2021-05-02 18:15:00', NULL, 'available', 2019, 13000250, 6, 'auto', 4, 5, 60, 'bmw_x3.jpg', 0, 2147483647, 1),
(20, 20, 18, 'Pickup-Truck', 5945160, 9965400, 15, 'Blue', '2021-05-02 18:15:00', '2021-05-04 00:00:00', 'sold', 2020, 40562100, 6, 'auto', 4, 5, 98, 'f150-raptorford.jpg', 0, 2147483647, 1),
(21, 22, 19, 'Sedan', 9665000, NULL, 14, 'Pearl White', '2021-05-02 18:15:00', NULL, 'available', 2020, 14580001, 6, 'auto', 4, 5, 65, 'audia6.jpg', 0, 2147483647, 1),
(22, 25, 20, 'Compact', 3968000, 6185600, 13, 'Red', '2021-05-03 18:15:00', '2021-05-04 00:00:00', 'sold', 2020, 80124003, 6, 'manual', 4, 5, 62, 'mg6.jpg', 0, 2147483647, 1),
(23, 18, 21, 'Coupe', 7261250, NULL, 14, 'Navy Blue', '2021-05-03 18:15:00', NULL, 'available', 2019, 14590000, 6, 'auto', 2, 2, 57, 'BMW4Series.jpg', 0, 2147483647, 1),
(24, 20, 22, 'Sedan', 9745781, NULL, 11, 'Silver', '2021-05-03 18:15:00', NULL, 'available', 2021, 10236870, 6, 'auto', 2, 4, 50, 'fmustangmach1.jpg', 0, 2147483647, 1),
(25, 26, 23, 'Sedan', 9863500, 12150000, 646, 'Pearl White', '2021-05-03 18:15:00', '2021-05-04 00:00:00', 'sold', 2020, 64500025, 6, 'auto', 4, 4, 0, 'teslams.jpg', 0, 2147483647, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`c_id`),
  ADD UNIQUE KEY `v_id_2` (`vehicle_id`),
  ADD UNIQUE KEY `c_id` (`c_id`),
  ADD UNIQUE KEY `invoice_id` (`invoice_id`),
  ADD KEY `v_id` (`vehicle_id`),
  ADD KEY `c_id_2` (`c_id`);

--
-- Indexes for table `manufacturers`
--
ALTER TABLE `manufacturers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`vehicle_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `manufacturers`
--
ALTER TABLE `manufacturers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `models`
--
ALTER TABLE `models`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `vehicle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `fk` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`vehicle_id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
