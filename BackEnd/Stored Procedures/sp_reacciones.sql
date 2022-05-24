-- STORED PROCEDURE REACCIONES


USE GOOD_OLD_TIMES_DB;
-- CALL sp_Reactions("D", 7, 26, 1);
-- CALL sp_Reactions('SSR', NULL,'13', NULL);
-- SELECT * FROM REACTIONS;

DELIMITER //
DROP PROCEDURE IF EXISTS sp_Reactions//
CREATE PROCEDURE sp_Reactions (	
	IN Oper char(4),
    IN user_idT INT,
	IN report_idT INT,    
    IN likedT TINYINT(1)
)
CONTAINS SQL
`sp_Reactions`:
BEGIN

	DECLARE EXIT HANDLER FOR 1452
		BEGIN
			SELECT 'Error al insertar en la tabla asociativa reacciones' MSG;
		END;
 

 /*#######################################
		CONSULTAR REACCIONES DE UNA NOTICIA
    ########################################*/
    IF Oper = 'SRR'
	THEN
		SELECT `USER`, `LIKED`, `CREATION_DATE`
        FROM reactions
        WHERE REPORT_ID = report_idT;
        LEAVE `sp_Reactions`;   
    END IF;
    
    /*#######################################
			CONSULTAR UNA REACCIÓN
    ########################################*/
    IF Oper = 'SO'
	THEN
		SELECT `USER`, `LIKED`, `CREATION_DATE`, `REPORT_ID`
        FROM reactions
       WHERE  `USER` = user_idT AND REPORT_ID = report_idT;
        LEAVE `sp_Reactions`;   
    END IF;
    

	/*#######################################
					INSERT
    ########################################*/
	IF Oper = 'I'
    THEN
		START TRANSACTION;
			INSERT INTO reactions(`REPORT_ID`, `USER`, `CREATED_BY`, `LIKED`) 
				VALUES (report_idT, user_idT, user_idT, likedT);
                
		IF @@error_count = 0
            THEN
				COMMIT;
		ELSE
				SELECT 'Error al insertar en la tabla reacciones' MSG;                
				ROLLBACK;
		END IF;
            
		LEAVE `sp_Reactions`;
	END IF;        
  
     /*#######################################
			VALIDACION PARA MODIFICAR
    ########################################*/
    IF NOT EXISTS(
	SELECT * FROM reactions
	WHERE `USER` = user_idT AND  REPORT_ID = report_idT)
	THEN
		SELECT 'tabla asociativa reacciones inexistente' MSG;
		LEAVE `sp_Reactions`;
	END IF;
    
     /*#######################################
					LIKE
    ########################################*/
	IF Oper = 'L'
	THEN
		START TRANSACTION;
			UPDATE reactions
            SET LIKED = 1
			WHERE  `USER` = user_idT AND REPORT_ID = report_idT;
            
		IF @@error_count = 0
            THEN
				COMMIT;
			ELSE				
				ROLLBACK;
			END IF;
            LEAVE `sp_Reactions`;   
    END IF;
    

    /*#######################################
					DISLIKE
    ########################################*/
	IF Oper = 'D'
	THEN
		START TRANSACTION;
			UPDATE reactions
            SET LIKED = 0
			WHERE  `USER` = user_idT AND REPORT_ID = report_idT;
            
		IF @@error_count = 0
            THEN
				COMMIT;
			ELSE
				
				ROLLBACK;
			END IF;
            LEAVE `sp_Reactions`;   
    END IF;
	
    
END//
DELIMITER ;