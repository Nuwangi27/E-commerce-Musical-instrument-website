-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2023 at 10:55 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brand_id` int(100) NOT NULL,
  `brand_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_name`) VALUES
(1, 'Yamaha'),
(2, 'Fender'),
(3, 'Gibsun');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(100) NOT NULL,
  `product_id` int(100) NOT NULL,
  `product_title` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `quality` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `product_id`, `product_title`, `ip_address`, `quality`) VALUES
(5, 15, 'Classic Violin', '::1', 0),
(7, 17, 'Classic Guitar', '::1', 0),
(8, 14, 'Guitar', '::1', 0),
(10, 16, 'Acoustic Drum', '::1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(100) NOT NULL,
  `cat_title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_title`) VALUES
(1, 'Guitar'),
(2, 'Violin'),
(3, 'Drum'),
(4, 'Trumpet');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(100) NOT NULL,
  `product_cat` int(100) NOT NULL,
  `product_brand` int(100) NOT NULL,
  `product_title` varchar(255) NOT NULL,
  `product_price` int(100) NOT NULL,
  `product_desc` text NOT NULL,
  `product_keywords` varchar(255) NOT NULL,
  `product_img_01` text NOT NULL,
  `product_img_02` text NOT NULL,
  `product_img_03` text NOT NULL,
  `product_img_04` text NOT NULL,
  `product_img_05` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_cat`, `product_brand`, `product_title`, `product_price`, `product_desc`, `product_keywords`, `product_img_01`, `product_img_02`, `product_img_03`, `product_img_04`, `product_img_05`) VALUES
(14, 1, 1, 'Guitar', 700, 'test', 'test', 'Guitar_01.png', 'Guitar_02.png', 'Guitar_03.png', 'Guitar_02.png', 'Guitar_03.png'),
(15, 2, 2, 'Classic Violin', 1000, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem, deleniti minus! Itaque eveniet labore quia adipisci iusto nulla dolorum nihil ab totam, ut ex tempora necessitatibus quos, pariatur dolor. Totam?', 'Fender Violin', 'Violin_01.png', 'Violin_02.png', 'Violin_01.png', 'Violin_02.png', 'Violin_01.png'),
(16, 3, 3, 'Acoustic Drum', 7000, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem, deleniti minus! Itaque eveniet labore quia adipisci iusto nulla dolorum nihil ab totam, ut ex tempora necessitatibus quos, pariatur dolor. Totam?', 'Gibsun Drum', 'Drum_01.png', 'Drum_01.png', 'Drum_01.png', 'Drum_01.png', 'Drum_01.png'),
(17, 1, 2, 'Classic Guitar', 800, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem, deleniti minus! Itaque eveniet labore quia adipisci iusto nulla dolorum nihil ab totam, ut ex tempora necessitatibus quos, pariatur dolor. Totam?', 'Fender Guitar', 'Guitar_02.png', 'Guitar_01.png', 'Guitar_03.png', 'Guitar_01.png', 'Guitar_03.png'),
(18, 2, 1, 'Violin', 1000, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem, deleniti minus! Itaque eveniet labore quia adipisci iusto nulla dolorum nihil ab totam, ut ex tempora necessitatibus quos, pariatur dolor. Totam?', 'yamaha violin', 'Violin_02.png', 'Violin_01.png', 'Violin_02.png', 'Violin_01.png', 'Violin_02.png'),
(19, 4, 1, 'Trumpet', 20000, 'test test test', 'yamaha trumpet', 'Trumpet_01.png', 'Trumpet_02.png', 'Trumpet_03.png', 'Trumpet_04.png', 'Trumpet_05.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
