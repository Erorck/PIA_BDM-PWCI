
<?php

class Reactions Extends Dbh{

    protected function insertReaction($updated_by, $reportId, $liked){

        $action = "I";
        $query = "";

        $stmt = $this->connect()->prepare('CALL sp_Reactions("SO", ?, ?, 1);');
        if(!$stmt->execute(array($updated_by, $reportId))){
            $stmt=null;
            header("location:../Pagina_noticia.php?error=stmtfailed");
            exit();
        }



        if ($stmt->rowCount() > 0) {
            $reaction = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($reaction[0]['LIKED'] == 1){
                $action = "D";
                $query = 'CALL sp_Reactions("D", ?, ?, 0);';
            }
            else{
                $action = "L";
                $query = 'CALL sp_Reactions("L", ?, ?, 0);';
                
            }
        }else{
            $query = 'CALL sp_Reactions("I", ?, ?, 1);';
        }


        $stmt2 = $this->connect()->prepare($query);


        if(!$stmt2->execute(array($updated_by, $reportId))){
            $stmt2=null;
            header("location:../Pagina_noticia.php?error=stmtfailed");
            exit();
        }
        echo $action;
        $stmt2=null;
        $stmt = null;
    }


    protected function reactionValue($updated_by, $reportId){

        $reaction = null;

        $stmt = $this->connect()->prepare('CALL sp_Reactions("SO", ?, ?, 1);');
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
        $stmt = $this->connect()->prepare('CALL sp_Reactions("D", ?, ?, NULL);');
        if(!$stmt->execute(array($updated_by, $reportId))){
            $stmt=null;
            header("location:../Pagina_noticia.php?error=stmtfailed");
            exit();
        }
        $stmt=null;
    }

}

?>