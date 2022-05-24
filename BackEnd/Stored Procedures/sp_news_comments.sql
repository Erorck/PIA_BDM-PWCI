USE GOOD_OLD_TIMES_DB;

CALL sp_News_Comments('SCFE', NULL, NULL, 16, NULL);

DELIMITER //
DROP PROCEDURE IF EXISTS sp_News_Comments//
CREATE PROCEDURE sp_News_Comments(	
	IN Oper char(4),
    IN comment_textT varchar(100),
    IN comment_idT INT,
	IN report_idT INT,    
    IN updated_byT INT
)
`sp_News_Comments`:
BEGIN

	/*#######################################
					INSERT
    ########################################*/
	IF Oper = 'I'
    THEN
		
			INSERT INTO comments(`COMMENT_TEXT`,`CREATED_BY`, `LAST_UPDATED_BY`, `REPORT_ID`)
            VALUES (comment_textT, updated_byT, updated_byT, report_idT);
	
		LEAVE `sp_News_Comments`;
	END IF;        
  
	IF Oper = 'S'
    THEN
				SELECT `COMMENT_ID`,
			`COMMENT_TEXT`,
			`CREATION_DATE`,
			`CREATED_BY`,
			`LAST_UPDATE_DATE`,
			`LAST_UPDATED_BY`,
			`COMMENT_STATUS`,
			`REPORT_ID`,
            `USER_ALIAS`,
            `PROFILE_PICTURE`
				FROM v_Comments_Detailed               
                WHERE `REPORT_ID`= report_idT
                AND `COMMENT_STATUS` = 'P';
    
    END IF;
    
    IF Oper = 'SPC'
    THEN
				SELECT `COMMENT_ID`,
			`COMMENT_TEXT`,
			`CREATION_DATE`,
			`CREATED_BY`,
			`LAST_UPDATE_DATE`,
			`LAST_UPDATED_BY`,
			`COMMENT_STATUS`,
			`REPORT_ID`,
            `USER_ALIAS`,
            `PROFILE_PICTURE`
				FROM v_Comments_Detailed               
                WHERE `REPORT_ID`= report_idT AND `USER_TYPE` IN ('UR', 'R')               
                AND `COMMENT_STATUS` = 'P'
				ORDER BY CREATION_DATE DESC;
    
    END IF;
    
    IF Oper = 'SCFE'
    THEN
			SELECT `COMMENT_ID`,
			`COMMENT_TEXT`,
			`CREATION_DATE`,
			`CREATED_BY`,
			`LAST_UPDATE_DATE`,
			`LAST_UPDATED_BY`,
			`COMMENT_STATUS`,
			`REPORT_ID`,
            `USER_ALIAS`,
            `PROFILE_PICTURE`
				FROM v_Comments_Detailed               
                 WHERE `REPORT_ID`=report_idT AND `USER_TYPE`='E'
                AND `COMMENT_STATUS` = 'P'
                ORDER BY CREATION_DATE DESC;
    
    END IF;
    
    ########################################*/
	IF Oper = 'DEL'
	THEN
		START TRANSACTION;
			UPDATE comments 
SET 
    `LAST_UPDATE_DATE` = NOW(),
    `LAST_UPDATED_BY` = IFNULL(updated_byT, `LAST_UPDATED_BY`),
    `COMMENT_STATUS` = 'E'
WHERE
    COMMENT_ID = comment_idT;
            
            
         IF @@error_count = 0
            THEN
				COMMIT;
			ELSE
				SELECT CONCAT('Error al eliminar el comentarios con No. ', CAST(comment_idT AS CHAR))
                 FROM comments WHERE COMMENT_ID = comment_idT;
				ROLLBACK;
			END IF;
            
		LEAVE `sp_News_Comments`;   
    END IF;
   
END//
DELIMITER ;