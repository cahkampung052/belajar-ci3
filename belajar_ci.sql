-- Adminer 4.7.7 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE DATABASE `belajar_ci` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `belajar_ci`;

DROP TABLE IF EXISTS `m_user`;
CREATE TABLE `m_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `m_user` (`id`, `nama`, `email`, `password`) VALUES
(1,	'Wahyu Agung Tribawono',	'wahyu@admin.com',	'8cb2237d0679ca88db6464eac60da96345513964'),
(2,	'Wahyu Agung Tribawono',	'wahyu@gmail.com',	'8cb2237d0679ca88db6464eac60da96345513964');

-- 2022-03-02 07:04:52
