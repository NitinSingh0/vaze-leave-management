-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 14, 2025 at 11:08 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vaze_leave_management_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `D_id` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `College` enum('D','J') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`D_id`, `Name`, `College`) VALUES
(1, 'Information Technology', 'D'),
(2, 'Biotechnology', 'D'),
(3, 'Math', 'J'),
(4, 'office_lab', 'D');

-- --------------------------------------------------------

--
-- Table structure for table `d_cl_leave`
--

CREATE TABLE `d_cl_leave` (
  `Staff_id` int(11) NOT NULL,
  `From_date` date NOT NULL,
  `To_date` date NOT NULL,
  `No_of_days` int(11) NOT NULL,
  `Reason` text NOT NULL,
  `Date_of_application` date NOT NULL,
  `HOD_remark` text NOT NULL,
  `Principal_remark` text NOT NULL,
  `Office_remark` text NOT NULL,
  `leave_approval_status` enum('P','HA','HD','PA','PD') NOT NULL,
  `A_year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `d_cl_leave`
--

INSERT INTO `d_cl_leave` (`Staff_id`, `From_date`, `To_date`, `No_of_days`, `Reason`, `Date_of_application`, `HOD_remark`, `Principal_remark`, `Office_remark`, `leave_approval_status`, `A_year`) VALUES
(120, '2024-11-01', '2024-11-23', 24, 'xyzzzz', '2024-11-04', '', 'approved', 'bsh', 'PA', '2024'),
(120, '2024-11-24', '2024-11-27', 4, 'abcc', '2024-11-04', '', 'approved', '', 'PA', '2024'),
(121, '2024-11-22', '2024-11-29', 8, 'aad', '2024-11-08', 'accept', 'approved', '', 'PA', '2024'),
(129, '2024-11-05', '2024-11-15', 12, 'not specified', '2024-11-14', 'submit', 'approved', '', 'PA', '2024');

-- --------------------------------------------------------

--
-- Table structure for table `d_dl_leave`
--

CREATE TABLE `d_dl_leave` (
  `Staff_id` int(11) NOT NULL,
  `From_date` date NOT NULL,
  `To_date` date NOT NULL,
  `No_of_days` int(11) NOT NULL,
  `Nature` text NOT NULL,
  `Reference_no` int(11) DEFAULT NULL,
  `Date_of_letter` date DEFAULT NULL,
  `HOD_remark` text NOT NULL,
  `Principal_remark` text NOT NULL,
  `Office_remark` text NOT NULL,
  `leave_approval_status` enum('P','HA','HD','PA','PD') NOT NULL,
  `A_year` year(4) NOT NULL,
  `Date_of_application` date NOT NULL,
  `Type` enum('SL','DL') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `d_dl_leave`
--

INSERT INTO `d_dl_leave` (`Staff_id`, `From_date`, `To_date`, `No_of_days`, `Nature`, `Reference_no`, `Date_of_letter`, `HOD_remark`, `Principal_remark`, `Office_remark`, `leave_approval_status`, `A_year`, `Date_of_application`, `Type`) VALUES
(120, '2024-11-08', '2024-11-09', 2, 'abcccc', NULL, NULL, 'accespt', 'approved 11:08', '', 'PA', '2024', '2024-11-04', 'SL'),
(120, '2024-11-14', '2024-11-14', 1, 'xyzzz', NULL, NULL, '', 'approved', '', 'PA', '2024', '2024-11-04', 'DL'),
(121, '2024-11-10', '2024-11-11', 2, 'not specified', 0, '0000-00-00', '', '', '', 'P', '2024', '2024-11-08', 'SL'),
(121, '2024-11-21', '2024-11-22', 2, 'leave on 21st nov', 0, '0000-00-00', 'accept', '', '', 'HA', '2024', '2024-11-21', 'SL'),
(121, '2024-11-21', '2024-11-30', 10, 'gffhj', 0, '0000-00-00', '', '', '', 'P', '2024', '2024-11-08', 'DL'),
(129, '2024-11-13', '2024-11-15', 3, 'not specified', NULL, NULL, '', '', '', 'P', '2024', '2024-11-14', 'SL');

-- --------------------------------------------------------

--
-- Table structure for table `d_mhm_leave`
--

CREATE TABLE `d_mhm_leave` (
  `Staff_id` int(11) NOT NULL,
  `From_date` date NOT NULL,
  `To_date` date NOT NULL,
  `No_of_days` int(11) NOT NULL,
  `Type` enum('ML','HP','MA') NOT NULL,
  `Reason` text NOT NULL,
  `Prefix-Suffix` varchar(50) NOT NULL,
  `Date_of_application` date NOT NULL,
  `HOD_remark` text NOT NULL,
  `Principal_remark` text NOT NULL,
  `Office_remark` text NOT NULL,
  `leave_approval_status` enum('P','HA','HD','PA','PD') NOT NULL,
  `A_year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `d_mhm_leave`
--

INSERT INTO `d_mhm_leave` (`Staff_id`, `From_date`, `To_date`, `No_of_days`, `Type`, `Reason`, `Prefix-Suffix`, `Date_of_application`, `HOD_remark`, `Principal_remark`, `Office_remark`, `leave_approval_status`, `A_year`) VALUES
(120, '2024-11-14', '2024-11-16', 3, 'ML', 'abccc', '', '2024-10-02', '', '', '', 'P', '2024'),
(121, '2024-11-22', '2024-11-27', 6, 'HP', 'reasonnnn', 'okk', '2024-11-21', 'accept', 'approved', '', 'PA', '2024');

-- --------------------------------------------------------

--
-- Table structure for table `j_cl_leave`
--

CREATE TABLE `j_cl_leave` (
  `Staff_id` int(11) NOT NULL,
  `From_date` date NOT NULL,
  `To_date` date NOT NULL,
  `No_of_days` int(11) NOT NULL,
  `Reason` text NOT NULL,
  `Date_of_application` date NOT NULL,
  `HOD_remark` text NOT NULL,
  `Principal_remark` text NOT NULL,
  `Office_remark` text NOT NULL,
  `leave_approval_status` enum('P','HA','HD','PA','PD') NOT NULL,
  `A_year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `j_cl_leave`
--

INSERT INTO `j_cl_leave` (`Staff_id`, `From_date`, `To_date`, `No_of_days`, `Reason`, `Date_of_application`, `HOD_remark`, `Principal_remark`, `Office_remark`, `leave_approval_status`, `A_year`) VALUES
(136, '2024-11-05', '2024-11-14', 11, 'not specified', '2024-11-12', '', '', '', 'P', '2024');

-- --------------------------------------------------------

--
-- Table structure for table `j_dl_leave`
--

CREATE TABLE `j_dl_leave` (
  `Staff_id` int(11) NOT NULL,
  `From_date` date NOT NULL,
  `To_date` date NOT NULL,
  `No_of_days` int(11) NOT NULL,
  `Nature` text NOT NULL,
  `Reference_no` int(11) DEFAULT NULL,
  `Date_of_letter` date DEFAULT NULL,
  `HOD_remark` text NOT NULL,
  `Principal_remark` text NOT NULL,
  `Office_remark` text NOT NULL,
  `leave_approval_status` enum('P','HA','HD','PA','PD') NOT NULL,
  `A_year` year(4) NOT NULL,
  `Date_of_application` date NOT NULL,
  `Type` enum('SL','DL') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `j_ehm_leave`
--

CREATE TABLE `j_ehm_leave` (
  `Staff_id` int(11) NOT NULL,
  `From_date` date NOT NULL,
  `To_date` date NOT NULL,
  `No_of_days` int(11) NOT NULL,
  `Type` enum('EL','HP','MA') NOT NULL,
  `Reason` text NOT NULL,
  `Prefix-Suffix` varchar(100) NOT NULL,
  `Date_of_application` date NOT NULL,
  `HOD_remark` text NOT NULL,
  `Principal_remark` text NOT NULL,
  `Office_remark` text NOT NULL,
  `leave_approval_status` enum('P','HA','HD','PA','PD') NOT NULL,
  `A_year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `Leave_type` enum('CL','DL','ML','HP','MA','EL','OL') NOT NULL,
  `College` enum('D','J') NOT NULL,
  `No_of_leaves` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `n_cl_leave`
--

CREATE TABLE `n_cl_leave` (
  `Staff_id` int(11) NOT NULL,
  `From_date` date NOT NULL,
  `To_date` date NOT NULL,
  `No_of_days` int(11) NOT NULL,
  `Reason` text NOT NULL,
  `Date_of_application` date NOT NULL,
  `HOD_remark` text NOT NULL,
  `Principal_remark` text NOT NULL,
  `Office_remark` text NOT NULL,
  `leave_approval_status` enum('P','PA','PD') NOT NULL,
  `A_year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `n_dl_leave`
--

CREATE TABLE `n_dl_leave` (
  `Staff_id` int(11) NOT NULL,
  `From_date` date NOT NULL,
  `To_date` date NOT NULL,
  `No_of_days` int(11) NOT NULL,
  `Nature` text NOT NULL,
  `HOD_remark` text NOT NULL,
  `Principal_remark` text NOT NULL,
  `Office_remark` text NOT NULL,
  `leave_approval_status` enum('P','PA','PD') NOT NULL,
  `A_year` year(4) NOT NULL,
  `Date_of_application` date NOT NULL,
  `Type` enum('SL','DL') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `n_emhm_leave`
--

CREATE TABLE `n_emhm_leave` (
  `Staff_id` int(11) NOT NULL,
  `From_date` date NOT NULL,
  `To_date` date NOT NULL,
  `No_of_days` int(11) NOT NULL,
  `Type` enum('EL','ML','HP','MA') NOT NULL,
  `Reason` text NOT NULL,
  `Prefix-suffix` varchar(50) NOT NULL,
  `Date_of_application` date NOT NULL,
  `Principal_remark` text NOT NULL,
  `Office_remark` text NOT NULL,
  `leave_approval_status` enum('P','PA','PD') NOT NULL,
  `A_year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `n_off_pay_leave`
--

CREATE TABLE `n_off_pay_leave` (
  `Staff_id` int(11) NOT NULL,
  `Date_of_application` date NOT NULL,
  `Extra_duty_date` date NOT NULL,
  `Nature_of_work` text NOT NULL,
  `Off_leave_date` date NOT NULL,
  `Principal_remark` text NOT NULL,
  `Office_remark` text NOT NULL,
  `leave_approval_status` enum('P','PA','PD') NOT NULL,
  `A_year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `Staff_id` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Designation` varchar(50) NOT NULL,
  `DOJ` date NOT NULL,
  `Staff_type` enum('T','N') NOT NULL,
  `Username` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Gender` enum('M','F') NOT NULL,
  `Job_role` enum('TD','TJ','NL','NO','OO') NOT NULL,
  `D_id` int(11) NOT NULL,
  `status` enum('A','D') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`Staff_id`, `Name`, `Designation`, `DOJ`, `Staff_type`, `Username`, `Password`, `Gender`, `Job_role`, `D_id`, `status`) VALUES
(120, 'Abc', 'Mr ', '2024-10-31', 'N', '022nitinsingh@gmail.com', '$2y$10$4sYMmkb1czma7PJOwtEpJ.XO2EHi0ajwVAdd24Xg7oBfFv7t7Lw1O', 'M', 'OO', 1, 'D'),
(121, 'Nitin Singh', 'Principal', '2024-11-01', 'T', '31nitinthakur@gmail.com', '$2y$10$0G1ZrrtB0b4I0rEUnryP1.5fE7i3fYdIaF1Tfv/mKtb0D4e.TiRyK', 'M', 'TD', 1, 'A'),
(127, 'aniket', 'Mr ', '2024-11-14', 'T', 'aniket@gmail.com', '$2y$10$zmnHuuNCXmdVZjhYbfoMXek2Up9VrnzYCSq.cjLIH3Q2ZjxaY13G2', 'M', 'TD', 1, 'A'),
(129, 'Pournima Maam', 'HOD', '2024-10-27', 'T', 'hod@gmail.com', '$2y$10$r7SCexExdvYaP8cFGQtQBezIu1nbiNAORVGCgieNnKlZxQo1omtaa', 'F', 'TD', 1, 'A'),
(131, 'Vice Principal', 'Vice Principal ', '2024-10-27', 'T', 'vice@gmail.com', '$2y$10$WCQk/CPqpBLgWNTzkFzM4ehKEykkhRg32xNAv8iOALzZYtT3120Yu', 'M', 'TD', 2, 'A'),
(132, 'abc', 'Mr ', '2024-11-14', 'N', 'abc@gmail.com', '$2y$10$wLSWbZ45sOHqDLfZZgnPNOAfUKvnc0wCUMjHDxtsqGWBc1fsUx.au', 'M', 'NO', 1, 'A'),
(134, 'new', 'Mr ', '2024-11-15', 'N', 'new@gmail.com', '$2y$10$LPS1cOWX.GqPSY35bzMIp.PlS1vPECZiUMUrvdTFRSXk2PKHpkqSi', 'M', 'NO', 1, 'A'),
(135, 'Non Teaching1', 'Mr ', '2024-11-05', 'N', 'non@gmail.com', '$2y$10$QAdzCZ.3IKxkR5ouPdDXW.8efejCIP2lX9MyDgTgvE.SsNi0FSbum', 'M', 'NO', 4, 'A'),
(136, 'Junior hod', 'HOD', '2024-11-03', 'T', 'juniorhod@gmail.com', '$2y$10$ghjBLHYmbhSbGQy0Si/.ouEGuuDcWP1rz0SIiMynEfgs1IAH2y6Xm', 'M', 'TJ', 3, 'D'),
(137, 'junior Principal', 'Vice Principal ', '2024-10-28', 'T', 'juniorprincipal@gmail.com', '$2y$10$DQ2uj9/fvSRrs76IwRe26.ZiNa8bKvVyi4DdehxX4JTgqgHmL7zCO', 'M', 'TD', 3, 'D'),
(138, 'Registrar', 'Registrar', '2025-01-14', 'N', 'registrar@gmail.com', '$2y$10$VLp9eqC9hKzECjCenC0kEeUf53MbCvrfios2nGokUTPlXGirwiPlG', 'M', 'NO', 4, 'A');

-- --------------------------------------------------------

--
-- Table structure for table `staff_leaves`
--

CREATE TABLE `staff_leaves` (
  `Staff_id` int(11) NOT NULL,
  `Type` enum('CL','DL','ML','HP','MA','EL','OL') NOT NULL,
  `College` enum('D','J') NOT NULL,
  `A_year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff_leaves_trial`
--

CREATE TABLE `staff_leaves_trial` (
  `Staff_id` int(11) NOT NULL,
  `Leave_type` enum('CL','DL','ML','HP','MA','EL','OL') NOT NULL,
  `No_of_leaves` int(11) NOT NULL,
  `A_year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_leaves_trial`
--

INSERT INTO `staff_leaves_trial` (`Staff_id`, `Leave_type`, `No_of_leaves`, `A_year`) VALUES
(121, 'CL', 15, '2024'),
(121, 'MA', 15, '2024'),
(121, 'HP', 15, '2024'),
(121, 'ML', 15, '2024'),
(121, 'DL', 15, '2024'),
(120, 'CL', 15, '2024'),
(120, 'MA', 15, '2024'),
(120, 'HP', 15, '2024'),
(120, 'ML', 15, '2024'),
(127, 'CL', 15, '2024'),
(127, 'MA', 15, '2024'),
(127, 'HP', 15, '2024'),
(127, 'ML', 15, '2024'),
(129, 'CL', 15, '2024'),
(129, 'MA', 15, '2024'),
(129, 'HP', 15, '2024'),
(129, 'ML', 15, '2024'),
(132, 'CL', 15, '2024'),
(132, 'MA', 15, '2024'),
(132, 'HP', 15, '2024'),
(132, 'ML', 15, '2024'),
(134, 'CL', 15, '2024'),
(134, 'MA', 15, '2024'),
(134, 'HP', 15, '2024'),
(134, 'ML', 15, '2024');

-- --------------------------------------------------------

--
-- Table structure for table `user_status_logs`
--

CREATE TABLE `user_status_logs` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `action_performed_by` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_status_logs`
--

INSERT INTO `user_status_logs` (`id`, `staff_id`, `action_performed_by`, `action`, `timestamp`) VALUES
(1, 136, 121, 'Activate', '2025-01-14 13:49:25'),
(2, 136, 121, 'Deactivate', '2025-01-14 13:49:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`D_id`);

--
-- Indexes for table `d_cl_leave`
--
ALTER TABLE `d_cl_leave`
  ADD PRIMARY KEY (`Staff_id`,`From_date`,`To_date`);

--
-- Indexes for table `d_dl_leave`
--
ALTER TABLE `d_dl_leave`
  ADD PRIMARY KEY (`Staff_id`,`From_date`,`To_date`);

--
-- Indexes for table `d_mhm_leave`
--
ALTER TABLE `d_mhm_leave`
  ADD PRIMARY KEY (`Staff_id`,`From_date`,`To_date`);

--
-- Indexes for table `j_cl_leave`
--
ALTER TABLE `j_cl_leave`
  ADD PRIMARY KEY (`Staff_id`,`From_date`,`To_date`);

--
-- Indexes for table `j_dl_leave`
--
ALTER TABLE `j_dl_leave`
  ADD PRIMARY KEY (`Staff_id`,`From_date`,`To_date`);

--
-- Indexes for table `j_ehm_leave`
--
ALTER TABLE `j_ehm_leave`
  ADD PRIMARY KEY (`Staff_id`,`From_date`,`To_date`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`Leave_type`,`College`);

--
-- Indexes for table `n_cl_leave`
--
ALTER TABLE `n_cl_leave`
  ADD PRIMARY KEY (`Staff_id`,`From_date`,`To_date`);

--
-- Indexes for table `n_dl_leave`
--
ALTER TABLE `n_dl_leave`
  ADD PRIMARY KEY (`Staff_id`,`From_date`,`To_date`);

--
-- Indexes for table `n_emhm_leave`
--
ALTER TABLE `n_emhm_leave`
  ADD PRIMARY KEY (`Staff_id`,`From_date`,`To_date`);

--
-- Indexes for table `n_off_pay_leave`
--
ALTER TABLE `n_off_pay_leave`
  ADD PRIMARY KEY (`Staff_id`,`Extra_duty_date`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`Staff_id`),
  ADD KEY `D_id` (`D_id`);

--
-- Indexes for table `staff_leaves`
--
ALTER TABLE `staff_leaves`
  ADD KEY `Staff_id` (`Staff_id`),
  ADD KEY `Type` (`Type`,`College`),
  ADD KEY `College` (`College`);

--
-- Indexes for table `staff_leaves_trial`
--
ALTER TABLE `staff_leaves_trial`
  ADD KEY `staff_leave_try` (`Staff_id`);

--
-- Indexes for table `user_status_logs`
--
ALTER TABLE `user_status_logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `n_off_pay_leave`
--
ALTER TABLE `n_off_pay_leave`
  MODIFY `Staff_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `Staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `user_status_logs`
--
ALTER TABLE `user_status_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `d_cl_leave`
--
ALTER TABLE `d_cl_leave`
  ADD CONSTRAINT `d_cl_leave_ibfk_1` FOREIGN KEY (`Staff_id`) REFERENCES `staff` (`Staff_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `d_dl_leave`
--
ALTER TABLE `d_dl_leave`
  ADD CONSTRAINT `d_dl_leave_ibfk_1` FOREIGN KEY (`Staff_id`) REFERENCES `staff` (`Staff_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `d_mhm_leave`
--
ALTER TABLE `d_mhm_leave`
  ADD CONSTRAINT `d_mhm_leave_ibfk_1` FOREIGN KEY (`Staff_id`) REFERENCES `staff` (`Staff_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `j_cl_leave`
--
ALTER TABLE `j_cl_leave`
  ADD CONSTRAINT `j_cl_leave_ibfk_1` FOREIGN KEY (`Staff_id`) REFERENCES `staff` (`Staff_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `j_dl_leave`
--
ALTER TABLE `j_dl_leave`
  ADD CONSTRAINT `j_dl_leave_ibfk_1` FOREIGN KEY (`Staff_id`) REFERENCES `staff` (`Staff_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `j_ehm_leave`
--
ALTER TABLE `j_ehm_leave`
  ADD CONSTRAINT `j_ehm_leave_ibfk_1` FOREIGN KEY (`Staff_id`) REFERENCES `staff` (`Staff_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `n_cl_leave`
--
ALTER TABLE `n_cl_leave`
  ADD CONSTRAINT `n_cl_leave_ibfk_1` FOREIGN KEY (`Staff_id`) REFERENCES `staff` (`Staff_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `n_dl_leave`
--
ALTER TABLE `n_dl_leave`
  ADD CONSTRAINT `n_dl_leave_ibfk_1` FOREIGN KEY (`Staff_id`) REFERENCES `staff` (`Staff_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `n_emhm_leave`
--
ALTER TABLE `n_emhm_leave`
  ADD CONSTRAINT `n_emhm_leave_ibfk_1` FOREIGN KEY (`Staff_id`) REFERENCES `staff` (`Staff_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `n_off_pay_leave`
--
ALTER TABLE `n_off_pay_leave`
  ADD CONSTRAINT `n_off_pay_leave_ibfk_1` FOREIGN KEY (`Staff_id`) REFERENCES `staff` (`Staff_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`D_id`) REFERENCES `department` (`D_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `staff_leaves`
--
ALTER TABLE `staff_leaves`
  ADD CONSTRAINT `staff_leaves_ibfk_1` FOREIGN KEY (`Staff_id`) REFERENCES `staff` (`Staff_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `staff_leaves_ibfk_2` FOREIGN KEY (`Type`) REFERENCES `leaves` (`Leave_type`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `staff_leaves_trial`
--
ALTER TABLE `staff_leaves_trial`
  ADD CONSTRAINT `staff_leave_try` FOREIGN KEY (`Staff_id`) REFERENCES `staff` (`Staff_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
