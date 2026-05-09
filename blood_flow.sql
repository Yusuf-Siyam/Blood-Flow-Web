-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2026 at 07:30 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blood_flow`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `content`, `image`, `created_at`) VALUES
(1, 'Why Donate Blood?', 'Donating blood saves lives. Every drop counts and can help someone in an emergency.', 'blog1.jpg', '2026-05-04 11:23:02'),
(2, 'Fitness and Blood Donation', 'You can donate blood even if you work out. Just make sure to stay hydrated and rest.', 'blog2.jpg', '2026-05-04 11:23:02'),
(3, 'Post-Donation Care', 'After donating blood, drink plenty of fluids and avoid heavy lifting for 24 hours.', 'blog3.jpg', '2026-05-04 11:23:02');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `recipient_name` varchar(100) NOT NULL,
  `blood_group` varchar(5) NOT NULL,
  `location` varchar(255) NOT NULL,
  `hospital` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `message` text DEFAULT NULL,
  `status` enum('pending','approved','accepted','verified','completed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `donor_name` varchar(100) DEFAULT NULL,
  `donor_contact` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `user_id`, `recipient_name`, `blood_group`, `location`, `hospital`, `date`, `time`, `message`, `status`, `created_at`, `donor_name`, `donor_contact`) VALUES
(2, 1, 'Sanjana Kabir', 'O+', 'Chittagong', 'Apollo Hospital', '2026-05-12', '14:30:00', 'Need O+ blood urgently.', '', '2026-05-04 11:23:24', 'siyam', 'mdsiyam1011@gmail.com'),
(3, 1, 'Rahat Khan', 'B+', 'Dhaka, Uttara', 'Evercare Hospital', '2026-05-15', '09:00:00', 'B+ blood needed for a patient.', '', '2026-05-04 11:23:24', 'siyam', 'mdsiyam10115555@gmail.com'),
(5, 2, 'siyam mia Donor', 'O+', 'united', 'RMC', '2026-05-09', '22:03:00', 'freeee', '', '2026-05-04 12:00:26', 'siyam', 'mdsiyam1011@gmail.com'),
(6, 1, 'siyam mia Donor', 'O-', 'united', 'RMC', '2026-05-09', '04:14:00', 'hi i am siyam', '', '2026-05-04 16:09:24', 'siyam', 'mdsiyam10115555@gmail.com'),
(7, 3, 'siyam mia Donor', 'O-', 'united', 'RMC', '2026-05-09', '13:20:00', 'hi', '', '2026-05-04 16:16:51', 'siyam', 'mdsiyam1011555500000@gmail.com'),
(8, 2, 'siyam mia Donor', 'A+', 'united medical', 'RMC', '2026-05-09', '14:22:00', 'fdsf', '', '2026-05-04 16:18:04', 'siyam', 'mdsiyam10115555@gmail.com'),
(9, 3, 'siyam mia ', 'B+', 'united medical', 'RMC', '2026-05-09', '14:22:00', 'hi new fixed', '', '2026-05-04 16:23:11', 'siyam', 'mdsiyam10115555@gmail.com'),
(10, 1, 'Rakib Hossain', 'A+', 'Dhaka', 'Dhaka Medical', '2026-05-10', '10:00:00', 'Emergency needed for surgery.', '', '2026-05-04 16:35:23', 'siyam', 'mdsiya0000@gmail.com'),
(11, 1, 'Sumaiya Akter', 'B-', 'Dhanmondi', 'Square Hospital', '2026-05-12', '14:30:00', 'Thalassemia patient.', 'verified', '2026-05-04 16:35:23', 'siyam', 'mdsiyam1011@gmail.com'),
(12, 1, 'Abdur Rahman', 'O+', 'Gulshan', 'United Hospital', '2026-05-15', '09:00:00', 'Urgent O+ blood.', '', '2026-05-04 16:35:23', 'Siyam Ahmed', '01711223344'),
(13, 1, 'Fatima Khatun', 'AB+', 'Bashundhara', 'Apollo Hospital', '2026-05-18', '11:00:00', 'Needed for operation.', '', '2026-05-04 16:35:23', 'Karim Ullah', 'karim@email.com'),
(14, 1, 'Sanjana', 'B+', 'Dhaka', 'LabAid', '2026-05-20', '16:00:00', 'Blood found and verified.', '', '2026-05-04 16:35:23', 'Yusuf Siyam', '01888776655'),
(15, 1, 'MD. Rahim', 'A+', 'Dhaka', 'Dhaka Medical', '2026-05-10', '10:00:00', 'Emergency surgery case.', 'verified', '2026-05-04 16:42:06', 'siyam', 'mdsiyam1011@gmail.com'),
(16, 1, 'Sultana Razia', 'O-', 'Dhanmondi', 'Square Hospital', '2026-05-12', '14:30:00', 'Accident patient.', 'verified', '2026-05-04 16:42:06', 'siyam', 'mdsiya0000@gmail.com'),
(17, 1, 'Kamal Ahmed', 'B+', 'Kalyanpur', 'Ibn Sina', '2026-05-15', '09:00:00', 'Urgent B+ required.', 'verified', '2026-05-04 16:42:06', 'Yusuf Siyam', '01711223344'),
(18, 1, 'Jannatun Nesa', 'AB-', 'Bashundhara', 'Evercare', '2026-05-18', '11:00:00', 'Thalassemia treatment.', 'verified', '2026-05-04 16:42:06', 'Sanjana', 'sanjana@email.com'),
(19, 1, 'Tarek Hasan', 'O+', 'Dhanmondi', 'LabAid', '2026-05-20', '16:00:00', 'Blood matched.', 'verified', '2026-05-04 16:42:06', 'Md. Sakib', '01888776655'),
(20, 1, 'Rakib Hossain', 'A+', 'Dhaka', 'Dhaka Medical', '2026-05-10', '10:00:00', 'Emergency needed for surgery.', 'verified', '2026-05-04 17:21:11', 'siyam', 'mdsiyam1011@gmail.com'),
(21, 2, 'Sumaiya Akter', 'B-', 'Dhanmondi', 'Square Hospital', '2026-05-12', '14:30:00', 'Thalassemia patient.', 'verified', '2026-05-04 17:21:11', 'siyam', 'mdsiyam1011@gmail.com'),
(22, 1, 'Abdur Rahman', 'O+', 'Gulshan', 'United Hospital', '2026-05-15', '09:00:00', 'Urgent O+ blood.', 'accepted', '2026-05-04 17:21:11', 'Siyam Ahmed', '01711223344'),
(23, 2, 'Fatima Khatun', 'AB+', 'Bashundhara', 'Apollo Hospital', '2026-05-18', '11:00:00', 'Needed for operation.', 'verified', '2026-05-04 17:21:11', 'Karim Ullah', 'karim@email.com'),
(24, 2, 'Sanjana', 'B+', 'Dhaka', 'LabAid', '2026-05-20', '16:00:00', 'Blood found and verified.', 'verified', '2026-05-04 17:21:11', 'Yusuf Siyam', '01888776655'),
(25, 1, 'siyam mia ', 'A-', 'united medical', 'RMC', '2026-05-09', '15:23:00', 'hi', 'approved', '2026-05-04 17:23:33', NULL, NULL),
(26, 1, 'Rakib Hossain', 'A+', 'Dhaka', 'Dhaka Medical', '2026-05-10', '10:00:00', 'Emergency needed for surgery.', 'accepted', '2026-05-04 17:25:37', 'siyam', 'mdsiyam1011@gmail.com'),
(27, 2, 'Sumaiya Akter', 'B-', 'Dhanmondi', 'Square Hospital', '2026-05-12', '14:30:00', 'Thalassemia patient.', 'accepted', '2026-05-04 17:25:37', 'siyam', 'mdsiyam1011@gmail.com'),
(28, 1, 'Rakib Hossain', 'A+', 'Dhaka', 'Dhaka Medical', '2026-05-10', '10:00:00', 'Emergency needed for surgery.', 'pending', '2026-05-04 17:25:44', NULL, NULL),
(29, 2, 'Sumaiya Akter', 'B-', 'Dhanmondi', 'Square Hospital', '2026-05-12', '14:30:00', 'Thalassemia patient.', 'pending', '2026-05-04 17:25:44', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('user','donor','admin') DEFAULT 'user',
  `nid_number` varchar(20) NOT NULL,
  `blood_group` varchar(5) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `last_donation_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `role`, `nid_number`, `blood_group`, `password`, `status`, `last_donation_date`, `created_at`) VALUES
(1, 'Siyam', 'mdsiyam1011@gmail.com', 'user', '1000000000', 'AB+', 'YSIYAM2003', 1, NULL, '2026-05-04 11:24:54'),
(2, 'Yusuf Siyam', 'mdsiyam2021@gmail.com', 'donor', '1000000001', 'A+', 'YSIYAM2003', 1, NULL, '2026-05-04 11:26:28'),
(3, 'Md Yusuf Siyam', 'adminsiyam@gmail.com', 'admin', '1234567890', 'AB+', 'YSIYAM2003', 1, NULL, '2026-05-04 11:44:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
