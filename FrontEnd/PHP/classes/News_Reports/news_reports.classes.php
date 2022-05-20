<?php

include "../classes/dbh.classes.php";

class News_Reports extends Dbh{

    protected function Insert($signT, $streetT, $neighbourhoodT, $cityT, $countryT, $event_date, $headerT, $descriptionT, $contentT, $thumbnailT, $updated_by){


        $stmt = $this->connect()->prepare('CALL sp_News_Reports("I", NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);');
        $new_insert = 0;

        if(!$stmt->execute(array( $signT, $streetT, $neighbourhoodT, $cityT, $countryT, $event_date, $headerT, $descriptionT, $contentT, $thumbnailT, $updated_by))){
            $stmt = null;
            header("location: ../Pages/Crear_noticia.php?error=stmtFailed");
            exit();
        }else{
            $stmt2 = $this->connect()->prepare('CALL sp_News_Reports("SNR", NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);');
            if(!$stmt2->execute()){
                header("location: ../Pages/Crear_noticia.php?error=stmtFailed");
            }else{
                if($stmt2->rowCount()>0){
                    $newsRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                    $new_insert = $newsRow[0]['REPORT_NUMBER'];
                }   
            }  
            $stmt2 = null;
        }

        $stmt = null;
        return $new_insert;
    }

    protected function Update($id_ReportT, $signT, $streetT, $neighbourhoodT, $cityT, $countryT, $event_date, $headerT, $descriptionT, $contentT, $thumbnailT, $updated_by){
        //Editamos el usuario
        $stmt = $this->connect()->prepare('CALL sp_News_Reports("U", ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);');

        if(!$stmt->execute(array($id_ReportT, $signT, $streetT, $neighbourhoodT, $cityT, $countryT, $event_date, $headerT, $descriptionT, $contentT, $thumbnailT, $updated_by))){
            $stmt = null;
            header("location: ../Pages/Crear_noticia.php?error=stmtFailed");
            exit();
        }

        $stmt = null;

    }


    protected function modStatus($action, $id_ReportT, $updated_by){
        //Editamos el usuario
        $stmt = $this->connect()->prepare('CALL sp_News_Reports( ?, ?, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, ?);');    

        if(!$stmt->execute(array($action, $id_ReportT, $updated_by))){
            $stmt = null;
            header("location: ../Pages/Perfil_Reportero.php?error=stmtFailed");
            exit();
        }

        $stmt = null;

    }

    protected function modLikes($action, $id_ReportT){
        $stmt = $this->connect()->prepare('CALL sp_News_Reports(?, ?, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);');

        if(!$stmt->execute(array($action, $id_ReportT))){
            $stmt = null;
            header("location: ../Pages/Perfil_Reportero.php?error=stmtFailed");
            exit();
        }

        return false;
    }

}


?>