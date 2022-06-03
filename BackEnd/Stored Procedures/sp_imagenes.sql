-- STORED PROCEDURE VIDEOS

USE GOOD_OLD_TIMES_DB;

DELIMITER //
DROP PROCEDURE IF EXISTS sp_Images//
CREATE PROCEDURE sp_Images (  
    IN Oper char(4),
    IN image_idT INT,
    IN image_contentT LONGBLOB,
	IN report_idT INT    
)
CONTAINS SQL
`sp_Images`:
BEGIN

	DECLARE EXIT HANDLER FOR 1452
		BEGIN
			SELECT 'Error al insertar en la tabla asociativa news_images' MSG;
		END;
 

 /*#######################################
	CONSULTAR IMAGENES DE UNA NOTICIA
    ########################################*/
    IF Oper = 'SIR'
	THEN
		SELECT `ID_IMAGE`, `CONTENT`, `REPORT_ID`
        FROM IMAGES
        WHERE REPORT_ID = report_idT;
        LEAVE `sp_Images`;   
    END IF;
    

	/*#######################################
					INSERT
    ########################################*/
	IF Oper = 'I'
    THEN
		START TRANSACTION;
			INSERT INTO images(`DESCRIPTION`, `CONTENT`, `ROUTE`, `REPORT_ID`) 
				VALUES ('Un video', image_contentT, 'Algun lugar', report_idT);
                
		IF @@error_count = 0
            THEN
				COMMIT;
		ELSE
				SELECT 'Error al insertar en la tabla asociativa news_images' MSG;                
				ROLLBACK;
		END IF;
            
		LEAVE `sp_Images`;
	END IF;        
  
     /*#######################################
			VALIDACION PARA MODIFICAR
    ########################################*/
    IF NOT EXISTS(
	SELECT * FROM images
	WHERE ID_IMAGE = image_idT AND  REPORT_ID = report_idT)
	THEN
		SELECT 'tabla asociativa news_images inexistente' MSG;
		LEAVE `sp_Images`;
	END IF;

    
     /*#######################################
					ELIMINAR
    ########################################*/
	IF Oper = 'E'
	THEN
		START TRANSACTION;
			DELETE FROM images 
			WHERE ID_IMAGE = image_idT AND REPORT_ID = report_idT;
            
		IF @@error_count = 0
            THEN
				COMMIT;
			ELSE
				SELECT CONCAT('Error al dar de baja la tabla asociativa news_images con IDs: ',ID_IMAGE, ' y ', REPORT_ID)
                FROM images 
                WHERE ID_IMAGE = image_idT AND REPORT_ID = report_idT;
				ROLLBACK;
			END IF;
            LEAVE `sp_Images`;   
    END IF;
    
END//
DELIMITER ;