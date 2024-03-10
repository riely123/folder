-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2024 at 04:56 PM
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
-- Database: `lunario_log_register`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `First_Name` varchar(255) NOT NULL,
  `Last_Name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `contact` int(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`First_Name`, `Last_Name`, `address`, `country`, `contact`, `email`, `password`) VALUES
('lunario', 'riely', '', '', 0, 'rielymedrano@gmail.com', '$2y$10$dmI5ehMBHnoL1gj.jm3f7uNDNEbnKeToyBwYYLn1RP/4GxWVh00aG'),
('lunario', 'riely', '', '', 0, 'rielylunario@yahoo.com', '$2y$10$.B1P/D7Ha17dWWXnZjuNc.MBHTzY0vLY/6g.5nr2yR5himfbJ0gn2'),
('lunario', 'riely', '', 'PH', 2147483647, 'jenaseksi@gmail.com', '$2y$10$2e01zzJDYrOjxXstTwKs8uc09yalB1kPkUa/u6xBJHCTAh7DHQkIu'),
('lunario', 'riely', '', 'PH', 2147483647, 'rielylunario@gmail.com', '$2y$10$ANtX8F/mdoWhrhsxV.rxiusfdHqJB938Y.YjeM.9jVKl2Ef5W2BEa');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
