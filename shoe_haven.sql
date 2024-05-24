-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2024 at 02:16 AM
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
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(225) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` float(7,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `size` varchar(225) NOT NULL,
  `quantity` int(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(225) NOT NULL,
  `color_id` int(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `name`, `price`, `image`, `size`, `quantity`, `user_id`, `product_id`, `color_id`) VALUES
(144, 'AIR JORDAN 1', 7500.00, 'airjordan2.png', '42', 1, 1, 51, 152);

-- --------------------------------------------------------

--
-- Table structure for table `color`
--

CREATE TABLE `color` (
  `color_id` int(11) NOT NULL,
  `color_name` varchar(255) NOT NULL,
  `stock` int(225) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `color`
--

INSERT INTO `color` (`color_id`, `color_name`, `stock`, `product_id`) VALUES
(151, 'AIRJORDAN.png', 0, 51),
(152, 'airjordan2.png', 9, 51),
(153, 'airwhitesmall.png', 10, 51),
(154, 'airyellowsmall.png', 9, 51),
(155, 'airyellowsmall.png', 10, 52),
(156, 'AIRJORDAN.png', 10, 52),
(157, 'airjordan2.png', 10, 52),
(158, 'airwhitesmall.png', 10, 52);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `o_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `zip_code` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `payment` varchar(255) NOT NULL,
  `gcash_reference` varchar(225) NOT NULL,
  `prod_name` varchar(255) NOT NULL,
  `size` varchar(225) NOT NULL,
  `quantity` int(255) NOT NULL,
  `price_total` int(11) NOT NULL,
  `date_ordered` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `status` varchar(100) NOT NULL DEFAULT 'pending' COMMENT 'pending\r\naccepted',
  `user_id` int(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `prod_name` varchar(100) NOT NULL,
  `prod_price` float(7,2) NOT NULL,
  `prod_image` varchar(355) NOT NULL,
  `prod_des` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `prod_name`, `prod_price`, `prod_image`, `prod_des`) VALUES
(51, 'AIR JORDAN 1', 7500.00, 'airwhitesmall.png', 'nigga nigga'),
(52, 'AIR force 1', 2000.00, 'AIRJORDAN.png', '');

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
(130, '40', 51),
(131, '41', 51),
(132, '42', 51),
(133, '43', 51),
(134, '44', 51),
(135, '45', 51),
(136, '40', 52),
(137, '41', 52),
(138, '42', 52),
(139, '43', 52),
(140, '44', 52),
(141, '45', 52);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(255) NOT NULL,
  `fullname` varchar(250) NOT NULL,
  `age` int(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `email` varchar(250) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(100) NOT NULL,
  `profile_image` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_type` char(1) NOT NULL DEFAULT 'u' COMMENT 'u - user\r\na - admin',
  `status` varchar(100) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fullname`, `age`, `gender`, `email`, `username`, `password`, `profile_image`, `date`, `user_type`, `status`) VALUES
(1, 'mark john oliva', 20, 'male', 'markjohnoliva27@gmail.com', 'mark.pro', '1234', 'uploads/profile_pictures/6ed150a98328f340ecbf0d0fbb4f32c0.jpg', '2024-05-20 08:30:04', 'u', 'active'),
(3, 'admin mark', 21, 'male', 'markjohnoliva27@gmail.com', 'admin', '1234', 'uploads/profile_pictures/e7461f2ef92442ceecf695027399c974.jpg', '2024-05-24 00:15:10', 'a', 'active'),
(11, 'mj oliva', 20, 'male', '', 'mj', '1234', 'uploads/profile_pictures/6cb918d7026cc793b30c9837fcc7c693.jpg', '2024-05-21 05:59:18', 'u', 'active'),
(12, 'cj solano', 21, 'male', 'asgdjhada@gmail.com', 'solano123', '1234', '', '2024-05-09 06:34:23', 'a', 'active');

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
(426, 'airpanda1.png', 51),
(427, 'airpanda2.png', 51),
(428, 'airpanda3.png', 51),
(429, 'airpanda4.png', 51),
(430, 'airpanda5.png', 51),
(431, 'airwhite1.png', 51),
(432, 'airwhite2.png', 51),
(433, 'airwhite3.png', 51),
(434, 'airwhite4.png', 51),
(435, 'airwhite5.png', 51),
(436, 'airyellow1.png', 51),
(437, 'airyellow2.jpg', 51),
(438, 'airyellow3.png', 51),
(439, 'airyellow4.png', 51),
(440, 'airyellow5.png', 51),
(441, 'img1.jpg', 51),
(442, 'img2.png', 51),
(443, 'img3.jpg', 51),
(444, 'img4.png', 51),
(445, 'img5.png', 51),
(446, 'img1.jpg', 52),
(447, 'img2.png', 52),
(448, 'img3.jpg', 52),
(449, 'img4.png', 52),
(450, 'img5.png', 52);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `color_id` (`color_id`);

--
-- Indexes for table `color`
--
ALTER TABLE `color`
  ADD PRIMARY KEY (`color_id`),
  ADD KEY `color_ibfk_1` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`o_id`),
  ADD KEY `user_id` (`user_id`);

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
  ADD PRIMARY KEY (`user_id`);

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
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(225) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT for table `color`
--
ALTER TABLE `color`
  MODIFY `color_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `o_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `size`
--
ALTER TABLE `size`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `view_prod`
--
ALTER TABLE `view_prod`
  MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=451;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `cart_ibfk_3` FOREIGN KEY (`color_id`) REFERENCES `color` (`color_id`);

--
-- Constraints for table `color`
--
ALTER TABLE `color`
  ADD CONSTRAINT `color_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

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
