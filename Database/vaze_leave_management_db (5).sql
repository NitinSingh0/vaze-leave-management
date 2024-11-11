-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2024 at 08:56 PM
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
(121, '2024-11-22', '2024-11-29', 8, 'aad', '2024-11-08', '', '', '', 'P', '2024'),
(123, '2024-10-01', '2024-10-03', 4, 'wxdxw', '2024-10-01', 'accepted', '', '', 'PA', '2024'),
(123, '2024-10-01', '2024-10-10', 11, 'not specified ...................................................................................................................', '2024-10-08', 'accept', 'approved', 'wec', 'PA', '2024');

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
(120, '2024-11-08', '2024-11-09', 2, 'abcccc', NULL, NULL, '', '', '', 'P', '2024', '2024-11-04', 'SL'),
(120, '2024-11-14', '2024-11-14', 1, 'xyzzz', NULL, NULL, '', 'approved', '', 'PA', '2024', '2024-11-04', 'DL'),
(121, '2024-11-10', '2024-11-11', 2, 'not specified', 0, '0000-00-00', '', '', '', 'P', '2024', '2024-11-08', 'SL'),
(121, '2024-11-21', '2024-11-30', 10, 'gffhj', 0, '0000-00-00', '', '', '', 'P', '2024', '2024-11-08', 'DL'),
(123, '2024-10-17', '2024-10-18', 2, 'jjcc', NULL, NULL, 'accepted', 'decline', 'wef', 'PD', '2024', '2024-10-16', 'SL');

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
(123, '2024-10-11', '2024-10-19', 10, 'ML', 'dcnjn,njjwj', 'wjj', '2024-10-02', 'aceept', 'decline', 'wdc', 'PD', '2024');

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
(120, 'Abc', 'Mr ', '2024-10-31', 'N', '022nitinsingh@gmail.com', '$2y$10$4sYMmkb1czma7PJOwtEpJ.XO2EHi0ajwVAdd24Xg7oBfFv7t7Lw1O', 'M', 'OO', 1, 'A'),
(121, 'Nitin Singh', 'Principal', '2024-11-01', 'T', '31nitinthakur@gmail.com', '$2y$10$QdYTsnWuJW1ku3RnkMkFLO9qqTLtI2Opro54uvTIKpUu01SlMMcHe', 'M', 'TD', 1, 'A'),
(123, 'Nitin Singh', 'Master', '2024-10-07', '', 'college.nitinsingh@gmail.com', 'nitin', 'M', 'TD', 1, 'A'),
(124, 'Abc', 'HOD', '2024-05-06', 'T', 'HOD', 'nitin', 'M', 'TD', 1, 'A'),
(125, 'Anonymous', 'Principal', '2024-04-01', 'T', 'Principal', 'nitin', 'M', 'TD', 4, 'A'),
(127, 'aniket', 'Mr ', '2024-11-14', 'T', 'aniket@gmail.com', '$2y$10$zmnHuuNCXmdVZjhYbfoMXek2Up9VrnzYCSq.cjLIH3Q2ZjxaY13G2', 'M', 'TD', 1, 'A'),
(129, 'Pournima Maam', 'HOD', '2024-10-27', 'T', 'hod@gmail.com', '$2y$10$r7SCexExdvYaP8cFGQtQBezIu1nbiNAORVGCgieNnKlZxQo1omtaa', 'F', 'TD', 1, 'A'),
(131, 'Vice Principal', 'Vice Principal ', '2024-10-27', 'T', 'vice@gmail.com', '$2y$10$WCQk/CPqpBLgWNTzkFzM4ehKEykkhRg32xNAv8iOALzZYtT3120Yu', 'M', 'TD', 2, 'A');

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
(121, 'ML', 15, '2024');

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
  MODIFY `Staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

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
