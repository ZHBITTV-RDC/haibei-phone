-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2017-08-29 07:39:43
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- 表的结构 `laravel_admin`
--

CREATE TABLE IF NOT EXISTS `laravel_admin` (
  `Admin_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `updated_at` varchar(300) CHARACTER SET utf8mb4 DEFAULT NULL,
  `Admin_password` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'password',
  `Admin_status` int(2) NOT NULL DEFAULT '0' COMMENT 'status',
  `Admin_name` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '' COMMENT 'name',
  `created_at` varchar(300) CHARACTER SET utf8mb4 DEFAULT NULL,
  PRIMARY KEY (`Admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `laravel_admin`
--

INSERT INTO `laravel_admin` (`Admin_id`, `updated_at`, `Admin_password`, `Admin_status`, `Admin_name`, `created_at`) VALUES
(1, NULL, 'eyJpdiI6Ikd4WFQ0VnlBVUlGeitDQktPQXpRSVE9PSIsInZhbHVlIjoiNnN6bDRNUmVzbnBNZzF3UTREVmJRUT09IiwibWFjIjoiM2UxOWZjY2ZmYmEwMmQ3NjkzMWNhMjcwZjZiYjIxODM3ODM4ZTVkMmJlNTg3ZjU3OTQ2MDA2ZWMxZGYyOWIwNyJ9', 0, 'Admin', NULL),
(2, '2017-07-28 12:57:27', 'eyJpdiI6IkFcL1hDdjNPV3dWcjZjTmxkcFhFWUNnPT0iLCJ2YWx1ZSI6Ik1cL2ZjTVJPY0J2bEE0NTlBUGVta0h3PT0iLCJtYWMiOiI4MGE3MGI3YTI5MTk5YWU4ZDkxM2JmMzI0ZWQ3YTJmMWMwZjBiZjU5MjYyYTM2M2FjZmQ1ZWY4MjZiNDZkNDBhIn0=', 0, 'user', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `laravel_content`
--

CREATE TABLE IF NOT EXISTS `laravel_content` (
  `content_title` varchar(20) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '标题',
  `content_data` varchar(1000) CHARACTER SET utf8 DEFAULT ' ' COMMENT '详细内容',
  `content_cover` varchar(200) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '视频封面地址',
  `content_vedio` varchar(200) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '视频地址',
  `content_status` int(11) DEFAULT NULL COMMENT '状态：1在线；0：下架',
  `content_id` int(200) NOT NULL AUTO_INCREMENT,
  `content_class` int(10) DEFAULT NULL COMMENT '1：2015级，2：2016级，3：2017级',
  `created_at` varchar(300) CHARACTER SET utf8mb4 DEFAULT NULL,
  `updated_at` varchar(300) CHARACTER SET utf8mb4 DEFAULT NULL,
  `content_abstract` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_danish_ci DEFAULT NULL COMMENT '简介',
  `content_visitors` int(10) DEFAULT '0' COMMENT '访问数',
  PRIMARY KEY (`content_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='内容表' AUTO_INCREMENT=90 ;

--
-- 转存表中的数据 `laravel_content`
--

INSERT INTO `laravel_content` (`content_title`, `content_data`, `content_cover`, `content_vedio`, `content_status`, `content_id`, `content_class`, `created_at`, `updated_at`, `content_abstract`, `content_visitors`) VALUES
('d', '', '/uploads/image/2017-08-27-12-14-33-59a2b7a9af993.jpg', '0', 1, 88, 1, NULL, '2017-08-28 17:49:05', 'd1', 1),
('f', '<p>sss<br/></p>', '/uploads/image/2017-08-27-12-15-05-59a2b7c9ad4c3.jpg', '0', 1, 89, 2, NULL, '2017-08-27 12:29:11', 'ss', 1);

-- --------------------------------------------------------

--
-- 表的结构 `laravel_migrations`
--

CREATE TABLE IF NOT EXISTS `laravel_migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `laravel_migrations`
--

INSERT INTO `laravel_migrations` (`migration`, `batch`) VALUES
('2014_02_09_225721_create_visitor_registry', 1),
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2017_08_11_113549_add_post_id_to_visitor_registry', 2);

-- --------------------------------------------------------

--
-- 表的结构 `laravel_password_resets`
--

CREATE TABLE IF NOT EXISTS `laravel_password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `laravel_users`
--

CREATE TABLE IF NOT EXISTS `laravel_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `laravel_visitor_registry`
--

CREATE TABLE IF NOT EXISTS `laravel_visitor_registry` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `clicks` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `article_id` int(100) DEFAULT NULL COMMENT '文章Id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=29 ;

--
-- 转存表中的数据 `laravel_visitor_registry`
--

INSERT INTO `laravel_visitor_registry` (`id`, `ip`, `country`, `clicks`, `created_at`, `updated_at`, `article_id`) VALUES
(27, '127.0.0.1', NULL, 5, '2017-08-27 04:15:10', '2017-08-27 04:29:11', 89),
(28, '127.0.0.1', NULL, 11, '2017-08-27 04:15:15', '2017-08-28 09:49:04', 88);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
