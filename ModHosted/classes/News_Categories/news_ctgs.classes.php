<?php

class News_Categories Extends Dbh{

    protected function insertNews_Ctgs($categoryId, $reportId, $updated_by){

        $stmt = $this->connect()->prepare('INSERT INTO NEWS_CATEGORIES(`REPORT_ID`, `CATEGORY`, `CREATED_BY`) 
        VALUES (?, ?, ?);');

        if(!$stmt->execute(array($reportId, $categoryId, $updated_by))){
            $stmt=null;
            header("location:../Crear_noticia.php?error=stmtfailed");
            exit();
        }
        $stmt=null;
    }

    protected function deleteNews_Ctgs($categoryId, $reportId){

        $stmt = $this->connect()->prepare('DELETE FROM NEWS_CATEGORIES 
        WHERE CATEGORY = ? AND REPORT_ID = ?;');

        if(!$stmt->execute(array($categoryId, $reportId))){
            $stmt=null;
            header("location:../Crear_noticia.php?error=stmtfailed");
            echo 'mal';
            exit();
        }
        $stmt=null;
    }

}

?>