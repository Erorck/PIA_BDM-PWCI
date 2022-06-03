-- STORED PROCEDURE VIDEOS

USE GOOD_OLD_TIMES_DB;

DELIMITER //
DROP PROCEDURE IF EXISTS sp_Videos//
CREATE PROCEDURE sp_Videos (  
    IN Oper char(4),
    IN video_idT INT,
    IN video_contentT LONGBLOB,
	IN report_idT INT    
)
CONTAINS SQL
`sp_Videos`:
BEGIN

	DECLARE EXIT HANDLER FOR 1452
		BEGIN
			SELECT 'Error al insertar en la tabla asociativa news_videos' MSG;
		END;
 

 /*#######################################
		CONSULTAR VIDEOS DE UNA NOTICIA
    ########################################*/
    IF Oper = 'SVR'
	THEN
		SELECT `ID_VIDEO`, `CONTENT`, `REPORT_ID`
        FROM VIDEOS
        WHERE REPORT_ID = report_idT;
        LEAVE `sp_Videos`;   
    END IF;
    

	/*#######################################
					INSERT
    ########################################*/
	IF Oper = 'I'
    THEN
		START TRANSACTION;
			INSERT INTO videos(`DESCRIPTION`, `CONTENT`, `ROUTE`, `REPORT_ID`) 
				VALUES ('Un video', video_contentT, 'algún lugar', report_idT);
                
		IF @@error_count = 0
            THEN
				COMMIT;
		ELSE
				SELECT 'Error al insertar en la tabla asociativa news_videos' MSG;                
				ROLLBACK;
		END IF;
            
		LEAVE `sp_Videos`;
	END IF;        
  
     /*#######################################
			VALIDACION PARA MODIFICAR
    ########################################*/
    IF NOT EXISTS(
	SELECT * FROM videos
	WHERE ID_VIDEO = video_idT AND  REPORT_ID = report_idT)
	THEN
		SELECT 'tabla asociativa news_videos inexistente' MSG;
		LEAVE `sp_Videos`;
	END IF;

    
     /*#######################################
					ELIMINAR
    ########################################*/
	IF Oper = 'E'
	THEN
		START TRANSACTION;
			DELETE FROM videos 
			WHERE ID_VIDEO = video_idT AND REPORT_ID = report_idT;
            
		IF @@error_count = 0
            THEN
				COMMIT;
			ELSE
				SELECT CONCAT('Error al dar de baja la tabla asociativa news_videos con IDs: ',ID_VIDEO, ' y ', REPORT_ID)
                FROM videos 
                WHERE ID_VIDEO = video_idT AND REPORT_ID = report_idT;
				ROLLBACK;
			END IF;
            LEAVE `sp_Videos`;   
    END IF;
    
END//
DELIMITER ;