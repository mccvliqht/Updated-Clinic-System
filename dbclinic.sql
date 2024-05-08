-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2024 at 02:35 AM
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
  `adm_contact` varchar(20) NOT NULL,
  `adm_email` varchar(50) DEFAULT NULL,
  `lgn_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`adm_id`, `adm_fname`, `adm_lname`, `adm_contact`, `adm_email`, `lgn_id`) VALUES
(5003, 'Micah', 'Anaya', '09817229282', 'micahanaya1009@gmail.com', 31);

-- --------------------------------------------------------

--
-- Table structure for table `tblappoint`
--

CREATE TABLE `tblappoint` (
  `apt_id` int(11) NOT NULL,
  `ptn_id` int(11) NOT NULL,
  `doc_id` int(11) NOT NULL,
  `serv_id` int(11) NOT NULL,
  `apt_time` time DEFAULT NULL,
  `apt_date` date DEFAULT NULL,
  `sched_status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblappoint`
--

INSERT INTO `tblappoint` (`apt_id`, `ptn_id`, `doc_id`, `serv_id`, `apt_time`, `apt_date`, `sched_status`) VALUES
(108402, 1114, 127, 4326, '00:00:01', '2024-05-15', ''),
(108403, 1115, 127, 4326, '08:30:00', '2024-05-15', ''),
(108404, 1116, 126, 4325, '00:00:10', '2024-05-11', ''),
(108405, 1117, 122, 4321, '04:00:00', '2024-05-10', ''),
(108406, 1118, 124, 4323, '03:30:00', '2024-05-13', ''),
(108407, 1119, 127, 4322, '08:30:00', '2024-05-15', ''),
(108408, 1120, 125, 4324, '12:00:00', '2024-05-14', ''),
(108409, 1122, 122, 4321, '03:00:00', '2024-05-10', ''),
(108410, 1126, 122, 4324, '03:00:00', '2024-05-10', ''),
(108411, 1127, 124, 4323, '08:30:00', '2024-05-15', ''),
(108412, 1128, 127, 4326, '01:00:00', '2024-05-15', ''),
(108413, 1129, 125, 4325, '10:00:00', '2024-05-14', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbldoctor`
--

CREATE TABLE `tbldoctor` (
  `doc_id` int(11) NOT NULL,
  `doc_fname` varchar(100) NOT NULL,
  `doc_lname` varchar(100) NOT NULL,
  `doc_spec` varchar(100) DEFAULT NULL,
  `doc_birthdate` date DEFAULT NULL,
  `doc_email` varchar(100) DEFAULT NULL,
  `doc_contact` varchar(20) NOT NULL,
  `lgn_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbldoctor`
--

INSERT INTO `tbldoctor` (`doc_id`, `doc_fname`, `doc_lname`, `doc_spec`, `doc_birthdate`, `doc_email`, `doc_contact`, `lgn_id`) VALUES
(122, 'George', 'Mendoza', 'Geriatrician', NULL, 'gmendoza@gmail.com', '9729163528', 24),
(123, 'Mateo', 'Cantiveros', 'Physician', NULL, 'mcantiveros@gmail.com', '9097251723', 25),
(124, 'Robert', 'Aquino', 'Cardiologist', NULL, 'raquino@gmail.com', '9873621034', 26),
(125, 'Maria Christine', 'Bondoc', 'Pediatrician', NULL, 'mcbondoc@gmail.com', '9026284521', 27),
(126, 'Carla', 'Mendez', 'Gastroenterologist', NULL, 'cmendez@gmail.com', '9821622453', 28),
(127, 'Luisa', 'Tanzo', 'Dentist', NULL, 'ltanzo@gmail.com', '9555728328', 29),
(129, 'Krizelle', 'Anaya', NULL, NULL, 'micahanaya09@gmail.com', '09817229282', 32);

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
(24, 'doc_mendoza', '$2y$10$ScZR.wEwLcmpOThIUz3hje/54dz5HwaqYVYKyVItilqHWGMKC5euC', 'doctor', 0),
(25, 'doc_cantiveros', '$2y$10$4AHTj5VdyRvToO63GHftq.1dJE9w7bgAbYvExysp.IPGntYyZpirG', 'doctor', 0),
(26, 'doc_aquino', '$2y$10$OGZKXGuNRuVD6Zy98OA4JeB.ek4eP4N8/NDyGrIMTi3BRGOtjF1im', 'doctor', 0),
(27, 'doc_bondoc', '$2y$10$H8sCJdk21D6Qtndi8MTwNe.JSSXcZGqWMIOUB74A0MXzUKNOHbJoq', 'doctor', 0),
(28, 'doc_mendez', '$2y$10$oDUt4w286TAjVHs.xsqEWuHK5GrlDT3XU1NijNrrLqAKHHQ6vjKLC', 'doctor', 0),
(29, 'doc_tanzo', '$2y$10$F94.0gjN0X1ja8gSFmJrYe5bjXdzQV2MZ0WwpkcXfwJI6/ezX.Rgu', 'doctor', 0),
(30, 'docmika', '$2y$10$RsEt/UoG3hEdHdJzHkL7w.CZcHr0vg0Yb5j7SL6BPmc0cH0KxNM.K', 'doctor', 0),
(31, 'adminmika', '$2y$10$rQB5snXeMIgmcWc7qLoNpOdXXq5iGyt7swFCO7LBjCq4Jhujq5CX.', 'admin', 0),
(32, 'krizelle', '$2y$10$V/Vg6bsceVDfpEwu4i.tyOpmLmLybWlUt7/n9B4b1Aep.FvKVgLKe', 'doctor', 0);

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
  `ptn_contact` bigint(30) NOT NULL,
  `ptn_email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblpatient`
--

INSERT INTO `tblpatient` (`ptn_id`, `ptn_fname`, `ptn_lname`, `ptn_birthdate`, `ptn_gender`, `ptn_contact`, `ptn_email`) VALUES
(1114, 'Jisoo', 'Kim', '1997-03-29', 'female', 9736183622, 'jisookim12@gmail.com'),
(1115, 'Chelsea', 'Jang', '2009-05-11', 'female', 9133862271, 'che@gmail.com'),
(1116, 'Chelsea', 'Jang', '2009-05-11', 'female', 9133862271, 'cgyf@gmail.com'),
(1117, 'Jisoo', 'Victoria', '1989-02-18', 'female', 9133863927, 'vic@gmail.com'),
(1118, 'Jisoo', 'Victoria', '1989-02-18', 'female', 9133863927, 'vc@gmail.com'),
(1119, 'Jisoo', 'Victoria', '1989-02-18', 'female', 9133863927, 'iic@gmail.com'),
(1120, 'Jisoo', 'Victoria', '1989-02-18', 'female', 9133863927, 'iiygc@gmail.com'),
(1121, 'Arjay', 'Yulip', '2024-02-06', 'male', 9133862028, 'jayjays@gmail.com'),
(1122, 'Arjay', 'Yulip', '2024-02-06', 'male', 9133862028, 'jss@gmail.com'),
(1123, 'Arjay', 'Mesiea', '2024-01-19', 'male', 9133863927, 'j32ay@gmail.com'),
(1124, 'Arjay', 'Mesiea', '2024-01-19', 'male', 9133863927, 'j3882ay@gmail.com'),
(1125, 'Arjay', 'Mesiea', '2024-01-19', 'male', 9133863927, 'jdiwydjwb@gmail.com'),
(1126, 'Arjay', 'Yulip', '2019-09-11', 'male', 9812517483, 'jay-m@gmail.com'),
(1127, 'Arjay', 'Jang', '2010-04-03', 'male', 9729461190, 'iiqsnsqs9@gmail.com'),
(1128, 'Wonyoung', 'Kim', '1991-05-29', 'female', 9736183911, 'qouw@gmail.com'),
(1129, 'Jang', 'Victoria', '1998-09-20', 'female', 9133863111, 'jangvic@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `tblschedule`
--

CREATE TABLE `tblschedule` (
  `sched_id` int(11) NOT NULL,
  `sched_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `sched_limit` int(11) NOT NULL,
  `doc_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblschedule`
--

INSERT INTO `tblschedule` (`sched_id`, `sched_date`, `start_time`, `end_time`, `sched_limit`, `doc_id`) VALUES
(211, '2024-05-09', '10:00:00', '17:00:00', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblservice`
--

CREATE TABLE `tblservice` (
  `serv_id` int(11) NOT NULL,
  `serv_name` varchar(100) NOT NULL,
  `serv_desc` varchar(255) DEFAULT NULL,
  `serv_duration` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblservice`
--

INSERT INTO `tblservice` (`serv_id`, `serv_name`, `serv_desc`, `serv_duration`) VALUES
(4321, 'Blood Test', 'Medical tests can be done on people of all ages to find problems, track treatments, and assess overall health, including checking blood cells, cholesterol levels, and detecting infections or illnesses.', '30 minutes'),
(4322, 'Vaccination', 'Vaccination not only protects individuals but also lowers the prevalence of infectious diseases, promoting public health and well-being for all people. Vaccines include Pneumonia, Anti-Rabies, and Birth Control.', '30 minutes'),
(4323, 'Minor Illness', 'Focuses on managing symptoms, alleviating discomfort, and supporting the body\'s natural healing process with the guidance of healthcare providers. Treatments include Cold, Flu, and Non-Severe asthma attack.', '30 minutes'),
(4324, 'Chronic Disease', 'The treating and controlling long-term health conditions like diabetes, involves coordinated efforts among healthcare providers in clinics to assist patients in managing their condition better.', '30 minutes'),
(4325, 'Ultrasound', 'Allows healthcare professionals to visualize internal structures such as detecting abnormalities in organs like the liver, kidneys, and fetal development during pregnancy and the heart.', '30 minutes'),
(4326, 'Dental', 'Oral health care services are provided by our Clinic which includes Regular check-ups, Cleaning, Whitening, Dental Crowns and Bridges.', '30 minutes');

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
  ADD PRIMARY KEY (`sched_id`),
  ADD KEY `fk_doc_id` (`doc_id`);

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
  MODIFY `adm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5004;

--
-- AUTO_INCREMENT for table `tblappoint`
--
ALTER TABLE `tblappoint`
  MODIFY `apt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108414;

--
-- AUTO_INCREMENT for table `tbldoctor`
--
ALTER TABLE `tbldoctor`
  MODIFY `doc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `tbllogin`
--
ALTER TABLE `tbllogin`
  MODIFY `lgn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `tblpatient`
--
ALTER TABLE `tblpatient`
  MODIFY `ptn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1130;

--
-- AUTO_INCREMENT for table `tblschedule`
--
ALTER TABLE `tblschedule`
  MODIFY `sched_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- AUTO_INCREMENT for table `tblservice`
--
ALTER TABLE `tblservice`
  MODIFY `serv_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4327;

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
-- Constraints for table `tblschedule`
--
ALTER TABLE `tblschedule`
  ADD CONSTRAINT `fk_doc_id` FOREIGN KEY (`doc_id`) REFERENCES `tbldoctor` (`doc_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
