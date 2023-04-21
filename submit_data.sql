-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2023 at 05:50 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `submission`
--

-- --------------------------------------------------------

--
-- Table structure for table `submit_data`
--

CREATE TABLE `submit_data` (
  `UUID` int(255) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Phone_number` bigint(10) NOT NULL,
  `City` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `submit_data`
--

INSERT INTO `submit_data` (`UUID`, `Name`, `Phone_number`, `City`) VALUES
(1, 'chandan singh', 8854902370, 'udaipur');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `submit_data`
--
ALTER TABLE `submit_data`
  ADD PRIMARY KEY (`UUID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `submit_data`
--
ALTER TABLE `submit_data`
  MODIFY `UUID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
