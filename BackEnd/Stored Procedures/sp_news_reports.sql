-- STORED PROCEDURE NOTICIA

USE GOOD_OLD_TIMES_DB;

CALL sp_News_Reports('-LIK', 26 , NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, null, null, NULL); 
CALL sp_News_Reports('SA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, null, null, NULL);
CALL sp_News_Reports('SOI', 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, null, null, NULL);
CALL sp_News_Categories('SSR', NULL,'25', NULL);
CALL sp_News_Tags('STR', NULL, 17, NULL);
CALL sp_Videos('SVR', NULL, NULL, 17);
CALL sp_Images('SIR', NULL, NULL, 17);
-- SELECT * FROM users;
-- DELETE FROM news_reports WHERE REPORT_ID > 0;

SELECT EVENT_DATE FROM news_reports;
SELECT * FROM videos;

DELIMITER //
DROP PROCEDURE IF EXISTS sp_News_Reports//
CREATE PROCEDURE sp_News_Reports (	
	IN Oper char(4),
	IN id_ReportT INT,
	IN signT VARCHAR(100),
	IN streetT VARCHAR(100),
	IN neighbourhoodT VARCHAR(70),
	IN cityT VARCHAR(80),
	IN countryT VARCHAR(50),
	IN event_dateT DATETIME,
	IN headerT VARCHAR(80),
	IN descriptionT VARCHAR(80),
	IN contentT VARCHAR(10000),	
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
        FROM v_news_detailed
		ORDER BY CREATION_DATE DESC, HEADER DESC;
        LEAVE `sp_News_Reports`;   
    END IF;
    
    /*#######################################
		CONSULTAR TODAS LAS PUBLICADAS
    ########################################*/
    IF Oper = 'SAP'
	THEN
		SELECT `REPORT_NUMBER`, `AUTOR_SIGN`,  
        `EVENT_STREET`, `EVENT_NEIGHBOURHOOD`, `EVENT_CITY`, `EVENT_COUNTRY`, 
        `HEADER`, `REPORT_DESCRIPTION`, `CONTENT`, `LIKES`, `THUMBNAIL`, EVENT_DATE, `PUBLICATION_DATE`,
        `CREATION_DATE`, `CREATED_BY_ID`, `CREATED_BY_NAME`,
		`LAST_UPDATE_DATE`, `UPDATED_BY_ID`, `UPDATED_BY_NAME`, `REPORT_STATUS`
        FROM v_news_detailed
        WHERE REPORT_STATUS = 'P'
		ORDER BY EVENT_DATE DESC, HEADER ASC;        
        LEAVE `sp_News_Reports`;   
    END IF;
    
     /*#######################################
		CONSULTAR TODAS PARA EL REPORTERO
    ########################################*/
    IF Oper = 'SAFR'
	THEN
		SELECT `REPORT_NUMBER`, `AUTOR_SIGN`,  
        `EVENT_STREET`, `EVENT_NEIGHBOURHOOD`, `EVENT_CITY`, `EVENT_COUNTRY`, 
        `HEADER`, `REPORT_DESCRIPTION`, `CONTENT`, `LIKES`, `THUMBNAIL`, EVENT_DATE, `PUBLICATION_DATE`,
        `CREATION_DATE`, `CREATED_BY_ID`, `CREATED_BY_NAME`,
		`LAST_UPDATE_DATE`, `UPDATED_BY_ID`, `UPDATED_BY_NAME`, `REPORT_STATUS`
        FROM v_news_detailed
        WHERE REPORT_STATUS IN ('RA', 'RR', 'P') AND CREATED_BY_ID = updated_byT
        ORDER BY CREATION_DATE DESC, HEADER ASC;
        
        LEAVE `sp_News_Reports`;   
    END IF;
    
    /*#######################################
		CONSULTAR TODAS PARA EL EDITOR
    ########################################*/
    IF Oper = 'SAFE'
	THEN
		SELECT `REPORT_NUMBER`, `AUTOR_SIGN`,  
        `EVENT_STREET`, `EVENT_NEIGHBOURHOOD`, `EVENT_CITY`, `EVENT_COUNTRY`, 
        `HEADER`, `REPORT_DESCRIPTION`, `CONTENT`, `LIKES`, `THUMBNAIL`, EVENT_DATE, `PUBLICATION_DATE`,
        `CREATION_DATE`, `CREATED_BY_ID`, `CREATED_BY_NAME`,
		`LAST_UPDATE_DATE`, `UPDATED_BY_ID`, `UPDATED_BY_NAME`, `REPORT_STATUS`
        FROM v_news_detailed       
        WHERE REPORT_STATUS IN ('RA')
		ORDER BY CREATION_DATE DESC, HEADER ASC;
        
        LEAVE `sp_News_Reports`;   
    END IF;
    
    /*#######################################
			CONSULTAR NOTICIAS RESUMIDO
    ########################################*/
    IF Oper = 'SRS'
	THEN
		SELECT `REPORT_NUMBER`,
        `HEADER`, `REPORT_DESCRIPTION`, `THUMBNAIL`, EVENT_DATE, `REPORT_STATUS`
        FROM v_news_detailed;
        LEAVE `sp_News_Reports`;
    END IF;
    
    
    /*#######################################
				CONSULTAR UNA POR ID
    ########################################*/
    IF Oper = 'SOI'
	THEN
		SELECT `REPORT_NUMBER`, `AUTOR_SIGN`,  
        `EVENT_STREET`, `EVENT_NEIGHBOURHOOD`, `EVENT_CITY`, `EVENT_COUNTRY`, 
        `HEADER`, `REPORT_DESCRIPTION`, `CONTENT`, `LIKES`, `THUMBNAIL`, EVENT_DATE, `PUBLICATION_DATE`,
        `CREATION_DATE`, `CREATED_BY_ID`, `CREATED_BY_NAME`,
		`LAST_UPDATE_DATE`, `UPDATED_BY_ID`, `UPDATED_BY_NAME`, `REPORT_STATUS`
        FROM v_news_detailed      
        WHERE `REPORT_NUMBER` = id_ReportT;
        LEAVE `sp_News_Reports`;   
    END IF;
    
     /*#######################################
			CONSULTAR LA ULTIMA INSERTADA
    ########################################*/
    IF Oper = 'SNR'
	THEN
		SELECT `REPORT_NUMBER`, `AUTOR_SIGN`,  
        `EVENT_STREET`, `EVENT_NEIGHBOURHOOD`, `EVENT_CITY`, `EVENT_COUNTRY`, 
        `HEADER`, `REPORT_DESCRIPTION`, `CONTENT`, `LIKES`, `THUMBNAIL`, EVENT_DATE, `PUBLICATION_DATE`,
        `CREATION_DATE`, `CREATED_BY_ID`, `CREATED_BY_NAME`,
		`LAST_UPDATE_DATE`, `UPDATED_BY_ID`, `UPDATED_BY_NAME`, `REPORT_STATUS`
        FROM v_news_detailed  
        ORDER BY REPORT_NUMBER DESC LIMIT 0, 1;
        LEAVE `sp_News_Reports`;   
    END IF;

	/*#######################################
					INSERT
    ########################################*/
	IF Oper = 'I'
    THEN
		START TRANSACTION;
			INSERT INTO NEWS_REPORTS(`SIGN`, `LOCATION_STREET`, `LOCATION_NEIGHB`, `LOCATION_CITY`, `LOCATION_COUNTRY`, 
        `REPORT_HEADER`, `REPORT_DESCRIPTION`, `REPORT_CONTENT`, `THUMBNAIL`, EVENT_DATE, `CREATED_BY`, `LAST_UPDATED_BY`, REPORT_STATUS) 
				VALUES (signT, streetT, neighbourhoodT, cityT, countryT,
                headerT, descriptionT, contentT, thumbnailT, event_dateT, updated_byT, updated_byT, 'RR');			

		IF @@error_count = 0
            THEN
				COMMIT;
		ELSE
				SELECT 'Error al insertar en la tabla noticias.' MSG
                FROM news_reports
				ROLLBACK;
		END IF;
            
		LEAVE `sp_News_Reports`;
	END IF;        
  
     /*#######################################
			VALIDACION PARA MODIFICAR
    ########################################*/
    IF NOT EXISTS(
	SELECT * FROM news_reports
	WHERE REPORT_ID = id_ReportT)
	THEN
		SELECT 'noticia inexistente' MSG;
		LEAVE `sp_News_Reports`;
	END IF;
    
    /*#######################################
					UPDATE
    ########################################*/
	IF Oper = 'U'
	THEN
        
		START TRANSACTION;
			UPDATE NEWS_REPORTS 
SET 
    `SIGN` = IFNULL(signT, `SIGN`),
    `LOCATION_STREET` = IFNULL(streetT, `LOCATION_STREET`),
    `LOCATION_NEIGHB` = IFNULL(neighbourhoodT, `LOCATION_NEIGHB`),
    `LOCATION_CITY` = IFNULL(cityT, `LOCATION_CITY`),
    `LOCATION_COUNTRY` = IFNULL(countryT, `LOCATION_COUNTRY`),
    `REPORT_HEADER` = IFNULL(headerT, `REPORT_HEADER`),
    `REPORT_DESCRIPTION` = IFNULL(descriptionT, `REPORT_DESCRIPTION`),
    `REPORT_CONTENT` = IFNULL(contentT, `REPORT_CONTENT`),
    `THUMBNAIL` = IFNULL(thumbnailT, `THUMBNAIL`),
    `LAST_UPDATED_BY` = IFNULL(updated_byT, `LAST_UPDATED_BY`),
    `LAST_UPDATE_DATE` = NOW()
WHERE
    REPORT_ID = id_ReportT;
            
SELECT @@Error_Count;
		IF @@error_count = 0
            THEN
				COMMIT;
			ELSE
				SELECT CONCAT('Error al modificar al noticia con No. ', CAST(id_ReportT AS CHAR))
                FROM news_reports WHERE REPORT_ID = id_ReportT;
				ROLLBACK;
			END IF;
            
		LEAVE `sp_News_Reports`;
    END IF;
    
    /*#######################################
					PUBLICAR
    ########################################*/
	IF Oper = 'PUB'
	THEN
		START TRANSACTION;
			UPDATE news_reports 
SET 
    `LAST_UPDATE_DATE` = NOW(),
    `PUBLICATION_DATE` = NOW(),
    `LAST_UPDATED_BY` = IFNULL(updated_byT, `LAST_UPDATED_BY`),
    `REPORT_STATUS` = 'P'
WHERE
    REPORT_ID = id_ReportT;
            
            
         IF @@error_count = 0
            THEN
				COMMIT;
			ELSE
				SELECT CONCAT('Error al publicar la noticias con No. ', CAST(id_ReportT AS CHAR))
                 FROM news_reports WHERE REPORT_ID = id_ReportT;
				ROLLBACK;
			END IF;
            
		LEAVE `sp_News_Reports`;   
    END IF;
    
    /*#######################################
					ELIMINAR
    ########################################*/
	IF Oper = 'DEL'
	THEN
		START TRANSACTION;
			UPDATE news_reports 
SET 
    `LAST_UPDATE_DATE` = NOW(),
    `LAST_UPDATED_BY` = IFNULL(updated_byT, `LAST_UPDATED_BY`),
    `REPORT_STATUS` = 'E'
WHERE
    REPORT_ID = id_ReportT;
            
            
         IF @@error_count = 0
            THEN
				COMMIT;
			ELSE
				SELECT CONCAT('Error al eliminar la noticias con No. ', CAST(id_ReportT AS CHAR))
                 FROM news_reports WHERE REPORT_ID = id_ReportT;
				ROLLBACK;
			END IF;
            
		LEAVE `sp_News_Reports`;   
    END IF;
    
    /*#######################################
				ENVIAR A REPORTERO
    ########################################*/
	IF Oper = 'STR'
	THEN
		START TRANSACTION;
			UPDATE news_reports 
SET 
    `LAST_UPDATE_DATE` = NOW(),
    `LAST_UPDATED_BY` = IFNULL(updated_byT, `LAST_UPDATED_BY`),
    `REPORT_STATUS` = 'RR'
WHERE
    REPORT_ID = id_ReportT;
            
            
         IF @@error_count = 0
            THEN
				COMMIT;
			ELSE
				SELECT CONCAT('Error al enviar la noticia con No. ', CAST(id_ReportT AS CHAR), ' al reportero')
                 FROM news_reports WHERE REPORT_ID = id_ReportT;
				ROLLBACK;
			END IF;
            
		LEAVE `sp_News_Reports`;   
    END IF;
    
       /*#######################################
				ENVIAR A EDITOR
    ########################################*/
	IF Oper = 'STE'
	THEN
		START TRANSACTION;
			UPDATE news_reports 
SET 
    `LAST_UPDATE_DATE` = NOW(),
    `LAST_UPDATED_BY` = IFNULL(updated_byT, `LAST_UPDATED_BY`),
    `REPORT_STATUS` = 'RA'
WHERE
    REPORT_ID = id_ReportT;
            
            
         IF @@error_count = 0
            THEN
				COMMIT;
			ELSE
				SELECT CONCAT('Error al enviar la noticia con No. ', CAST(id_ReportT AS CHAR), ' al editor')
                 FROM news_reports WHERE REPORT_ID = id_ReportT;
				ROLLBACK;
			END IF;
            
		LEAVE `sp_News_Reports`;   
    END IF;
    
       /*#######################################
				DISMINUIR LIKES
    ########################################*/
	IF Oper = '-LIK'
	THEN
		START TRANSACTION;
			UPDATE news_reports 
SET 
    `LIKES` = LIKES - 1   
WHERE
    REPORT_ID = id_ReportT;
            
            
         IF @@error_count = 0
            THEN
				COMMIT;
			ELSE
				-- SELECT CONCAT('Error al enviar la decrementar los likes en la noticia con No. ', CAST(id_ReportT AS CHAR))
                 -- FROM news_reports WHERE REPORT_ID = id_ReportT;
				ROLLBACK;
			END IF;
            
		LEAVE `sp_News_Reports`;   
    END IF;
    
       /*#######################################
				AUMENTAR LIKES
    ########################################*/
	IF Oper = '+LIK'
	THEN
		START TRANSACTION;
			UPDATE news_reports 
SET 
    `LIKES` = LIKES + 1   
WHERE
    REPORT_ID = id_ReportT;
            
            
         IF @@error_count = 0
            THEN
				COMMIT;
			ELSE
				SELECT CONCAT('Error al enviar la aumentar los likes en la noticia con No. ', CAST(id_ReportT AS CHAR))
                 FROM news_reports WHERE REPORT_ID = id_ReportT;
				ROLLBACK;
			END IF;
            
		LEAVE `sp_News_Reports`;   
    END IF;
    
    /*#######################################
				DISMINUIR COMENTARIOS
    ########################################*/
	IF Oper = '-COM'
	THEN
		START TRANSACTION;
			UPDATE news_reports 
SET 
    `COMMENTS` = COMMENTS - 1   
WHERE
    REPORT_ID = id_ReportT;
            
            
         IF @@error_count = 0
            THEN
				COMMIT;
			ELSE
				SELECT CONCAT('Error al enviar la decrementar los comentarios en la noticia con No. ', CAST(id_ReportT AS CHAR))
                 FROM news_reports WHERE REPORT_ID = id_ReportT;
				ROLLBACK;
			END IF;
            
		LEAVE `sp_News_Reports`;   
    END IF;
    
       /*#######################################
				AUMENTAR COMENTARIOS
    ########################################*/
	IF Oper = '+COM'
	THEN
		START TRANSACTION;
			UPDATE news_reports 
SET 
    `COMMENTS` = COMMENTS + 1   
WHERE
    REPORT_ID = id_ReportT;
            
            
         IF @@error_count = 0
            THEN
				COMMIT;
			ELSE
				SELECT CONCAT('Error al enviar la aumentar los comentarios en la noticia con No. ', CAST(id_ReportT AS CHAR))
                 FROM news_reports WHERE REPORT_ID = id_ReportT;
				ROLLBACK;
			END IF;
            
		LEAVE `sp_News_Reports`;   
    END IF;
    
END//
DELIMITER ;