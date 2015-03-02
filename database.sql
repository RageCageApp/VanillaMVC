-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Mar 02, 2015 at 01:16 AM
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
('042d3a75e6d56cb44a44bc63216dbc2c', 'a:3:{s:7:"user_id";i:18;s:5:"email";s:19:"myromac87@gmail.com";s:6:"status";s:1:"1";}'),
('1e4927058336c2a53d4ecf2d819e880d', 'a:3:{s:7:"user_id";i:20;s:5:"email";s:19:"myromac87@yahoo.com";s:6:"status";s:1:"0";}'),
('4e13fbfb7bdf02de188115c95c56ffea', 'a:3:{s:7:"user_id";i:18;s:5:"email";s:19:"myromac87@gmail.com";s:6:"status";s:1:"1";}'),
('53193405e18301eb2659336a6fc20161', 'a:3:{s:7:"user_id";i:18;s:5:"email";s:19:"myromac87@gmail.com";s:6:"status";s:1:"1";}'),
('6d18f42e422c711fac3599758c5b5435', 'a:3:{s:7:"user_id";i:25;s:5:"email";s:11:"123@123.com";s:6:"status";s:1:"0";}'),
('77bd71dee84ae37fe61d7cde07ebeef6', 'a:3:{s:7:"user_id";i:18;s:5:"email";s:19:"myromac87@gmail.com";s:6:"status";s:1:"1";}'),
('7cafd52b42ef0c964d04db1995db71c9', 'a:3:{s:7:"user_id";i:18;s:5:"email";s:19:"myromac87@gmail.com";s:6:"status";s:1:"1";}'),
('ae1d58e861a0fa8544a5b9a77c862009', 'a:3:{s:7:"user_id";i:21;s:5:"email";s:20:"akwjdalkwdj@gmail.co";s:6:"status";s:1:"0";}'),
('c13d7ebffbd72665f56d39d68dc8ef27', 'a:3:{s:7:"user_id";i:23;s:5:"email";s:16:"123123@gmail.com";s:6:"status";s:1:"0";}'),
('d6ccb0b24ff732a872ee1856ef603298', 'a:3:{s:7:"user_id";i:18;s:5:"email";s:19:"myromac87@gmail.com";s:6:"status";s:1:"1";}'),
('f2afa955ae5557d6f5a5efc23801937e', 'a:3:{s:7:"user_id";i:24;s:5:"email";s:3:"123";s:6:"status";s:1:"0";}'),
('fed5e78d042594b3cf6938c7764d810b', 'a:3:{s:7:"user_id";i:22;s:5:"email";s:12:"test@123.com";s:6:"status";s:1:"0";}');

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
`photo_id` int(11) unsigned NOT NULL,
  `owner_id` int(11) unsigned NOT NULL DEFAULT '0',
  `path` varchar(250) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`photo_id`, `owner_id`, `path`, `deleted`) VALUES
(2, 18, 'localhost:8888/public/uploads/76d60f144d7ccf99a6302fcd45719145.png', 1),
(3, 18, 'localhost:8888/public/uploads/4ec5ab5cae3a616b9a864acf22880533.jpg', 1),
(4, 18, 'http://localhost:8888/public/uploads/a8d5fc55673862ec08ec3d67df491a5d.png', 1),
(5, 18, 'http://localhost:8888/public/uploads/a1412b86602e6b43946ec6a7d6bb3a61.jpg', 1),
(6, 18, 'http://localhost:8888/public/uploads/3eff7122c729113bfe919db7310c060b.png', 1),
(7, 18, 'http://localhost:8888/public/uploads/6fc71bde66ae26bf65afe91f69bce7ad.png', 1),
(8, 18, 'http://localhost:8888/public/uploads/43eac56065d29a7d0217b0105fbcb747.jpg', 1),
(9, 18, 'http://localhost:8888/public/uploads/76fe5cd4a2dd1d374e76a84c48fc778e.png', 1),
(10, 19, 'http://localhost:8888/public/uploads/c99422c2b76e5d0560241bb7f9efdb05.png', 0),
(11, 18, 'http://localhost:8888/public/uploads/93ac8933b3f7626deb6fa3025aa99960.jpg', 1),
(12, 18, 'http://localhost:8888/public/uploads/e7e5b569975948c9732746e60e07cec0.png', 1),
(13, 18, 'http://localhost:8888/public/uploads/f40f528a7a156dcd61697bd0039d3a4d.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
`id` int(11) NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `activation_key` int(11) NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `administrator` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `password`, `email`, `activated`, `activation_key`, `modified`, `administrator`) VALUES
(18, '1b2b0df453b6a0743d789f42ad21ae77', 'myromac87@gmail.com', 1, 5131, '2015-03-02 00:00:51', 0),
(19, '123123123123123', 'janromac@yahoo.com', 1, 123, '2015-03-01 22:10:36', 0),
(20, 'b53759f3ce692de7aff1b5779d3964da', 'myromac87@yahoo.com', 0, 9035, '2015-03-01 22:32:06', 0),
(21, 'b53759f3ce692de7aff1b5779d3964da', 'akwjdalkwdj@gmail.co', 0, 7813, '2015-03-01 23:06:20', 0),
(22, 'b53759f3ce692de7aff1b5779d3964da', 'test@123.com', 0, 3116, '2015-03-01 23:14:47', 0),
(23, 'b53759f3ce692de7aff1b5779d3964da', '123123@gmail.com', 0, 1664, '2015-03-01 23:15:35', 1),
(24, '202cb962ac59075b964b07152d234b70', '123', 0, 8198, '2015-03-01 23:17:25', 0),
(25, '202cb962ac59075b964b07152d234b70', '123@123.com', 0, 2630, '2015-03-01 23:20:37', 1);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
MODIFY `photo_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;