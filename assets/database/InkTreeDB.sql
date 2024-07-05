-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2024 at 02:16 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `inktreedb`
--
CREATE DATABASE IF NOT EXISTS `inktreedb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `inktreedb`;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `CUSTOMER_ID` int(11) NOT NULL,
  `CUSTOMER_NAME` varchar(100) DEFAULT NULL,
  `CUSTOMER_ADDRESS` varchar(255) DEFAULT NULL,
  `CUSTOMER_DELIVERY` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CUSTOMER_ID`, `CUSTOMER_NAME`, `CUSTOMER_ADDRESS`, `CUSTOMER_DELIVERY`) VALUES
(1, 'User 1', '123 Main St', '123 Delivery St');

-- --------------------------------------------------------

--
-- Table structure for table `customerproduct`
--

DROP TABLE IF EXISTS `customerproduct`;
CREATE TABLE `customerproduct` (
  `CUSTOMER_ID` int(11) NOT NULL,
  `PRODUCT_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
CREATE TABLE `customerpurchase` (
  `CUSTOMER_ID` int(11) NOT NULL,
  `PURCHASE_ID` int(11) NOT NULL,
  `CUSTOMERPURCHASE_DETAILS` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customerpurchase`
--

INSERT INTO `customerpurchase` (`CUSTOMER_ID`, `PURCHASE_ID`, `CUSTOMERPURCHASE_DETAILS`) VALUES
(1, 1, 'First purchase');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `PRODUCT_ID` int(11) NOT NULL,
  `PRODUCT_NAME` varchar(100) DEFAULT NULL,
  `PRODUCT_STOCK` int(11) DEFAULT NULL,
  `PRODUCT_PRICE` decimal(10,2) DEFAULT NULL,
  `PURCHASED_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`PRODUCT_ID`, `PRODUCT_NAME`, `PRODUCT_STOCK`, `PRODUCT_PRICE`, `PURCHASED_ID`) VALUES
(1, 'Product A', 100, 19.99, 1);

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

DROP TABLE IF EXISTS `purchase`;
CREATE TABLE `purchase` (
  `PURCHASE_ID` int(11) NOT NULL,
  `PURCHASE_TRACK_NUM` varchar(100) DEFAULT NULL,
  `TRANSACTION_REFERENTIAL_NUM` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`PURCHASE_ID`, `PURCHASE_TRACK_NUM`, `TRANSACTION_REFERENTIAL_NUM`) VALUES
(1, 'TRACK123', 1);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

DROP TABLE IF EXISTS `transaction`;
CREATE TABLE `transaction` (
  `TRANSACTION_REFERENTIAL_NUM` int(11) NOT NULL,
  `TRANSACTION_TYPE` varchar(50) DEFAULT NULL,
  `TRANSACTION_DATE` date DEFAULT NULL,
  `CUSTOMER_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`TRANSACTION_REFERENTIAL_NUM`, `TRANSACTION_TYPE`, `TRANSACTION_DATE`, `CUSTOMER_ID`) VALUES
(1, 'Purchase', '2024-07-05', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CUSTOMER_ID`);

--
-- Indexes for table `customerproduct`
--
ALTER TABLE `customerproduct`
  ADD PRIMARY KEY (`CUSTOMER_ID`,`PRODUCT_ID`),
  ADD KEY `PRODUCT_ID` (`PRODUCT_ID`);

--
-- Indexes for table `customerpurchase`
--
ALTER TABLE `customerpurchase`
  ADD PRIMARY KEY (`CUSTOMER_ID`,`PURCHASE_ID`),
  ADD KEY `PURCHASE_ID` (`PURCHASE_ID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`PRODUCT_ID`),
  ADD KEY `PURCHASED_ID` (`PURCHASED_ID`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`PURCHASE_ID`),
  ADD KEY `TRANSACTION_REFERENTIAL_NUM` (`TRANSACTION_REFERENTIAL_NUM`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`TRANSACTION_REFERENTIAL_NUM`),
  ADD KEY `CUSTOMER_ID` (`CUSTOMER_ID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customerproduct`
--
ALTER TABLE `customerproduct`
  ADD CONSTRAINT `customerproduct_ibfk_1` FOREIGN KEY (`CUSTOMER_ID`) REFERENCES `customer` (`CUSTOMER_ID`),
  ADD CONSTRAINT `customerproduct_ibfk_2` FOREIGN KEY (`PRODUCT_ID`) REFERENCES `product` (`PRODUCT_ID`);

--
-- Constraints for table `customerpurchase`
--
ALTER TABLE `customerpurchase`
  ADD CONSTRAINT `customerpurchase_ibfk_1` FOREIGN KEY (`CUSTOMER_ID`) REFERENCES `customer` (`CUSTOMER_ID`),
  ADD CONSTRAINT `customerpurchase_ibfk_2` FOREIGN KEY (`PURCHASE_ID`) REFERENCES `purchase` (`PURCHASE_ID`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`PURCHASED_ID`) REFERENCES `purchase` (`PURCHASE_ID`);

--
-- Constraints for table `purchase`
--
ALTER TABLE `purchase`
  ADD CONSTRAINT `purchase_ibfk_1` FOREIGN KEY (`TRANSACTION_REFERENTIAL_NUM`) REFERENCES `transaction` (`TRANSACTION_REFERENTIAL_NUM`);

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`CUSTOMER_ID`) REFERENCES `customer` (`CUSTOMER_ID`);
COMMIT;
