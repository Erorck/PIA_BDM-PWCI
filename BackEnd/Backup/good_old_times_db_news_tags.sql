-- MySQL dump 10.13  Distrib 8.0.26, for Win64 (x86_64)
--
-- Host: localhost    Database: good_old_times_db
-- ------------------------------------------------------
-- Server version	8.0.26

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
-- Table structure for table `news_tags`
--

DROP TABLE IF EXISTS `news_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `news_tags` (
  `TAG` varchar(50) NOT NULL COMMENT 'Identificador de la etiqueta involucrada en la relación',
  `REPORT_ID` int NOT NULL COMMENT 'Identificador de la noticia involucrada en la relación',
  `CREATION_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creacion del registro',
  `CREATED_BY` int NOT NULL COMMENT 'Usuario que creo el registro',
  PRIMARY KEY (`TAG`,`REPORT_ID`),
  KEY `FK_N_T_REPORT` (`REPORT_ID`),
  CONSTRAINT `FK_N_T_REPORT` FOREIGN KEY (`REPORT_ID`) REFERENCES `news_reports` (`REPORT_ID`),
  CONSTRAINT `FK_N_T_TAG` FOREIGN KEY (`TAG`) REFERENCES `tags` (`TAG_NAME`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news_tags`
--

LOCK TABLES `news_tags` WRITE;
/*!40000 ALTER TABLE `news_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `news_tags` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-03-31 14:39:58
