-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: localhost    Database: workwear
-- ------------------------------------------------------
-- Server version	8.0.34

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
-- Table structure for table `получение`
--

DROP TABLE IF EXISTS `получение`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `получение` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_работника` int DEFAULT NULL,
  `id_спецодежды` int DEFAULT NULL,
  `дата_получения` date DEFAULT NULL,
  `роспись` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `получение`
--

LOCK TABLES `получение` WRITE;
/*!40000 ALTER TABLE `получение` DISABLE KEYS */;
INSERT INTO `получение` VALUES (1,1,2,'2023-01-14',1),(2,1,4,'2023-01-13',1),(3,1,5,'2023-01-12',1),(4,2,2,'2023-02-11',1),(5,2,4,'2023-02-10',1),(6,2,6,'2023-02-14',1),(7,3,2,'2023-09-13',1),(8,3,4,'2023-09-12',1),(9,3,6,'2023-09-11',1),(10,4,2,'2023-09-10',1),(11,4,4,'2023-09-14',1),(12,4,6,'2023-09-13',1),(13,5,2,'2023-09-12',1),(14,5,4,'2023-09-11',1),(15,5,6,'2023-09-10',1),(16,6,2,'2023-09-12',1),(17,6,4,'2023-09-11',1),(18,6,6,'2023-09-10',1),(19,7,2,'2023-09-12',1),(20,7,4,'2023-09-11',1),(21,7,6,'2023-09-10',1);
/*!40000 ALTER TABLE `получение` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `работники`
--

DROP TABLE IF EXISTS `работники`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `работники` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Ф_И_О_работника` text,
  `должность` text,
  `скидка_на_спецодежду` float DEFAULT NULL,
  `id_цеха` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_цеха` (`id_цеха`),
  CONSTRAINT `работники_ibfk_1` FOREIGN KEY (`id_цеха`) REFERENCES `цехи` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `работники`
--

LOCK TABLES `работники` WRITE;
/*!40000 ALTER TABLE `работники` DISABLE KEYS */;
INSERT INTO `работники` VALUES (1,'Иванов Иван Иванович','Токарь',40,1),(2,'Васильев Василий Васильевич','Слесарь',30,1),(3,'Михайлов Михаил Михайлович','Токарь',30,2),(4,'Андреев Андрей Андреевич','Фрезеровщик',45,3),(5,'Александров Александр Александрович','Сварщик',50,4),(6,'Сергеев Сергей Сергеевич','Электрик',40,5),(7,'Дуров Павел Михайлович','Инженер-технолог',35,2),(8,'Сидоров Сидор Сидорович','Начальник цеха',0,3);
/*!40000 ALTER TABLE `работники` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `спецодежда`
--

DROP TABLE IF EXISTS `спецодежда`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `спецодежда` (
  `id` int NOT NULL AUTO_INCREMENT,
  `вид_спецодежды` varchar(255) DEFAULT NULL,
  `срок_носки` text,
  `стоимость_единицы` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `спецодежда`
--

LOCK TABLES `спецодежда` WRITE;
/*!40000 ALTER TABLE `спецодежда` DISABLE KEYS */;
INSERT INTO `спецодежда` VALUES (1,'Халат','12 месяцев',500),(2,'Комбинезон','6 месяцев',800),(3,'Костюм защитный','2 года',5000),(4,'Перчатки','1 год',1500),(5,'Ботинки','1 год',3500),(6,'Очки защитные','2 года',2000);
/*!40000 ALTER TABLE `спецодежда` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `цехи`
--

DROP TABLE IF EXISTS `цехи`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `цехи` (
  `id` int NOT NULL AUTO_INCREMENT,
  `наименование_цеха` text,
  `Ф_И_О_начальника_цеха` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `цехи`
--

LOCK TABLES `цехи` WRITE;
/*!40000 ALTER TABLE `цехи` DISABLE KEYS */;
INSERT INTO `цехи` VALUES (1,'Цех 1','Иванов Сергей Петрович'),(2,'Цех 2','Петров Иван Литвененко'),(3,'Цех 3','Сидоров Сидор Сидорович'),(4,'Цех 4','Алексеев Николай Резниченко'),(5,'Цех 5','Николаев Сергей Рудаков');
/*!40000 ALTER TABLE `цехи` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'workwear'
--

--
-- Dumping routines for database 'workwear'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-09-19  0:13:55
