-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2024 at 11:36 AM
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
(163, 'nike air max dn color 1.png', 10, 54),
(164, 'nike air max dn color 2.png', 10, 54),
(165, 'nike air max dn color 3.png', 10, 54),
(166, 'nike air max dn color.png', 10, 54),
(167, 'Nike air vapormax - avatar.png', 10, 55),
(168, 'Nike air vapormax green.jpg', 10, 55),
(169, 'Nike air vapormax light yellow.png', 10, 55),
(170, 'Nike air vapormax orange.jpg', 10, 55),
(171, 'Nike air vapormax white.png', 10, 55),
(172, 'nike downshifter - avatar.png', 10, 56),
(173, 'nike downshifter black white.jpg', 8, 56),
(174, 'nike downshifter black.png', 10, 56),
(175, 'nike downshifter blue.png', 10, 56),
(176, 'nike downshifter white.png', 10, 56),
(177, 'nike down low gray.png', 8, 57),
(178, 'Nike dunk low - avatar.png', 10, 57),
(179, 'Nike dunk low brown.png', 10, 57),
(180, 'nike dunk low yellow green.png', 10, 57),
(181, 'Nike precision - avatar.png', 7, 58),
(182, 'Nike precision black.png', 10, 58),
(183, 'Nike precision purple.png', 10, 58),
(184, 'Tatum 2 - avatar.jpg', 7, 59),
(185, 'tatum 2 green.jpg', 10, 59),
(186, 'New balance dynesoft nitrel v5 - avatar.webp', 7, 60),
(187, 'New balance dynesoft nitrel v5 gray.webp', 9, 60),
(188, 'New balance FuelCell Propel v5 - avatar.webp', 9, 61),
(189, 'New balance FuelCell Propel v5 black.webp', 10, 61),
(190, 'New balance FuelCell Propel v5 gray.webp', 10, 61),
(191, 'New balance FuelCell Propel v5 white.webp', 10, 61),
(192, 'New balance FuelCell SD100 v5 - avatr.webp', 10, 62),
(193, 'MR530 MEN SNEAKERS - WHITE - avatar.jpg', 10, 63),
(194, 'airpanda1.png', 10, 64);

-- --------------------------------------------------------

--
-- Table structure for table `inbox`
--

CREATE TABLE `inbox` (
  `user_id` int(225) NOT NULL,
  `order_id` int(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `date_sent` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inbox`
--

INSERT INTO `inbox` (`user_id`, `order_id`, `message`, `date_sent`) VALUES
(1, 6870, 'Your order #6870 has been accepted.', '2024-06-02 07:19:32.788877'),
(1, 6870, 'Your order #6870 has been shipped.', '2024-06-02 07:20:17.445860'),
(1, 6870, 'Your order #6870 has been delivered.', '2024-06-02 07:20:23.468094'),
(1, 73680955, 'Your order #73680955 has been accepted.', '2024-06-02 09:25:16.599336'),
(1, 73680955, 'Your order #73680955 has been shipped.', '2024-06-02 09:25:19.256189'),
(1, 73680955, 'Your order #73680955 has been delivered.', '2024-06-02 09:25:20.141827'),
(1, 8007041, 'Your order #8007041 has been accepted.', '2024-06-02 09:31:05.774397'),
(1, 8007041, 'Your order #8007041 has been shipped.', '2024-06-02 09:31:06.793543'),
(1, 8007041, 'Your order #8007041 has been delivered.', '2024-06-02 09:31:13.368204');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `received_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `user_id`, `order_id`, `message`, `received_date`) VALUES
(31, 1, 65686878, 'User mark john oliva has received the order Nike Precision 7.', '2024-06-02 05:26:20'),
(32, 1, 95617, 'User mark john oliva has received the order Tatum 2 \\\'Vortex\\\' PF.', '2024-06-02 05:27:19'),
(34, 1, 6870, 'User mark john oliva has received the order Nike Downshifter 12.', '2024-06-02 07:20:45'),
(35, 1, 73680955, 'User mark john oliva has received the order DynaSoft Nitrel v5.', '2024-06-02 09:26:32');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `o_id` int(11) NOT NULL,
  `order_id` int(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `zip_code` int(11) NOT NULL,
  `phone_num` varchar(225) NOT NULL,
  `payment` varchar(255) NOT NULL,
  `gcash_reference` varchar(225) NOT NULL,
  `acc_name` varchar(225) NOT NULL,
  `acc_number` varchar(255) NOT NULL,
  `amount_paid` int(255) NOT NULL,
  `prod_name` varchar(255) NOT NULL,
  `size` varchar(225) NOT NULL,
  `quantity` int(255) NOT NULL,
  `price_total` int(11) NOT NULL,
  `date_ordered` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `status` varchar(100) NOT NULL DEFAULT 'pending' COMMENT 'pending\r\nPay\r\nShip\r\nDelivered',
  `user_id` int(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`o_id`, `order_id`, `fullname`, `address`, `zip_code`, `phone_num`, `payment`, `gcash_reference`, `acc_name`, `acc_number`, `amount_paid`, `prod_name`, `size`, `quantity`, `price_total`, `date_ordered`, `status`, `user_id`) VALUES
(78, 73680955, 'Mark John Oliva', 'centro occidental polangui albay', 4506, '09914815998', 'gcash', 'QQW4234123', 'mark john oliva', '09914815998', 2900, 'DynaSoft Nitrel v5', '42', 1, 2900, '2024-06-02 09:26:32.750651', 'received', 1),
(79, 8007041, 'Mark Oliva', 'centro occidental polangui albay', 4506, '09914815998', 'gcash', 'QQW4234123', 'mark john oliva', '09914815998', 6000, 'Nike Dunk Low', '42', 1, 6000, '2024-06-02 09:31:13.305785', 'delivered', 1);

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
(54, 'Nike Air Max dn', 8500.00, 'Nike air max dn - avatar.png', 'Say hello to the next generation of Air technology. The Air Max Dn features our Dynamic Air unit system of dual-pressure tubes, creating a reactive sensation with every step. This results in a futuristic design that\'s comfortable enough to wear from day to night. Go ahead—Feel The Unreal.\r\n\r\nColour Shown: Particle Grey/Smoke Grey/Wolf Grey/Black\r\nStyle: DV3337-004'),
(55, 'Nike Air VaporMax 2023', 11200.00, 'Nike air vapormax - avatar.png', 'Breathe in. Breath out. This Air is better than that. With the first 1-piece Air unit to run the entire length of a shoe, the Air VaporMax 2023 Flyknit lets you walk on unbelievable cushioning. And at the top, stretchy and supportive Flyknit keeps it breezy and light. Bonus—it\'s made from at least 20% recycled materials by weight. Now that\'s fresh!\r\n\r\nColour Shown: Black/Black/Anthracite\r\nStyle: DV6840-001'),
(56, 'Nike Downshifter 12', 2500.00, 'nike downshifter black.png', 'NIKE DOWNSHIFTER\r\nWhether you\'re starting your running journey or an expert eager to switch up your pace, the Downshifter 13 is down for the ride. With a revamped upper, cushioning and durability, it helps you find that extra gear or take that first stride towards chasing down your goals.\r\n'),
(57, 'Nike Dunk Low', 6000.00, 'Nike dunk low - avatar.png', 'NIKE DUNK LOW\r\nThis \'80s basketball icon returns with classic details and throwback hoops flair. Channelling vintage style, its padded, low-cut collar lets you take your game anywhere—in comfort.\r\n'),
(58, 'Nike Precision 7', 3500.00, 'Nike precision - avatar.png', 'Score at will at the rim or from deep in the Nike Precision 7. Crafted with a combination of ground control, comfort and on-court traction, it\'s perfect for instant impact plays when your name is called for the next casual game. Check in and make the plays that swing the outcome in your favour.\r\n\r\nColour Shown: Barely Grape/Sail/Dusted \r\nClay/Lilac Bloom\r\nStyle: FN4322-500'),
(59, 'Tatum 2 \'Vortex\' PF', 7000.00, 'Tatum 2 - avatar.jpg', 'Bright colours and big energy come together in the Tatum 2 \'Vortex\'. The lightweight, flexible design was created with energy return in mind and this colourway is all about how Jayson helps energise his team. When you\'re wearing them on the court, your opponents won\'t be able to ignore all the moves you make—but that doesn\'t mean they can stop you from scoring.\r\n\r\nColour Shown: Mint Foam/Black/Hyper Jade/Lava Glow\r\nStyle: FJ6458-300'),
(60, 'DynaSoft Nitrel v5', 2900.00, 'New balance dynesoft nitrel v5 - avatar.webp', 'Ideal for active outdoor kids, the New Balance DynaSoft Nitrel v5 features a grippy AT Tread outsole for superior traction on uneven terrain. Designed for trail hikes, these running shoes also feature a springy DynaSoft midsole for a responsive and plush underfoot feel that delivers outstanding comfort.'),
(61, 'FuelCell Propel v5', 6500.00, 'New balance FuelCell Propel v5 - avatar.webp', 'Designed with comfort and energy return top-of-mind, this versatile running shoe is crafted for runners of all styles.\r\n\r\nFeatures\r\nFuelCell midsole foam with approximately 3% bio-based content delivers a propulsive feel to help drive you forward. Bio-based content is made from renewable resources to help reduce our carbon footprint.\r\nTPU plate for a propulsive feeling\r\n  280 grams (9.9 oz)\r\nMaterial\r\nStructured upper for breathability and a lightweight fit\r\nLightweight synthetic material\r\nStyle #: MFCPRLN5'),
(62, 'FuelCell SD100 v5', 4000.00, 'New balance FuelCell SD100 v5 - avatr.webp', 'For track athletes, the New Balance FuelCell SD100 v5 is a sleek, lightweight track spike great for sprints and jumps. The SD100 is equipped with a full-length FuelCell midsole that offers a propulsive feel perfect for racers striving to go faster. A 6-pin TPU spike plate with removable spikes provides an aggressive but forgiving ride perfect for a wide range of track events.\r\n\r\nFeatures\r\nFuelCell foam delivers a propulsive feel to help drive you forward\r\nSynthetic and mesh upper with reinforced toe for toe drag sprinters\r\nUpper features no-sew construction for a sleek fit and feel\r\n6-Pin TPU spike plate for an aggressive yet forgiving ride\r\nRemovable spikes for easy replacement\r\nAdjustable lace closure for a customized fit\r\n  154 grams (5.4 oz)\r\nStyle #: USD100L5'),
(63, ' MR530 ', 5000.00, 'MR530 MEN SNEAKERS - WHITE - avatar.jpg', 'The original MR530 combined turn of the millennium aesthetics with the reliability of a high milage running shoe. The reintroduced 530 applies a contemporary, everyday style outlook to this performance-minded design. A segmented ABZORB midsole is paired with a classic mesh and leather overlay upper design, which utilizes sweeping curves and angles for a distinctive, high-tech look.'),
(64, 'AIR JORDAN 1', 1000.00, 'airpanda1.png', 'sfgwefosdyfwuegrifusfgwiurfuge4gugkg');

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
(148, '40', 54),
(149, '41', 54),
(150, '42', 54),
(151, '43', 54),
(152, '44', 54),
(153, '45', 54),
(154, '40', 55),
(155, '41', 55),
(156, '42', 55),
(157, '43', 55),
(158, '44', 55),
(159, '45', 55),
(160, '35', 56),
(161, '36', 56),
(162, '37', 56),
(163, '38', 56),
(164, '40', 56),
(166, '41', 56),
(167, '42', 56),
(168, '43', 56),
(169, '44', 56),
(170, '45', 56),
(171, '35', 57),
(172, '36', 57),
(173, '37', 57),
(174, '38', 57),
(175, '39', 57),
(176, '40', 57),
(177, '41', 57),
(178, '42', 57),
(179, '43', 57),
(180, '44', 57),
(181, '45', 57),
(183, '40', 58),
(184, '41', 58),
(185, '42', 58),
(186, '43', 58),
(187, '44', 58),
(188, '45', 58),
(189, '40', 59),
(190, '41', 59),
(191, '42', 59),
(192, '43', 59),
(193, '44', 59),
(194, '45', 59),
(195, '35', 60),
(196, '36', 60),
(197, '37', 60),
(198, '38', 60),
(199, '39', 60),
(200, '40', 60),
(201, '41', 60),
(202, '42', 60),
(203, '43', 60),
(204, '44', 60),
(205, '45', 60),
(206, '35', 61),
(207, '36', 61),
(208, '37', 61),
(209, '38', 61),
(210, '39', 61),
(211, '40', 61),
(212, '41', 61),
(213, '42', 61),
(214, '43', 61),
(215, '44', 61),
(216, '45', 61),
(217, '35', 62),
(218, '36', 62),
(219, '37', 62),
(220, '38', 62),
(221, '39', 62),
(222, '40', 62),
(223, '41', 62),
(224, '42', 62),
(225, '43', 62),
(226, '44', 62),
(227, '45', 62),
(228, '35', 63),
(229, '36', 63),
(230, '37', 63),
(231, '38', 63),
(232, '39', 63),
(233, '40', 63),
(234, '41', 63),
(235, '42', 63),
(236, '43', 63),
(237, '44', 63),
(238, '45', 63),
(239, '35', 64),
(240, '36', 64),
(241, '37', 64),
(242, '38', 64),
(243, '39', 64),
(244, '40', 64),
(245, '41', 64),
(246, '42', 64),
(247, '43', 64),
(248, '44', 64),
(249, '45', 64);

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
(15, 'Mark Oliva', 20, 'male', 'mjoo2022-2358-66147@bicol-u.edu.ph', 'mark123', '1234', '', '2024-05-30 10:24:41', 'u', 'active');

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
(472, 'Nike air max dn - avatar.png', 54),
(473, 'nike air max dn 1.png', 54),
(474, 'nike air max dn 2.jpg', 54),
(475, 'nike air max dn 3.jpg', 54),
(476, 'nike air max dn 4.png', 54),
(477, 'nike air vapor max green  3.jpg', 55),
(478, 'nike air vapor max green 1.jpg', 55),
(479, 'nike air vapor max green 2.jpg', 55),
(480, 'nike air vapor max green 4.png', 55),
(481, 'nike air vapor max light yellow 1.png', 55),
(482, 'nike air vapor max light yellow 2.png', 55),
(483, 'nike air vapor max light yellow 3.png', 55),
(484, 'nike air vapor max light yellow 4.png', 55),
(485, 'nike air vapor max orange 1.jpg', 55),
(486, 'nike air vapor max orange 2.jpg', 55),
(487, 'nike air vapor max orange 3.jpg', 55),
(488, 'nike air vapor max orange 4.png', 55),
(489, 'nike air vapor max white 1.png', 55),
(490, 'nike air vapor max white 2.jpg', 55),
(491, 'nike air vapor max white 3.png', 55),
(492, 'nike air vapor max white 4.png', 55),
(493, 'Nike air vapormax - avatar.png', 55),
(494, 'Nike air vapormax 1.png', 55),
(495, 'Nike air vapormax 2.png', 55),
(496, 'Nike air vapormax 3.png', 55),
(497, 'Nike air vapormax 4.png', 55),
(498, 'Nike air vapormax green.jpg', 55),
(499, 'Nike air vapormax light yellow.png', 55),
(500, 'Nike air vapormax orange.jpg', 55),
(501, 'Nike air vapormax white.png', 55),
(502, 'nike downshifter - avatar.png', 56),
(503, 'nike downshifter 1.png', 56),
(504, 'nike downshifter 2.jpg', 56),
(505, 'nike downshifter 3.png', 56),
(506, 'nike downshifter 4.png', 56),
(507, 'nike downshifter black  1.png', 56),
(508, 'nike downshifter black  2.jpg', 56),
(509, 'nike downshifter black  3.png', 56),
(510, 'nike downshifter black  4.png', 56),
(511, 'nike downshifter black  white 1.jpg', 56),
(512, 'nike downshifter black  white 2.jpg', 56),
(513, 'nike downshifter black  white 3.png', 56),
(514, 'nike downshifter black  white 4.png', 56),
(515, 'nike downshifter black white.jpg', 56),
(516, 'nike downshifter black.png', 56),
(517, 'nike downshifter white 1.png', 56),
(518, 'nike downshifter white 2.png', 56),
(519, 'nike downshifter white 3.png', 56),
(520, 'nike downshifter white 4.png', 56),
(521, 'nike downshifter white.png', 56),
(522, 'nike down low brown 2.jpg', 57),
(523, 'nike down low brown 3.png', 57),
(524, 'nike down low brown 4.png', 57),
(525, 'nike down low gray 1.png', 57),
(526, 'nike down low gray 2.png', 57),
(527, 'nike down low gray 3.png', 57),
(528, 'nike down low gray 4.png', 57),
(529, 'nike down low gray.png', 57),
(530, 'nike down low yellow green 1.png', 57),
(531, 'nike down low yellow green 2.png', 57),
(532, 'nike down low yellow green 3.png', 57),
(533, 'nike down low yellow green 4.png', 57),
(534, 'Nike dunk low - avatar.png', 57),
(535, 'nike dunk low 1.png', 57),
(536, 'nike dunk low 2.jpg', 57),
(537, 'nike dunk low 3.png', 57),
(538, 'Nike dunk low 5.png', 57),
(539, 'nike dunk low brown 1.png', 57),
(540, 'Nike dunk low brown.png', 57),
(541, 'nike dunk low yellow green.png', 57),
(542, 'Nike precision - avatar.png', 58),
(543, 'Nike precision 1.png', 58),
(544, 'Nike precision 2.png', 58),
(545, 'Nike precision 3.png', 58),
(546, 'Nike precision 4.png', 58),
(547, 'nike precision black 1.png', 58),
(548, 'nike precision black 2.jpg', 58),
(549, 'nike precision black 3.png', 58),
(550, 'nike precision black 4.png', 58),
(551, 'Nike precision black.png', 58),
(552, 'nike precision purple 1.png', 58),
(553, 'nike precision purple 2.png', 58),
(554, 'nike precision purple 3.png', 58),
(555, 'nike precision purple 4.png', 58),
(556, 'Nike precision purple.png', 58),
(557, 'Tatum 2 - avatar.jpg', 59),
(558, 'tatum 2 1.jpg', 59),
(559, 'tatum 2 2.jpg', 59),
(560, 'tatum 2 3.jpg', 59),
(561, 'tatum 2 4.jpg', 59),
(562, 'tatum 2 green 1.png', 59),
(563, 'tatum 2 green 2.png', 59),
(564, 'tatum 2 green 3.jpg', 59),
(565, 'tatum 2 green 4.jpg', 59),
(566, 'tatum 2 green.jpg', 59),
(567, 'New balance dynesoft nitrel v5 - avatar.webp', 60),
(568, 'New balance dynesoft nitrel v5 1.webp', 60),
(569, 'New balance dynesoft nitrel v5 2.webp', 60),
(570, 'New balance dynesoft nitrel v5 3.webp', 60),
(571, 'New balance dynesoft nitrel v5 gray 1.webp', 60),
(572, 'New balance dynesoft nitrel v5 gray 2.webp', 60),
(573, 'New balance dynesoft nitrel v5 gray 3.webp', 60),
(574, 'New balance dynesoft nitrel v5 gray 4.webp', 60),
(575, 'New balance dynesoft nitrel v5 gray.webp', 60),
(576, 'New balance FuelCell Propel v5 - avatar.webp', 61),
(577, 'New balance FuelCell Propel v5 1.webp', 61),
(578, 'New balance FuelCell Propel v5 2.webp', 61),
(579, 'New balance FuelCell Propel v5 3.webp', 61),
(580, 'New balance FuelCell Propel v5 4.webp', 61),
(581, 'New balance FuelCell Propel v5 black 1.webp', 61),
(582, 'New balance FuelCell Propel v5 black 2.webp', 61),
(583, 'New balance FuelCell Propel v5 black 3.webp', 61),
(584, 'New balance FuelCell Propel v5 black 4.webp', 61),
(585, 'New balance FuelCell Propel v5 black.webp', 61),
(586, 'New balance FuelCell Propel v5 gray 1.webp', 61),
(587, 'New balance FuelCell Propel v5 gray 2.webp', 61),
(588, 'New balance FuelCell Propel v5 gray 3.webp', 61),
(589, 'New balance FuelCell Propel v5 gray 4.webp', 61),
(590, 'New balance FuelCell Propel v5 gray.webp', 61),
(591, 'New balance FuelCell Propel v5 white 1.webp', 61),
(592, 'New balance FuelCell Propel v5 white 2.webp', 61),
(593, 'New balance FuelCell Propel v5 white 3.webp', 61),
(594, 'New balance FuelCell Propel v5 white 4.webp', 61),
(595, 'New balance FuelCell Propel v5 white.webp', 61),
(596, 'New balance FuelCell SD100 v5 - avatr.webp', 62),
(597, 'New balance FuelCell SD100 v5 1.webp', 62),
(598, 'New balance FuelCell SD100 v5 2.webp', 62),
(599, 'New balance FuelCell SD100 v5 3.webp', 62),
(600, 'New balance FuelCell SD100 v5 4.webp', 62),
(601, 'MR530 MEN SNEAKERS - WHITE - avatar.jpg', 63),
(602, 'MR530 MEN SNEAKERS - WHITE 1.jpg', 63),
(603, 'MR530 MEN SNEAKERS - WHITE 2.jpg', 63),
(604, 'MR530 MEN SNEAKERS - WHITE 3.jpg', 63),
(605, 'airpanda1.png', 64),
(606, 'airpanda2.png', 64),
(607, 'airpanda3.png', 64),
(608, 'airpanda4.png', 64),
(609, 'airpanda5.png', 64);

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
-- Indexes for table `inbox`
--
ALTER TABLE `inbox`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `order_id` (`order_id`);

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
  MODIFY `id` int(225) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;

--
-- AUTO_INCREMENT for table `color`
--
ALTER TABLE `color`
  MODIFY `color_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `o_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `size`
--
ALTER TABLE `size`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=250;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `view_prod`
--
ALTER TABLE `view_prod`
  MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=610;

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
-- Constraints for table `inbox`
--
ALTER TABLE `inbox`
  ADD CONSTRAINT `inbox_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

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
