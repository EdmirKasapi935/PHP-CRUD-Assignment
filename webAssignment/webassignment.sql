-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2024 at 08:25 PM
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
-- Database: `webassignment`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `Username` varchar(64) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `RegistrationDate` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `Username`, `Password`, `RegistrationDate`) VALUES
(3, 'mark', 'a42517d09dcaeb6462ab8075dd673294', '2024-05-22'),
(4, 'sundowner', '7f7e295fc8e47d1090d2a991df11e28a', '2024-05-22');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `vehicleID` int(11) NOT NULL,
  `licenseplate` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `seats` int(11) NOT NULL,
  `transmission` varchar(50) NOT NULL,
  `imgsrc` varchar(255) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`vehicleID`, `licenseplate`, `brand`, `model`, `category`, `seats`, `transmission`, `imgsrc`, `price`) VALUES
(17, 'CRO451', 'Skoda', 'Octavia', 'Sedan', 4, 'Automatic', 'C:/xampp/htdocs/webAssignment/admin/uploads/bandit_with_a_gun.png', 3000),
(18, 'RMM123', 'Dodge', 'Viper', 'Sports Car', 2, 'Automatic', 'C:/xampp/htdocs/webAssignment/admin/uploads/crabmob.png', 4500),
(19, 'GAM433', 'Ford', 'Mustang', 'Sports Car', 4, 'Manual', 'C:/xampp/htdocs/webAssignment/admin/uploads/village_leader.png', 3100),
(20, 'AMG787', 'Mercedes', 'AMG', 'Sedan', 5, 'Manual', 'C:/xampp/htdocs/webAssignment/admin/uploads/generic_villager_pack_1.png', 1900);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`vehicleID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `vehicleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
