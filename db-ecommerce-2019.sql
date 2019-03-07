-- MySQL dump 10.13  Distrib 5.7.23, for Linux (x86_64)
--
-- Host: localhost    Database: db_ecommerce
-- ------------------------------------------------------
-- Server version	5.7.23

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tb_addresses`
--

DROP TABLE IF EXISTS `tb_addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_addresses` (
  `idaddress` int(11) NOT NULL AUTO_INCREMENT,
  `desaddress` varchar(128) NOT NULL,
  `descomplement` varchar(32) DEFAULT NULL,
  `descity` varchar(32) NOT NULL,
  `desstate` varchar(32) NOT NULL,
  `descountry` varchar(32) NOT NULL,
  `deszipcode` char(8) NOT NULL,
  `desdistrict` varchar(32) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idaddress`),
  UNIQUE KEY `deszipcode` (`deszipcode`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_addresses`
--

LOCK TABLES `tb_addresses` WRITE;
/*!40000 ALTER TABLE `tb_addresses` DISABLE KEYS */;
INSERT INTO `tb_addresses` VALUES (3,'Rua Emília Couto','','Salvador','BA','Brasil','40285030','Brotas','2019-03-07 14:34:59'),(4,'Avenida Laurindo Régis','','Salvador','BA','Brasil','40240550','Engenho Velho de Brotas','2019-03-07 14:35:20');
/*!40000 ALTER TABLE `tb_addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_addressescarts`
--

DROP TABLE IF EXISTS `tb_addressescarts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_addressescarts` (
  `idaddressescarts` int(11) NOT NULL AUTO_INCREMENT,
  `idaddress` int(11) NOT NULL,
  `idcart` int(11) NOT NULL,
  `dtremoved` datetime DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idaddressescarts`),
  KEY `fk_addressescarts_addresses` (`idaddress`),
  KEY `fk_addressescarts_carts` (`idcart`),
  CONSTRAINT `fk_addressescarts_addresses` FOREIGN KEY (`idaddress`) REFERENCES `tb_addresses` (`idaddress`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_addressescarts_carts` FOREIGN KEY (`idcart`) REFERENCES `tb_carts` (`idcart`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_addressescarts`
--

LOCK TABLES `tb_addressescarts` WRITE;
/*!40000 ALTER TABLE `tb_addressescarts` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_addressescarts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_carts`
--

DROP TABLE IF EXISTS `tb_carts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_carts` (
  `idcart` int(11) NOT NULL AUTO_INCREMENT,
  `dessessionid` varchar(64) NOT NULL,
  `iduser` int(11) DEFAULT NULL,
  `deszipcode` char(8) DEFAULT NULL,
  `vlfreight` decimal(10,2) DEFAULT NULL,
  `nrdays` int(11) DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcart`),
  KEY `FK_carts_users_idx` (`iduser`),
  CONSTRAINT `fk_carts_users` FOREIGN KEY (`iduser`) REFERENCES `tb_users` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_carts`
--

LOCK TABLES `tb_carts` WRITE;
/*!40000 ALTER TABLE `tb_carts` DISABLE KEYS */;
INSERT INTO `tb_carts` VALUES (11,'ts518knt1k7g3adkmht73fvjh4',NULL,NULL,NULL,NULL,'2019-02-22 23:47:10'),(12,'bnk4dlau0k9ir3vcmqlluvqt17',8,NULL,NULL,NULL,'2019-02-22 23:52:37'),(13,'bnk4dlau0k9ir3vcmqlluvqt17',8,NULL,NULL,NULL,'2019-02-22 23:52:51'),(14,'ts518knt1k7g3adkmht73fvjh4',8,NULL,NULL,NULL,'2019-02-22 23:54:22'),(15,'ts518knt1k7g3adkmht73fvjh4',8,NULL,NULL,NULL,'2019-02-22 23:54:29'),(16,'ts518knt1k7g3adkmht73fvjh4',8,NULL,NULL,NULL,'2019-02-22 23:58:21'),(17,'ts518knt1k7g3adkmht73fvjh4',NULL,NULL,NULL,NULL,'2019-02-23 01:55:42'),(18,'ts518knt1k7g3adkmht73fvjh4',NULL,NULL,NULL,NULL,'2019-02-23 04:11:50'),(19,'prggbkme9l0kthkh6escgl2o92',NULL,NULL,NULL,NULL,'2019-02-23 05:42:46'),(20,'ehdgti2gu1e14rhpe4hidn3v56',NULL,NULL,NULL,NULL,'2019-02-24 22:51:00'),(21,'cphoci8o8eu7qtsk1opv6217p1',NULL,'123123',NULL,NULL,'2019-02-25 12:56:49'),(22,'cphoci8o8eu7qtsk1opv6217p1',NULL,'40285030',104.26,5,'2019-02-25 14:12:33'),(23,'cphoci8o8eu7qtsk1opv6217p1',NULL,'22041080',613.86,1,'2019-02-25 17:52:59'),(24,'cphoci8o8eu7qtsk1opv6217p1',NULL,'22041080',140.16,1,'2019-02-25 19:09:26'),(25,'cphoci8o8eu7qtsk1opv6217p1',NULL,NULL,NULL,NULL,'2019-02-25 23:18:27'),(26,'f58m76cccq85649g48ljuhjas7',NULL,'22041080',441.76,2,'2019-02-27 11:24:01'),(27,'f58m76cccq85649g48ljuhjas7',NULL,'',0.00,0,'2019-02-27 14:54:30'),(28,'1qst6t5d8bei5ngihv39a3j7r0',NULL,NULL,NULL,NULL,'2019-02-27 17:46:06'),(29,'tv40q92rjcmbe3m9qav438j6s6',NULL,'',0.00,0,'2019-02-28 12:48:40'),(30,'qb3u3dsljlsgv99khlbs1ag9b6',NULL,NULL,NULL,NULL,'2019-02-28 14:56:12'),(31,'a4sdk4id4rel320qdb44coq520',NULL,NULL,0.00,0,'2019-02-28 14:58:03'),(32,'tv40q92rjcmbe3m9qav438j6s6',NULL,NULL,0.00,0,'2019-02-28 17:02:37'),(33,'tv40q92rjcmbe3m9qav438j6s6',NULL,'40285030',0.00,0,'2019-02-28 19:22:16'),(34,'68cpvs083ml8jipik4gnvmmom3',NULL,NULL,0.00,0,'2019-03-01 13:15:20'),(35,'0j1i116v7dus9psdephbqbseq1',NULL,NULL,0.00,0,'2019-03-01 15:18:48'),(36,'68cpvs083ml8jipik4gnvmmom3',NULL,NULL,0.00,0,'2019-03-01 17:49:00'),(37,'68cpvs083ml8jipik4gnvmmom3',NULL,'40285030',74.46,1,'2019-03-01 18:59:06'),(38,'0j1i116v7dus9psdephbqbseq1',NULL,NULL,0.00,0,'2019-03-01 19:03:28'),(39,'68cpvs083ml8jipik4gnvmmom3',NULL,NULL,0.00,0,'2019-03-01 21:06:37'),(40,'4mv2n4copfd9e4gqep0j9cgfi5',NULL,NULL,0.00,0,'2019-03-04 13:09:43'),(41,'4mv2n4copfd9e4gqep0j9cgfi5',NULL,NULL,0.00,0,'2019-03-04 21:01:22'),(42,'4mv2n4copfd9e4gqep0j9cgfi5',NULL,'55555555',0.00,0,'2019-03-04 22:50:20'),(43,'s747lv2ti36atur8enpp7jkrv5',NULL,NULL,0.00,0,'2019-03-04 23:31:50'),(44,'9au03vd2ogu4ok2l9tac01b7m6',NULL,NULL,0.00,0,'2019-03-07 14:21:18');
/*!40000 ALTER TABLE `tb_carts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_cartsproducts`
--

DROP TABLE IF EXISTS `tb_cartsproducts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_cartsproducts` (
  `idcartproduct` int(11) NOT NULL AUTO_INCREMENT,
  `idcart` int(11) NOT NULL,
  `idproduct` int(11) NOT NULL,
  `dtremoved` datetime DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcartproduct`),
  KEY `FK_cartsproducts_carts_idx` (`idcart`),
  KEY `FK_cartsproducts_products_idx` (`idproduct`),
  CONSTRAINT `fk_cartsproducts_carts` FOREIGN KEY (`idcart`) REFERENCES `tb_carts` (`idcart`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cartsproducts_products` FOREIGN KEY (`idproduct`) REFERENCES `tb_products` (`idproduct`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_cartsproducts`
--

LOCK TABLES `tb_cartsproducts` WRITE;
/*!40000 ALTER TABLE `tb_cartsproducts` DISABLE KEYS */;
INSERT INTO `tb_cartsproducts` VALUES (1,17,4,NULL,'2019-02-23 01:58:26'),(2,17,4,NULL,'2019-02-23 01:58:34'),(3,17,4,NULL,'2019-02-23 01:58:41'),(4,17,3,NULL,'2019-02-23 02:16:09'),(5,17,1,NULL,'2019-02-23 02:18:22'),(6,17,3,NULL,'2019-02-23 02:46:13'),(7,18,2,'2019-02-23 01:15:16','2019-02-23 04:13:28'),(8,18,2,'2019-02-23 01:15:36','2019-02-23 04:14:49'),(9,18,2,'2019-02-23 01:15:57','2019-02-23 04:15:52'),(10,18,2,'2019-02-23 01:17:44','2019-02-23 04:16:12'),(11,18,4,'2019-02-23 01:18:06','2019-02-23 04:18:01'),(12,18,4,'2019-02-23 01:18:10','2019-02-23 04:18:04'),(13,18,3,'2019-02-23 01:22:57','2019-02-23 04:20:17'),(14,18,3,'2019-02-23 01:24:31','2019-02-23 04:20:19'),(15,18,3,'2019-02-23 01:25:07','2019-02-23 04:20:21'),(16,18,3,'2019-02-23 01:25:10','2019-02-23 04:20:23'),(17,18,3,'2019-02-23 01:27:09','2019-02-23 04:20:31'),(18,18,3,'2019-02-23 01:27:09','2019-02-23 04:20:33'),(19,18,4,'2019-02-23 01:23:14','2019-02-23 04:20:42'),(20,18,3,'2019-02-23 01:27:09','2019-02-23 04:23:11'),(21,18,4,'2019-02-23 01:28:01','2019-02-23 04:24:28'),(22,18,4,'2019-02-23 01:28:01','2019-02-23 04:27:13'),(23,18,4,'2019-02-23 01:28:01','2019-02-23 04:27:14'),(24,18,4,'2019-02-23 01:28:01','2019-02-23 04:27:14'),(25,18,4,'2019-02-23 01:28:01','2019-02-23 04:27:15'),(26,18,4,'2019-02-23 01:28:01','2019-02-23 04:27:54'),(27,18,4,'2019-02-23 01:28:46','2019-02-23 04:28:21'),(28,18,4,'2019-02-23 01:28:49','2019-02-23 04:28:44'),(29,18,4,'2019-02-23 01:28:51','2019-02-23 04:28:47'),(30,18,4,'2019-02-23 01:29:36','2019-02-23 04:28:48'),(31,18,4,'2019-02-23 01:29:36','2019-02-23 04:29:31'),(32,18,4,'2019-02-23 01:29:36','2019-02-23 04:29:32'),(33,18,4,'2019-02-23 01:29:36','2019-02-23 04:29:33'),(34,18,4,'2019-02-23 01:29:36','2019-02-23 04:29:33'),(35,18,4,'2019-02-23 01:29:36','2019-02-23 04:29:34'),(36,18,4,'2019-02-23 01:29:36','2019-02-23 04:29:34'),(37,18,4,'2019-02-23 01:31:55','2019-02-23 04:31:08'),(38,18,4,'2019-02-23 01:31:55','2019-02-23 04:31:27'),(39,18,4,'2019-02-23 01:31:55','2019-02-23 04:31:30'),(40,18,4,'2019-02-23 01:31:55','2019-02-23 04:31:44'),(41,18,4,'2019-02-23 01:31:55','2019-02-23 04:31:48'),(42,18,4,'2019-02-23 01:37:39','2019-02-23 04:37:27'),(43,18,4,'2019-02-23 01:47:16','2019-02-23 04:42:42'),(44,18,4,'2019-02-23 01:47:17','2019-02-23 04:42:43'),(45,18,4,'2019-02-23 01:47:18','2019-02-23 04:42:43'),(46,18,4,'2019-02-23 01:47:19','2019-02-23 04:47:12'),(47,18,4,'2019-02-23 01:47:25','2019-02-23 04:47:15'),(48,18,4,'2019-02-23 01:47:25','2019-02-23 04:47:21'),(49,18,3,'2019-02-23 02:19:09','2019-02-23 05:18:53'),(50,18,3,'2019-02-23 02:47:18','2019-02-23 05:18:59'),(51,18,6,'2019-02-23 02:47:16','2019-02-23 05:46:27'),(52,18,6,'2019-02-23 02:47:16','2019-02-23 05:46:40'),(53,18,6,'2019-02-23 02:47:16','2019-02-23 05:46:49'),(54,18,3,'2019-02-23 02:47:18','2019-02-23 05:47:04'),(55,18,6,NULL,'2019-02-23 05:54:57'),(56,18,6,NULL,'2019-02-23 05:54:58'),(57,18,6,NULL,'2019-02-23 05:54:58'),(58,18,6,NULL,'2019-02-23 05:54:58'),(59,18,6,NULL,'2019-02-23 05:54:58'),(60,20,4,'2019-02-24 19:54:26','2019-02-24 22:51:21'),(61,20,4,'2019-02-24 19:54:26','2019-02-24 22:54:22'),(62,20,4,'2019-02-24 20:01:32','2019-02-24 22:54:24'),(63,21,2,NULL,'2019-02-25 12:57:19'),(64,21,2,NULL,'2019-02-25 12:57:24'),(65,21,3,NULL,'2019-02-25 12:57:27'),(66,22,3,'2019-02-25 11:36:19','2019-02-25 14:14:09'),(67,22,1,NULL,'2019-02-25 14:36:15'),(68,22,1,NULL,'2019-02-25 14:36:20'),(69,22,1,NULL,'2019-02-25 14:36:21'),(70,23,3,'2019-02-25 14:58:03','2019-02-25 17:53:05'),(71,23,4,'2019-02-25 15:14:58','2019-02-25 18:13:52'),(72,23,4,'2019-02-25 15:14:58','2019-02-25 18:14:55'),(73,23,4,'2019-02-25 15:14:58','2019-02-25 18:14:55'),(74,23,4,'2019-02-25 15:14:58','2019-02-25 18:14:56'),(75,23,1,'2019-02-25 15:30:34','2019-02-25 18:15:13'),(76,23,1,'2019-02-25 15:30:34','2019-02-25 18:15:13'),(77,23,1,'2019-02-25 15:30:34','2019-02-25 18:15:13'),(78,23,1,'2019-02-25 15:30:34','2019-02-25 18:15:13'),(79,24,4,'2019-02-25 16:11:09','2019-02-25 19:09:26'),(80,24,1,'2019-02-25 16:59:25','2019-02-25 19:11:22'),(81,24,1,'2019-02-25 16:59:25','2019-02-25 19:11:22'),(82,24,1,'2019-02-25 16:59:25','2019-02-25 19:11:22'),(83,24,1,'2019-02-25 16:59:25','2019-02-25 19:11:22'),(84,24,1,'2019-02-25 16:59:25','2019-02-25 19:11:22'),(85,24,4,'2019-02-25 17:25:51','2019-02-25 20:24:54'),(86,24,1,'2019-02-25 17:27:04','2019-02-25 20:25:10'),(87,24,1,'2019-02-25 17:29:07','2019-02-25 20:27:12'),(88,24,1,'2019-02-25 17:53:25','2019-02-25 20:27:21'),(89,24,1,'2019-02-25 17:53:25','2019-02-25 20:29:45'),(90,24,1,'2019-02-25 17:53:25','2019-02-25 20:52:56'),(91,24,1,'2019-02-25 17:53:25','2019-02-25 20:52:57'),(92,24,3,'2019-02-25 17:53:48','2019-02-25 20:53:33'),(93,24,1,NULL,'2019-02-25 20:53:46'),(94,24,1,NULL,'2019-02-25 20:54:05'),(95,26,3,'2019-02-27 08:59:02','2019-02-27 11:24:28'),(96,26,4,'2019-02-27 08:59:25','2019-02-27 11:59:08'),(97,26,1,'2019-02-27 09:15:48','2019-02-27 11:59:22'),(98,26,1,'2019-02-27 09:20:18','2019-02-27 11:59:34'),(99,26,1,'2019-02-27 09:20:34','2019-02-27 12:02:24'),(100,26,1,'2019-02-27 09:21:53','2019-02-27 12:11:20'),(101,26,1,'2019-02-27 09:22:00','2019-02-27 12:15:46'),(102,26,1,'2019-02-27 09:25:15','2019-02-27 12:20:11'),(103,26,1,'2019-02-27 09:25:15','2019-02-27 12:21:45'),(104,26,1,'2019-02-27 09:25:15','2019-02-27 12:25:09'),(105,26,1,NULL,'2019-02-27 12:43:38'),(106,26,1,NULL,'2019-02-27 12:43:46'),(107,26,1,NULL,'2019-02-27 12:48:01'),(108,26,4,NULL,'2019-02-27 13:35:57'),(109,27,1,'2019-02-27 11:58:24','2019-02-27 14:54:38'),(110,33,1,'2019-02-28 17:01:19','2019-02-28 20:00:10'),(111,33,1,NULL,'2019-02-28 20:00:12'),(112,35,3,NULL,'2019-03-01 15:18:54'),(113,37,3,'2019-03-01 16:12:16','2019-03-01 19:11:47'),(114,37,1,NULL,'2019-03-01 19:12:10'),(115,37,1,NULL,'2019-03-01 19:12:55'),(116,40,3,NULL,'2019-03-04 13:10:04'),(117,42,4,'2019-03-04 20:18:59','2019-03-04 23:18:37'),(118,42,4,'2019-03-04 20:55:44','2019-03-04 23:28:57'),(119,42,4,'2019-03-04 20:55:47','2019-03-04 23:55:25'),(120,42,4,'2019-03-04 20:55:50','2019-03-04 23:55:29'),(121,42,4,'2019-03-04 20:55:53','2019-03-04 23:55:36'),(122,42,4,'2019-03-04 20:55:54','2019-03-04 23:55:38'),(123,42,4,'2019-03-04 20:56:03','2019-03-04 23:55:39'),(124,42,4,NULL,'2019-03-04 23:55:39'),(125,42,4,NULL,'2019-03-04 23:55:39'),(126,42,4,NULL,'2019-03-04 23:55:39'),(127,42,4,NULL,'2019-03-04 23:55:39'),(128,42,4,NULL,'2019-03-04 23:55:39'),(129,42,4,NULL,'2019-03-04 23:55:57');
/*!40000 ALTER TABLE `tb_cartsproducts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_categories`
--

DROP TABLE IF EXISTS `tb_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_categories` (
  `idcategory` int(11) NOT NULL AUTO_INCREMENT,
  `descategory` varchar(32) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcategory`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_categories`
--

LOCK TABLES `tb_categories` WRITE;
/*!40000 ALTER TABLE `tb_categories` DISABLE KEYS */;
INSERT INTO `tb_categories` VALUES (3,'Smartphone','2019-02-18 12:14:31'),(4,'Notebook','2019-02-18 14:12:49'),(5,'TelevisÃ£o','2019-02-18 14:41:35');
/*!40000 ALTER TABLE `tb_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_orders`
--

DROP TABLE IF EXISTS `tb_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_orders` (
  `idorder` int(11) NOT NULL AUTO_INCREMENT,
  `idcart` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `idstatus` int(11) NOT NULL,
  `vltotal` decimal(10,2) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idorder`),
  KEY `FK_orders_carts_idx` (`idcart`),
  KEY `FK_orders_users_idx` (`iduser`),
  KEY `fk_orders_ordersstatus_idx` (`idstatus`),
  CONSTRAINT `fk_orders_carts` FOREIGN KEY (`idcart`) REFERENCES `tb_carts` (`idcart`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_orders_ordersstatus` FOREIGN KEY (`idstatus`) REFERENCES `tb_ordersstatus` (`idstatus`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_orders_users` FOREIGN KEY (`iduser`) REFERENCES `tb_users` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_orders`
--

LOCK TABLES `tb_orders` WRITE;
/*!40000 ALTER TABLE `tb_orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_ordersstatus`
--

DROP TABLE IF EXISTS `tb_ordersstatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_ordersstatus` (
  `idstatus` int(11) NOT NULL AUTO_INCREMENT,
  `desstatus` varchar(32) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idstatus`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_ordersstatus`
--

LOCK TABLES `tb_ordersstatus` WRITE;
/*!40000 ALTER TABLE `tb_ordersstatus` DISABLE KEYS */;
INSERT INTO `tb_ordersstatus` VALUES (1,'Em Aberto','2017-03-13 06:00:00'),(2,'Aguardando Pagamento','2017-03-13 06:00:00'),(3,'Pago','2017-03-13 06:00:00'),(4,'Entregue','2017-03-13 06:00:00');
/*!40000 ALTER TABLE `tb_ordersstatus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_persons`
--

DROP TABLE IF EXISTS `tb_persons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_persons` (
  `idperson` int(11) NOT NULL AUTO_INCREMENT,
  `desperson` varchar(64) NOT NULL,
  `desemail` varchar(128) DEFAULT NULL,
  `nrphone` bigint(20) DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idperson`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_persons`
--

LOCK TABLES `tb_persons` WRITE;
/*!40000 ALTER TABLE `tb_persons` DISABLE KEYS */;
INSERT INTO `tb_persons` VALUES (1,'JoÃ£o Rangel','admin@hcode.com.br',2147483647,'2017-03-01 06:00:00'),(7,'Suporte','suporte@hcode.com.br',1112345678,'2017-03-15 19:10:27'),(9,'teste','d@d.d',123123123,'2019-02-05 21:58:25'),(10,'teste','d@d.d',123123123,'2019-02-05 21:58:28'),(11,'teste','d@d.d',123123123,'2019-02-05 21:59:04'),(12,'teste','d@d.d',123123123,'2019-02-05 21:59:13'),(13,'teste','d@d.d',123123123,'2019-02-05 22:00:02'),(14,'nome','d@d.d',123,'2019-02-05 22:02:10'),(15,'nome','d@d.d',123,'2019-02-05 22:07:54'),(16,'nome','d@d.d',123,'2019-02-05 22:08:15'),(17,'David','david@cabra.io',123123,'2019-02-05 22:11:57'),(18,'David','david@cabra.io',123123,'2019-02-05 22:13:15'),(19,'David','david@cabra.io',123123,'2019-02-05 22:13:47'),(20,'David','david@cabra.io',123123,'2019-02-05 22:14:28'),(21,'David','david@cabra.io',123123,'2019-02-05 22:15:04'),(22,'David','david@cabra.io',123123,'2019-02-05 22:16:10'),(23,'David','david@cabra.io',123123,'2019-02-05 22:16:42'),(24,'David','david@cabra.io',123123,'2019-02-05 22:17:23'),(25,'David','david@cabra.io',123123,'2019-02-05 22:17:35'),(26,'David','d@d.d',123123123,'2019-02-05 22:18:05'),(27,'David','d@d.d',123123123,'2019-02-05 22:18:22'),(28,'David','d@d.d',123123123,'2019-02-05 22:19:01'),(29,'David','david@cabra.io',7133569897,'2019-02-05 22:19:46'),(30,'Rosinha','a@a.a',123123123,'2019-02-05 23:37:09'),(31,'David Santos Meth','david.meth@hotmail.com',33569897,'2019-02-06 17:26:07'),(32,'Brenda Costa','brendacosta23@gmail.com',123123,'2019-02-06 20:04:13'),(33,'Admin','david.meth@live.com',123123123,'2019-02-23 05:40:39'),(34,'Rosinha','rosa@email.com',123123123,'2019-02-27 13:15:02'),(35,'Teste','teste@teste.com',123123123,'2019-02-28 14:15:12'),(36,'Fulano de Souza','fulano@fck.com',123123123,'2019-02-28 14:17:36'),(37,'David Santos Meth','david.meth@hotmail.com',123123123,'2019-03-01 15:08:24'),(38,'David Santos Meth','david.meth@cabra.io',33569897,'2019-03-01 15:34:22');
/*!40000 ALTER TABLE `tb_persons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_products`
--

DROP TABLE IF EXISTS `tb_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_products` (
  `idproduct` int(11) NOT NULL AUTO_INCREMENT,
  `desproduct` varchar(64) NOT NULL,
  `vlprice` decimal(10,2) NOT NULL,
  `vlwidth` decimal(10,2) NOT NULL,
  `vlheight` decimal(10,2) NOT NULL,
  `vllength` decimal(10,2) NOT NULL,
  `vlweight` decimal(10,2) NOT NULL,
  `desurl` varchar(128) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idproduct`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_products`
--

LOCK TABLES `tb_products` WRITE;
/*!40000 ALTER TABLE `tb_products` DISABLE KEYS */;
INSERT INTO `tb_products` VALUES (1,'Smartphone Android 7.0',999.95,19.00,11.00,9.00,0.64,'smartphone-android-7.0','2017-03-13 06:00:00'),(2,'SmartTV LED 4K',3925.99,917.00,596.00,288.00,8600.00,'smarttv-led-4k','2017-03-13 06:00:00'),(3,'Notebook 14\" 4GB 1TB',1949.99,345.00,23.00,30.00,2000.00,'notebook-14-4gb-1tb','2017-03-13 06:00:00'),(4,'Smartphone Motorola Moto G5 Plus',1135.23,15.20,7.40,0.70,0.12,'smartphone-motorola-moto-g5-plus','2019-02-18 12:16:06'),(5,'Smartphone Moto Z Play',1887.78,14.10,0.90,1.16,0.14,'smartphone-moto-z-play','2019-02-18 12:17:45'),(6,'Smartphone Samsung Galaxy J5 Pro',1299.00,14.60,7.10,0.80,0.16,'smartphone-samsung-galaxy-j5','2019-02-18 12:18:34'),(7,'Smartphone Samsung Galaxy J7 Prime',1149.00,15.10,7.50,0.80,0.16,'smartphone-samsung-galaxy-j7','2019-02-18 12:19:20'),(8,'Smartphone Samsung Galaxy J3 Dual',679.90,14.20,7.10,0.70,0.15,'smartphone-samsung-galaxy-j3','2019-02-18 12:20:18');
/*!40000 ALTER TABLE `tb_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_productscategories`
--

DROP TABLE IF EXISTS `tb_productscategories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_productscategories` (
  `idcategory` int(11) NOT NULL,
  `idproduct` int(11) NOT NULL,
  PRIMARY KEY (`idcategory`,`idproduct`),
  KEY `fk_productscategories_products_idx` (`idproduct`),
  CONSTRAINT `fk_productscategories_categories` FOREIGN KEY (`idcategory`) REFERENCES `tb_categories` (`idcategory`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_productscategories_products` FOREIGN KEY (`idproduct`) REFERENCES `tb_products` (`idproduct`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_productscategories`
--

LOCK TABLES `tb_productscategories` WRITE;
/*!40000 ALTER TABLE `tb_productscategories` DISABLE KEYS */;
INSERT INTO `tb_productscategories` VALUES (3,1),(4,1),(3,2),(5,2),(3,3),(4,3),(3,4),(3,6),(4,6);
/*!40000 ALTER TABLE `tb_productscategories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_users`
--

DROP TABLE IF EXISTS `tb_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_users` (
  `iduser` int(11) NOT NULL AUTO_INCREMENT,
  `idperson` int(11) NOT NULL,
  `deslogin` varchar(64) NOT NULL,
  `despassword` varchar(256) NOT NULL,
  `inadmin` tinyint(4) NOT NULL DEFAULT '0',
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`iduser`),
  KEY `FK_users_persons_idx` (`idperson`),
  CONSTRAINT `fk_users_persons` FOREIGN KEY (`idperson`) REFERENCES `tb_persons` (`idperson`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_users`
--

LOCK TABLES `tb_users` WRITE;
/*!40000 ALTER TABLE `tb_users` DISABLE KEYS */;
INSERT INTO `tb_users` VALUES (7,7,'fck','$2y$12$HFjgUm/mk1RzTy4ZkJaZBe0Mc/BA2hQyoUckvm.lFa6TesjtNpiMe',1,'2017-03-15 19:10:27'),(8,31,'me42th','$2y$12$TaDbgl4e1ZAHoARd/r6JAO3u2.Mogz/BryKZ1ui9pptWdMMS5gTV6',1,'2019-02-06 17:26:08'),(10,32,'fck','$2y$12$ZAx.ns9lMYayzLfA1G1IWumyqxVxntDLEv2wdICuZxl.cvgDaCEMG',1,'2019-02-08 12:33:55'),(12,34,'rosa','$2y$12$INGQbGshihY1IuvMhY02zulsqBHIo4DMCb2M2gBzSrqm5a3Zy4VdK',1,'2019-02-27 13:15:03'),(13,36,'fulano','$2y$12$iasMGEffIERQisixvdfXReIvKQQyTs/i8kBi7M1iCuVkXZ3T62xP.',1,'2019-02-28 14:17:36'),(14,37,'123123123','$2y$12$YUx3JPnZiH.2aO2r1JBhquM8jKGpxOsV8qvNlpSFT.CXwhwcbvPgK',1,'2019-03-01 15:08:24'),(15,38,'davd','$2y$12$m6KzMhVv3Sj.hFfw.oPQxOOF8def8i8ZyjyGuClai670yE3nvlcEi',1,'2019-03-01 15:34:22');
/*!40000 ALTER TABLE `tb_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_userslogs`
--

DROP TABLE IF EXISTS `tb_userslogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_userslogs` (
  `idlog` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(11) NOT NULL,
  `deslog` varchar(128) NOT NULL,
  `desip` varchar(45) NOT NULL,
  `desuseragent` varchar(128) NOT NULL,
  `dessessionid` varchar(64) NOT NULL,
  `desurl` varchar(128) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idlog`),
  KEY `fk_userslogs_users_idx` (`iduser`),
  CONSTRAINT `fk_userslogs_users` FOREIGN KEY (`iduser`) REFERENCES `tb_users` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_userslogs`
--

LOCK TABLES `tb_userslogs` WRITE;
/*!40000 ALTER TABLE `tb_userslogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_userslogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_userspasswordsrecoveries`
--

DROP TABLE IF EXISTS `tb_userspasswordsrecoveries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_userspasswordsrecoveries` (
  `idrecovery` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(11) NOT NULL,
  `desip` varchar(45) NOT NULL,
  `dtrecovery` datetime DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idrecovery`),
  KEY `fk_userspasswordsrecoveries_users_idx` (`iduser`),
  CONSTRAINT `fk_userspasswordsrecoveries_users` FOREIGN KEY (`iduser`) REFERENCES `tb_users` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_userspasswordsrecoveries`
--

LOCK TABLES `tb_userspasswordsrecoveries` WRITE;
/*!40000 ALTER TABLE `tb_userspasswordsrecoveries` DISABLE KEYS */;
INSERT INTO `tb_userspasswordsrecoveries` VALUES (1,7,'127.0.0.1',NULL,'2017-03-15 19:10:59'),(2,7,'127.0.0.1',NULL,'2017-03-15 19:11:18'),(3,7,'127.0.0.1',NULL,'2017-03-15 19:37:12'),(4,8,'127.0.0.1',NULL,'2019-02-06 19:03:28'),(5,8,'127.0.0.1',NULL,'2019-02-06 19:06:06'),(6,8,'127.0.0.1',NULL,'2019-02-06 19:11:40'),(7,8,'127.0.0.1',NULL,'2019-02-06 19:11:59'),(8,8,'127.0.0.1',NULL,'2019-02-06 19:12:27'),(9,8,'127.0.0.1',NULL,'2019-02-06 19:12:50'),(10,8,'127.0.0.1',NULL,'2019-02-06 19:13:06'),(11,8,'127.0.0.1',NULL,'2019-02-06 19:13:38'),(12,8,'127.0.0.1',NULL,'2019-02-06 19:16:53'),(13,8,'127.0.0.1',NULL,'2019-02-06 19:17:39'),(14,8,'127.0.0.1',NULL,'2019-02-06 19:18:08'),(15,8,'127.0.0.1',NULL,'2019-02-06 20:19:36'),(16,8,'127.0.0.1',NULL,'2019-02-06 20:22:51'),(17,8,'127.0.0.1',NULL,'2019-02-06 20:23:28'),(18,8,'127.0.0.1',NULL,'2019-02-06 20:24:51'),(19,8,'127.0.0.1',NULL,'2019-02-06 20:26:02'),(20,8,'127.0.0.1',NULL,'2019-02-06 20:34:18'),(21,8,'127.0.0.1',NULL,'2019-02-06 20:34:57'),(22,8,'127.0.0.1',NULL,'2019-02-06 20:35:16'),(23,8,'127.0.0.1',NULL,'2019-02-06 20:52:59'),(24,8,'127.0.0.1',NULL,'2019-02-06 20:56:08'),(25,8,'127.0.0.1',NULL,'2019-02-06 20:58:49'),(26,8,'127.0.0.1',NULL,'2019-02-06 20:59:41'),(27,8,'127.0.0.1',NULL,'2019-02-06 21:03:50'),(28,8,'127.0.0.1',NULL,'2019-02-06 21:05:56'),(29,8,'127.0.0.1',NULL,'2019-02-07 14:24:37'),(30,8,'127.0.0.1',NULL,'2019-02-07 14:26:43'),(31,8,'127.0.0.1',NULL,'2019-02-07 15:30:34'),(32,8,'127.0.0.1','2019-02-07 13:24:09','2019-02-07 16:23:24'),(33,10,'127.0.0.1',NULL,'2019-02-08 12:34:59'),(34,8,'127.0.0.1','2019-02-23 02:31:43','2019-02-23 05:30:25'),(35,8,'127.0.0.1','2019-02-23 02:38:26','2019-02-23 05:38:04'),(36,8,'127.0.0.1',NULL,'2019-02-28 16:48:43'),(37,8,'127.0.0.1',NULL,'2019-02-28 16:55:13'),(38,8,'127.0.0.1',NULL,'2019-02-28 16:55:47'),(39,8,'127.0.0.1',NULL,'2019-02-28 17:04:42'),(40,8,'127.0.0.1',NULL,'2019-02-28 17:13:05'),(41,8,'127.0.0.1',NULL,'2019-02-28 17:27:30'),(42,8,'127.0.0.1',NULL,'2019-02-28 17:30:00'),(43,8,'127.0.0.1',NULL,'2019-02-28 17:30:53'),(44,8,'127.0.0.1',NULL,'2019-02-28 17:35:48'),(45,14,'127.0.0.1',NULL,'2019-03-01 17:49:17');
/*!40000 ALTER TABLE `tb_userspasswordsrecoveries` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-03-07 11:44:29
