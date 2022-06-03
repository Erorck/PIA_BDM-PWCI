
<?php

class Reactions Extends Dbh{

    protected function insertReaction($updated_by, $reportId, $liked){

        $action = "I";
        $query = "";
        $query2 = "";
        $executeArray = array($updated_by, $reportId);

        $stmt = $this->connect()->prepare('SELECT `USER`, `LIKED`, `CREATION_DATE`, `REPORT_ID`
        FROM REACTIONS
        WHERE  `USER` = ? AND REPORT_ID = ?;');

        if(!$stmt->execute(array($updated_by, $reportId))){
            $stmt=null;
            header("location:../Pagina_noticia.php?error=stmtfailed");
            exit();
        }



        if ($stmt->rowCount() > 0) {
            $reaction = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($reaction[0]['LIKED'] == 1){
                $action = "D";
                $query = 'UPDATE REACTIONS
                SET LIKED = 0
                WHERE  `USER` = ? AND REPORT_ID = ?;';
            }
            else{
                $action = "L";
                $query = 'UPDATE REACTIONS
                SET LIKED = 1
                WHERE  `USER` = ? AND REPORT_ID = ?;';
                
            }
        }else{
            $query = 'INSERT INTO REACTIONS(`REPORT_ID`, `USER`, `CREATED_BY`, `LIKED`) 
            VALUES (?, ?, ?, ?);';
            $executeArray = array($reportId, $updated_by, $updated_by, $liked);
        }


        $stmt2 = $this->connect()->prepare($query);


        if(!$stmt2->execute($executeArray)){
            $stmt2=null;
            header("location:../Pagina_noticia.php?error=stmtfailed");
            exit();
        }

        if($action == 'I' && $action == 'L'){
            $query2 = 'UPDATE NEWS_REPORTS
            SET LIKES = LIKES + 1
            WHERE REPORT_ID = ?;';
        }else{
            $query2 = 'UPDATE NEWS_REPORTS
            SET LIKES = LIKES - 1
            WHERE REPORT_ID = ?;';
        }

        $stmt3 = $this->connect()->prepare($query2);


        if(!$stmt3->execute(array($reportId))){
            $stmt3=null;
            header("location:../Pagina_noticia.php?error=stmtfailed");
            exit();
        }

        echo $action;
        $stmt3 = null;
        $stmt2 = null;
        $stmt = null;
    }

    protected function reactionValue($updated_by, $reportId){

        $reaction = null;

        $stmt = $this->connect()->prepare('SELECT `USER`, `LIKED`, `CREATION_DATE`, `REPORT_ID`
        FROM REACTIONS
       WHERE  `USER` = ? AND REPORT_ID = ?;');

        if(!$stmt->execute(array($updated_by, $reportId))){
            $stmt=null;
            header("location:../Pagina_noticia.php?error=stmtfailed");
            exit();
        }
        if ($stmt->rowCount() > 0) {
            $reaction = $stmt->fetchAll(PDO::FETCH_ASSOC);;
        }else{
            return 0;
        }



        $stmt = null;
        return $reaction;
    }

    protected function minusLike($updated_by, $reportId){
        
        $stmt = $this->connect()->prepare('UPDATE REACTIONS
        SET LIKED = 0
        WHERE  `USER` = ? AND REPORT_ID = ?;');

        if(!$stmt->execute(array($updated_by, $reportId))){
            $stmt=null;
            header("location:../Pagina_noticia.php?error=stmtfailed");
            exit();
        }
        $stmt=null;
    }

}

?>