<?php
include"../classes/dbh.classes.php";

class Image Extends Dbh{

    protected function upload($image){
        $stmt = $this->connect()->prepare("INSERT INTO BD_IMAGES(IMAGE_BLOB, CREATION_DATE) VALUES(?,sysdate());");
        if(!$stmt->execute(array($image))){
            $stmt=null;
            header("location:../load.php?error=stmtfailed");
            exit();
        }
        $stmt=null;
    }

    protected function retrieve($imageId){
        $stmt = $this->connect()->prepare("SELECT IMAGE_BLOB FROM BD_IMAGES WHERE IMAGE_ID = ?;");
        if(!$stmt->execute(array($imageId))){
            $stmt=null;
            header("location:../load.php?error=stmtfailed");
            exit();
        }

      
        if($stmt->rowCount() == 0){
            $stmt = null;
            header("location:../load.php?error=imageNotFound");
            exit();
        }

        $imageRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
        session_start();
        $_SESSION['IMAGE_RETRIEVE'] = $imageRow[0]["IMAGE_BLOB"];
        $stmt = null;
    }
}

?>