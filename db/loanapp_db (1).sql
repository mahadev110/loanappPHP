-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2025 at 09:36 PM
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
  `application_number` varchar(50) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `address` text NOT NULL,
  `pan` varchar(20) DEFAULT NULL,
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

INSERT INTO `customers` (`id`, `application_number`, `customer_name`, `mobile`, `address`, `pan`, `aadhar`, `request_loan_amt`, `eligible_loan_amt`, `given_loan_amt`, `loan_date`, `created_at`) VALUES
(8, 'APP01005', 'Murugan', '9940933927', '139, Vysial street', '', '889844576254', 0.00, 0.00, 500000.00, '2025-03-01', '2025-03-04 20:08:44'),
(21, 'APP00006', 'Sivakumar', '9600830086', '15, MG ROAD', '', '554466223333', 0.00, 0.00, 200000.00, '2025-03-03', '2025-03-04 20:25:39');

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
(9, 'APP01005', 'Murugan', 30000.00, '2025-03-04', '2025-03-04 20:26:36'),
(10, 'APP01005', 'Murugan', 4000.00, '2025-02-24', '2025-03-04 20:27:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mobile` (`mobile`),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `loan_collections`
--
ALTER TABLE `loan_collections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



20.03.2025
ALTER TABLE `customers` ADD `isdelete` INT(10) NOT NULL AFTER `created_at`;
ALTER TABLE `loan_collections` ADD `isdelete` INT(10) NOT NULL AFTER `created_at`;