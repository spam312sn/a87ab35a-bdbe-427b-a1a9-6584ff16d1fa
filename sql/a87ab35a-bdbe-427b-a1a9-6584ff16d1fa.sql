-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 02, 2017 at 03:15 PM
-- Server version: 5.5.54-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+02:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `a87ab35a-bdbe-427b-a1a9-6584ff16d1fa`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--
-- Creation: Mar 02, 2017 at 11:20 AM
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id`         INT(11)               NOT NULL AUTO_INCREMENT,
  `user_id`    INT(11)               NOT NULL,
  `post`       TEXT COLLATE utf8_bin NOT NULL,
  `created_at` DATETIME              NOT NULL,
  `deleted`    TINYINT(1)            NOT NULL DEFAULT '0',
  `deleted_at` DATETIME                       DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_bin
  AUTO_INCREMENT = 1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
-- Creation: Mar 02, 2017 at 11:18 AM
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id`         INT(11)          NOT NULL AUTO_INCREMENT,
  `username`   VARCHAR(255)
               COLLATE utf8_bin NOT NULL
  COMMENT 'email/username',
  `token`      VARCHAR(64)
               COLLATE utf8_bin          DEFAULT NULL
  COMMENT 'SHA256',
  `first_name` VARCHAR(30)
               COLLATE utf8_bin          DEFAULT NULL,
  `last_name`  VARCHAR(30)
               COLLATE utf8_bin          DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_bin
  AUTO_INCREMENT = 1;

/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
