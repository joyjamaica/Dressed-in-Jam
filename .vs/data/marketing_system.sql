-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2026 at 07:44 PM
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
-- Database: `marketing_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_details`
--

CREATE TABLE `cart_details` (
  `c_id` int(12) NOT NULL,
  `cart_id` int(12) NOT NULL,
  `prod_id` int(12) NOT NULL,
  `cqty` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_details`
--

INSERT INTO `cart_details` (`c_id`, `cart_id`, `prod_id`, `cqty`) VALUES
(1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cart_master`
--

CREATE TABLE `cart_master` (
  `cart_id` int(12) NOT NULL,
  `cdate` date NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_master`
--

INSERT INTO `cart_master` (`cart_id`, `cdate`, `id`) VALUES
(10000, '0000-00-00', 0),
(10004, '2026-10-05', 1344567);

-- --------------------------------------------------------

--
-- Table structure for table `customer_table`
--

CREATE TABLE `customer_table` (
  `id` int(10) NOT NULL,
  `f_name` varchar(255) NOT NULL,
  `l_name` varchar(255) NOT NULL,
  `mi` varchar(1) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(100) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_table`
--

INSERT INTO `customer_table` (`id`, `f_name`, `l_name`, `mi`, `email`, `role`, `username`, `password`, `status`) VALUES
(119957, 'Ara', 'Bemil', 'A', 'ara@gmail.com', 'customer', 'arabela', 'arabela123', 'Approved'),
(1344567, 'Jammy', 'Bemil', 'A', 'jammy@gmail.com', 'admin', 'Maica', 'maica123', ''),
(25233560, 'Jamaica', 'Bemil', 'A', 'bjamaicajoy@gmail.com', '', 'jamaica', '123', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `product_table`
--

CREATE TABLE `product_table` (
  `prod_id` int(11) NOT NULL,
  `prod_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_table`
--

INSERT INTO `product_table` (`prod_id`, `prod_name`, `description`, `price`, `quantity`, `image`) VALUES
(1002, 'Dress', 'Bridgerton inspired dress.', 450, 18, 'dress1.jfif'),
(1004, 'Off-shoulder dress', 'Elegant shoulder satin dress', 800, 20, 'dress3.jfif'),
(1005, 'Evening Dress', 'A flattering evening dress that will make you look smaller.', 650, 10, 'dress4.webp'),
(1006, 'Floral Wedding Dress', 'Wren floral lace wedding dress.', 25000, 2, 'wedding dress.jfif'),
(1007, 'Ball Gown Wedding Dress', 'Overlace A-line wedding dress with scoop neckline.', 20000, 5, 'wedding dress 2.webp'),
(1008, 'Short Off-shoulder Dress', 'An off-shoulder dress that is best for parties.', 350, 30, 'short off-shoulder dress.webp'),
(1009, 'Party Dress', 'Designer Party dress.', 400, 15, 'partydress.webp'),
(1010, 'Korean Party Dress', 'Red korean elegant party dress.', 500, 10, 'korean party dress.jfif'),
(1011, 'Black Korean Dress', 'A dress that is best for many occasion.', 320, 50, 'koreandress2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_details`
--

CREATE TABLE `purchase_details` (
  `p_id` int(12) NOT NULL,
  `purchase_id` int(12) NOT NULL,
  `prod_id` int(10) NOT NULL,
  `pqty` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase_details`
--

INSERT INTO `purchase_details` (`p_id`, `purchase_id`, `prod_id`, `pqty`) VALUES
(0, 0, 1002, 2);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_master`
--

CREATE TABLE `purchase_master` (
  `purchase_id` int(12) NOT NULL,
  `pdate` date NOT NULL,
  `id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase_master`
--

INSERT INTO `purchase_master` (`purchase_id`, `pdate`, `id`) VALUES
(0, '2026-11-01', 1344567);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_details`
--
ALTER TABLE `cart_details`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `cart_master`
--
ALTER TABLE `cart_master`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `customer_table`
--
ALTER TABLE `customer_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_table`
--
ALTER TABLE `product_table`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `purchase_master`
--
ALTER TABLE `purchase_master`
  ADD PRIMARY KEY (`purchase_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_details`
--
ALTER TABLE `cart_details`
  MODIFY `c_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `cart_master`
--
ALTER TABLE `cart_master`
  MODIFY `cart_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10005;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
