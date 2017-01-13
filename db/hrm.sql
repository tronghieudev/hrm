-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 13 Janvier 2017 à 03:44
-- Version du serveur :  10.1.13-MariaDB
-- Version de PHP :  5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `hrm`
--

-- --------------------------------------------------------

--
-- Structure de la table `calendars`
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
-- Contenu de la table `calendars`
--

INSERT INTO `calendars` (`id`, `users_id`, `time_in`, `time_out`, `time_cancel`, `status`, `created`, `modified`) VALUES
(55, 17, '2017-01-05 19:00:00', '2017-01-05 20:00:00', NULL, 1, '2017-01-05 15:06:22', '2017-01-05 15:06:22'),
(56, 12, '2017-01-05 15:00:00', '2017-01-05 19:00:00', NULL, 1, '2017-01-05 15:08:43', '2017-01-05 15:08:55'),
(57, 12, '2017-01-05 13:15:00', '2017-01-05 14:00:00', NULL, 1, '2017-01-05 16:18:58', '2017-01-05 16:18:58'),
(58, 12, '2017-01-06 16:15:00', '2017-01-06 17:15:00', NULL, 1, '2017-01-05 16:48:52', '2017-01-05 16:48:52');

-- --------------------------------------------------------

--
-- Structure de la table `calendar_details`
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
-- Contenu de la table `calendar_details`
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
-- Structure de la table `currencies`
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
-- Contenu de la table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `symbol`, `status`, `created`, `modified`) VALUES
(1, 'Dola', '$', 1, '2016-12-14 15:03:12', '2016-12-14 15:06:27'),
(3, 'Viá»‡t Nam', 'VND', 1, '2016-12-15 08:00:03', '2016-12-15 08:00:03');

-- --------------------------------------------------------

--
-- Structure de la table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `departments`
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
-- Structure de la table `positions`
--

CREATE TABLE `positions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `positions`
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
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created`, `modified`) VALUES
(1, 'Admin', '2016-12-07 00:00:00', '2016-12-07 00:00:00'),
(2, 'User', '2016-12-07 00:00:00', '2016-12-07 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(60) NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` varchar(100) NOT NULL,
  `positions_id` int(11) NOT NULL,
  `roles_id` int(11) NOT NULL,
  `departments_id` int(11) NOT NULL,
  `days_leave` int(11) NOT NULL DEFAULT '12',
  `money_efficiency` int(11) DEFAULT NULL,
  `money_complete` int(11) DEFAULT NULL,
  `money_house` int(11) DEFAULT NULL,
  `money_gasoline` int(11) DEFAULT NULL,
  `money_costume` int(11) DEFAULT NULL,
  `money_phone` int(11) DEFAULT NULL,
  `money_lunch` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `positions_id`, `roles_id`, `departments_id`, `days_leave`, `money_efficiency`, `money_complete`, `money_house`, `money_gasoline`, `money_costume`, `money_phone`, `money_lunch`, `status`, `created`, `modified`) VALUES
(1, 'admin@gmail.com', 'admin', '832e569c33de9e8b4660f960c3af67383b885210', 1, 1, 1, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2016-12-07 00:00:00', '2016-12-30 13:34:01'),
(18, 'chienmadondoc@gmail.com', 'chienmadondoc', '3c46a4482ef09289251adb66f8e7e8ea71f4ac1a', 1, 2, 1, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-01-09 10:38:35', '2017-01-12 10:33:25'),
(25, 'hieunt@nal.vn', 'hieunt', '3c46a4482ef09289251adb66f8e7e8ea71f4ac1a', 1, 2, 5, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-01-11 17:22:58', '2017-01-11 17:22:58'),
(26, 'tronghieudev@nal.vn', 'tronghieudev', '3c46a4482ef09289251adb66f8e7e8ea71f4ac1a', 1, 2, 1, 12, 500000, 500000, 500000, 500000, 500000, 500000, 500000, 1, '2017-01-12 15:25:12', '2017-01-12 15:25:12'),
(27, 'chienmadondo123123123c@gmail.com', 'chienmadondo123123123c', '3c46a4482ef09289251adb66f8e7e8ea71f4ac1a', 1, 2, 1, 12, 1000000, 1000000, 1000000, 1000000, 1000000, 1000000, 1000000, 1, '2017-01-12 16:05:27', '2017-01-12 16:05:27');

-- --------------------------------------------------------

--
-- Structure de la table `users_days_leaves`
--

CREATE TABLE `users_days_leaves` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `day_start` datetime NOT NULL,
  `days` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users_days_leaves`
--

INSERT INTO `users_days_leaves` (`id`, `users_id`, `day_start`, `days`, `status`, `created`, `modified`) VALUES
(7, 18, '2017-01-30 00:00:00', 1, 0, '2017-01-12 10:33:25', '2017-01-12 10:33:25');

-- --------------------------------------------------------

--
-- Structure de la table `users_days_offs`
--

CREATE TABLE `users_days_offs` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `day_start` date NOT NULL,
  `days` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users_days_offs`
--

INSERT INTO `users_days_offs` (`id`, `users_id`, `day_start`, `days`, `status`, `created`, `modified`) VALUES
(13, 18, '2017-01-14', 2, 0, '2017-01-10 13:14:02', '2017-01-10 13:14:02'),
(14, 18, '2017-01-11', 2, 1, '2017-01-10 13:35:55', '2017-01-12 14:30:54'),
(15, 18, '2017-01-30', 1, 1, '2017-01-12 10:30:48', '2017-01-12 14:30:19'),
(16, 18, '2017-01-22', 1, 0, '2017-01-12 15:26:24', '2017-01-12 15:26:24');

-- --------------------------------------------------------

--
-- Structure de la table `users_overtimes`
--

CREATE TABLE `users_overtimes` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `time_in` datetime NOT NULL,
  `time_out` datetime NOT NULL,
  `type` int(11) NOT NULL DEFAULT '1',
  `status` int(1) DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users_overtimes`
--

INSERT INTO `users_overtimes` (`id`, `users_id`, `time_in`, `time_out`, `type`, `status`, `created`, `modified`) VALUES
(1, 3, '2016-12-30 16:15:00', '2016-12-30 18:15:00', 1, 0, '2016-12-22 16:32:08', '2016-12-22 16:32:08'),
(2, 2, '2016-12-30 17:30:00', '2016-12-30 19:30:00', 1, 0, '2016-12-22 16:37:20', '2016-12-22 16:37:20'),
(3, 18, '2017-01-06 16:30:00', '2017-01-06 19:30:00', 1, 0, '2016-12-22 16:40:48', '2016-12-22 16:40:48'),
(4, 18, '2017-01-10 17:30:00', '2017-01-10 21:30:00', 3, 0, '2016-12-30 14:32:20', '2016-12-30 14:32:20'),
(5, 18, '2017-01-04 18:30:00', '2017-01-04 22:30:00', 2, 0, '2016-12-30 15:21:10', '2016-12-30 15:21:10'),
(6, 18, '2017-01-06 16:45:00', '2017-01-06 17:00:00', 1, 0, '2017-01-09 17:01:09', '2017-01-09 17:01:09'),
(7, 18, '2017-01-28 19:30:00', '2017-01-28 21:30:00', 1, 1, '2017-01-12 10:45:33', '2017-01-12 14:20:24'),
(8, 18, '2017-01-14 19:30:00', '2017-01-14 22:30:00', 3, 0, '2017-01-12 10:54:00', '2017-01-12 10:54:00'),
(9, 18, '2017-01-07 20:45:00', '2017-01-07 22:45:00', 3, 0, '2017-01-12 10:56:58', '2017-01-12 10:56:58');

-- --------------------------------------------------------

--
-- Structure de la table `users_profiles`
--

CREATE TABLE `users_profiles` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `avata` varchar(255) DEFAULT NULL,
  `cv` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `gender` int(11) NOT NULL DEFAULT '1',
  `atm` varchar(20) DEFAULT NULL,
  `salary` int(11) DEFAULT NULL,
  `currencies_id` int(11) DEFAULT NULL,
  `description` text,
  `day_in_company` date DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users_profiles`
--

INSERT INTO `users_profiles` (`id`, `users_id`, `fullname`, `phone_number`, `avata`, `cv`, `address`, `birthday`, `gender`, `atm`, `salary`, `currencies_id`, `description`, `day_in_company`, `created`, `modified`) VALUES
(7, 18, 'Hieu Nguyen', '981945175', NULL, NULL, '696 TÃ´n Äá»©c Tháº¯ng', '1970-01-01', 1, '', NULL, NULL, '', '0000-00-00', '2017-01-09 10:38:35', '2017-01-09 10:38:35'),
(10, 25, 'Hieu Nguyen', '0981945175', NULL, NULL, '696 TÃ´n Äá»©c Tháº¯ng', '1995-04-15', 1, '', NULL, NULL, 'Hot boy', NULL, '2017-01-11 17:22:58', '2017-01-11 17:22:58'),
(11, 26, 'Nguyen Trong Hieu', '0981945175', NULL, NULL, '696 TÃ´n Äá»©c Tháº¯ng', '1995-01-01', 1, '', 8000000, NULL, '', NULL, '2017-01-12 15:25:12', '2017-01-12 15:25:12'),
(12, 27, 'Hieu Nguyen 123', '981945175', NULL, NULL, '696 TÃ´n Äá»©c Tháº¯ng', '1983-01-01', 1, '', 10000000, NULL, '', NULL, '2017-01-12 16:05:27', '2017-01-12 16:05:27');

-- --------------------------------------------------------

--
-- Structure de la table `users_salarys`
--

CREATE TABLE `users_salarys` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `salary` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users_salarys`
--

INSERT INTO `users_salarys` (`id`, `users_id`, `salary`, `status`, `created`, `modified`) VALUES
(20, 18, 12000000, 1, '2017-01-11 17:16:25', '2017-01-11 17:16:25'),
(22, 25, 12000000, 0, '2017-01-12 09:07:28', '2017-01-12 09:07:28'),
(23, 25, 8000000, 0, '2017-01-12 09:07:47', '2017-01-12 09:07:47'),
(24, 25, 8000000, 0, '2017-01-12 09:11:14', '2017-01-12 09:11:14'),
(25, 25, 15000000, 1, '2017-01-12 09:11:37', '2017-01-12 09:11:37'),
(26, 26, 8000000, 1, '2017-01-12 15:25:12', '2017-01-12 15:25:12'),
(27, 27, 10000000, 1, '2017-01-12 16:05:27', '2017-01-12 16:05:27');

-- --------------------------------------------------------

--
-- Structure de la table `users_salarys_social_insurances`
--

CREATE TABLE `users_salarys_social_insurances` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `salary` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users_salarys_social_insurances`
--

INSERT INTO `users_salarys_social_insurances` (`id`, `users_id`, `salary`, `status`, `created`, `modified`) VALUES
(1, 18, 5000000, 1, '2017-01-11 00:00:00', '2017-01-11 00:00:00'),
(2, 27, 3000000, 1, '2017-01-12 16:05:27', '2017-01-12 16:05:27');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `calendars`
--
ALTER TABLE `calendars`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `calendar_details`
--
ALTER TABLE `calendar_details`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`,`email`);

--
-- Index pour la table `users_days_leaves`
--
ALTER TABLE `users_days_leaves`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users_days_offs`
--
ALTER TABLE `users_days_offs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users_overtimes`
--
ALTER TABLE `users_overtimes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users_profiles`
--
ALTER TABLE `users_profiles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users_salarys`
--
ALTER TABLE `users_salarys`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users_salarys_social_insurances`
--
ALTER TABLE `users_salarys_social_insurances`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `calendars`
--
ALTER TABLE `calendars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT pour la table `calendar_details`
--
ALTER TABLE `calendar_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=395;
--
-- AUTO_INCREMENT pour la table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT pour la table `users_days_leaves`
--
ALTER TABLE `users_days_leaves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `users_days_offs`
--
ALTER TABLE `users_days_offs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT pour la table `users_overtimes`
--
ALTER TABLE `users_overtimes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `users_profiles`
--
ALTER TABLE `users_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `users_salarys`
--
ALTER TABLE `users_salarys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT pour la table `users_salarys_social_insurances`
--
ALTER TABLE `users_salarys_social_insurances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
