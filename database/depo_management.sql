-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2016 at 02:43 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `depo_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `balance`
--

CREATE TABLE `balance` (
  `id` int(11) NOT NULL,
  `depo_id` int(11) NOT NULL,
  `total_sales_id` int(11) NOT NULL,
  `warranty_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `catName` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `catName`) VALUES
(17, 'mobile'),
(20, 'book'),
(21, 'computer'),
(22, 'laptop'),
(23, 'deskTable'),
(24, 'button'),
(25, 'mango'),
(26, 'apple'),
(27, 'banana'),
(28, 'jack-fruit'),
(29, 'black-berry');

-- --------------------------------------------------------

--
-- Table structure for table `depo`
--

CREATE TABLE `depo` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `depo_name` varchar(80) NOT NULL,
  `first_name` varchar(15) NOT NULL,
  `last_name` varchar(15) NOT NULL,
  `birthDate` date NOT NULL,
  `nid` int(19) NOT NULL,
  `phone` int(11) NOT NULL,
  `email` varchar(35) NOT NULL,
  `website` varchar(35) NOT NULL,
  `upazilla` varchar(20) NOT NULL,
  `district` varchar(20) NOT NULL,
  `division` varchar(20) NOT NULL,
  `street` varchar(40) NOT NULL,
  `uploader` varchar(20) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `profile_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `picture` varchar(47) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `depo`
--

INSERT INTO `depo` (`id`, `user_id`, `depo_name`, `first_name`, `last_name`, `birthDate`, `nid`, `phone`, `email`, `website`, `upazilla`, `district`, `division`, `street`, `uploader`, `create_date`, `profile_update`, `picture`) VALUES
(12, 4, 'Bright telecom ltd', 'araf', 'hossain', '0000-00-00', 123456789, 123456789, 'pazihasan@gmail.com', 'bright.com', 'dhaka', 'Dhaka', 'sylhet', 'Banasree project,Dhaka-1219', 'admin', '2016-09-28 10:51:29', '2016-10-01 04:40:12', '29d6959fba0638092486a5d52ed000e7d65bb46d.jpg'),
(13, 2, 'bright insurance', 'araf', 'hossain', '2009-09-16', 123456789, 123456789, 'pazihasan@gmail.com', 'bright.com', 'Dhaka', 'Dhaka', 'chittagong', 'Banasree project,Dhaka-1219', 'nazrul', '2016-09-28 12:10:09', '2016-09-28 12:10:09', 'aac8ad733053ee9cbb56d28ab610f6284be1959b.jpg'),
(14, 5, 'star technology', 'star', 'technology', '2006-10-16', 1233456789, 12457869, 'hukushpakush2015@gmail.com', 'fffff', 'fffff', 'frrrr', 'khulna', 'fffff', 'bsi', '2016-10-15 07:51:07', '2016-10-15 07:51:07', 'c10a4ebee38a08e1c5930b0f786b99f4404fbf77.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `depo_sales`
--

CREATE TABLE `depo_sales` (
  `id` int(11) NOT NULL,
  `depo_id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `pro_price` int(8) NOT NULL,
  `quantity` int(6) NOT NULL,
  `total_price` int(11) NOT NULL,
  `date_time` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `depo_sales`
--

INSERT INTO `depo_sales` (`id`, `depo_id`, `pro_id`, `pro_price`, `quantity`, `total_price`, `date_time`) VALUES
(45, 12, 14, 10, 10, 100, '2016-10-15'),
(46, 12, 15, 10, 10, 100, '2016-10-15'),
(47, 12, 16, 5, 20, 100, '2016-10-15'),
(48, 12, 16, 5, 30, 150, '2016-10-15'),
(56, 14, 16, 5, 7, 35, '2016-10-15'),
(57, 14, 16, 5, 7, 35, '2016-10-15'),
(58, 14, 15, 10, 2, 20, '2016-10-15'),
(59, 14, 15, 10, 2, 20, '2016-10-15'),
(60, 12, 16, 5, 10, 50, '2016-10-15'),
(61, 12, 16, 5, 10, 50, '2016-10-15'),
(62, 12, 14, 10, 6, 60, '2016-10-15'),
(63, 12, 14, 10, 6, 60, '2016-10-15'),
(64, 12, 14, 10, 6, 60, '2016-10-15'),
(65, 12, 14, 10, 6, 60, '2016-10-15'),
(66, 14, 16, 5, 10, 50, '2016-10-15'),
(67, 14, 16, 5, 10, 50, '2016-10-15');

-- --------------------------------------------------------

--
-- Table structure for table `depo_store`
--

CREATE TABLE `depo_store` (
  `id` int(11) NOT NULL,
  `depo_id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `pro_quantity` int(6) NOT NULL,
  `pro_price` int(6) NOT NULL,
  `total_price` int(11) NOT NULL,
  `entry_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `depo_store`
--

INSERT INTO `depo_store` (`id`, `depo_id`, `pro_id`, `pro_quantity`, `pro_price`, `total_price`, `entry_date`) VALUES
(12, 12, 14, -7, 10, -70, '2016-10-11 06:55:58'),
(13, 12, 16, -39, 5, -195, '2016-10-11 06:56:20'),
(14, 12, 15, 14, 10, 140, '2016-10-11 07:12:27');

-- --------------------------------------------------------

--
-- Table structure for table `depo_total_sales`
--

CREATE TABLE `depo_total_sales` (
  `id` int(11) NOT NULL,
  `depo_id` int(11) NOT NULL,
  `prev_total_sales_tk` int(11) NOT NULL,
  `today_sales_tk` int(11) NOT NULL,
  `total_taka` int(11) NOT NULL,
  `date_time` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `depo_total_sales`
--

INSERT INTO `depo_total_sales` (`id`, `depo_id`, `prev_total_sales_tk`, `today_sales_tk`, `total_taka`, `date_time`) VALUES
(4, 13, 0, 9000, 9000, '2016-10-15'),
(5, 13, 0, 9000, 9000, '2016-10-15'),
(6, 13, 0, 9000, 9000, '2016-10-15'),
(7, 13, 0, 9000, 9000, '2016-10-15'),
(8, 13, 0, 9000, 9000, '2016-10-15'),
(9, 12, 0, 975, 975, '2016-10-15');

-- --------------------------------------------------------

--
-- Table structure for table `due`
--

CREATE TABLE `due` (
  `id` int(11) NOT NULL,
  `depo_id` int(11) NOT NULL,
  `client_name` varchar(30) NOT NULL,
  `phone` int(11) NOT NULL,
  `address` varchar(50) NOT NULL,
  `pro_name` varchar(30) NOT NULL,
  `pro_price` int(8) NOT NULL,
  `total_due_price` int(11) NOT NULL,
  `uploader` varchar(30) NOT NULL,
  `quantity` int(6) NOT NULL,
  `due_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `due_pay`
--

CREATE TABLE `due_pay` (
  `id` int(11) NOT NULL,
  `due_id` int(11) NOT NULL,
  `depo_id` int(11) NOT NULL,
  `client_name` varchar(30) NOT NULL,
  `phone` int(11) NOT NULL,
  `address` varchar(50) NOT NULL,
  `pro_name` varchar(30) NOT NULL,
  `pro_price` int(8) NOT NULL,
  `total_due_price` int(8) NOT NULL,
  `uploader` varchar(30) NOT NULL,
  `quantity` int(5) NOT NULL,
  `pay_date` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `user_type` varchar(20) NOT NULL,
  `message` varchar(400) NOT NULL,
  `from_person` varchar(50) NOT NULL,
  `to_person` varchar(50) NOT NULL,
  `message_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `depo_id` int(11) NOT NULL,
  `depo_name` varchar(50) NOT NULL,
  `notification_msg` varchar(120) NOT NULL,
  `notification_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE `package` (
  `id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `pro_name` varchar(30) NOT NULL,
  `pro_price` int(6) NOT NULL,
  `quantity` int(6) NOT NULL,
  `total_package` int(4) NOT NULL,
  `package_price` int(8) NOT NULL,
  `total_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `pro_name` varchar(30) NOT NULL,
  `pro_price` int(6) NOT NULL,
  `quantity` int(6) NOT NULL,
  `total_price` int(11) NOT NULL,
  `uploader` varchar(30) NOT NULL,
  `entry_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `user_id`, `cat_id`, `pro_name`, `pro_price`, `quantity`, `total_price`, `uploader`, `entry_date`) VALUES
(14, 4, 20, 'pen', 10, 3, 30, 'admin', '2016-10-11 06:52:58'),
(15, 4, 20, 'notes', 10, 2, 20, 'admin', '2016-10-11 06:53:20'),
(16, 4, 21, 'mouse', 5, 5, 25, 'admin', '2016-10-11 06:54:11');

-- --------------------------------------------------------

--
-- Table structure for table `total_pro_info`
--

CREATE TABLE `total_pro_info` (
  `id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `total_item` int(5) NOT NULL,
  `total_products` int(11) NOT NULL,
  `total_amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `total_warranty`
--

CREATE TABLE `total_warranty` (
  `id` int(11) NOT NULL,
  `warranty_id` int(11) NOT NULL,
  `depo_id` int(11) NOT NULL,
  `pre_warranty` int(10) NOT NULL,
  `today_warranty` int(10) NOT NULL,
  `total_warranty` int(10) NOT NULL,
  `total_warranty_tk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `userName` varchar(20) NOT NULL,
  `password` varchar(42) NOT NULL,
  `userType` varchar(20) NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `userName`, `password`, `userType`, `last_login`, `status`) VALUES
(2, 'nazrul', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'employee', '2016-08-27 06:58:46', 'active'),
(4, 'admin', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'admin', '2016-08-27 09:12:03', 'active'),
(5, 'bsi', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'superadmin', '2016-09-18 11:21:57', 'active'),
(20, 'arif', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'employee', '2016-09-26 09:37:50', 'deactive');

-- --------------------------------------------------------

--
-- Table structure for table `warranty`
--

CREATE TABLE `warranty` (
  `id` int(11) NOT NULL,
  `depo_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `pro_name` varchar(30) NOT NULL,
  `pro_price` int(6) NOT NULL,
  `quantity` int(6) NOT NULL,
  `total_price` int(11) NOT NULL,
  `sales_date` date NOT NULL,
  `replace_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `balance`
--
ALTER TABLE `balance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `depo_id` (`depo_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `depo`
--
ALTER TABLE `depo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `depo_sales`
--
ALTER TABLE `depo_sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `depo_id` (`depo_id`),
  ADD KEY `pro_id` (`pro_id`);

--
-- Indexes for table `depo_store`
--
ALTER TABLE `depo_store`
  ADD PRIMARY KEY (`id`),
  ADD KEY `depo_id` (`depo_id`),
  ADD KEY `pro_id` (`pro_id`),
  ADD KEY `pro_id_2` (`pro_id`);

--
-- Indexes for table `depo_total_sales`
--
ALTER TABLE `depo_total_sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `depo_id` (`depo_id`);

--
-- Indexes for table `due`
--
ALTER TABLE `due`
  ADD PRIMARY KEY (`id`),
  ADD KEY `depo_id` (`depo_id`);

--
-- Indexes for table `due_pay`
--
ALTER TABLE `due_pay`
  ADD PRIMARY KEY (`id`),
  ADD KEY `due_id` (`due_id`),
  ADD KEY `depo_id` (`depo_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pro_id` (`pro_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indexes for table `total_pro_info`
--
ALTER TABLE `total_pro_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_id` (`products_id`);

--
-- Indexes for table `total_warranty`
--
ALTER TABLE `total_warranty`
  ADD PRIMARY KEY (`id`),
  ADD KEY `warranty_id` (`warranty_id`),
  ADD KEY `depo_id` (`depo_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warranty`
--
ALTER TABLE `warranty`
  ADD PRIMARY KEY (`id`),
  ADD KEY `depo_id` (`depo_id`),
  ADD KEY `cat_id` (`cat_id`),
  ADD KEY `pro_id` (`pro_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `balance`
--
ALTER TABLE `balance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `depo`
--
ALTER TABLE `depo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `depo_sales`
--
ALTER TABLE `depo_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
--
-- AUTO_INCREMENT for table `depo_store`
--
ALTER TABLE `depo_store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `depo_total_sales`
--
ALTER TABLE `depo_total_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `due`
--
ALTER TABLE `due`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `due_pay`
--
ALTER TABLE `due_pay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `package`
--
ALTER TABLE `package`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `total_pro_info`
--
ALTER TABLE `total_pro_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `total_warranty`
--
ALTER TABLE `total_warranty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `balance`
--
ALTER TABLE `balance`
  ADD CONSTRAINT `balance_ibfk_1` FOREIGN KEY (`depo_id`) REFERENCES `depo` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `depo`
--
ALTER TABLE `depo`
  ADD CONSTRAINT `depo_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `depo_sales`
--
ALTER TABLE `depo_sales`
  ADD CONSTRAINT `depo_sales_ibfk_1` FOREIGN KEY (`depo_id`) REFERENCES `depo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `depo_sales_ibfk_3` FOREIGN KEY (`pro_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `depo_store`
--
ALTER TABLE `depo_store`
  ADD CONSTRAINT `depo_store_ibfk_1` FOREIGN KEY (`depo_id`) REFERENCES `depo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `depo_store_ibfk_3` FOREIGN KEY (`pro_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `depo_total_sales`
--
ALTER TABLE `depo_total_sales`
  ADD CONSTRAINT `depo_total_sales_ibfk_1` FOREIGN KEY (`depo_id`) REFERENCES `depo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `due`
--
ALTER TABLE `due`
  ADD CONSTRAINT `due_ibfk_1` FOREIGN KEY (`depo_id`) REFERENCES `depo` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `due_pay`
--
ALTER TABLE `due_pay`
  ADD CONSTRAINT `due_pay_ibfk_1` FOREIGN KEY (`due_id`) REFERENCES `due` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `due_pay_ibfk_2` FOREIGN KEY (`depo_id`) REFERENCES `depo` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `package`
--
ALTER TABLE `package`
  ADD CONSTRAINT `package_ibfk_2` FOREIGN KEY (`pro_id`) REFERENCES `products` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`cat_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `total_pro_info`
--
ALTER TABLE `total_pro_info`
  ADD CONSTRAINT `total_pro_info_ibfk_1` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `total_warranty`
--
ALTER TABLE `total_warranty`
  ADD CONSTRAINT `total_warranty_ibfk_1` FOREIGN KEY (`warranty_id`) REFERENCES `warranty` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `total_warranty_ibfk_2` FOREIGN KEY (`depo_id`) REFERENCES `depo` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `warranty`
--
ALTER TABLE `warranty`
  ADD CONSTRAINT `warranty_ibfk_1` FOREIGN KEY (`depo_id`) REFERENCES `depo` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `warranty_ibfk_2` FOREIGN KEY (`cat_id`) REFERENCES `category` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `warranty_ibfk_3` FOREIGN KEY (`pro_id`) REFERENCES `products` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
