-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 07, 2021 at 04:49 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bbms`
--

-- --------------------------------------------------------

--
-- Table structure for table `donate_blood`
--

CREATE TABLE `donate_blood` (
  `don_id` int(11) NOT NULL,
  `don_id_ref` int(11) NOT NULL,
  `donor_name` varchar(50) NOT NULL,
  `donor_blood_group` varchar(5) NOT NULL,
  `donor_hospital` varchar(50) NOT NULL,
  `donation_reason` varchar(20) NOT NULL,
  `donor_date` varchar(20) NOT NULL,
  `donor_city` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `donate_blood`
--

INSERT INTO `donate_blood` (`don_id`, `don_id_ref`, `donor_name`, `donor_blood_group`, `donor_hospital`, `donation_reason`, `donor_date`, `donor_city`) VALUES
(1, 2, 'Innocent Shata', 'B+', 'Arthur Davison Children Hospital', 'Felt the Need', '4/4/2021', 'Ndola'),
(2, 2, 'Innocent Shata', 'B+', 'Ndola Central', 'Anniversary', '6/4/2021', 'Ndola'),
(3, 2, 'Innocent Shata', 'B+', 'Ndola Central', 'Felt the Need', '5/4/2021', 'Ndola');

-- --------------------------------------------------------

--
-- Table structure for table `hospital_tbl`
--

CREATE TABLE `hospital_tbl` (
  `hosp_id` int(100) NOT NULL,
  `hosp_name` varchar(100) NOT NULL,
  `hosp_city` varchar(50) NOT NULL,
  `hosp_location` varchar(100) NOT NULL,
  `hosp_address` varchar(100) NOT NULL,
  `hosp_lat` float(10,6) NOT NULL,
  `hosp_long` float(10,6) NOT NULL,
  `hosp_username` varchar(50) DEFAULT NULL,
  `hosp_password` varchar(50) NOT NULL DEFAULT '1234'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hospital_tbl`
--

INSERT INTO `hospital_tbl` (`hosp_id`, `hosp_name`, `hosp_city`, `hosp_location`, `hosp_address`, `hosp_lat`, `hosp_long`, `hosp_username`, `hosp_password`) VALUES
(1, 'Kabwe Central', 'Kabwe', 'Mining Area', 'kabwe Central', -14.434260, 28.429689, 'kabwe_cen_admin', '1234'),
(2, 'Ndola Central', 'Ndola', 'Ndola Central', 'New Street', -12.969400, 28.635799, 'ndola_cen_admin', '1234'),
(3, 'University Teaching Hospital', 'Lusaka', 'CHAINAMA  HILLSA', 'LWH CHAINAMA', -15.430010, 28.307501, 'uth_admin', '1234'),
(4, 'Kitwe Central', 'Kitwe', 'KITWE', 'KT', -12.797130, 28.211500, 'kitwe_cen_admin', '1234'),
(5, 'Kabwe Mining Hospital', 'Kabwe', 'Chowa', 'Chowa Street', -14.447547, 28.449699, 'kabwe_min_admin', '1234'),
(6, 'Arthur Davison Children Hospital', 'Ndola', 'Northrise', 'New Street', -12.930540, 28.650579, 'adch_admin', '1234'),
(7, 'Northern Command Military Hospital', 'Ndola', 'Itawa', 'Airport Road', -12.988763, 28.675987, 'ncmh_admin', '1234'),
(8, 'Levy Mwanawasa University Teaching Hospital', 'Lusaka', 'Munali', '1st', -15.382160, 28.363819, 'lmuth_admin', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `request_tbl`
--

CREATE TABLE `request_tbl` (
  `req_id` int(11) NOT NULL,
  `requester_id` int(11) NOT NULL,
  `requesting_id` int(11) NOT NULL,
  `request_blood_group` varchar(10) NOT NULL,
  `requested_city` varchar(100) NOT NULL,
  `requested_hosp` varchar(200) NOT NULL,
  `request_status` enum('waiting','accepted','rejected') NOT NULL DEFAULT 'waiting',
  `reasonForBlood` text DEFAULT NULL,
  `request_date` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `request_tbl`
--

INSERT INTO `request_tbl` (`req_id`, `requester_id`, `requesting_id`, `request_blood_group`, `requested_city`, `requested_hosp`, `request_status`, `reasonForBlood`, `request_date`) VALUES
(1, 2, 1, 'B+', 'Ndola', 'Ndola Central', 'accepted', NULL, '5/4/2021');

-- --------------------------------------------------------

--
-- Table structure for table `users_tbl`
--

CREATE TABLE `users_tbl` (
  `user_id` int(255) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_number` varchar(100) DEFAULT NULL,
  `physical_address` varchar(100) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `type_of_user` varchar(100) DEFAULT NULL,
  `blood_group` varchar(10) DEFAULT NULL,
  `why_give_blood` text DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `province` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_tbl`
--

INSERT INTO `users_tbl` (`user_id`, `name`, `email`, `phone_number`, `physical_address`, `password`, `type_of_user`, `blood_group`, `why_give_blood`, `city`, `province`) VALUES
(1, 'Paul Kinda', 'visionaryminds24@gmail.com', '0972157418', 'new mushili', '1234', 'receiver', 'A+', NULL, 'Ndola', 'Copperbelt'),
(2, 'Innocent Shata', 'pkunda24@gmail.com', '0972157419', 'new', '1234', 'donor', 'B+', NULL, 'Ndola', 'Copperbelt');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `donate_blood`
--
ALTER TABLE `donate_blood`
  ADD PRIMARY KEY (`don_id`);

--
-- Indexes for table `hospital_tbl`
--
ALTER TABLE `hospital_tbl`
  ADD PRIMARY KEY (`hosp_id`);

--
-- Indexes for table `request_tbl`
--
ALTER TABLE `request_tbl`
  ADD PRIMARY KEY (`req_id`);

--
-- Indexes for table `users_tbl`
--
ALTER TABLE `users_tbl`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `donate_blood`
--
ALTER TABLE `donate_blood`
  MODIFY `don_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hospital_tbl`
--
ALTER TABLE `hospital_tbl`
  MODIFY `hosp_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `request_tbl`
--
ALTER TABLE `request_tbl`
  MODIFY `req_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users_tbl`
--
ALTER TABLE `users_tbl`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
