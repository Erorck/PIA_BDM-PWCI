<?php
include "../classes/dbh.classes.php";

class Login extends Dbh{

    protected function sign_in($email, $password){
        $stmt = $this->connect()->prepare('SELECT USER_PASSWORD FROM USERS WHERE EMAIL = ?;');

        if(!$stmt->execute(array($email))){
            $stmt = null;
            header("Location: ../index.php?error=stmtFailed");
            exit();
        }

        $check = false;

        if($stmt->rowCount()==0){
            $check = true;
            $stmt = null;
            header("Location: ../index.php?error=userNotFound");
            exit();
        }
        
        $pwdHashed = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $checkPwd = password_verify($password, $pwdHashed[0]["USER_PASSWORD"]);

        if($checkPwd == false){
            $stmt = null;
            header("Location: ../index.php?error=wrongPassword");
            exit();
        }else if($checkPwd == true){
            session_start();
            $_SESSION["user_email"] = $email;
        }

        $stmt = null;

    }

}

?>