-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 26, 2025 at 03:48 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vaze_leave_management_db_trial`
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
(3, 'Commerce', 'J'),
(4, 'office_lab', 'D'),
(5, 'Science', 'J'),
(6, 'Arts', 'J');

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

--
-- Dumping data for table `n_cl_leave`
--

INSERT INTO `n_cl_leave` (`Staff_id`, `From_date`, `To_date`, `No_of_days`, `Reason`, `Date_of_application`, `HOD_remark`, `Principal_remark`, `Office_remark`, `leave_approval_status`, `A_year`) VALUES
(120, '2025-01-26', '2025-01-28', 3, '  ,,,,opp', '2025-01-26', '', '', '', 'P', '2025');

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

--
-- Dumping data for table `n_emhm_leave`
--

INSERT INTO `n_emhm_leave` (`Staff_id`, `From_date`, `To_date`, `No_of_days`, `Type`, `Reason`, `Prefix-suffix`, `Date_of_application`, `Principal_remark`, `Office_remark`, `leave_approval_status`, `A_year`) VALUES
(120, '2025-01-26', '2025-02-04', 10, 'ML', 'dd', 'd', '2025-01-26', '', '', 'P', '2025');

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
(120, 'Office Operator 1', 'Mr ', '2024-10-31', 'N', '022nitinsingh@gmail.com', '$2y$10$4sYMmkb1czma7PJOwtEpJ.XO2EHi0ajwVAdd24Xg7oBfFv7t7Lw1O', 'M', 'OO', 4, 'A'),
(121, 'Principal Degree', 'Principal', '2024-11-01', 'T', '31nitinthakur@gmail.com', '$2y$10$0G1ZrrtB0b4I0rEUnryP1.5fE7i3fYdIaF1Tfv/mKtb0D4e.TiRyK', 'M', 'TD', 1, 'A'),
(127, 'Degree Teacher 1', 'Mr ', '2024-11-14', 'T', 'aniket@gmail.com', '$2y$10$zmnHuuNCXmdVZjhYbfoMXek2Up9VrnzYCSq.cjLIH3Q2ZjxaY13G2', 'M', 'TD', 1, 'A'),
(129, 'Degree HOD', 'HOD', '2024-10-27', 'T', 'hod@gmail.com', '$2y$10$r7SCexExdvYaP8cFGQtQBezIu1nbiNAORVGCgieNnKlZxQo1omtaa', 'F', 'TD', 1, 'A'),
(131, 'Vice Principal', 'Vice Principal ', '2024-10-27', 'T', 'vice@gmail.com', '$2y$10$WCQk/CPqpBLgWNTzkFzM4ehKEykkhRg32xNAv8iOALzZYtT3120Yu', 'M', 'TD', 2, 'A'),
(132, 'Non Teaching Office 1', 'Mr ', '2024-11-14', 'N', 'abc@gmail.com', '$2y$10$wLSWbZ45sOHqDLfZZgnPNOAfUKvnc0wCUMjHDxtsqGWBc1fsUx.au', 'M', 'NO', 4, 'A'),
(134, 'Non Teaching Office 2', 'Mr ', '2024-11-15', 'N', 'new@gmail.com', '$2y$10$LPS1cOWX.GqPSY35bzMIp.PlS1vPECZiUMUrvdTFRSXk2PKHpkqSi', 'M', 'NO', 4, 'A'),
(135, 'Non Teaching1', 'Mr ', '2024-11-05', 'N', 'non@gmail.com', '$2y$10$QAdzCZ.3IKxkR5ouPdDXW.8efejCIP2lX9MyDgTgvE.SsNi0FSbum', 'M', 'NO', 4, 'A'),
(136, 'Junior HOD', 'HOD', '2024-11-03', 'T', 'juniorhod@gmail.com', '$2y$10$ghjBLHYmbhSbGQy0Si/.ouEGuuDcWP1rz0SIiMynEfgs1IAH2y6Xm', 'M', 'TJ', 3, 'A'),
(137, 'Junior Principal', 'Vice Principal ', '2024-10-28', 'T', 'juniorprincipal@gmail.com', '$2y$10$DQ2uj9/fvSRrs76IwRe26.ZiNa8bKvVyi4DdehxX4JTgqgHmL7zCO', 'M', 'TJ', 5, 'A'),
(138, 'Registrar', 'Registrar', '2025-01-14', 'N', 'registrar@gmail.com', '$2y$10$VLp9eqC9hKzECjCenC0kEeUf53MbCvrfios2nGokUTPlXGirwiPlG', 'M', 'NO', 4, 'A'),
(139, 'Junior Teacher 2', 'Professor ', '2025-01-04', 'T', 'butche@gmail.com', '$2y$10$hysEYlr9pCucaFlV.l3uueaozZYbsmWw6bJc7SlhrwRSVlXfmPQGK', 'M', 'TJ', 5, 'A'),
(140, 'Junior Teacher 3', 'Professor ', '2025-01-08', 'T', 'habibi52777@gmail.com', '$2y$10$hysEYlr9pCucaFlV.l3uueaozZYbsmWw6bJc7SlhrwRSVlXfmPQGK', 'M', 'TJ', 6, 'A'),
(141, 'Degree Teacher 2', 'Professor ', '2025-01-03', 'T', 'butche234@gmail.com', '$2y$10$NEdEq4hCcD3dTfODOrD/Le2t9DsttiJqDfrpRkbFJYTqYpErnerdq', 'M', 'TD', 2, 'A');

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
(132, 'CL', 10, '2025'),
(132, 'MA', 10, '2025'),
(132, 'HP', 10, '2025'),
(132, 'DL', 10, '2025'),
(132, 'ML', 10, '2025'),
(132, 'EL', 10, '2025'),
(134, 'CL', 10, '2025'),
(134, 'MA', 10, '2025'),
(134, 'HP', 10, '2025'),
(134, 'DL', 10, '2025'),
(134, 'ML', 10, '2025'),
(134, 'EL', 10, '2025'),
(135, 'CL', 10, '2025'),
(135, 'MA', 10, '2025'),
(135, 'HP', 10, '2025'),
(135, 'DL', 10, '2025'),
(135, 'ML', 10, '2025'),
(135, 'EL', 10, '2025'),
(138, 'CL', 10, '2025'),
(138, 'MA', 10, '2025'),
(138, 'HP', 10, '2025'),
(138, 'DL', 10, '2025'),
(138, 'ML', 10, '2025'),
(138, 'EL', 10, '2025'),
(120, 'CL', 10, '2025'),
(120, 'MA', 10, '2025'),
(120, 'HP', 10, '2025'),
(120, 'DL', 10, '2025'),
(120, 'ML', 10, '2025'),
(120, 'EL', 10, '2025'),
(121, 'CL', 10, '2025'),
(121, 'MA', 10, '2025'),
(121, 'HP', 10, '2025'),
(121, 'DL', 10, '2025'),
(121, 'ML', 10, '2025'),
(127, 'CL', 10, '2025'),
(127, 'MA', 10, '2025'),
(127, 'HP', 10, '2025'),
(127, 'DL', 10, '2025'),
(127, 'ML', 10, '2025'),
(129, 'CL', 10, '2025'),
(129, 'MA', 10, '2025'),
(129, 'HP', 10, '2025'),
(129, 'DL', 10, '2025'),
(129, 'ML', 10, '2025'),
(131, 'CL', 10, '2025'),
(131, 'MA', 10, '2025'),
(131, 'HP', 10, '2025'),
(131, 'DL', 10, '2025'),
(131, 'ML', 10, '2025'),
(141, 'CL', 10, '2025'),
(141, 'MA', 10, '2025'),
(141, 'HP', 10, '2025'),
(141, 'DL', 10, '2025'),
(141, 'ML', 10, '2025');

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
  MODIFY `Staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

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
