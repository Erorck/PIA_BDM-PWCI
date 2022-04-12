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
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `COMMENT_ID` int NOT NULL AUTO_INCREMENT COMMENT 'Llave primaria de la tabla de COMMENTS',
  `COMMENT_TEXT` varchar(1000) NOT NULL COMMENT 'Contenido del comentario',
  `CREATION_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creacion del comentario',
  `CREATED_BY` int NOT NULL COMMENT 'Usuario que creo el comentario',
  `LAST_UPDATE_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Última fecha de modificación del comentario',
  `LAST_UPDATED_BY` int NOT NULL COMMENT 'Ultimo usuario que modifico el comentario',
  `COMMENT_STATUS` char(2) NOT NULL DEFAULT 'P' COMMENT 'Estado actual del comentario [P-Publico  E-Eliminado]',
  `REPORT_ID` int NOT NULL COMMENT 'Id de la noticia a la que pertence el comentario',
  PRIMARY KEY (`COMMENT_ID`),
  KEY `FK_COMMENT_USER` (`CREATED_BY`),
  KEY `FK_COMMENT_REPORT` (`REPORT_ID`),
  CONSTRAINT `FK_COMMENT_REPORT` FOREIGN KEY (`REPORT_ID`) REFERENCES `news_reports` (`REPORT_ID`),
  CONSTRAINT `FK_COMMENT_USER` FOREIGN KEY (`CREATED_BY`) REFERENCES `users` (`ID_USER`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
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
