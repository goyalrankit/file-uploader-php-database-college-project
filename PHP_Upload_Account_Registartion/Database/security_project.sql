-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 19, 2020 at 04:50 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `security_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `pay` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `name`, `date`, `location`, `pay`, `contact`) VALUES
(1002, 'York Mall', '20-12-2020', 'York', '17', '416-414-1945'),
(1003, 'Kipling Mall', '30-12-2020', 'Kipling', '20', '416-416-1800\r\n'),
(1004, 'Eaton Center', '01-01-2021', 'Downtown', '19', '473-400-6000\r\n'),
(1005, 'York Mall', '20-12-2020', 'York', '17', '416-414-1945\r\n'),
(1007, 'RBC Bank', '22-01-2021', 'Malton', '18.25', '478-437-1453'),
(1009, 'Kipling Mall', '30-02-2021', 'Kipling', '20', '416-416-1800\r\n'),
(1017, 'No Frills', '20-01-2021', 'Etobicoke', '14.25', '416-416-6666\r\n'),
(1019, 'Driving School', '01-02-2021', 'Downtown', '19', '473-400-6000\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `cpassword` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `email`, `password`, `cpassword`, `username`, `phone`, `token`) VALUES
(7, 'goyalrankit@outlook.com', '$2y$10$gOoU74TGFPVS6xtVBYdxpenC16b/35EymO5CpDFjoGrsg6rv84iRS', '$2y$10$H8HNTSeYMqagIOD3Mgc1puuyPQWnAQA0KOxWlqAujp3ref0ebu2Ke', 'Rankit', '(437)248-0662', ''),
(9, 'ran@gmail.com', '$2y$10$E5WFj3FtQkoejVkUSbbvsOwsU0qiJhxvnpgVsxqWtS6ASCM95dBMe', '$2y$10$Omn7MRzKYnMnByVIMkllkOH7OQmHCg2Y72DC9HoT1kIVuonkk5eH2', 'Rankit Goyal', '4372480662', ''),
(13, 'goyalrankit@outlook', '$2y$10$Pw0dR3i7YfkxpTPGKnVSse8SxBxESVdwV/lSw7Q2oIpBxF6ITXfIi', '$2y$10$XuerOCVo.3D9ZXLcaSWxZ.5HL5uBHCzzlL1tBkPn.FOWhIWyyLBc2', 'Rankit Goyal', '4372480662', ''),
(14, 'admin@admin.com', '$2y$10$HLKnNzEmyhBLKlR4Im4b4O9SJvGgt387Z3HyC1n2BxXn7MrGmlLta', '$2y$10$bAumxBaeuOz7/ZvQshZMsOLyOzEwDKjNBQGvDI6ioQV28/3lOvKKu', 'Admin', '1234567890', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` varchar(255) NOT NULL,
  `jobid` int(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `jobid`, `fname`, `lname`, `location`, `gender`, `contact`) VALUES
('102', 1007, 'Navdeep', 'Singh', 'Malton', 'Male', '4512\r\n'),
('108', 1003, 'Rankit', 'Goyal', 'Etobicoke', 'Male', '451-416-9090\r\n'),
('110', 1005, 'Rahul', 'Garg', 'Malton', 'Male', '416-437-0000'),
('111', 1002, 'Ali', 'Khan', 'Etobicoke', 'Male', '400-165-9014\r\n'),
('112', 1007, 'NAzy', 'William', 'Malton', 'Male', '416-146-1616\r\n'),
('113', 1017, 'Peter', 'Parker', 'Brampton', 'Male', '412-521-6060\r\n'),
('118', 1019, 'John', 'Smith', 'Etobicoke', 'Male', '451-416-9090\r\n'),
('120', 1009, 'Alex', 'Alex', 'Malton', 'Male', '416-437-0000');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`),
  ADD KEY `user_job_f` (`jobid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `user_job_f` FOREIGN KEY (`jobid`) REFERENCES `jobs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
