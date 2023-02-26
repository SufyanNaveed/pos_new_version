-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2023 at 03:10 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos_7.1`
--

-- --------------------------------------------------------

--
-- Table structure for table `geopos_employees`
--

CREATE TABLE `geopos_employees` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `region` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `postbox` varchar(20) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `phonealt` varchar(15) DEFAULT NULL,
  `picture` varchar(50) NOT NULL DEFAULT 'example.png',
  `sign` varchar(100) DEFAULT 'sign.png',
  `joindate` datetime NOT NULL DEFAULT current_timestamp(),
  `dept` int(11) DEFAULT NULL,
  `degis` int(11) DEFAULT NULL,
  `salary` decimal(16,2) DEFAULT 0.00,
  `target` varchar(255) DEFAULT NULL,
  `month_target` varchar(255) DEFAULT NULL,
  `clock` int(1) DEFAULT NULL,
  `clockin` int(11) DEFAULT NULL,
  `clockout` int(11) DEFAULT NULL,
  `c_rate` decimal(16,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `geopos_employees`
--

INSERT INTO `geopos_employees` (`id`, `username`, `name`, `address`, `city`, `region`, `country`, `postbox`, `phone`, `phonealt`, `picture`, `sign`, `joindate`, `dept`, `degis`, `salary`, `target`, `month_target`, `clock`, `clockin`, `clockout`, `c_rate`) VALUES
(13, 'admin', 'BusinessOwner', 'Test Street', 'Test City', 'Test Region', 'Test Country', '123456', '12345678', '0', 'example.png', 'sign.png', '2023-01-11 23:02:20', NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'c222', 'Test 17', 'Test', 'Islamabad', NULL, 'Pakistan', '', '000000000000', '', 'example.png', 'sign.png', '2023-02-15 00:53:13', 0, NULL, '5000.00', '35000', '02', NULL, NULL, NULL, '0.00'),
(19, 'Testing', 'Test 19', 'Test', 'Islamabad', NULL, 'Pakistan', '', '000000000000', '', 'example.png', 'sign.png', '2023-02-26 17:03:38', 0, NULL, '30000.00', '50000', '02', NULL, NULL, NULL, '0.00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `geopos_employees`
--
ALTER TABLE `geopos_employees`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `geopos_employees`
--
ALTER TABLE `geopos_employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
