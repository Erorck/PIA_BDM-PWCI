<?php

class News_Categories Extends Dbh{

    protected function insertNews_Ctgs($categoryId, $reportId, $updated_by){

        $stmt = $this->connect()->prepare('CALL sp_News_Categories("I", ?, ?, ?);');
        if(!$stmt->execute(array( $categoryId, $reportId, $updated_by))){
            $stmt=null;
            header("location:../Crear_noticia.php?error=stmtfailed");
            exit();
        }
        $stmt=null;
    }

    protected function deleteNews_Ctgs($categoryId, $reportId){
        $stmt = $this->connect()->prepare('CALL sp_News_Categories("E", ?, ?, NULL);');
        if(!$stmt->execute(array($categoryId, $reportId))){
            $stmt=null;
            header("location:../Crear_noticia.php?error=stmtfailed");
            exit();
        }
        $stmt=null;
    }

}

?>