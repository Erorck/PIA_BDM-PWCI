<?php
include "../classes/dbh.classes.php";

class User extends Dbh{

    protected function Update($id, $nickname, $name, $password, $email, $phoneNumber, $pPic, $bPic, $user_type, $updated_by){

        //Editamos el usuario
        $stmt = $this->connect()->prepare('UPDATE USERS 
        SET 
            `FULL_NAME` = IFNULL(?, `FULL_NAME`),
            `USER_ALIAS` = IFNULL(?, `USER_ALIAS`),
            `CREDENTIAL` = IFNULL(?, `CREDENTIAL`),
            `EMAIL` = IFNULL(?, `EMAIL`),
            `PHONE_NUMBER` = IFNULL(?, `PHONE_NUMBER`),
            `LAST_UPDATE_DATE` = NOW(),
            `LAST_UPDATED_BY` = IFNULL(?, `LAST_UPDATED_BY`),
            `PROFILE_PICTURE` = IFNULL(?, `PROFILE_PICTURE`),
            `BANNER_PICTURE` = IFNULL(?, `BANNER_PICTURE`),
            `USER_TYPE` = IFNULL(?, `USER_TYPE`)
        WHERE
            id_User = ?;');

        $hashPwd = password_hash($password, PASSWORD_DEFAULT);

        if(!$stmt->execute(array($name, $nickname, $hashPwd, $email, $phoneNumber, $updated_by, $pPic, $bPic, $user_type, $id))){
            $stmt = null;
            header("location: ../Pages/Perfil_Usuario.php?error=stmtFailed");
            exit();
        }

        $stmt = null;

        //Consultamos al usuario recien editado
        $stmt2 = $this->connect()->prepare('SELECT `ID_USER`, `FULL_NAME`, `USER_ALIAS`,  `CREDENTIAL`, `EMAIL`, `PHONE_NUMBER`, `BIRTHDAY`, `PROFILE_PICTURE`, `BANNER_PICTURE`, `USER_TYPE`, `CREATED_BY`, `LAST_UPDATED_BY` FROM USERS
        WHERE `ID_USER` = ?;');

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
        $stmt = $this->connect()->prepare('UPDATE USERS 
                                        SET 
                                            `LAST_UPDATE_DATE` = NOW(),
                                            `LAST_UPDATED_BY` = IFNULL(?, `LAST_UPDATED_BY`),
                                            `USER_STATUS` = \'E\'
                                        WHERE
                                            id_User = ?;');    

        if(!$stmt->execute(array($updated_by, $id))){
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

        $stmt = $this->connect()->prepare('SELECT  `ID_USER` FROM USERS WHERE `EMAIL` = ? AND `ID_USER` != ?;');

        if(!$stmt->execute(array($email, $userId))){
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
        $stmt = $this->connect()->prepare('UPDATE USERS 
                                        SET 
                                            `LAST_UPDATE_DATE` = NOW(),
                                            `LAST_UPDATED_BY` = IFNULL(?, `LAST_UPDATED_BY`),
                                            `USER_TYPE` = \'UR\'
                                        WHERE
                                            id_User = ?;');
        

        if(!$stmt->execute(array($updated_by, $id))){
            $stmt = null;
            header("location: ../Pages/Perfil_Usuario.php?error=stmtFailed");
            exit();
        }

        $stmt = null;

    }

    protected function toJournalist($id, $updated_by){
        //Editamos el usuario
        $stmt = $this->connect()->prepare('UPDATE USERS 
                                        SET 
                                            `LAST_UPDATE_DATE` = NOW(),
                                            `LAST_UPDATED_BY` = IFNULL(?, `LAST_UPDATED_BY`),
                                            `USER_TYPE` = \'R\'
                                        WHERE
                                            id_User = ?;');
        

        if(!$stmt->execute(array($updated_by, $id))){
            $stmt = null;
            header("location: ../Pages/Perfil_Usuario.php?error=stmtFailed");
            exit();
        }

        $stmt = null;

    }
}
