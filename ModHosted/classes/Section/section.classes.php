<?php

include "../classes/dbh.classes.php";

class Section extends Dbh{

    protected function Insert($name, $color, $order, $updated_by){

        $stmt = $this->connect()->prepare('INSERT INTO CATEGORIES(`CATEGORY_NAME`, `COLOR`, `ORDER`, `CREATED_BY`, `LAST_UPDATED_BY`) 
        VALUES (?, ?, ?, ?, ?);');

        if(!$stmt->execute(array( $name, $color, $order, $updated_by, $updated_by))){
            $stmt = null;
            header("location: ../Pages/Perfil_Editor.php?error=stmtFailed");
            exit();
        }

        $stmt = null;

    }

    protected function Update($id, $name, $color, $order, $updated_by){
        
        //Editamos el usuario
        $stmt = $this->connect()->prepare('UPDATE CATEGORIES 
                                        SET 
                                            `CATEGORY_NAME` = IFNULL(?, `CATEGORY_NAME`),
                                            `COLOR` = IFNULL(?, `COLOR`),
                                            `ORDER` = IFNULL(?, `ORDER`),
                                            `LAST_UPDATE_DATE` = NOW(),
                                            `LAST_UPDATED_BY` = IFNULL(?, `LAST_UPDATED_BY`)    
                                        WHERE
                                            CATEGORY_ID = ?;');

        if(!$stmt->execute(array($name, $color, $order, $updated_by, $id))){
            $stmt = null;
            header("location: ../Pages/Perfil_Editor.php?error=stmtFailed");
            exit();
        }

        $stmt = null;

    }

    protected function UpdateName($id, $name, $updated_by){

        //Editamos el usuario
        $stmt = $this->connect()->prepare('UPDATE CATEGORIES 
                                            SET 
                                                `CATEGORY_NAME` = IFNULL(?, `CATEGORY_NAME`),                                               
                                                `LAST_UPDATE_DATE` = NOW(),
                                                `LAST_UPDATED_BY` = IFNULL(?, `LAST_UPDATED_BY`)    
                                            WHERE
                                                CATEGORY_ID = ?;');

        if(!$stmt->execute(array($name, $updated_by, $id))){
            $stmt = null;
            header("location: ../Pages/Perfil_Editor.php?error=stmtFailed");
            exit();
        }

        $stmt = null;

    }

    protected function modStatus($action, $id, $updated_by){

        $status = 'A';

        if($action = 'E')
            $status = 'E';
        if($action = 'A')
            $status = 'A';

        //Editamos el usuario
        $stmt = $this->connect()->prepare('UPDATE CATEGORIES 
                                        SET 
                                            `LAST_UPDATE_DATE` = NOW(),
                                            `LAST_UPDATED_BY` = IFNULL(?, `LAST_UPDATED_BY`),
                                            `SECTION_STATUS` = \'?\'
                                        WHERE
                                            `CATEGORY_ID` = ?;');    

        if(!$stmt->execute(array($updated_by, $status, $id))){
            $stmt = null;
            header("location: ../Pages/Perfil_Editor.php?error=stmtFailed");
            exit();
        }

        $stmt = null;

    }

    protected function checkUpdatedName($categoryId, $newName){
        $stmt = $this->connect()->prepare('SELECT `CATEGORY_ID` AS SECTION_ID, `CATEGORY_NAME` AS SECTION_NAME
        FROM CATEGORIES
        WHERE `SECTION_NAME` = ? AND `SECTION_ID` != ?;');

        if(!$stmt->execute(array($newName, $categoryId))){
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