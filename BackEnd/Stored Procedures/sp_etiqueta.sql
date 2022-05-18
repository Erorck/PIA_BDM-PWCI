-- STORED PROCEDURE ETIQUETA

/*CALL sp_Tags('I', 'Mandarina');
CALL sp_Tags('I', 'Manzana');
CALL sp_Tags('I', 'Papaya');
CALL sp_Tags('SAA', NULL);*/
-- CALL sp_Tags('E', 1, NULL, NULL, NULL, NULL);

-- DELETE FROM categories WHERE CATEGORY_ID = 2;

USE GOOD_OLD_TIMES_DB;

DELIMITER //
DROP PROCEDURE IF EXISTS sp_Tags//
CREATE PROCEDURE sp_Tags (	
	IN Oper char(4),
    IN tag_idT VARCHAR(50)
)
CONTAINS SQL
`sp_Tags`:
BEGIN

	DECLARE EXIT HANDLER FOR 1452
		BEGIN
			SELECT 'Error al insertar en la tabla etiquetas' MSG;
		END;
 

 /*#######################################
				CONSULTAR TODAS
    ########################################*/
    IF Oper = 'SA'
	THEN
		SELECT `TAG_NAME`, `TAG_STATUS` AS `STATUS`
        FROM tags;
        LEAVE `sp_Tags`;   
    END IF;
    
    /*#######################################
	 CONSULTAR ACTIVAS ORDENADAS POR NOMBRE
    ########################################*/
    IF Oper = 'SAA'
	THEN
		SELECT `TAG_NAME`, `TAG_STATUS` AS `STATUS`
        FROM tags
        WHERE `TAG_STATUS` = 'EU'
        ORDER BY TAG_NAME ASC;
        LEAVE `sp_Tags`;   
    END IF;
    
    
	/*#######################################
					INSERT
    ########################################*/
	IF Oper = 'I'
    THEN
		START TRANSACTION;
			INSERT INTO TAGS(`TAG_NAME`) 
				VALUES (tag_idT);
                
		IF @@error_count = 0
            THEN
				COMMIT;
		ELSE
				SELECT 'Error al insertar en la tabla etiquetas.' MSG;                
				ROLLBACK;
		END IF;
            
		LEAVE `sp_Tags`;
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
			UPDATE TAGS 
		SET 
			`TAG_STATUS` = 'EU'
		WHERE
			`TAG_NAME` = tag_idT;
        
		IF @@error_count = 0
            THEN
				COMMIT;
			ELSE
				SELECT CONCAT('Error al habilitar a la CATEGORIA con nombre:  ', TAG_NAME)
                FROM TAGS WHERE TAG_NAME = tag_idT;
				ROLLBACK;
			END IF;
            
		LEAVE `sp_Tags`;   
    END IF;
    
     /*#######################################
					ELIMINAR
    ########################################*/
	IF Oper = 'E'
	THEN
		START TRANSACTION;
			UPDATE CATEGORIES 
		SET 			
			`TAG_STATUS` = 'SU'
		WHERE
			  `TAG_NAME` = tag_idT;
            
		IF @@error_count = 0
            THEN
				COMMIT;
			ELSE
				SELECT CONCAT('Error al dar de baja a la CATEGORIA con nombre:  ', TAG_NAME)
                FROM TAGS WHERE TAG_NAME = tag_idT;
				ROLLBACK;
			END IF;
            LEAVE `sp_Tags`;   
    END IF;
    
END//
DELIMITER ;