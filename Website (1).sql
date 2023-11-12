-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 11, 2023 at 05:38 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Website`
--

-- --------------------------------------------------------

--
-- Table structure for table `Admins`
--

CREATE TABLE `Admins` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `dob` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Admins`
--

INSERT INTO `Admins` (`admin_id`, `username`, `password`, `name`, `dob`) VALUES
(1, '2022UCM2386', 'johncena', 'Aman Kumar', '2003-08-02');

-- --------------------------------------------------------

--
-- Table structure for table `Complaints`
--

CREATE TABLE `Complaints` (
  `complaint_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `complaint_text` longtext DEFAULT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `complaint_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `complaint_status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Complaints`
--

INSERT INTO `Complaints` (`complaint_id`, `user_id`, `complaint_text`, `photo_path`, `complaint_date`, `complaint_status`) VALUES
(4, 33, 'Shubh Deepawali', 'uploads/35B49A22-7F74-4ABF-917F-67BF81D6EA0A_1_201_a (1).png', '2023-11-11 15:42:45', 'green'),
(6, 34, 'Powr Rangers mystic force', 'uploads/a-girl-with-young-blue-eyes-blonde-hairs-cute-an (1).jpg', '2023-11-11 16:04:22', 'yellow'),
(7, 37, 'Hare Krsna', 'uploads/Create-an-image-representing-the-Chandrayaan-3-space-mission-by-India--The-image-should-capture-the-excitement-and-energy-of-the-mission--with-a-rocket-launching-into-the-starry-night-sky--The-rocket-.png', '2023-11-11 16:16:44', 'yellow');

-- --------------------------------------------------------

--
-- Table structure for table `Email`
--

CREATE TABLE `Email` (
  `email_id` int(11) NOT NULL,
  `email_address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Email`
--

INSERT INTO `Email` (`email_id`, `email_address`) VALUES
(32, 'afFSSA@gmail.com'),
(31, 'aman922003@gmail.com'),
(30, 'aniketrathore9361@gmail.com'),
(33, 'thisisaman408@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `Mobile`
--

CREATE TABLE `Mobile` (
  `mobile_id` int(11) NOT NULL,
  `mobile_number` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Mobile`
--

INSERT INTO `Mobile` (`mobile_id`, `mobile_number`) VALUES
(38, '7428576490'),
(37, '7428576491'),
(36, '8750078301'),
(35, '8882280136');

-- --------------------------------------------------------

--
-- Table structure for table `Name`
--

CREATE TABLE `Name` (
  `name_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Name`
--

INSERT INTO `Name` (`name_id`, `first_name`, `middle_name`, `last_name`) VALUES
(35, 'Aniket Singh Rathore', '', ''),
(36, 'Aman Verma', NULL, NULL),
(37, 'Ekaankar', NULL, NULL),
(38, 'Aman Kumar', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `UserDetails`
--

CREATE TABLE `UserDetails` (
  `user_id` int(11) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `last_login` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `UserDetails`
--

INSERT INTO `UserDetails` (`user_id`, `date_of_birth`, `last_login`) VALUES
(33, '2003-08-26', '2023-11-06 05:08:23'),
(34, '2003-12-29', '2023-11-07 05:24:17'),
(35, '2000-12-12', '2023-11-07 07:50:53'),
(37, '2003-08-04', '2023-11-11 16:15:27');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name_id` int(11) DEFAULT NULL,
  `email_id` int(11) DEFAULT NULL,
  `mobile_id` int(11) DEFAULT NULL,
  `profile_pic_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`user_id`, `username`, `password`, `name_id`, `email_id`, `mobile_id`, `profile_pic_id`) VALUES
(33, 'aniket', 'aniket', 35, 30, 35, NULL),
(34, 'aman92', 'aman', 36, 31, 36, NULL),
(35, 'ekankar', 'aman', 37, 32, 37, NULL),
(37, 'thisisaman408', 'aman', 38, 33, 38, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Admins`
--
ALTER TABLE `Admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `Complaints`
--
ALTER TABLE `Complaints`
  ADD PRIMARY KEY (`complaint_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `Email`
--
ALTER TABLE `Email`
  ADD PRIMARY KEY (`email_id`),
  ADD UNIQUE KEY `unique_email` (`email_address`);

--
-- Indexes for table `Mobile`
--
ALTER TABLE `Mobile`
  ADD PRIMARY KEY (`mobile_id`),
  ADD UNIQUE KEY `unique_mobile` (`mobile_number`);

--
-- Indexes for table `Name`
--
ALTER TABLE `Name`
  ADD PRIMARY KEY (`name_id`);

--
-- Indexes for table `UserDetails`
--
ALTER TABLE `UserDetails`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `name_id` (`name_id`),
  ADD KEY `email_id` (`email_id`),
  ADD KEY `mobile_id` (`mobile_id`),
  ADD KEY `FK_ProfilePicture` (`profile_pic_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Admins`
--
ALTER TABLE `Admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Complaints`
--
ALTER TABLE `Complaints`
  MODIFY `complaint_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `Email`
--
ALTER TABLE `Email`
  MODIFY `email_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `Mobile`
--
ALTER TABLE `Mobile`
  MODIFY `mobile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `Name`
--
ALTER TABLE `Name`
  MODIFY `name_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Complaints`
--
ALTER TABLE `Complaints`
  ADD CONSTRAINT `complaints_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`);

--
-- Constraints for table `Users`
--
ALTER TABLE `Users`
  ADD CONSTRAINT `FK_ProfilePicture` FOREIGN KEY (`profile_pic_id`) REFERENCES `ProfilePictures` (`profile_pic_id`),
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`name_id`) REFERENCES `Name` (`name_id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`email_id`) REFERENCES `Email` (`email_id`),
  ADD CONSTRAINT `users_ibfk_3` FOREIGN KEY (`mobile_id`) REFERENCES `Mobile` (`mobile_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
