-- phpMyAdmin SQL Dump
-- version 2.11.9.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 29, 2009 at 10:07 AM
-- Server version: 5.0.67
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `filmtest_drpl1`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(60) NOT NULL default '',
  `pass` varchar(32) NOT NULL default '',
  `mail` varchar(64) default '',
  `mode` tinyint(4) NOT NULL default '0',
  `sort` tinyint(4) default '0',
  `threshold` tinyint(4) default '0',
  `theme` varchar(255) NOT NULL default '',
  `signature` varchar(255) NOT NULL default '',
  `created` int(11) NOT NULL default '0',
  `access` int(11) NOT NULL default '0',
  `login` int(11) NOT NULL default '0',
  `status` tinyint(4) NOT NULL default '0',
  `timezone` varchar(8) default NULL,
  `language` varchar(12) NOT NULL default '',
  `picture` varchar(255) NOT NULL default '',
  `init` varchar(64) default '',
  `data` longtext,
  PRIMARY KEY  (`uid`),
  UNIQUE KEY `name` (`name`),
  KEY `access` (`access`),
  KEY `created` (`created`),
  KEY `mail` (`mail`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `name`, `pass`, `mail`, `mode`, `sort`, `threshold`, `theme`, `signature`, `created`, `access`, `login`, `status`, `timezone`, `language`, `picture`, `init`, `data`) VALUES
(0, '', '', '', 0, 0, 0, '', '', 0, 0, 0, 0, NULL, '', '', '', NULL),
(1, 'admin', '2a8ae479d8a381be4506dc632ef4b26b', 'nandhu@baryons.in', 0, 0, 0, '', '', 1237962956, 1242968856, 1242968856, 1, '19800', '', '', 'nandhu@baryons.in', 'a:2:{s:5:"block";a:1:{s:5:"block";a:1:{i:6;i:1;}}s:13:"form_build_id";s:37:"form-4387af9a7712826f40e736f3791629d4";}'),
(3, 'nandhu', 'e10adc3949ba59abbe56e057f20f883e', 'nandhaguru@gmail.com', 2, 1, 0, '', '', 1235971433, 1242890896, 1242890896, 1, '19800', '', '', 'nandhaguru@gmail.com', 'a:3:{s:13:"form_build_id";s:37:"form-c5bd89a9c1ece2fd9ee90afed9a0f447";s:17:"comments_per_page";s:2:"50";s:5:"block";a:1:{s:5:"block";a:1:{i:6;i:0;}}}'),
(9, 'guru', 'e10adc3949ba59abbe56e057f20f883e', 'guru@baryons.in', 0, 0, 0, '', '', 1239708774, 1239708775, 1239708775, 1, '19800', '', '', 'guru@baryons.in', 'a:1:{s:13:"form_build_id";s:37:"form-8f38b054ba86271e37528e9c0d375f16";}'),
(10, 'd6veteran', '831342a10a70e9abab152a985dbe95da', 'd6veteran@gmail.com', 0, 0, 0, '', '', 1239984225, 1241620599, 1240802921, 1, '-18000', '', '', 'd6veteran@gmail.com', 'a:1:{s:13:"form_build_id";s:37:"form-d592e65017158f78031f0f21b0038f6b";}'),
(11, 'wmerydith', '831342a10a70e9abab152a985dbe95da', 'will.merydith@gmail.com', 0, 0, 0, '', '', 1239984476, 1243441681, 1242318890, 1, '-18000', '', '', 'will.merydith@gmail.com', 'a:1:{s:13:"form_build_id";s:37:"form-bb71100c26826dc9b0fe0e33749a7c03";}'),
(12, 'testuser', '5d9c68c6c50ed3d02a2fcf54f63993b6', 'nandhaguru@yahoo.com', 0, 0, 0, '', '', 1240229310, 1240230962, 1240230490, 1, '19800', '', '', 'nandhaguru@yahoo.com', 'a:1:{s:13:"form_build_id";s:37:"form-499b8f6f2edb6e512b1bf1110bd2075a";}'),
(13, 'Dawni', '41ea475152548dffb75ab96279913407', 'dawn.merydith@gmail.com', 0, 0, 0, '', '', 1240351246, 1240353431, 1240351246, 1, '-18000', '', '', 'dawn.merydith@gmail.com', 'a:1:{s:13:"form_build_id";s:37:"form-1064917757512fd864253b68c1f28600";}'),
(14, 'baryons', 'e10adc3949ba59abbe56e057f20f883e', 'bharani@baryonssoftsolutions.com', 0, 0, 0, '', '', 1240835424, 1242033479, 1242033479, 1, '19800', '', '', 'bharani@baryonssoftsolutions.com', 'a:1:{s:13:"form_build_id";s:37:"form-9f590b3dcb362a7353af5b4e21560733";}'),
(15, 'brijsingh', 'e10adc3949ba59abbe56e057f20f883e', 'brijs@baryonssoftsolutions.com', 0, 0, 0, '', '', 1241505661, 1241519672, 1241519553, 1, '19800', '', '', 'brijs@baryonssoftsolutions.com', 'a:2:{s:13:"form_build_id";s:37:"form-3187db711818fecb9679c8e98609d906";s:5:"block";a:1:{s:5:"block";a:1:{i:6;i:1;}}}'),
(16, 'test123', 'e10adc3949ba59abbe56e057f20f883e', 'test123@baryonssoftsolutions.com', 0, 0, 0, '', '', 1241505940, 1242038229, 1242038229, 1, '19800', '', '', 'test123@baryonssoftsolutions.com', 'a:1:{s:13:"form_build_id";s:37:"form-8273d8ddd11c22d0247f9b640e0ad8eb";}'),
(17, 'sampyxis', 'cfd0b2eb078ff59935e248aa83cad6fc', 'sampyxis@gmail.com', 0, 0, 0, '', '', 1241804295, 1241831579, 1241804295, 1, '-25200', '', '', 'sampyxis@gmail.com', 'a:1:{s:13:"form_build_id";s:37:"form-1ca4f5e81cf9da40e159888679a28f2b";}'),
(18, 'User_new', 'e10adc3949ba59abbe56e057f20f883e', 'vasanthbharani@gmail.com', 0, 0, 0, '', '', 1242029878, 1242034118, 1242033925, 1, '19800', '', '', 'vasanthbharani@gmail.com', 'a:1:{s:13:"form_build_id";s:37:"form-d9b8082605887cb2d95d1b5e9a67c84b";}'),
(19, 'User', 'e10adc3949ba59abbe56e057f20f883e', 'bharani1@baryonssoftsolutions.com', 0, 0, 0, '', '', 1242891321, 1242891991, 1242891903, 1, '-14400', '', '', 'bharani1@baryonssoftsolutions.com', 'a:1:{s:13:"form_build_id";s:37:"form-2d408d8ddc2a6c6895052fc6e8f199f1";}');
