<?php

include "../classes/dbh.classes.php";

class News_Reports extends Dbh{

    protected function Insert($signT, $streetT, $neighbourhoodT, $cityT, $countryT, $event_date, $headerT, $descriptionT, $contentT, $thumbnailT, $updated_by){


        $stmt = $this->connect()->prepare('INSERT INTO NEWS_REPORTS(`SIGN`, `LOCATION_STREET`, `LOCATION_NEIGHB`, `LOCATION_CITY`, `LOCATION_COUNTRY`, `REPORT_HEADER`, `REPORT_DESCRIPTION`, `REPORT_CONTENT`, `THUMBNAIL`, EVENT_DATE, `CREATED_BY`, `LAST_UPDATED_BY`, REPORT_STATUS) 
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, \'RR\');');
                
        $new_insert = 0;

        if(!$stmt->execute(array( $signT, $streetT, $neighbourhoodT, $cityT, $countryT, $headerT, $descriptionT, $contentT, $thumbnailT, $event_date, $updated_by, $updated_by))){
            $stmt = null;
            header("location: ../Pages/Crear_noticia.php?error=stmtFailed");
            exit();
        }else{

            $stmt2 = $this->connect()->prepare('SELECT NR.`REPORT_ID` AS REPORT_NUMBER, NR.`SIGN` AS AUTOR_SIGN, NR.`LOCATION_STREET` AS EVENT_STREET, NR.`LOCATION_NEIGHB` AS EVENT_NEIGHBOURHOOD, NR.`LOCATION_CITY` AS EVENT_CITY, NR.`LOCATION_COUNTRY` AS EVENT_COUNTRY,
                NR.`REPORT_HEADER` AS HEADER, NR.`REPORT_DESCRIPTION`, NR.`REPORT_CONTENT` AS CONTENT, NR.`LIKES`, NR.`THUMBNAIL`,
                NR.EVENT_DATE, NR.`PUBLICATION_DATE`, NR.`CREATION_DATE`, NR.`CREATED_BY` AS CREATED_BY_ID, UCR.`FULL_NAME` AS CREATED_BY_NAME, 
                NR.`LAST_UPDATE_DATE`, NR.`LAST_UPDATED_BY` AS UPDATED_BY_ID, UUP.`FULL_NAME` AS UPDATED_BY_NAME,
                `REPORT_STATUS`
                FROM NEWS_REPORTS NR
                JOIN USERS UCR
                ON UCR.ID_USER = NR.CREATED_BY
                JOIN USERS UUP
                ON UUP.ID_USER = NR.LAST_UPDATED_BY
            ORDER BY REPORT_NUMBER DESC LIMIT 0, 1;');

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
        $stmt = $this->connect()->prepare('UPDATE NEWS_REPORTS 
        SET 
            `SIGN` = IFNULL(?, `SIGN`),
            `LOCATION_STREET` = IFNULL(?, `LOCATION_STREET`),
            `LOCATION_NEIGHB` = IFNULL(?, `LOCATION_NEIGHB`),
            `LOCATION_CITY` = IFNULL(?, `LOCATION_CITY`),
            `LOCATION_COUNTRY` = IFNULL(?, `LOCATION_COUNTRY`),
            `REPORT_HEADER` = IFNULL(?, `REPORT_HEADER`),
            `REPORT_DESCRIPTION` = IFNULL(?, `REPORT_DESCRIPTION`),
            `REPORT_CONTENT` = IFNULL(?, `REPORT_CONTENT`),
            `THUMBNAIL` = IFNULL(?, `THUMBNAIL`),
            `EVENT_DATE` = IFNULL(?, `EVENT_DATE`), 
            `LAST_UPDATED_BY` = IFNULL(?, `LAST_UPDATED_BY`),
            `LAST_UPDATE_DATE` = NOW()
        WHERE
            REPORT_ID = ?;');

        if(!$stmt->execute(array($signT, $streetT, $neighbourhoodT, $cityT, $countryT, $headerT, $descriptionT, $contentT, $thumbnailT, $event_date, $updated_by, $id_ReportT))){
            $stmt = null;
            header("location: ../Pages/Crear_noticia.php?error=stmtFailed");
            exit();
        }

        $stmt = null;

    }


    protected function modStatus($action, $id_ReportT, $updated_by){

        $status = '';

        if($action == 'PUB')
            $status = 'P';
        if($action == 'DEL')
            $status = 'E';
        if($action == 'STR')
            $status = 'RR';
        if($action == 'STE')
            $status = 'RA';

        //Editamos el usuario
        $stmt = $this->connect()->prepare('UPDATE NEWS_REPORTS 
        SET 
            `LAST_UPDATE_DATE` = NOW(),
            `LAST_UPDATED_BY` = IFNULL(?, `LAST_UPDATED_BY`),
            `REPORT_STATUS` = \'?\'
        WHERE
            REPORT_ID = ?;');    

        if(!$stmt->execute(array($updated_by, $status, $id_ReportT))){
            $stmt = null;
            header("location: ../Pages/Inicio.php?error=stmtFailed");
            exit();
        }

        $stmt = null;

    }

    protected function modLikes($action, $id_ReportT){

        $oper = "";

        if($action =='-LIK')
            $oper = "-";

        if($action =='+LIK')
            $oper = "+";

        $stmt = $this->connect()->prepare('UPDATE NEWS_REPORTS 
                                            SET 
                                                `LIKES` = LIKES ? 1   
                                            WHERE
                                                REPORT_ID = ?;');

        if(!$stmt->execute(array($oper, $id_ReportT))){
            $stmt = null;
            header("location: ../Pages/Perfil_Reportero.php?error=stmtFailed");
            exit();
        }

        return false;
    }

}


?>