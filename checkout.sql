-- Adminer 4.8.1 MySQL 5.7.40-0ubuntu0.18.04.1 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `checkout`;
CREATE DATABASE `checkout` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `checkout`;

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `item` varchar(25) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `image` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `products` (`id`, `item`, `unit_price`, `image`) VALUES
(1,	'A',	50.00,	'item-a.jpg'),
(2,	'B',	30.00,	'item-b.png'),
(3,	'C',	20.00,	'item-c.png'),
(4,	'D',	15.00,	'item-d.png'),
(5,	'E',	5.00,	'item-e.png');

DROP TABLE IF EXISTS `special_offers`;
CREATE TABLE `special_offers` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `product_id` int(10) NOT NULL,
  `unit` int(10) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `linked_product_price` int(10) DEFAULT NULL,
  `offer_status` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `special_offers` (`id`, `product_id`, `unit`, `price`, `linked_product_price`, `offer_status`) VALUES
(1,	1,	3,	130.00,	NULL,	'1'),
(2,	2,	2,	45.00,	NULL,	'1'),
(3,	3,	2,	38.00,	NULL,	'1'),
(4,	3,	3,	56.00,	NULL,	'1'),
(5,	4,	1,	5.00,	1,	'1');

-- 2022-11-15 15:16:32
