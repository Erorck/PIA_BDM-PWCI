-- STORED PROCEDURE NOTICIA

USE GOOD_OLD_TIMES_DB;
-- SELECT * FROM noticias;
-- CALL sp_noticias('I', null, 'Capoeira12', 'gordito21','KARIM', 'CHAPARRO', 'HDZ', 'karim@live.com', '1999-12-07', null)
-- CALL sp_noticias('U', 4, 'Mascaporonga12', NULL, NULL, NULL, NULL, NULL, NULL, null);
-- CALL sp_noticias('U', 3, 'Mascaporonga12', NULL,'KARIM', 'CHAPARRO', NULL, 'karim@live.com', '1999-12-08', null);
-- CALL sp_News_Reports('SA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
-- SELECT * FROM users;

DELIMITER //
DROP PROCEDURE IF EXISTS sp_News_Reports//
CREATE PROCEDURE sp_News_Reports (	
	IN Oper char(4),
	IN id_ReportT INT,
	IN signT VARCHAR(100),
	IN streetT VARCHAR(100),
	IN neighbourhoohT VARCHAR(70),
	IN cityT VARCHAR(80),
	IN countryT VARCHAR(50),
	IN event_date DATETIME,
	IN headerT VARCHAR(80),
	IN descriptionT VARCHAR(80),
	IN contentT VARCHAR(80),
	IN likes INT,
	IN thumbnailT LONGBLOB,
    IN updated_byT INT
)
CONTAINS SQL
`sp_News_Reports`:
BEGIN

	DECLARE EXIT HANDLER FOR 1452
		BEGIN
			SELECT 'Error al insertar en la tabla noticias' MSG;
		END;
 

 /*#######################################
				CONSULTAR TODOS
    ########################################*/
    IF Oper = 'SA'
	THEN
		SELECT `REPORT_NUMBER`, `AUTOR_SIGN`,  
        `EVENT_STREET`, `EVENT_NEIGHBOURHOOD`, `EVENT_CITY`, `EVENT_COUNTRY`, 
        `HEADER`, `REPORT_DESCRIPTION`, `CONTENT`, `LIKES`, `THUMBNAIL`, `EVENT_DATE`, `PUBLICATION_DATE`,
        `CREATION_DATE`, `CREATED_BY_ID`, `CREATED_BY_NAME`,
		`LAST_UPDATE_DATE`, `UPDATED_BY_ID`, `UPDATED_BY_NAME`, `REPORT_STATUS`
        FROM v_news_detailed;
        LEAVE `sp_News_Reports`;   
    END IF;
    
    /*#######################################
	 CONSULTAR NOTICIAS RESUMIDO
    ########################################*/
    IF Oper = 'SURS'
	THEN
		SELECT ID_USER, USER_NAME, USER_ALIAS, USER_STATUS, USER_ICON FROM v_registered_users_small;
        LEAVE `sp_News_Reports`;
    END IF;
    
    /*#######################################
			CONSULTAR REPORTEROS RESUMIDO
    ########################################*/
    IF Oper = 'SJS'
	THEN
		SELECT ID_JOURNALIST, JOURNALIST_NAME, JOURNALIST_ALIAS, JOURNALIST_STATUS, JOURNALIST_ICON FROM v_journalists_small;
        LEAVE `sp_News_Reports`;
    END IF;
    
    /*#######################################
				CONSULTAR UNO
    ########################################*/
    IF Oper = 'SO'
	THEN
		SELECT `ID_USER`, `FULL_NAME`, `USER_ALIAS`,  `CREDENTIAL`, `EMAIL`, `PHONE_NUMBER`, `BIRTHDAY`, `PROFILE_PICTURE`, `BANNER_PICTURE`, `USER_TYPE`, `CREATED_BY`, `LAST_UPDATED_BY` FROM USERS
        WHERE `EMAIL` = emailT;
        LEAVE `sp_News_Reports`;   
    END IF;
    
    /*#######################################
				CONSULTAR UNO POR ID
    ########################################*/
    IF Oper = 'SOI'
	THEN
		SELECT `ID_USER`, `FULL_NAME`, `USER_ALIAS`,  `CREDENTIAL`, `EMAIL`, `PHONE_NUMBER`, `BIRTHDAY`, `PROFILE_PICTURE`, `BANNER_PICTURE`, `USER_TYPE`, `CREATED_BY`, `LAST_UPDATED_BY` FROM USERS
        WHERE `ID_USER` = id_ReportT;
        LEAVE `sp_News_Reports`;   
    END IF;
    
    /*#######################################
			CONSULTAR CREDENCIAL POR EMAIL
    ########################################*/
    IF Oper = 'SCE'
	THEN
		SELECT  `ID_USER` FROM USERS WHERE `EMAIL` = emailT;
        LEAVE `sp_News_Reports`;   
    END IF;
    
     /*#############################################################
	VERIFICAR SI UN EMAIL HA SIDO UTILIZADO ANTES DE ACTUALIZARLO
    ##############################################################*/
    IF Oper = 'SUE'
	THEN
		SELECT  `ID_USER` FROM USERS WHERE `EMAIL` = emailT AND `ID_USER` != id_ReportT;
        LEAVE `sp_News_Reports`;   
    END IF;
    
    /*#######################################
				CONSULTAR CORREO
    ########################################*/
    IF Oper = 'SE'
	THEN
		SELECT  `EMAIL` FROM USERS WHERE `EMAIL` = emailT;
        LEAVE `sp_News_Reports`;   
    END IF;

	/*#######################################
					INSERT
    ########################################*/
	IF Oper = 'I'
    THEN
		START TRANSACTION;
			INSERT INTO USERS(`FULL_NAME`,`USER_ALIAS`,  `CREDENTIAL`, `EMAIL`, `PHONE_NUMBER`, `BIRTHDAY`, `PROFILE_PICTURE`, `BANNER_PICTURE`, `USER_TYPE`, `CREATED_BY`, `LAST_UPDATED_BY`) 
				VALUES (nameT, signT, credentialT, emailT, phone_NumberT, birthdayT, profile_PicT, banner_PicT, user_TypeT, updated_byT, updated_byT);
                
		IF @@error_count = 0
            THEN
				COMMIT;
		ELSE
				SELECT 'Error al insertar en la tabla noticiass.' MSG
                FROM users WHERE id_User = id_ReportT;
				ROLLBACK;
		END IF;
            
		LEAVE `sp_News_Reports`;
	END IF;        
  
     /*#######################################
			VALIDACION PARA MODIFICAR
    ########################################*/
    IF NOT EXISTS(
	SELECT * FROM users
	WHERE id_User = id_ReportT)
	THEN
		SELECT 'noticias inexistente' MSG;
		LEAVE `sp_News_Reports`;
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
    `USER_ALIAS` = IFNULL(signT, `USER_ALIAS`),
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
    id_User = id_ReportT;
            
SELECT @@Error_Count;
		IF @@error_count = 0
            THEN
				COMMIT;
			ELSE
				SELECT CONCAT('Error al modificar al noticias con No. ', CAST(id_User AS CHAR))
                FROM users WHERE id_User = id_ReportT;
				ROLLBACK;
			END IF;
            
		LEAVE `sp_News_Reports`;
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
    id_User = id_ReportT;
            
            
         IF @@error_count = 0
            THEN
				COMMIT;
			ELSE
				SELECT CONCAT('Error al suspender al noticias con No. ', CAST(id_User AS CHAR))
                FROM users WHERE id_User = id_ReportT;
				ROLLBACK;
			END IF;
            
		LEAVE `sp_News_Reports`;   
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
    id_User = id_ReportT;
        
		IF @@error_count = 0
            THEN
				COMMIT;
			ELSE
				SELECT CONCAT('Error al habilitar al noticias con No. ', CAST(id_User AS CHAR))
                FROM users WHERE id_User = id_ReportT;
				ROLLBACK;
			END IF;
            
		LEAVE `sp_News_Reports`;   
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
    id_User = id_ReportT;
            
		IF @@error_count = 0
            THEN
				COMMIT;
			ELSE
				SELECT CONCAT('Error al dar de baja al noticias con No. ', CAST(id_User AS CHAR))
                FROM users WHERE id_User = id_ReportT;
				ROLLBACK;
			END IF;
            LEAVE `sp_News_Reports`;   
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
    id_User = id_ReportT;
            
		IF @@error_count = 0
            THEN
				COMMIT;
			ELSE
				SELECT CONCAT('Error al dar convertir en reportero al noticias con No. ', CAST(id_User AS CHAR))
                FROM users WHERE id_User = id_ReportT;
				ROLLBACK;
			END IF;
            LEAVE `sp_News_Reports`;   
    END IF;
    
    /*#######################################
		CONVERTIR EN noticias REGISTRADO
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
    id_User = id_ReportT;
            
		IF @@error_count = 0
            THEN
				COMMIT;
			ELSE
				SELECT CONCAT('Error al dar convertir en noticias registrado al noticias con No. ', CAST(id_User AS CHAR))
                FROM users WHERE id_User = id_ReportT;
				ROLLBACK;
			END IF;
            LEAVE `sp_News_Reports`;   
    END IF;
    
END//
DELIMITER ;