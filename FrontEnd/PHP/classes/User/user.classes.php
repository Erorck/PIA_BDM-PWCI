<?php
include "../classes/dbh.classes.php";

class User extends Dbh{

    protected function Update($id, $nickname, $name, $password, $email, $phoneNumber, $pPic, $bPic, $user_type, $updated_by){
        //Editamos el usuario
        $stmt = $this->connect()->prepare('CALL sp_User("U", ?, ?, ?, ?, ?, ?, NULL, ?, ?, ?, ?);');
        $hashPwd = password_hash($password, PASSWORD_DEFAULT);

        if(!$stmt->execute(array($id, $nickname, $hashPwd, $name, $email, $phoneNumber, $pPic, $bPic, $user_type, $updated_by))){
            $stmt = null;
            header("location: ../Pages/Perfil_Usuario.php?error=stmtFailed");
            exit();
        }

        $stmt = null;

        //Consultamos al usuario recien editado
        $stmt2 = $this->connect()->prepare('CALL sp_User("SOI", ?, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);');

            if(!$stmt2->execute(array($id,))){
                $stmt2 = null;
                header("location: ../Pages/Perfil_Usuario.php?error=stmtFailed");
                exit();
            }

            if($stmt2->rowCount()==0){
                $stmt2 = null;
                header("location: ../Pages/Perfil_Usuario.php?error=userNotFound");
                session_start();
                $_SESSION["error"] = "userNotFound";
                exit();
            }

            $users = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        session_start();
        $_SESSION["user"] = $users[0];

    }

    protected function Delete($id, $updated_by){
        //Editamos el usuario
        $stmt = $this->connect()->prepare('CALL sp_User("E", ?, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, ?);');    

        if(!$stmt->execute(array($id, $updated_by))){
            $stmt = null;
            header("location: ../Pages/Perfil_Usuario.php?error=stmtFailed");
            exit();
        }

        $stmt = null;

        if(isset($_SESSION['user'])){
            session_start();    
            session_destroy();
        }
    }

    protected function checkUpdatedEmail($userId, $email){
        $stmt = $this->connect()->prepare('CALL sp_User("SUE", ?, NULL, NULL, NULL, ?, NULL, NULL, NULL, NULL, NULL, NULL);');
        if(!$stmt->execute(array($userId, $email))){
            $stmt = null;
            header("location: ../Pages/Perfil_Usuario.php?error=stmtFailed");
            exit();
        }
        $check = false;
        if($stmt->rowCount()>0){
            $check = true;
            session_start();
            $_SESSION["error"] = "userChecked";
        }else{
            $check = false;
        }
        //echo "$check";
        return $check;
    }

    protected function toRegisteredUser($id, $updated_by){
        //Editamos el usuario
        $stmt = $this->connect()->prepare('CALL sp_User("TRU", ?, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, ?);');
        

        if(!$stmt->execute(array($id, $updated_by))){
            $stmt = null;
            header("location: ../Pages/Perfil_Usuario.php?error=stmtFailed");
            exit();
        }

        $stmt = null;

    }

    protected function toJournalist($id, $updated_by){
        //Editamos el usuario
        $stmt = $this->connect()->prepare('CALL sp_User("TR", ?, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, ?);');
        

        if(!$stmt->execute(array($id, $updated_by))){
            $stmt = null;
            header("location: ../Pages/Perfil_Usuario.php?error=stmtFailed");
            exit();
        }

        $stmt = null;

    }
}
