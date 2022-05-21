-- STORED PROCEDURE RELACIÓN NOTICIA-CATERGORIA


USE GOOD_OLD_TIMES_DB;

-- CALL sp_News_Categories('SSR', NULL,'13', NULL);


DELIMITER //
DROP PROCEDURE IF EXISTS sp_News_Categories//
CREATE PROCEDURE sp_News_Categories (	
	IN Oper char(4),
    IN category_idT INT,
	IN report_idT INT,    
    IN updated_byT INT
)
CONTAINS SQL
`sp_News_Categories`:
BEGIN

	DECLARE EXIT HANDLER FOR 1452
		BEGIN
			SELECT 'Error al insertar en la tabla asociativa news_categories' MSG;
		END;
 

 /*#######################################
		CONSULTAR SECCIONES DE UNA NOTICIA
    ########################################*/
    IF Oper = 'SSR'
	THEN
		SELECT `CATEGORY_ID`, `CATEGORY_NAME`, `COLOR`
        FROM v_NewsCategories_N
        WHERE REPORT_NUMBER = report_idT;
        LEAVE `sp_News_Categories`;   
    END IF;
    

	/*#######################################
					INSERT
    ########################################*/
	IF Oper = 'I'
    THEN
		START TRANSACTION;
			INSERT INTO news_categories(`REPORT_ID`, `CATEGORY`, `CREATED_BY`) 
				VALUES (report_idT, category_idT, updated_byT);
                
		IF @@error_count = 0
            THEN
				COMMIT;
		ELSE
				SELECT 'Error al insertar en la tabla asociativa news_categories.' MSG;                
				ROLLBACK;
		END IF;
            
		LEAVE `sp_News_Categories`;
	END IF;        
  
     /*#######################################
			VALIDACION PARA MODIFICAR
    ########################################*/
    IF NOT EXISTS(
	SELECT * FROM news_categories
	WHERE CATEGORY = category_idT AND  REPORT_ID = report_idT)
	THEN
		SELECT 'tabla asociativa news_categories inexistente' MSG;
		LEAVE `sp_News_Categories`;
	END IF;

    
     /*#######################################
					ELIMINAR
    ########################################*/
	IF Oper = 'E'
	THEN
		START TRANSACTION;
			DELETE FROM news_categories 
			WHERE CATEGORY = category_idT AND REPORT_ID = report_idT;
            
		IF @@error_count = 0
            THEN
				COMMIT;
			ELSE
				SELECT CONCAT('Error al dar de baja la tabla asociativa news_categories con IDs: ',CATEGORY_NAME, ' y ', REPORT_NUMBER)
                FROM v_NewsCategories_N 
                WHERE CATEGORY_ID = category_idT AND REPORT_NUMBER = report_idT;
				ROLLBACK;
			END IF;
            LEAVE `sp_News_Categories`;   
    END IF;
    
END//
DELIMITER ;