-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 27, 2013 at 06:02 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gripadv_newbackend`
--

-- --------------------------------------------------------

--
-- Table structure for table `administration`
--

CREATE TABLE IF NOT EXISTS `administration` (
  `id` varchar(255) NOT NULL,
  `value` varchar(1024) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `administration`
--

INSERT INTO `administration` (`id`, `value`) VALUES
('licensekey', 'Gripown-3f1372510fb1051ea7df'),
('sitekey', '==Qf7IyNyQDMzEDMyIiO4ozc7ISZ0FGZrNWZoNmI6kjOztjIyYWMlRWZ3EjZxQmNxYTZzMDOmVDOmNmZ\n2YWYzMDMzEmI6IzM6M3Oig2chhWNk1mI6cjOztjIzV2czFGbj9SZkVHbj5WavMnbvlGdj5Wdm9ybyB3b\ntVGZvwWb0h2XjlGbiVHcvwGblNHcpJ3ZvUWbvh2LioDM2ozc7ISey9GdjVmcpRGZpxWY2JiO0EjOztjI\nyUjMucDOx4yM0EjL4kTMsIjMx4SM14SO2EjL4YDLx4CMuAjL3ITMsADOx4SM3EjL3IjMucjNioDN1ozc\n7ICcpRWasFmdiozN6M3Oi02bj5CbsV2cwlmcn5idlRWai9Wbuc3d3xSbvNmLsxWZzBXaydmL2VGZpJ2b\ntxSbvNmLsxWZzBXaydmL3d3ds02bj5CbsV2cwlmcnxSbvNmLlxGctFGel5yd3dHLt92YuUGbw1WY4VGL\nt92YuwGblNHcpJ3ZuYXZk5SY0VmYuc3d3xSbvNmLsxWZzBXaydmL2VGZuEGdlJGLt92YuwGblNHcpJ3Z\nuM3MzQzbtVGZs02bj5CbsV2cwlmcn5yczMDNv1WZk5yd3dHLt92YuwGblNHcpJ3Zu8mcw9WblRmL3d3d\ns02bj5CbsV2cwlmcn5ybyB3btVGZs02bj5SZsBXbhhXZuc3d3xSbvNmLlxGctFGelxSbvNmLsxWZzBXa\nydmLhRjM08WblRGLt92YuwGblNHcpJ3ZuEGNyQzbtVGZuc3d3JiOxIzM6M3Oi4Wah12bkRWasFmdioTM\nxozc7ISZtlGVgUmbPJiO4ozc7ISZsNWejdmbpxGbpJmI6ITM6M3OiADMtADMtADMwAjI6ATM6M3OiUGd\nhRWZ1RGd4VmbioTMxozc7ISNx0SMw0SMxAjMioDMxozc7ISZ0FGZnVmciozN6M3OikSZz5WZjlGTgUWb\npRXZmlGToACajJXQgQWZyV3YlN1L3BSZj5WY2RWQgwGblNHcpJ3R'),
('sitename', 'R3JpcHNlbGwgVGVjaG5vbG9naWVz'),
('ccode', 'on');

-- --------------------------------------------------------

--
-- Table structure for table `agent`
--

CREATE TABLE IF NOT EXISTS `agent` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `partnerid` bigint(20) NOT NULL,
  `agentname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `create_time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `agent`
--

INSERT INTO `agent` (`id`, `partnerid`, `agentname`, `password`, `create_time`) VALUES
(1, 1, 'agent1', '759bc7fa4438cd873ef26d79d1c4c844', 1293507031),
(2, 1, 'agent2', '759bc7fa4438cd873ef26d79d1c4c844', 1293507048),
(3, 1, 'agent3', '759bc7fa4438cd873ef26d79d1c4c844', 1293507080);

-- --------------------------------------------------------

--
-- Table structure for table `ask`
--

CREATE TABLE IF NOT EXISTS `ask` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `deals_id` int(10) unsigned NOT NULL DEFAULT '0',
  `city_id` int(10) unsigned NOT NULL DEFAULT '0',
  `content` text,
  `comment` text,
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `ask`
--

INSERT INTO `ask` (`id`, `user_id`, `deals_id`, `city_id`, `content`, `comment`, `create_time`) VALUES
(1, 5, 3, 0, 'cool', NULL, 1290009280),
(2, 1, 6, 2, '<yx<yx<y', NULL, 1290106613),
(3, 1, 6, 2, 'ghgfh', NULL, 1290106632),
(4, 36, 3, 0, 'Teste Jonny', NULL, 1292442830),
(5, 1, 3, 0, 'This is a test question', 'This site seem to work', 1292584307);

-- --------------------------------------------------------

--
-- Table structure for table `assigned`
--

CREATE TABLE IF NOT EXISTS `assigned` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `USER_ID` int(11) NOT NULL,
  `TICKET_ID` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `assigned`
--


-- --------------------------------------------------------

--
-- Table structure for table `card`
--

CREATE TABLE IF NOT EXISTS `card` (
  `id` varchar(16) NOT NULL,
  `code` varchar(16) DEFAULT NULL,
  `partner_id` int(10) unsigned NOT NULL DEFAULT '0',
  `deals_id` int(10) unsigned NOT NULL DEFAULT '0',
  `order_id` int(10) unsigned NOT NULL DEFAULT '0',
  `credit` int(10) unsigned NOT NULL DEFAULT '0',
  `consume` enum('Y','N') NOT NULL DEFAULT 'N',
  `ip` varchar(16) DEFAULT NULL,
  `begin_time` int(10) unsigned NOT NULL DEFAULT '0',
  `end_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `card`
--


-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  `ename` varchar(10) NOT NULL,
  `desc` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNQ_zne` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `ename`, `desc`) VALUES
(1, 'Food', 'food', 'Eat Something'),
(2, 'Beauty', 'beauty', 'Get Pampered'),
(3, 'Health', 'health', 'Stay Fit'),
(4, 'Entertainment', 'entertainm', 'Go Out'),
(5, 'Shopping', 'shopping', 'Go Shopping'),
(6, 'Sports', 'sports', 'Let''s Play'),
(7, 'Travel', 'travel', 'Enjoy Trip');

-- --------------------------------------------------------

--
-- Table structure for table `charity`
--

CREATE TABLE IF NOT EXISTS `charity` (
  `type` varchar(30) NOT NULL,
  `value` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `charity`
--

INSERT INTO `charity` (`type`, `value`) VALUES
('charopc', 31),
('charopa', 23),
('charopb', 29);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `zone` varchar(16) DEFAULT NULL,
  `czone` varchar(32) DEFAULT NULL,
  `name` varchar(32) DEFAULT NULL,
  `ename` varchar(16) DEFAULT NULL,
  `letter` char(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNQ_zne` (`zone`,`name`,`ename`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `zone`, `czone`, `name`, `ename`, `letter`) VALUES
(1, 'group', 'Deals', 'Deals', 'deals', 'D'),
(3, 'city', 'USA', 'Los Angeles', 'loa', 'L'),
(4, 'city', 'USA', 'Denver', 'den', 'D'),
(5, 'city', 'USA', 'Miami', 'mia', 'M'),
(6, 'city', 'USA', 'Chicago', 'chi', 'C'),
(7, 'city', 'USA', 'Atlanta', 'atl', 'A'),
(8, 'city', 'USA', 'Kansas', 'kan', 'K'),
(9, 'group', 'COUNTRY', 'Canada', 'CA', 'C'),
(10, 'group', 'COUNTRY', 'USA', 'US', 'U'),
(11, 'city', 'USA', 'San Francisco', 'san', 'S'),
(12, 'city', 'Canada', 'Toronto', 'tor', 'T'),
(14, 'city', 'USA', 'Minneapolis', 'min', 'M'),
(15, 'city', 'USA', 'Austin', 'aus', 'A'),
(16, 'city', 'USA', 'Cleveland', 'cle', 'C'),
(21, 'city', 'USA', 'New York', 'new', 'N'),
(22, 'city', 'USA', 'North Jersey', 'nor', 'N'),
(23, 'city', 'USA', 'Richmond', 'ric', 'R');

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE IF NOT EXISTS `coupon` (
  `id` varchar(12) NOT NULL DEFAULT '',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `partner_id` int(10) unsigned NOT NULL DEFAULT '0',
  `deals_id` int(10) unsigned NOT NULL DEFAULT '0',
  `order_id` int(10) unsigned NOT NULL DEFAULT '0',
  `type` enum('consume','credit') NOT NULL DEFAULT 'consume',
  `credit` int(10) unsigned NOT NULL DEFAULT '0',
  `secret` varchar(10) DEFAULT NULL,
  `consume` enum('Y','N') NOT NULL DEFAULT 'N',
  `ip` varchar(16) DEFAULT NULL,
  `sms` int(10) unsigned NOT NULL DEFAULT '0',
  `expire_time` int(10) unsigned NOT NULL DEFAULT '0',
  `consume_time` int(10) unsigned NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `gifted` varchar(1) NOT NULL DEFAULT 'N',
  `giftbyid` int(11) NOT NULL,
  `isinsta` int(11) NOT NULL DEFAULT '0',
  `agent` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `coupon`
--


-- --------------------------------------------------------

--
-- Table structure for table `deals`
--

CREATE TABLE IF NOT EXISTS `deals` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(128) DEFAULT NULL,
  `summary` text NOT NULL,
  `city_id` varchar(100) NOT NULL DEFAULT '0',
  `group_id` int(10) unsigned NOT NULL DEFAULT '0',
  `partner_id` int(10) unsigned NOT NULL DEFAULT '0',
  `system` enum('Y','N') NOT NULL DEFAULT 'Y',
  `fbcheck` varchar(5) NOT NULL,
  `deals_price` double(10,2) NOT NULL DEFAULT '0.00',
  `market_price` double(10,2) NOT NULL DEFAULT '0.00',
  `product` varchar(128) DEFAULT NULL,
  `per_number` int(10) unsigned NOT NULL DEFAULT '1',
  `min_number` int(10) unsigned NOT NULL DEFAULT '1',
  `max_number` int(10) unsigned NOT NULL DEFAULT '0',
  `now_number` int(10) unsigned NOT NULL DEFAULT '0',
  `image` varchar(128) DEFAULT NULL,
  `image1` varchar(128) DEFAULT NULL,
  `image2` varchar(128) DEFAULT NULL,
  `flv` varchar(400) DEFAULT NULL,
  `mobile` varchar(16) DEFAULT NULL,
  `credit` int(10) unsigned NOT NULL DEFAULT '0',
  `card` int(10) unsigned NOT NULL DEFAULT '0',
  `fare` int(10) unsigned NOT NULL DEFAULT '0',
  `address` varchar(128) DEFAULT NULL,
  `detail` text NOT NULL,
  `systemreview` text NOT NULL,
  `userreview` text NOT NULL,
  `notice` text NOT NULL,
  `express` text NOT NULL,
  `delivery` enum('coupon','express','pickup') NOT NULL DEFAULT 'coupon',
  `state` enum('none','success','soldout','failure','refund') NOT NULL DEFAULT 'none',
  `conduser` enum('Y','N') NOT NULL DEFAULT 'Y',
  `expire_time` int(10) unsigned NOT NULL DEFAULT '0',
  `begin_time` int(10) unsigned NOT NULL DEFAULT '0',
  `end_time` int(10) unsigned NOT NULL DEFAULT '0',
  `close_time` int(10) unsigned NOT NULL DEFAULT '0',
  `sendalert` int(1) unsigned NOT NULL DEFAULT '1',
  `stage` text NOT NULL,
  `seokey` varchar(255) NOT NULL,
  `commission` int(11) NOT NULL,
  `seodesc` varchar(255) NOT NULL,
  `deal_id` int(11) NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `deal_id` (`deal_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `deals`
--

INSERT INTO `deals` (`id`, `user_id`, `title`, `summary`, `city_id`, `group_id`, `partner_id`, `system`, `fbcheck`, `deals_price`, `market_price`, `product`, `per_number`, `min_number`, `max_number`, `now_number`, `image`, `image1`, `image2`, `flv`, `mobile`, `credit`, `card`, `fare`, `address`, `detail`, `systemreview`, `userreview`, `notice`, `express`, `delivery`, `state`, `conduser`, `expire_time`, `begin_time`, `end_time`, `close_time`, `sendalert`, `stage`, `seokey`, `commission`, `seodesc`, `deal_id`, `name`) VALUES
(2, 1, 'sdfsdf sdfsdf sdfsdf sdfsdfsdf sdf', '<p>\r\n	sdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fs&nbsp;sdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fs</p>\r\n', '0', 0, 1, 'Y', '', 50.00, 100.00, '2', 1, 5, 100, 6, 'deals/2013/0425/13668693703838.jpg', NULL, NULL, '', '', 0, 0, 5, '', '<p>\r\n	&nbsp;</p>\r\n<p>\r\n	sdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fs</p>\r\n', '', 'sdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fs', '<p>\r\n	sdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fssdf sdfsd fsdf sdfsdfsdfsdfsdf sfsdfsdf sd fs</p>\r\n', '', 'coupon', 'none', 'Y', 1383198840, 1364795640, 1380520440, 0, 1, '1-featured', '', 5, '', 0, 'Movenpick of Switzerland Ice Cream at Palawan Beach Sentosa: Any Two Ice Cream Sets @ $19nett instead of $31.9'),
(3, 1, 'sdfsdf sdfsdf sdfsdf sdfsdfsdf sdf', '', '0', 0, 0, 'Y', '', 8.00, 10.00, '', 1, 10, 20, 0, 'deals/2013/0426/13669728117192.jpg', NULL, NULL, '', '', 0, 0, 5, '', '', '', '', '', '', 'coupon', 'none', 'Y', 1375267140, 1367404740, 1369996740, 0, 1, '1-featured', '', 5, '', 0, 'test deafds dfsdfsfsdfsdf sdfsdfsdf'),
(4, 1, 'sfsdfsdf sdfsafsdfwerwerwe sdfsdf', '', '0', 0, 0, 'Y', '', 50.00, 100.00, '', 1, 10, 520, 0, 'deals/2013/0426/13669728911347.jpg', NULL, NULL, '', '', 0, 0, 5, '', '', '', '', '', '', 'coupon', 'none', 'Y', 1374921600, 1364899200, 1372588800, 0, 1, 'approved', '', 5, '', 0, 'dfgfsf sdfsdfsdf'),
(5, 1, 'dsfsd ewrrwe fsdgdfghd', '', '0', 0, 0, 'Y', '', 1.00, 8.00, '', 1, 10, 60, 0, 'deals/2013/0426/13669729471133.jpg', NULL, NULL, '', '', 0, 0, 5, '', '', '', '', '', '', 'coupon', 'none', 'Y', 1374921660, 1364812860, 1369996860, 0, 1, 'approved', '', 5, '', 0, 'fdsf werwercsgdfbfdhdhh dfgdg'),
(6, 1, 'previous deals for testeingsdfsdf', '', '0', 0, 0, 'Y', '', 1.00, 50.00, '', 1, 10, 50, 0, 'deals/2013/0426/13669730756612.jpg', NULL, NULL, '', '', 0, 0, 5, '', '', '', '', '', '', 'coupon', 'none', 'Y', 1374921780, 1364726580, 1365849780, 0, 1, 'approved', '', 5, '', 0, 'previous deals for testeingsdfsdf');

-- --------------------------------------------------------

--
-- Table structure for table `deal_details`
--

CREATE TABLE IF NOT EXISTS `deal_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deal_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `title` text CHARACTER SET utf8 NOT NULL,
  `summary` text CHARACTER SET utf8 NOT NULL,
  `detail` text CHARACTER SET utf8 NOT NULL,
  `notice` text CHARACTER SET utf8 NOT NULL,
  `userreview` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `deal_id` (`deal_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `deal_details`
--

INSERT INTO `deal_details` (`id`, `deal_id`, `lang_id`, `title`, `summary`, `detail`, `notice`, `userreview`) VALUES
(2, 2, 1, 'sdfsdf sdfsdf sdfsdf sdfsdfsdf sdf', '<p>\r\n	<strong style="color: rgb(0, 0, 0); font-family: Arial, Helvetica, sans; font-size: 11px; line-height: 14px; text-align: justify;">Lorem Ipsum</strong><span style="color: rgb(0, 0, 0); font-family: Arial, Helvetica, sans; font-size: 11px; line-height: 14px; text-align: justify;">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p>\r\n', '<p>\r\n	<strong style="color: rgb(0, 0, 0); font-family: Arial, Helvetica, sans; font-size: 11px; line-height: 14px; text-align: justify;">Lorem Ipsum</strong><span style="color: rgb(0, 0, 0); font-family: Arial, Helvetica, sans; font-size: 11px; line-height: 14px; text-align: justify;">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p>\r\n', '<p>\r\n	<strong style="color: rgb(0, 0, 0); font-family: Arial, Helvetica, sans; font-size: 11px; line-height: 14px; text-align: justify;">Lorem Ipsum</strong><span style="color: rgb(0, 0, 0); font-family: Arial, Helvetica, sans; font-size: 11px; line-height: 14px; text-align: justify;">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p>\r\n', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'),
(3, 3, 1, 'sdfsdf sdfsdf sdfsdf sdfsdfsdf sdf', '', '', '', ''),
(4, 4, 1, 'sfsdfsdf sdfsafsdfwerwerwe sdfsdf', '', '', '', ''),
(5, 5, 1, 'dsfsd ewrrwe fsdgdfghd', '', '', '', ''),
(6, 6, 1, 'previous deals for testeingsdfsdf', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `deal_locations`
--

CREATE TABLE IF NOT EXISTS `deal_locations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `deal_id` int(10) unsigned NOT NULL DEFAULT '0',
  `lat` varchar(30) NOT NULL,
  `lng` varchar(30) NOT NULL,
  `address` text,
  `stage` varchar(30) NOT NULL,
  `html` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `deal_locations`
--

INSERT INTO `deal_locations` (`id`, `deal_id`, `lat`, `lng`, `address`, `stage`, `html`) VALUES
(7, 1, '40.6187181', '-74.0153231', 'Manhattan, NY, USA', '1', 'Manhattan, NY, USA'),
(8, 1, '40.7143528', '-74.0059731', 'Dyker Heights, NY, USA', '1', 'Dyker Heights, NY, USA'),
(9, 1, '40.59727063442024', '-73.95326614379883', 'Sheepshead Bay, NY, USA', '1', 'Sheepshead Bay, NY, USA'),
(16, 2, '36.778261', '-119.4179324', 'california', '1', ''),
(17, 2, '40.7143528', '-74.0059731', 'newyork', '1', ''),
(18, 2, '41.8781136', '-87.6297982', 'chicago', '1', ''),
(20, 3, '36.778261', '-119.4179324', 'california', '1', ''),
(26, 4, '36.114646', '-115.172816', 'las vegas', '1', ''),
(25, 5, '36.114646', '-115.172816', 'las vegas', '1', ''),
(28, 6, '36.778261', '-119.4179324', 'california', '1', '');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE IF NOT EXISTS `departments` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` mediumtext NOT NULL,
  `email` varchar(65) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `departments`
--


-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `category` enum('suggest','seller') NOT NULL DEFAULT 'suggest',
  `title` varchar(128) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `content` text,
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `feedback`
--


-- --------------------------------------------------------

--
-- Table structure for table `flow`
--

CREATE TABLE IF NOT EXISTS `flow` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `admin_id` int(10) unsigned NOT NULL DEFAULT '0',
  `detail_id` varchar(32) DEFAULT NULL,
  `partner_id` int(10) NOT NULL,
  `isinsta` int(2) NOT NULL,
  `commissionpercentage` int(3) NOT NULL,
  `direction` enum('income','expense','commission') NOT NULL DEFAULT 'income',
  `money` double(10,2) NOT NULL DEFAULT '0.00',
  `action` varchar(16) NOT NULL DEFAULT 'buy',
  `commissionby` enum('deal','partner') NOT NULL,
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `flow`
--


-- --------------------------------------------------------

--
-- Table structure for table `insta`
--

CREATE TABLE IF NOT EXISTS `insta` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(128) DEFAULT NULL,
  `city_id` int(10) unsigned NOT NULL DEFAULT '0',
  `group_id` int(10) unsigned NOT NULL DEFAULT '0',
  `partner_id` int(10) unsigned NOT NULL DEFAULT '0',
  `system` enum('Y','N') NOT NULL DEFAULT 'Y',
  `deals_price` double(10,2) NOT NULL DEFAULT '0.00',
  `market_price` double(10,2) NOT NULL DEFAULT '0.00',
  `product` varchar(128) DEFAULT NULL,
  `per_number` int(10) unsigned NOT NULL DEFAULT '1',
  `min_number` int(10) unsigned NOT NULL DEFAULT '1',
  `max_number` int(10) unsigned NOT NULL DEFAULT '0',
  `now_number` int(10) unsigned NOT NULL DEFAULT '0',
  `image` varchar(128) DEFAULT NULL,
  `notice` text,
  `conduser` enum('Y','N') NOT NULL DEFAULT 'Y',
  `expire_time` int(10) unsigned NOT NULL DEFAULT '0',
  `begin_time` int(10) unsigned NOT NULL DEFAULT '0',
  `end_time` int(10) unsigned NOT NULL DEFAULT '0',
  `sendalert` int(1) unsigned NOT NULL DEFAULT '1',
  `commission` int(11) NOT NULL,
  `lat` varchar(30) NOT NULL,
  `lng` varchar(30) NOT NULL,
  `address` text,
  `zipcode` int(11) NOT NULL,
  `stage` varchar(30) NOT NULL,
  `category` varchar(30) NOT NULL,
  `url` varchar(100) NOT NULL DEFAULT '#',
  `html` varchar(255) NOT NULL,
  `marker` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `insta`
--

INSERT INTO `insta` (`id`, `name`, `user_id`, `title`, `city_id`, `group_id`, `partner_id`, `system`, `deals_price`, `market_price`, `product`, `per_number`, `min_number`, `max_number`, `now_number`, `image`, `notice`, `conduser`, `expire_time`, `begin_time`, `end_time`, `sendalert`, `commission`, `lat`, `lng`, `address`, `zipcode`, `stage`, `category`, `url`, `html`, `marker`) VALUES
(1, 'Test insta deal ', 1, 'test deal title in EN', 0, 0, 1, 'Y', 10.00, 20.00, '1', 1, 1, 0, 0, 'deals/2013/0426/13669735171752.jpg', '', 'Y', 1375267680, 1364813280, 1375267680, 1, 5, '40.7902778', '-73.9597222', 'new york, usa', 1234, 'approved', '', '#', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `insta_details`
--

CREATE TABLE IF NOT EXISTS `insta_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deal_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `title` text CHARACTER SET utf8 NOT NULL,
  `notice` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `deal_id` (`deal_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `insta_details`
--

INSERT INTO `insta_details` (`id`, `deal_id`, `lang_id`, `title`, `notice`) VALUES
(1, 1, 1, 'test deal title in EN', 'Description for fine print in EN '),
(2, 1, 1, 'Test insta deal ', '');

-- --------------------------------------------------------

--
-- Table structure for table `invite`
--

CREATE TABLE IF NOT EXISTS `invite` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `admin_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_ip` varchar(16) DEFAULT NULL,
  `other_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `other_user_ip` varchar(16) DEFAULT NULL,
  `deals_id` int(10) unsigned NOT NULL DEFAULT '0',
  `pay` enum('Y','N') NOT NULL DEFAULT 'N',
  `credit` int(10) unsigned NOT NULL DEFAULT '0',
  `buy_time` int(10) unsigned NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNQ_uo` (`user_id`,`other_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `invite`
--


-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE IF NOT EXISTS `invoice` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `deal_id` int(10) unsigned NOT NULL DEFAULT '0',
  `order_id` int(10) unsigned NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(30) DEFAULT NULL,
  `paid` enum('Y','N') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNQ_uo` (`user_id`,`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `invoice`
--


-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE IF NOT EXISTS `language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `code` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL,
  `deleted` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`id`, `name`, `code`, `status`, `deleted`) VALUES
(1, 'English', 'en', 'enabled', 0);

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `datetime` int(10) NOT NULL,
  `userid` int(10) NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `comments` text CHARACTER SET utf8 NOT NULL,
  `error` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`ID`, `datetime`, `userid`, `description`, `comments`, `error`) VALUES
(1, 1366621492, 1, 'Login', 'info@cloneportal.com', 0),
(2, 1366621931, 1, 'Login', 'info@cloneportal.com', 0),
(3, 1366633902, 0, 'Login', 'info@cloneportal.com', 1),
(4, 1366633925, 1, 'Login', 'info@cloneportal.com', 0),
(5, 1366634605, 1, 'Login', 'info@cloneportal.com', 0),
(6, 1366636288, 1, 'Login', 'info@cloneportal.com', 0),
(7, 1366869212, 1, 'Login', 'info@cloneportal.com', 0),
(8, 1366869370, 1, 'Deal Added', 'Deal Type:Regular, Deal ID:2', 0),
(9, 1366869378, 1, 'Deal Updated', 'Deal ID:2', 0),
(10, 1366869728, 1, 'Deal Updated', 'Deal ID:2', 0),
(11, 1366878374, 1, 'Deal Updated', 'Deal ID:2', 0),
(12, 1366895510, 1, 'Login', 'info@cloneportal.com', 0),
(13, 1366895659, 1, 'Deal Updated', 'Deal ID:2', 0),
(14, 1366895695, 1, 'Deal Updated', 'Deal ID:2', 0),
(15, 1366895988, 1, 'Deal Updated', 'Deal ID:2', 0),
(16, 1366965608, 1, 'Login', 'info@cloneportal.com', 0),
(17, 1366972811, 1, 'Deal Added', 'Deal Type:Regular, Deal ID:3', 0),
(18, 1366972821, 1, 'Deal Updated', 'Deal ID:3', 0),
(19, 1366972891, 1, 'Deal Added', 'Deal Type:Regular, Deal ID:4', 0),
(20, 1366972898, 1, 'Deal Updated', 'Deal ID:4', 0),
(21, 1366972947, 1, 'Deal Added', 'Deal Type:Regular, Deal ID:5', 0),
(22, 1366972957, 1, 'Deal Updated', 'Deal ID:5', 0),
(23, 1366972966, 1, 'Deal Updated', 'Deal ID:5', 0),
(24, 1366973004, 1, 'Deal Updated', 'Deal ID:4', 0),
(25, 1366973075, 1, 'Deal Added', 'Deal Type:Regular, Deal ID:6', 0),
(26, 1366973084, 1, 'Deal Updated', 'Deal ID:6', 0),
(27, 1366973517, 1, 'Deal Added', 'Deal Type:Insta, Deal ID:1', 0),
(28, 1366973525, 1, 'Deal Updated', 'Deal Type:Insta, Deal ID:1', 0),
(29, 1366973574, 1, 'Deal Updated', 'Deal Type:Insta, Deal ID:1', 0),
(30, 1366973681, 1, 'Deal Updated', 'Deal Type:Insta, Deal ID:1', 0),
(31, 1366976693, 1, 'Login', 'info@cloneportal.com', 0),
(32, 1366977167, 1, 'Login', 'info@cloneportal.com', 0),
(33, 1366985960, 1, 'Login', 'info@cloneportal.com', 0),
(34, 1367037831, 1, 'Login', 'info@cloneportal.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE IF NOT EXISTS `options` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `deals_id` int(10) NOT NULL,
  `title` varchar(300) NOT NULL,
  `options_price` double(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `options`
--


-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pay_id` varchar(32) DEFAULT NULL,
  `service` varchar(16) NOT NULL DEFAULT 'paypal',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `admin_id` int(10) unsigned NOT NULL DEFAULT '0',
  `deals_id` int(10) unsigned NOT NULL DEFAULT '0',
  `city_id` int(10) unsigned NOT NULL DEFAULT '0',
  `card_id` varchar(16) DEFAULT NULL,
  `state` enum('unpay','pay') NOT NULL DEFAULT 'unpay',
  `quantity` int(10) unsigned NOT NULL DEFAULT '1',
  `realname` varchar(32) DEFAULT NULL,
  `mobile` varchar(128) DEFAULT NULL,
  `zipcode` char(6) DEFAULT NULL,
  `address` varchar(128) DEFAULT NULL,
  `express` enum('Y','N') NOT NULL DEFAULT 'Y',
  `express_xx` varchar(128) DEFAULT NULL,
  `express_id` int(10) unsigned NOT NULL DEFAULT '0',
  `express_no` varchar(32) DEFAULT NULL,
  `option_id` int(15) NOT NULL,
  `option_title` varchar(300) NOT NULL,
  `option_price` double(10,2) NOT NULL,
  `price` double(10,2) NOT NULL DEFAULT '0.00',
  `money` double(10,2) NOT NULL DEFAULT '0.00',
  `origin` double(10,2) NOT NULL DEFAULT '0.00',
  `credit` double(10,2) NOT NULL DEFAULT '0.00',
  `card` double(10,2) NOT NULL DEFAULT '0.00',
  `fare` double(10,2) NOT NULL DEFAULT '0.00',
  `remark` text,
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `isgift` varchar(11) NOT NULL DEFAULT 'No',
  `giftemail` varchar(50) NOT NULL,
  `giftname` text NOT NULL,
  `giftmsg` text NOT NULL,
  `isinsta` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNQ_p` (`pay_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `order`
--


-- --------------------------------------------------------

--
-- Table structure for table `partner`
--

CREATE TABLE IF NOT EXISTS `partner` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `title` varchar(128) DEFAULT NULL,
  `homepage` varchar(128) DEFAULT NULL,
  `city_id` int(10) unsigned NOT NULL DEFAULT '0',
  `bank_name` varchar(128) DEFAULT NULL,
  `bank_no` varchar(128) DEFAULT NULL,
  `bank_user` varchar(128) DEFAULT NULL,
  `location` text NOT NULL,
  `contact` varchar(32) DEFAULT NULL,
  `phone` varchar(18) DEFAULT NULL,
  `address` varchar(128) DEFAULT NULL,
  `addres` varchar(128) DEFAULT NULL,
  `other` text,
  `mobile` varchar(12) DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `commission` int(11) NOT NULL,
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNQ_ct` (`city_id`,`title`),
  UNIQUE KEY `UNQ_u` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `partner`
--

INSERT INTO `partner` (`id`, `username`, `password`, `title`, `homepage`, `city_id`, `bank_name`, `bank_no`, `bank_user`, `location`, `contact`, `phone`, `address`, `addres`, `other`, `mobile`, `user_id`, `commission`, `create_time`) VALUES
(1, 'partner', '35cea906180d72b3001787a208d90667', 'GRIPSELL TECHNOLOGIES', 'http://www.gripsell.com', 0, '', '', '', 'NY, USA', 'Gripsell Technologies', '999999999', 'NY, USA', NULL, '<p>Gripsell Adv w/Secured Arch Script</p>', '999999999', 1, 0, 1289313146);

-- --------------------------------------------------------

--
-- Table structure for table `pay`
--

CREATE TABLE IF NOT EXISTS `pay` (
  `id` varchar(32) NOT NULL DEFAULT '',
  `order_id` int(10) unsigned NOT NULL DEFAULT '0',
  `bank` varchar(32) DEFAULT NULL,
  `money` double(10,2) DEFAULT NULL,
  `currency` enum('SGD','USD') NOT NULL DEFAULT 'SGD',
  `service` varchar(16) NOT NULL DEFAULT 'paypal',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNQ_o` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pay`
--


-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `name` char(3) NOT NULL,
  `value` mediumtext NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--


-- --------------------------------------------------------

--
-- Table structure for table `subscribe`
--

CREATE TABLE IF NOT EXISTS `subscribe` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(128) DEFAULT NULL,
  `city_id` int(10) unsigned NOT NULL DEFAULT '0',
  `secret` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNQ_e` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `subscribe`
--


-- --------------------------------------------------------

--
-- Table structure for table `system`
--

CREATE TABLE IF NOT EXISTS `system` (
  `id` enum('1') NOT NULL DEFAULT '1',
  `value` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `system`
--

INSERT INTO `system` (`id`, `value`) VALUES
('1', 'eyJzeXN0ZW0iOnsibW9kZW9mZiI6IjAiLCJzaXRlbmFtZSI6IkdyaXBzZWxsIEJlc3QgRGFpbHkgRGVhbHMgR3JvdXAgQnV5aW5nIFBIUCBTY3JpcHQiLCJzaXRldGl0bGUiOiJHcmlwc2VsbCBCZXN0IERhaWx5IERlYWxzIEdyb3VwIEJ1eWluZyBQSFAgU2NyaXB0IiwiY3BlbWFpbCI6ImluZm9AY2xvbmVwb3J0YWwuY29tIiwiY3BwaG9uZSI6IiArNjg2MTIzNDEyMzQiLCJhYmJyZXZpYXRpb24iOiJHcmlwc2VsbCIsImJnc3RyZXRjaCI6IjEiLCJsYW5nIjoiZW4iLCJsYW5nc2VsZWN0IjoiMSIsImNvdXBvbm5hbWUiOiJWb3VjaGVyIiwidGltZXpvbmUiOiJFU1QiLCJjdXJyZW5jeSI6IiQiLCJjdXJyY29kZSI6IlVTRCIsImludml0ZWNyZWRpdCI6IjUiLCJlbWFpbHZlcmlmeSI6MSwiZGVhbGFsZXJ0IjoiMSIsIm11bHRpcHVyY2hhc2UiOiIxIiwic2lkZWRlYWxzIjoiMSIsInNkbnVtYmVyIjoiNSIsInNkdGltZXIiOiI1MDAwIiwic2hvd2ZiIjoiMSIsImZiaWQiOiJncmlwc2VsbHRlY2giLCJmYmFwcGlkIjoiMTI3ODA5MzUwNjEwMTM2IiwiZmJhcHBrZXkiOiJkOTE0ZjMwNTFlNTljNDdhMTI1MTQ1ODdhNDlmNzZjMSIsImZic2VjaWQiOiJkNDk5ODRmMDRjNjM5MzQzZDFjMzNiYzNhZmU4MDBmMyIsInNob3d0d2VldCI6IjEiLCJ0d2VldGlkIjoidHdpdHRlciIsInR3ZWV0Y250IjoiNSIsImdtYXBrZXkiOiJBQlFJQUFBQVR1c0ptMkhUOUUwMHRhNFhLM0RfRlJRYU82Y2M0YVF0aVNWWXNwSkdndDlyeHEyVHl4UWlhcTE5MXBta2NqLS1DM29FZEcxeVJIRXRBQSIsImdtYXB6b29tIjoiMTIiLCJnYWNvZGUiOiI8c2NyaXB0IHR5cGU9XCJ0ZXh0XC9qYXZhc2NyaXB0XCI+XHJcblxyXG4gIHZhciBfZ2FxID0gX2dhcSB8fCBbXTtcclxuICBfZ2FxLnB1c2goWydfc2V0QWNjb3VudCcsICdVQS0yMDM2Mzk3NS0yJ10pO1xyXG4gIF9nYXEucHVzaChbJ190cmFja1BhZ2V2aWV3J10pO1xyXG5cclxuICAoZnVuY3Rpb24oKSB7XHJcbiAgICB2YXIgZ2EgPSBkb2N1bWVudC5jcmVhdGVFbGVtZW50KCdzY3JpcHQnKTsgZ2EudHlwZSA9ICd0ZXh0XC9qYXZhc2NyaXB0JzsgZ2EuYXN5bmMgPSB0cnVlO1xyXG4gICAgZ2Euc3JjID0gKCdodHRwczonID09IGRvY3VtZW50LmxvY2F0aW9uLnByb3RvY29sID8gJ2h0dHBzOlwvXC9zc2wnIDogJ2h0dHA6XC9cL3d3dycpICsgJy5nb29nbGUtYW5hbHl0aWNzLmNvbVwvZ2EuanMnO1xyXG4gICAgdmFyIHMgPSBkb2N1bWVudC5nZXRFbGVtZW50c0J5VGFnTmFtZSgnc2NyaXB0JylbMF07IHMucGFyZW50Tm9kZS5pbnNlcnRCZWZvcmUoZ2EsIHMpO1xyXG4gIH0pKCk7XHJcblxyXG48XC9zY3JpcHQ+IiwibXNlcnZpY2UiOiIxIiwibW9iaWxlIjoiMSIsIm1sb2NhdGlvbiI6Imh0dHA6XC9cL2RlbW9wcm8uZ3JpcHNlbGwuY29tXC9tIiwiY29uZHVzZXIiOjAsInBhcnRuZXJkb3duIjoxLCJmb3J1bSI6MSwiZ3ppcCI6MCwiaWNwIjoiIiwid3d3cHJlZml4IjoiaHR0cDpcL1wvZXhhbXBsZS5jb21cL2dyaXBhZHZfbmV3X2JhY2tlbmQiLCJpbWdwcmVmaXgiOiJodHRwOlwvXC9leGFtcGxlLmNvbVwvZ3JpcGFkdl9uZXdfYmFja2VuZCJ9LCJwYXlwYWwiOnsibWlkIjoiaW5mb0BjbG9uZXBvcnRhbC5jb20iLCJhY2MiOiJpbmZvQGNsb25lcG9ydGFsLmNvbSIsIm1vZCI6Imh0dHBzOlwvXC93d3cucGF5cGFsLmNvbVwvY2dpLWJpblwvd2Vic2NyIn0sInBhZ3NlZ3VybyI6eyJtaWQiOiJnaGdoaCIsImFjYyI6IkBkZmRzZnNkLmNvbSJ9LCJhdXRob3JpemVuZXQiOnsiYWNjIjoiIiwic2VjIjoiIiwiQWxsb3dNQyI6IjEiLCJBbGxvd1Zpc2EiOiIxIiwiQWxsb3dBbWV4IjoiMCIsIkFsbG93RGlzY292ZXIiOiIwIiwiQWxsb3dKQ0IiOiIwIiwiQWxsb3dEaW5lcnMiOiIwIiwiQWxsb3dDYXJ0ZUJsYW5jaGUiOiIwIiwiQWxsb3dFblJvdXRlIjoiMCIsIkFsbG93RUNoZWNrcyI6IjAiLCJBbGxvd0ludGVybmF0aW9uYWwiOiIwIiwidmVyc2lvbiI6IiIsInRlc3RfbW9kZSI6IjAiLCJBbGxvd1Rlc3RPdmVycmlkZSI6IjAiLCJkZWxpbV9kYXRhIjoiMCIsImRlbGltX2NoYXIiOiIiLCJlbmNhcF9jaGFyIjoiIiwicmVsYXlfcmVzcG9uc2UiOiIwIiwidXJsIjoiIiwiY3VybF9sb2NhdGlvbiI6IiIsIlBheW1lbnRBcHByb3ZlZFBhZ2UiOiIiLCJQYXltZW50RGVuaWVkUGFnZSI6IiIsIk1ENUhhc2giOiIifSwib3RoZXIiOnsicGF5IjoiIn0sIm1haWwiOnsibWFpbCI6Im1haWwiLCJob3N0IjoiIiwicG9ydCI6IiIsInNzbCI6IiIsInVzZXIiOiIiLCJwYXNzIjoiIiwiZnJvbSI6ImluZm9AY2xvbmVwb3J0YWwuY29tIiwicmVwbHkiOiJpbmZvQGNsb25lcG9ydGFsLmNvbSJ9LCJzdWJzY3JpYmUiOnsiaGVscHBob25lIjoiIiwiaGVscGVtYWlsIjoiIn0sImlkIjoiMSIsImJ1bGxldGluIjp7IjAiOiIiLCI3IjoiIiwiMTUiOiIiLCI2IjoiIiwiNCI6IiIsIjExIjoiIiwiMyI6IiIsIjUiOiIiLCIyMiI6IiIsIjIiOiIiLCIyMSI6IiIsIjgiOiIiLCIxNCI6IiIsIjIzIjoiIiwiMTIiOiIifSwiY2hhcml0eSI6eyJzaG93Y2hhcml0eSI6IjEiLCJjaGFyb3BhIjoiT3JwaGFuYWdlIiwiY2hhcm9wYWMiOiIxMCIsImNoYXJvcGIiOiJPbGQgQWdlIEhvbWUiLCJjaGFyb3BiYyI6IjEwIiwiY2hhcm9wYyI6IldpZG93IEZ1bmRzIiwiY2hhcm9wY2MiOiIxMCJ9LCJwcmVyZWwiOnsicmVsZWFzZXIiOjAsInJlbGVhc2VkYXRlIjoxLCJyZWxlYXNlbW9udGgiOjExLCJyZWxlYXNleWVhciI6MjAxMSwicmVsZWFzZWhvdXIiOjAsInJlbGVhc2VtaW4iOjAsInJlbGVhc2VzZWMiOjAsInJlbGVhc2Vtc2ciOiJHZXQgZ3JlYXQgZGVhbHMgYXQgOTAlIGRpc2NvdW50LiIsInJlbGVhc2Vjb2RlIjoiYWNjZXNzY29kZSJ9LCJzeXN0ZW1bJ2dhY29kZSddIjoiIiwiZGlzcGxheSI6eyJ0aGVtZSI6InVsdHJhIiwiYmciOiIwIiwidGFiYmVkIjoiMSIsInNob3dpbnN0YSI6IjEiLCJkZWZpbnN0YWxvYyI6Ik5ZLCBVU0EiLCJjYXRuYW1lIjoiZGVzYyIsImxpc3RzZCI6IjEiLCJnaWZ0ZGVhbCI6IjEiLCJxYyI6IjEiLCJmYm94IjoiMSIsInJmIjoiMSIsInN1YnBvcCI6IjAiLCJiaWdib3giOiIxIiwic3RhdHMiOiIxIiwicHAiOiIxIn0sImxpY2Vuc2VrZXkiOiJHcmlwb3duLTNmMTM3MjUxMGZiMTA1MWVhN2RmIn0=');

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE IF NOT EXISTS `templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` varchar(16) NOT NULL,
  `value` text,
  `lang_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `templates`
--


-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE IF NOT EXISTS `tickets` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `by` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `uploads` tinyint(3) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `priority` varchar(45) NOT NULL,
  `status` varchar(55) NOT NULL DEFAULT 'New',
  `parent` int(11) NOT NULL DEFAULT '0',
  `DEPARTMENT_ID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tickets`
--


-- --------------------------------------------------------

--
-- Table structure for table `topic`
--

CREATE TABLE IF NOT EXISTS `topic` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(128) DEFAULT NULL,
  `deals_id` int(10) unsigned NOT NULL DEFAULT '0',
  `city_id` int(10) unsigned NOT NULL DEFAULT '0',
  `public_id` int(10) unsigned NOT NULL DEFAULT '0',
  `content` text,
  `head` int(10) unsigned NOT NULL DEFAULT '0',
  `reply_number` int(10) unsigned NOT NULL DEFAULT '0',
  `view_number` int(10) unsigned NOT NULL DEFAULT '0',
  `last_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `last_time` int(10) unsigned NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `topic`
--


-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE IF NOT EXISTS `uploads` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(125) NOT NULL,
  `hash` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `TICKET_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `uploads`
--


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(128) DEFAULT NULL,
  `username` varchar(32) DEFAULT NULL,
  `realname` varchar(32) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `avatar` varchar(128) DEFAULT NULL,
  `gender` enum('M','F') NOT NULL DEFAULT 'M',
  `newbie` enum('Y','N') NOT NULL DEFAULT 'Y',
  `mobile` varchar(16) DEFAULT NULL,
  `qq` varchar(16) DEFAULT NULL,
  `money` double(10,2) NOT NULL DEFAULT '0.00',
  `zipcode` char(6) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city_id` int(10) unsigned NOT NULL DEFAULT '0',
  `enable` enum('Y','N') NOT NULL DEFAULT 'Y',
  `manager` enum('Y','N') NOT NULL DEFAULT 'N',
  `secret` varchar(32) DEFAULT NULL,
  `recode` varchar(32) DEFAULT NULL,
  `ip` varchar(16) DEFAULT NULL,
  `login_time` int(10) unsigned NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `facebook_uid` varchar(20) NOT NULL,
  `facebook_url` varchar(255) NOT NULL,
  `facebook_pic` varchar(255) NOT NULL,
  `fname` varchar(35) NOT NULL,
  `lname` varchar(35) NOT NULL,
  `type` tinyint(3) NOT NULL DEFAULT '0',
  `receive` tinyint(3) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `hash` varchar(32) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `UNQ_name` (`username`),
  UNIQUE KEY `UNQ_e` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `email`, `username`, `realname`, `password`, `avatar`, `gender`, `newbie`, `mobile`, `qq`, `money`, `zipcode`, `address`, `city_id`, `enable`, `manager`, `secret`, `recode`, `ip`, `login_time`, `create_time`, `facebook_uid`, `facebook_url`, `facebook_pic`, `fname`, `lname`, `type`, `receive`, `created`, `hash`) VALUES
(1, 'info@cloneportal.com', 'admin', '', '759bc7fa4438cd873ef26d79d1c4c844', NULL, 'M', 'Y', '', NULL, 100.00, '', '', 4, 'Y', 'Y', '', NULL, 'Admin System', 1366982327, 1289173526, '', '', '', 'Admin', '', 1, 1, '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

CREATE TABLE IF NOT EXISTS `user_address` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `address1` varchar(256) DEFAULT NULL,
  `address2` varchar(256) DEFAULT NULL,
  `city` varchar(128) DEFAULT NULL,
  `state` varchar(128) DEFAULT NULL,
  `country` varchar(128) DEFAULT NULL,
  `phone` varchar(18) DEFAULT NULL,
  `pincode` varchar(18) DEFAULT NULL,
  `type` int(10) unsigned NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNQ_ut` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `user_address`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_department`
--

CREATE TABLE IF NOT EXISTS `user_department` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `USER_ID` int(11) NOT NULL,
  `DEPARTMENT_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `user_department`
--

