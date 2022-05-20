<?php

class News_Tags Extends Dbh{

    protected function insertNews_Tags($tag, $reportId, $updated_by){
        $stmt = $this->connect()->prepare('CALL sp_News_Tags("I", ?, ?, ?);');
        if(!$stmt->execute(array($tag, $reportId, $updated_by))){
            $stmt=null;
            header("location:../Crear_noticia.php?error=stmtfailed");
            exit();
        }
        $stmt=null;
    }

    protected function deleteNewsTags($tag, $reportId){
        $stmt = $this->connect()->prepare('CALL sp_News_Tags("E", ?, ?, NULL);');
        if(!$stmt->execute(array($tag, $reportId))){
            $stmt=null;
            header("location:../Crear_noticia.php?error=stmtfailed");
            exit();
        }
        $stmt=null;
    }

}

?>