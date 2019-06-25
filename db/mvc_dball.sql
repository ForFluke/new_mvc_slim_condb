-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2019 at 03:19 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mvc_dball`
--

-- --------------------------------------------------------

--
-- Table structure for table `active_account`
--

CREATE TABLE `active_account` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `mvc_admin`
--

CREATE TABLE `mvc_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `nickname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `tell` varchar(20) NOT NULL,
  `img_part` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mvc_admin`
--

INSERT INTO `mvc_admin` (`id`, `username`, `nickname`, `email`, `password`, `tell`, `img_part`) VALUES
(1, 'Admin', 'Admin', 'admin', '123456', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `mvc_content`
--

CREATE TABLE `mvc_content` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `detail` text NOT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mvc_content`
--

INSERT INTO `mvc_content` (`id`, `title`, `detail`, `create_time`, `update_time`) VALUES
(1, 'ทดสอบการแสดงผลเนื้อหา', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.\n\nDonec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget\n\nNam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc.', '2019-06-20 15:30:45', '2019-06-25 11:02:49'),
(2, 'ทดสอบการแสดงเนื้อหา 2 ', 'Quis pharetra a pharetra fames blandit. Risus faucibus velit Risus imperdiet mattis neque volutpat, etiam lacinia netus dictum magnis per facilisi sociosqu. Volutpat. Ridiculus nostra.', '2019-06-20 15:31:23', '2019-06-20 16:19:11'),
(3, 'ทดสอบ content ใหม่ๆ', 'test content\n\n\n\n\n\n\n', '2019-06-21 16:41:37', '2019-06-21 16:42:09');

-- --------------------------------------------------------

--
-- Table structure for table `mvc_member`
--

CREATE TABLE `mvc_member` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `nickname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(30) NOT NULL,
  `tell` varchar(20) NOT NULL,
  `img_part` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mvc_member`
--

INSERT INTO `mvc_member` (`id`, `username`, `nickname`, `email`, `password`, `tell`, `img_part`) VALUES
(1, 'Tawin Pasmanee', 'Fluke', 'tawin.pas@readyplanet.com', '123456', '083xxxxxxx', '50520743_2507459125993524_1920758814139744256_n.jpg'),
(2, 'Tawan Pasmanee', 'wan ', 'tawin@hotmail.com', '1234', '083xxxxxxx', '50520743_2507459125993524_1920758814139744256_n.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `mvc_menu`
--

CREATE TABLE `mvc_menu` (
  `id` int(11) NOT NULL,
  `menu_name` varchar(100) NOT NULL,
  `part_menu` varchar(100) NOT NULL,
  `status` varchar(2) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mvc_menu`
--

INSERT INTO `mvc_menu` (`id`, `menu_name`, `part_menu`, `status`, `create_time`, `update_time`) VALUES
(1, 'เมนูหลัก', 'home', '1', '0000-00-00 00:00:00', '2019-06-25 11:08:13'),
(2, 'ข้อมูลส่วนตัว', 'profile', '1', '0000-00-00 00:00:00', '2019-06-20 16:47:56'),
(3, 'ติดต่อเรา', 'contact', '2', '0000-00-00 00:00:00', '2019-06-20 16:48:12'),
(4, 'แนะนำ', 'introduce', '2', '2019-06-20 09:17:42', '2019-06-20 16:56:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `active_account`
--
ALTER TABLE `active_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mvc_admin`
--
ALTER TABLE `mvc_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mvc_content`
--
ALTER TABLE `mvc_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mvc_member`
--
ALTER TABLE `mvc_member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mvc_menu`
--
ALTER TABLE `mvc_menu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `active_account`
--
ALTER TABLE `active_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mvc_admin`
--
ALTER TABLE `mvc_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mvc_content`
--
ALTER TABLE `mvc_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mvc_member`
--
ALTER TABLE `mvc_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mvc_menu`
--
ALTER TABLE `mvc_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
