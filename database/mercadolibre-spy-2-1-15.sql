# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.40)
# Database: mercadolibre-spy
# Generation Time: 2015-02-01 06:31:35 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table analysis
# ------------------------------------------------------------

DROP TABLE IF EXISTS `analysis`;

CREATE TABLE `analysis` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `created` date DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `analysis` WRITE;
/*!40000 ALTER TABLE `analysis` DISABLE KEYS */;

INSERT INTO `analysis` (`id`, `name`, `created`, `status`)
VALUES
	(1,'Amario Plastico','2015-01-31','active');

/*!40000 ALTER TABLE `analysis` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table items
# ------------------------------------------------------------

DROP TABLE IF EXISTS `items`;

CREATE TABLE `items` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `analysis_id` int(11) DEFAULT NULL,
  `source_id` int(11) DEFAULT NULL,
  `following` enum('yes','no') DEFAULT NULL,
  `meli_status` varchar(20) DEFAULT NULL,
  `meli_id` varchar(20) DEFAULT NULL,
  `finish_date` datetime DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `currency` enum('ars','usd','eur') DEFAULT NULL,
  `buying_mode` varchar(20) DEFAULT NULL,
  `category_id` varchar(10) DEFAULT NULL,
  `last_updated` datetime DEFAULT NULL,
  `sold` int(11) DEFAULT NULL,
  `visits` int(11) DEFAULT NULL,
  `available_quantity` int(11) DEFAULT NULL,
  `publication_type` varchar(30) DEFAULT '',
  `last_cron_run` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `analysis_id` (`analysis_id`,`meli_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;

INSERT INTO `items` (`id`, `analysis_id`, `source_id`, `following`, `meli_status`, `meli_id`, `finish_date`, `title`, `created`, `seller_id`, `price`, `currency`, `buying_mode`, `category_id`, `last_updated`, `sold`, `visits`, `available_quantity`, `publication_type`, `last_cron_run`)
VALUES
	(1,1,1,'yes','','MLA538528804','2015-02-21 21:02:12','Armario Colombraro Plastico Baño Lavadero','0000-00-00 00:00:00',129456144,2019,'ars','buy_it_now','MLA11043','0000-00-00 00:00:00',14,4773,2,'gold_premium','2015-01-31 22:18:53'),
	(2,1,1,'yes','active','MLA542374771','2015-03-21 19:03:58','Armario Plastico 3 Est- Gabinete- Deposito- Estanteria Keter','2015-01-20 19:03:58',36208094,2300,'ars','buy_it_now','MLA11043','2015-01-25 22:20:36',46,14163,3,'gold','2015-01-31 22:18:54'),
	(3,1,1,'yes','','MLA543343106','2015-03-28 18:05:56','Baul Plastico Keter. Gabinete Estanteria Deposito Armario','0000-00-00 00:00:00',36208094,1400,'ars','buy_it_now','MLA11043','0000-00-00 00:00:00',8,2875,3,'silver','2015-01-31 22:18:53'),
	(4,1,1,'yes','','MLA542374892','2015-03-21 19:04:38','Armario Plastico Gabinete Deposito Estanteria Keter O Rimax','0000-00-00 00:00:00',36208094,3200,'ars','buy_it_now','MLA11043','0000-00-00 00:00:00',12,14351,1,'silver','2015-01-31 22:18:53'),
	(5,1,1,NULL,'','MLA541933275','2015-03-18 21:44:52','Armario Plástico Deposito Estantería Exterior Rimax Excelent','0000-00-00 00:00:00',142509698,2804.99,'ars','buy_it_now','MLA11043','0000-00-00 00:00:00',1,NULL,2,'silver','2015-01-31 22:18:53'),
	(6,1,1,NULL,'','MLA542443257','2015-03-22 02:18:21','Armario Plastico Gabinete Multiuso Deposito Estanteria Rimax','0000-00-00 00:00:00',142509698,3799.99,'ars','buy_it_now','MLA11043','0000-00-00 00:00:00',3,NULL,2,'silver','2015-01-31 22:18:53'),
	(7,1,1,NULL,'','MLA542296312','2015-03-21 11:08:24','Armario Plastico Gabinete Escobero Deposito Estanteria Rimax','0000-00-00 00:00:00',142509698,3799.99,'ars','buy_it_now','MLA11043','0000-00-00 00:00:00',3,NULL,19,'silver','2015-01-31 22:18:53'),
	(8,1,1,NULL,'','MLA542731916','2015-03-24 12:08:34','Armario Keter, Deposito Plastico, Grande, Resistente  Exteri','0000-00-00 00:00:00',144427409,6999.99,'ars','buy_it_now','MLA11043','0000-00-00 00:00:00',2,NULL,1,'silver','2015-01-31 22:18:53'),
	(9,1,1,NULL,'','MLA542229413','2015-03-20 20:58:08','Armario Colombraro Plastico Baño Lavadero Bajo','0000-00-00 00:00:00',129456144,1150,'ars','buy_it_now','MLA11043','0000-00-00 00:00:00',1,NULL,7,'bronze','2015-01-31 22:18:53'),
	(10,1,1,NULL,'','MLA537451387','2015-02-14 12:46:29','Mueble Armario Plástico Alto Estantes Colombraro','0000-00-00 00:00:00',47536259,3200,'ars','buy_it_now','MLA11043','0000-00-00 00:00:00',2,NULL,2,'silver','2015-01-31 22:18:53'),
	(11,1,1,NULL,'','MLA537451393','2015-02-14 12:46:29','Mueble Armario Plástico Colombraro Lavadero Cocina Baño','0000-00-00 00:00:00',47536259,2190,'ars','buy_it_now','MLA11043','0000-00-00 00:00:00',0,NULL,2,'silver','2015-01-31 22:18:53'),
	(12,1,1,NULL,'','MLA537943986','2015-03-07 13:48:45','Mueble Armario Plástico Colombraro Lavadero Cocina Baño','0000-00-00 00:00:00',47536259,1210,'ars','buy_it_now','MLA11043','0000-00-00 00:00:00',0,NULL,2,'silver','2015-01-31 22:18:53'),
	(13,1,1,'yes','active','MLA543411440','2015-03-29 01:57:55','Armario Plástico Grande Para Lavadero Baño Jardin O Cochera','2015-01-28 01:57:09',82289468,2199,'ars','buy_it_now','MLA11043','2015-01-28 21:55:03',0,2432,10,'silver','2015-01-31 22:18:54'),
	(14,1,1,NULL,'','MLA542234052','2015-03-20 21:23:46','Armario Colombraro Plastico Baño Lavadero Bajo Bicolor','0000-00-00 00:00:00',129456144,1180,'ars','buy_it_now','MLA11043','0000-00-00 00:00:00',0,NULL,8,'bronze','2015-01-31 22:18:53'),
	(15,1,1,'yes','active','MLA543251257','2015-03-28 03:00:00','Armario Plástico Mediano Para Lavadero Baño Jardin O Cochera','2015-01-27 03:00:00',82289468,1799,'ars','buy_it_now','MLA11043','2015-01-28 21:55:02',0,47,10,'bronze','2015-01-31 22:18:54'),
	(16,1,1,NULL,'','MLA543638519','2015-03-30 18:55:23','Armario Plastico 3 Estantes - Deposito - Gabinete- Escobero','0000-00-00 00:00:00',168205093,2300,'ars','buy_it_now','MLA11043','0000-00-00 00:00:00',0,NULL,10,'bronze','2015-01-31 22:18:53'),
	(17,1,1,NULL,'','MLA543753356','2015-03-31 14:49:47','Armario Plastico - Mueble Para Baño Lavadero Cochera Balcon','0000-00-00 00:00:00',168205093,1790,'ars','buy_it_now','MLA11043','0000-00-00 00:00:00',0,NULL,50,'bronze','2015-01-31 22:18:53');

/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table sources
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sources`;

CREATE TABLE `sources` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `analysis_id` int(11) DEFAULT NULL,
  `type` enum('meli_category','meli_search','meli_csv') DEFAULT NULL,
  `last_cron_run` datetime DEFAULT '0000-00-00 00:00:00',
  `body` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `sources` WRITE;
/*!40000 ALTER TABLE `sources` DISABLE KEYS */;

INSERT INTO `sources` (`id`, `analysis_id`, `type`, `last_cron_run`, `body`)
VALUES
	(1,1,'meli_search','2015-01-31 22:18:53','armario plastico'),
	(2,1,'meli_csv','2015-01-31 22:18:54','MLA543411440,MLA543251257,MLA542374771');

/*!40000 ALTER TABLE `sources` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
