<?php

class Image Extends Dbh{

    protected function insertImage($image, $reportId){
        $stmt = $this->connect()->prepare('CALL sp_Images("I", NULL, ?, ?);');
        if(!$stmt->execute(array($image, $reportId))){
            $stmt=null;
            header("location:../Crear_noticia.php?error=stmtfailed");
            exit();
        }
        $stmt=null;
    }

    protected function deleteImage($image_id, $reportId){
        $stmt = $this->connect()->prepare('CALL sp_Images("E", ?, NULL, ?);');
        if(!$stmt->execute(array($image_id, $reportId))){
            $stmt=null;
            header("location:../Crear_noticia.php?error=stmtfailed");
            exit();
        }
        $stmt=null;
    }

    protected function updateProfilePic($image, $user_Id, $editor_Id){
        
        $stmt = $this->connect()->prepare('CALL sp_User("U", ?, NULL, NULL, NULL, NULL, NULL, NULL, ?, NULL, NULL, ?);');
        

        if(!$stmt->execute(array($user_Id, $image, $editor_Id))){
            $stmt=null;
            header("location:../load.php?error=stmtfailed");
            exit();
        }
        $stmt=null;
    }

    protected function retrieveFromUser($user_Id){
        $stmt = $this->connect()->prepare('CALL sp_User("SOI", ?, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);');

        if(!$stmt->execute(array($user_Id))){
            $stmt = null;
            header("location: ../Pages/Login.php?error=stmtFailed");
            exit();
        }

        if($stmt->rowCount()==0){
            $check = true;
            $stmt = null;
            header("location: ../Pages/Login.php?error=userNotFound");
            session_start();
            $_SESSION["error"] = "userNotFound";
            exit();
        }

        $imageRow = $stmt->fetchAll(PDO::FETCH_ASSOC);

        session_start();
        $_SESSION['user']['PROFILE_PICTURE'] = $imageRow[0]["PROFILE_PICTURE"];
        $stmt = null;
    }
}

?>