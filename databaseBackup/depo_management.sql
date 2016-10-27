-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2016 at 02:47 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

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
(1, 12, 19, 120, 16, 1920, '2016-10-24'),
(2, 12, 21, 120, 60, 1920, '2016-10-24'),
(3, 12, 20, 300, 25, 2220, '2016-10-24');

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
  `store_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `depo_store`
--

INSERT INTO `depo_store` (`id`, `depo_id`, `pro_id`, `pro_quantity`, `pro_price`, `total_price`, `store_date`) VALUES
(3, 12, 20, -235, 300, -70500, '2016-10-24'),
(4, 12, 19, -140, 120, -16800, '2016-10-27'),
(9, 12, 22, 60, 500, 30000, '2016-10-27');

-- --------------------------------------------------------

--
-- Table structure for table `depo_total_sales`
--

CREATE TABLE `depo_total_sales` (
  `id` int(11) NOT NULL,
  `depo_id` int(11) NOT NULL,
  `depo_total_sales_quantity` int(11) NOT NULL,
  `today_sales_tk` int(11) NOT NULL,
  `date_time` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `depo_total_sales`
--

INSERT INTO `depo_total_sales` (`id`, `depo_id`, `depo_total_sales_quantity`, `today_sales_tk`, `date_time`) VALUES
(15, 12, 0, 300, '2016-10-19'),
(16, 12, 101, 6060, '2016-10-24');

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
-- Table structure for table `final_balance`
--

CREATE TABLE `final_balance` (
  `id` int(11) NOT NULL,
  `total_pro_quantity` int(11) NOT NULL,
  `total_pro_taka` int(11) NOT NULL,
  `total_sales_quantity` int(11) NOT NULL,
  `total_sales_taka` int(11) NOT NULL,
  `total_damage_quantity` int(11) NOT NULL,
  `total_damage_tk` int(11) NOT NULL,
  `month_total_quantity` int(11) NOT NULL,
  `month_total_cost` int(11) NOT NULL,
  `total_profit` int(11) NOT NULL,
  `final_bal_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `final_balance`
--

INSERT INTO `final_balance` (`id`, `total_pro_quantity`, `total_pro_taka`, `total_sales_quantity`, `total_sales_taka`, `total_damage_quantity`, `total_damage_tk`, `month_total_quantity`, `month_total_cost`, `total_profit`, `final_bal_date`) VALUES
(2, 610, 91200, 0, 300, 240, 28800, 610, 91500, 62700, '2016-10-23'),
(3, 610, 91200, 0, 300, 240, 28800, 610, 91500, 62700, '2016-10-23'),
(4, 610, 91200, 0, 300, 240, 28800, 610, 91500, 62700, '2016-10-23'),
(5, 610, 91200, 0, 300, 240, 28800, 610, 91500, 62700, '2016-10-23'),
(6, 610, 91200, 0, 300, 240, 28800, 610, 91500, 62700, '2016-10-23');

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
  `depo_id` int(11) NOT NULL,
  `pack_name_id` int(11) NOT NULL,
  `total_item` int(11) NOT NULL,
  `percentageOff` int(11) NOT NULL,
  `total_sales_taka` int(11) NOT NULL,
  `package_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`id`, `depo_id`, `pack_name_id`, `total_item`, `percentageOff`, `total_sales_taka`, `package_date`) VALUES
(2, 12, 3, 10, 15, 450, '2016-10-27'),
(3, 12, 3, 0, 15, 0, '2016-10-27'),
(4, 12, 3, 10, 15, 450, '2016-10-27');

-- --------------------------------------------------------

--
-- Table structure for table `pack_name`
--

CREATE TABLE `pack_name` (
  `id` int(11) NOT NULL,
  `package_name` varchar(35) NOT NULL,
  `percentage` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pack_name`
--

INSERT INTO `pack_name` (`id`, `package_name`, `percentage`) VALUES
(3, '24 pcs', 15),
(4, '72 pcs', 25),
(6, '500 pcs', 35);

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
  `entry_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `user_id`, `cat_id`, `pro_name`, `pro_price`, `quantity`, `total_price`, `uploader`, `entry_date`) VALUES
(19, 4, 20, 'Bags', 120, 142, 17040, 'admin', '2016-10-22'),
(20, 4, 21, 'mouse', 300, 216, 300, 'admin', '2016-10-22'),
(21, 4, 27, 'notes', 120, 216, 120, 'admin', '2016-10-22'),
(22, 4, 25, 'nazrul', 500, 140, 70000, 'admin', '2016-09-14');

-- --------------------------------------------------------

--
-- Table structure for table `total_warranty`
--

CREATE TABLE `total_warranty` (
  `id` int(11) NOT NULL,
  `depo_id` int(11) NOT NULL,
  `warranty_quantity` int(11) NOT NULL,
  `total_warranty_tk` int(11) NOT NULL,
  `warranty_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `total_warranty`
--

INSERT INTO `total_warranty` (`id`, `depo_id`, `warranty_quantity`, `total_warranty_tk`, `warranty_date`) VALUES
(14, 12, 60, 7200, '2016-10-24'),
(15, 12, 70, 8400, '2016-10-24');

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
(5, 'bsi', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'superadmin', '2016-09-18 11:21:57', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `warranty`
--

CREATE TABLE `warranty` (
  `id` int(11) NOT NULL,
  `depo_id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `pro_price` int(6) NOT NULL,
  `quantity` int(6) NOT NULL,
  `total_price` int(11) NOT NULL,
  `replace_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `warranty`
--

INSERT INTO `warranty` (`id`, `depo_id`, `pro_id`, `pro_price`, `quantity`, `total_price`, `replace_date`) VALUES
(8, 12, 19, 120, 20, 2400, '2016-10-24'),
(11, 12, 21, 120, 50, 6000, '2016-10-24');

-- --------------------------------------------------------

--
-- Table structure for table `workshop_loss`
--

CREATE TABLE `workshop_loss` (
  `id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `enter_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `workshop_loss`
--

INSERT INTO `workshop_loss` (`id`, `pro_id`, `quantity`, `total_price`, `enter_date`) VALUES
(2, 19, 80, 9600, '2016-10-23'),
(3, 21, 190, 22800, '2016-10-24'),
(4, 22, 20, 10000, '2016-10-24'),
(17, 20, 20, 6000, '2016-10-24');

--
-- Indexes for dumped tables
--

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
  ADD KEY `pro_id` (`pro_id`),
  ADD KEY `pro_id_2` (`pro_id`);

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
  ADD KEY `depo_id` (`depo_id`),
  ADD KEY `depo_id_2` (`depo_id`);

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
-- Indexes for table `final_balance`
--
ALTER TABLE `final_balance`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `pack_name_id` (`pack_name_id`),
  ADD KEY `pack_name_id_2` (`pack_name_id`),
  ADD KEY `pack_name_id_3` (`pack_name_id`),
  ADD KEY `depo_id` (`depo_id`);

--
-- Indexes for table `pack_name`
--
ALTER TABLE `pack_name`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indexes for table `total_warranty`
--
ALTER TABLE `total_warranty`
  ADD PRIMARY KEY (`id`),
  ADD KEY `depo_id` (`depo_id`),
  ADD KEY `depo_id_2` (`depo_id`),
  ADD KEY `depo_id_3` (`depo_id`);

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
  ADD KEY `pro_id` (`pro_id`),
  ADD KEY `depo_id_2` (`depo_id`),
  ADD KEY `pro_id_2` (`pro_id`),
  ADD KEY `depo_id_3` (`depo_id`),
  ADD KEY `pro_id_3` (`pro_id`);

--
-- Indexes for table `workshop_loss`
--
ALTER TABLE `workshop_loss`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pro_id` (`pro_id`),
  ADD KEY `pro_id_2` (`pro_id`);

--
-- AUTO_INCREMENT for dumped tables
--

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `depo_store`
--
ALTER TABLE `depo_store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `depo_total_sales`
--
ALTER TABLE `depo_total_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
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
-- AUTO_INCREMENT for table `final_balance`
--
ALTER TABLE `final_balance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `pack_name`
--
ALTER TABLE `pack_name`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `total_warranty`
--
ALTER TABLE `total_warranty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `warranty`
--
ALTER TABLE `warranty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `workshop_loss`
--
ALTER TABLE `workshop_loss`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- Constraints for dumped tables
--

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
  ADD CONSTRAINT `package_ibfk_1` FOREIGN KEY (`pack_name_id`) REFERENCES `pack_name` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `package_ibfk_2` FOREIGN KEY (`depo_id`) REFERENCES `depo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`cat_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `total_warranty`
--
ALTER TABLE `total_warranty`
  ADD CONSTRAINT `total_warranty_ibfk_2` FOREIGN KEY (`depo_id`) REFERENCES `depo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `warranty`
--
ALTER TABLE `warranty`
  ADD CONSTRAINT `warranty_ibfk_1` FOREIGN KEY (`depo_id`) REFERENCES `depo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `warranty_ibfk_3` FOREIGN KEY (`pro_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `workshop_loss`
--
ALTER TABLE `workshop_loss`
  ADD CONSTRAINT `workshop_loss_ibfk_1` FOREIGN KEY (`pro_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
