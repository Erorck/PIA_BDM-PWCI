<?php

class News_Tags Extends Dbh{

    protected function insertNews_Tags($tag, $reportId, $updated_by){

        $stmt = $this->connect()->prepare('INSERT INTO NEWS_TAGS(`TAG`, `REPORT_ID`, `CREATED_BY`) 
        VALUES (?, ?, ?);');

        if(!$stmt->execute(array($tag, $reportId, $updated_by))){
            $stmt=null;
            header("location:../Crear_noticia.php?error=stmtfailed");
            exit();
        }
        $stmt=null;
    }

    protected function deleteNewsTags($tag, $reportId){

        $stmt = $this->connect()->prepare('DELETE FROM NEWS_TAGS
		WHERE TAG = ? AND REPORT_ID = ?;');

        if(!$stmt->execute(array($tag, $reportId))){
            $stmt=null;
            header("location:../Crear_noticia.php?error=stmtfailed");
            exit();
        }
        $stmt=null;
    }

}

?>