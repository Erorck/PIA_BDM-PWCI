-- STORED PROCEDURE USUARIO

USE scdchnc;
-- SELECT * FROM usuario;
-- CALL sp_Usuario('I', null, 'Capoeira12', 'gordito21','KARIM', 'CHAPARRO', 'HDZ', 'karim@live.com', '1999-12-07', null)
-- CALL sp_Usuario('U', 4, 'Mascaporonga12', NULL, NULL, NULL, NULL, NULL, NULL, null);
-- CALL sp_Usuario('U', 3, 'Mascaporonga12', NULL,'KARIM', 'CHAPARRO', NULL, 'karim@live.com', '1999-12-08', null);
-- CALL sp_Usuario('H', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, null);
-- SELECT * FROM usuario;

DELIMITER //
DROP PROCEDURE IF EXISTS sp_Usuario//
CREATE PROCEDURE sp_Usuario (	
	IN Oper char(2),
	IN id_UserT INT,
	IN nicknameT VARCHAR(40),
	IN credentialT VARCHAR(45),
	IN nameT VARCHAR(35),
	IN apellido_PT CHAR(25),
	IN apellido_MT CHAR(25),
	IN emailT VARCHAR(40),
	IN f_NacT DATE,
	IN Foto_PerfilT VARCHAR(260)
)
CONTAINS SQL
`sp_Usuario`:
BEGIN

	DECLARE EXIT HANDLER FOR 1452
		BEGIN
			SELECT 'Error al insertar en la tabla usuario' MSG;
		END;
        
	DECLARE EXIT HANDLER FOR 1062
		BEGIN
			SELECT CONCAT('Identificadores duplicados con entrada (ID: ',id_Usuario, ' - Nickname: ' ,nickname,') ') AS message
            FROM usuario WHERE nickname = nicknameT;
		END;

	/*#######################################
					INSERT
    ########################################*/
	IF Oper = 'I'
    THEN
		START TRANSACTION;
			INSERT INTO usuario(nombre, apellido_P, apellido_M, nickname, contrasenia, email, f_Nac, Foto_Perfil) 
				VALUES (nameT, apellido_PT, apellido_MT, nicknameT, credentialT, emailT, f_NacT, Foto_PerfilT);
            
		LEAVE `sp_Usuario`;
	END IF;        
  
     /*#######################################
			VALIDACION PARA MODIFICAR
    ########################################*/
    IF NOT EXISTS(
	SELECT * FROM usuario
	WHERE id_Usuario = id_UserT)
	THEN
		SELECT 'Usuario inexistente' MSG;
		LEAVE `sp_Usuario`;
	END IF;
    
    /*#######################################
					UPDATE
    ########################################*/
	IF Oper = 'U'
	THEN
		
		START TRANSACTION;
			UPDATE usuario 
			SET 
				nombre = IFNULL(nameT, nombre),
				apellido_P = IFNULL(apellido_PT, apellido_P),
				apellido_M = IFNULL(apellido_MT, apellido_M),
				nickname = IFNULL(nicknameT, nickname),
				contrasenia = IFNULL(credentialT, contrasenia),
				email = IFNULL(emailT, email),
				f_Nac = IFNULL(f_NacT, f_Nac),
				f_Mod = NOW(),
				Foto_Perfil = IFNULL(Foto_PerfilT, Foto_Perfil)
			WHERE
				id_Usuario = id_UserT;
            
            SELECT @@Error_Count;
		IF @@error_count = 0
            THEN
				COMMIT;
			ELSE
				SELECT CONCAT('Error al modificar al usuario con No. ', CAST(id_Usuario AS CHAR))
                FROM usuario WHERE id_Usuario = id_UserT;
				ROLLBACK;
			END IF;
            
		LEAVE `sp_Usuario`;
    END IF;
    
    /*#######################################
					SUSPENDER
    ########################################*/
	IF Oper = 'S'
	THEN
		START TRANSACTION;
			UPDATE usuario 
SET 
    estatus = 'S',
    f_Mod = NOW()
WHERE
    id_Usuario = id_UserT;
            
            
         IF @@error_count = 0
            THEN
				COMMIT;
			ELSE
				SELECT CONCAT('Error al suspender al usuario con No. ', CAST(id_Usuario AS CHAR))
                FROM usuario WHERE id_Usuario = id_UserT;
				ROLLBACK;
			END IF;
            
		LEAVE `sp_Usuario`;   
    END IF;
    
    /*#######################################
					HABILITAR
    ########################################*/
	IF Oper = 'H'
	THEN
		START TRANSACTION;
			UPDATE usuario 
SET 
    estatus = 'A',
    f_Mod = NOW()
WHERE
    id_Usuario = id_UserT;
        
		IF @@error_count = 0
            THEN
				COMMIT;
			ELSE
				SELECT CONCAT('Error al habilitar al usuario con No. ', CAST(id_Usuario AS CHAR))
                FROM usuario WHERE id_Usuario = id_UserT;
				ROLLBACK;
			END IF;
            
		LEAVE `sp_Usuario`;   
    END IF;
    
     /*#######################################
					ELIMINAR
    ########################################*/
	IF Oper = 'E'
	THEN
		START TRANSACTION;
			UPDATE usuario 
SET 
    estatus = 'E',
    f_Mod = NOW()
WHERE
    id_Usuario = id_UserT;
            
		IF @@error_count = 0
            THEN
				COMMIT;
			ELSE
				SELECT CONCAT('Error al dar de baja al usuario con No. ', CAST(id_Usuario AS CHAR))
                FROM usuario WHERE id_Usuario = id_UserT;
				ROLLBACK;
			END IF;
    END IF;
    
END//
DELIMITER ;