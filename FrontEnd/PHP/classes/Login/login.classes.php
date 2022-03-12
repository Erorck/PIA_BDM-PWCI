<?php
include "../classes/dbh.classes.php";

class Login extends Dbh{

    protected function sign_in($email, $password){
        $stmt = $this->connect()->prepare('CALL sp_User("SO", NULL, NULL, NULL, NULL, ?, NULL, NULL, NULL, NULL, NULL, NULL);');

        if(!$stmt->execute(array($email))){
            $stmt = null;
            header("location: ../Pages/Login.php?error=stmtFailed");
            exit();
        }

        $check = false;

        if($stmt->rowCount()==0){
            $check = true;
            $stmt = null;
            header("location: ../Pages/Login.php?error=userNotFound");
            session_start();
            $_SESSION["error"] = "userNotFound";
            exit();
        }
        
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $checkPwd = password_verify($password, $users[0]["CREDENTIAL"]);

        if($checkPwd == false){
            $stmt = null;
            header("location: ../Pages/Login.php?error=wrongPassword");
            session_start();
            $_SESSION["error"] = "wrongPassword";
            exit();
        }else if($checkPwd == true){
            session_start();
            $_SESSION["user_name"] = $users[0]["FULL_NAME"];
            $_SESSION["permission"] = $users[0]["USER_TYPE"];
        }

        $stmt = null;

    }

}

?>