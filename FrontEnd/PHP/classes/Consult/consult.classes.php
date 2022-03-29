<?php
include "../classes/dbh.classes.php";

class Consults extends Dbh{


    protected function getJournalists(){
        $stmt = $this->connect()->prepare('CALL sp_User("SJS", NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);');
        if(!$stmt->execute()){
            $stmt = null;
            header("location: ../Pages/Perfil_Usuario.php?error=stmtFailed");
            exit();
        }
        if($stmt->rowCount()>0){
            session_start();
            $journalists = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $_SESSION["journalists"] = $journalists;
        }else{
            return 0;
        }
       
        return $journalists;
    }
    
    protected function getRUsers(){
        $stmt = $this->connect()->prepare('CALL sp_User("SURS", NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);');
        if(!$stmt->execute()){
            $stmt = null;
            header("location: ../Pages/Perfil_Usuario.php?error=stmtFailed");
            exit();
        }
        if($stmt->rowCount()>0){
            session_start();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $_SESSION["r_users"] = $users;
        }else{
            return 0;
        }
       
        return $users;
    }


}