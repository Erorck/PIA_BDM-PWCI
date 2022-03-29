-- STORED PROCEDURE USUARIO

USE GOOD_OLD_TIMES_DB;
-- SELECT * FROM usuario;
-- CALL sp_Usuario('I', null, 'Capoeira12', 'gordito21','KARIM', 'CHAPARRO', 'HDZ', 'karim@live.com', '1999-12-07', null)
-- CALL sp_Usuario('U', 4, 'Mascaporonga12', NULL, NULL, NULL, NULL, NULL, NULL, null);
-- CALL sp_Usuario('U', 3, 'Mascaporonga12', NULL,'KARIM', 'CHAPARRO', NULL, 'karim@live.com', '1999-12-08', null);
-- CALL sp_User('SA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
-- SELECT * FROM usuario;

DELIMITER //
DROP PROCEDURE IF EXISTS sp_User//
CREATE PROCEDURE sp_User (	
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
CONTAINS SQL
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
	IF Oper = 'TR'
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
    
END//
DELIMITER ;