-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2025 at 08:47 PM
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
-- Database: `loanapp_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `address` text NOT NULL,
  `pan` varchar(10) NOT NULL,
  `aadhar` varchar(12) NOT NULL,
  `request_loan_amt` decimal(10,2) NOT NULL,
  `eligible_loan_amt` decimal(10,2) NOT NULL,
  `given_loan_amt` decimal(10,2) NOT NULL,
  `loan_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customer_name`, `mobile`, `address`, `pan`, `aadhar`, `request_loan_amt`, `eligible_loan_amt`, `given_loan_amt`, `loan_date`, `created_at`) VALUES
(1, 'Sivakumar', '9876543210', 'Lawspet', 'ABCDE1234F', '222111124445', 1000000.00, 500000.00, 500000.00, '2025-02-12', '2025-02-25 18:20:19'),
(2, 'Murugan', '5467891230', '30,vysial st', 'AQWER1457D', '222111123322', 1100000.00, 600000.00, 600000.00, '2025-02-03', '2025-02-25 18:40:50');

-- --------------------------------------------------------

--
-- Table structure for table `loan_collections`
--

CREATE TABLE `loan_collections` (
  `id` int(11) NOT NULL,
  `application_number` varchar(50) NOT NULL,
  `borrower_name` varchar(255) NOT NULL,
  `amount_collected` decimal(10,2) NOT NULL,
  `collection_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loan_collections`
--

INSERT INTO `loan_collections` (`id`, `application_number`, `borrower_name`, `amount_collected`, `collection_date`, `created_at`) VALUES
(1, 'app00001', 'Sivakumar', 30000.00, '2025-02-27', '2025-02-25 19:22:48'),
(2, 'app00002', 'Murugan', 4000.00, '2025-02-18', '2025-02-25 19:26:46'),
(3, 'app00001', 'Sivakumar', 2000.00, '2025-02-28', '2025-02-25 19:30:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mobile` (`mobile`),
  ADD UNIQUE KEY `pan` (`pan`),
  ADD UNIQUE KEY `aadhar` (`aadhar`);

--
-- Indexes for table `loan_collections`
--
ALTER TABLE `loan_collections`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `loan_collections`
--
ALTER TABLE `loan_collections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
