-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Feb 27, 2015 at 11:22 AM
-- Server version: 5.5.38
-- PHP Version: 5.6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `pixafy_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `my_sessions`
--

CREATE TABLE `my_sessions` (
  `session_id` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `my_sessions`
--

INSERT INTO `my_sessions` (`session_id`, `user_data`) VALUES
('312e7c0471b7aab1129f265f9adb7b76', 'a:3:{s:7:"user_id";i:1;s:5:"email";s:19:"myromac87@gmail.com";s:6:"status";s:1:"1";}'),
('347eb040b652b9383be437f34072d77d', ''),
('4d1e4fcfeaf67598aa760a2aae35ab81', ''),
('57dec3c27542c2725f2f9f47ed073552', 'a:3:{s:7:"user_id";i:1;s:5:"email";s:19:"myromac87@gmail.com";s:6:"status";s:1:"1";}'),
('b3fbb83072b3ca2873e595359b41b469', 'a:3:{s:7:"user_id";i:1;s:5:"email";s:19:"myromac87@gmail.com";s:6:"status";s:1:"1";}'),
('d487f051011b746d3ed7cd709c15c084', '');

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
`photo_id` int(11) unsigned NOT NULL,
  `owner_id` int(11) unsigned NOT NULL DEFAULT '0',
  `path` varchar(250) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
`id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '1',
  `new_email` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `new_email_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `administrator` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `activated`, `new_email`, `new_email_key`, `last_ip`, `created`, `modified`, `administrator`) VALUES
(1, '', '1b2b0df453b6a0743d789f42ad21ae77', 'myromac87@gmail.com', 1, NULL, NULL, '', '0000-00-00 00:00:00', '2015-02-26 17:05:19', 0),
(2, '', '', 'awd@gmail.com', 1, NULL, NULL, '', '0000-00-00 00:00:00', '2015-02-26 16:09:51', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `city` varchar(20) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `my_sessions`
--
ALTER TABLE `my_sessions`
 ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
 ADD PRIMARY KEY (`photo_id`), ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
MODIFY `photo_id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;