-- STORED PROCEDURE REPORTE

USE GOOD_OLD_TIMES_DB;

DELIMITER //
DROP PROCEDURE IF EXISTS sp_Likes_Report//
CREATE PROCEDURE sp_Likes_Report (		
    IN Oper CHAR(1),
    IN fechaMinT DATETIME,
    IN fechaMaxT DATETIME,
	IN categoryT INT
)
CONTAINS SQL
`sp_Likes_Report`:
BEGIN
 
 /*#######################################
				CONSULTAR POR SECCIÓN
    ########################################*/
   
    IF Oper = 'N'
	THEN
		SELECT `CATEGORY_NAME`, `PUBLICATION_DATE`,`REPORT_HEADER`, 
        `LIKES`, `COMENTS`
        FROM categories CS
        JOIN news_reports NSR
        ON NSR.CREATED_BY = CS.CREATED_BY
		WHERE if(categoryT IS NULL OR categoryT = 0, 1, CATEGORY_NAME = categoryT)
		AND if (fechaMinT IS NULL, 1, `PUBLICATION_DATE` >=  fechaMinT)
		AND if (fechaMaxT IS NULL, 1, `PUBLICATION_DATE` <= fechaMaxT)
		AND `REPORT_STATUS` = 'P'
        ORDER BY LIKES DESC;
    END IF;
    
    IF Oper = 'S'
	THEN
		SELECT `CATEGORY_NAME`, `PUBLICATION_DATE`,   
        `LIKES`, `COMENTS`
        FROM categories CS
        JOIN news_reports NSR
        ON NSR.CREATED_BY = CS.CREATED_BY
		WHERE if(categoryT IS NULL OR categoryT = 0, 1, CATEGORY_NAME = categoryT)
		AND if (fechaMinT IS NULL, 1, `PUBLICATION_DATE` >=  fechaMinT)
		AND if (fechaMaxT IS NULL, 1, `PUBLICATION_DATE` <= fechaMaxT)
		AND `REPORT_STATUS` = 'P'
        GROUP BY MONTH(fechaMinT) AND YEAR(fechaMaxT)
        ORDER BY LIKES DESC;
        
	END IF;
END//
DELIMITER ;