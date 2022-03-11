<?php

include "../classes/dbh.classes.php";

class Register extends Dbh{

    protected function register($name, $email, $password, $user_type){
        $stmt = $this->connect()->prepare('CALL sp_User("I", NULL, ?, ?, ?, ?, NULL, NULL, NULL, NULL, ?, 0);');
        $hashPwd = password_hash($password, PASSWORD_DEFAULT);

       

        if(!$stmt->execute(array($name, $hashPwd, $name, $email, $user_type))){
            $stmt = null;
            header("location: ../Pages/Inicio.php?error=stmtFailed");
            exit();
        }

        session_start();
        $_SESSION["user_name"] = $name;

        $stmt = null;
    }

    protected function checkUser($email){
        $stmt = $this->connect()->prepare('CALL sp_User("SE", NULL, NULL, NULL, NULL, ?, NULL, NULL, NULL, NULL, NULL, NULL);');
        if(!$stmt->execute(array($email))){
            $stmt = null;
            header("location: ../Pages/Inicio.php?error=stmtFailed");
            exit();
        }
        $check = false;
        if($stmt->rowCount()>0){
            $check = true;
        }else{
            $check = false;
        }
        echo "$check";
        return $check;
    }
}

?>