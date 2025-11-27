-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 27, 2025 at 02:30 PM
-- Server version: 11.8.3-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u530884239_bossbino111`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `notes`) VALUES
(15, 'heyrow', 'hiro@gmail.com', '09077515757', 'kapoy'),
(14, 'Hiro', 'cenizajanhiro@smcbi.edu.ph', '09283673927', 'cute');

-- --------------------------------------------------------

--
-- Table structure for table `designs`
--

CREATE TABLE `designs` (
  `id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `designs`
--

INSERT INTO `designs` (`id`, `category`, `file_name`, `price`) VALUES
(1, 'Logo', 'logo1.jpg', 2500.00),
(2, 'Logo', 'logo2.jpg', 2500.00),
(3, 'Logo', 'logo3.jpg', 2500.00),
(4, 'Logo', 'logo4.jpg', 2500.00),
(5, 'Jersey', 'jersey1.jpg', 900.00),
(6, 'Jersey', 'jersey2.jpg', 900.00),
(7, 'Jersey', 'jersey3.jpg', 900.00),
(8, 'Jersey', 'jersey4.jpg', 900.00),
(9, 'T-shirt', 'tshirt1.jpg', 900.00),
(10, 'T-shirt', 'tshirt2.jpg', 900.00),
(11, 'T-shirt', 'tshirt3.jpg', 900.00),
(12, 'T-shirt', 'tshirt4.jpg', 900.00),
(13, 'Long Sleeve', 'long1.jpg', 900.00),
(14, 'Long Sleeve', 'long2.jpg', 900.00),
(15, 'Long Sleeve', 'long3.jpg', 900.00),
(16, 'Long Sleeve', 'long4.jpg', 900.00);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'haha', 'cenizajanhiro@smcbi.edu.ph', 'fdv', '2025-11-26 11:48:08'),
(2, 'haha', 'cenizajanhiro@smcbi.edu.ph', 'sac', '2025-11-26 11:55:22'),
(3, 'hello lord', 'cenizajanhiro@smcbi.edu.ph', 'adfhzgjm', '2025-11-26 11:58:03'),
(4, 'hello lord', 'janhiro438@gmail.com', 'j', '2025-11-26 16:05:08');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `design_name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `upload_logo` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `order_date` timestamp NULL DEFAULT current_timestamp(),
  `status` enum('pending','approved','declined') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `design_name`, `price`, `customer_name`, `email`, `contact`, `address`, `payment_method`, `upload_logo`, `message`, `order_date`, `status`) VALUES
(19, 'Logo2', 2500.00, 'jasfdsgf', 'customer@gmail.com', 'sadgasdfg', 'asdgasdfg', 'Gcash', NULL, 'asdgv', '2025-11-27 10:48:14', 'approved'),
(21, 'Logo2', 2500.00, 'afadf', 'customer@gmail.com', 'sdgfas', 'sdfgv', 'Gcash', NULL, 'sdf', '2025-11-27 10:55:36', 'approved'),
(22, 'Tshirt2', 900.00, 'Customer User', 'customer@gmail.com', '0078078907090', 'dfgdfg', 'COD', NULL, 'sdfhb', '2025-11-27 11:06:38', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `due_date` datetime NOT NULL,
  `status` enum('pending','successful','unsuccessful') DEFAULT 'pending',
  `completed` tinyint(1) DEFAULT 0,
  `customer_id` int(11) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(50) DEFAULT NULL,
  `customer_notes` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `title`, `description`, `due_date`, `status`, `completed`, `customer_id`, `customer_name`, `customer_email`, `customer_phone`, `customer_notes`) VALUES
(10, 'Isksjsj', 'hsheushs', '2025-12-20 19:35:00', 'pending', 0, NULL, 'Hiro', 'cenizajanhiro@smcbi.edu.ph', '09283673927', 'cute'),
(11, 'tshirt', '5 pcs', '2025-11-23 10:15:00', 'pending', 0, NULL, 'heyrow', 'hiro@gmail.com', '09077515757', 'kapoy');

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE `tb_users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('admin','customer') NOT NULL DEFAULT 'customer'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`id`, `name`, `email`, `phone`, `password`, `created_at`, `role`) VALUES
(1, 'Hiro', 'admin@gmail.com', '09123456789', '$2y$10$24goyuX9u02T1t5MuYTOVunvKIwYd9ZHKcPgUfwDa59JVPt7gcBMe', '2025-11-23 14:42:46', 'admin'),
(2, 'Customer User', 'customer@gmail.com', '09123456789', '$2y$10$Zs/KMTJqeWlIIwG31MiVw.bI1cW80wvHozPV2oRwkf4DyGNQWR1Oe', '2025-11-26 03:48:53', 'customer'),
(3, 'haha', 'ad@gmail.com', '09122255472', '$2y$10$GZsCy.OIKV1FdsDowfLjI.3Hg6FRhG9jc1E/9Zbm4YxTrMfRT70Ca', '2025-11-26 11:39:06', 'customer'),
(4, 'Jan Hiro Ceniza', 'adn@gmail.com', '09122255472', '$2y$10$FpIhjXEjTWPip3F.PilMOekKUqkUnhTJKeXdNhcmp6Nxj9zH0eo8i', '2025-11-26 11:40:58', 'customer'),
(5, 'ergreq', 'h@gmail.com', '0009790799', '$2y$10$emiPabMwHOPmYdjMYiTZa.cSdTiwxFkGU.AZhcgsbfCmOJl1Y61VC', '2025-11-27 11:14:14', 'customer'),
(6, 'swfswfg', 'r@gmail.com', '56897859', '$2y$10$/CsuwgHX9ZCzyFx1uQPDguJdzW17RNZFgDIfhsqQBBsX/Xd.CKRp6', '2025-11-27 11:17:04', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designs`
--
ALTER TABLE `designs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `designs`
--
ALTER TABLE `designs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
