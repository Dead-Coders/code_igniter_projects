-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2022 at 09:33 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `payroll_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(30) UNSIGNED NOT NULL,
  `code` varchar(100) NOT NULL,
  `name` varchar(250) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES
(1, 'ITD', 'Information Technology Department', '2022-06-23 09:07:05', '2022-06-23 09:07:05'),
(2, 'HRD', 'Human Resource Department', '2022-06-23 09:07:05', '2022-06-23 09:07:05'),
(3, 'MKGTD', 'Marketing Department', '2022-06-23 09:07:05', '2022-06-23 09:07:05'),
(4, 'AFD', 'Accounting and Finance Department', '2022-06-23 09:07:05', '2022-06-23 09:07:05');

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` int(30) UNSIGNED NOT NULL,
  `code` varchar(100) NOT NULL,
  `name` varchar(250) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Staff', 'Staff', '2022-06-23 09:13:21', '2022-06-23 09:13:21'),
(2, 'Clerk', 'Clerk', '2022-06-23 09:13:21', '2022-06-23 09:13:21'),
(3, 'Sr. Web Dev.', 'Senior Web Developer', '2022-06-23 09:13:21', '2022-06-23 09:13:21'),
(4, 'Jr. Web Dev.', 'Junior Web Developer', '2022-06-23 09:13:21', '2022-06-23 09:13:21'),
(5, 'FullStack Dev', 'Full Stack Developer', '2022-06-23 09:13:21', '2022-06-23 09:13:21'),
(6, 'PM', 'Project Manager', '2022-06-23 09:13:21', '2022-06-23 09:13:21'),
(7, 'Manage', 'Manager', '2022-06-23 09:13:21', '2022-06-23 09:13:21'),
(8, 'DH', 'Department Head', '2022-06-23 09:13:21', '2022-06-23 09:13:21');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(30) UNSIGNED NOT NULL,
  `department_id` int(30) UNSIGNED NOT NULL,
  `designation_id` int(30) UNSIGNED NOT NULL,
  `code` varchar(100) NOT NULL,
  `first_name` varchar(250) NOT NULL,
  `middle_name` varchar(250) DEFAULT '',
  `last_name` varchar(250) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(50) NOT NULL,
  `email` varchar(250) NOT NULL,
  `date_hired` date NOT NULL,
  `salary` float(12,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `department_id`, `designation_id`, `code`, `first_name`, `middle_name`, `last_name`, `dob`, `gender`, `email`, `date_hired`, `salary`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 7, '1000', 'Tiffany', 'Bradtke', 'Klocko', '1940-07-28', 'Male', 'tiklocko@mail.com', '2015-09-23', 34000.00, 1, '2022-06-23 09:26:28', '2022-06-23 09:26:28'),
(2, 3, 8, '1001', 'Harley', 'Cummerata', 'DuBuque', '1976-06-14', 'Female', 'hadubuque@mail.com', '2014-04-25', 41000.00, 1, '2022-06-23 09:26:28', '2022-06-23 09:26:28'),
(3, 1, 8, '1002', 'Harrison', 'Von', 'Koch', '1930-09-30', 'Female', 'hakoch@mail.com', '2018-05-19', 40000.00, 1, '2022-06-23 09:26:28', '2022-06-23 09:26:28'),
(4, 4, 6, '1003', 'Jay', 'Torphy', 'Zieme', '1948-03-04', 'Female', 'jazieme@mail.com', '2012-11-13', 50000.00, 1, '2022-06-23 09:26:28', '2022-06-23 09:26:28'),
(5, 3, 7, '1004', 'Vallie', 'Koepp', 'Crooks', '1998-12-08', 'Female', 'vacrooks@mail.com', '2013-07-28', 29000.00, 1, '2022-06-23 09:26:28', '2022-06-23 09:26:28'),
(6, 2, 2, '1005', 'Flavio', 'Fisher', 'Conn', '2002-04-17', 'Female', 'flconn@mail.com', '2015-08-31', 51000.00, 1, '2022-06-23 09:26:28', '2022-06-23 09:26:28'),
(7, 1, 5, '1006', 'Jared', 'Waters', 'Thompson', '1954-06-05', 'Male', 'jathompson@mail.com', '2020-02-09', 56000.00, 1, '2022-06-23 09:26:28', '2022-06-23 09:26:28'),
(8, 3, 1, '1007', 'Leilani', 'Cruickshank', 'Braun', '1976-06-21', 'Female', 'lebraun@mail.com', '2020-12-01', 55000.00, 1, '2022-06-23 09:26:28', '2022-06-23 09:26:28'),
(9, 1, 6, '1008', 'Osvaldo', 'McLaughlin', 'Crooks', '1926-07-20', 'Female', 'oscrooks@mail.com', '2017-03-16', 40000.00, 1, '2022-06-23 09:26:28', '2022-06-23 09:26:28'),
(10, 2, 7, '1009', 'Santiago', 'Blick', 'Kilback', '1983-09-15', 'Male', 'sakilback@mail.com', '2012-09-18', 45000.00, 1, '2022-06-23 09:26:28', '2022-06-23 09:26:28'),
(11, 2, 3, '10010', 'Tyson', 'Pfannerstill', 'Hand', '2003-11-02', 'Male', 'tyhand@mail.com', '2012-09-16', 31000.00, 1, '2022-06-23 09:26:28', '2022-06-23 09:26:28'),
(12, 4, 8, '10011', 'Camren', 'Haley', 'Marquardt', '2011-11-30', 'Male', 'camarquardt@mail.com', '2019-03-20', 54000.00, 1, '2022-06-23 09:26:28', '2022-06-23 09:26:28'),
(13, 1, 3, '10012', 'Dorcas', 'Gleason', 'Windler', '1930-11-29', 'Male', 'dowindler@mail.com', '2018-05-17', 27000.00, 1, '2022-06-23 09:26:28', '2022-06-23 09:26:28'),
(14, 1, 4, '10013', 'Danika', 'Crona', 'Marquardt', '1990-08-25', 'Female', 'damarquardt@mail.com', '2015-10-29', 49000.00, 1, '2022-06-23 09:26:28', '2022-06-23 09:26:28'),
(15, 2, 5, '10014', 'Gregorio', 'Bergnaum', 'Heathcote', '2015-05-28', 'Female', 'grheathcote@mail.com', '2014-05-01', 59000.00, 1, '2022-06-23 09:26:29', '2022-06-23 09:26:29'),
(16, 2, 3, '10015', 'Nikki', 'Nicolas', 'Spencer', '1934-07-08', 'Female', 'nispencer@mail.com', '2021-01-06', 37000.00, 1, '2022-06-23 09:26:29', '2022-06-23 09:26:29'),
(17, 1, 7, '10016', 'Edgardo', 'Miller', 'Grimes', '1946-07-25', 'Male', 'edgrimes@mail.com', '2016-07-16', 57000.00, 1, '2022-06-23 09:26:29', '2022-06-23 09:26:29'),
(18, 3, 7, '10017', 'Sally', 'O\'Hara', 'Lehner', '2010-10-09', 'Female', 'salehner@mail.com', '2020-11-13', 54000.00, 1, '2022-06-23 09:26:29', '2022-06-23 09:26:29'),
(19, 2, 5, '10018', 'Julius', 'Marquardt', 'Waters', '1976-07-10', 'Female', 'juwaters@mail.com', '2021-12-14', 29000.00, 1, '2022-06-23 09:26:29', '2022-06-23 09:26:29'),
(20, 2, 1, '10019', 'Jason', 'Bailey', 'Mraz', '1972-06-02', 'Female', 'jamraz@mail.com', '2014-06-22', 53000.00, 1, '2022-06-23 09:26:29', '2022-06-23 09:26:29'),
(21, 1, 7, '10020', 'Steve', 'Goldner', 'Kunde', '1977-07-21', 'Male', 'stkunde@mail.com', '2013-01-20', 29000.00, 1, '2022-06-23 09:26:29', '2022-06-23 09:26:29'),
(22, 3, 6, '10021', 'Laurence', 'Reichel', 'Kreiger', '1935-04-12', 'Female', 'lakreiger@mail.com', '2016-11-23', 47000.00, 1, '2022-06-23 09:26:29', '2022-06-23 09:26:29'),
(23, 1, 3, '10022', 'Wilburn', 'Blanda', 'Lehner', '1989-11-21', 'Male', 'wilehner@mail.com', '2017-10-05', 58000.00, 1, '2022-06-23 09:26:29', '2022-06-23 09:26:29'),
(24, 2, 4, '10023', 'Oswaldo', 'Dare', 'Langworth', '1931-02-04', 'Male', 'oslangworth@mail.com', '2018-03-05', 42000.00, 1, '2022-06-23 09:26:29', '2022-06-23 09:26:29'),
(25, 3, 2, '10024', 'Cristal', 'Mitchell', 'Mitchell', '1984-05-22', 'Female', 'crmitchell@mail.com', '2017-10-07', 45000.00, 1, '2022-06-23 09:26:29', '2022-06-23 09:26:29'),
(27, 1, 5, '6231415', 'Mark', 'D', 'Cooper', '1997-06-23', 'Male', 'mcooper@mail.com', '2020-10-14', 50000.00, 1, '2022-06-23 11:03:07', '2022-06-23 11:35:59');

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
(1, '2022-06-18-005419', 'App\\Database\\Migrations\\Authentication', 'default', 'App', 1655945989, 1),
(2, '2022-06-23-004252', 'App\\Database\\Migrations\\Department', 'default', 'App', 1655945989, 1),
(3, '2022-06-23-004521', 'App\\Database\\Migrations\\Designation', 'default', 'App', 1655945989, 1),
(4, '2022-06-23-005222', 'App\\Database\\Migrations\\Employee', 'default', 'App', 1655945990, 1),
(5, '2022-06-23-034207', 'App\\Database\\Migrations\\Payroll', 'default', 'App', 1655956354, 2),
(6, '2022-06-23-040112', 'App\\Database\\Migrations\\Payslip', 'default', 'App', 1655964506, 3),
(7, '2022-06-23-050647', 'App\\Database\\Migrations\\PayslipEarnings', 'default', 'App', 1655964506, 3),
(8, '2022-06-23-050657', 'App\\Database\\Migrations\\PayslipDeductions', 'default', 'App', 1655964507, 3);

-- --------------------------------------------------------

--
-- Table structure for table `payrolls`
--

CREATE TABLE `payrolls` (
  `id` int(30) UNSIGNED NOT NULL,
  `code` varchar(100) NOT NULL,
  `title` varchar(250) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payrolls`
--

INSERT INTO `payrolls` (`id`, `code`, `title`, `from_date`, `to_date`, `created_at`, `updated_at`) VALUES
(1, 'Payroll-1001', 'Sample Payroll #1', '2022-05-01', '2022-05-15', '2022-06-23 11:53:47', '2022-06-23 11:55:22'),
(2, 'Payroll-1002', 'Sample Payroll #2', '2022-05-16', '2022-05-31', '2022-06-23 11:55:55', '2022-06-23 11:55:55');

-- --------------------------------------------------------

--
-- Table structure for table `payroll_deductions`
--

CREATE TABLE `payroll_deductions` (
  `payslip_id` int(30) UNSIGNED NOT NULL,
  `name` varchar(250) NOT NULL,
  `amount` float(12,2) NOT NULL DEFAULT 0.00,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payroll_deductions`
--

INSERT INTO `payroll_deductions` (`payslip_id`, `name`, `amount`, `created_at`, `updated_at`) VALUES
(1, 'Pagibig', 500.00, '2022-06-23 14:45:50', '2022-06-23 14:45:50'),
(1, 'SSS', 370.00, '2022-06-23 14:45:50', '2022-06-23 14:45:50'),
(1, 'PhilHelth', 375.00, '2022-06-23 14:45:50', '2022-06-23 14:45:50');

-- --------------------------------------------------------

--
-- Table structure for table `payroll_earnings`
--

CREATE TABLE `payroll_earnings` (
  `payslip_id` int(30) UNSIGNED NOT NULL,
  `name` varchar(250) NOT NULL,
  `amount` float(12,2) NOT NULL DEFAULT 0.00,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payroll_earnings`
--

INSERT INTO `payroll_earnings` (`payslip_id`, `name`, `amount`, `created_at`, `updated_at`) VALUES
(1, 'Overtime', 2500.00, '2022-06-23 14:45:50', '2022-06-23 14:45:50'),
(1, 'Allowance', 5000.00, '2022-06-23 14:45:50', '2022-06-23 14:45:50');

-- --------------------------------------------------------

--
-- Table structure for table `payslips`
--

CREATE TABLE `payslips` (
  `id` int(30) UNSIGNED NOT NULL,
  `payroll_id` int(30) UNSIGNED NOT NULL,
  `employee_id` int(30) UNSIGNED NOT NULL,
  `salary` float(12,2) NOT NULL DEFAULT 0.00,
  `present` float(12,2) NOT NULL DEFAULT 0.00,
  `late_undertime` float(12,2) NOT NULL DEFAULT 0.00,
  `witholding_tax` float(12,2) NOT NULL DEFAULT 0.00,
  `net` float(12,2) NOT NULL DEFAULT 0.00,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payslips`
--

INSERT INTO `payslips` (`id`, `payroll_id`, `employee_id`, `salary`, `present`, `late_undertime`, `witholding_tax`, `net`, `created_at`, `updated_at`) VALUES
(1, 1, 27, 50000.00, 11.00, 30.00, 1150.00, 29962.96, '2022-06-23 14:45:50', '2022-06-23 14:46:45');

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
(1, 'Administrator', 'admin@mail.com', '$2y$10$KDBSRIVimyaM8Ig5RV9IaOOIpWpTdGPZuU3sjT32x4Y9dpY28t56C', '2022-06-23 09:35:38', '2022-06-23 09:35:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `designation_id` (`designation_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payrolls`
--
ALTER TABLE `payrolls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payroll_deductions`
--
ALTER TABLE `payroll_deductions`
  ADD KEY `payslip_id` (`payslip_id`);

--
-- Indexes for table `payroll_earnings`
--
ALTER TABLE `payroll_earnings`
  ADD KEY `payslip_id` (`payslip_id`);

--
-- Indexes for table `payslips`
--
ALTER TABLE `payslips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payroll_id` (`payroll_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(30) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` int(30) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(30) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payrolls`
--
ALTER TABLE `payrolls`
  MODIFY `id` int(30) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payslips`
--
ALTER TABLE `payslips`
  MODIFY `id` int(30) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `employees_designation_id_foreign` FOREIGN KEY (`designation_id`) REFERENCES `designations` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `payroll_deductions`
--
ALTER TABLE `payroll_deductions`
  ADD CONSTRAINT `payroll_deductions_payslip_id_foreign` FOREIGN KEY (`payslip_id`) REFERENCES `payslips` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `payroll_earnings`
--
ALTER TABLE `payroll_earnings`
  ADD CONSTRAINT `payroll_earnings_payslip_id_foreign` FOREIGN KEY (`payslip_id`) REFERENCES `payslips` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `payslips`
--
ALTER TABLE `payslips`
  ADD CONSTRAINT `payslips_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `payslips_payroll_id_foreign` FOREIGN KEY (`payroll_id`) REFERENCES `payrolls` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;
