-- STORED PROCEDURE NEWS_TAGS

/*CALL sp_News_Tags('I', 'Mandarina');
CALL sp_News_Tags('I', 'Manzana');
CALL sp_News_Tags('I', 'Papaya');
CALL sp_News_Tags('SAA', NULL);*/
-- CALL sp_News_Tags('STR', NULL, 1);

-- DELETE FROM categories WHERE CATEGORY_ID = 2;

USE GOOD_OLD_TIMES_DB;

DELIMITER //
DROP PROCEDURE IF EXISTS sp_News_Tags//
CREATE PROCEDURE sp_News_Tags (	
	IN Oper char(4),
    IN tag_idT VARCHAR(50),
    IN report_idT INT,
    IN created_byT INT
)
CONTAINS SQL
`sp_News_Tags`:
BEGIN

	DECLARE EXIT HANDLER FOR 1452
		BEGIN
			SELECT 'Error al insertar en la tabla asociativa news_tags' MSG;
		END;
 

 /*#######################################
				CONSULTAR TODAS
    ########################################*/
    IF Oper = 'SA'
	THEN
		SELECT `TAG` AS TAG_NAME, `REPORT_ID` AS REPORT, `CREATION_DATE`, `CREATED_BY` AS CREATED_BY_ID
        FROM news_tags;
        LEAVE `sp_News_Tags`;   
    END IF;
    
    /*#######################################
		CONSULTAR TODAS LAS DE UNA ETIQUETA
    ########################################*/
    IF Oper = 'SAT'
	THEN
		SELECT `TAG` AS TAG_NAME, `REPORT_ID` AS REPORT, `CREATION_DATE`, `CREATED_BY` AS CREATED_BY_ID
        FROM news_tags
        WHERE TAG_NAME = tag_idT;
        LEAVE `sp_News_Tags`;   
    END IF;
    
    /*#######################################
		CONSULTAR TODAS LAS DE UNA NOTICIA
    ########################################*/
    IF Oper = 'STR'
	THEN
		SELECT `TAG` AS TAG_NAME, `REPORT_ID` AS REPORT, `CREATION_DATE`, `CREATED_BY` AS CREATED_BY_ID
        FROM news_tags
        WHERE REPORT_ID = report_idT;
        LEAVE `sp_News_Tags`;   
    END IF;
    
	/*#######################################
					INSERT
    ########################################*/
	IF Oper = 'I'
    THEN
		START TRANSACTION;
			INSERT INTO NEWS_TAGS(`TAG`, `REPORT_ID`, `CREATED_BY`) 
				VALUES (tag_idT, report_idT, created_byT);
                
		IF @@error_count = 0
            THEN
				COMMIT;
		ELSE
				SELECT 'Error al insertar en la tabla asociativa news_tags' MSG;                
				ROLLBACK;
		END IF;
            
		LEAVE `sp_News_Tags`;
	END IF;        
    
     /*#######################################
					ELIMINAR
    ########################################*/
	IF Oper = 'E'
	THEN
		START TRANSACTION;
		DELETE FROM NEWS_TAGS
		WHERE TAG = tag_idT AND REPORT_ID = report_idT;
            
		IF @@error_count = 0
            THEN
				COMMIT;
			ELSE
				SELECT CONCAT('Error al dar de baja la relacion NEWS_TAG con identificadores:  ', TAG_NAME, ' y ', REPORT_ID)
                FROM NEWS_TAGS WHERE TAG = tag_idT AND REPORT_ID = report_idT;
				ROLLBACK;
			END IF;
            LEAVE `sp_News_Tags`;   
    END IF;
    
END//
DELIMITER ;