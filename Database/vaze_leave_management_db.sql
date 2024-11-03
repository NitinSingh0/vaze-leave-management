-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2024 at 06:31 PM
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
-- Database: `vaze_leave_management_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `D_id` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `College` enum('D','J','O','L') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`D_id`, `Name`, `College`) VALUES
(1, 'Information technology', 'D'),
(2, 'Baf', 'D');

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
  `Date_of_appliaction` date NOT NULL,
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
  `Ofiice_remark` text NOT NULL,
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
  `Ofiice_remark` text NOT NULL,
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

--
-- Dumping data for table `n_off_pay_leave`
--

INSERT INTO `n_off_pay_leave` (`Staff_id`, `Date_of_application`, `Extra_duty_date`, `Nature_of_work`, `Off_leave_date`, `Principal_remark`, `Office_remark`, `leave_approval_status`, `A_year`) VALUES
(1, '2024-10-29', '2024-10-01', '555', '2024-10-29', '', '', 'P', '2024'),
(1, '2024-10-29', '2024-10-02', '555', '2024-10-30', '', '', 'P', '2024'),
(1, '2024-10-29', '2024-10-18', '55', '2024-10-31', '', '', 'P', '2024'),
(1, '2024-10-29', '2024-10-22', 'thdjdwjdjwdjwdjjdwjdwjdwjdwjdwdwdwd', '2024-10-30', '', '', 'P', '2025'),
(1, '2024-10-29', '2024-10-25', '5', '2024-10-30', '', '', 'P', '2024'),
(1, '2024-10-29', '2024-10-26', '55', '2024-10-31', '', '', 'P', '2024');

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
(1, 'aniket', 'HOD', '2024-10-08', 'T', 'walfra52777@gmail.com', 'NEW', 'M', 'TD', 1, 'A');

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `n_off_pay_leave`
--
ALTER TABLE `n_off_pay_leave`
  MODIFY `Staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
