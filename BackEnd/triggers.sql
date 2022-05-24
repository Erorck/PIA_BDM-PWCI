-- TRIGGERS

DROP TRIGGER IF EXISTS upd_reaction;
delimiter //
CREATE TRIGGER upd_reaction BEFORE INSERT ON reactions
       FOR EACH ROW 
       BEGIN    
			UPDATE news_reports
            SET LIKES = LIKES + 1
            WHERE CREATED_BY = NEW.`USER`;
               -- CALL sp_News_Reports('+LIK', NEW.REPORT_ID , NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, null, null, NULL);                         		            
       END;//
delimiter ;

DROP TRIGGER IF EXISTS upd_reaction;
delimiter //
CREATE TRIGGER upd_reaction BEFORE UPDATE ON reactions
       FOR EACH ROW 
       BEGIN
           IF NEW.LIKED = 0 THEN           
			UPDATE news_reports
            SET LIKES = LIKES - 1
            WHERE REPORT_ID = NEW.REPORT_ID;
               -- CALL sp_News_Reports('-LIK',NEW.REPORT_ID , NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, null, null, NULL);               
           ELSE
				UPDATE news_reports
				SET LIKES = LIKES + 1
				WHERE REPORT_ID = NEW.REPORT_ID;
				-- CALL sp_News_Reports('+LIK', NEW.REPORT_ID , NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, null, null, NULL);    			  
           END IF;
       END;//
delimiter ;

DROP TRIGGER IF EXISTS upd_comment;
delimiter //
CREATE TRIGGER upd_comment BEFORE UPDATE ON comments
       FOR EACH ROW 
       BEGIN
           IF NEW.`COMMENT_STATUS` = 'E' THEN           
			   UPDATE news_reports
				SET COMMENTS = COMMENTS - 1
				WHERE REPORT_ID = NEW.REPORT_ID;
               -- CALL sp_News_Reports('-COM', NEW.REPORT_ID , NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, null, null, NULL);                          		  
           END IF;
       END;//
delimiter ;

DROP TRIGGER IF EXISTS ins_comment;
delimiter //
CREATE TRIGGER ins_comment BEFORE INSERT ON comments
       FOR EACH ROW 
       BEGIN
       
       SELECT USER_STATUS INTO @usuarioTemp FROM `USER` U
       WHERE U.ID_USER = NEW.CREATED_BY;
       
           IF @usuarioTemp != 'E' THEN	
					UPDATE news_reports
					SET COMMENTS = COMMENTS + 1
					WHERE REPORT_ID = NEW.REPORT_ID;
					-- CALL sp_News_Reports('+COM', NEW.REPORT_ID , NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, null, null, NULL);     			
           END IF;
       END;//
delimiter ;