<?php

class Image Extends Dbh{

    protected function insertImage($image, $reportId){
        
        $stmt = $this->connect()->prepare('INSERT INTO IMAGES(`DESCRIPTION`, `CONTENT`, `ROUTE`, `REPORT_ID`) 
        VALUES (\'Un video\', ?, \'Algun lugar\', ?);');

        if(!$stmt->execute(array($image, $reportId))){
            $stmt=null;
            header("location:../Crear_noticia.php?error=stmtfailed");
            exit();
        }
        $stmt=null;
    }

    protected function deleteImage($image_id, $reportId){

        $stmt = $this->connect()->prepare('DELETE FROM IMAGES 
        WHERE ID_IMAGE = ? AND REPORT_ID = ?;');

        if(!$stmt->execute(array($image_id, $reportId))){
            $stmt=null;
            header("location:../Crear_noticia.php?error=stmtfailed");
            exit();
        }
        $stmt=null;
    }

    protected function updateProfilePic($image, $user_Id, $editor_Id){
        
        $stmt = $this->connect()->prepare('UPDATE USERS 
        SET             
            `LAST_UPDATE_DATE` = NOW(),
            `LAST_UPDATED_BY` = IFNULL(?, `LAST_UPDATED_BY`),
            `PROFILE_PICTURE` = IFNULL(?, `PROFILE_PICTURE`)
        WHERE
            id_User = ?;');
        

        if(!$stmt->execute(array($editor_Id, $image, $user_Id))){
            $stmt=null;
            header("location:../load.php?error=stmtfailed");
            exit();
        }
        $stmt=null;
    }

    protected function retrieveFromUser($user_Id){
        $stmt = $this->connect()->prepare('SELECT `ID_USER`, `FULL_NAME`, `USER_ALIAS`,  `CREDENTIAL`, `EMAIL`, `PHONE_NUMBER`, `BIRTHDAY`, `PROFILE_PICTURE`, `BANNER_PICTURE`, `USER_TYPE`, `CREATED_BY`, `LAST_UPDATED_BY` FROM USERS
        WHERE `ID_USER` = ?;');

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