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
-- Table structure for table `videos`
--

DROP TABLE IF EXISTS `videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `videos` (
  `ID_VIDEO` int NOT NULL AUTO_INCREMENT COMMENT 'Llave primaria de la tabla VIDEOS',
  `DESCRIPTION` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Breve descripcion del contenido del archivo',
  `CONTENT` longblob NOT NULL COMMENT 'Datos deL video',
  `ROUTE` varchar(1000) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Ruta del archivo',
  `UPLOAD_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de subida del material',
  `VIDEO_STATUS` char(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'P' COMMENT 'Estado actual del material [P-Publico  E-Eliminado]',
  `REPORT_ID` int NOT NULL COMMENT 'Id de la noticia a la que pertence el material',
  PRIMARY KEY (`ID_VIDEO`),
  KEY `FK_VIDEO_REPORT` (`REPORT_ID`),
  CONSTRAINT `FK_VIDEO_REPORT` FOREIGN KEY (`REPORT_ID`) REFERENCES `news_reports` (`REPORT_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `videos`
--

LOCK TABLES `videos` WRITE;
/*!40000 ALTER TABLE `videos` DISABLE KEYS */;
/*!40000 ALTER TABLE `videos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-03-31 14:39:59
