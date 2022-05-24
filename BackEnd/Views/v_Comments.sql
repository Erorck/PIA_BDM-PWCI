USE GOOD_OLD_TIMES_DB;

DROP VIEW IF EXISTS v_Comments_Detailed;
CREATE VIEW v_Comments_Detailed 
AS SELECT `comments`.`COMMENT_ID`,
			`comments`.`COMMENT_TEXT`,
			`comments`.`CREATION_DATE`,
			`comments`.`CREATED_BY`,
			`comments`.`LAST_UPDATE_DATE`,
			`comments`.`LAST_UPDATED_BY`,
			`comments`.`COMMENT_STATUS`,
			`comments`.`REPORT_ID`,
            `users`.`USER_ALIAS`,
            `users`.`PROFILE_PICTURE`,
			`users`.`USER_TYPE`
			FROM `good_old_times_db`.`comments`
			INNER JOIN `users` ON `users`.`ID_USER` = `comments`.`CREATED_BY`;
                