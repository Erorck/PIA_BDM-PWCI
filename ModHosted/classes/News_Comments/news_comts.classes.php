<?php 

class News_Comments extends Dbh {


    protected  function getCommentsByReport($reportId){

        $stmt = $this->connect()->prepare('SELECT `COMMENTS`.`COMMENT_ID`,
            `COMMENTS`.`COMMENT_TEXT`,
            `COMMENTS`.`CREATION_DATE`,
            `COMMENTS`.`CREATED_BY`,
            `COMMENTS`.`LAST_UPDATE_DATE`,
            `COMMENTS`.`LAST_UPDATED_BY`,
            `COMMENTS`.`COMMENT_STATUS`,
            `COMMENTS`.`REPORT_ID`,
            `USERS`.`USER_ALIAS`,
            `USERS`.`PROFILE_PICTURE`,
            `USERS`.`USER_TYPE`
            FROM `COMMENTS`
            INNER JOIN `USERS` ON `USERS`.`ID_USER` = `COMMENTS`.`CREATED_BY`         
            WHERE `REPORT_ID`= ? AND `USER_TYPE` IN (\'UR\', \'R\')               
            AND `COMMENT_STATUS` = \'P\'
            ORDER BY CREATION_DATE DESC;');

        if (!$stmt->execute(array($reportId))) {
            $stmt = null;
            header("location: ../Pages/Crear_noticia.php?error=stmtFailed");
            exit();
        }
        if ($stmt->rowCount() > 0) {
            $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);            
            
        } else {
            return array();
        }

        $stmt = null;
        return $comments;
    }

    protected function getEditorComment($reportId){
        $stmt = $this->connect()->prepare('SELECT `COMMENTS`.`COMMENT_ID`,
            `COMMENTS`.`COMMENT_TEXT`,
            `COMMENTS`.`CREATION_DATE`,
            `COMMENTS`.`CREATED_BY`,
            `COMMENTS`.`LAST_UPDATE_DATE`,
            `COMMENTS`.`LAST_UPDATED_BY`,
            `COMMENTS`.`COMMENT_STATUS`,
            `COMMENTS`.`REPORT_ID`,
            `USERS`.`USER_ALIAS`,
            `USERS`.`PROFILE_PICTURE`,
            `USERS`.`USER_TYPE`
            FROM `COMMENTS`
            INNER JOIN `USERS` ON `USERS`.`ID_USER` = `COMMENTS`.`CREATED_BY`        
             WHERE `REPORT_ID`= ? AND `USER_TYPE`=  \'E\'
            AND `COMMENT_STATUS` = \'P\'
            ORDER BY CREATION_DATE DESC;');

        $comment = 0;

        if ($reportId == 0) {
            session_start();
            if (isset($_SESSION['c_report'])) {
                $report = $_SESSION['c_report'];
                $reportId = $report[0]['REPORT_NUMBER'];
            }
        }

        if (!$stmt->execute(array($reportId))) {
            $stmt = null;
            header("location: ../Pages/Revision_noticia.php?error=stmtFailed");
            exit();
        }
        if ($stmt->rowCount() > 0) {
            $comment = $stmt->fetchAll(PDO::FETCH_ASSOC);            
            
        } else {
            return 0;
        }

        $stmt = null;
        return $comment;
    }

    protected function insertComment($commentText, $reportId, $createdBy) {
        
        $stmt = $this->connect()->prepare('INSERT INTO COMMENTS(`COMMENT_TEXT`,`CREATED_BY`, `LAST_UPDATED_BY`, `REPORT_ID`)
        VALUES (?, ?, ?, ?);');

        if(!$stmt->execute(array($commentText, $createdBy, $createdBy, $reportId))){
            $stmt = null;
            header("location: ../Pages/Pagina_noticia.php?error=stmtFailed");
            exit();
        }

        $stmt2 = $this->connect()->prepare('SELECT USER_STATUS INTO @usuarioTemp FROM `USERS`
        WHERE ID_USER = ?;
        
            IF @usuarioTemp != \'E\' THEN	
                     UPDATE NEWS_REPORTS
                     SET COMMENTS = COMMENTS + 1
                     WHERE REPORT_ID = ?;
            END IF;');


        if(!$stmt2->execute(array($createdBy, $reportId))){
            $stmt2=null;
            header("location:../Pagina_noticia.php?error=stmtfailed");
            exit();
        }


        $stmt = null;
        $stmt2 = null;

    }

    protected function deleteComment($commentId, $createdBy) {
        
        $stmt = $this->connect()->prepare('UPDATE COMMENTS 
        SET 
            `LAST_UPDATE_DATE` = NOW(),
            `LAST_UPDATED_BY` = IFNULL(?, `LAST_UPDATED_BY`),
            `COMMENT_STATUS` = \'E\'
        WHERE
            COMMENT_ID = ?;');

        if(!$stmt->execute(array($createdBy, $commentId))){
            $stmt = null;
            header("location: ../Pages/Inicio.php?error=stmtFailed");
            exit();
        }

        $stmt2 = $this->connect()->prepare('SELECT REPORT_ID INTO @reporteTemp FROM `COMMENTS`
        WHERE COMMENT_ID = ?;
        
        UPDATE NEWS_REPORTS
        SET COMMENTS = COMMENTS - 1
        WHERE REPORT_ID = @reporteTemp ;');


        if(!$stmt2->execute(array($commentId))){
            $stmt2=null;
            header("location:../Pagina_noticia.php?error=stmtfailed");
            exit();
        }

        $stmt = null;
        $stmt2 = null;

    }
}