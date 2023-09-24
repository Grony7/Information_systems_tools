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
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employees` (
  `id` int NOT NULL AUTO_INCREMENT,
  `employee_name` text,
  `position` text,
  `discount_on_clothing` float DEFAULT NULL,
  `workshop_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_workshop` (`workshop_id`),
  CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`workshop_id`) REFERENCES `workshops` (`id`),
  CONSTRAINT `fk_workshop` FOREIGN KEY (`workshop_id`) REFERENCES `workshops` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES (1,'Иванов Иван Иванович','Токарь',40,1),(2,'Васильев Василий Васильевич','Слесарь',30,1),(3,'Михайлов Михаил Михайлович','Токарь',30,2),(4,'Андреев Андрей Андреевич','Фрезеровщик',45,3),(5,'Александров Александр Александрович','Сварщик',50,4),(6,'Сергеев Сергей Сергеевич','Электрик',40,5),(7,'Дуров Павел Михайлович','Инженер-технолог',35,2),(8,'Сидоров Сидор Сидорович','Начальник цеха',0,3),(9,'Воронин Николай Михайлович','Электрик',40,4),(10,'Мамонтов Петр Николаевич','Электрик',40,5),(11,'Иванов Сергей Петрович','Начальник цеха',0,1),(12,'Петров Иван Литвененко','Начальник цеха',0,2),(13,'Алексеев Николай Резниченко','Начальник цеха',0,4),(14,'Николаев Сергей Рудаков','Начальник цеха',0,5);
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `receiving`
--

DROP TABLE IF EXISTS `receiving`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `receiving` (
  `id` int NOT NULL AUTO_INCREMENT,
  `employee_id` int DEFAULT NULL,
  `clothing_id` int DEFAULT NULL,
  `receiving_date` date DEFAULT NULL,
  `signature` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_employee` (`employee_id`),
  KEY `fk_clothing` (`clothing_id`),
  CONSTRAINT `fk_clothing` FOREIGN KEY (`clothing_id`) REFERENCES `special_clothing` (`id`),
  CONSTRAINT `fk_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `receiving`
--

LOCK TABLES `receiving` WRITE;
/*!40000 ALTER TABLE `receiving` DISABLE KEYS */;
INSERT INTO `receiving` VALUES (1,1,2,'2023-01-14',1),(2,1,4,'2023-01-13',1),(3,1,5,'2023-01-12',1),(4,2,2,'2023-02-11',1),(5,2,4,'2023-02-10',1),(6,2,6,'2023-02-14',1),(7,3,2,'2023-09-13',1),(8,3,4,'2023-09-12',1),(9,3,6,'2023-09-11',1),(10,4,2,'2023-09-10',1),(11,4,4,'2023-09-14',1),(12,4,6,'2023-09-13',1),(13,5,2,'2023-09-12',1),(14,5,4,'2023-09-11',1),(15,5,6,'2023-09-10',1),(16,6,2,'2023-09-12',1),(17,6,4,'2023-09-11',1),(18,6,6,'2023-09-10',1),(19,7,2,'2023-09-12',1),(20,7,4,'2023-09-11',1),(21,7,6,'2023-09-10',1),(22,9,2,'2022-01-10',1),(23,9,4,'2022-01-10',1),(24,9,6,'2022-01-10',1),(25,10,2,'2022-02-10',1),(26,10,4,'2022-02-10',1),(27,10,5,'2022-02-10',1),(28,10,6,'2022-02-10',1);
/*!40000 ALTER TABLE `receiving` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `special_clothing`
--

DROP TABLE IF EXISTS `special_clothing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `special_clothing` (
  `id` int NOT NULL AUTO_INCREMENT,
  `clothing_type` varchar(255) DEFAULT NULL,
  `wearing_period_months` int DEFAULT NULL,
  `unit_cost` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `special_clothing`
--

LOCK TABLES `special_clothing` WRITE;
/*!40000 ALTER TABLE `special_clothing` DISABLE KEYS */;
INSERT INTO `special_clothing` VALUES (1,'Халат',12,500),(2,'Комбинезон',6,800),(3,'Костюм защитный',24,5000),(4,'Перчатки',12,1500),(5,'Ботинки',12,3500),(6,'Очки защитные',24,2000);
/*!40000 ALTER TABLE `special_clothing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `workshops`
--

DROP TABLE IF EXISTS `workshops`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `workshops` (
  `id` int NOT NULL AUTO_INCREMENT,
  `workshop_name` text,
  `supervisor_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `supervisor_id` (`supervisor_id`),
  CONSTRAINT `workshops_ibfk_1` FOREIGN KEY (`supervisor_id`) REFERENCES `employees` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `workshops`
--

LOCK TABLES `workshops` WRITE;
/*!40000 ALTER TABLE `workshops` DISABLE KEYS */;
INSERT INTO `workshops` VALUES (1,'Цех 1',11),(2,'Цех 2',12),(3,'Цех 3',8),(4,'Цех 4',13),(5,'Цех 5',14);
/*!40000 ALTER TABLE `workshops` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-09-24 22:10:56
