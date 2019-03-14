SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE TABLE IF NOT EXISTS `taches` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `texte` varchar(255) CHARACTER SET utf8 NOT NULL,
  `termine` TINYINT DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
