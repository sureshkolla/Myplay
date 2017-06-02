-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2017 at 04:43 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_studentapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `cetegory_name` varchar(100) NOT NULL,
  `createdon` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `cetegory_name`, `createdon`, `status`) VALUES
(1, 'Movie', '', 1),
(2, 'Music', '', 1),
(3, 'Sport', '', 1),
(4, 'Fashion', '', 1),
(5, 'Education', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `uploadvideo`
--

CREATE TABLE `uploadvideo` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `category` int(11) NOT NULL,
  `url` varchar(100) NOT NULL,
  `description` varchar(250) NOT NULL,
  `owner` int(11) NOT NULL,
  `createdon` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uploadvideo`
--

INSERT INTO `uploadvideo` (`id`, `title`, `category`, `url`, `description`, `owner`, `createdon`, `status`) VALUES
(1, 'managers1', 5, 'MSNYzz4Khuk', 'Slim', 1, '2017/05/31 04:05:25', 1),
(2, 'autocomplete', 5, 'kt2hWLZNO9c', 'notliked', 1, '2017/06/01 10:06:53', 1),
(5, 'Best music with videos', 2, 'u6p6dubzHAc', 'Best music with videos', 1, '2017/06/02 12:06:37', 1),
(6, 'regional Music', 2, 'JVPw-THFCCo', 'regional Music', 1, '2017/06/02 12:06:01', 1),
(7, 'pub music', 2, 'kJQP7kiw5Fk', 'pub music', 1, '2017/06/02 12:06:25', 1),
(8, 'Khaleed Music', 2, 'weeI1G46q0o', 'Khaleed Music', 1, '2017/06/02 12:06:49', 1),
(9, 'Class of clan', 3, 'bSyYEzITzCw', 'Class of clan', 1, '2017/06/02 12:06:24', 1),
(10, 'Brave of the break', 3, 'RyaS4oE3I-8', 'Brave of the break', 1, '2017/06/02 12:06:41', 1),
(13, 'world passion', 4, 'MG9lTjvJm7Q', 'world passion', 1, '2017/06/02 12:06:15', 1),
(14, 'rate of rare', 4, '0rRMePZ2gGU', 'rate of rare', 1, '2017/06/02 12:06:38', 1),
(15, 'New action best 2017', 1, 'QHW_cfv_y1w', 'New action best 2017', 1, '2017/06/02 12:06:09', 1),
(16, 'Adventure movei', 1, 'AN2yIY0LNxE', 'Adventure movei', 1, '2017/06/02 12:06:48', 1);

-- --------------------------------------------------------

--
-- Table structure for table `userplaylist`
--

CREATE TABLE `userplaylist` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `videoid` int(11) NOT NULL,
  `createdon` char(100) NOT NULL,
  `status` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userplaylist`
--

INSERT INTO `userplaylist` (`id`, `userid`, `videoid`, `createdon`, `status`) VALUES
(1, 1, 1, '2017/06/02 09:06:33', 1),
(2, 1, 4, '2017/06/02 09:06:18', 0),
(3, 1, 2, '2017/06/02 11:06:32', 0),
(4, 4, 1, '2017/06/02 12:06:20', 1),
(5, 4, 2, '2017/06/02 12:06:22', 1),
(6, 4, 5, '2017/06/02 12:06:36', 1),
(7, 5, 1, '2017/06/02 12:06:03', 1),
(8, 5, 2, '2017/06/02 12:06:40', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `age` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `api_key` varchar(100) NOT NULL,
  `createdon` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `age`, `username`, `password`, `gender`, `api_key`, `createdon`, `status`) VALUES
(1, 'Suresh', 'babu', '33', 'user', '21232f297a57a5a743894a0e4a801fc3', 'male', 'bac6e92ea9b4498e7a197a7c0a4b67a3', '2017/05/30 02:05:01', 1),
(4, 'Suresh1', 'babu1', '33', 'user1', '21232f297a57a5a743894a0e4a801fc3', 'male', 'bac6e92ea9b4498e7a197a7c0a4b67a3', '2017/05/30 02:05:01', 1),
(5, 'reddy', 'babu', '23', 'user2', '21232f297a57a5a743894a0e4a801fc3', 'male', 'd2299e7690b273f76e9eae0bcff3842a', '2017/06/02 12:06:44', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uploadvideo`
--
ALTER TABLE `uploadvideo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userplaylist`
--
ALTER TABLE `userplaylist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `uploadvideo`
--
ALTER TABLE `uploadvideo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `userplaylist`
--
ALTER TABLE `userplaylist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
