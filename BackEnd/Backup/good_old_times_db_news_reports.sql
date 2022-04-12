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
-- Table structure for table `news_reports`
--

DROP TABLE IF EXISTS `news_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `news_reports` (
  `REPORT_ID` int NOT NULL AUTO_INCREMENT COMMENT 'Llave primaria de la tabla de NEWS_REPORTS',
  `SIGN` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Firma del reportero',
  `LOCATION_STREET` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Calle en la que ocurrio la nota',
  `LOCATION_NEIGHB` varchar(70) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Colonia en la que ocurrio la nota',
  `LOCATION_CITY` varchar(80) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Ciudad en la que ocurrio la nota',
  `LOCATION_COUNTRY` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Pais en la que ocurrio la nota',
  `EVENT_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha en la que ocurrio el suceso',
  `PUBLICATION_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha en la que publico la nota en el portal',
  `REPORT_HEADER` varchar(80) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Encabezado de la nota',
  `REPORT_DESCRIPTION` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Descripción breve de la nota',
  `REPORT_CONTENT` varchar(1000) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Contenido de la nota',
  `LIKES` int NOT NULL DEFAULT '0' COMMENT 'Numero de likes que ha recibido la nota',
  `THUMBNAIL` longblob NOT NULL COMMENT 'Miniatura con la que la nota se muestra',
  `CREATION_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creacion de la nota',
  `CREATED_BY` int NOT NULL COMMENT 'Usuario que creo la nota',
  `LAST_UPDATE_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Última fecha de modificación de la nota',
  `LAST_UPDATED_BY` int NOT NULL COMMENT 'Ultimo usuario que modifico la nota',
  `REPORT_STATUS` char(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'RA' COMMENT 'Estado actual de la noticia [P-Publicada  E-Eliminada  RA-En revision por administrador  RR-En revision por reportero]',
  PRIMARY KEY (`REPORT_ID`),
  KEY `FK_REPORT_USER` (`CREATED_BY`),
  CONSTRAINT `FK_REPORT_USER` FOREIGN KEY (`CREATED_BY`) REFERENCES `users` (`ID_USER`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news_reports`
--

LOCK TABLES `news_reports` WRITE;
/*!40000 ALTER TABLE `news_reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `news_reports` ENABLE KEYS */;
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
