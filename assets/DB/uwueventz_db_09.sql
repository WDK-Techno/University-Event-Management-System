-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 30, 2023 at 07:10 PM
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
  `contact_no` varchar(30) NOT NULL,
  `description` text DEFAULT NULL,
  `register_date` date NOT NULL DEFAULT current_timestamp(),
  `profile_image` varchar(50) NOT NULL DEFAULT 'club_profile_default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `club`
--

INSERT INTO `club` (`user_id`, `name`, `contact_no`, `description`, `register_date`, `profile_image`) VALUES
(11, 'IEEE UWU', '0774568793', '', '2023-08-21', '64f57db2323d91.14154601.png'),
(12, 'Rotaract Club', '0771235462', 'Sample Text', '2023-08-21', 'club_profile_default.jpg'),
(15, 'Leo', '0774568793', NULL, '2023-09-01', 'club_profile_default.jpg'),
(16, 'Test Club', '0774568793', NULL, '2023-09-04', 'club_profile_default.jpg'),
(18, 'Aqua Club', '0771235462', '', '2023-09-04', '64f566b37e50a6.27696346.png'),
(19, 'ABC Club', '0774568793', NULL, '2023-09-04', 'club_profile_default.jpg'),
(20, 'Test 2 Club', '0774568793', NULL, '2023-09-04', 'club_profile_default.jpg'),
(21, 'Art Club', '0774568793', NULL, '2023-09-04', 'club_profile_default.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `event_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `project_id` int(11) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'new'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`event_id`, `name`, `description`, `start_date`, `end_date`, `project_id`, `status`) VALUES
(2, 'Holi', 'This is Fund Raising program', '2023-08-27 10:00:00', '2023-08-27 11:59:00', 1, 'active'),
(4, 'ENM Thorpy', 'ENM trophy - By ENM Degree', '2023-09-06 10:47:00', '2023-09-06 13:47:00', 8, 'active'),
(7, 'Test Event', 'sfdaadfsf', '2023-10-13 08:04:00', '2023-10-13 19:46:00', 1, 'active'),
(8, 'Test2', 'sfadfsdafa', '2023-10-13 07:28:00', '2023-10-13 10:50:00', 1, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `main_task`
--

CREATE TABLE `main_task` (
  `main_task_id` int(11) NOT NULL,
  `main_task_name` varchar(50) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  `ordinal` int(11) DEFAULT NULL,
  `ordinal_priority` datetime DEFAULT NULL,
  `complete` int(11) NOT NULL DEFAULT 0,
  `parent_id` int(11) DEFAULT NULL,
  `milestone` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `main_task`
--

INSERT INTO `main_task` (`main_task_id`, `main_task_name`, `start_date`, `end_date`, `project_id`, `ordinal`, `ordinal_priority`, `complete`, `parent_id`, `milestone`) VALUES
(6, 'Initial Task', '2023-10-27', '2023-10-30', 1, 1, '2023-10-30 18:04:12', 0, NULL, 0),
(7, 'PR Plan Create', '2023-10-27', '2023-11-02', 1, 2, '2023-10-30 18:05:07', 0, NULL, 0),
(9, 'Sponsorship Hunting', '2023-11-03', '2023-11-11', 1, 4, '2023-10-30 18:06:26', 0, NULL, 0),
(10, 'Program Plan Create', '2023-10-28', '2023-11-03', 1, 5, '2023-10-30 18:07:22', 0, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `project_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `club_id` int(11) NOT NULL,
  `project_chair_id` int(11) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active',
  `start_date` date NOT NULL DEFAULT current_timestamp(),
  `end_date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `profile_image` varchar(50) NOT NULL DEFAULT 'project_profile_default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`project_id`, `name`, `club_id`, `project_chair_id`, `status`, `start_date`, `end_date`, `description`, `profile_image`) VALUES
(1, 'JamborIEEE23', 11, 4, 'active', '2023-10-27', '2023-11-28', 'JamborIEEE is a project intiate by IEEE Sri Lanka Section. ', '64e830b42afda8.67288644.png'),
(5, 'INSL 2023', 11, 5, 'active', '2023-08-25', NULL, NULL, '64e87d4ab4ca82.40177324.png'),
(6, 'Open Day 2023', 11, 6, 'active', '2023-08-25', NULL, '', 'project_profile_default.jpg'),
(7, 'IMPETUS 23', 11, 5, 'deactive', '2023-09-03', NULL, NULL, 'project_profile_default.jpg'),
(8, 'Test Project', 18, 17, 'active', '2023-09-03', NULL, '', '64f5676b3b4705.39751827.png'),
(10, 'Nanasa 2024', 11, 4, 'delete', '2023-09-05', NULL, 'sample text', '64f57e06827334.58295198.png'),
(11, 'Nanasa 2023', 11, 4, 'delete', '2023-09-04', NULL, NULL, 'project_profile_default.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `project_team`
--

CREATE TABLE `project_team` (
  `category_id` int(11) NOT NULL,
  `ug_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project_team`
--

INSERT INTO `project_team` (`category_id`, `ug_id`) VALUES
(1, 4),
(1, 6),
(3, 6),
(9, 5),
(12, 4),
(13, 4),
(14, 17),
(15, 5),
(16, 4),
(16, 5),
(19, 5);

-- --------------------------------------------------------

--
-- Table structure for table `pr_task`
--

CREATE TABLE `pr_task` (
  `pr_id` int(11) NOT NULL,
  `published` int(11) NOT NULL DEFAULT 0,
  `publish_date` datetime DEFAULT NULL,
  `topic` varchar(30) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `designer_id` int(11) DEFAULT NULL,
  `design_complete` int(11) NOT NULL DEFAULT 0,
  `caption_writer_id` int(11) DEFAULT NULL,
  `caption_complete` int(11) NOT NULL DEFAULT 0,
  `design_deadline` datetime DEFAULT NULL,
  `project_chair_verify` int(11) NOT NULL DEFAULT 0,
  `project_id` int(11) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `public_flyer`
--

CREATE TABLE `public_flyer` (
  `flyer_id` int(11) NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `caption` text DEFAULT NULL,
  `link` text DEFAULT NULL,
  `flyer_image` varchar(50) DEFAULT NULL,
  `club_id` int(11) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active',
  `flyer_topic` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sub_task`
--

CREATE TABLE `sub_task` (
  `sub_task_id` int(11) NOT NULL,
  `sub_task_name` varchar(50) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `deadline` datetime DEFAULT NULL,
  `asign_member_id` int(11) DEFAULT NULL,
  `task_complete` int(11) NOT NULL DEFAULT 0,
  `main_task_id` int(11) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active'
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
(9, 'Program Team', 6, 'active'),
(11, 'Secretary Team', 6, 'active'),
(12, 'Program Team', 8, 'active'),
(13, 'Secretary Team1', 8, 'active'),
(14, 'Logistic Team', 8, 'active'),
(15, 'Program Team', 10, 'active'),
(16, 'Secretary Team1', 10, 'active'),
(19, 'Publicity Team', 1, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `undergraduate`
--

CREATE TABLE `undergraduate` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `contact_no` varchar(13) NOT NULL,
  `profile_image` varchar(50) NOT NULL DEFAULT 'ug_profile_default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `undergraduate`
--

INSERT INTO `undergraduate` (`user_id`, `first_name`, `last_name`, `contact_no`, `profile_image`) VALUES
(4, 'Kavindra', 'Weerasingh', '0771235462', '64f57fd9121790.90818807.jpg'),
(5, 'Ishara', 'Suvini', '0774568793', 'ug_profile_default.jpg'),
(6, 'Thilini', 'Priyangika', '0714568792', 'ug_profile_default.jpg'),
(17, 'Kavinda', 'Helitha', '0771235462', '64f5656d449877.81367753.jpg');

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
(5, 'suvi@gmail.com', '$2y$10$ygwIkp/oUl8SqIi8rCmQGekH1MxFyxLHHB3vMHid88F9fzqF7AR0e', 'ug', 'active'),
(6, 'thilini@gmail.com', '$2y$10$eSa/3JDL43juhVipg2GP7OmeprZhkj1ZvaUWDHpvLe6y1wzjKLd3y', 'ug', 'active'),
(11, 'ieee@gmail.com', '$2y$10$p.AFtXCnxtHqGHdh/YydEejiJg31PnDIQgmmB7e8SnhXKsYdHM.Nm', 'club', 'active'),
(12, 'rotaract@gmail.com', '$2y$10$DQlhqaLHY8MomVwohOzOsexmaqzvTPg9ZIUGd/1In4NZp1tptWPLW', 'club', 'active'),
(14, 'admin@gmail.com', '$2y$10$RLEVRnMq2yLZkU6mYL4U1OfQMjM8tv0dyfA3ddMMQ0P5ZOccZlFVq', 'admin', 'active'),
(15, 'leo@gmail.com', '$2y$10$gK5WyiCZjDRL.cDyoNWjZefXGOHb0OR3AU5f7mvuVyN80dmsAdXf.', 'club', 'active'),
(16, 'testclub1@gmail.com', '$2y$10$jsswh6/Uc8RfGvW/tIu1DORASdqQQf6LQjmtzYt6a2mwfztgWJaRu', 'club', 'active'),
(17, 'heli@gmail.com', '$2y$10$gi6mfaBJf.Y.3fVlaOFHnuf06PxPYHeiE/niPx8AdyqlcSvJgc6Wi', 'ug', 'delete'),
(18, 'aqua@gmail.com', '$2y$10$tJdlExUkWEvA2Ss6bA.tMO5ZXPc/Qjc3fc3CWRl3nBfGMPZdNFgBa', 'club', 'active'),
(19, 'abc@gmail.com', '$2y$10$0/LmS/JziiRN7wPWjAdo7u1vZt7o1y4ZXG2V/vduOOfPTMW/1Wymu', 'club', 'delete'),
(20, 'test2@gmail.com', '$2y$10$mxrL6kLM89wrDeJloon1Uu3bpJq7oBxObx7YYkDVgld63Npnp64BC', 'club', 'delete'),
(21, 'art@gmail.com', '$2y$10$Cv8LHydf56UyOyRgIDa1ke1V34idSPUgHtZa2uVO1oIZOXUlspV.2', 'club', 'delete');

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
-- Indexes for table `main_task`
--
ALTER TABLE `main_task`
  ADD PRIMARY KEY (`main_task_id`),
  ADD KEY `main_task_ibfk_1` (`project_id`);

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
-- Indexes for table `pr_task`
--
ALTER TABLE `pr_task`
  ADD PRIMARY KEY (`pr_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `designer_id` (`designer_id`),
  ADD KEY `caption_writer_id` (`caption_writer_id`);

--
-- Indexes for table `public_flyer`
--
ALTER TABLE `public_flyer`
  ADD PRIMARY KEY (`flyer_id`),
  ADD KEY `club_id` (`club_id`);

--
-- Indexes for table `sub_task`
--
ALTER TABLE `sub_task`
  ADD PRIMARY KEY (`sub_task_id`),
  ADD KEY `sub_task_ibfk_1` (`asign_member_id`),
  ADD KEY `sub_task_ibfk_2` (`main_task_id`);

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
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `main_task`
--
ALTER TABLE `main_task`
  MODIFY `main_task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pr_task`
--
ALTER TABLE `pr_task`
  MODIFY `pr_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `public_flyer`
--
ALTER TABLE `public_flyer`
  MODIFY `flyer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_task`
--
ALTER TABLE `sub_task`
  MODIFY `sub_task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `team_category`
--
ALTER TABLE `team_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

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
-- Constraints for table `main_task`
--
ALTER TABLE `main_task`
  ADD CONSTRAINT `main_task_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `project_team_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `team_category` (`category_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_team_ibfk_2` FOREIGN KEY (`ug_id`) REFERENCES `undergraduate` (`user_id`);

--
-- Constraints for table `pr_task`
--
ALTER TABLE `pr_task`
  ADD CONSTRAINT `pr_task_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`),
  ADD CONSTRAINT `pr_task_ibfk_2` FOREIGN KEY (`designer_id`) REFERENCES `undergraduate` (`user_id`),
  ADD CONSTRAINT `pr_task_ibfk_3` FOREIGN KEY (`caption_writer_id`) REFERENCES `undergraduate` (`user_id`);

--
-- Constraints for table `public_flyer`
--
ALTER TABLE `public_flyer`
  ADD CONSTRAINT `public_flyer_ibfk_1` FOREIGN KEY (`club_id`) REFERENCES `club` (`user_id`);

--
-- Constraints for table `sub_task`
--
ALTER TABLE `sub_task`
  ADD CONSTRAINT `sub_task_ibfk_1` FOREIGN KEY (`asign_member_id`) REFERENCES `undergraduate` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sub_task_ibfk_2` FOREIGN KEY (`main_task_id`) REFERENCES `main_task` (`main_task_id`) ON DELETE CASCADE;

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
