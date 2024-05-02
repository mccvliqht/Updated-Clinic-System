-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2024 at 05:20 AM
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
-- Database: `dbclinic`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `adm_id` int(11) NOT NULL,
  `adm_fname` varchar(100) NOT NULL,
  `adm_lname` varchar(100) NOT NULL,
  `adm_contact` int(11) NOT NULL,
  `adm_email` varchar(50) DEFAULT NULL,
  `lgn_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`adm_id`, `adm_fname`, `adm_lname`, `adm_contact`, `adm_email`, `lgn_id`) VALUES
(5002, 'Micah Kristine', 'Anaya', 2147483647, 'micahanaya09@gmail.com', 23);

-- --------------------------------------------------------

--
-- Table structure for table `tblappoint`
--

CREATE TABLE `tblappoint` (
  `apt_id` int(11) NOT NULL,
  `ptn_id` int(11) NOT NULL,
  `doc_id` int(11) NOT NULL,
  `serv_id` int(11) NOT NULL,
  `apt_time` time NOT NULL,
  `apt_date` date NOT NULL,
  `sched_status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbldoctor`
--

CREATE TABLE `tbldoctor` (
  `doc_id` int(11) NOT NULL,
  `doc_fname` varchar(100) NOT NULL,
  `doc_lname` varchar(100) NOT NULL,
  `doc_birthdate` date DEFAULT NULL,
  `doc_email` varchar(100) DEFAULT NULL,
  `doc_contact` int(11) NOT NULL,
  `sched_id` int(11) DEFAULT NULL,
  `lgn_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbldoctor`
--

INSERT INTO `tbldoctor` (`doc_id`, `doc_fname`, `doc_lname`, `doc_birthdate`, `doc_email`, `doc_contact`, `sched_id`, `lgn_id`) VALUES
(121, 'Micah Kristine', 'Anaya', NULL, 'micahanaya09@gmail.com', 2147483647, NULL, 22);

-- --------------------------------------------------------

--
-- Table structure for table `tbllogin`
--

CREATE TABLE `tbllogin` (
  `lgn_id` int(11) NOT NULL,
  `lgn_username` varchar(255) NOT NULL,
  `lgn_password` varchar(100) NOT NULL,
  `user_type` enum('doctor','admin') NOT NULL,
  `sys_pass` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbllogin`
--

INSERT INTO `tbllogin` (`lgn_id`, `lgn_username`, `lgn_password`, `user_type`, `sys_pass`) VALUES
(22, 'mikaaa', '$2y$10$7UWjvQ6f4DiPixGNsRL/m.B4I8TO.qrUUAFjL95qoUZ.7Ei0l3W72', 'doctor', 0),
(23, 'micah', '$2y$10$4D9VVSqOsOi9cX5ByzFcQ.WSenhTP0tKtsuYlkOnhRNh7XT5Wm.ii', 'admin', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblpatient`
--

CREATE TABLE `tblpatient` (
  `ptn_id` int(11) NOT NULL,
  `ptn_fname` varchar(100) NOT NULL,
  `ptn_lname` varchar(100) NOT NULL,
  `ptn_birthdate` date NOT NULL,
  `ptn_gender` varchar(30) NOT NULL,
  `ptn_contact` int(30) NOT NULL,
  `ptn_email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblschedule`
--

CREATE TABLE `tblschedule` (
  `sched_id` int(11) NOT NULL,
  `sched_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `sched_limit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblservice`
--

CREATE TABLE `tblservice` (
  `serv_id` int(11) NOT NULL,
  `serv_name` varchar(100) NOT NULL,
  `serv_desc` varchar(255) DEFAULT NULL,
  `serv_category` varchar(100) NOT NULL,
  `serv_duration` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`adm_id`),
  ADD KEY `lgn_id` (`lgn_id`);

--
-- Indexes for table `tblappoint`
--
ALTER TABLE `tblappoint`
  ADD PRIMARY KEY (`apt_id`),
  ADD KEY `ptn_id` (`ptn_id`),
  ADD KEY `doc_id` (`doc_id`),
  ADD KEY `serv_id` (`serv_id`);

--
-- Indexes for table `tbldoctor`
--
ALTER TABLE `tbldoctor`
  ADD PRIMARY KEY (`doc_id`),
  ADD KEY `sched_id` (`sched_id`),
  ADD KEY `lgn_id` (`lgn_id`);

--
-- Indexes for table `tbllogin`
--
ALTER TABLE `tbllogin`
  ADD PRIMARY KEY (`lgn_id`);

--
-- Indexes for table `tblpatient`
--
ALTER TABLE `tblpatient`
  ADD PRIMARY KEY (`ptn_id`);

--
-- Indexes for table `tblschedule`
--
ALTER TABLE `tblschedule`
  ADD PRIMARY KEY (`sched_id`);

--
-- Indexes for table `tblservice`
--
ALTER TABLE `tblservice`
  ADD PRIMARY KEY (`serv_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `adm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5003;

--
-- AUTO_INCREMENT for table `tblappoint`
--
ALTER TABLE `tblappoint`
  MODIFY `apt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108401;

--
-- AUTO_INCREMENT for table `tbldoctor`
--
ALTER TABLE `tbldoctor`
  MODIFY `doc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `tbllogin`
--
ALTER TABLE `tbllogin`
  MODIFY `lgn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tblpatient`
--
ALTER TABLE `tblpatient`
  MODIFY `ptn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1111;

--
-- AUTO_INCREMENT for table `tblschedule`
--
ALTER TABLE `tblschedule`
  MODIFY `sched_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=211;

--
-- AUTO_INCREMENT for table `tblservice`
--
ALTER TABLE `tblservice`
  MODIFY `serv_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4321;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD CONSTRAINT `tbladmin_ibfk_1` FOREIGN KEY (`lgn_id`) REFERENCES `tbllogin` (`lgn_id`);

--
-- Constraints for table `tblappoint`
--
ALTER TABLE `tblappoint`
  ADD CONSTRAINT `tblappoint_ibfk_1` FOREIGN KEY (`ptn_id`) REFERENCES `tblpatient` (`ptn_id`),
  ADD CONSTRAINT `tblappoint_ibfk_2` FOREIGN KEY (`doc_id`) REFERENCES `tbldoctor` (`doc_id`),
  ADD CONSTRAINT `tblappoint_ibfk_3` FOREIGN KEY (`serv_id`) REFERENCES `tblservice` (`serv_id`);

--
-- Constraints for table `tbldoctor`
--
ALTER TABLE `tbldoctor`
  ADD CONSTRAINT `tbldoctor_ibfk_1` FOREIGN KEY (`sched_id`) REFERENCES `tblschedule` (`sched_id`),
  ADD CONSTRAINT `tbldoctor_ibfk_2` FOREIGN KEY (`lgn_id`) REFERENCES `tbllogin` (`lgn_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
