-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2024 at 06:31 AM
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
-- Database: `mrsg`
--

-- --------------------------------------------------------

--
-- Table structure for table `ref_no`
--

CREATE TABLE `ref_no` (
  `ref_id` int(11) NOT NULL,
  `ref_no` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ref_no`
--

INSERT INTO `ref_no` (`ref_id`, `ref_no`) VALUES
(1, 'mrsg-Tsyan4xn8T'),
(2, 'mrsg-cxb08iDQNn'),
(3, 'mrsg-UvCsLP2WgL'),
(4, 'mrsg-tpUADGHzEh'),
(5, 'mrsg-dyrqzXwlxY'),
(6, 'mrsg-QKAIXBxOsZ'),
(7, 'mrsg-WYhijDVzqT'),
(8, 'mrsg-n4UE1TNssy');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `full_name`, `username`, `password`) VALUES
(1, 'Princess Dianne Valdez', 'Cessy', '12345'),
(2, 'Princess Dianne Valdez', 'princessdianne', '827ccb0eea8a706c4c34a16891f84e7b');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cake`
--

CREATE TABLE `tbl_cake` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `featured` varchar(10) NOT NULL,
  `active` varchar(10) NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_cake`
--

INSERT INTO `tbl_cake` (`id`, `title`, `description`, `price`, `image_name`, `category_id`, `featured`, `active`, `quantity`) VALUES
(1, 'Caramelo Mango 6RD', 'Delicious mango-flavored cake.', 369.00, '1.jpg', 1, 'Yes', 'Yes', 33),
(2, 'Lush Ube Velvet 6RD', 'Velvety ube-flavored cake.', 369.00, '2.jpg', 1, 'No', 'Yes', 15),
(3, 'Ube Grande 8RD', 'Rich and creamy ube cake.', 489.00, '3.jpg', 2, 'Yes', 'Yes', 13),
(4, 'Vanilla Grande 8RD', 'Classic vanilla cake with almond.', 489.00, '4.jpg', 2, 'Yes', 'Yes', 55),
(5, 'Choco Grande 8RD', 'Decadent chocolate cake.', 489.00, '5.jpg', 2, 'Yes', 'Yes', 22),
(6, 'LUSH UBE VELVET 9RD', 'Delicious ube velvet cake.', 599.00, '6.jpg', 3, 'No', 'Yes', 22),
(7, 'BANAMEL POUND 9RD', 'Moist pound cake.', 599.00, '7.jpg', 3, 'No', 'Yes', 9),
(8, 'BUTTER VELVET 9RD', 'Velvety butter cake.', 599.00, '8.jpg', 3, 'No', 'Yes', 15),
(9, 'CHOCOMAX 9RD', 'Maximized chocolate cake.', 599.00, '9.jpg', 3, 'No', 'Yes', 8),
(10, 'COOKIES AND CREAM CARESS 9RD', 'Creamy cookies and cream cake.', 599.00, '10.jpg', 3, 'No', 'Yes', 8),
(11, 'TARTA DE MRSG 9RD', 'Special Mrs. G cake.', 599.00, '11.jpg', 3, 'No', 'Yes', 5),
(12, 'WHITE FOREST 9RD', 'Delicate white forest cake.', 599.00, '12.jpg', 3, 'No', 'Yes', 4),
(13, 'LUSH UBE VELVET 8X12', 'Velvety ube cake.', 699.00, '13.jpg', 4, 'No', 'Yes', 4),
(14, 'CARAMELO MANGO 8X12', 'Mango-flavored cake.', 699.00, '14.jpg', 4, 'No', 'Yes', 5),
(15, 'CHOCOMAX 8X12', 'Decadent chocolate cake.', 699.00, '15.jpg', 4, 'No', 'Yes', 5),
(16, 'YUMMYLICIOUS CARAMEL 8X12', 'Delicious caramel cake.', 699.00, '16.jpg', 4, 'No', 'Yes', 4),
(17, 'WHITE FOREST 8X12', 'Delicate white forest cake.', 699.00, '17.jpg', 4, 'No', 'Yes', 5),
(18, 'UBE SANS RIVAL 8X12', 'Classic ube sans rival cake.', 699.00, '18.jpg', 4, 'No', 'Yes', 5),
(19, 'CHOCO CARAMEL 4X14', 'Chocolate caramel cake.', 389.00, '19.jpg', 5, 'No', 'Yes', 5),
(20, 'UBE MACAPUNO 4X14', 'Ube macapuno cake.', 389.00, '20.jpg', 5, 'No', 'Yes', 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cart`
--

CREATE TABLE `tbl_cart` (
  `id` int(11) NOT NULL,
  `cake_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `u_id` int(11) DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT 1,
  `ref_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `featured` varchar(10) NOT NULL,
  `active` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`id`, `title`, `image_name`, `featured`, `active`) VALUES
(1, '6rd', '1.jpg', 'Yes', 'Yes'),
(2, '8rd', '6.jpg', 'No', 'Yes'),
(3, '9rd', '14.jpg', 'Yes', 'Yes'),
(4, '8x12', '18.jpg', 'Yes', 'Yes'),
(5, '4x14', '20.jpg', 'No', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE `tbl_order` (
  `id` int(11) NOT NULL,
  `cake` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL,
  `u_id` int(11) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `delivery_option` varchar(50) NOT NULL,
  `gcash_no` varchar(11) DEFAULT NULL,
  `ref_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_order`
--

INSERT INTO `tbl_order` (`id`, `cake`, `price`, `qty`, `total`, `order_date`, `status`, `u_id`, `payment_method`, `delivery_option`, `gcash_no`, `ref_no`) VALUES
(1, 'Caramelo Mango 6RD', 369.00, 1, 369.00, '2024-06-22 02:49:46', 'Ordered', 12, 'cash', 'pickup', '', 1),
(2, 'WHITE FOREST 9RD', 599.00, 1, 599.00, '2024-06-22 02:49:46', 'Ordered', 12, 'cash', 'pickup', '', 1),
(3, 'LUSH UBE VELVET 8X12', 699.00, 1, 699.00, '2024-06-22 02:51:39', 'Ordered', 12, 'cash', 'pickup', '', 2),
(4, 'YUMMYLICIOUS CARAMEL 8X12', 699.00, 1, 699.00, '2024-06-22 02:51:39', 'Ordered', 12, 'cash', 'pickup', '', 2),
(5, 'Caramelo Mango 6RD', 369.00, 2, 738.00, '2024-06-22 02:54:01', 'Ordered', 12, 'cash', 'pickup', '', 3),
(6, 'Caramelo Mango 6RD', 369.00, 1, 369.00, '2024-06-22 03:01:26', 'Ordered', 12, 'gcash', 'pickup', NULL, 0),
(7, 'Caramelo Mango 6RD', 369.00, 1, 369.00, '2024-06-22 03:02:19', 'Ordered', 11, 'gcash', 'pickup', NULL, 0),
(8, 'Caramelo Mango 6RD', 369.00, 1, 369.00, '2024-06-22 03:03:30', 'Ordered', 11, 'gcash', 'pickup', NULL, 0),
(9, 'Lush Ube Velvet 6RD', 369.00, 1, 369.00, '2024-06-22 03:06:55', 'Ordered', 11, 'gcash', 'pickup', NULL, 0),
(10, 'Ube Grande 8RD', 489.00, 1, 489.00, '2024-06-22 03:11:05', 'Ordered', 11, 'gcash', 'pickup', NULL, 0),
(11, 'Ube Grande 8RD', 489.00, 1, 489.00, '2024-06-22 03:12:35', 'Ordered', 11, 'cash', 'pickup', '', 4),
(12, 'Caramelo Mango 6RD', 369.00, 1, 369.00, '2024-06-22 03:21:45', 'Ordered', 11, 'cash', 'pickup', '', 5),
(13, 'Choco Grande 8RD', 489.00, 1, 489.00, '2024-06-22 04:14:31', 'Ordered', 11, 'gcash', 'pickup', '09991931710', 6),
(14, 'Caramelo Mango 6RD', 369.00, 1, 369.00, '2024-06-22 04:14:52', 'Ordered', 11, 'cash', 'pickup', '', 7),
(15, 'Caramelo Mango 6RD', 369.00, 1, 369.00, '2024-06-22 04:15:05', 'Ordered', 11, 'cash', 'pickup', '', 8),
(16, 'Caramelo Mango 6RD', 369.00, 1, 369.00, '2024-06-22 04:24:11', 'Ordered', 11, 'gcash', 'pickup', '09991931710', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `customer_contact` varchar(20) NOT NULL,
  `customer_address` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `customer_name`, `customer_email`, `customer_contact`, `customer_address`, `created_at`) VALUES
(1, 'Cessy', '$2y$10$6.3hyb/bzOIPTCYT377kqejKFl7piSZ2NFYXheukNislwb7uXDcq6', 'Princess Dianne Valdez', 'vmonieecess@gmail.com', '9970715710', '         Bliss, Ilagan City, Isabela', '2024-06-10 02:36:22'),
(3, 'ramos@gmail.com', '$2y$10$i5FZPmIR8ISa7csgWZxQXeP62JS11Dqm/yL6Jc5TC3t09vpge3Lxa', 'geraldine ramos', 'ramos@gmail.com', '970709821131', '         bs, isabela', '2024-06-18 12:54:41'),
(4, '@q', '$2y$10$cmOkXIAIjur8XLrMEFgHWu6Vrbw.xDGNW6KOTJsnuFsOTyn4vELv.', 'shu tek', 'q@gmail.com', '1234567890', '1, hah, nep, ka', '2024-06-18 13:36:56'),
(5, 'vmonieecess@gmail.com', '$2y$10$zE/PMxzgqz5pTRYXHzAthOBg2xWQoYJd7cqbgsP9XD8q2ufzowEI.', 'g ramos', 'g@gmail.com', '1234098665', 'pbs', '2024-06-18 15:29:49'),
(6, 'geraldineramos062', '$2y$10$UVJgBjocf8lBqust40nVauZ0yUIFjfGtLuojgQ9grCZfik/r094qi', 'gr', 'ge@gmail.com', '12', '12', '2024-06-18 16:45:46'),
(7, 'a', '$2y$10$FZvAo0q0mzpe0fE2pxQX8e9KPiNatX31h7fcSHqKpQUmY3lfs35Cq', 'a', 'a@gmail.com', '1', 'a', '2024-06-19 00:36:44'),
(8, 'b', '$2y$10$/KNv0It8WbXRQDZNAOKFwOJKWWlSI/ouYjFIwkJ2dQEV2YKbAp2vG', 'b', 'b@b.com', '1', '         b', '2024-06-20 08:54:39'),
(9, 'Hakdog', '$2y$10$KNhtCevYoJsSpMXsro3zk.kbTnh4fJdwL8UcuMTzYHuOoWNrxoeP2', 'Hakdog', 'h@h.com', '1234567890', 'a', '2024-06-20 09:02:33'),
(10, 'mark gerald', '$2y$10$hhjPV6ImLizLo11tiPHaLOAFll6DXV4wdIl0Gjy.qeBuJb8e4b4v.', 'mark gerald', 'markgerald@gmail.com', '1234567890', 'isu', '2024-06-20 09:33:56'),
(11, 'mike', '$2y$10$elEwTCbft41OboCRvUO79.hA/9H7hfAlbLYS/tKfX9RhR29CPXjxK', 'mike', 'mike@gmail.com', '0912345678', 'uuu', '2024-06-20 12:17:51'),
(12, 'chael', '$2y$10$JmH8Ax.yKxfGTDLnbrFOOucIavzmO1unCTpkvEuB0.K.fppLXnolq', 'chael', 'chael@gmail.com', '0922223456', 'biringan', '2024-06-20 19:43:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ref_no`
--
ALTER TABLE `ref_no`
  ADD PRIMARY KEY (`ref_id`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_cake`
--
ALTER TABLE `tbl_cake`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`u_id`);

--
-- Indexes for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `u_id` (`u_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ref_no`
--
ALTER TABLE `ref_no`
  MODIFY `ref_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_cake`
--
ALTER TABLE `tbl_cake`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`u_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD CONSTRAINT `tbl_order_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
