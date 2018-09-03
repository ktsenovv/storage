-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 
-- Версия на сървъра: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kdir`
--

-- --------------------------------------------------------

--
-- Структура на таблица `categories`
--

CREATE TABLE `categories` (
  `category_id` int(10) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Mouses'),
(3, 'Keybards'),
(4, 'Laptops');

-- --------------------------------------------------------

--
-- Структура на таблица `clients`
--

CREATE TABLE `clients` (
  `client_id` int(10) NOT NULL,
  `client_name` varchar(100) NOT NULL,
  `client_egn` varchar(20) NOT NULL,
  `client_address` varchar(100) NOT NULL,
  `client_phone` varchar(50) NOT NULL,
  `client_mol` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `clients`
--

INSERT INTO `clients` (`client_id`, `client_name`, `client_egn`, `client_address`, `client_phone`, `client_mol`) VALUES
(1, 'Christian Stone', '1739539594', 'San Francisco', '+359 3124', 'Christian Stone'),
(2, 'Denis Newman', '1853856483', 'San Diego', '+359 3123', 'Denis Newman');

-- --------------------------------------------------------

--
-- Структура на таблица `corders`
--

CREATE TABLE `corders` (
  `corder_id` int(10) NOT NULL,
  `corder_catid` int(10) NOT NULL,
  `corder_cntid` int(10) NOT NULL,
  `corder_name` varchar(250) NOT NULL,
  `corder_price` varchar(30) NOT NULL,
  `corder_amount` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `corders`
--

INSERT INTO `corders` (`corder_id`, `corder_catid`, `corder_cntid`, `corder_name`, `corder_price`, `corder_amount`) VALUES
(3, 1, 2, 'Mouse A4Tech', '30', 8),
(4, 4, 1, 'Laptop Acer', '1450', 5);

-- --------------------------------------------------------

--
-- Структура на таблица `sorders`
--

CREATE TABLE `sorders` (
  `sorder_id` int(10) NOT NULL,
  `sorder_catid` int(10) NOT NULL,
  `sorder_supid` int(10) NOT NULL,
  `sorder_name` varchar(250) NOT NULL,
  `sorder_price` varchar(30) NOT NULL,
  `sorder_amount` int(10) NOT NULL,
  `sorder_added` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `sorders`
--

INSERT INTO `sorders` (`sorder_id`, `sorder_catid`, `sorder_supid`, `sorder_name`, `sorder_price`, `sorder_amount`, `sorder_added`) VALUES
(1, 1, 1, 'Mouse A4Tech', '20', 5, 1),
(2, 1, 2, 'Mouse Genius', '40', 10, 1),
(3, 1, 1, 'Mouse A4Tech', '20', 5, 1),
(4, 1, 2, 'Mouse A4Tech', '20', 5, 1),
(5, 1, 1, 'Mouse A4Tech', '20', 5, 1),
(6, 1, 1, 'Mouse A4Tech', '20', 3, 1),
(7, 1, 1, 'Mouse Genius', '40', 7, 1),
(8, 4, 1, 'Laptop Acer', '1200', 10, 1),
(9, 1, 1, 'Mouse Genius', '40', 5, 1),
(10, 4, 2, 'Laptop Asus', '1325', 15, 1);

-- --------------------------------------------------------

--
-- Структура на таблица `storage`
--

CREATE TABLE `storage` (
  `item_id` int(10) NOT NULL,
  `item_catid` int(10) NOT NULL,
  `item_name` varchar(250) NOT NULL,
  `item_price` varchar(30) NOT NULL,
  `item_amount` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `storage`
--

INSERT INTO `storage` (`item_id`, `item_catid`, `item_name`, `item_price`, `item_amount`) VALUES
(1, 1, 'Mouse A4Tech', '20', 20),
(2, 1, 'Mouse Genius', '40', 25),
(3, 4, 'Laptop Acer', '1200', 5),
(5, 4, 'Laptop Asus', '1325', 15);

-- --------------------------------------------------------

--
-- Структура на таблица `suppliers`
--

CREATE TABLE `suppliers` (
  `supplier_id` int(10) NOT NULL,
  `supplier_name` varchar(100) NOT NULL,
  `supplier_egn` varchar(20) NOT NULL,
  `supplier_address` varchar(100) NOT NULL,
  `supplier_phone` varchar(50) NOT NULL,
  `supplier_mol` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `suppliers`
--

INSERT INTO `suppliers` (`supplier_id`, `supplier_name`, `supplier_egn`, `supplier_address`, `supplier_phone`, `supplier_mol`) VALUES
(1, 'Denis Inc', '1853856483', 'San Diego', '+359 3123', 'Denis Newman'),
(2, 'Chris Inc', '1739539594', 'San Francisco', '+359 3124', 'Christian Stone');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `corders`
--
ALTER TABLE `corders`
  ADD PRIMARY KEY (`corder_id`);

--
-- Indexes for table `sorders`
--
ALTER TABLE `sorders`
  ADD PRIMARY KEY (`sorder_id`);

--
-- Indexes for table `storage`
--
ALTER TABLE `storage`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`supplier_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `client_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `corders`
--
ALTER TABLE `corders`
  MODIFY `corder_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `sorders`
--
ALTER TABLE `sorders`
  MODIFY `sorder_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `storage`
--
ALTER TABLE `storage`
  MODIFY `item_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supplier_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
