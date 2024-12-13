-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2022 at 11:04 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `pos_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(9, '2022-06-18-005419', 'App\\Database\\Migrations\\Authentication', 'default', 'App', 1655887322, 1),
(10, '2022-06-22-060131', 'App\\Database\\Migrations\\Product', 'default', 'App', 1655887322, 1),
(11, '2022-06-22-060355', 'App\\Database\\Migrations\\Transaction', 'default', 'App', 1655887322, 1),
(12, '2022-06-22-060410', 'App\\Database\\Migrations\\TransactionItem', 'default', 'App', 1655887322, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(30) UNSIGNED NOT NULL,
  `code` varchar(100) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` text DEFAULT '',
  `price` float(12,2) NOT NULL DEFAULT 0.00,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `code`, `name`, `description`, `price`, `created_at`, `updated_at`) VALUES
(1, '1001', 'Product 101', 'Sample Product #101', 55.50, '2022-06-22 16:42:07', '2022-06-22 16:42:07'),
(2, '1002', 'Product 102', 'Sample Product #102', 150.00, '2022-06-22 16:42:07', '2022-06-22 16:42:07'),
(4, '1004', 'Product 104', 'Sample Product #104', 23.50, '2022-06-22 16:42:07', '2022-06-22 16:42:07'),
(5, '1005', 'Product 105', 'Sample Product #105', 60.50, '2022-06-22 16:42:07', '2022-06-22 16:42:07'),
(6, '1006', 'Product 106', 'Sample Product #106', 205.25, '2022-06-22 16:42:07', '2022-06-22 16:42:07'),
(7, '1007', 'Product 107', 'Sample Product #107', 45.00, '2022-06-22 16:42:07', '2022-06-22 16:42:07'),
(8, '1008', 'Product 108', 'Sample Product #108', 75.23, '2022-06-22 16:42:07', '2022-06-22 16:42:07'),
(9, '1009', 'Product 109', 'Sample Product #109', 106.55, '2022-06-22 16:42:07', '2022-06-22 16:42:07'),
(10, '1010', 'Product 110', 'Sample Product #110', 375.50, '2022-06-22 16:42:07', '2022-06-22 16:42:07'),
(11, '1011', 'Product 111', 'Sample Product #111', 87.45, '2022-06-22 16:42:07', '2022-06-22 16:42:07'),
(12, '1012', 'Product 112', 'Sample Product #112', 104.99, '2022-06-22 16:42:07', '2022-06-22 16:42:07'),
(13, '1013', 'Product 113', 'Sample Product #113', 55.33, '2022-06-22 16:42:07', '2022-06-22 16:42:07'),
(14, '1014', 'Product 114', 'Sample Product #114', 88.99, '2022-06-22 16:42:07', '2022-06-22 16:42:07'),
(15, '1015', 'Product 115', 'Sample Product #115', 67.25, '2022-06-22 16:42:07', '2022-06-22 16:42:07'),
(16, '1016', 'Product 116', 'Sample Product #116', 195.85, '2022-06-22 16:42:07', '2022-06-22 16:42:07'),
(17, '1017', 'Product 117', 'Sample Product #117', 499.99, '2022-06-22 16:42:07', '2022-06-22 16:42:07');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(30) UNSIGNED NOT NULL,
  `code` varchar(100) NOT NULL,
  `customer` varchar(250) NOT NULL,
  `total_amount` float(12,2) NOT NULL DEFAULT 0.00,
  `tendered` float(12,2) NOT NULL DEFAULT 0.00,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `code`, `customer`, `total_amount`, `tendered`, `created_at`, `updated_at`) VALUES
(1, '2022062200001', 'Mark Cooper', 505.50, 600.00, '2022-06-22 16:42:41', '2022-06-22 16:42:41'),
(2, '2022062200002', 'Samantha', 1285.00, 1300.00, '2022-06-22 16:43:00', '2022-06-22 16:43:00');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_items`
--

CREATE TABLE `transaction_items` (
  `transaction_id` int(30) UNSIGNED NOT NULL,
  `product_id` int(30) UNSIGNED NOT NULL,
  `price` float(12,2) NOT NULL DEFAULT 0.00,
  `quantity` int(30) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transaction_items`
--

INSERT INTO `transaction_items` (`transaction_id`, `product_id`, `price`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 1, 55.50, 1, '2022-06-22 16:42:41', '2022-06-22 16:42:41'),
(1, 2, 150.00, 3, '2022-06-22 16:42:41', '2022-06-22 16:42:41'),
(2, 11, 87.45, 10, '2022-06-22 16:43:00', '2022-06-22 16:43:00'),
(2, 6, 205.25, 2, '2022-06-22 16:43:00', '2022-06-22 16:43:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) UNSIGNED NOT NULL,
  `name` varchar(250) NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@mail.com', '$2y$10$74KR7BL3HBoPFrojMX9y.OMASdwNgT/CNwIhA2fRkpBDvs/S/T1sS', '2022-06-22 16:42:05', '2022-06-22 16:42:05'),
(2, 'Mark Cooper', 'mcooper@mail.com', '$2y$10$EAclL..4GhUrXmkSixth8OoYasqJRcX.Qa2I4TqX1mz9v7gSmEMzW', '2022-06-22 17:04:27', '2022-06-22 17:04:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_items`
--
ALTER TABLE `transaction_items`
  ADD KEY `transaction_items_product_id_foreign` (`product_id`),
  ADD KEY `transaction_id` (`transaction_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(30) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(30) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaction_items`
--
ALTER TABLE `transaction_items`
  ADD CONSTRAINT `transaction_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `transaction_items_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;
