-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 05, 2020 at 02:29 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wheels`
--

-- --------------------------------------------------------

--
-- Table structure for table `archive`
--

CREATE TABLE `archive` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `generated_by` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bets`
--

CREATE TABLE `bets` (
  `id` int(11) NOT NULL,
  `cid` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `wheel_type` int(11) NOT NULL,
  `wheel_number` varchar(2) NOT NULL,
  `wheel_spot` int(11) NOT NULL,
  `choice` varchar(255) NOT NULL,
  `paid` float(11,2) NOT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT '0',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `credit`
--

CREATE TABLE `credit` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `amount` float(11,2) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `agent_id` int(11) DEFAULT '0',
  `count_limit` int(11) DEFAULT '10',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `numbers`
--

CREATE TABLE `numbers` (
  `id` int(11) NOT NULL,
  `wheel` varchar(2) NOT NULL,
  `number` int(11) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `numbers`
--

INSERT INTO `numbers` (`id`, `wheel`, `number`, `updated_at`, `created_at`) VALUES
(1, 'x1', NULL, '2020-08-02 09:56:55', '2020-08-02 09:56:55'),
(2, 'x2', NULL, '2020-08-02 09:56:55', '2020-08-02 09:56:55'),
(3, 'x3', NULL, '2020-08-02 09:56:55', '2020-08-02 09:56:55'),
(4, 'x4', NULL, '2020-08-02 09:56:55', '2020-08-02 09:56:55'),
(5, 'x5', NULL, '2020-08-02 09:56:55', '2020-08-02 09:56:55'),
(6, 'x6', NULL, '2020-08-02 09:56:55', '2020-08-02 09:56:55'),
(7, 'x7', NULL, '2020-08-02 09:56:55', '2020-08-02 09:56:55');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `sitename` varchar(255) NOT NULL DEFAULT 'MTL Wheels',
  `text` varchar(255) DEFAULT NULL,
  `mode` varchar(255) NOT NULL DEFAULT 'play_mode',
  `status` varchar(11) NOT NULL DEFAULT 'online',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `sitename`, `text`, `mode`, `status`, `updated_at`, `created_at`) VALUES
(1, 'MTL Wheels', '1 in 10 chances of winning!', 'play', 'online', '2020-07-29 02:30:12', '2020-07-29 02:30:12');

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `odds` varchar(11) NOT NULL,
  `prize` float(11,2) NOT NULL,
  `amount` float(11,2) NOT NULL,
  `allowed` tinyint(1) NOT NULL DEFAULT '0',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`id`, `type`, `name`, `link`, `odds`, `prize`, `amount`, `allowed`, `updated_at`, `created_at`) VALUES
(1, 1, '40 Draw', 'microdraw.php', '8:1', 40.00, 7.50, 1, '2020-08-02 09:51:46', '2020-08-02 09:51:46'),
(2, 2, '80 Draw', 'highstakes.php', '8:1', 80.00, 10.00, 1, '2020-08-02 09:51:46', '2020-08-02 09:51:46'),
(3, 3, '800 Draw', 'microdraws.php', '8:1', 800.00, 100.00, 1, '2020-08-02 09:51:46', '2020-08-02 09:51:46'),
(4, 4, 'Draw 4 (N/A)', 'page04.php', '8:1', 0.00, 0.00, 0, '2020-08-04 09:58:03', '2020-08-04 09:58:03'),
(5, 5, 'Draw 5 (N/A)', 'page05.php', '8:1', 0.00, 0.00, 0, '2020-08-04 09:58:26', '2020-08-04 09:58:26'),
(6, 6, 'Draw 6 (N/A)', 'page06.php', '8:1', 0.00, 0.00, 0, '2020-08-04 09:58:39', '2020-08-04 09:58:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `balance` float(11,2) NOT NULL DEFAULT '0.00',
  `credit` float(11,2) NOT NULL DEFAULT '1000.00',
  `user_type` int(1) DEFAULT '3',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `fullname`, `username`, `password`, `balance`, `credit`, `user_type`, `updated_at`, `created_at`) VALUES
(1, 'admin@mtl.com', 'Administrator', 'admin', '$argon2id$v=19$m=1024,t=2,p=2$bUV6OXV2QUhMVDI2NWNQYg$hsq+GVlwk9ZYCJr0YM7iwJj009DgtBsBFZsbvzU+rlY', 0.00, 1000.00, 1, '2020-08-04 14:09:44', '2020-08-04 14:09:44');

-- --------------------------------------------------------

--
-- Table structure for table `wheels`
--

CREATE TABLE `wheels` (
  `id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `wheel_number` varchar(3) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wheels`
--

INSERT INTO `wheels` (`id`, `type_id`, `wheel_number`, `updated_at`, `created_at`) VALUES
(1, 1, 'A1', '2020-08-05 04:00:38', '2020-08-05 04:00:38'),
(2, 1, 'A2', '2020-08-05 04:00:38', '2020-08-05 04:00:38'),
(3, 1, 'A3', '2020-08-05 04:00:38', '2020-08-05 04:00:38'),
(4, 1, 'A4', '2020-08-05 04:00:39', '2020-08-05 04:00:39'),
(5, 1, 'A5', '2020-08-05 04:00:39', '2020-08-05 04:00:39'),
(6, 1, 'A6', '2020-08-05 04:00:39', '2020-08-05 04:00:39'),
(7, 1, 'A7', '2020-08-05 04:00:39', '2020-08-05 04:00:39'),
(8, 2, 'A1', '2020-08-05 04:00:39', '2020-08-05 04:00:39'),
(9, 2, 'A2', '2020-08-05 04:00:39', '2020-08-05 04:00:39'),
(10, 2, 'A3', '2020-08-05 04:00:39', '2020-08-05 04:00:39'),
(11, 2, 'A4', '2020-08-05 04:00:39', '2020-08-05 04:00:39'),
(12, 2, 'A5', '2020-08-05 04:00:39', '2020-08-05 04:00:39'),
(13, 2, 'A6', '2020-08-05 04:00:39', '2020-08-05 04:00:39'),
(14, 2, 'A7', '2020-08-05 04:00:39', '2020-08-05 04:00:39'),
(15, 3, 'A1', '2020-08-05 04:00:39', '2020-08-05 04:00:39'),
(16, 3, 'A2', '2020-08-05 04:00:39', '2020-08-05 04:00:39'),
(17, 3, 'A3', '2020-08-05 04:00:39', '2020-08-05 04:00:39'),
(18, 3, 'A4', '2020-08-05 04:00:40', '2020-08-05 04:00:40'),
(19, 3, 'A5', '2020-08-05 04:00:40', '2020-08-05 04:00:40'),
(20, 3, 'A6', '2020-08-05 04:00:40', '2020-08-05 04:00:40'),
(21, 3, 'A7', '2020-08-05 04:00:40', '2020-08-05 04:00:40');

-- --------------------------------------------------------

--
-- Table structure for table `winners`
--

CREATE TABLE `winners` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cid` varchar(11) NOT NULL,
  `wheel_type` int(11) NOT NULL,
  `wheel_number` varchar(2) NOT NULL,
  `wheel_spot` int(11) NOT NULL,
  `prize` float(11,2) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `archive`
--
ALTER TABLE `archive`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `filename` (`filename`);

--
-- Indexes for table `bets`
--
ALTER TABLE `bets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `credit`
--
ALTER TABLE `credit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `agent_id` (`agent_id`,`name`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `numbers`
--
ALTER TABLE `numbers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wheel` (`wheel`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `wheels`
--
ALTER TABLE `wheels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `winners`
--
ALTER TABLE `winners`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `archive`
--
ALTER TABLE `archive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bets`
--
ALTER TABLE `bets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `credit`
--
ALTER TABLE `credit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `numbers`
--
ALTER TABLE `numbers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wheels`
--
ALTER TABLE `wheels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `winners`
--
ALTER TABLE `winners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
