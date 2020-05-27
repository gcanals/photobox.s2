-- Adminer 4.2.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `photobox_categorie`;
CREATE TABLE `photobox_categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(64) NOT NULL,
  `descr` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `photobox_comment`;
CREATE TABLE `photobox_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(64) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `content` text,
  `c_id` int(11) DEFAULT NULL,
  `p_id` int(11) NOT NULL,
  `titre` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `photobox_photo`;
CREATE TABLE `photobox_photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(64) NOT NULL,
  `file` varchar(126) NOT NULL,
  `descr` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `format` varchar(8) DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `size` bigint(20) DEFAULT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `type` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2017-01-06 14:06:11
