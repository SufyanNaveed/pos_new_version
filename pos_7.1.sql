-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 11, 2023 at 07:57 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('6oqm1unc13arndojg0c61dlv71ptl221', '::1', 1673462478, 0x5f5f63695f6c6173745f726567656e65726174657c693a313637333436323437383b69647c733a323a223135223b757365726e616d657c733a353a2261646d696e223b656d61696c7c733a31353a2261646d696e4061646d696e2e636f6d223b735f726f6c657c733a333a22725f35223b6c6f67676564696e7c623a313b),
('77u6h8svdmrj0lpimla9f425ce6tjrjg', '::1', 1673463375, 0x5f5f63695f6c6173745f726567656e65726174657c693a313637333436333337353b69647c733a323a223135223b757365726e616d657c733a353a2261646d696e223b656d61696c7c733a31353a2261646d696e4061646d696e2e636f6d223b735f726f6c657c733a333a22725f35223b6c6f67676564696e7c623a313b),
('8csqi10pev7i1asdmgv3rtn107geg2mi', '::1', 1673462841, 0x5f5f63695f6c6173745f726567656e65726174657c693a313637333436323834313b69647c733a323a223135223b757365726e616d657c733a353a2261646d696e223b656d61696c7c733a31353a2261646d696e4061646d696e2e636f6d223b735f726f6c657c733a333a22725f35223b6c6f67676564696e7c623a313b),
('8p1ah8jfkema4f01sq5rgq4me3inba2q', '::1', 1673461412, 0x5f5f63695f6c6173745f726567656e65726174657c693a313637333436313431323b69647c733a323a223135223b757365726e616d657c733a353a2261646d696e223b656d61696c7c733a31353a2261646d696e4061646d696e2e636f6d223b735f726f6c657c733a333a22725f35223b6c6f67676564696e7c623a313b),
('kai0hc5bi9he3m1fto6cq6jjaqb8ktd3', '::1', 1673463376, 0x5f5f63695f6c6173745f726567656e65726174657c693a313637333436333337353b69647c733a323a223135223b757365726e616d657c733a353a2261646d696e223b656d61696c7c733a31353a2261646d696e4061646d696e2e636f6d223b735f726f6c657c733a333a22725f35223b6c6f67676564696e7c623a313b);

-- --------------------------------------------------------

--
-- Table structure for table `geopos_accounts`
--

CREATE TABLE `geopos_accounts` (
  `id` int(5) NOT NULL,
  `acn` varchar(35) NOT NULL,
  `holder` varchar(100) NOT NULL,
  `adate` datetime NOT NULL,
  `lastbal` decimal(16,2) DEFAULT 0.00,
  `code` varchar(30) DEFAULT NULL,
  `loc` int(4) DEFAULT NULL,
  `account_type` enum('Assets','Expenses','Income','Liabilities','Equity','Basic') NOT NULL DEFAULT 'Basic'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `geopos_accounts`
--

INSERT INTO `geopos_accounts` (`id`, `acn`, `holder`, `adate`, `lastbal`, `code`, `loc`, `account_type`) VALUES
(1, '123456', 'Sales Account', '2018-01-01 00:00:00', '0.00', 'Default Sales Account', 0, 'Basic');

-- --------------------------------------------------------

--
-- Table structure for table `geopos_attendance`
--

CREATE TABLE `geopos_attendance` (
  `id` int(11) NOT NULL,
  `emp` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `adate` date NOT NULL,
  `tfrom` time NOT NULL,
  `tto` time NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `actual_hours` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_bank_ac`
--

CREATE TABLE `geopos_bank_ac` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `bank` varchar(50) NOT NULL,
  `acn` varchar(50) NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `note` varchar(2000) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `branch` varchar(100) DEFAULT NULL,
  `enable` enum('Yes','No') NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_config`
--

CREATE TABLE `geopos_config` (
  `id` int(11) NOT NULL,
  `type` int(3) NOT NULL,
  `val1` varchar(50) NOT NULL,
  `val2` varchar(200) NOT NULL,
  `val3` varchar(100) NOT NULL,
  `val4` varchar(100) NOT NULL,
  `rid` int(11) NOT NULL,
  `other` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_currencies`
--

CREATE TABLE `geopos_currencies` (
  `id` int(4) NOT NULL,
  `code` varchar(3) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `symbol` varchar(3) DEFAULT NULL,
  `rate` decimal(10,5) NOT NULL,
  `thous` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `dpoint` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `decim` int(2) NOT NULL,
  `cpos` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_customers`
--

CREATE TABLE `geopos_customers` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `region` varchar(30) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `postbox` varchar(20) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `picture` varchar(100) NOT NULL DEFAULT 'example.png',
  `gid` int(5) NOT NULL DEFAULT 1,
  `company` varchar(100) DEFAULT NULL,
  `taxid` varchar(100) DEFAULT NULL,
  `name_s` varchar(100) DEFAULT NULL,
  `phone_s` varchar(100) DEFAULT NULL,
  `email_s` varchar(100) DEFAULT NULL,
  `address_s` varchar(100) DEFAULT NULL,
  `city_s` varchar(100) DEFAULT NULL,
  `region_s` varchar(100) DEFAULT NULL,
  `country_s` varchar(100) DEFAULT NULL,
  `postbox_s` varchar(100) DEFAULT NULL,
  `balance` decimal(16,2) DEFAULT 0.00,
  `loc` int(11) DEFAULT 0,
  `docid` varchar(255) DEFAULT NULL,
  `custom1` varchar(255) DEFAULT NULL,
  `discount_c` decimal(16,2) DEFAULT NULL,
  `reg_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `geopos_customers`
--

INSERT INTO `geopos_customers` (`id`, `name`, `phone`, `address`, `city`, `region`, `country`, `postbox`, `email`, `picture`, `gid`, `company`, `taxid`, `name_s`, `phone_s`, `email_s`, `address_s`, `city_s`, `region_s`, `country_s`, `postbox_s`, `balance`, `loc`, `docid`, `custom1`, `discount_c`, `reg_date`) VALUES
(1, 'Walk-in Client', '0987654321', NULL, NULL, NULL, NULL, NULL, 'example@example.com', 'example.png', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `geopos_custom_data`
--

CREATE TABLE `geopos_custom_data` (
  `id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `rid` int(11) NOT NULL,
  `module` int(3) NOT NULL,
  `data` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_custom_fields`
--

CREATE TABLE `geopos_custom_fields` (
  `id` int(11) NOT NULL,
  `f_module` int(3) NOT NULL,
  `f_type` varchar(30) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `placeholder` varchar(30) DEFAULT NULL,
  `value_data` text NOT NULL,
  `f_view` int(2) NOT NULL,
  `other` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_cust_group`
--

CREATE TABLE `geopos_cust_group` (
  `id` int(10) NOT NULL,
  `title` varchar(60) DEFAULT NULL,
  `summary` varchar(250) DEFAULT NULL,
  `disc_rate` decimal(9,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `geopos_cust_group`
--

INSERT INTO `geopos_cust_group` (`id`, `title`, `summary`, `disc_rate`) VALUES
(1, 'Default Group', 'Default Group', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `geopos_documents`
--

CREATE TABLE `geopos_documents` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `filename` varchar(50) DEFAULT NULL,
  `cdate` date NOT NULL,
  `permission` int(1) DEFAULT NULL,
  `cid` int(11) NOT NULL,
  `fid` int(11) NOT NULL,
  `rid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_draft`
--

CREATE TABLE `geopos_draft` (
  `id` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `invoicedate` date NOT NULL,
  `invoiceduedate` date NOT NULL,
  `subtotal` decimal(16,2) DEFAULT 0.00,
  `shipping` decimal(16,2) DEFAULT 0.00,
  `ship_tax` decimal(16,2) DEFAULT NULL,
  `ship_tax_type` enum('incl','excl','off') DEFAULT 'off',
  `discount` decimal(16,2) DEFAULT 0.00,
  `tax` decimal(16,2) DEFAULT 0.00,
  `total` decimal(16,2) DEFAULT 0.00,
  `pmethod` varchar(14) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `status` enum('paid','due','canceled','partial') NOT NULL DEFAULT 'due',
  `csd` int(5) NOT NULL DEFAULT 0,
  `eid` int(4) NOT NULL,
  `pamnt` decimal(16,2) DEFAULT 0.00,
  `items` decimal(10,2) NOT NULL,
  `taxstatus` enum('yes','no','cgst','igst') NOT NULL DEFAULT 'yes',
  `discstatus` tinyint(1) NOT NULL,
  `format_discount` enum('%','flat','bflat','b_p') NOT NULL DEFAULT '%',
  `refer` varchar(20) DEFAULT NULL,
  `term` int(3) NOT NULL,
  `multi` int(4) DEFAULT NULL,
  `i_class` int(1) NOT NULL DEFAULT 0,
  `loc` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_draft_items`
--

CREATE TABLE `geopos_draft_items` (
  `id` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `pid` int(11) NOT NULL DEFAULT 0,
  `product` varchar(255) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `qty` decimal(10,2) NOT NULL DEFAULT 0.00,
  `price` decimal(16,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(16,2) DEFAULT 0.00,
  `discount` decimal(16,2) DEFAULT 0.00,
  `subtotal` decimal(16,2) DEFAULT 0.00,
  `totaltax` decimal(16,2) DEFAULT 0.00,
  `totaldiscount` decimal(16,2) DEFAULT 0.00,
  `product_des` text DEFAULT NULL,
  `i_class` int(1) NOT NULL DEFAULT 0,
  `unit` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
  `clock` int(1) DEFAULT NULL,
  `clockin` int(11) DEFAULT NULL,
  `clockout` int(11) DEFAULT NULL,
  `c_rate` decimal(16,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `geopos_employees`
--

INSERT INTO `geopos_employees` (`id`, `username`, `name`, `address`, `city`, `region`, `country`, `postbox`, `phone`, `phonealt`, `picture`, `sign`, `joindate`, `dept`, `degis`, `salary`, `clock`, `clockin`, `clockout`, `c_rate`) VALUES
(13, 'admin', 'BusinessOwner', 'Test Street', 'Test City', 'Test Region', 'Test Country', '123456', '12345678', '0', 'example.png', 'sign.png', '2023-01-11 23:02:20', NULL, NULL, '0.00', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `geopos_events`
--

CREATE TABLE `geopos_events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `color` varchar(7) NOT NULL DEFAULT '#3a87ad',
  `start` datetime NOT NULL,
  `end` datetime DEFAULT NULL,
  `allDay` varchar(50) NOT NULL DEFAULT 'true',
  `rel` int(2) NOT NULL DEFAULT 0,
  `rid` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_gateways`
--

CREATE TABLE `geopos_gateways` (
  `id` int(5) NOT NULL,
  `name` varchar(50) NOT NULL,
  `enable` enum('Yes','No') NOT NULL,
  `key1` varchar(255) NOT NULL,
  `key2` varchar(255) DEFAULT NULL,
  `currency` varchar(3) NOT NULL DEFAULT 'USD',
  `dev_mode` enum('true','false') NOT NULL,
  `ord` int(5) NOT NULL,
  `surcharge` decimal(16,2) NOT NULL,
  `extra` varchar(40) NOT NULL DEFAULT 'none'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `geopos_gateways`
--

INSERT INTO `geopos_gateways` (`id`, `name`, `enable`, `key1`, `key2`, `currency`, `dev_mode`, `ord`, `surcharge`, `extra`) VALUES
(1, 'Stripe', 'Yes', 'sk_test_secratekey', 'stripe_public_key', 'USD', 'true', 1, '0.00', 'none'),
(2, 'Authorize.Net', 'Yes', 'TRANSACTIONKEY', 'LOGINID', 'AUD', 'true', 2, '0.00', 'none'),
(3, 'Pin Payments', 'Yes', 'TEST', 'none', 'AUD', 'true', 3, '0.00', 'none'),
(4, 'PayPal', 'Yes', 'MyPayPalClientId', 'MyPayPalSecret', 'USD', 'true', 4, '0.00', 'none'),
(5, 'SecurePay', 'Yes', 'ABC0001', 'abc123', 'AUD', 'true', 5, '0.00', 'none'),
(6, '2Checkout', 'Yes', 'Publishable Key', 'Private Key', 'USD', 'true', 6, '0.00', 'seller_id'),
(7, 'PayU Money', 'Yes', 'MERCHANT_KEY', 'MERCHANT_SALT', 'USD', 'true', 7, '0.00', 'none'),
(8, 'RazorPay', 'Yes', 'Key Id', 'Key Secret', 'INR', 'true', 8, '0.00', 'none');

-- --------------------------------------------------------

--
-- Table structure for table `geopos_goals`
--

CREATE TABLE `geopos_goals` (
  `id` int(1) NOT NULL,
  `income` bigint(20) NOT NULL,
  `expense` bigint(20) NOT NULL,
  `sales` bigint(20) NOT NULL,
  `netincome` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `geopos_goals`
--

INSERT INTO `geopos_goals` (`id`, `income`, `expense`, `sales`, `netincome`) VALUES
(1, 999999, 999999, 999999, 999999);

-- --------------------------------------------------------

--
-- Table structure for table `geopos_hrm`
--

CREATE TABLE `geopos_hrm` (
  `id` int(11) NOT NULL,
  `typ` int(2) NOT NULL,
  `rid` int(11) NOT NULL,
  `val1` varchar(255) DEFAULT NULL,
  `val2` varchar(255) DEFAULT NULL,
  `val3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_invoices`
--

CREATE TABLE `geopos_invoices` (
  `id` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `invoicedate` date NOT NULL,
  `invoiceduedate` date NOT NULL,
  `subtotal` decimal(16,2) DEFAULT 0.00,
  `shipping` decimal(16,2) DEFAULT 0.00,
  `ship_tax` decimal(16,2) DEFAULT NULL,
  `ship_tax_type` enum('incl','excl','off') DEFAULT 'off',
  `discount` decimal(16,2) DEFAULT 0.00,
  `discount_rate` decimal(10,2) DEFAULT 0.00,
  `tax` decimal(16,2) DEFAULT 0.00,
  `total` decimal(16,2) DEFAULT 0.00,
  `pmethod` varchar(14) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `status` enum('paid','due','canceled','partial') NOT NULL DEFAULT 'due',
  `csd` int(5) NOT NULL DEFAULT 0,
  `eid` int(4) NOT NULL,
  `pamnt` decimal(16,2) DEFAULT 0.00,
  `items` decimal(10,2) NOT NULL,
  `taxstatus` enum('yes','no','incl','cgst','igst') NOT NULL DEFAULT 'yes',
  `discstatus` tinyint(1) NOT NULL,
  `format_discount` enum('%','flat','b_p','bflat') NOT NULL DEFAULT '%',
  `refer` varchar(20) DEFAULT NULL,
  `term` int(3) NOT NULL,
  `multi` int(4) DEFAULT NULL,
  `i_class` int(1) NOT NULL DEFAULT 0,
  `loc` int(4) NOT NULL,
  `r_time` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_invoice_items`
--

CREATE TABLE `geopos_invoice_items` (
  `id` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `pid` int(11) NOT NULL DEFAULT 0,
  `product` varchar(255) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `qty` decimal(10,2) NOT NULL DEFAULT 0.00,
  `price` decimal(16,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(16,2) DEFAULT 0.00,
  `discount` decimal(16,2) DEFAULT 0.00,
  `subtotal` decimal(16,2) DEFAULT 0.00,
  `totaltax` decimal(16,2) DEFAULT 0.00,
  `totaldiscount` decimal(16,2) DEFAULT 0.00,
  `product_des` text DEFAULT NULL,
  `i_class` int(1) NOT NULL DEFAULT 0,
  `unit` varchar(5) DEFAULT NULL,
  `serial` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_locations`
--

CREATE TABLE `geopos_locations` (
  `id` int(3) NOT NULL,
  `cname` varchar(100) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `region` varchar(40) DEFAULT NULL,
  `country` varchar(40) DEFAULT NULL,
  `postbox` varchar(20) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `taxid` varchar(40) DEFAULT NULL,
  `logo` varchar(50) DEFAULT 'logo.png',
  `cur` int(4) NOT NULL,
  `ware` int(11) DEFAULT 0,
  `ext` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_log`
--

CREATE TABLE `geopos_log` (
  `id` int(11) NOT NULL,
  `note` mediumtext NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `user` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `geopos_log`
--

INSERT INTO `geopos_log` (`id`, `note`, `created`, `user`) VALUES
(1, '[Logged In] admin@admin.com', '2023-01-11 18:02:39', '');

-- --------------------------------------------------------

--
-- Table structure for table `geopos_login_attempts`
--

CREATE TABLE `geopos_login_attempts` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(39) DEFAULT '0',
  `timestamp` datetime DEFAULT NULL,
  `login_attempts` tinyint(2) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_metadata`
--

CREATE TABLE `geopos_metadata` (
  `id` int(11) NOT NULL,
  `type` int(3) NOT NULL,
  `rid` int(11) NOT NULL,
  `col1` varchar(255) DEFAULT NULL,
  `col2` varchar(255) DEFAULT NULL,
  `d_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_milestones`
--

CREATE TABLE `geopos_milestones` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `sdate` date NOT NULL,
  `edate` date NOT NULL,
  `exp` text NOT NULL,
  `color` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_movers`
--

CREATE TABLE `geopos_movers` (
  `id` int(11) NOT NULL,
  `d_type` int(3) NOT NULL,
  `rid1` int(11) NOT NULL,
  `rid2` int(11) NOT NULL,
  `rid3` int(11) NOT NULL,
  `d_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `note` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_notes`
--

CREATE TABLE `geopos_notes` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `cdate` date NOT NULL,
  `last_edit` datetime NOT NULL DEFAULT current_timestamp(),
  `cid` int(11) NOT NULL DEFAULT 0,
  `fid` int(11) NOT NULL DEFAULT 0,
  `rid` int(11) NOT NULL DEFAULT 0,
  `ntype` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_pms`
--

CREATE TABLE `geopos_pms` (
  `id` int(11) UNSIGNED NOT NULL,
  `sender_id` int(11) UNSIGNED NOT NULL,
  `receiver_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text DEFAULT NULL,
  `date_sent` datetime DEFAULT NULL,
  `date_read` datetime DEFAULT NULL,
  `pm_deleted_sender` int(1) NOT NULL,
  `pm_deleted_receiver` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_premissions`
--

CREATE TABLE `geopos_premissions` (
  `id` int(11) NOT NULL,
  `module` enum('Sales','Stock','Crm','Project','Accounts','Miscellaneous','Employees','Assign Project','Customer Profile','Reports','Delete','POS','Sales Edit','Stock Edit') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `r_1` int(1) NOT NULL,
  `r_2` int(1) NOT NULL,
  `r_3` int(1) NOT NULL,
  `r_4` int(1) NOT NULL,
  `r_5` int(1) NOT NULL,
  `r_6` int(1) NOT NULL,
  `r_7` int(1) NOT NULL,
  `r_8` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `geopos_premissions`
--

INSERT INTO `geopos_premissions` (`id`, `module`, `r_1`, `r_2`, `r_3`, `r_4`, `r_5`, `r_6`, `r_7`, `r_8`) VALUES
(1, 'Sales', 0, 1, 1, 1, 1, 0, 0, 0),
(2, 'Stock', 1, 0, 1, 1, 1, 0, 0, 0),
(3, 'Crm', 0, 0, 1, 1, 1, 0, 0, 0),
(4, 'Project', 0, 0, 0, 1, 1, 1, 0, 0),
(5, 'Accounts', 0, 0, 0, 1, 1, 0, 0, 0),
(6, 'Miscellaneous', 0, 0, 0, 1, 1, 0, 0, 0),
(7, 'Assign Project', 0, 1, 0, 0, 1, 0, 0, 0),
(8, 'Customer Profile', 0, 0, 0, 0, 1, 0, 0, 0),
(9, 'Employees', 0, 0, 0, 0, 1, 0, 0, 0),
(10, 'Reports', 0, 0, 0, 1, 1, 0, 0, 0),
(11, 'Delete', 1, 1, 1, 1, 1, 1, 1, 1),
(12, 'POS', 1, 1, 1, 1, 1, 1, 1, 1),
(13, 'Sales Edit', 1, 1, 1, 1, 1, 1, 1, 1),
(14, 'Stock Edit', 1, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `geopos_products`
--

CREATE TABLE `geopos_products` (
  `pid` int(11) NOT NULL,
  `pcat` int(3) NOT NULL DEFAULT 1,
  `warehouse` int(11) NOT NULL DEFAULT 1,
  `product_name` varchar(80) NOT NULL,
  `product_code` varchar(30) DEFAULT NULL,
  `product_price` decimal(16,2) DEFAULT 0.00,
  `fproduct_price` decimal(16,2) DEFAULT 0.00,
  `taxrate` decimal(16,2) DEFAULT 0.00,
  `disrate` decimal(16,2) DEFAULT 0.00,
  `qty` decimal(10,2) NOT NULL,
  `product_des` text DEFAULT NULL,
  `alert` int(11) DEFAULT NULL,
  `unit` varchar(4) DEFAULT NULL,
  `image` varchar(120) DEFAULT 'default.png',
  `barcode` varchar(40) DEFAULT NULL,
  `merge` int(2) NOT NULL,
  `sub` int(11) NOT NULL,
  `vb` int(11) NOT NULL,
  `expiry` date DEFAULT NULL,
  `code_type` varchar(8) DEFAULT 'EAN13',
  `sub_id` int(11) DEFAULT 0,
  `b_id` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_product_cat`
--

CREATE TABLE `geopos_product_cat` (
  `id` int(3) NOT NULL,
  `title` varchar(100) NOT NULL,
  `extra` varchar(255) DEFAULT NULL,
  `c_type` int(2) DEFAULT 0,
  `rel_id` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `geopos_product_cat`
--

INSERT INTO `geopos_product_cat` (`id`, `title`, `extra`, `c_type`, `rel_id`) VALUES
(1, 'General', 'General Cat', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `geopos_product_serials`
--

CREATE TABLE `geopos_product_serials` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `serial` varchar(200) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_projects`
--

CREATE TABLE `geopos_projects` (
  `id` int(11) NOT NULL,
  `p_id` varchar(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` enum('Waiting','Pending','Terminated','Finished','Progress') NOT NULL DEFAULT 'Pending',
  `priority` enum('Low','Medium','High','Urgent') NOT NULL DEFAULT 'Medium',
  `progress` int(3) NOT NULL,
  `cid` int(11) NOT NULL,
  `sdate` date NOT NULL,
  `edate` date NOT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `phase` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `worth` decimal(16,2) NOT NULL DEFAULT 0.00,
  `ptype` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_project_meta`
--

CREATE TABLE `geopos_project_meta` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `meta_key` int(11) NOT NULL,
  `meta_data` varchar(200) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `key3` varchar(20) DEFAULT NULL,
  `key4` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_promo`
--

CREATE TABLE `geopos_promo` (
  `id` int(11) NOT NULL,
  `code` varchar(15) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `valid` date NOT NULL,
  `active` int(1) NOT NULL,
  `note` varchar(100) NOT NULL,
  `reflect` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `available` int(11) NOT NULL,
  `location` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_purchase`
--

CREATE TABLE `geopos_purchase` (
  `id` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `invoicedate` date NOT NULL,
  `invoiceduedate` date NOT NULL,
  `subtotal` decimal(16,2) DEFAULT 0.00,
  `shipping` decimal(16,2) DEFAULT 0.00,
  `ship_tax` decimal(16,2) DEFAULT NULL,
  `ship_tax_type` enum('incl','excl','off') DEFAULT 'off',
  `discount` decimal(16,2) DEFAULT 0.00,
  `tax` decimal(16,2) DEFAULT 0.00,
  `total` decimal(16,2) DEFAULT 0.00,
  `pmethod` varchar(14) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `status` enum('paid','due','canceled','partial') DEFAULT 'due',
  `csd` int(5) NOT NULL DEFAULT 0,
  `eid` int(4) NOT NULL,
  `pamnt` decimal(16,2) DEFAULT 0.00,
  `items` decimal(10,2) NOT NULL,
  `taxstatus` enum('yes','no','incl','cgst','igst') DEFAULT 'yes',
  `discstatus` tinyint(1) NOT NULL,
  `format_discount` enum('%','flat','b_p','bflat') DEFAULT NULL,
  `refer` varchar(20) DEFAULT NULL,
  `term` int(3) NOT NULL,
  `loc` int(4) NOT NULL,
  `multi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_purchase_items`
--

CREATE TABLE `geopos_purchase_items` (
  `id` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `product` varchar(255) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `qty` decimal(10,2) NOT NULL,
  `price` decimal(16,2) DEFAULT 0.00,
  `tax` decimal(16,2) DEFAULT 0.00,
  `discount` decimal(16,2) DEFAULT 0.00,
  `subtotal` decimal(16,2) DEFAULT 0.00,
  `totaltax` decimal(16,2) DEFAULT 0.00,
  `totaldiscount` decimal(16,2) DEFAULT 0.00,
  `product_des` text DEFAULT NULL,
  `unit` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_quotes`
--

CREATE TABLE `geopos_quotes` (
  `id` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `invoicedate` date NOT NULL,
  `invoiceduedate` date NOT NULL,
  `subtotal` decimal(16,2) DEFAULT 0.00,
  `shipping` decimal(16,2) DEFAULT 0.00,
  `ship_tax` decimal(16,2) DEFAULT NULL,
  `ship_tax_type` enum('incl','excl','off') DEFAULT 'off',
  `discount` decimal(16,2) DEFAULT 0.00,
  `tax` decimal(16,2) DEFAULT 0.00,
  `total` decimal(16,2) DEFAULT 0.00,
  `pmethod` varchar(14) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `status` enum('pending','accepted','rejected','customer_approved') DEFAULT 'pending',
  `csd` int(5) NOT NULL DEFAULT 0,
  `eid` int(4) NOT NULL,
  `pamnt` decimal(16,2) NOT NULL,
  `items` decimal(10,2) NOT NULL,
  `taxstatus` enum('yes','no','incl','cgst','igst') DEFAULT 'yes',
  `discstatus` tinyint(1) NOT NULL,
  `format_discount` enum('%','flat','b_p','bflat') DEFAULT '%',
  `refer` varchar(20) DEFAULT NULL,
  `term` int(3) NOT NULL,
  `proposal` text DEFAULT NULL,
  `multi` int(4) DEFAULT NULL,
  `loc` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_quotes_items`
--

CREATE TABLE `geopos_quotes_items` (
  `id` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `product` varchar(255) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `qty` decimal(16,2) NOT NULL,
  `price` decimal(16,2) DEFAULT 0.00,
  `tax` decimal(16,2) DEFAULT 0.00,
  `discount` decimal(16,2) DEFAULT 0.00,
  `subtotal` decimal(16,2) DEFAULT 0.00,
  `totaltax` decimal(16,2) DEFAULT 0.00,
  `totaldiscount` decimal(16,2) DEFAULT 0.00,
  `product_des` text DEFAULT NULL,
  `unit` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_register`
--

CREATE TABLE `geopos_register` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `o_date` datetime NOT NULL,
  `c_date` datetime NOT NULL,
  `cash` decimal(16,2) NOT NULL,
  `card` decimal(16,2) NOT NULL,
  `bank` decimal(16,2) NOT NULL,
  `cheque` decimal(16,2) NOT NULL,
  `r_change` decimal(16,2) NOT NULL,
  `active` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `geopos_register`
--

INSERT INTO `geopos_register` (`id`, `uid`, `o_date`, `c_date`, `cash`, `card`, `bank`, `cheque`, `r_change`, `active`) VALUES
(1, 15, '2023-01-11 18:41:23', '0000-00-00 00:00:00', '0.00', '0.00', '0.00', '0.00', '0.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `geopos_reports`
--

CREATE TABLE `geopos_reports` (
  `id` int(11) NOT NULL,
  `month` varchar(10) DEFAULT NULL,
  `year` int(4) NOT NULL,
  `invoices` int(11) NOT NULL,
  `sales` decimal(16,2) DEFAULT 0.00,
  `items` decimal(10,2) NOT NULL,
  `income` decimal(16,2) DEFAULT 0.00,
  `expense` decimal(16,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_restkeys`
--

CREATE TABLE `geopos_restkeys` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `key` varchar(40) DEFAULT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT 0,
  `is_private_key` tinyint(1) NOT NULL DEFAULT 0,
  `ip_addresses` text DEFAULT NULL,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_smtp`
--

CREATE TABLE `geopos_smtp` (
  `id` int(11) NOT NULL,
  `host` varchar(100) NOT NULL,
  `port` int(11) NOT NULL,
  `auth` enum('true','false') NOT NULL,
  `auth_type` enum('none','tls','ssl') NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `sender` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `geopos_smtp`
--

INSERT INTO `geopos_smtp` (`id`, `host`, `port`, `auth`, `auth_type`, `username`, `password`, `sender`) VALUES
(1, 'smtp.com', 587, 'true', 'none', 'support@example.com', '123456', 'support@example.com');

-- --------------------------------------------------------

--
-- Table structure for table `geopos_stock_r`
--

CREATE TABLE `geopos_stock_r` (
  `id` int(11) NOT NULL,
  `tid` int(8) NOT NULL,
  `invoicedate` date NOT NULL,
  `invoiceduedate` date NOT NULL,
  `subtotal` decimal(16,2) DEFAULT 0.00,
  `shipping` decimal(16,2) DEFAULT 0.00,
  `ship_tax` decimal(16,2) DEFAULT NULL,
  `ship_tax_type` enum('incl','excl','off') DEFAULT 'off',
  `discount` decimal(16,2) DEFAULT 0.00,
  `tax` decimal(16,2) DEFAULT 0.00,
  `total` decimal(16,2) DEFAULT 0.00,
  `pmethod` varchar(14) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `status` enum('pending','accepted','rejected','partial','canceled') DEFAULT 'pending',
  `csd` int(5) NOT NULL DEFAULT 0,
  `eid` int(4) NOT NULL,
  `pamnt` decimal(16,2) DEFAULT 0.00,
  `items` decimal(10,0) NOT NULL,
  `taxstatus` enum('yes','no','incl','cgst','igst') DEFAULT 'yes',
  `discstatus` tinyint(1) NOT NULL,
  `format_discount` enum('%','flat','bflat','b_p') DEFAULT NULL,
  `refer` varchar(20) DEFAULT NULL,
  `term` int(3) NOT NULL,
  `loc` int(4) NOT NULL,
  `i_class` int(1) NOT NULL DEFAULT 0,
  `multi` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_stock_r_items`
--

CREATE TABLE `geopos_stock_r_items` (
  `id` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `product` varchar(255) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `qty` decimal(10,2) NOT NULL,
  `price` decimal(16,2) DEFAULT 0.00,
  `tax` decimal(16,2) DEFAULT 0.00,
  `discount` decimal(16,2) DEFAULT 0.00,
  `subtotal` decimal(16,2) DEFAULT 0.00,
  `totaltax` decimal(16,2) DEFAULT 0.00,
  `totaldiscount` decimal(16,2) DEFAULT 0.00,
  `product_des` text DEFAULT NULL,
  `unit` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_supplier`
--

CREATE TABLE `geopos_supplier` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `region` varchar(30) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `postbox` varchar(20) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `picture` varchar(100) NOT NULL DEFAULT 'example.png',
  `gid` int(5) NOT NULL DEFAULT 1,
  `company` varchar(100) DEFAULT NULL,
  `taxid` varchar(100) DEFAULT NULL,
  `loc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_system`
--

CREATE TABLE `geopos_system` (
  `id` int(1) NOT NULL,
  `cname` char(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(30) NOT NULL,
  `region` varchar(40) NOT NULL,
  `country` varchar(30) NOT NULL,
  `postbox` varchar(15) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL,
  `taxid` varchar(20) NOT NULL,
  `tax` int(11) NOT NULL,
  `currency` varchar(4) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `currency_format` int(1) NOT NULL,
  `prefix` varchar(5) NOT NULL,
  `dformat` int(1) NOT NULL,
  `zone` varchar(25) NOT NULL,
  `logo` varchar(30) NOT NULL,
  `lang` varchar(20) DEFAULT 'english',
  `foundation` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `geopos_system`
--

INSERT INTO `geopos_system` (`id`, `cname`, `address`, `city`, `region`, `country`, `postbox`, `phone`, `email`, `taxid`, `tax`, `currency`, `currency_format`, `prefix`, `dformat`, `zone`, `logo`, `lang`, `foundation`) VALUES
(1, 'ABC Company', '412 Example South Street,', 'Los Angeles', 'FL', 'USA', '123', '410-987-89-60', 'support@ultimatekode.com', '23442', -1, '$', 0, 'SRN', 1, 'Etc/Greenwich', 'logo.png', 'english', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `geopos_terms`
--

CREATE TABLE `geopos_terms` (
  `id` int(4) NOT NULL,
  `title` varchar(100) NOT NULL,
  `type` int(1) NOT NULL,
  `terms` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `geopos_terms`
--

INSERT INTO `geopos_terms` (`id`, `title`, `type`, `terms`) VALUES
(1, 'Payment On Receipt', 0, '<p>1. 10% discount if payment received within ten days otherwise payment 30 days\n            after invoice date<br></p>');

-- --------------------------------------------------------

--
-- Table structure for table `geopos_tickets`
--

CREATE TABLE `geopos_tickets` (
  `id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `cid` int(11) NOT NULL,
  `status` enum('Solved','Processing','Waiting') NOT NULL,
  `section` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_tickets_th`
--

CREATE TABLE `geopos_tickets_th` (
  `id` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `message` text DEFAULT NULL,
  `cid` int(11) NOT NULL,
  `eid` int(11) NOT NULL,
  `cdate` datetime NOT NULL,
  `attach` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_todolist`
--

CREATE TABLE `geopos_todolist` (
  `id` int(11) NOT NULL,
  `tdate` date NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `status` enum('Due','Done','Progress') NOT NULL DEFAULT 'Due',
  `start` date NOT NULL,
  `duedate` date NOT NULL,
  `description` text DEFAULT NULL,
  `eid` int(11) NOT NULL,
  `aid` int(11) NOT NULL,
  `related` int(11) NOT NULL,
  `priority` enum('Low','Medium','High','Urgent') NOT NULL,
  `rid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_transactions`
--

CREATE TABLE `geopos_transactions` (
  `id` int(11) NOT NULL,
  `acid` int(11) NOT NULL,
  `account` varchar(200) NOT NULL,
  `type` enum('Income','Expense','Transfer') NOT NULL,
  `cat` varchar(200) NOT NULL,
  `debit` decimal(16,2) DEFAULT 0.00,
  `credit` decimal(16,2) DEFAULT 0.00,
  `payer` varchar(200) DEFAULT NULL,
  `payerid` int(11) NOT NULL DEFAULT 0,
  `method` varchar(200) DEFAULT NULL,
  `date` date NOT NULL,
  `tid` int(11) NOT NULL DEFAULT 0,
  `eid` int(11) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `ext` int(1) DEFAULT 0,
  `loc` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_trans_cat`
--

CREATE TABLE `geopos_trans_cat` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `geopos_trans_cat`
--

INSERT INTO `geopos_trans_cat` (`id`, `name`) VALUES
(1, 'Income'),
(2, 'Expenses'),
(3, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `geopos_units`
--

CREATE TABLE `geopos_units` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `code` varchar(5) NOT NULL,
  `type` int(1) NOT NULL,
  `sub` int(1) NOT NULL,
  `rid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geopos_users`
--

CREATE TABLE `geopos_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(100) NOT NULL,
  `pass` varchar(64) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `banned` tinyint(1) DEFAULT 0,
  `last_login` datetime DEFAULT NULL,
  `last_activity` datetime DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `forgot_exp` text DEFAULT NULL,
  `remember_time` datetime DEFAULT NULL,
  `remember_exp` text DEFAULT NULL,
  `verification_code` text DEFAULT NULL,
  `totp_secret` varchar(16) DEFAULT NULL,
  `ip_address` text DEFAULT NULL,
  `roleid` int(1) NOT NULL,
  `picture` varchar(50) DEFAULT NULL,
  `loc` int(11) NOT NULL,
  `lang` char(15) NOT NULL DEFAULT 'english'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `geopos_users`
--

INSERT INTO `geopos_users` (`id`, `email`, `pass`, `username`, `banned`, `last_login`, `last_activity`, `date_created`, `forgot_exp`, `remember_time`, `remember_exp`, `verification_code`, `totp_secret`, `ip_address`, `roleid`, `picture`, `loc`, `lang`) VALUES
(15, 'admin@admin.com', '196075d3b960128ae4a5cf79596d3d06ed482c5535c813ec0c7dbc2e6be032be', 'admin', 0, '2023-01-11 18:02:39', '2023-01-11 18:02:39', '2023-01-11 19:02:18', NULL, NULL, NULL, '', NULL, '::1', 5, 'example.png', 0, 'english');

-- --------------------------------------------------------

--
-- Table structure for table `geopos_warehouse`
--

CREATE TABLE `geopos_warehouse` (
  `id` int(3) NOT NULL,
  `title` varchar(100) NOT NULL,
  `extra` varchar(255) DEFAULT NULL,
  `loc` int(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `geopos_warehouse`
--

INSERT INTO `geopos_warehouse` (`id`, `title`, `extra`, `loc`) VALUES
(1, 'Main WareHouse', 'The Main WareHouse', 0);

-- --------------------------------------------------------

--
-- Table structure for table `univarsal_api`
--

CREATE TABLE `univarsal_api` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `key1` varchar(255) DEFAULT NULL,
  `key2` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `method` varchar(10) DEFAULT NULL,
  `other` text DEFAULT NULL,
  `active` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `univarsal_api`
--

INSERT INTO `univarsal_api` (`id`, `name`, `key1`, `key2`, `url`, `method`, `other`, `active`) VALUES
(1, 'Goo.gl URL Shortner', 'yourkey', '0', '0', '0', '0', 0),
(2, 'Twilio SMS API', 'ac', 'key', '+11234567', '0', '0', 1),
(3, 'Company Support', '1', '1', 'support@gmail.com', NULL, '<p>Your footer</p>', 1),
(4, 'Currency', '.', ',', '2', 'l', NULL, NULL),
(5, 'Exchange', 'key1v', 'key2', 'USD', NULL, NULL, 0),
(6, 'New Invoice Notification', '[{Company}] Invoice #{BillNumber} Generated', NULL, NULL, NULL, '<p>Dear\n            Client,\r\n</p><p>We are contacting you in regard to a payment received for invoice # {BillNumber} that has\n            been created on your account. You may find the invoice with below link.\r\n\r\nView\n            Invoice\r\n{URL}\r\n\r\nWe look forward to conducting future business with you.\r\n\r\nKind\n            Regards,\r\nTeam\r\n{CompanyDetails}</p>', NULL),
(7, 'Invoice Payment Reminder', '[{Company}] Invoice #{BillNumber} Payment Reminder', NULL, NULL, NULL, '<p>Dear\n            Client,</p><p>We are contacting you in regard to a payment reminder of invoice # {BillNumber} that has been\n            created on your account. You may find the invoice with below link. Please pay the balance of {Amount} due by\n            {DueDate}.</p><p>\r\n\r\n<b>View Invoice</b></p><p><span style=\"font-size: 1rem;\">{URL}\r\n</span></p><p>\n            <span style=\"font-size: 1rem;\">\r\nWe look forward to conducting future business with you.</span></p><p>\n            <span style=\"font-size: 1rem;\">\r\n\r\nKind Regards,\r\n</span></p><p><span style=\"font-size: 1rem;\">\r\nTeam\r\n</span>\n        </p><p><span style=\"font-size: 1rem;\">\r\n{CompanyDetails}</span></p>', NULL),
(8, 'Invoice Refund Proceeded', '{Company} Invoice #{BillNumber} Refund Proceeded', NULL, NULL, NULL, '<p>Dear\n            Client,</p><p>\r\nWe are contacting you in regard to a refund request processed for invoice # {BillNumber}\n            that has been created on your account. You may find the invoice with below link. Please pay the balance of\n            {Amount} by {DueDate}.\r\n</p><p>\r\nView Invoice\r\n</p><p>{URL}\r\n</p><p>\r\nWe look forward to\n            conducting future business with you.\r\n</p><p>\r\nKind Regards,\r\n</p><p>\n            \r\nTeam\r\n\r\n{CompanyDetails}</p>', NULL),
(9, 'Invoice payment Received', '{Company} Payment Received for Invoice #{BillNumber}', NULL, NULL, NULL, '<p>\n            Dear Client,\r\n</p><p>We are contacting you in regard to a payment received for invoice # {BillNumber} that\n            has been created on your account. You can find the invoice with below link.\r\n</p><p>\r\nView Invoice</p>\n        <p>\r\n{URL}\r\n</p><p>\r\nWe look forward to conducting future business with you.\r\n</p><p>\r\nKind\n            Regards,\r\n</p><p>\r\nTeam\r\n</p><p>\r\n{CompanyDetails}</p>', NULL),
(10, 'Invoice Overdue Notice', '{Company} Invoice #{BillNumber} Generated for you', NULL, NULL, NULL, '<p>Dear\n            Client,</p><p>\r\nWe are contacting you in regard to an Overdue Notice for invoice # {BillNumber} that has\n            been created on your account. You may find the invoice with below link.\r\nPlease pay the balance of\n            {Amount} due by {DueDate}.\r\n</p><p>View Invoice\r\n</p><p>{URL}\r\n</p><p>\r\nWe look forward to\n            conducting future business with you.\r\n</p><p>\r\nKind Regards,\r\n</p><p>\r\nTeam</p><p>\n            \r\n\r\n{CompanyDetails}</p>', NULL),
(11, 'Quote Proposal', '{Company} Quote #{BillNumber} Generated for you', NULL, NULL, NULL, '<p>Dear Client,</p>\n        <p>\r\nWe are contacting you in regard to a new quote # {BillNumber} that has been created on your account. You\n            may find the quote with below link.\r\n</p><p>\r\nView Invoice\r\n</p><p>{URL}\r\n</p><p>\r\nWe look forward\n            to conducting future business with you.</p><p>\r\n\r\nKind Regards,</p><p>\r\n\r\nTeam</p><p>\n            \r\n\r\n{CompanyDetails}</p>', NULL),
(12, 'Purchase Order Request', '{Company} Purchase Order #{BillNumber} Requested', NULL, NULL, NULL, '<p>Dear\n            Client,\r\n</p><p>We are contacting you in regard to a new purchase # {BillNumber} that has been requested\n            on your account. You may find the order with below link. </p><p>\r\n\r\nView Invoice\r\n</p><p>{URL}</p><p>\n            \r\n\r\nWe look forward to conducting future business with you.</p><p>\r\n\r\nKind Regards,\r\n</p><p>\n            \r\nTeam</p><p>\r\n\r\n{CompanyDetails}</p>', NULL),
(13, 'Stock Return Mail', '{Company} New purchase return # {BillNumber}', NULL, NULL, NULL, 'Dear Client,\r\n\r\nWe are contacting you in regard to a new purchase return # {BillNumber} that has been requested on your account. You may find the order with below link.\r\n\r\nView Invoice\r\n\r\n{URL}\r\n\r\nWe look forward to conducting future business with you.\r\n\r\nKind Regards,\r\n\r\nTeam\r\n\r\n{CompanyDetails}', NULL),
(14, 'Customer Registration', '{Company}  Customer Registration - {NAME}', NULL, NULL, NULL, 'Dear Customer,\r\nThank You for registration, please confirm the registration by the following URL {REG_URL}\r\nRegards', NULL),
(15, ' Customer Password Reset', '{Company}  Customer Password Reset- {NAME}', NULL, NULL, NULL, 'Dear Customer,\r\nPlease reset the password by the following URL {RESET_URL}\r\nRegards', NULL),
(16, 'Customer Registration by Employee', '{Company}  Customer Registration - {NAME}', '0', '0', '0', 'Dear Customer,\r\nThank You for registration.\r\nLogin URL: {URL}\r\nLogin Email: {EMAIL}\r\nPassword: {PASSWORD}\r\n\r\nRegards\r\n{CompanyDetails}', 0),
(30, 'New Invoice Notification', NULL, NULL, NULL, NULL, 'Dear Customer, new invoice  # {BillNumber} generated. {URL} Regards', NULL),
(31, 'Invoice Payment Reminder', NULL, NULL, NULL, NULL, 'Dear Customer, Please make payment of invoice  # {BillNumber}. {URL} Regards', NULL),
(32, 'Invoice Refund Proceeded', NULL, NULL, NULL, NULL, 'Dear Customer, Refund generated of invoice # {BillNumber}. {URL} Regards', NULL),
(33, 'Invoice payment Received', NULL, NULL, NULL, NULL, 'Dear Customer, Payment received of invoice # {BillNumber}. {URL} Regards', NULL),
(34, 'Invoice Overdue Notice', NULL, NULL, NULL, NULL, 'Dear Customer, Dear Customer,Payment is overdue of invoice # {BillNumber}. {URL} Regards', NULL),
(35, 'Quote Proposal', NULL, NULL, NULL, NULL, 'Dear Customer, Dear Customer, a quote created for you # {BillNumber}. {URL} Regards', NULL),
(36, 'Purchase Order Request', NULL, NULL, NULL, NULL, 'Dear Customer, Dear, a purchased order for you # {BillNumber}. {URL} Regards', NULL),
(51, 'QT#', 'PO#', 'SUB#', 'SR#', 'TRN#', 'SRN#', 1),
(52, 'ThermalPrint', '0', NULL, NULL, NULL, 'POS#', 0),
(53, 'ConfPort', 'Public Key', '0', 'Private Key', NULL, NULL, 1),
(54, 'online_payment', '1', 'USD', '1', '1', NULL, 1),
(55, 'CronJob', '99293768', 'rec_email', 'email', 'rec_due', 'recemail', NULL),
(56, 'Auto Email SMS', 'email', 'sms', NULL, NULL, NULL, NULL),
(60, 'Warehouse', '1', NULL, NULL, NULL, NULL, NULL),
(61, 'Discount & Shipping', '%', '10.00', 'incl', NULL, '% Discount After TAX', NULL),
(62, 'AutoAttendance', '1', '0', '0', '0', '0', NULL),
(63, 'Zero Stock Billing', '1', '0', '0', '0', '0', 0),
(64, 'FrontEndSection', '0', '0', '0', '0', NULL, 0),
(65, 'Dual Entry', '0', '1', '0', '0', '0', 0),
(66, 'Email Alert', '0', '0', 'sample@email.com', '0', '0', 0),
(67, 'billing_settings', '0', '0', NULL, NULL, NULL, NULL),
(69, 'pos_settings', '1', NULL, NULL, NULL, NULL, NULL),
(70, 'DB-B-150', '4a99003dd3aa27b87fabfa153f1ab06a2ff08c3d', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `users_id` int(11) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `var_key` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_deleted` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `user_type` varchar(255) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `lang` varchar(25) NOT NULL DEFAULT 'english',
  `code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`users_id`, `user_id`, `var_key`, `status`, `is_deleted`, `name`, `password`, `email`, `profile_pic`, `user_type`, `cid`, `lang`, `code`) VALUES
(1, '1', NULL, 'active', '0', 'Walk-in Client', '$2y$10$TKfTVltchv/jxZIouy8i8O7rSzVvtdx4Y5wNRodK5RNyTBJkEoIAW', 'example@example.com', NULL, 'Member', 1, 'english', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `geopos_accounts`
--
ALTER TABLE `geopos_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `acn` (`acn`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `geopos_attendance`
--
ALTER TABLE `geopos_attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emp` (`emp`);

--
-- Indexes for table `geopos_bank_ac`
--
ALTER TABLE `geopos_bank_ac`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `geopos_config`
--
ALTER TABLE `geopos_config`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `geopos_currencies`
--
ALTER TABLE `geopos_currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `geopos_customers`
--
ALTER TABLE `geopos_customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gid` (`gid`);

--
-- Indexes for table `geopos_custom_data`
--
ALTER TABLE `geopos_custom_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fid` (`field_id`,`rid`);

--
-- Indexes for table `geopos_custom_fields`
--
ALTER TABLE `geopos_custom_fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `f_module` (`f_module`);

--
-- Indexes for table `geopos_cust_group`
--
ALTER TABLE `geopos_cust_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `geopos_documents`
--
ALTER TABLE `geopos_documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `geopos_draft`
--
ALTER TABLE `geopos_draft`
  ADD PRIMARY KEY (`id`),
  ADD KEY `eid` (`eid`),
  ADD KEY `csd` (`csd`),
  ADD KEY `invoice` (`tid`) USING BTREE,
  ADD KEY `i_class` (`i_class`),
  ADD KEY `loc` (`loc`);

--
-- Indexes for table `geopos_draft_items`
--
ALTER TABLE `geopos_draft_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice` (`tid`),
  ADD KEY `i_class` (`i_class`);

--
-- Indexes for table `geopos_employees`
--
ALTER TABLE `geopos_employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `geopos_events`
--
ALTER TABLE `geopos_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rel` (`rel`),
  ADD KEY `rid` (`rid`);

--
-- Indexes for table `geopos_gateways`
--
ALTER TABLE `geopos_gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `geopos_hrm`
--
ALTER TABLE `geopos_hrm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `geopos_invoices`
--
ALTER TABLE `geopos_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `eid` (`eid`),
  ADD KEY `csd` (`csd`),
  ADD KEY `invoice` (`tid`) USING BTREE,
  ADD KEY `i_class` (`i_class`),
  ADD KEY `loc` (`loc`);

--
-- Indexes for table `geopos_invoice_items`
--
ALTER TABLE `geopos_invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice` (`tid`),
  ADD KEY `i_class` (`i_class`);

--
-- Indexes for table `geopos_locations`
--
ALTER TABLE `geopos_locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `geopos_log`
--
ALTER TABLE `geopos_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `geopos_login_attempts`
--
ALTER TABLE `geopos_login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `geopos_metadata`
--
ALTER TABLE `geopos_metadata`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`),
  ADD KEY `rid` (`rid`);

--
-- Indexes for table `geopos_milestones`
--
ALTER TABLE `geopos_milestones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `geopos_movers`
--
ALTER TABLE `geopos_movers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `d_type` (`d_type`,`rid1`,`rid2`,`rid3`);

--
-- Indexes for table `geopos_notes`
--
ALTER TABLE `geopos_notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `geopos_pms`
--
ALTER TABLE `geopos_pms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `full_index` (`id`,`sender_id`,`receiver_id`,`date_read`);

--
-- Indexes for table `geopos_premissions`
--
ALTER TABLE `geopos_premissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `geopos_products`
--
ALTER TABLE `geopos_products`
  ADD PRIMARY KEY (`pid`),
  ADD KEY `pcat` (`pcat`),
  ADD KEY `warehouse` (`warehouse`);

--
-- Indexes for table `geopos_product_cat`
--
ALTER TABLE `geopos_product_cat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `geopos_product_serials`
--
ALTER TABLE `geopos_product_serials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `geopos_projects`
--
ALTER TABLE `geopos_projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `p_id` (`p_id`);

--
-- Indexes for table `geopos_project_meta`
--
ALTER TABLE `geopos_project_meta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid` (`pid`),
  ADD KEY `meta_key` (`meta_key`),
  ADD KEY `key3` (`key3`);

--
-- Indexes for table `geopos_promo`
--
ALTER TABLE `geopos_promo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code_2` (`code`),
  ADD KEY `code` (`code`);

--
-- Indexes for table `geopos_purchase`
--
ALTER TABLE `geopos_purchase`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice` (`tid`),
  ADD KEY `eid` (`eid`),
  ADD KEY `csd` (`csd`);

--
-- Indexes for table `geopos_purchase_items`
--
ALTER TABLE `geopos_purchase_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice` (`tid`);

--
-- Indexes for table `geopos_quotes`
--
ALTER TABLE `geopos_quotes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice` (`tid`),
  ADD KEY `eid` (`eid`),
  ADD KEY `csd` (`csd`);

--
-- Indexes for table `geopos_quotes_items`
--
ALTER TABLE `geopos_quotes_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice` (`tid`);

--
-- Indexes for table `geopos_register`
--
ALTER TABLE `geopos_register`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `active` (`active`);

--
-- Indexes for table `geopos_reports`
--
ALTER TABLE `geopos_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `geopos_restkeys`
--
ALTER TABLE `geopos_restkeys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `geopos_smtp`
--
ALTER TABLE `geopos_smtp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `geopos_stock_r`
--
ALTER TABLE `geopos_stock_r`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice` (`tid`),
  ADD KEY `eid` (`eid`),
  ADD KEY `csd` (`csd`);

--
-- Indexes for table `geopos_stock_r_items`
--
ALTER TABLE `geopos_stock_r_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice` (`tid`) KEY_BLOCK_SIZE=1024 USING BTREE;

--
-- Indexes for table `geopos_supplier`
--
ALTER TABLE `geopos_supplier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gid` (`gid`);

--
-- Indexes for table `geopos_system`
--
ALTER TABLE `geopos_system`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `geopos_terms`
--
ALTER TABLE `geopos_terms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `geopos_tickets`
--
ALTER TABLE `geopos_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `geopos_tickets_th`
--
ALTER TABLE `geopos_tickets_th`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tid` (`tid`),
  ADD KEY `cid` (`cid`),
  ADD KEY `eid` (`eid`);

--
-- Indexes for table `geopos_todolist`
--
ALTER TABLE `geopos_todolist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `geopos_transactions`
--
ALTER TABLE `geopos_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loc` (`loc`),
  ADD KEY `acid` (`acid`),
  ADD KEY `eid` (`eid`),
  ADD KEY `tid` (`tid`);

--
-- Indexes for table `geopos_trans_cat`
--
ALTER TABLE `geopos_trans_cat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `geopos_units`
--
ALTER TABLE `geopos_units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `geopos_users`
--
ALTER TABLE `geopos_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `geopos_warehouse`
--
ALTER TABLE `geopos_warehouse`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `univarsal_api`
--
ALTER TABLE `univarsal_api`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`users_id`),
  ADD KEY `code` (`code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `geopos_accounts`
--
ALTER TABLE `geopos_accounts`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `geopos_attendance`
--
ALTER TABLE `geopos_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_bank_ac`
--
ALTER TABLE `geopos_bank_ac`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_config`
--
ALTER TABLE `geopos_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_currencies`
--
ALTER TABLE `geopos_currencies`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_customers`
--
ALTER TABLE `geopos_customers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `geopos_custom_data`
--
ALTER TABLE `geopos_custom_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_custom_fields`
--
ALTER TABLE `geopos_custom_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_cust_group`
--
ALTER TABLE `geopos_cust_group`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `geopos_documents`
--
ALTER TABLE `geopos_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_draft`
--
ALTER TABLE `geopos_draft`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_draft_items`
--
ALTER TABLE `geopos_draft_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_employees`
--
ALTER TABLE `geopos_employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `geopos_events`
--
ALTER TABLE `geopos_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_gateways`
--
ALTER TABLE `geopos_gateways`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `geopos_hrm`
--
ALTER TABLE `geopos_hrm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_invoices`
--
ALTER TABLE `geopos_invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_invoice_items`
--
ALTER TABLE `geopos_invoice_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_locations`
--
ALTER TABLE `geopos_locations`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_log`
--
ALTER TABLE `geopos_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `geopos_login_attempts`
--
ALTER TABLE `geopos_login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `geopos_metadata`
--
ALTER TABLE `geopos_metadata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_milestones`
--
ALTER TABLE `geopos_milestones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_movers`
--
ALTER TABLE `geopos_movers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_notes`
--
ALTER TABLE `geopos_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_pms`
--
ALTER TABLE `geopos_pms`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_premissions`
--
ALTER TABLE `geopos_premissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `geopos_products`
--
ALTER TABLE `geopos_products`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_product_cat`
--
ALTER TABLE `geopos_product_cat`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `geopos_product_serials`
--
ALTER TABLE `geopos_product_serials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_projects`
--
ALTER TABLE `geopos_projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_project_meta`
--
ALTER TABLE `geopos_project_meta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_promo`
--
ALTER TABLE `geopos_promo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_purchase`
--
ALTER TABLE `geopos_purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_purchase_items`
--
ALTER TABLE `geopos_purchase_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_quotes`
--
ALTER TABLE `geopos_quotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_quotes_items`
--
ALTER TABLE `geopos_quotes_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_register`
--
ALTER TABLE `geopos_register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `geopos_reports`
--
ALTER TABLE `geopos_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_restkeys`
--
ALTER TABLE `geopos_restkeys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_stock_r`
--
ALTER TABLE `geopos_stock_r`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_stock_r_items`
--
ALTER TABLE `geopos_stock_r_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_supplier`
--
ALTER TABLE `geopos_supplier`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_terms`
--
ALTER TABLE `geopos_terms`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `geopos_tickets`
--
ALTER TABLE `geopos_tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_tickets_th`
--
ALTER TABLE `geopos_tickets_th`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_todolist`
--
ALTER TABLE `geopos_todolist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_transactions`
--
ALTER TABLE `geopos_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_trans_cat`
--
ALTER TABLE `geopos_trans_cat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `geopos_units`
--
ALTER TABLE `geopos_units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geopos_users`
--
ALTER TABLE `geopos_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `geopos_warehouse`
--
ALTER TABLE `geopos_warehouse`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `univarsal_api`
--
ALTER TABLE `univarsal_api`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `users_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
