-- MySQL dump 10.13  Distrib 8.0.34, for Linux (x86_64)
--
-- Host: localhost    Database: db_toko
-- ------------------------------------------------------
-- Server version	8.1.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `goods`
--

DROP TABLE IF EXISTS `goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `goods` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `goods_code` varchar(255) NOT NULL,
  `goods_name` varchar(255) NOT NULL,
  `goods_price` bigint NOT NULL,
  `goods_prev_price` bigint DEFAULT NULL,
  `goods_stock_warehouse` bigint DEFAULT NULL,
  `goods_min_stock` bigint DEFAULT NULL,
  `users_id` bigint unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goods`
--

LOCK TABLES `goods` WRITE;
/*!40000 ALTER TABLE `goods` DISABLE KEYS */;
INSERT INTO `goods` VALUES (1,'GS65854429be50700001','Gorong-gorong ukuran 20 cm',65000,0,34,20,1,'2023-12-22 15:09:13','2023-12-27 12:47:59',NULL),(2,'GS65854443524a700002','Gorong-gorong ukuran 30 cm',80000,0,20,20,1,'2023-12-22 15:09:39','2023-12-27 12:44:22',NULL),(3,'GS658544601d20900003','Gorong-gorong ukuran 40 cm',100000,0,20,20,1,'2023-12-22 15:10:08','2023-12-27 12:44:31',NULL),(4,'GS658544761e0ca00004','Gorong-gorong ukuran 80 cm',150000,0,20,20,1,'2023-12-22 15:10:30','2023-12-27 12:44:38',NULL),(5,'GS6585448b7200f00005','Gorong-gorong ukuran 100 Cm',180000,0,34,20,1,'2023-12-22 15:10:51','2024-01-06 11:03:56',NULL),(6,'GS6585458990a9d00006','Paving Block Segi Enam per m2 (meter persegi)',60000,0,200,100,1,'2023-12-22 15:15:05','2023-12-27 12:45:05',NULL),(7,'GS658545b1cee4600007','Paving Block Bata per m2 (meter persegi)',70000,0,150,100,1,'2023-12-22 15:15:45','2023-12-27 12:44:57',NULL),(8,'GS658545d9cc1b300008','Loster Cor Motif Spiral',15000,0,200,100,1,'2023-12-22 15:16:25','2023-12-27 12:45:47',NULL),(9,'GS658545fc26f7800009','Loster Cor Motif Bunga',15000,0,130,100,1,'2023-12-22 15:17:00','2023-12-27 12:45:58',NULL),(10,'GS65854618cc98500010','Loster Cor Motif Tapak Kucing',15000,0,120,100,1,'2023-12-22 15:17:28','2023-12-27 12:46:30',NULL),(11,'GS65854631e6fe700011','Loster Cor Motif Tampias',15000,0,40,100,1,'2023-12-22 15:17:53','2024-01-06 11:06:59',NULL),(12,'GS6585464596bbf00012','Loster Cor Motif Bintang',15000,0,120,100,1,'2023-12-22 15:18:13','2023-12-27 12:46:51',NULL),(13,'GS65854665682d700013','Loster Cor Motif Minimalis',15000,0,20,100,1,'2023-12-22 15:18:45','2024-01-06 11:07:09',NULL),(14,'GS658546812a2fd00014','Loster Cor Motif 3 Dimensi',15000,0,150,100,1,'2023-12-22 15:19:13','2023-12-27 12:46:40',NULL),(15,'GS6585469cb539f00015','Loster Tumbuk ukuran 25 Cm',8000,0,20,100,1,'2023-12-22 15:19:40','2024-01-05 19:26:25',NULL),(16,'GS6585473a3549d00016','Loster Tumbuk ukuran 30 Cm',10000,0,130,100,1,'2023-12-22 15:22:18','2023-12-27 12:47:26',NULL),(17,'GS6585474fce06900017','Loster Tumbuk ukuran 40 Cm',12000,0,210,100,1,'2023-12-22 15:22:39','2023-12-27 12:47:06',NULL),(18,'GS6585476fdbb5900018','Loster Tumbuk ukuran 50 Cm',15000,0,120,100,1,'2023-12-22 15:23:11','2023-12-27 12:47:17',NULL),(19,'GS6585478b038af00019','Loster Tumbuk ukuran 60 Cm',17000,0,120,100,1,'2023-12-22 15:23:39','2023-12-27 12:47:35',NULL),(20,'GS658547a49c03d00020','Graple ukuran 20 Cm',35000,0,20,100,1,'2023-12-22 15:24:04','2024-01-05 19:26:13',NULL),(21,'GS658547b5bed1600021','Graple ukuran 30 Cm',40000,0,120,100,1,'2023-12-22 15:24:21','2023-12-27 12:46:21',NULL),(22,'GS658547ce93af800022','Graple ukuran 40 Cm',50000,0,300,100,1,'2023-12-22 15:24:46','2023-12-27 12:46:10',NULL),(23,'GS658547e98c9ea00023','Bis Beton ukuran 80 Cm',150000,0,97,100,1,'2023-12-22 15:25:13','2024-01-06 11:03:55',NULL),(24,'GS658547fd7330500024','Bis Beton ukuran 100 Cm',180000,0,96,100,1,'2023-12-22 15:25:33','2024-01-06 11:03:54',NULL);
/*!40000 ALTER TABLE `goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `goods_history`
--

DROP TABLE IF EXISTS `goods_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `goods_history` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `qty` bigint NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goods_history`
--

LOCK TABLES `goods_history` WRITE;
/*!40000 ALTER TABLE `goods_history` DISABLE KEYS */;
INSERT INTO `goods_history` VALUES (1,1,1,50,'2023-12-26 10:45:35','2023-12-26 10:45:35'),(2,2,1,20,'2023-12-27 12:44:22','2023-12-27 12:44:22'),(3,3,1,20,'2023-12-27 12:44:31','2023-12-27 12:44:31'),(4,4,1,20,'2023-12-27 12:44:38','2023-12-27 12:44:38'),(5,7,1,150,'2023-12-27 12:44:57','2023-12-27 12:44:57'),(6,6,1,200,'2023-12-27 12:45:05','2023-12-27 12:45:05'),(7,24,1,120,'2023-12-27 12:45:17','2023-12-27 12:45:17'),(8,23,1,100,'2023-12-27 12:45:27','2023-12-27 12:45:27'),(9,5,1,50,'2023-12-27 12:45:40','2023-12-27 12:45:40'),(10,8,1,200,'2023-12-27 12:45:47','2023-12-27 12:45:47'),(11,9,1,130,'2023-12-27 12:45:58','2023-12-27 12:45:58'),(12,22,1,300,'2023-12-27 12:46:10','2023-12-27 12:46:10'),(13,21,1,120,'2023-12-27 12:46:21','2023-12-27 12:46:21'),(14,10,1,120,'2023-12-27 12:46:30','2023-12-27 12:46:30'),(15,14,1,150,'2023-12-27 12:46:40','2023-12-27 12:46:40'),(16,12,1,120,'2023-12-27 12:46:51','2023-12-27 12:46:51'),(17,17,1,210,'2023-12-27 12:47:06','2023-12-27 12:47:06'),(18,18,1,120,'2023-12-27 12:47:17','2023-12-27 12:47:17'),(19,16,1,130,'2023-12-27 12:47:26','2023-12-27 12:47:26'),(20,19,1,120,'2023-12-27 12:47:35','2023-12-27 12:47:35'),(21,11,1,20,'2023-12-27 13:02:51','2023-12-27 13:02:51'),(22,11,1,10,'2024-01-03 11:40:45','2024-01-03 11:40:45'),(23,13,1,10,'2024-01-03 11:40:51','2024-01-03 11:40:51'),(24,15,1,10,'2024-01-03 11:40:57','2024-01-03 11:40:57'),(25,20,1,10,'2024-01-03 11:41:04','2024-01-03 11:41:04'),(26,20,1,10,'2024-01-05 19:26:13','2024-01-05 19:26:13'),(27,15,1,10,'2024-01-05 19:26:25','2024-01-05 19:26:25'),(28,11,1,10,'2024-01-06 11:06:59','2024-01-06 11:06:59'),(29,13,1,10,'2024-01-06 11:07:09','2024-01-06 11:07:09');
/*!40000 ALTER TABLE `goods_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `goods_restocks`
--

DROP TABLE IF EXISTS `goods_restocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `goods_restocks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` bigint unsigned NOT NULL,
  `restock_id` bigint unsigned NOT NULL,
  `qty` bigint NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goods_restocks`
--

LOCK TABLES `goods_restocks` WRITE;
/*!40000 ALTER TABLE `goods_restocks` DISABLE KEYS */;
INSERT INTO `goods_restocks` VALUES (1,1,1,5,'2023-12-26 10:48:18','2023-12-26 10:48:22'),(3,1,3,10,'2023-12-26 11:27:03','2023-12-27 12:47:59'),(4,24,3,2,'2023-12-27 12:48:05','2023-12-27 12:48:13'),(5,24,4,18,'2023-12-27 13:37:37','2023-12-27 13:37:42'),(6,24,5,2,'2024-01-03 11:41:09','2024-01-03 11:41:17'),(7,23,5,2,'2024-01-03 11:41:09','2024-01-03 11:41:21'),(8,5,6,5,'2024-01-03 11:41:29','2024-01-03 11:41:32'),(11,5,7,10,'2024-01-05 19:26:48','2024-01-05 19:26:51'),(13,24,7,1,'2024-01-05 19:26:58','2024-01-05 19:26:58'),(14,24,8,1,'2024-01-06 11:03:54','2024-01-06 11:03:54'),(15,23,8,1,'2024-01-06 11:03:55','2024-01-06 11:03:55'),(16,5,8,1,'2024-01-06 11:03:56','2024-01-06 11:03:56');
/*!40000 ALTER TABLE `goods_restocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int NOT NULL,
  `batch` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (8,'2023-10-19-060204','App\\Database\\Migrations\\Users','default','App',1703211223,1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `restocks`
--

DROP TABLE IF EXISTS `restocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `restocks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `restock_code` varchar(255) NOT NULL,
  `status` int NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `restocks`
--

LOCK TABLES `restocks` WRITE;
/*!40000 ALTER TABLE `restocks` DISABLE KEYS */;
INSERT INTO `restocks` VALUES (1,'RS658a4cfebe97f00001',1,1,'2023-12-26 10:48:18','2023-12-26 11:04:16',NULL),(3,'RS658a56127c81200002',1,1,'2023-12-26 11:27:01','2023-12-27 12:48:15',NULL),(4,'RS658bc62ec379c00003',1,1,'2023-12-27 13:37:37','2023-12-27 13:38:06',NULL),(5,'RS6594e563a573e00004',1,1,'2024-01-03 11:41:09','2024-01-03 11:41:23',NULL),(6,'RS6594e5763b84400005',1,1,'2024-01-03 11:41:29','2024-01-03 11:41:34',NULL),(7,'RS6597f57c9719b00006',1,1,'2024-01-05 19:26:38','2024-01-05 19:27:04',NULL),(8,'RS6598d12780a7a00007',1,1,'2024-01-06 11:03:54','2024-01-06 11:05:21',NULL);
/*!40000 ALTER TABLE `restocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `online_status` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','$2y$10$/ZdMSGioLVKnMUkZVUe9suuWMA5N2Y2N7Za0pdk3iHicB3e0ypRSC','admin','6598d1237be69','2023-11-03 20:34:03','2024-01-06 11:03:47'),(2,'gudang','$2y$10$/ZdMSGioLVKnMUkZVUe9suuWMA5N2Y2N7Za0pdk3iHicB3e0ypRSC','gudang',NULL,'2023-11-03 20:50:03','2024-01-03 11:41:55');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-01-06 14:26:08
