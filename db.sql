-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2017 at 01:50 PM
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
(4, 'Fashion', '', 1);

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
(5, 'd', 1, 'yWEK4v9AVKQ', 'sd', 1, '2017/05/22 :15', 1),
(7, 'd', 2, '3AtDnEC4zak', 'sd', 1, '2017/05/22 :15 MayMay', 1),
(8, 'rtsdfg', 1, 'xv5E6vVEXNY', 'dff', 9, '2017/05/22 :15 MayMay', 1),
(9, 'wert', 1, 'ALZHF5UqnU4', 't', 9, '2017/05/23 :08 MayMay', 1),
(10, 'wert', 1, '2vMH8lITTCE', 't', 1, '2017/05/23 :08 MayMay', 1),
(11, 'tester', 1, 'ALZHF5UqnU4', 'des', 1, '2017/05/23 :08 MayMay', 1),
(12, 'tester', 1, '3AtDnEC4zak', 'des', 1, '2017/05/23 :08 MayMay', 1),
(13, 'dds', 1, 'xv5E6vVEXNY', '342323', 1, '2017/05/23 :10 MayMay', 1),
(14, 'manager', 1, '2vMH8lITTCE', 'tdescription', 1, '2017/05/23 :10 MayMay', 1),
(15, 'test for ckeditor', 1, 'yWEK4v9AVKQ', 'rerr', 1, '2017/05/23 :13 MayMay', 1),
(16, 'sas', 1, 'yWEK4v9AVKQ', 'asaas', 1, '2017/05/23 :13 MayMay', 1),
(18, 'sss', 1, 'hRC037_mHMs', 'desc', 1, '2017/05/23 :14 MayMay', 1),
(19, 'sss', 1, 'hRC037_mHMs', 'desc', 4, '2017/05/23 :14 MayMay', 1),
(20, 'tester', 4, 'LSw7K4RpTHo', 'doo', 1, '2017/05/24 :11 MayMay', 1),
(21, 'test for ckeditor', 4, 'UsDpUWaINcc', 'testing', 1, '2017/05/24 :15 MayMay', 1),
(22, 'test', 4, 'Qk2xaMguQUM', 'desc', 1, '2017/05/24 :16 MayMay', 1),
(23, 'manager', 3, '9_4lxnUyJLE', 'D', 1, '2017/05/24 :16 MayMay', 1),
(24, 'Bootstrap 3 Simple floating alert', 1, 'MSNYzz4Khuk', 'Description', 1, '2017/05/25 :08 MayMay', 1),
(25, 'test for ckeditor', 2, 'kt2hWLZNO9c', 'erer', 1, '2017/05/25 :08 MayMay', 1),
(26, 'test for ckeditor1', 2, '7YcW25PHnAA', 'erer', 1, '2017/05/25 :08 MayMay', 1),
(27, 'manager', 1, 'oBW_VNg4qD0', 'desc', 1, '2017/05/25 :08 MayMay', 1),
(28, 'dd', 1, 'oBW_VNg4qD01', 'desc', 1, '2017/05/25 :09 MayMay', 1),
(29, 'dd', 1, 'oBW_VNg4qD02', 'desc', 9, '2017/05/25 :09 MayMay', 1),
(30, 'manager', 3, 'o-', 'tester', 4, '2017/05/25 12:05:52', 1);

-- --------------------------------------------------------

--
-- Table structure for table `userplaylist`
--

CREATE TABLE `userplaylist` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `videoid` int(11) NOT NULL,
  `createdon` char(100) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userplaylist`
--

INSERT INTO `userplaylist` (`id`, `userid`, `videoid`, `createdon`, `status`) VALUES
(1, 4, 9, '2017/05/25 :10 MayMay', 1),
(2, 4, 19, '2017/05/25 1010:MayMay', 1),
(3, 4, 5, '2017/05/25 1010:0505', 1),
(4, 4, 7, '2017/05/25 10:05:14', 1),
(5, 4, 10, '2017/05/25 10:05:52', 1),
(6, 4, 9, '2017/05/25 11:05:41', 1),
(7, 4, 19, '2017/05/25 11:05:13', 1);

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
(1, 'belal', '', '', 'belal', '81dc9bdb52d04dc20036dbd8313ed055', '', '50addfeb14283e2568ca98e2a8ecf7f6', '', 0),
(2, 'Belal Khan', '', '', 'probelalkhan', '81dc9bdb52d04dc20036dbd8313ed055', '', '589d3d5ad22808e7cb54fd1ee2affd3c', '', 0),
(3, 'Vivek Raj', '', '', 'vivek', 'e2fc714c4727ee9395f324cd2e7f331f', '', '2d092996274be2edf7a0771ba427e134', '', 0),
(4, 'errer', '', '', 'admin', '21232f297a57a5a743894a0e4a801fc3', '', 'a235f51b418125451769a4700af8c4fd', '', 0),
(5, 'test', '', '', 'adminnme', '21232f297a57a5a743894a0e4a801fc3', '', 'f7c5664f490ab3b6a8f6b36762168494', '', 0),
(6, '', '', '', '', '', '', '', '', 0),
(7, '', '', '', '', '', '', '', '', 1),
(8, 'test', 'tset', '23', 'test123', '81dc9bdb52d04dc20036dbd8313ed055', '1', '7de41ce257c806ad11801fb534f4dd47', '2017/05/22 :13', 1),
(9, 'd', 'd', 'd', 'admindd', '21232f297a57a5a743894a0e4a801fc3', '1', '44c6dd449a45b3190b60f14f70d368ad', '2017/05/23 :13', 1),
(10, 'Suresh', 'Babu', '28', 'suresh', '0487cc982f7db39c51695026e4bdc692', '1', '931893b2cf927edf882ebdabee8a1bb9', '2017/05/24 :11', 1),
(11, 'e', 'e', '23', 'admin11', '21232f297a57a5a743894a0e4a801fc3', 'female', 'a4a6bb045b377a76687ba873aaa5c686', '2017/05/24 :11', 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `uploadvideo`
--
ALTER TABLE `uploadvideo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `userplaylist`
--
ALTER TABLE `userplaylist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
