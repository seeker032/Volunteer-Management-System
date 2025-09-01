-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2023 at 03:30 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `manage_volunteers`
--
CREATE DATABASE IF NOT EXISTS `manage_volunteers` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `manage_volunteers`;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `log_id` int(11) NOT NULL,
  `log_date` timestamp NULL DEFAULT current_timestamp(),
  `ip_address` varchar(255) DEFAULT NULL,
  `event_type` varchar(255) DEFAULT NULL,
  `event_details` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- RELATIONSHIPS FOR TABLE `log`:
--

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`log_id`, `log_date`, `ip_address`, `event_type`, `event_details`) VALUES
(3, '2023-09-14 13:53:58', '::1', 'Failed Login (Volunteer)', 'hdroxas@gmail.com failed to log in'),
(4, '2023-09-14 13:54:04', '::1', 'Login (Volunteer)', 'hdroxas@gmail.com logged in'),
(6, '2023-09-14 14:04:21', '::1', 'Time Slot added', 'hdroxas@gmail.com added Day 2, Afternoon'),
(7, '2023-09-14 14:04:29', '::1', 'Time Slot added', 'hdroxas@gmail.com added Day 2, Night'),
(8, '2023-09-14 14:04:44', '::1', 'Time Slot removed', 'hdroxas@gmail.com removed Day 2, Afternoon'),
(9, '2023-09-14 14:04:53', '::1', 'Time Slot removed', 'hdroxas@gmail.com removed Day 2, Night'),
(10, '2023-09-14 14:08:23', '::1', 'Registration (Volunteer)', '569171588-9@qq.com registered'),
(11, '2023-09-14 14:08:44', '::1', 'Login (Volunteer)', '569171588-9@qq.com logged in'),
(12, '2023-09-14 14:08:52', '::1', 'Time Slot added', '569171588-9@qq.com added Day 1, Morning'),
(13, '2023-09-14 14:09:27', '::1', 'Failed Login (Organiser)', 'organiser1@admin.com failed to log in'),
(14, '2023-09-14 14:09:48', '::1', 'Login (Organiser)', 'organiser1@admin.com logged in'),
(15, '2023-09-14 14:15:52', '::1', 'Allocate Task', 'organiser1@admin.com allocated 111 to joebloggs@gmail.com on Day 1, Morning'),
(16, '2023-09-14 14:17:31', '::1', 'Allocate Task', 'organiser1@admin.com allocated Run Competition to hdroxas@gmail.com on Day 1, Morning'),
(17, '2023-09-14 14:20:59', '::1', 'Clear Task', 'organiser1@admin.com clear joebloggs@gmail.com\'s  on Day 1, Morning'),
(18, '2023-09-14 14:25:41', '::1', 'Allocate Task', 'organiser1@admin.com allocated Run Competition to hdroxas@gmail.com on Day 1, Night'),
(19, '2023-09-14 14:25:52', '::1', 'Clear Task', 'organiser1@admin.com cleared hdroxas@gmail.com\'s Run Competition on Day 1, Night'),
(20, '2023-09-14 14:32:28', '::1', 'Add Task', 'organiser1@admin.com added task 000'),
(22, '2023-09-14 14:33:23', '::1', 'Edit Task', 'organiser1@admin.com changed task from 000-0 to 000'),
(23, '2023-09-14 14:33:52', '::1', 'Remove Task', 'organiser1@admin.com removed task Crowd Control'),
(24, '2023-09-14 14:34:07', '::1', 'Remove Task', 'organiser1@admin.com removed task 222'),
(25, '2023-09-14 14:36:12', '::1', 'Registration (Organiser)', 'organiser4@admin.com registered'),
(26, '2023-09-14 14:36:29', '::1', 'Login (Organiser)', 'organiser4@admin.com logged in'),
(27, '2023-09-14 14:44:11', '::1', 'Edit Task', 'organiser4@admin.com changed task name from 111 to 111-2'),
(28, '2023-09-14 14:45:27', '::1', 'Allocate Task', 'organiser4@admin.com allocated Crowd Control to joebloggs@gmail.com on Day 1, Morning'),
(29, '2023-09-14 15:36:53', '::1', 'Login (Organiser)', 'organiser3@admin.com logged in'),
(30, '2023-10-13 03:06:56', '::1', 'Failed Login (Organiser)', 'organiser1@admin.com failed to log in'),
(31, '2023-10-13 03:11:03', '::1', 'Failed Login (Volunteer)', 'hdroxas@gmail.com failed to log in'),
(32, '2023-10-13 03:14:13', '::1', 'Login (Volunteer)', 'hdroxas@gmail.com logged in'),
(33, '2023-10-13 03:14:41', '::1', 'Time Slot added', 'hdroxas@gmail.com added Day 2, Night'),
(34, '2023-10-13 03:14:59', '::1', 'Login (Organiser)', 'organiser1@admin.com logged in'),
(35, '2023-10-13 03:16:16', '::1', 'Login (Volunteer)', '569171588-1@qq.com logged in'),
(36, '2023-10-13 03:16:19', '::1', 'Time Slot added', '569171588-1@qq.com added Day 1, Morning'),
(37, '2023-10-13 03:16:22', '::1', 'Time Slot added', '569171588-1@qq.com added Day 1, Afternoon'),
(38, '2023-10-13 03:16:26', '::1', 'Time Slot added', '569171588-1@qq.com added Day 1, Night'),
(39, '2023-10-13 03:16:31', '::1', 'Time Slot added', '569171588-1@qq.com added Day 2, Afternoon'),
(40, '2023-10-13 03:16:43', '::1', 'Login (Organiser)', 'organiser1@admin.com logged in'),
(41, '2023-10-13 03:16:58', '::1', 'Login (Volunteer)', 'hdroxas@gmail.com logged in'),
(42, '2023-10-13 03:18:00', '::1', 'Login (Organiser)', 'organiser1@admin.com logged in'),
(43, '2023-10-13 03:18:53', '::1', 'Login (Volunteer)', 'hdroxas@gmail.com logged in'),
(44, '2023-10-13 05:17:21', '::1', 'Registration (Volunteer)', 'chloesianghio@gmail.com registered'),
(45, '2023-10-13 05:17:32', '::1', 'Login (Volunteer)', 'chloesianghio@gmail.com logged in'),
(46, '2023-10-13 06:19:18', '::1', 'Login (Volunteer)', '569171588-1@qq.com logged in'),
(47, '2023-10-13 06:19:25', '::1', 'Login (Organiser)', 'organiser1@admin.com logged in'),
(48, '2023-10-13 06:19:38', '::1', 'Add Task', 'organiser1@admin.com added task blah'),
(49, '2023-10-13 06:19:48', '::1', 'Add Task', 'organiser1@admin.com added task blug'),
(50, '2023-10-13 06:19:59', '::1', 'Edit Task', 'organiser1@admin.com changed task name from blug to blug'),
(51, '2023-10-13 06:43:19', '::1', 'Remove Task', 'organiser1@admin.com removed task Cleaning'),
(52, '2023-10-13 06:46:33', '::1', 'Login (Volunteer)', 'hdroxas@gmail.com logged in'),
(53, '2023-10-13 06:46:45', '::1', 'Time Slot added', 'hdroxas@gmail.com added Day 3, Night'),
(54, '2023-10-13 06:52:22', '::1', 'Login (Volunteer)', 'hdroxas@gmail.com logged in'),
(55, '2023-10-13 07:10:38', '::1', 'Login (Volunteer)', 'hdroxas@gmail.com logged in'),
(56, '2023-10-14 05:50:23', '::1', 'Registration (Organiser)', 'tr21 registered'),
(57, '2023-10-14 05:50:32', '::1', 'Login (Organiser)', 'tr21 logged in'),
(58, '2023-10-14 06:03:24', '::1', 'Login (Volunteer)', 'hdroxas@gmail.com logged in'),
(59, '2023-10-14 06:06:03', '::1', 'Time slot removed', 'hdroxas@gmail.com removed Day 1, Morning'),
(60, '2023-10-14 06:06:07', '::1', 'Time slot removed', 'hdroxas@gmail.com removed Day 1, Afternoon'),
(61, '2023-10-14 06:06:11', '::1', 'Time slot removed', 'hdroxas@gmail.com removed Day 1, Night'),
(62, '2023-10-14 06:06:18', '::1', 'Time Slot added', 'hdroxas@gmail.com added Day 1, Night'),
(63, '2023-10-14 06:14:04', '::1', 'Time slot removed', 'hdroxas@gmail.com removed Day 1, Night'),
(64, '2023-10-14 06:24:44', '::1', 'Login (Organiser)', 'organiser1@admin.com logged in'),
(65, '2023-10-14 06:40:46', '::1', 'Login (Organiser)', 'organiser1@admin.com logged in'),
(66, '2023-10-14 06:56:09', '::1', 'Edit Task', 'organiser1@admin.com changed task name from Merchandise Stall to Merchandise Stall'),
(67, '2023-10-14 07:06:30', '::1', 'Login (Organiser)', 'organiser1@admin.com logged in'),
(68, '2023-10-14 07:11:16', '::1', 'Failed Login (Organiser)', 'organiser1@admin.com failed to log in'),
(69, '2023-10-14 07:11:20', '::1', 'Login (Organiser)', 'organiser1@admin.com logged in'),
(70, '2023-10-14 07:11:26', '::1', 'Clear Task', 'organiser1@admin.com cleared joebloggs@gmail.com\'s Crowd Control on Day 1, Morning'),
(71, '2023-10-14 07:11:31', '::1', 'Clear Task', 'organiser1@admin.com cleared 569171588@qq.com\'s Crowd Control on Day 1, Morning'),
(72, '2023-10-14 07:13:37', '::1', 'Login (Organiser)', 'organiser1@admin.com logged in'),
(73, '2023-10-14 07:20:28', '::1', 'Registration (Volunteer)', 'howellyang@gmail.com registered'),
(74, '2023-10-14 07:20:38', '::1', 'Login (Volunteer)', 'howellyang@gmail.com logged in'),
(75, '2023-10-14 07:20:45', '::1', 'Time Slot added', 'howellyang@gmail.com added Day 1, Morning'),
(76, '2023-10-14 07:20:49', '::1', 'Time Slot added', 'howellyang@gmail.com added Day 1, Afternoon'),
(77, '2023-10-14 07:20:52', '::1', 'Time Slot added', 'howellyang@gmail.com added Day 1, Night'),
(78, '2023-10-14 07:21:05', '::1', 'Login (Organiser)', 'organiser1@admin.com logged in'),
(79, '2023-10-14 07:26:47', '::1', 'Login (Organiser)', 'tr21 logged in'),
(80, '2023-10-14 07:26:55', '::1', 'Failed Login (Organiser)', 'organiser1@admin.com failed to log in'),
(81, '2023-10-14 07:27:04', '::1', 'Login (Organiser)', 'tr21 logged in'),
(82, '2023-10-14 07:28:46', '::1', 'Allocate Task', 'tr21 allocated Crowd Control to joebloggs@gmail.com on Day 1, Morning'),
(83, '2023-10-14 07:29:08', '::1', 'Allocate Task', 'tr21 allocated Crowd Control to joebloggs@gmail.com on Day 1, Morning'),
(84, '2023-10-14 07:29:18', '::1', 'Allocate Task', 'tr21 allocated Pack Up to howellyang@gmail.com on Day 1, Morning'),
(85, '2023-10-14 07:29:35', '::1', 'Allocate Task', 'tr21 allocated Merchandise Stall to suejones@gmail.com on Day 1, Afternoon');

-- --------------------------------------------------------

--
-- Table structure for table `organiser`
--

CREATE TABLE `organiser` (
  `organiser_username` varchar(50) NOT NULL,
  `organiser_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- RELATIONSHIPS FOR TABLE `organiser`:
--

--
-- Dumping data for table `organiser`
--

INSERT INTO `organiser` (`organiser_username`, `organiser_password`) VALUES
('tr21', '$2y$10$KAPYPYjX6eglFfkCBX7u.uAvxEjw0e/z6zy2.bTU.yb25t87Iyl.e');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `task_id` int(20) NOT NULL,
  `task_name` varchar(20) NOT NULL,
  `only_18` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- RELATIONSHIPS FOR TABLE `task`:
--

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`task_id`, `task_name`, `only_18`) VALUES
(2, 'Crowd Control', 1),
(4, 'Merchandise Stall', 0),
(5, 'Run Competition', 0),
(6, 'Pack Up', 1),
(8, 'Admissions', 1),
(9, '999', 1),
(12, '111-2', 0),
(15, 'blah', 1),
(16, 'blug', 1);

-- --------------------------------------------------------

--
-- Table structure for table `time_slot`
--

CREATE TABLE `time_slot` (
  `time_slot_id` int(20) NOT NULL,
  `time_slot_name` varchar(50) NOT NULL,
  `day` tinyint(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- RELATIONSHIPS FOR TABLE `time_slot`:
--

--
-- Dumping data for table `time_slot`
--

INSERT INTO `time_slot` (`time_slot_id`, `time_slot_name`, `day`) VALUES
(1, 'Day 1, Morning', 1),
(2, 'Day 1, Afternoon', 1),
(3, 'Day 1, Night', 1),
(97, 'Day 2, Morning', 2),
(98, 'Day 2, Afternoon', 2),
(99, 'Day 2, Night', 2);

-- --------------------------------------------------------

--
-- Table structure for table `volunteer`
--

CREATE TABLE `volunteer` (
  `volunteer_email` varchar(50) NOT NULL,
  `volunteer_password` varchar(255) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `birthday` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- RELATIONSHIPS FOR TABLE `volunteer`:
--

--
-- Dumping data for table `volunteer`
--

INSERT INTO `volunteer` (`volunteer_email`, `volunteer_password`, `first_name`, `last_name`, `phone`, `postcode`, `birthday`) VALUES
('chloesianghio@gmail.com', '$2y$10$nyz673tL4q846FTBF7bNJO9iUW7ZkmBUkH7F0Oc6jzAIp7LcEyD3.', 'Chloe', 'Sianghio', '0491560543', '6065', '1980-06-13'),
('hdroxas@gmail.com', '$2y$10$R6IwAlSvBGGILUpEfEWlFeuPkVgooo3ccjjvBHkjcU2.9At9JSdli', 'Harvey', 'Roxas', '0493780741', '1109', '2023-09-13'),
('howellyang@gmail.com', '$2y$10$gIByL46GYPSqwz9UWoIjQeBiVLa.HvZoD8eC4NloNSo3SYC0Hg8qe', 'Howell', 'Yang', '0498756453', '6068', '2002-07-06'),
('joebloggs@gmail.com', '$2y$10$R6IwAlSvBGGILUpEfEWlFeuPkVgooo3ccjjvBHkjcU2.9At9JSdli', 'Joe', 'Bloggs', '0491780765', '6065', '2000-09-13'),
('suejones@gmail.com', '$2y$10$R6IwAlSvBGGILUpEfEWlFeuPkVgooo3ccjjvBHkjcU2.9At9JSdli', 'Sue', 'Jones', '0492657807', '6067', '2023-09-13');

-- --------------------------------------------------------

--
-- Table structure for table `volunteer_time_slot`
--

CREATE TABLE `volunteer_time_slot` (
  `vol_time_id` int(20) NOT NULL,
  `volunteer_email` varchar(50) NOT NULL,
  `time_id` int(20) NOT NULL,
  `task_id` int(20) DEFAULT NULL,
  `details` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- RELATIONSHIPS FOR TABLE `volunteer_time_slot`:
--   `volunteer_email`
--       `volunteer` -> `volunteer_email`
--   `task_id`
--       `task` -> `task_id`
--   `time_id`
--       `time_slot` -> `time_slot_id`
--

--
-- Dumping data for table `volunteer_time_slot`
--

INSERT INTO `volunteer_time_slot` (`vol_time_id`, `volunteer_email`, `time_id`, `task_id`, `details`) VALUES
(1, 'joebloggs@gmail.com', 1, 2, 'Crowd control'),
(2, 'suejones@gmail.com', 2, 4, 'Man lemonade stand'),
(33, 'howellyang@gmail.com', 1, 6, 'Pack Up'),
(34, 'howellyang@gmail.com', 2, NULL, NULL),
(35, 'howellyang@gmail.com', 3, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`log_id`) USING BTREE;

--
-- Indexes for table `organiser`
--
ALTER TABLE `organiser`
  ADD PRIMARY KEY (`organiser_username`) USING BTREE;

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`task_id`) USING BTREE;

--
-- Indexes for table `time_slot`
--
ALTER TABLE `time_slot`
  ADD PRIMARY KEY (`time_slot_id`) USING BTREE;

--
-- Indexes for table `volunteer`
--
ALTER TABLE `volunteer`
  ADD PRIMARY KEY (`volunteer_email`) USING BTREE;

--
-- Indexes for table `volunteer_time_slot`
--
ALTER TABLE `volunteer_time_slot`
  ADD PRIMARY KEY (`vol_time_id`) USING BTREE,
  ADD KEY `volunteer_time_ibfk_3` (`volunteer_email`) USING BTREE,
  ADD KEY `volunteer_time_ibfk_4` (`task_id`) USING BTREE,
  ADD KEY `volunteer_time_ibfk_5` (`time_id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `task_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `time_slot`
--
ALTER TABLE `time_slot`
  MODIFY `time_slot_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `volunteer_time_slot`
--
ALTER TABLE `volunteer_time_slot`
  MODIFY `vol_time_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `volunteer_time_slot`
--
ALTER TABLE `volunteer_time_slot`
  ADD CONSTRAINT `volunteer_time_slot_ibfk_3` FOREIGN KEY (`volunteer_email`) REFERENCES `volunteer` (`volunteer_email`),
  ADD CONSTRAINT `volunteer_time_slot_ibfk_4` FOREIGN KEY (`task_id`) REFERENCES `task` (`task_id`),
  ADD CONSTRAINT `volunteer_time_slot_ibfk_5` FOREIGN KEY (`time_id`) REFERENCES `time_slot` (`time_slot_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
