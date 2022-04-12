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
-- Temporary view structure for view `v_registered_users_small`
--

DROP TABLE IF EXISTS `v_registered_users_small`;
/*!50001 DROP VIEW IF EXISTS `v_registered_users_small`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `v_registered_users_small` AS SELECT 
 1 AS `ID_USER`,
 1 AS `USER_NAME`,
 1 AS `USER_ALIAS`,
 1 AS `USER_STATUS`,
 1 AS `USER_ICON`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_journalists_small`
--

DROP TABLE IF EXISTS `v_journalists_small`;
/*!50001 DROP VIEW IF EXISTS `v_journalists_small`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `v_journalists_small` AS SELECT 
 1 AS `ID_JOURNALIST`,
 1 AS `JOURNALIST_NAME`,
 1 AS `JOURNALIST_ALIAS`,
 1 AS `JOURNALIST_STATUS`,
 1 AS `JOURNALIST_ICON`*/;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `v_registered_users_small`
--

/*!50001 DROP VIEW IF EXISTS `v_registered_users_small`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_registered_users_small` AS select `users`.`ID_USER` AS `ID_USER`,`users`.`FULL_NAME` AS `USER_NAME`,`users`.`USER_ALIAS` AS `USER_ALIAS`,`users`.`USER_STATUS` AS `USER_STATUS`,`users`.`PROFILE_PICTURE` AS `USER_ICON` from `users` where (`users`.`USER_TYPE` = 'UR') */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_journalists_small`
--

/*!50001 DROP VIEW IF EXISTS `v_journalists_small`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_journalists_small` AS select `users`.`ID_USER` AS `ID_JOURNALIST`,`users`.`FULL_NAME` AS `JOURNALIST_NAME`,`users`.`USER_ALIAS` AS `JOURNALIST_ALIAS`,`users`.`USER_STATUS` AS `JOURNALIST_STATUS`,`users`.`PROFILE_PICTURE` AS `JOURNALIST_ICON` from `users` where (`users`.`USER_TYPE` = 'R') */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Dumping routines for database 'good_old_times_db'
--
/*!50003 DROP PROCEDURE IF EXISTS `PROC_DROP_FOREIGN_KEY` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `PROC_DROP_FOREIGN_KEY`(IN tableName VARCHAR(64), IN constraintName VARCHAR(64))
BEGIN
        IF EXISTS(
            SELECT * FROM information_schema.table_constraints
            WHERE 
                table_schema    = DATABASE()     AND
                table_name      = tableName      AND
                constraint_name = constraintName AND
                constraint_type = 'FOREIGN KEY')
        THEN
            SET @query = CONCAT('ALTER TABLE ', tableName, ' DROP FOREIGN KEY ', constraintName, ';');
            PREPARE stmt FROM @query; 
            EXECUTE stmt; 
            DEALLOCATE PREPARE stmt; 
        END IF; 
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_User` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_User`(	
	IN Oper char(4),
	IN id_UserT INT,
	IN user_AliasT VARCHAR(100),
	IN credentialT VARCHAR(75),
	IN nameT VARCHAR(100),
	IN emailT VARCHAR(100),
    IN phone_NumberT VARCHAR(12),
	IN birthdayT DATE,
	IN profile_PicT LONGBLOB, 
    IN banner_PicT LONGBLOB, 
    IN user_TypeT CHAR(2),
    IN updated_byT INT
)
`sp_User`:
BEGIN

	DECLARE EXIT HANDLER FOR 1452
		BEGIN
			SELECT 'Error al insertar en la tabla usuario' MSG;
		END;
 

 /*#######################################
				CONSULTAR TODOS
    ########################################*/
    IF Oper = 'SA'
	THEN
		SELECT `FULL_NAME`, `USER_ALIAS`,  `CREDENTIAL`, `EMAIL`, `PHONE_NUMBER`, `BIRTHDAY`, `PROFILE_PICTURE`, `BANNER_PICTURE`, `USER_TYPE`, `CREATED_BY`, `LAST_UPDATED_BY` FROM USERS;
        LEAVE `sp_User`;   
    END IF;
    
    /*#######################################
	 CONSULTAR USUARIOS REGISTRADOS RESUMIDO
    ########################################*/
    IF Oper = 'SURS'
	THEN
		SELECT ID_USER, USER_NAME, USER_ALIAS, USER_STATUS, USER_ICON FROM v_registered_users_small;
        LEAVE `sp_User`;
    END IF;
    
    /*#######################################
			CONSULTAR REPORTEROS RESUMIDO
    ########################################*/
    IF Oper = 'SJS'
	THEN
		SELECT ID_JOURNALIST, JOURNALIST_NAME, JOURNALIST_ALIAS, JOURNALIST_STATUS, JOURNALIST_ICON FROM v_journalists_small;
        LEAVE `sp_User`;
    END IF;
    
    /*#######################################
				CONSULTAR UNO
    ########################################*/
    IF Oper = 'SO'
	THEN
		SELECT `ID_USER`, `FULL_NAME`, `USER_ALIAS`,  `CREDENTIAL`, `EMAIL`, `PHONE_NUMBER`, `BIRTHDAY`, `PROFILE_PICTURE`, `BANNER_PICTURE`, `USER_TYPE`, `CREATED_BY`, `LAST_UPDATED_BY` FROM USERS
        WHERE `EMAIL` = emailT;
        LEAVE `sp_User`;   
    END IF;
    
    /*#######################################
				CONSULTAR UNO POR ID
    ########################################*/
    IF Oper = 'SOI'
	THEN
		SELECT `ID_USER`, `FULL_NAME`, `USER_ALIAS`,  `CREDENTIAL`, `EMAIL`, `PHONE_NUMBER`, `BIRTHDAY`, `PROFILE_PICTURE`, `BANNER_PICTURE`, `USER_TYPE`, `CREATED_BY`, `LAST_UPDATED_BY` FROM USERS
        WHERE `ID_USER` = id_UserT;
        LEAVE `sp_User`;   
    END IF;
    
    /*#######################################
			CONSULTAR CREDENCIAL POR EMAIL
    ########################################*/
    IF Oper = 'SCE'
	THEN
		SELECT  `ID_USER` FROM USERS WHERE `EMAIL` = emailT;
        LEAVE `sp_User`;   
    END IF;
    
     /*#############################################################
	VERIFICAR SI UN EMAIL HA SIDO UTILIZADO ANTES DE ACTUALIZARLO
    ##############################################################*/
    IF Oper = 'SUE'
	THEN
		SELECT  `ID_USER` FROM USERS WHERE `EMAIL` = emailT AND `ID_USER` != id_UserT;
        LEAVE `sp_User`;   
    END IF;
    
    /*#######################################
				CONSULTAR CORREO
    ########################################*/
    IF Oper = 'SE'
	THEN
		SELECT  `EMAIL` FROM USERS WHERE `EMAIL` = emailT;
        LEAVE `sp_User`;   
    END IF;

	/*#######################################
					INSERT
    ########################################*/
	IF Oper = 'I'
    THEN
		START TRANSACTION;
			INSERT INTO USERS(`FULL_NAME`,`USER_ALIAS`,  `CREDENTIAL`, `EMAIL`, `PHONE_NUMBER`, `BIRTHDAY`, `PROFILE_PICTURE`, `BANNER_PICTURE`, `USER_TYPE`, `CREATED_BY`, `LAST_UPDATED_BY`) 
				VALUES (nameT, user_AliasT, credentialT, emailT, phone_NumberT, birthdayT, profile_PicT, banner_PicT, user_TypeT, updated_byT, updated_byT);
                
		IF @@error_count = 0
            THEN
				COMMIT;
		ELSE
				SELECT 'Error al insertar en la tabla usuarios.' MSG
                FROM users WHERE id_User = id_UserT;
				ROLLBACK;
		END IF;
            
		LEAVE `sp_User`;
	END IF;        
  
     /*#######################################
			VALIDACION PARA MODIFICAR
    ########################################*/
    IF NOT EXISTS(
	SELECT * FROM users
	WHERE id_User = id_UserT)
	THEN
		SELECT 'Usuario inexistente' MSG;
		LEAVE `sp_User`;
	END IF;
    
    /*#######################################
					UPDATE
    ########################################*/
	IF Oper = 'U'
	THEN
        
		START TRANSACTION;
			UPDATE USERS 
SET 
    `FULL_NAME` = IFNULL(nameT, `FULL_NAME`),
    `USER_ALIAS` = IFNULL(user_AliasT, `USER_ALIAS`),
    `CREDENTIAL` = IFNULL(credentialT, `CREDENTIAL`),
    `EMAIL` = IFNULL(emailT, `EMAIL`),
    `PHONE_NUMBER` = IFNULL(phone_numberT, `PHONE_NUMBER`),
    `BIRTHDAY` = IFNULL(birthdayT, `BIRTHDAY`),
    `LAST_UPDATE_DATE` = NOW(),
    `LAST_UPDATED_BY` = IFNULL(updated_byT, `LAST_UPDATED_BY`),
    `PROFILE_PICTURE` = IFNULL(profile_PicT, `PROFILE_PICTURE`),
    `BANNER_PICTURE` = IFNULL(banner_PicT, `BANNER_PICTURE`),
    `USER_TYPE` = IFNULL(user_TypeT, `USER_TYPE`)
WHERE
    id_User = id_UserT;
            
SELECT @@Error_Count;
		IF @@error_count = 0
            THEN
				COMMIT;
			ELSE
				SELECT CONCAT('Error al modificar al usuario con No. ', CAST(id_User AS CHAR))
                FROM users WHERE id_User = id_UserT;
				ROLLBACK;
			END IF;
            
		LEAVE `sp_User`;
    END IF;
    
    /*#######################################
					SUSPENDER
    ########################################*/
	IF Oper = 'S'
	THEN
		START TRANSACTION;
			UPDATE USERS 
SET 
	`LAST_UPDATE_DATE` = NOW(),
    `LAST_UPDATED_BY` = IFNULL(updated_byT, `LAST_UPDATED_BY`),
    `USER_STATUS` = 'B'
WHERE
    id_User = id_UserT;
            
            
         IF @@error_count = 0
            THEN
				COMMIT;
			ELSE
				SELECT CONCAT('Error al suspender al usuario con No. ', CAST(id_User AS CHAR))
                FROM users WHERE id_User = id_UserT;
				ROLLBACK;
			END IF;
            
		LEAVE `sp_User`;   
    END IF;
    
    /*#######################################
					HABILITAR
    ########################################*/
	IF Oper = 'H'
	THEN
		START TRANSACTION;
			UPDATE USERS 
SET 
	`LAST_UPDATE_DATE` = NOW(),
	`LAST_UPDATED_BY` = IFNULL(updated_byT, `LAST_UPDATED_BY`),
    `USER_STATUS` = 'H'
WHERE
    id_User = id_UserT;
        
		IF @@error_count = 0
            THEN
				COMMIT;
			ELSE
				SELECT CONCAT('Error al habilitar al usuario con No. ', CAST(id_User AS CHAR))
                FROM users WHERE id_User = id_UserT;
				ROLLBACK;
			END IF;
            
		LEAVE `sp_User`;   
    END IF;
    
     /*#######################################
					ELIMINAR
    ########################################*/
	IF Oper = 'E'
	THEN
		START TRANSACTION;
			UPDATE USERS 
SET 
    `LAST_UPDATE_DATE` = NOW(),
	`LAST_UPDATED_BY` = IFNULL(updated_byT, `LAST_UPDATED_BY`),
    `USER_STATUS` = 'E'
WHERE
    id_User = id_UserT;
            
		IF @@error_count = 0
            THEN
				COMMIT;
			ELSE
				SELECT CONCAT('Error al dar de baja al usuario con No. ', CAST(id_User AS CHAR))
                FROM users WHERE id_User = id_UserT;
				ROLLBACK;
			END IF;
            LEAVE `sp_User`;   
    END IF;
    
   /*#######################################
			CONVERTIR EN REPORTERO
    ########################################*/
	IF Oper = 'TR'
	THEN
		START TRANSACTION;
			UPDATE USERS 
SET 
    `LAST_UPDATE_DATE` = NOW(),
	`LAST_UPDATED_BY` = IFNULL(updated_byT, `LAST_UPDATED_BY`),
    `USER_TYPE` = 'R'
WHERE
    id_User = id_UserT;
            
		IF @@error_count = 0
            THEN
				COMMIT;
			ELSE
				SELECT CONCAT('Error al dar convertir en reportero al usuario con No. ', CAST(id_User AS CHAR))
                FROM users WHERE id_User = id_UserT;
				ROLLBACK;
			END IF;
            LEAVE `sp_User`;   
    END IF;
    
    /*#######################################
		CONVERTIR EN USUARIO REGISTRADO
    ########################################*/
	IF Oper = 'TRU'
	THEN
		START TRANSACTION;
			UPDATE USERS 
SET 
    `LAST_UPDATE_DATE` = NOW(),
	`LAST_UPDATED_BY` = IFNULL(updated_byT, `LAST_UPDATED_BY`),
    `USER_TYPE` = 'UR'
WHERE
    id_User = id_UserT;
            
		IF @@error_count = 0
            THEN
				COMMIT;
			ELSE
				SELECT CONCAT('Error al dar convertir en usuario registrado al usuario con No. ', CAST(id_User AS CHAR))
                FROM users WHERE id_User = id_UserT;
				ROLLBACK;
			END IF;
            LEAVE `sp_User`;   
    END IF;
    
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-03-31 14:40:00
