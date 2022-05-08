-- STORED PROCEDURE SECCIÓN

-- CALL sp_Section('SA', NULL, NULL, NULL, NULL, NULL);
-- CALL sp_Section('E', 1, NULL, NULL, NULL, NULL);

-- DELETE FROM categories WHERE CATEGORY_ID = 2;

USE GOOD_OLD_TIMES_DB;

DELIMITER //
DROP PROCEDURE IF EXISTS sp_Section//
CREATE PROCEDURE sp_Section (	
	IN Oper char(4),
    IN category_idT INT,
	IN category_NameT VARCHAR(40),
    IN colorT CHAR(7),
	IN orderT TINYINT,	
    IN updated_byT INT
)
CONTAINS SQL
`sp_Section`:
BEGIN

	DECLARE EXIT HANDLER FOR 1452
		BEGIN
			SELECT 'Error al insertar en la tabla secciones' MSG;
		END;
 

 /*#######################################
				CONSULTAR TODOS
    ########################################*/
    IF Oper = 'SA'
	THEN
		SELECT `SECTION_ID`, `SECTION_NAME`, `DISPLAY_COLOR`,  `DISPLAY_ORDER`, `CREATION_DATE`, `CREATED_BY_ID`, `CREATED_BY_NAME`, `LAST_UPDATE_DATE`, `UPDATED_BY_ID`, `UPDATED_BY_NAME`, `SECTION_STATUS` 
        FROM v_Sections_Detailed;
        LEAVE `sp_Section`;   
    END IF;
    
    /*#######################################
	CONSULTAR ACTIVAS ORDENADAS POR LUGAR Y NOMBRE
    ########################################*/
    IF Oper = 'SAA'
	THEN
		SELECT `SECTION_ID`, `SECTION_NAME`, `DISPLAY_COLOR`, `DISPLAY_ORDER`, `CREATION_DATE`, `CREATED_BY_ID`, `CREATED_BY_NAME`, `LAST_UPDATE_DATE`, `UPDATED_BY_ID`, `UPDATED_BY_NAME`, `SECTION_STATUS` 
        FROM v_Sections_Detailed
        WHERE `SECTION_STATUS` = 'A'
        ORDER BY DISPLAY_ORDER, SECTION_NAME ASC;
        LEAVE `sp_Section`;   
    END IF;
    
     /*#######################################
	CONSULTAR ELIMINADAS ORDENADAS ALFABÉTICAMENTE
    ########################################*/
    IF Oper = 'SAE'
	THEN
		SELECT `SECTION_ID`, `SECTION_NAME`, `DISPLAY_COLOR`,  `DISPLAY_ORDER`, `CREATION_DATE`, `CREATED_BY_ID`, `CREATED_BY_NAME`, `LAST_UPDATE_DATE`, `UPDATED_BY_ID`, `UPDATED_BY_NAME`, `SECTION_STATUS` 
        FROM v_Sections_Detailed
        WHERE `SECTION_STATUS` = 'E'
        ORDER BY SECTION_NAME ASC;
        LEAVE `sp_Section`;   
    END IF;
    
    /*#######################################
				CONSULTAR UNO POR ID
    ########################################*/
    IF Oper = 'SOI'
	THEN
		SELECT `SECTION_ID`, `SECTION_NAME`, `DISPLAY_COLOR`,  `DISPLAY_ORDER`, `CREATION_DATE`, `CREATED_BY_ID`, `CREATED_BY_NAME`, `LAST_UPDATE_DATE`, `UPDATED_BY_ID`, `UPDATED_BY_NAME`, `SECTION_STATUS` 
        FROM v_Sections_Detailed
        WHERE `SECTION_ID` = category_idT;
        LEAVE `sp_Section`;   
    END IF;
    

    /*#######################################
				CONSULTAR NOMBRE
    ########################################*/
    IF Oper = 'SID'
	THEN
		SELECT  `SECTION_ID`, `SECTION_NAME` FROM v_sections_small 
        WHERE `SECTION_NAME` = category_NameT AND `SECTION_ID` != category_idT;
        LEAVE `sp_Section`;   
    END IF;
    

	/*#######################################
					INSERT
    ########################################*/
	IF Oper = 'I'
    THEN
		START TRANSACTION;
			INSERT INTO CATEGORIES(`CATEGORY_NAME`, `COLOR`, `ORDER`, `CREATED_BY`, `LAST_UPDATED_BY`) 
				VALUES (category_NameT, colorT, orderT, updated_byT, updated_byT);
                
		IF @@error_count = 0
            THEN
				COMMIT;
		ELSE
				SELECT 'Error al insertar en la tabla secciones.' MSG;                
				ROLLBACK;
		END IF;
            
		LEAVE `sp_Section`;
	END IF;        
  
     /*#######################################
			VALIDACION PARA MODIFICAR
    ########################################*/
    IF NOT EXISTS(
	SELECT * FROM categories
	WHERE CATEGORY_ID = category_idT)
	THEN
		SELECT 'Seccion inexistente' MSG;
		LEAVE `sp_Section`;
	END IF;
    
    /*#######################################
					UPDATE
    ########################################*/
	IF Oper = 'U'
	THEN
        
		START TRANSACTION;
			UPDATE categories 
SET 
    `CATEGORY_NAME` = IFNULL(category_NameT, `CATEGORY_NAME`),
    `COLOR` = IFNULL(colorT, `COLOR`),
    `ORDER` = IFNULL(orderT, `ORDER`),
    `LAST_UPDATE_DATE` = NOW(),
    `LAST_UPDATED_BY` = IFNULL(updated_byT, `LAST_UPDATED_BY`)    
WHERE
    CATEGORY_ID = category_idT;
            
SELECT @@Error_Count;
		IF @@error_count = 0
            THEN
				COMMIT;
			ELSE
				SELECT CONCAT('Error al modificar al usuario con No. ', CAST(CATEGORY_NAME AS CHAR))
                FROM categories WHERE CATEGORY_NAME = category_NameT;
				ROLLBACK;
			END IF;
            
		LEAVE `sp_Section`;
    END IF;
    
    
    /*########################################################
	  TODO: TRIGGER DE NOTICIAS AL CAMBIAR STATUS DE SECCION
    #########################################################*/
    
    /*#######################################
					HABILITAR
    ########################################*/
	IF Oper = 'H'
	THEN
		START TRANSACTION;
			UPDATE CATEGORIES 
SET 
	`LAST_UPDATE_DATE` = NOW(),
	`LAST_UPDATED_BY` = IFNULL(updated_byT, `LAST_UPDATED_BY`),
    `SECTION_STATUS` = 'A'
WHERE
    `CATEGORY_ID` = category_idT;
        
		IF @@error_count = 0
            THEN
				COMMIT;
			ELSE
				SELECT CONCAT('Error al habilitar al usuario con No. ', CAST(CATEGORY_NAME AS CHAR))
                FROM categories WHERE SECTION_ID = category_idT;
				ROLLBACK;
			END IF;
            
		LEAVE `sp_Section`;   
    END IF;
    
     /*#######################################
					ELIMINAR
    ########################################*/
	IF Oper = 'E'
	THEN
		START TRANSACTION;
			UPDATE CATEGORIES 
SET 
    `LAST_UPDATE_DATE` = NOW(),
	`LAST_UPDATED_BY` = IFNULL(updated_byT, `LAST_UPDATED_BY`),
    `SECTION_STATUS` = 'E'
WHERE
      `CATEGORY_ID` = category_idT;
            
		IF @@error_count = 0
            THEN
				COMMIT;
			ELSE
				SELECT CONCAT('Error al dar de baja al usuario con No. ', CAST(CATEGORY_NAME AS CHAR))
                FROM CATEGORIES WHERE SECTION_ID = category_idT;
				ROLLBACK;
			END IF;
            LEAVE `sp_Section`;   
    END IF;
    
END//
DELIMITER ;