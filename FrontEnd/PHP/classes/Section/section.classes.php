<?php

include "../classes/dbh.classes.php";

class Section extends Dbh{

    protected function Insert($name, $color, $order, $updated_by){

        $stmt = $this->connect()->prepare('CALL sp_Section("I", NULL, ?, ?, ?, ?);');

        if(!$stmt->execute(array( $name, $color, $order, $updated_by))){
            $stmt = null;
            header("location: ../Pages/Perfil_Editor.php?error=stmtFailed");
            exit();
        }

        $stmt = null;

    }

    protected function Update($id, $name, $color, $order, $updated_by){
        //Editamos el usuario
        $stmt = $this->connect()->prepare('CALL sp_Section("U", ?, ?, ?, ?, ?);');

        if(!$stmt->execute(array($id, $name, $color, $order, $updated_by))){
            $stmt = null;
            header("location: ../Pages/Perfil_Editor.php?error=stmtFailed");
            exit();
        }

        $stmt = null;

    }

    protected function UpdateName($id, $name, $updated_by){
        //Editamos el usuario
        $stmt = $this->connect()->prepare('CALL sp_Section("U", ?, ?, NULL, NULL, ?);');

        if(!$stmt->execute(array($id, $name, $updated_by))){
            $stmt = null;
            header("location: ../Pages/Perfil_Editor.php?error=stmtFailed");
            exit();
        }

        $stmt = null;

    }

    protected function modStatus($action, $id, $updated_by){
        //Editamos el usuario
        $stmt = $this->connect()->prepare('CALL sp_Section(?, ?, NULL, NULL, NULL, ?);');    

        if(!$stmt->execute(array($action, $id, $updated_by))){
            $stmt = null;
            header("location: ../Pages/Perfil_Editor.php?error=stmtFailed");
            exit();
        }

        $stmt = null;

    }

    protected function checkUpdatedName($categoryId, $newName){
        $stmt = $this->connect()->prepare('CALL sp_Section("SID", ?, ?, NULL, NULL, NULL);');

        if(!$stmt->execute(array($categoryId, $newName))){
            $stmt = null;
            header("location: ../Pages/Perfil_Editor.php?error=stmtFailed");
            exit();
        }

        if($stmt->rowCount()>0){
           return true;
        }

        return false;
    }

}


?>