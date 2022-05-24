-- STORED PROCEDURE SECCIÓN

-- CALL sp_Search_News('SA', NULL, NULL, NULL, NULL, NULL);
-- CALL sp_Search_News('E', 1, NULL, NULL, NULL, NULL);

-- DELETE FROM categories WHERE CATEGORY_ID = 2;

USE GOOD_OLD_TIMES_DB;

DELIMITER //
DROP PROCEDURE IF EXISTS sp_Search_News//
CREATE PROCEDURE sp_Search_News (	
	IN Oper char(4),
    IN textoT VARCHAR(180),
    IN fechaMinT DATETIME,
    IN fechaMaxT DATETIME,
	IN categoryT INT,
    IN tagT varchar(100)
)
CONTAINS SQL
`sp_Search_News`:
BEGIN
 
 /*#######################################
				CONSULTAR TODOS
    ########################################*/
   
		SELECT `REPORT_NUMBER`, `AUTOR_SIGN`,  
        `EVENT_STREET`, `EVENT_NEIGHBOURHOOD`, `EVENT_CITY`, `EVENT_COUNTRY`, 
        `HEADER`, `REPORT_DESCRIPTION`, `CONTENT`, `LIKES`, `THUMBNAIL`, `EVENT_DATE`, `PUBLICATION_DATE`,
        `CREATION_DATE`, `CREATED_BY_ID`, `CREATED_BY_NAME`,
		`LAST_UPDATE_DATE`, `UPDATED_BY_ID`, `UPDATED_BY_NAME`, `TAG`, `CATEGORY`, `CATEGORY_NAME`,`REPORT_STATUS`
        FROM v_News_Search
		WHERE if(textoT IS NULL OR textoT = '', 1, HEADER LIKE concat('%', textoT,'%'))
        OR if(textoT IS NULL OR textoT = '', 1, REPORT_DESCRIPTION LIKE concat('%', textoT,'%'))
        OR if(textoT IS NULL OR textoT = '', 1, EVENT_CITY LIKE concat('%', textoT,'%'))
        OR if(textoT IS NULL OR textoT = '', 1, EVENT_COUNTRY LIKE concat('%', textoT,'%'))
        OR if(textoT IS NULL OR tagT = 0, 1, TAG LIKE concat('%', textoT,'%'))
        OR if(textoT IS NULL OR textoT = 0, 1, CATEGORY_NAME LIKE concat('%', textoT,'%'))
        AND if(categoryT IS NULL OR categoryT = 0, 1, CATEGORY = categoryT)
		AND if (fechaMinT IS NULL, 1, `EVENT_DATE` >=  fechaMinT)
		AND if (fechaMaxT IS NULL, 1, `EVENT_DATE` <= fechaMaxT)
		AND `REPORT_STATUS` = 'P'
		GROUP BY REPORT_NUMBER
        ORDER BY EVENT_DATE, HEADER ASC;
        LEAVE `sp_Search_News`; 
    
    
END//
DELIMITER ;