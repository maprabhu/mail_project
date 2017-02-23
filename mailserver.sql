-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 13, 2017 at 06:56 PM
-- Server version: 5.5.53-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mailserver`
--

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'user', 'User');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `messageID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL,
  `receiverID` int(11) NOT NULL,
  `receiverType` varchar(20) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `attach` text,
  `attach_file_name` text,
  `userID` int(11) NOT NULL,
  `usertype` varchar(20) NOT NULL,
  `useremail` varchar(40) NOT NULL,
  `year` year(4) NOT NULL,
  `date` date NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `read_status` tinyint(1) NOT NULL,
  `from_status` int(11) NOT NULL,
  `to_status` int(11) NOT NULL,
  `fav_status` tinyint(1) NOT NULL,
  `fav_status_sent` tinyint(1) NOT NULL,
  `reply_status` int(11) NOT NULL,
  PRIMARY KEY (`messageID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=65 ;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`messageID`, `email`, `receiverID`, `receiverType`, `subject`, `message`, `attach`, `attach_file_name`, `userID`, `usertype`, `useremail`, `year`, `date`, `create_date`, `read_status`, `from_status`, `to_status`, `fav_status`, `fav_status_sent`, `reply_status`) VALUES
(59, '', 3, '', 'Testing message', 'hai rajesh how are you man', NULL, NULL, 1, '', '', 0000, '0000-00-00', '2017-02-11 22:25:14', 0, 0, 0, 0, 0, 0),
(63, '', 3, '', 'fgsfgsfg', 'testing message for rajesh', NULL, NULL, 1, '', '', 0000, '0000-00-00', '2017-02-11 22:25:01', 0, 0, 0, 0, 0, 0),
(64, '', 1, '', 'greetings', 'hai admin how are you man..<br>', NULL, NULL, 3, '', '', 0000, '0000-00-00', '2017-02-11 22:44:03', 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `reply_msg`
--

CREATE TABLE IF NOT EXISTS `reply_msg` (
  `replyID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `messageID` int(11) NOT NULL,
  `reply_msg` text NOT NULL,
  `status` int(11) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`replyID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `random_numbers` varchar(255) NOT NULL,
  `created_from` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Android,2=Website',
  `login_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=inactive,1=active',
  `userauthkey` varchar(255) DEFAULT NULL,
  `is_logged_in` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=Not logged,1=Logged in',
  `profile_photo` varchar(255) DEFAULT NULL,
  `company_logo` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL DEFAULT '1',
  `created_on_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `description`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `random_numbers`, `created_from`, `login_status`, `userauthkey`, `is_logged_in`, `profile_photo`, `company_logo`, `created_by`, `created_on_date`) VALUES
(1, '127.0.0.1', 'administrator', '$2y$08$fPuFdeWHXurcbeWvdYywQuTh1DHxss9L.mHflm6T1liHrMtOJ4jsW', '', '', 'sdada@administrator.com', NULL, NULL, NULL, NULL, 1268889823, 1486877450, 1, 'first_name', '0', 'asdasdas', '9874', '', 1, 0, '', 0, '', '', 1, '2017-01-24 11:28:03'),
(3, '127.0.0.1', 'rajesh', '$2y$08$1B./0RbnGExpgT5.VC52x.iA7D.gyMZcnozMO3oX5JboKBMqwoAiq', 'material', NULL, 'asdsa@asd.acom', NULL, NULL, NULL, NULL, 1475306810, 1486850996, 1, 'sathish', NULL, 'kumar', '9600751885', '2039561871', 1, 0, '449ea2defb584e38a9d9c5e5c', 0, '', NULL, 0, '2017-01-24 11:28:03'),
(4, '127.0.0.1', 'administrator1d1', '0', '', NULL, 'administrator@administrator.com', NULL, NULL, NULL, NULL, 1475306893, NULL, 1, 'first_name', NULL, NULL, '0', '1179863586', 1, 0, '5687d12d66cb1cf3d4479b661', 0, '', NULL, 0, '2017-01-24 11:28:03'),
(5, '127.0.0.1', 'asdsada', '0', '', NULL, 'asda@ad.aasdsosdamc', NULL, NULL, NULL, NULL, 1475314900, NULL, 1, 'asdasdsa', NULL, NULL, '', '694079152', 1, 0, '459831860b1198420540a7938', 0, '', NULL, 1, '2017-01-24 11:28:03'),
(6, '127.0.0.1', 'asdadasad', '0', '', NULL, 'asda@ad.aasdsosdamc', NULL, NULL, NULL, NULL, 1475315767, NULL, 1, 'asasd', NULL, NULL, '', '2079663235', 1, 0, '9f4b563397b2a7bf42d67b988', 0, '', NULL, 1, '2017-01-24 11:28:03'),
(7, '127.0.0.1', 'administrator1d11', '0', '', NULL, 'administrator@administrator.com', NULL, NULL, NULL, NULL, 1475315781, NULL, 1, 'first_name', NULL, NULL, '0', '157937168', 1, 0, '87ca063507d5c175fbfde8ce7', 0, '', NULL, 0, '2017-01-24 11:28:03'),
(8, '127.0.0.1', 'administrator1d111', '0', '', NULL, 'administrator@administrator.com', NULL, NULL, NULL, NULL, 1475315824, NULL, 1, 'first_name', NULL, NULL, '0', '1247385757', 1, 0, '8d3cb7920300ba27b39ba6a30', 0, '', NULL, 0, '2017-01-24 11:28:03'),
(9, '127.0.0.1', 'administrator1d1111', '0', '', NULL, 'administrator@administrator.com', NULL, NULL, NULL, NULL, 1475315836, NULL, 1, 'first_name', NULL, NULL, '0', '1735681979', 1, 0, '674e950be23b9f3bf9a9c7b70', 0, '', NULL, 0, '2017-01-24 11:28:03'),
(10, '127.0.0.1', 'govarathinam', '$2y$08$AZA7yur82SBXn9sdMr5OpO4cR8B7JNf71DF5Y3aTiGSTMOPqkU0z6', 'material', NULL, 'administrator@administrator.com', NULL, NULL, NULL, NULL, 1475315875, NULL, 1, 'first_name', NULL, NULL, '9047222424', '1634880124', 1, 0, 'a39f70280f909307961b44706', 0, '', NULL, 0, '2017-01-24 11:28:03'),
(11, '127.0.0.1', 'administrator1d111111', '0', '', NULL, 'administrator@administrator.com', NULL, NULL, NULL, NULL, 1475316039, NULL, 1, 'first_name', NULL, NULL, '0', '289912052', 1, 0, 'c06a1109dc5c2254fc1db281e', 0, '', NULL, 0, '2017-01-24 11:28:03'),
(12, '127.0.0.1', 'sathish', '$2y$08$CeoR6TQz/iMeUF/.4hF0TO9l35YTyBcI2wFBNFnfbmhzXXT8OFMI2', 'Joined as first user', NULL, 'sathishkumar@sathishkumar.com', NULL, NULL, NULL, NULL, 1475316140, 1475316846, 1, 'sathish1', NULL, 'Self Company', '8088231481', '1794989767', 1, 0, 'f76e02b2d9a6c34d1616e48a3', 0, '2016-10-01-153220_dishaug-2016.png', NULL, 1, '2017-01-24 11:28:03'),
(16, '127.0.0.1', 'rajhhh', '$2y$08$IjOcgT3Z6DERqzn3NCF1J.KB0VYX4T5.Ytd37CHk9s.uKyswhr6Se', 'new user added 24Jan', NULL, '', NULL, NULL, NULL, NULL, 1485257349, NULL, 1, NULL, NULL, NULL, '9600751884', '1457640155', 1, 0, 'aa2bb8bfd57f6c7c3cf36dc93', 0, NULL, NULL, 1, '2017-01-24 11:29:09'),
(17, '127.0.0.1', 'govaios', '$2y$08$Uz7p7O7nD4WxT4Unh2NbxOCj.8yCtrStY9RoqXcvFwo9ByW4UlxwC', 'newly joined user', NULL, '', NULL, NULL, NULL, NULL, 1485262836, 1485262892, 1, NULL, NULL, NULL, '9629294546', '796602298', 1, 0, '6b9ac8680c8c881cc3f1fe342', 0, NULL, NULL, 1, '2017-01-24 13:00:36');

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE IF NOT EXISTS `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(3, 3, 2),
(4, 4, 2),
(5, 5, 2),
(6, 6, 2),
(7, 7, 1),
(8, 8, 1),
(9, 9, 1),
(10, 10, 2),
(11, 11, 2),
(12, 12, 2),
(16, 16, 2),
(17, 17, 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
