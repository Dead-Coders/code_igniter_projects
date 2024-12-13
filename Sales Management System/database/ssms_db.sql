-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2022 at 07:53 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `ssms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblcategories`
--

CREATE TABLE `tblcategories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblcategories`
--

INSERT INTO `tblcategories` (`category_id`, `category_name`, `created_at`, `updated_at`) VALUES
(1, 'Drug', '2016-10-01 00:00:00', '2021-06-17 16:01:55'),
(2, 'Skin Care', '2016-10-01 00:00:00', '2021-06-17 16:01:59'),
(3, 'Office Supplies', '2021-05-12 11:11:56', '2021-06-17 16:00:45'),
(4, 'Fragrance', '2021-06-17 18:02:15', '0000-00-00 00:00:00'),
(5, 'Nutrition', '2021-06-17 19:34:48', '0000-00-00 00:00:00'),
(6, 'Category 101', '2022-07-02 05:31:24', '2022-07-02 03:47:45');

-- --------------------------------------------------------

--
-- Table structure for table `tblorders`
--

CREATE TABLE `tblorders` (
  `order_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `order_details` text NOT NULL,
  `order_total` double NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `order_number` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblorders`
--

INSERT INTO `tblorders` (`order_id`, `customer_name`, `order_details`, `order_total`, `created_at`, `updated_at`, `order_number`) VALUES
(6, 'Cassey', '[{\"product_id\":\"64\",\"product_price\":\"24.15\",\"qty\":\"6\"}]', 144.9, '2021-06-17 18:17:14', '2021-06-17 16:17:32', 'CA_80697'),
(8, 'Jimmy Williams', '[{\"product_id\":\"82\",\"product_price\":\"28.46\",\"qty\":\"7\"},{\"product_id\":\"1\",\"product_price\":\"24\",\"qty\":\"3\"},{\"product_id\":\"81\",\"product_price\":\"24\",\"qty\":\"4\"}]', 367.22, '2021-06-17 19:38:05', '2021-06-17 17:38:05', 'CA_40317'),
(9, 'John Cordero', '[{\"product_id\":\"9\",\"product_price\":\"21.99\",\"qty\":\"13\"},{\"product_id\":\"71\",\"product_price\":\"4.19\",\"qty\":\"5\"},{\"product_id\":\"77\",\"product_price\":\"16\",\"qty\":\"10\"},{\"product_id\":\"80\",\"product_price\":\"79\",\"qty\":\"1\"},{\"product_id\":\"75\",\"product_price\":\"32\",\"qty\":\"6\"}]', 737.82, '2021-06-17 19:39:49', '2021-06-17 17:39:49', 'CA_78164'),
(10, 'Mark Cooper', '[{\"product_id\":\"83\",\"product_price\":\"125\",\"qty\":\"1\"},{\"product_id\":\"3\",\"product_price\":\"34\",\"qty\":\"2\"},{\"product_id\":\"6\",\"product_price\":\"43\",\"qty\":\"3\"},{\"product_id\":\"21\",\"product_price\":\"55\",\"qty\":\"4\"},{\"product_id\":\"30\",\"product_price\":\"21\",\"qty\":\"5\"},{\"product_id\":\"69\",\"product_price\":\"28.59\",\"qty\":\"6\"}]', 818.54, '2022-07-02 05:52:45', '2022-07-02 03:52:45', 'CA_27160'),
(11, 'Sample Customer', '[{\"product_id\":\"83\",\"product_price\":\"125\",\"qty\":\"1\"},{\"product_id\":\"21\",\"product_price\":\"55\",\"qty\":\"1\"},{\"product_id\":\"23\",\"product_price\":\"19\",\"qty\":\"1\"},{\"product_id\":\"1\",\"product_price\":\"24\",\"qty\":\"1\"},{\"product_id\":\"1\",\"product_price\":\"24\",\"qty\":\"1\"}]', 247, '2022-07-02 07:51:18', '2022-07-02 05:51:18', 'CA_80267');

-- --------------------------------------------------------

--
-- Table structure for table `tblproducts`
--

CREATE TABLE `tblproducts` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_price` double NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblproducts`
--

INSERT INTO `tblproducts` (`product_id`, `product_name`, `category_id`, `product_price`, `created_at`, `updated_at`) VALUES
(1, 'Viagra', 1, 24, '0000-00-00 00:00:00', '2021-06-17 15:46:14'),
(3, 'Alprazolam', 1, 34, '0000-00-00 00:00:00', '2021-06-17 15:30:49'),
(5, 'Clonazepam', 1, 20.83, '0000-00-00 00:00:00', '2021-06-17 15:36:28'),
(6, 'Gabapentin', 1, 43, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'Ciprofloxacin HCl', 1, 21.99, '0000-00-00 00:00:00', '2021-06-17 15:35:42'),
(10, 'APAP/Codeine', 1, 14, '0000-00-00 00:00:00', '2021-06-17 15:31:33'),
(21, 'Carisoprodol', 1, 55, '0000-00-00 00:00:00', '2021-06-17 15:34:55'),
(23, 'Azithromycin', 1, 19, '0000-00-00 00:00:00', '2021-06-17 15:33:03'),
(30, 'Citalopram HBR', 1, 21, '0000-00-00 00:00:00', '2021-06-17 15:36:01'),
(42, 'Allopurinol', 1, 17, '0000-00-00 00:00:00', '2021-06-17 15:30:09'),
(59, 'Amlodipine Besylate', 1, 57.99, '0000-00-00 00:00:00', '2021-06-17 15:31:15'),
(64, 'Carvedilol', 1, 24.15, '0000-00-00 00:00:00', '2021-06-17 15:35:22'),
(69, 'TruSkin Vitamin C Serum for Face', 2, 28.59, '2021-06-17 18:39:20', '0000-00-00 00:00:00'),
(70, 'Cerave Facial Moisturizing Lotion', 2, 25, '2021-06-17 18:40:08', '0000-00-00 00:00:00'),
(71, 'Aveeno Active Naturals Moisturizing Lotion', 2, 4.19, '2021-06-17 18:40:48', '0000-00-00 00:00:00'),
(72, 'Raw Pheromone Cologne', 4, 16.85, '2021-06-17 18:41:33', '0000-00-00 00:00:00'),
(73, 'Ralph Lauren Polo Blue Eau De Parfum Spray', 4, 19, '2021-06-17 18:42:29', '0000-00-00 00:00:00'),
(74, 'Vanilla Musk Perfume Oil Roll On', 4, 37, '2021-06-17 18:42:57', '0000-00-00 00:00:00'),
(75, 'Amber Perfume Oil Roll On', 4, 32, '2021-06-17 18:43:30', '0000-00-00 00:00:00'),
(76, 'Premium Pheromone Cologne', 4, 28, '2021-06-17 18:44:20', '0000-00-00 00:00:00'),
(77, 'Sticky Notes', 3, 16, '2021-06-17 18:44:48', '0000-00-00 00:00:00'),
(78, 'Multipurpose Copy Printer Paper', 3, 19.27, '2021-06-17 18:45:33', '0000-00-00 00:00:00'),
(79, 'Swingline Stapler', 3, 10.84, '2021-06-17 18:46:05', '0000-00-00 00:00:00'),
(80, 'Air Filter with Air Pretreatment System', 3, 79, '2021-06-17 18:46:48', '0000-00-00 00:00:00'),
(81, 'Nuun Sport Electrolyte Drink Tablets', 5, 24, '2021-06-17 19:36:17', '0000-00-00 00:00:00'),
(82, 'Premier Protein Clear Drink', 5, 28.46, '2021-06-17 19:36:58', '0000-00-00 00:00:00'),
(83, 'Product 101', 1, 125, '2022-07-02 05:48:25', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblcategories`
--
ALTER TABLE `tblcategories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tblorders`
--
ALTER TABLE `tblorders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `tblproducts`
--
ALTER TABLE `tblproducts`
  ADD PRIMARY KEY (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblcategories`
--
ALTER TABLE `tblcategories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblorders`
--
ALTER TABLE `tblorders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tblproducts`
--
ALTER TABLE `tblproducts`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;
COMMIT;
