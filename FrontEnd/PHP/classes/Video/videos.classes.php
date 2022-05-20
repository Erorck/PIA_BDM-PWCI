<?php

class Video Extends Dbh{

    protected function insertVideo($video, $reportId){
        $stmt = $this->connect()->prepare('CALL sp_Videos("I", NULL, ?, ?);');
        if(!$stmt->execute(array($video, $reportId))){
            $stmt=null;
            header("location:../Crear_noticia.php?error=stmtfailed");
            exit();
        }
        $stmt=null;
    }

    protected function deleteVideo($video_id, $reportId){
        $stmt = $this->connect()->prepare('CALL sp_Videos("E", ?, NULL, ?);');
        if(!$stmt->execute(array($video_id, $reportId))){
            $stmt=null;
            header("location:../Crear_noticia.php?error=stmtfailed");
            exit();
        }
        $stmt=null;
    }

    protected function updateProfilePic($video, $user_Id, $editor_Id){
        
        $stmt = $this->connect()->prepare('CALL sp_User("U", ?, NULL, NULL, NULL, NULL, NULL, NULL, ?, NULL, NULL, ?);');
        

        if(!$stmt->execute(array($user_Id, $video, $editor_Id))){
            $stmt=null;
            header("location:../load.php?error=stmtfailed");
            exit();
        }
        $stmt=null;
    }

}

?>