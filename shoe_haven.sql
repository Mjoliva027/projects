-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2024 at 08:01 AM
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
-- Database: `shoe_haven`
--

-- --------------------------------------------------------

--
-- Table structure for table `color`
--

CREATE TABLE `color` (
  `color_id` int(11) NOT NULL,
  `color_name` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `color`
--

INSERT INTO `color` (`color_id`, `color_name`, `product_id`) VALUES
(1, 'airwhitesmall.png', 1),
(2, 'airjordan2.png', 1),
(3, 'AIRJORDAN.png', 1),
(9, 'airyellowsmall.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `prod_name` varchar(100) NOT NULL,
  `prod_price` varchar(10) NOT NULL,
  `prod_image` varchar(355) NOT NULL,
  `prod_des` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `prod_name`, `prod_price`, `prod_image`, `prod_des`) VALUES
(1, 'NIKE AIR JORDAN 1', '₱7,095', 'airwhite1.png\r\n', 'Inspired by the original AJ1, this mid-top edition maintains the iconic look you love while choice colours and crisp leather give it a distinct identity.\r\n\r\n\r\nBenefits\r\n\r\n• Leather, synthetic leather and textile upper for a s'),
(2, 'SHOES', '1000', 'RIFF\0\0WEBPVP8X\n\0\0\0 \0\0\0?\0\0?\0\0ICCP0\0\0\0\00ADBE\0\0mntrRGB XYZ ?\0\0\0\03\0;acspAPPL\0\0\0\0none\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0??\0\0\0\0\0?-ADBE\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\ncprt\0\0\0?\0\0\02desc\0\00\0\0\0kwtpt\0\0?\0\0\0bkpt\0\0?\0\0\0rTRC\0\0', '');

-- --------------------------------------------------------

--
-- Table structure for table `size`
--

CREATE TABLE `size` (
  `size_id` int(11) NOT NULL,
  `size_name` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `size`
--

INSERT INTO `size` (`size_id`, `size_name`, `product_id`) VALUES
(1, '36', 1),
(2, '37', 1),
(3, '38', 1),
(4, '39', 1),
(5, '40', 1),
(6, '41', 1),
(7, '42', 1),
(8, '43', 1),
(9, '44', 1),
(10, '45', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `fullname` varchar(250) NOT NULL,
  `age` int(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `email` varchar(250) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(100) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `fullname`, `age`, `gender`, `email`, `username`, `password`, `date`, `status`) VALUES
(1, 2147483647, '', 20, 'male', 'markjohnoliva27@gmail.com', 'mark.pro', '1234', '2024-03-06 05:00:56', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `view_prod`
--

CREATE TABLE `view_prod` (
  `img_id` int(11) NOT NULL,
  `img_name` varchar(225) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `view_prod`
--

INSERT INTO `view_prod` (`img_id`, `img_name`, `product_id`) VALUES
(1, 'airwhite1.png', 1),
(2, 'airwhite2.png', 1),
(3, 'airwhite3.png', 1),
(4, 'airwhite4.png', 1),
(5, 'airwhite5.png', 1),
(6, 'airpanda1.png', 1),
(7, 'airpanda2.png', 1),
(8, 'airpanda3.png', 1),
(9, 'airpanda4.png', 1),
(10, 'airpanda5.png', 1),
(11, 'img1.jpg', 1),
(12, 'img2.png', 1),
(13, 'img3.jpg', 1),
(14, 'img4.png', 1),
(15, 'img5.png', 1),
(16, 'airyellow1.png', 1),
(17, 'airyellow2.jpg', 1),
(18, 'airyellow3.png', 1),
(19, 'airyellow4.png', 1),
(20, 'airyellow5.png', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `color`
--
ALTER TABLE `color`
  ADD PRIMARY KEY (`color_id`),
  ADD KEY `color_ibfk_1` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `size`
--
ALTER TABLE `size`
  ADD PRIMARY KEY (`size_id`),
  ADD KEY `size_ibfk_1` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fullname` (`fullname`),
  ADD KEY `password` (`password`),
  ADD KEY `username` (`username`),
  ADD KEY `email` (`email`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `view_prod`
--
ALTER TABLE `view_prod`
  ADD PRIMARY KEY (`img_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `color`
--
ALTER TABLE `color`
  MODIFY `color_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `size`
--
ALTER TABLE `size`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `view_prod`
--
ALTER TABLE `view_prod`
  MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `color`
--
ALTER TABLE `color`
  ADD CONSTRAINT `color_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `size`
--
ALTER TABLE `size`
  ADD CONSTRAINT `size_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `view_prod`
--
ALTER TABLE `view_prod`
  ADD CONSTRAINT `view_prod_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
