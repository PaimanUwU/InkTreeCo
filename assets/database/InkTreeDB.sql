-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2024 at 03:00 PM
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
-- Database: `inktreedb`
--
DROP DATABASE IF EXISTS `inktreedb`;
CREATE DATABASE IF NOT EXISTS `inktreedb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `inktreedb`;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `CUSTOMER_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CUSTOMER_NAME` varchar(100) DEFAULT NULL,
  `CUSTOMER_EMAIL` varchar(100) DEFAULT NULL,
  `CUSTOMER_PASSWORD` varchar(100) DEFAULT NULL,
  `CUSTOMER_ADDRESS` varchar(255) DEFAULT NULL,
  `CUSTOMER_PHONE` varchar(255) DEFAULT NULL,
  `CUSTOMER_CART` varchar(255) DEFAULT NULL,
  `CUSTOMER_IMAGE` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`CUSTOMER_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `customer`:
--

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CUSTOMER_ID`, `CUSTOMER_NAME`, `CUSTOMER_EMAIL`, `CUSTOMER_PASSWORD`, `CUSTOMER_ADDRESS`, `CUSTOMER_PHONE`, `CUSTOMER_CART`, `CUSTOMER_IMAGE`) VALUES
(1, 'User 1', 'user1@example.com', 'password1', '123 Main St', '123 Delivery St', 'Cart1', 'path/to/image1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `customerproduct`
--

DROP TABLE IF EXISTS `customerproduct`;
CREATE TABLE IF NOT EXISTS `customerproduct` (
  `CUSTOMER_ID` int(11) NOT NULL,
  `PRODUCT_ID` int(11) NOT NULL,
  PRIMARY KEY (`CUSTOMER_ID`,`PRODUCT_ID`),
  KEY `PRODUCT_ID` (`PRODUCT_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `customerproduct`:
--

--
-- Dumping data for table `customerproduct`
--

INSERT INTO `customerproduct` (`CUSTOMER_ID`, `PRODUCT_ID`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `customerpurchase`
--

DROP TABLE IF EXISTS `customerpurchase`;
CREATE TABLE IF NOT EXISTS `customerpurchase` (
  `CUSTOMER_ID` int(11) NOT NULL,
  `PURCHASE_ID` int(11) NOT NULL,
  `CUSTOMERPURCHASE_DETAILS` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`CUSTOMER_ID`,`PURCHASE_ID`),
  KEY `PURCHASE_ID` (`PURCHASE_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `customerpurchase`:
--

--
-- Dumping data for table `customerpurchase`
--

INSERT INTO `customerpurchase` (`CUSTOMER_ID`, `PURCHASE_ID`, `CUSTOMERPURCHASE_DETAILS`) VALUES
(1, 1, 'First purchase');

-- --------------------------------------------------------

--
-- Table structure for table `donation`
--

DROP TABLE IF EXISTS `donation`;
CREATE TABLE IF NOT EXISTS `donation` (
  `DONATION_ID` int(11) NOT NULL AUTO_INCREMENT,
  `DONATION_AMOUNT` decimal(10,2) DEFAULT NULL,
  `DONATION_DATE` date DEFAULT NULL,
  `CUSTOMER_ID` int(11) DEFAULT NULL,
  `TRANSACTION_REFERENTIAL_NUM` int(11) DEFAULT NULL,
  PRIMARY KEY (`DONATION_ID`),
  KEY `CUSTOMER_ID` (`CUSTOMER_ID`),
  KEY `TRANSACTION_REFERENTIAL_NUM` (`TRANSACTION_REFERENTIAL_NUM`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `donation`:
--

--
-- Dumping data for table `donation`
--

INSERT INTO `donation` (`DONATION_ID`, `DONATION_AMOUNT`, `DONATION_DATE`, `CUSTOMER_ID`, `TRANSACTION_REFERENTIAL_NUM`) VALUES
(1, 10.00, '2024-07-05', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `PRODUCT_ID` int(11) NOT NULL AUTO_INCREMENT,
  `PRODUCT_NAME` varchar(100) DEFAULT NULL,
  `PRODUCT_STOCK` int(11) DEFAULT NULL,
  `PRODUCT_PRICE` decimal(10,2) DEFAULT NULL,
  `PRODUCT_LIKE` int(11) DEFAULT NULL,
  `PRODUCT_IMAGE` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`PRODUCT_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `product`:
--

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`PRODUCT_ID`, `PRODUCT_NAME`, `PRODUCT_STOCK`, `PRODUCT_PRICE`, `PRODUCT_LIKE`, `PRODUCT_IMAGE`) VALUES
(1, 'Phone Stand', 100, 19.99, 50, '../assets/productImage/1.jpg'),
(2, 'Mini Chair Phone Stand', 230, 14.99, 33, '../assets/productImage/2.jpg'),
(3, 'Astronaut Phone Stand', 43, 29.99, 133, '../assets/productImage/3.jpg'),
(4, 'Bear Laptop Bag', 112, 49.99, 235, '../assets/productImage/4.jpg'),
(5, 'InkTreeCo Cap', 2342, 19.99, 2343, '../assets/productImage/5.jpg'),
(6, 'Cup', 443, 29.99, 444, '../assets/productImage/6.jpg'),
(7, 'Thermos', 553, 49.99, 443, '../assets/productImage/7.jpg'),
(8, 'Tote Bag', 6, 19.99, 4, '../assets/productImage/8.jpg'),
(9, 'Note Book', 1004, 9.99, 1903, '../assets/productImage/9.jpg'),
(10, 'Calculator', 239, 69.99, 123, '../assets/productImage/10.jpg'),
(11, 'Bamboo Laptop Stand', 554, 59.99, 526, '../assets/productImage/11.png'),
(12, 'Highlighters', 799, 9.99, 990, '../assets/productImage/12.jpg'),
(13, 'Laptop Sleeve', 876, 69.99, 123, '../assets/productImage/13.jpg'),
(14, 'Tablet Sleeve', 234, 59.99, 654, '../assets/productImage/14.jpg'),
(15, 'Color Pen', 124, 9.99, 8435, '../assets/productImage/15.jpg'),
(16, 'Lightweight Laptop Stand', 56, 39.99, 455, '../assets/productImage/16.jpg'),
(17, 'Positive Vibe Mug', 1239, 19.99, 2345, '../assets/productImage/17.jpg'),
(18, 'Glass Tumbler', 1244, 39.99, 455, '../assets/productImage/18.jpg'),
(19, 'Pencil Case', 643, 19.99, 1235, '../assets/productImage/19.jpg'),
(20, 'Sticky Note', 6543, 9.99, 436, '../assets/productImage/20.jpg'),
(21, 'Socks', 1249, 9.99, 235, '../assets/productImage/21.jpg'),
(22, 'Sock (Unisex)', 239, 19.99, 2335, '../assets/productImage/22.jpg'),
(23, 'Tote Bag (Collaboration With Ugh)', 6, 49.99, 7, '../assets/productImage/23.jpg'),
(24, 'Hard Cover Notebook', 2634, 29.99, 2342, '../assets/productImage/24.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

DROP TABLE IF EXISTS `purchase`;
CREATE TABLE IF NOT EXISTS `purchase` (
  `PURCHASE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `PURCHASE_TRACK_NUM` varchar(100) DEFAULT NULL,
  `PRODUCT_ID` int(11) DEFAULT NULL,
  `TRANSACTION_REFERENTIAL_NUM` int(11) DEFAULT NULL,
  PRIMARY KEY (`PURCHASE_ID`),
  KEY `TRANSACTION_REFERENTIAL_NUM` (`TRANSACTION_REFERENTIAL_NUM`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `purchase`:
--

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`PURCHASE_ID`, `PURCHASE_TRACK_NUM`, `PRODUCT_ID`, `TRANSACTION_REFERENTIAL_NUM`) VALUES
(1, 'TRACK123', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

DROP TABLE IF EXISTS `transaction`;
CREATE TABLE IF NOT EXISTS `transaction` (
  `TRANSACTION_REFERENTIAL_NUM` int(11) NOT NULL AUTO_INCREMENT,
  `TRANSACTION_TYPE` varchar(50) DEFAULT NULL,
  `TRANSACTION_DATE` date DEFAULT NULL,
  `TRANSACTION_AMOUNT` decimal(10,2) DEFAULT NULL,
  `CUSTOMER_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`TRANSACTION_REFERENTIAL_NUM`),
  KEY `CUSTOMER_ID` (`CUSTOMER_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `transaction`:
--

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`TRANSACTION_REFERENTIAL_NUM`, `TRANSACTION_TYPE`, `TRANSACTION_DATE`, `TRANSACTION_AMOUNT`, `CUSTOMER_ID`) VALUES
(1, 'Purchase', '2024-07-05', 19.99, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
