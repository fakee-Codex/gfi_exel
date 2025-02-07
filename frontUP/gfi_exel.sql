-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2025 at 02:14 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gfi_exel`
--

-- --------------------------------------------------------

--
-- Table structure for table `computation`
--

CREATE TABLE `computation` (
  `computation_id` int(6) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `overload_rate` decimal(10,2) NOT NULL,
  `overload_total` decimal(10,2) NOT NULL,
  `wr_hr` decimal(10,2) NOT NULL,
  `wr_rate` decimal(10,2) NOT NULL,
  `wr_total` decimal(10,2) NOT NULL,
  `adjust_hr` decimal(10,2) NOT NULL,
  `adjust_rate` decimal(10,2) NOT NULL,
  `adjust_total` decimal(10,2) NOT NULL,
  `watch_hr` decimal(10,2) NOT NULL,
  `watch_rate` decimal(10,2) NOT NULL,
  `watch_total` decimal(10,2) NOT NULL,
  `gross_pay` decimal(10,2) NOT NULL,
  `absent_late_hr` decimal(10,2) NOT NULL,
  `absent_late_rate` decimal(10,2) NOT NULL,
  `absent_late_total` decimal(10,2) NOT NULL,
  `pagibig` decimal(10,2) NOT NULL,
  `mp2` decimal(10,2) NOT NULL,
  `canteen` decimal(10,2) NOT NULL,
  `others` decimal(10,2) NOT NULL,
  `total_deduction` decimal(10,2) NOT NULL,
  `net_pay` decimal(10,2) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contributions`
--

CREATE TABLE `contributions` (
  `contributions_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `sss_ee` decimal(11,0) NOT NULL,
  `pag_ibig_ee` decimal(11,0) NOT NULL,
  `philhealth_ee` decimal(11,0) NOT NULL,
  `sss_er` decimal(11,0) NOT NULL,
  `pag_ibig_er` decimal(11,0) NOT NULL,
  `philhealth_er` decimal(11,0) NOT NULL,
  `medical_savings` decimal(10,0) NOT NULL,
  `retirement` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contributions`
--

INSERT INTO `contributions` (`contributions_id`, `employee_id`, `sss_ee`, `pag_ibig_ee`, `philhealth_ee`, `sss_er`, `pag_ibig_er`, `philhealth_er`, `medical_savings`, `retirement`) VALUES
(11, 401, 1350, 210, 750, 2850, 205, 750, 440, 476),
(12, 402, 2250, 200, 1250, 4750, 200, 1250, 420, 360),
(14, 404, 1575, 200, 875, 3325, 200, 875, 150, 530);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `employee_type` enum('full-time','part-time') NOT NULL,
  `classification` varchar(255) NOT NULL,
  `basic_salary` decimal(10,2) NOT NULL,
  `honorarium` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `first_name`, `last_name`, `employee_type`, `classification`, `basic_salary`, `honorarium`, `created_at`) VALUES
(401, 'Manila', 'Bay', 'full-time', 'Dancer', 30000.00, 6000.00, '2025-01-14 09:43:19'),
(402, 'Willie', 'Pacquiao', 'full-time', 'Boxer', 50000.00, 10000.00, '2025-01-14 09:44:02'),
(403, 'genisis', 'mantilla', 'full-time', 'Roblox', 100000.00, 10000.00, '2025-01-14 10:13:30'),
(404, 'John', 'Joseph', 'part-time', 'Monkey Elepant', 35000.00, 7000.00, '2025-01-14 10:14:56');

-- --------------------------------------------------------

--
-- Table structure for table `overload`
--

CREATE TABLE `overload` (
  `overload_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `wednesday_days` decimal(10,2) DEFAULT 0.00,
  `wednesday_hrs` decimal(10,2) DEFAULT 0.00,
  `wednesday_total` decimal(10,2) DEFAULT 0.00,
  `thursday_days` decimal(10,2) DEFAULT 0.00,
  `thursday_hrs` decimal(10,2) DEFAULT 0.00,
  `thursday_total` decimal(10,2) DEFAULT 0.00,
  `friday_days` decimal(10,2) DEFAULT 0.00,
  `friday_hrs` decimal(10,2) DEFAULT 0.00,
  `friday_total` decimal(10,2) DEFAULT 0.00,
  `mtth_days` decimal(10,2) DEFAULT 0.00,
  `mtth_hrs` decimal(10,2) DEFAULT 0.00,
  `mtth_total` decimal(10,2) DEFAULT 0.00,
  `mtwf_days` decimal(10,2) DEFAULT 0.00,
  `mtwf_hrs` decimal(10,2) DEFAULT 0.00,
  `mtwf_total` decimal(10,2) DEFAULT 0.00,
  `twthf_days` decimal(10,2) DEFAULT 0.00,
  `twthf_hrs` decimal(10,2) DEFAULT 0.00,
  `twthf_total` decimal(10,2) DEFAULT 0.00,
  `mw_days` decimal(10,2) DEFAULT 0.00,
  `mw_hrs` decimal(10,2) DEFAULT 0.00,
  `mw_total` decimal(10,2) DEFAULT 0.00,
  `less_lateOL` decimal(10,2) DEFAULT 0.00,
  `additional` decimal(10,2) DEFAULT 0.00,
  `adjustment_less` decimal(10,2) DEFAULT 0.00,
  `grand_total` decimal(11,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `overload`
--

INSERT INTO `overload` (`overload_id`, `employee_id`, `wednesday_days`, `wednesday_hrs`, `wednesday_total`, `thursday_days`, `thursday_hrs`, `thursday_total`, `friday_days`, `friday_hrs`, `friday_total`, `mtth_days`, `mtth_hrs`, `mtth_total`, `mtwf_days`, `mtwf_hrs`, `mtwf_total`, `twthf_days`, `twthf_hrs`, `twthf_total`, `mw_days`, `mw_hrs`, `mw_total`, `less_lateOL`, `additional`, `adjustment_less`, `grand_total`) VALUES
(10, 401, 5.00, 3.00, 15.00, 5.00, 3.00, 9.00, 2.00, 3.00, 6.00, 0.00, 3.00, 0.00, 0.00, 3.00, 0.00, 0.00, 3.00, 0.00, 0.00, 3.00, 0.00, 2.00, 5.00, 0.00, 24.00),
(11, 403, 3.00, 4.00, 0.00, 5.00, 2.00, 4.00, 4.00, 2.00, 8.00, 3.00, 6.00, 18.00, 0.00, 5.00, 0.00, 5.00, 3.00, 15.00, 4.00, 2.00, 8.00, 5.00, 10.00, 5.00, 53.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `computation`
--
ALTER TABLE `computation`
  ADD PRIMARY KEY (`computation_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `contributions`
--
ALTER TABLE `contributions`
  ADD PRIMARY KEY (`contributions_id`),
  ADD KEY `fk_contributions_employee_id` (`employee_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `overload`
--
ALTER TABLE `overload`
  ADD PRIMARY KEY (`overload_id`),
  ADD KEY `fk_overload_employee_id` (`employee_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `computation`
--
ALTER TABLE `computation`
  MODIFY `computation_id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `contributions`
--
ALTER TABLE `contributions`
  MODIFY `contributions_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=423;

--
-- AUTO_INCREMENT for table `overload`
--
ALTER TABLE `overload`
  MODIFY `overload_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contributions`
--
ALTER TABLE `contributions`
  ADD CONSTRAINT `fk_contributions_employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`) ON DELETE CASCADE;

--
-- Constraints for table `overload`
--
ALTER TABLE `overload`
  ADD CONSTRAINT `fk_overload_employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
