-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2017 at 05:18 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hrm`
--

-- --------------------------------------------------------

--
-- Table structure for table `calendars`
--

CREATE TABLE `calendars` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `time_in` datetime NOT NULL,
  `time_out` datetime NOT NULL,
  `time_cancel` datetime DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `calendars`
--

INSERT INTO `calendars` (`id`, `users_id`, `time_in`, `time_out`, `time_cancel`, `status`, `created`, `modified`) VALUES
(55, 17, '2017-01-05 19:00:00', '2017-01-05 20:00:00', NULL, 1, '2017-01-05 15:06:22', '2017-01-05 15:06:22'),
(56, 12, '2017-01-05 15:00:00', '2017-01-05 19:00:00', NULL, 1, '2017-01-05 15:08:43', '2017-01-05 15:08:55'),
(57, 12, '2017-01-05 13:15:00', '2017-01-05 14:00:00', NULL, 1, '2017-01-05 16:18:58', '2017-01-05 16:18:58'),
(58, 12, '2017-01-06 16:15:00', '2017-01-06 17:15:00', NULL, 1, '2017-01-05 16:48:52', '2017-01-05 16:48:52');

-- --------------------------------------------------------

--
-- Table structure for table `calendar_details`
--

CREATE TABLE `calendar_details` (
  `id` int(11) NOT NULL,
  `calendars_id` int(11) NOT NULL,
  `time` datetime NOT NULL,
  `check` int(11) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `calendar_details`
--

INSERT INTO `calendar_details` (`id`, `calendars_id`, `time`, `check`, `created`, `modified`) VALUES
(354, 55, '2017-01-05 19:15:00', 0, '2017-01-05 15:06:22', '2017-01-05 15:06:22'),
(355, 55, '2017-01-05 19:30:00', 0, '2017-01-05 15:06:22', '2017-01-05 15:06:22'),
(356, 55, '2017-01-05 19:45:00', 0, '2017-01-05 15:06:22', '2017-01-05 15:06:22'),
(375, 56, '2017-01-05 15:15:00', 0, '2017-01-05 15:08:55', '2017-01-05 15:08:55'),
(376, 56, '2017-01-05 15:30:00', 0, '2017-01-05 15:08:55', '2017-01-05 15:08:55'),
(377, 56, '2017-01-05 15:45:00', 0, '2017-01-05 15:08:55', '2017-01-05 15:08:55'),
(378, 56, '2017-01-05 16:00:00', 0, '2017-01-05 15:08:55', '2017-01-05 15:08:55'),
(379, 56, '2017-01-05 16:15:00', 0, '2017-01-05 15:08:55', '2017-01-05 15:08:55'),
(380, 56, '2017-01-05 16:30:00', 0, '2017-01-05 15:08:55', '2017-01-05 15:08:55'),
(381, 56, '2017-01-05 16:45:00', 0, '2017-01-05 15:08:55', '2017-01-05 15:08:55'),
(382, 56, '2017-01-05 17:00:00', 0, '2017-01-05 15:08:55', '2017-01-05 15:08:55'),
(383, 56, '2017-01-05 17:15:00', 0, '2017-01-05 15:08:55', '2017-01-05 15:08:55'),
(384, 56, '2017-01-05 17:30:00', 0, '2017-01-05 15:08:55', '2017-01-05 15:08:55'),
(385, 56, '2017-01-05 17:45:00', 0, '2017-01-05 15:08:55', '2017-01-05 15:08:55'),
(386, 56, '2017-01-05 18:00:00', 0, '2017-01-05 15:08:55', '2017-01-05 15:08:55'),
(387, 56, '2017-01-05 18:15:00', 0, '2017-01-05 15:08:55', '2017-01-05 15:08:55'),
(388, 56, '2017-01-05 18:30:00', 0, '2017-01-05 15:08:55', '2017-01-05 15:08:55'),
(389, 56, '2017-01-05 18:45:00', 0, '2017-01-05 15:08:55', '2017-01-05 15:08:55'),
(390, 57, '2017-01-05 13:30:00', 0, '2017-01-05 16:18:58', '2017-01-05 16:18:58'),
(391, 57, '2017-01-05 13:45:00', 0, '2017-01-05 16:18:58', '2017-01-05 16:18:58'),
(392, 58, '2017-01-06 16:30:00', 0, '2017-01-05 16:48:52', '2017-01-05 16:48:52'),
(393, 58, '2017-01-06 16:45:00', 0, '2017-01-05 16:48:52', '2017-01-05 16:48:52'),
(394, 58, '2017-01-06 17:00:00', 0, '2017-01-05 16:48:52', '2017-01-05 16:48:52');

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `symbol` varchar(10) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `symbol`, `status`, `created`, `modified`) VALUES
(1, 'Dola', '$', 1, '2016-12-14 15:03:12', '2016-12-14 15:06:27'),
(3, 'Viá»‡t Nam', 'VND', 1, '2016-12-15 08:00:03', '2016-12-15 08:00:03');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `status`, `created`, `modified`) VALUES
(1, 'DORAEMON', 1, '2016-12-12 17:21:16', '2016-12-12 17:22:33'),
(2, 'CULI', 1, '2016-12-12 17:22:45', '2016-12-12 17:22:50'),
(3, 'HOLON', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'BOD', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'AIMER', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'AR', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'PMG', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'IMBOUND', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'DUBULATOR', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 'KATEIKA', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `name`, `status`, `created`, `modified`) VALUES
(1, 'Director', 1, '2016-12-09 08:06:41', '2016-12-12 09:15:25'),
(2, 'Staff', 1, '2016-12-09 08:06:41', '2016-12-12 09:32:25'),
(7, 'Intership', 0, '2016-12-12 09:42:31', '2016-12-12 10:02:58'),
(8, 'Hieu 1', 0, '2016-12-12 09:54:47', '2016-12-12 10:02:43'),
(9, 'Intership', 0, '2016-12-12 10:05:01', '2016-12-14 03:22:49'),
(10, 'Intership 1', 1, '2016-12-19 10:00:16', '2016-12-19 10:00:38');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created`, `modified`) VALUES
(1, 'Admin', '2016-12-07 00:00:00', '2016-12-07 00:00:00'),
(2, 'User', '2016-12-07 00:00:00', '2016-12-07 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(60) NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` varchar(100) NOT NULL,
  `positions_id` int(11) NOT NULL,
  `roles_id` int(11) NOT NULL,
  `departments_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `positions_id`, `roles_id`, `departments_id`, `status`, `created`, `modified`) VALUES
(1, 'admin@gmail.com', 'admin', '832e569c33de9e8b4660f960c3af67383b885210', 1, 1, 1, 1, '2016-12-07 00:00:00', '2016-12-30 13:34:01'),
(12, 'hieunt@nal.vn', '', '832e569c33de9e8b4660f960c3af67383b885210', 0, 2, 1, 1, '2017-01-05 09:39:27', '2017-01-05 09:39:27'),
(17, 'chienmadondoc@nal.vn', '', '832e569c33de9e8b4660f960c3af67383b885210', 0, 2, 3, 1, '2017-01-05 13:56:26', '2017-01-05 13:56:26');

-- --------------------------------------------------------

--
-- Table structure for table `users_overtimes`
--

CREATE TABLE `users_overtimes` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `time_in` datetime NOT NULL,
  `time_out` datetime NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_overtimes`
--

INSERT INTO `users_overtimes` (`id`, `users_id`, `time_in`, `time_out`, `created`, `modified`) VALUES
(1, 3, '2016-12-30 16:15:00', '2016-12-30 18:15:00', '2016-12-22 16:32:08', '2016-12-22 16:32:08'),
(2, 2, '2016-12-30 17:30:00', '2016-12-30 19:30:00', '2016-12-22 16:37:20', '2016-12-22 16:37:20'),
(3, 5, '2016-12-31 16:30:00', '2016-12-31 19:30:00', '2016-12-22 16:40:48', '2016-12-22 16:40:48'),
(4, 2, '2016-12-31 17:30:00', '2016-12-31 21:30:00', '2016-12-30 14:32:20', '2016-12-30 14:32:20'),
(5, 3, '2016-12-14 18:30:00', '2016-12-14 22:30:00', '2016-12-30 15:21:10', '2016-12-30 15:21:10');

-- --------------------------------------------------------

--
-- Table structure for table `users_profiles`
--

CREATE TABLE `users_profiles` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `avata` varchar(255) DEFAULT NULL,
  `cv` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `gender` int(11) NOT NULL DEFAULT '1',
  `atm` varchar(20) DEFAULT NULL,
  `salary` int(11) DEFAULT NULL,
  `currencies_id` int(11) DEFAULT NULL,
  `description` text,
  `day_in_company` date NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_profiles`
--

INSERT INTO `users_profiles` (`id`, `users_id`, `fullname`, `phone_number`, `avata`, `cv`, `address`, `birthday`, `gender`, `atm`, `salary`, `currencies_id`, `description`, `day_in_company`, `created`, `modified`) VALUES
(2, 3, '', '1981945175', '1482139287-Hydrangeas.jpg', '1482121835-PD01233_NguyenTrongHieu_Assignment2.doc', '696 TÃ´n Äá»©c Tháº¯ng', NULL, 1, '', 1000, 1, '', '0000-00-00', '2016-12-14 09:35:35', '2016-12-19 16:21:27'),
(3, 4, 'Hieu Nguyen', '981945175', '1482121442-Jellyfish.jpg', '1482139265-TRÆ¯á»œNG CAO Äáº²NG THá»°C HÃ€NH FPT.docx', '696 TÃ´n Äá»©c Tháº¯ng', NULL, 1, '', 1000, 1, '', '0000-00-00', '2016-12-14 09:41:14', '2016-12-19 16:21:05'),
(4, 5, 'Hieu Nguyen', '981945175', NULL, '1482139302-NguyenTrongHieu_PHP_Developer.docx', '696 TÃ´n Äá»©c Tháº¯ng', '1995-04-15', 1, '123456780987654345', 1000000000, 1, '', '2016-11-22', '2016-12-14 09:44:23', '2016-12-19 16:21:42'),
(5, 6, 'Hieu Nguyen', '981945175', NULL, NULL, '696 TÃ´n Äá»©c Tháº¯ng', '1970-01-01', 1, '', 0, NULL, '', '0000-00-00', '2016-12-14 09:52:29', '2016-12-14 09:52:29'),
(6, 7, 'Hieu Nguyen', '981945175', NULL, NULL, '696 TÃ´n Äá»©c Tháº¯ng', '1970-01-01', 1, '', 0, 1, '', '0000-00-00', '2016-12-14 09:53:36', '2016-12-14 09:53:36');

-- --------------------------------------------------------

--
-- Table structure for table `users_salaries`
--

CREATE TABLE `users_salaries` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `salary` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `calendars`
--
ALTER TABLE `calendars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `calendar_details`
--
ALTER TABLE `calendar_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`,`email`);

--
-- Indexes for table `users_overtimes`
--
ALTER TABLE `users_overtimes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_profiles`
--
ALTER TABLE `users_profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_salaries`
--
ALTER TABLE `users_salaries`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `calendars`
--
ALTER TABLE `calendars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT for table `calendar_details`
--
ALTER TABLE `calendar_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=395;
--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `users_overtimes`
--
ALTER TABLE `users_overtimes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users_profiles`
--
ALTER TABLE `users_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `users_salaries`
--
ALTER TABLE `users_salaries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
