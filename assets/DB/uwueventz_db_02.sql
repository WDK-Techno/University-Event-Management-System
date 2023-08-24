-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 19, 2023 at 07:08 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uwueventz_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `club`
--

CREATE TABLE `club` (
  `user_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `contact_no` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `club`
--

INSERT INTO `club` (`user_id`, `name`, `contact_no`) VALUES
(11, 'IEEE UWU', '0774568793'),
(12, 'Rotaract Club', '0771235462');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `event_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `event_date` datetime NOT NULL,
  `project_id` int(11) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'new'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `project_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `club_id` int(11) NOT NULL,
  `project_chair_id` int(11) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`project_id`, `name`, `club_id`, `project_chair_id`, `status`) VALUES
(1, 'JamborIEEE23', 11, 4, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `project_team`
--

CREATE TABLE `project_team` (
  `category_id` int(11) NOT NULL,
  `ug_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `team_category`
--

CREATE TABLE `team_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(30) NOT NULL,
  `project_id` int(11) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `team_category`
--

INSERT INTO `team_category` (`category_id`, `category_name`, `project_id`, `status`) VALUES
(1, 'Program Team', 1, 'active'),
(2, 'Secretary Team', 1, 'active'),
(3, 'Logistic Team', 1, 'active'),
(4, 'Finance Team', 1, 'active'),
(5, 'test Team 1', 1, 'delete'),
(6, 'Test Team 5', 1, 'delete');

-- --------------------------------------------------------

--
-- Table structure for table `undergraduate`
--

CREATE TABLE `undergraduate` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `contact_no` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `undergraduate`
--

INSERT INTO `undergraduate` (`user_id`, `first_name`, `last_name`, `contact_no`) VALUES
(4, 'Kavindra', 'Weerasinghe', '0771235462'),
(5, 'Ishara', 'Suvini', '0774568793'),
(6, 'Thilini', 'Priyangika', '0714568792');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `role` varchar(5) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `password`, `role`, `status`) VALUES
(4, 'wdk@gmail.com', '$2y$10$B6upj90IgL8nrCWee7qeX.xB7zRDVkxZgJjF8PaJmcgM7ZH./9jmG', 'ug', 'active'),
(5, 'suvi@gmail.com', '$2y$10$EyFlRe7LqQ/1HQQIBukH7.6sGKAid2b5yztMpo1wVp7ijw2HncuTa', 'ug', 'active'),
(6, 'thilini@gmail.com', '$2y$10$eSa/3JDL43juhVipg2GP7OmeprZhkj1ZvaUWDHpvLe6y1wzjKLd3y', 'ug', 'active'),
(11, 'ieee@gmail.com', '$2y$10$p.AFtXCnxtHqGHdh/YydEejiJg31PnDIQgmmB7e8SnhXKsYdHM.Nm', 'club', 'new'),
(12, 'rotaract@gmail.com', '$2y$10$DQlhqaLHY8MomVwohOzOsexmaqzvTPg9ZIUGd/1In4NZp1tptWPLW', 'club', 'new');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `club`
--
ALTER TABLE `club`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`project_id`),
  ADD KEY `club_id` (`club_id`),
  ADD KEY `project_chair_id` (`project_chair_id`);

--
-- Indexes for table `project_team`
--
ALTER TABLE `project_team`
  ADD PRIMARY KEY (`category_id`,`ug_id`),
  ADD KEY `ug_id` (`ug_id`);

--
-- Indexes for table `team_category`
--
ALTER TABLE `team_category`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `undergraduate`
--
ALTER TABLE `undergraduate`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `team_category`
--
ALTER TABLE `team_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `club`
--
ALTER TABLE `club`
  ADD CONSTRAINT `club_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`);

--
-- Constraints for table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `project_ibfk_1` FOREIGN KEY (`club_id`) REFERENCES `club` (`user_id`),
  ADD CONSTRAINT `project_ibfk_2` FOREIGN KEY (`project_chair_id`) REFERENCES `undergraduate` (`user_id`);

--
-- Constraints for table `project_team`
--
ALTER TABLE `project_team`
  ADD CONSTRAINT `project_team_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `team_category` (`category_id`),
  ADD CONSTRAINT `project_team_ibfk_2` FOREIGN KEY (`ug_id`) REFERENCES `undergraduate` (`user_id`);

--
-- Constraints for table `team_category`
--
ALTER TABLE `team_category`
  ADD CONSTRAINT `team_category_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`);

--
-- Constraints for table `undergraduate`
--
ALTER TABLE `undergraduate`
  ADD CONSTRAINT `undergraduate_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
