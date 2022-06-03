<?php

class Video Extends Dbh{

    protected function insertVideo($video, $reportId){

        $stmt = $this->connect()->prepare('INSERT INTO VIDEOS(`DESCRIPTION`, `CONTENT`, `ROUTE`, `REPORT_ID`) 
        VALUES (\'Un video\', ?, \'algún lugar\', ?);');

        if(!$stmt->execute(array($video, $reportId))){
            $stmt=null;
            header("location:../Crear_noticia.php?error=stmtfailed");
            exit();
        }
        $stmt=null;
    }

    protected function deleteVideo($video_id, $reportId){

        $stmt = $this->connect()->prepare('DELETE FROM VIDEOS 
        WHERE ID_VIDEO = ? AND REPORT_ID = ?;');

        if(!$stmt->execute(array($video_id, $reportId))){
            $stmt=null;
            header("location:../Crear_noticia.php?error=stmtfailed");
            exit();
        }
        $stmt=null;
    }

}

?>